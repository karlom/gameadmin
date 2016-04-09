<?php 
/**
 * 查看聊天日志
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
global $lang;
// 错误信息
$errorMsg = $successMsg = array();

// 获取参数
//$role 	= isset( $_REQUEST['role'] )? $_REQUEST['role'] : array();
//$page	= isset( $_REQUEST['page'] )? $_REQUEST['page'] : 1;//当前页码
//$page_size = isset( $_REQUEST['pagesize'] )? $_REQUEST['pagesize'] : 30;//当前页码;//一页显示记录数

// 过滤参数
/* 不按条件过滤，直接按日显示日志
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

if( !empty( $_REQUEST['keyword'] ) )
{
	$keyword 		= SS( $_REQUEST['keyword'] );
	$smarty->assign( 'keyword', 	$keyword );
}
*/
// 分日显示
if( !empty( $_REQUEST['channel'] ) || is_numeric( $_REQUEST['channel'] ) )
{
	$channel 		= SS( $_REQUEST['channel'] );
}
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
// 账号
if ( !empty( $account_name ) )
{
	$andCondArray[] = " account_name = '$account_name' ";
	
}
// 角色名
if ( !empty( $role_name ) )
{
	$andCondArray[] = " role_name = '$role_name' ";
}
// 频道
if ( !empty( $channel ) || is_numeric( $channel )  )
{ 
	if( !is_numeric($channel) )
	{
		$notValid = true;
		$errorMsg[] = $lang->page->channelShouldBeInt;
	}
	if( $channel > -1)
	{
		$andCondArray[] = " channel = $channel ";
	}
}
else 
{
	$channel_keys = array_keys( $channelArray );
	$channel = array_shift( $channel_keys );
	unset( $channel_keys );
	$andCondArray[] = " channel = $channel ";
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
// 关键字
if ( !empty( $keyword ) )
{
	$andCondArray[] = " content like '%$keyword%' ";
}

// 当提供了查询条件则执行查询
if( !$notValid && !empty( $andCondArray ) )
{  
	$cond 	= implode( ' AND ' ,$andCondArray ) ;// where 子句
	$start 	= ( $page - 1 ) * $page_size; // limit 子句
	
	// 获取满足条件的记录
	$sql 	= "SELECT 
					account_name, role_name, channel, content, mtime
				FROM " . T_LOG_CHAT . " 
				WHERE 
					$cond 
				ORDER BY 
					mtime DESC";
	
//				LIMIT $start, $page_size;
//	$smarty->assign( 'unfinish_task_list', $unfinish_task_list );
//	print_r($viewData);
	$chat_log_list = GFetchRowSet( $sql );
	/*
	// 获取满足条件的记录数
	$sql2 = "SELECT 
				count(*) as row_count
			FROM " . T_LOG_CHAT . " 
			WHERE 
				$cond";
	$chat_log_count = GFetchRowOne( $sql2 );
	$chat_log_count = $chat_log_count['row_count'];
	// 构造页码
//	$pages = getPages( $page, $chat_log_count, $page_size );
	// 传递变量到模板
//	$smarty->assign( 'pages', 	$pages );*/
	$smarty->assign( 'chat_log_list', $chat_log_list );
}



// 设置smarty的变量
$minDate = $serverList[ $_SESSION ['gameAdminServer'] ]['onlinedate'];
$maxDate = Datatime::getTodayString();
$smarty->assign("minDate", $minDate);
$smarty->assign("maxDate", $maxDate);
$smarty->assign("lookingDay", $lookingday);
$smarty->assign("viewday", $viewday);
$smarty->assign( 'channel', 	$channel );
$smarty->assign("channelArray", $channelArray);
$smarty->assign( 'role', 	$role );
$smarty->assign( 'errorMsg', 	implode('<br/>', $errorMsg ) );
$smarty->assign( 'successMsg', 	implode('<br/>', $successMsg ) );
$smarty->assign( 'current_uri', cleanQueryString( $_SERVER['REQUEST_URI'], array('page') ) );
$smarty->assign( 'lang', 	$lang );
$smarty->display( 'module/msg/chat_log.tpl' );