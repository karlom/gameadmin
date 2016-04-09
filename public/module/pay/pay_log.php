<?php
/**
 * pay_log.php
 * Author: Libiao
 * Create on 2013-9-26 05:15:16
 * 充值日志
 */
 
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/arrItemsAll.php';

//开通黄钻次数：普通、年费

$roleName = $_POST['role_name'] ; 
$accountName = $_POST['account_name'] ; 
$billno = $_POST['billno'] ; 

//获取时间段
if (! isset ( $_POST ['starttime'] )){
    $dateStart = Datatime::getPrevWeekString ();
}else{
    $dateStart = SS ( $_POST ['starttime'] );
}

$dateStart = (strtotime($dateStart) >= strtotime(ONLINEDATE)) ? $dateStart : ONLINEDATE;
$dateEnd = ! isset ($_POST['endtime']) ? Datatime::getTodayString() :  SS ($_POST['endtime']);
$dateStartTamp = strtotime($dateStart." 0:0:0");
$dateEndTamp = strtotime($dateEnd." 23:59:59");

$where = " mtime>={$dateStartTamp} AND mtime<={$dateEndTamp} ";

if($roleName) {
	$where .= " AND role_name='{$roleName}' ";
}
if($accountName) {
	$where .= " AND account_name='{$accountName}' ";
}
if($billno) {
	$where .= " AND billno='{$billno}' ";
}

$record = $_POST['record'] ? SS($_POST['record']) : LIST_PER_PAGE_RECORDS;

$counts = 0;//总记录
$pageno = getUrlParam('page');//设置初始页
$startNum = ($pageno - 1) * $record; //每页开始位置
$buyData = getBuyGoodsData($where, $startNum, $record, $counts);

$pageCount = ceil ( $counts/$record );
$pagelist = getPages($pageno, $counts,$record);

$maxDate = date ( "Y-m-d" );
$data = array(
    'counts' => $counts,
    'record' => $record,
    'minDate' => ONLINEDATE,
    'maxDate' => $maxDate,
    'role_name' => $roleName,
    'account_name' => $accountName,
    'billno' => $billno,
    'pagelist' => $pagelist,
    'pageCount' => $pageCount,
    'pageno' => $pageno,
    'dateStart' => $dateStart,
    'dateEnd' => $dateEnd,
    'lang' => $lang,
    'arrItemsAll' => $arrItemsAll,
    'viewData' => $buyData['viewData'],
	'date_data' => $buyData['date_data'],
	'all_data' => $buyData['all_data'],
	'payRoleCount' => $buyData['payRoleCount'],
	'allPayRoleCount' => $buyData['allPayRoleCount'],
);


$smarty->assign ($data);
$smarty->display("module/pay/pay_log.tpl");


function getBuyGoodsData($where,$startNum,$record,&$counts) {
	
//	$data = array();
	$table  = "t_log_pay";
	
	$sqlYellowVipCount = "select count(*) as cnt from " . $table . " where {$where} ";
	$result = GFetchRowOne($sqlYellowVipCount);
	$counts = $result['cnt'];
	
	$sqlYellowVip = "select * from " . $table . " where {$where} limit {$startNum},{$record} ";
	$result = GFetchRowSet($sqlYellowVip);
	
	$sqlDateTotal = "select sum(xianshiCnt) as game_coin, sum(amt) as date_total from " . $table . " where {$where} ";
	$sqlDateTotalResult = GFetchRowOne($sqlDateTotal);
	
	if(!empty($sqlDateTotalResult)) {
		foreach($sqlDateTotalResult as $k => $v){
			if(empty($v)) {
				$sqlDateTotalResult[$k] = 0;
			}
		}
	}
	
	$sqlAllTotal = "select sum(xianshiCnt) as game_coin, sum(amt) as  all_total from " . $table ;
	$sqlAllTotalResult = GFetchRowOne($sqlAllTotal);
	
	if(!empty($sqlAllTotalResult)) {
		foreach($sqlAllTotalResult as $k => $v){
			if(empty($v)) {
				$sqlAllTotalResult[$k] = 0;
			}
		}
	}
	
	$sqlPayRoleCount = "select count(distinct uuid) as payRoleCount from " . $table ;
	$sqlPayRoleCountResult = GFetchRowOne($sqlPayRoleCount);
	
	$sqlAllPayRoleCount = "select count(distinct uuid) as payRoleCount from " . $table . " where {$where} ";
	$sqlAllPayRoleCountResult = GFetchRowOne($sqlAllPayRoleCount);
	
	$data = array(
		'viewData' => $result,
		'date_data' => $sqlDateTotalResult,
		'all_data' => $sqlAllTotalResult,
		'payRoleCount' => $sqlPayRoleCountResult['payRoleCount'],
		'allPayRoleCount' => $sqlAllPayRoleCountResult['payRoleCount'],
	);
	
	return $data;
}
