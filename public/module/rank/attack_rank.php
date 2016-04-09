<?php
/**
 * attack_rank.php
 * 战斗力排行榜
 */


include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';

//$dictHour
for($i=0;$i<24;$i++) {
	$dictHour[$i] = $i."";
}

$selectDate = $_POST['selectDate'];
if(!$selectDate) {
	$selectDate = date("Y-m-d");
}

$hour = isset($_POST['hour']) ? $_POST['hour'] : date("H");

$dateStartTime = strtotime($selectDate ." ". $hour . ":00:00");
$dateEndTime = strtotime($selectDate ." ". $hour . ":59:59");
$where = " mtime>={$dateStartTime} AND mtime<={$dateEndTime} ";

$record = $_POST['record'] ? SS($_POST['record']) : LIST_PER_PAGE_RECORDS;

$counts = 0;//总记录
$pageno = getUrlParam('page');//设置初始页
$startNum = ($pageno - 1) * $record; //每页开始位置

$viewData = getAttackRank($where, $startNum, $record, $counts);

$pageCount = ceil ( $counts/$record );
$pagelist = getPages($pageno, $counts,$record);


$smarty->assign("counts", $counts);
$smarty->assign("record", $record);
$smarty->assign("pagelist", $pagelist);
$smarty->assign("pageCount", $pageCount);
$smarty->assign("pageno", $pageno);

$smarty->assign("dictHour", $dictHour);
$smarty->assign("hour", $hour);
$smarty->assign("selectDate", $selectDate);
$smarty->assign("minDate", ONLINEDATE);
$smarty->assign("maxDate", date("Y-m-d"));
$smarty->assign("viewData", $viewData);
$smarty->assign("lang", $lang);
$smarty->display("module/rank/attack_rank.tpl");

function getAttackRank($where, $startNum, $record, &$counts) {
	
	$sqlCount = "select count(*) as cnt from " . T_LOG_BILLBOARD_ROLE_ATK . " where {$where} ";
	$ret = GFetchRowOne($sqlCount);
	$counts = $ret['cnt'] ? $ret['cnt'] : 0;
	
	$sql = "select uuid, account_name, role_name, level, atk, rank from " . T_LOG_BILLBOARD_ROLE_ATK . " where {$where} order by rank limit {$startNum}, {$record}";	
	$data = GFetchRowSet($sql);
	
//	echo "sql: $sqlMonsterKill"."<br>";
	
	return $data;
}
