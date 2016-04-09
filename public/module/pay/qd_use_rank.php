<?php
/**
 * qd_use_rank.php
 * Author: Libiao
 * Create on 2013-9-26 05:15:16
 * Q点使用排行
 */
 
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/arrItemsAll.php';


$roleName = $_POST['role_name'] ; 
$accountName = $_POST['account_name'] ; 

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

$record = $_POST['record'] ? SS($_POST['record']) : LIST_PER_PAGE_RECORDS;

$counts = 0;//总记录
$pageno = getUrlParam('page');//设置初始页
$startNum = ($pageno - 1) * $record; //每页开始位置
$viewData = getBuyGoodsData($where, $startNum, $record, $counts);

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
    'pagelist' => $pagelist,
    'pageCount' => $pageCount,
    'pageno' => $pageno,
    'dateStart' => $dateStart,
    'dateEnd' => $dateEnd,
    'lang' => $lang,
    'arrItemsAll' => $arrItemsAll,
    'viewData' => $viewData,
);


$smarty->assign ($data);
$smarty->display("module/pay/qd_use_rank.tpl");


function getBuyGoodsData($where,$startNum,$record,&$counts) {
	
//	$data = array();
	
	$sqlYellowVipCount = "select count(*) as cnt from " . T_LOG_BUY_GOODS . " where {$where} ";
	$result = GFetchRowOne($sqlYellowVipCount);
	$counts = $result['cnt'];
	
	
	$sqlQdUseRank = "select uuid,account_name,role_name, max(level) as level, round(sum(total_cost + pubacct + amt/10)) as all_total from " . T_LOG_BUY_GOODS . " where {$where} group by uuid order by all_total desc limit {$startNum},{$record} ";
	$result = GFetchRowSet($sqlQdUseRank);
	
	if(!empty($result)) {
		foreach($result as $k => &$v){
			$v['rank'] = $startNum + $k + 1;
		}
	}
	
	return $result;
}
