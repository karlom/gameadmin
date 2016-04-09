<?php
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';

$selectDate = $_POST['selectDate'];

if(!$selectDate) {
	$selectDate = date("Y-m-d");
}

$viewData = getVeinLevelRank($selectDate);

//print_r($viewData);
//$viewData = sortArrayByKey($viewData,"level","desc");


$smarty->assign("selectDate", $selectDate);
$smarty->assign("minDate", ONLINEDATE);
$smarty->assign("maxDate", date("Y-m-d"));
$smarty->assign("viewData", $viewData);
$smarty->assign("lang", $lang);
$smarty->display("module/rank/vein_level_rank.tpl");

function getVeinLevelRank($date) {
	$data = array();
	
	$dateStartTime = strtotime($date." 00:00:00 ");
	$dateEndTime = strtotime($date." 23:59:59 ");
	
	$table = "t_log_vein_lv";
	
	//龙脉等级
	$sql = "select uuid, role_name, max(veinLv) as level from ". $table ." where mtime<={$dateEndTime} group by uuid order by veinLv desc limit 50 ";
	
	$levelRankData = GFetchRowSet($sql);
//	echo "sql: $sqlLevelRank"."<br>";
	
	return $levelRankData;
}
