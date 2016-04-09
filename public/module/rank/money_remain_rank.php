<?php
/**
 * money_remain_rank.php
 * 铜币排行榜
 */


include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
/*
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
*/
$where = " 1 ";

$record = $_POST['record'] ? SS($_POST['record']) : LIST_PER_PAGE_RECORDS;

$counts = 0;//总记录
$pageno = getUrlParam('page');//设置初始页
$startNum = ($pageno - 1) * $record; //每页开始位置

$viewData = getMoneyRank($where, $startNum, $record, $counts);

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
$smarty->display("module/rank/money_remain_rank.tpl");

function getMoneyRank($where, $startNum, $record, &$counts) {
	
//	$sqlCount = "select count(distinct uuid) as cnt from t_log_money  where {$where} ";
	$sqlCount = "SELECT COUNT(DISTINCT t1.uuid) AS cnt " .
			" FROM t_log_money t1, (SELECT uuid, MAX(mtime) AS mtime FROM t_log_money GROUP BY uuid) t2 " .
			" WHERE t2.mtime = t1.mtime AND t1.uuid=t2.uuid AND t1.remain_money>0 ";
	$ret = GFetchRowOne($sqlCount);
	$counts = $ret['cnt'] ? $ret['cnt'] : 0;
	
	$sql = "SELECT t1.mtime, t1.uuid, t1.account_name, t1.role_name, t1.remain_money " .
			" FROM t_log_money t1 , (SELECT uuid, max(mtime) AS mtime FROM t_log_money GROUP BY uuid) t2 " .
			" WHERE t2.mtime = t1.mtime AND t1.uuid=t2.uuid AND t1.remain_money>0 " .
			" GROUP BY t1.uuid ORDER BY t1.remain_money DESC " .
			" LIMIT {$startNum}, {$record} ";	
	$data = GFetchRowSet($sql);
	
//	echo "sql: $sql"."<br>";
	if(!empty($data)){
		foreach($data as $k => &$v){
			$v['rank'] = $startNum + $k + 1;
		}		
	}
	
	return $data;
}