<?php
/**
 * 宠物资质排行榜
 */


include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';

for($i=0;$i<24;$i++) {
	$dictHour[$i] = $i."";
}

$selectDate = $_POST['selectDate'];
if(!$selectDate) {
	$selectDate = date("Y-m-d");
}

$hour = $_POST['hour']? $_POST['hour'] : date("H");

$dateStartTime = strtotime($selectDate ." ". $hour . ":00:00");
$dateEndTime = strtotime($selectDate ." ". $hour . ":59:59");
$where = " mtime>={$dateStartTime} AND mtime<={$dateEndTime} ";

$record = $_POST['record'] ? SS($_POST['record']) : LIST_PER_PAGE_RECORDS;

$counts = 0;//总记录
$pageno = getUrlParam('page');//设置初始页
$startNum = ($pageno - 1) * $record; //每页开始位置

$viewData = getZizhiRank($where, $startNum, $record, $counts);

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
$smarty->display("module/rank/pet_attack_rank.tpl");

function getZizhiRank($where, $startNum, $record, &$counts) {
	
	$sqlCount = "select count(*) as cnt from t_log_billboard_pet_zizhi where {$where} ";
	$ret = GFetchRowOne($sqlCount);
	$counts = $ret['cnt'] ? $ret['cnt'] : 0;
	
	$sql = "select uuid, role_name, zizhi, rank,petLv from t_log_billboard_pet_zizhi where {$where} order by rank limit {$startNum}, {$record}";	
    $data = GFetchRowSet($sql);
	
	return $data;
}
