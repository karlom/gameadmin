<?php 
/**
 * 玩家升级历史查询
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
//include_once '../../../protected/game_config/webgame/game_function.php';
global $lang;
// 错误信息
$errorMsg = $successMsg = array();

// 获取参数
$role 	= isset( $_REQUEST['role'] )? $_REQUEST['role'] : array();
list($page, $page_size) = getPagesParams();

// 过滤参数
if( !empty( $role['account_name'] ) )
{
	$account_name 	=  SS( $role['account_name'] ) ;
	$role['account_name'] = $account_name;
}

if( !empty( $role['role_name'] ) )
{
	$role_name 		=  SS( $role['role_name'] ) ;
	$role['role_name'] = $role_name;
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
	$andCondArray[] = " account_name = '$account_name' ";
	
}
if ( !empty( $role_name ) )
{	
	$andCondArray[] = " role_name = '$role_name' ";
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
	$start 	= ( $page - 1 ) * $page_size;
	$sql 	= "SELECT 
					account_name, role_name, prev_level, level, ip, mtime
				FROM " . T_LOG_LEVEL_UP . " 
				WHERE 
					$cond 
				ORDER BY 
					level DESC
				LIMIT $start, $page_size";

//	$smarty->assign( 'unfinish_task_list', $unfinish_task_list );
//	print_r($viewData);
	$level_up_log_list = GFetchRowSet( $sql );
	
	// 获取满足条件的记录数
	$sql2 = "SELECT 
				count(*) as row_count
			FROM " . T_LOG_LEVEL_UP . " 
			WHERE 
				$cond";
	$level_up_log_count = GFetchRowOne( $sql2 );
	$level_up_log_count = $level_up_log_count['row_count'];
	// 构造页码
	$pages = getPages2( $page, $level_up_log_count, $page_size );
	
	$smarty->assign( 'pages', 	$pages );
	$smarty->assign( 'level_up_log_list', $level_up_log_list );
}



// 设置smarty的变量
$minDate = $serverList[$_SESSION ['gameAdminServer']]['onlinedate'];
$maxDate = Datatime :: getTodayString();
$smarty->assign("minDate", $minDate);
$smarty->assign("maxDate", $maxDate);
$smarty->assign( 'role', 	$role );
$smarty->assign( 'errorMsg', 	implode('<br/>', $errorMsg ) );
$smarty->assign( 'successMsg', 	implode('<br/>', $successMsg ) );
$smarty->assign( 'lang', 	$lang );
$smarty->display('module/player/level_up.tpl');