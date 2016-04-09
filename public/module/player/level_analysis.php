<?php 
/**
 * 等级分析
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
global $lang;
// 错误信息
$errorMsg = $successMsg = array();

// 获取参数
$page	= isset( $_REQUEST['page'] )? $_REQUEST['page'] : 1;//当前页码
$page_size = isset( $_REQUEST['pagesize'] )? $_REQUEST['pagesize'] : 1;//当前页码;//一页显示记录数

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
$notValid = false;

if ( !empty( $start_time ) && !empty( $end_time ) && $start_time > $end_time )
{// 提供了开始和结束时间，但是开始时间大于结束时间
	$errorMsg[] = $lang->page->startTimeGtEndTime;
	$notValid = true;
}
if ( !empty( $start_time ) )
{
	$andCondArray[] = " t1.mtime > $start_time ";
}
if ( !empty( $end_time ) )
{ 
	$andCondArray[] = " t1.mtime < $end_time ";
}
$cond = '';
// 当提供了查询条件则执行查询
if( !$notValid && !empty( $andCondArray ) )
{  
	$cond 	= ' AND ' . implode( ' AND ' ,$andCondArray ) ;
	$start 	= ( $page - 1 ) * $pageSize;
	$sql 	= "SELECT
					 	count(t1.account_name) men_count, t1.prev_level p_level, t1.level c_level, avg (t1.mtime - t2.mtime) cost 
				   FROM
				   		" . T_LOG_LEVEL_UP . " t1 
				   LEFT JOIN 
				   		" . T_LOG_LEVEL_UP . " t2 
				   ON 
				   		t1.prev_level = t2.level AND t1.account_name=t2.account_name 
				   WHERE 
				   		t1.level > 1 $cond
				   GROUP BY 
				   		p_level, c_level;
	";
	
	//	$smarty->assign( 'unfinish_task_list', $unfinish_task_list );
	//	print_r($viewData);
	
	$avg_cost_per_level = GFetchRowSet( $sql );
		
	// 获取满足条件的记录数
	$smarty->assign( 'avg_cost_per_level', $avg_cost_per_level );
		
}




// 设置smarty的变量
$minDate = $serverList[$_SESSION ['gameAdminServer']]['onlinedate'];
$maxDate = Datatime :: getTodayString();
$smarty->assign("minDate", $minDate);
$smarty->assign("maxDate", $maxDate);
$smarty->assign( 'errorMsg', 	implode('<br/>', $errorMsg ) );
$smarty->assign( 'successMsg', 	implode('<br/>', $successMsg ) );
$smarty->assign( 'lang', 	$lang );
$smarty->display('module/player/level_analysis.tpl');