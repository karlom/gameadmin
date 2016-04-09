<?php
/**
 * player_opinion.php
 * 玩家提BUG或建议
 * 
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';


$today = date("Y-m-d");
$minDate = ONLINEDATE;
$maxDate = $today;

if(!empty($_REQUEST['today'])){
	$startDate = $today ;
	$endDate = $today ;
	$startTime = strtotime($startDate. " 00:00:00");
	$endTime = strtotime($endDate. " 23:59:59");
} else {
	$startDate = isset($_REQUEST['starttime'])?$_REQUEST['starttime']:$today;
	$endDate = isset($_REQUEST['endtime'])?$_REQUEST['endtime']:$today;
	$startTime = strtotime($startDate. " 00:00:00");
	$endTime = strtotime($endDate. " 23:59:59");
}

//分页参数
$pageNum = intval($_REQUEST['record']) ? SS($_REQUEST['record']) : LIST_PER_PAGE_RECORDS;

$counts = 0;//总记录
$pageno = isset($_GET['page'])?$_GET['page']:1;//设置初始页
$startNum = ($pageno - 1) * $pageNum; //每页开始位置

//
$condArr = array ();
$condArr[] = " mtime >= {$startTime} ";
$condArr[] = " mtime < {$endTime} ";

$accountName = isset($_REQUEST['account_name'])? SS(trim($_REQUEST['account_name'])):"";
$roleName = isset($_REQUEST['role_name'])? SS(trim($_REQUEST['role_name'])):"";

if( !empty($accountName) ) {
	$condArr[] = " account_name = '{$accountName}' ";
}
if( !empty($roleName) ) {
	$condArr[] = " role_name = '{$roleName}' ";
}

$where = implode(' AND ',$condArr);
$sql = " select * from ". T_LOG_BUG . " where {$where}  limit {$startNum}, {$pageNum}";
$countSql = " select count(*) as count from ". T_LOG_BUG . " where {$where} ";
$opinion_list = GFetchRowSet($sql);
$cntRs = GFetchRowOne($countSql);
$counts = $cntRs['count'];

if( !empty($accountName) || !empty($roleName) && !empty($opinion_list)) {
	$accountName = $opinion_list[0]['account_name'];
	$roleName = $opinion_list[0]['role_name'];
}


//分页参数
$pageCount = ceil ( $counts/$pageNum );
$pagelist = getPages($pageno, $counts, $pageNum);

$smarty->assign('counts', $counts );
$smarty->assign('pagelist', $pagelist );
$smarty->assign('pageCount', $pageCount );
$smarty->assign('pageNum', $pageNum );
$smarty->assign('pageno', $pageno );

$smarty->assign('account_name', $accountName );
$smarty->assign('role_name', $roleName );
$smarty->assign('opinion_list', $opinion_list );
$smarty->assign('lang', $lang );

$smarty->assign('startDate', $startDate );
$smarty->assign('endDate', $endDate );
$smarty->assign('minDate', $minDate );
$smarty->assign('maxDate', $maxDate );
$smarty->display( 'module/msg/player_opinion.tpl' );