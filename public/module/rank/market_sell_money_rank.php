<?php
/**
 * market_sell_money_rank.php
 * 寄卖铜币交易量排行
 */


include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';

$selectDate = $_POST['selectDate'];
$lookingday = $_POST['lookingday'];

if( !$selectDate || !empty($_POST['today']) ) {
	$selectDate = date("Y-m-d");
}

if(!empty($_POST['preday'])){
	$selectDate = date("Y-m-d", strtotime($lookingday)-86400 );
}
if(!empty($_POST['nextday'])){
	$selectDate = date("Y-m-d", strtotime($lookingday)+86400 );
}

$dateStartTime = strtotime($selectDate." 0:0:0");
$dateEndTime = strtotime($selectDate." 23:59:59");

$where = " mtime>={$dateStartTime} AND mtime<={$dateEndTime} ";

$record = $_POST['record'] ? SS($_POST['record']) : LIST_PER_PAGE_RECORDS;

$counts = 0;//总记录
$pageno = getUrlParam('page');//设置初始页
$startNum = ($pageno - 1) * $record; //每页开始位置

$viewData = getMarketDealRank($where, $startNum, $record, $counts);

$pageCount = ceil ( $counts/$record );
$pagelist = getPages($pageno, $counts,$record);

$lookingday = $selectDate;

$smarty->assign("counts", $counts);
$smarty->assign("record", $record);
$smarty->assign("pagelist", $pagelist);
$smarty->assign("pageCount", $pageCount);
$smarty->assign("pageno", $pageno);

$smarty->assign("lookingday", $lookingday);
$smarty->assign("selectDate", $selectDate);
$smarty->assign("minDate", ONLINEDATE);
$smarty->assign("maxDate", date("Y-m-d"));
$smarty->assign("viewData", $viewData);
$smarty->assign("lang", $lang);
$smarty->display("module/rank/market_sell_money_rank.tpl");

function getMarketDealRank($where, $startNum, $record, &$counts) {
	
	$sqlCount = "select count(distinct uuid) as cnt from t_log_money  where {$where} AND money>0 AND type=30018 ";
	$ret = GFetchRowOne($sqlCount);
	$counts = $ret['cnt'] ? $ret['cnt'] : 0;
	
	$sql = "select uuid, account_name, role_name, sum(money) as sum_money from t_log_money  where {$where} AND money>0 AND type=30018 group by uuid order by sum_money desc limit {$startNum}, {$record}";	
	$data = GFetchRowSet($sql);
	
//	echo "sql: $sql"."<br>";
	if(!empty($data)){
		foreach($data as $k => &$v){
			$v['rank'] = $startNum + $k + 1;
		}		
	}
	
	return $data;
}