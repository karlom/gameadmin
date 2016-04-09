<?php 
/**
 * 查看好友聊天日志
 * 
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
global $lang;
// 错误信息
$errorMsg = $successMsg = array();

// 获取参数
$role_name 	= isset( $_REQUEST['role_name'] )? SS($_REQUEST['role_name']) : "";

// 分日显示
if( !empty( $_REQUEST['lookingday'] ))
{
	$lookingday = SS( $_REQUEST['lookingday'] );
}
else
{
	$lookingday = date( 'Y-m-d' );
}

if( !empty( $_REQUEST['preday'] ) )
{
	$start_time = strtotime( $lookingday . ' 00:00:00 -1 day' );
	$end_time	= strtotime( $lookingday . ' 23:59:59 -1 day' );
	$lookingday = date('Y-m-d', $start_time);
}
elseif( !empty( $_REQUEST['nextday'] ) )
{
	$start_time = strtotime( $lookingday . ' 00:00:00 +1 day' );
	$end_time	= strtotime( $lookingday . ' 23:59:59 +1 day' );
	$lookingday = date('Y-m-d', $start_time);
}
elseif( !empty( $_REQUEST['today'] ) )// 查看当天
{
	$today 		= date( 'Y-m-d' );
	$start_time = strtotime( $today . ' 00:00:00' );
	$end_time	= strtotime( $today . ' 23:59:59' );
	$lookingday = $today;
}
else
{
//	$today 		= date( 'Y-m-d' );
	$start_time = strtotime( $lookingday . ' 00:00:00' );
	$end_time	= strtotime( $lookingday . ' 23:59:59' );
}

// 构造$andCondArray
$andCondArray = array();
$notValid = false;

// 角色名
if ( !empty( $role_name ) )
{	
	$andCondArray[] = " ( role_name = '{$role_name}' || targetName = '{$role_name}' )";
}

// 时间范围
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
	$cond 	= implode( ' AND ' ,$andCondArray ) ;// where 子句
	$start 	= ( $page - 1 ) * $page_size; // limit 子句
	
	// 获取满足条件的记录
	$sql 	= "SELECT 
					account_name, role_name, level, content, mtime, targetName
				FROM " . T_LOG_FRIEND_CHAT . " 
				WHERE 
					$cond 
				ORDER BY 
					mtime DESC";
	

	$chat_log_list = GFetchRowSet( $sql );

	$smarty->assign( 'chat_log_list', $chat_log_list );
}



// 设置smarty的变量
$minDate = $serverList[ $_SESSION ['gameAdminServer'] ]['onlinedate'];
$maxDate = Datatime::getTodayString();
$smarty->assign("minDate", $minDate);
$smarty->assign("maxDate", $maxDate);
$smarty->assign("lookingDay", $lookingday);
$smarty->assign( 'role_name', 	$role_name );
$smarty->assign( 'errorMsg', 	implode('<br/>', $errorMsg ) );
$smarty->assign( 'successMsg', 	implode('<br/>', $successMsg ) );
$smarty->assign( 'current_uri', cleanQueryString( $_SERVER['REQUEST_URI'], array('page') ) );
$smarty->assign( 'lang', 	$lang );
$smarty->display( 'module/msg/friend_chat_log.tpl' );