<?php
/**
 * 玩家登录查询
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once '../../../protected/game_config/webgame/game_function.php';
global $lang;

// 错误信息
$errorMsg = $successMsg = array();


// 获取参数
$role 	= isset( $_REQUEST['role'] )? $_REQUEST['role'] : array();
list($page, $page_size) = getPagesParams();
// 过滤参数
if( !empty( $role['account_name'] ) )
{
	$account_name 	= SS( $role['account_name'] );
}
if( !empty( $role['role_name'] ) )
{
	$role_name 		= SS( $role['role_name'] );
}

if( !empty( $_REQUEST['starttime'] ) )
{
	$start_time 	= strtotime( SS( $_REQUEST['starttime'] ) );
	$smarty->assign( 'startDate', 	date('Y-m-d', $start_time ) );
}
else
{
	$smarty->assign( 'startDate', 	Datatime :: getTodayString() );
}

if( !empty( $_REQUEST['endtime'] ) )
{
	$end_time 		= strtotime( SS( $_REQUEST['endtime'] ) . ' 23:59:59' );
	$smarty->assign( 'endDate', 	date('Y-m-d', $end_time) );
}
else
{
	$smarty->assign( 'endDate', 	Datatime :: getTodayString() );
}



// 构造$andCondArray
$andCondArray = array();
$account_name_db = $role_name_db = '';
$notValid = false;

if ( !empty( $account_name ) )
{
	// 添加前缀，因为日志中获得的账户名，格式为 "[服ID]账户名"
	$account_name_db = addPrefix( $_SESSION['gameAdminServer'], 'accountName', $account_name );

	$andCondArray[] = " account_name = '$account_name_db' ";
	
}
if ( !empty( $role_name ) )
{
	// 添加前缀，因为日志中获得的角色名，格式为 "[服ID]角色名"
	$role_name_db = addPrefix( $_SESSION['gameAdminServer'], 'roleName', $role_name );
	
	$andCondArray[] = " role_name = '$role_name_db' ";
}
if ( !empty( $start_time ) && !empty( $end_time ) && $start_time > $end_time )
{// 提供了开始和结束时间，但是开始时间大于结束时间
	$errorMsg[] = $lang->page->startTimeGtEndTime;
	$notValid = true;
}
if ( !empty( $start_time ) )
{
	$andCondArray[] = " mtime > $start_time ";
}
if ( !empty( $end_time ) )
{ 
	$andCondArray[] = " mtime < $end_time ";
}



// 当提供了查询条件则执行查询
if( !$notValid && !empty( $andCondArray ) )
{  
	$cond 	= implode( ' AND ' ,$andCondArray ) ;
	$start 	= ( $page - 1 ) * $pageSize;
	$sql 	= "SELECT 
					account_name, role_name, level, ip, mtime
				FROM " . T_LOG_LOGIN . " 
				WHERE 
					$cond 
				ORDER BY 
					mtime desc
				LIMIT $start, $page_size";
//	$smarty->assign( 'unfinish_task_list', $unfinish_task_list );
//	print_r($viewData);
	$login_log_list = GFetchRowSet( $sql );
	
	// 获取满足条件的记录数
	$sql2 = "SELECT 
				count(*) as row_count
			FROM " . T_LOG_LOGIN . " 
			WHERE 
				$cond";
	$login_log_count = GFetchRowOne( $sql2 );
	$login_log_count = $login_log_count['row_count'];
	// 构造页码
	$pages = getPages2( $page, $login_log_count, $page_size );
	
	$smarty->assign( 'pages', 	$pages );
	$smarty->assign( 'login_log_list', $login_log_list );
}

// 设置smarty的变量
$minDate = $serverList[$_SESSION ['gameAdminServer']]['onlinedate'];
$maxDate = Datatime :: getTodayString();
$smarty->assign("minDate", $minDate);
$smarty->assign("maxDate", $maxDate);
$smarty->assign( 'role', 	$role );
$smarty->assign( 'errorMsg', 	implode('<br/>', $errorMsg ) );
$smarty->assign( 'successMsg', 	implode('<br/>', $successMsg ) );
//$smarty->assign( 'current_uri', cleanQueryString( $_SERVER['REQUEST_URI'], array('page') ));
$smarty->assign( 'lang', 	$lang );
$smarty->display('module/player/player_login.tpl');

