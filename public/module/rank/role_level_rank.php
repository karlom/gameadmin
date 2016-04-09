<?php
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';

$selectDate = $_POST['selectDate'];

if(!$selectDate) {
	$selectDate = date("Y-m-d");
}

$viewData = getLevelRank($selectDate);

//print_r($viewData);
//$viewData = sortArrayByKey($viewData,"level","desc");


$smarty->assign("selectDate", $selectDate);
$smarty->assign("minDate", ONLINEDATE);
$smarty->assign("maxDate", date("Y-m-d"));
$smarty->assign("viewData", $viewData);
$smarty->assign("lang", $lang);
$smarty->display("module/rank/role_level_rank.tpl");

function getLevelRank($date) {
	$data = array();
	
	$dateStartTime = strtotime($date." 00:00:00 ");
	$dateEndTime = strtotime($date." 23:59:59 ");
	
//	$where = " mtime < {$dateStartTime} ";
	
	//今日等级
	$sqlTodayLevel = "select uuid, role_name, max(level) as level from ". T_LOG_LEVEL_UP ." where mtime<={$dateEndTime} group by uuid order by level desc limit 50 ";

	//昨日等级
	$sqlYestodayLevel = "select uuid, role_name, max(level) as level from ". T_LOG_LEVEL_UP ." where mtime<{$dateStartTime} group by uuid ";
	/*
	$sqlLevelRank = "select t2.uuid, t2.role_name, t2.level as level, t1.level as ylevel " .
			" from ({$sqlYestodayLevel}) t1, ({$sqlTodayLevel}) t2 " .
			" where t1.uuid= t2.uuid " .
			" order by t2.level desc ";
	*/	
	$sqlLevelRank = " select t2.uuid, t2.role_name, t2.level as level, t1.level as ylevel " .
			" from ({$sqlYestodayLevel}) t1 right join ({$sqlTodayLevel}) t2 " .
			" on t1.uuid= t2.uuid " .
			" order by t2.level desc ";			
			
	$levelRankData = GFetchRowSet($sqlLevelRank);
//	echo "sql: $sqlLevelRank"."<br>";
	
	return $levelRankData;
}
