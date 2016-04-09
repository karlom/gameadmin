<?php
/**
 * pay_userid.php
 * Author: Libiao
 * Create on 2014-03-15
 * 充值玩家ID
 */
 
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/arrItemsAll.php';

//开通黄钻次数：普通、年费

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
$smarty->display("module/pay/pay_userid.tpl");


function getBuyGoodsData($where,$startNum,$record,&$counts) {
	
//	$data = array();
	
	$sqlCount = "select count(distinct uuid) as cnt from " . T_LOG_BUY_GOODS . " where {$where} ";
	$result = GFetchRowOne($sqlCount);
	$counts = $result['cnt'];
	
	$sqlData = "select account_name, role_name from " . T_LOG_BUY_GOODS . " where {$where} group by uuid limit {$startNum},{$record} ";
	$data = GFetchRowSet($sqlData);
	
	if(!empty($data)) {
		foreach($data as $k => $v ){
			$openid = (strlen($v['account_name'])>32) ? substr($v['account_name'],6) : $v['account_name'];
			$data[$k]['openid'] = $openid;
		}
	}
	
	return $data;
}
