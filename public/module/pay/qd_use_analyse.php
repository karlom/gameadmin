<?php
/**
 * qd_use_analyse.php
 * Author: Libiao
 * Create on 2013-9-29 17:52:07
 * Q点使用统计
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/arrItemsAll.php';

$openTimestamp = strtotime( ONLINEDATE );
$today = date("Y-m-d");

$roleName = $_REQUEST['role_name'] ; 
$accountName = $_REQUEST['account_name'] ; 

$startDate = $_REQUEST['startdate'] ? $_REQUEST['startdate'] : Datatime::getPrevWeekString();
$endDate = $_REQUEST['enddate'] ? $_REQUEST['enddate'] : $today;

$startTime = strtotime($startDate. " 00:00:00 ");
$endTime = strtotime($endDate." 23:59:59 ");

if($startTime < $openTimestamp) {
	$startDate = ONLINEDATE;
	$startTime = strtotime($startDate. " 00:00:00 ");
}

$lookingday = $_REQUEST['lookingday'] ? $_REQUEST['lookingday'] : $today;


if( !empty( $_REQUEST['preday'] ) ) { // 查看前一天
	$startTime = strtotime( $lookingday . ' 00:00:00 -1 day' );
	$endTime	= strtotime( $lookingday . ' 23:59:59 -1 day' );
	$lookingday = date('Y-m-d', $startTime);
} elseif( !empty( $_REQUEST['nextday'] ) ) { // 查看后一天
	$startTime = strtotime( $lookingday . ' 00:00:00 +1 day' );
	$endTime	= strtotime( $lookingday . ' 23:59:59 +1 day' );
	$lookingday = date('Y-m-d', $startTime);
} elseif( !empty( $_REQUEST['today'] ) ) { // 查看当天
	$startTime = strtotime( $today . ' 00:00:00' );
	$endTime	= strtotime( $today . ' 23:59:59' );
	$lookingday = $today;
} elseif( !empty( $_REQUEST['showAll'] ) ) { // 查看全部
	$startTime = strtotime( ONLINEDATE );
	$endTime	= strtotime( $today . ' 23:59:59' );
	$lookingday = $today;
}


// 构造$andCondArray
$andCondArray = array();
$notValid = false;

if ( !empty( $accountName ) ) {
	$andCondArray[] = " account_name = '{$accountName}' ";	
}
if ( !empty( $roleName ) ) {	
	$andCondArray[] = " role_name = '{$roleName}' ";
}

if ( !empty( $startTime ) && !empty( $endTime ) && $startTime > $endTime ) {// 提供了开始和结束时间，但是开始时间大于结束时间
	$errorMsg[] = $lang->page->startTimeGtEndTime;
	$notValid = true;
}
if ( !empty( $startTime ) ) {
	$andCondArray[] = " ts > $startTime ";
}
if ( !empty( $endTime ) ) { 
	$andCondArray[] = " ts < $endTime ";
}

$cond 	= implode( ' AND ' ,$andCondArray ) ;

$sql = "select item_id, sum(item_cnt) as item_cnt, round(sum(total_cost  + pubacct + amt/10)) as total_cost, count(*) as op_cnt from " . T_LOG_BUY_GOODS . " where {$cond} group by item_id order by item_id ";
$viewData = GFetchRowSet($sql);
//echo "S=".$sql;


$allCost = 0;
$allOpCost = 0;
$allItemCount = 0;

foreach($viewData as $k => $v) {
	$allCost += $v['total_cost'];
	$allOpCost += $v['op_cnt'];
	$allItemCount += $v['item_cnt'];
}

if($allCost != 0 ) {
	foreach($viewData as $k => $v) {
		$viewData[$k]['perc'] = round($v['total_cost']/$allCost , 4)*100;
	}
}


$minDate = ONLINEDATE;
$maxDate = $today;
$smarty->assign("role_name", $roleName);
$smarty->assign("account_name", $accountName);
$smarty->assign("minDate", $minDate);
$smarty->assign("maxDate", $maxDate);
//$smarty->assign("startDate", $startDate);
//$smarty->assign("endDate", $endDate);
$smarty->assign("startDate", date("Y-m-d", $startTime));
$smarty->assign("endDate", date("Y-m-d", $endTime));
$smarty->assign("lookingday", $lookingday);

$smarty->assign("viewData", $viewData);
$smarty->assign("allOpCost", $allOpCost);
$smarty->assign("allCost", $allCost);
$smarty->assign("allItemCount", $allItemCount);

$smarty->assign("lang", $lang);
$smarty->assign("arrItemsAll", $arrItemsAll);
$smarty->display("module/pay/qd_use_analyse.tpl");