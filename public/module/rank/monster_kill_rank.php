<?php
/**
 * monster_kill_rank.php
 */


include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';

$selectDate = $_POST['selectDate'];

if(!$selectDate) {
	$selectDate = date("Y-m-d");
}

//$dateStartTime = strtotime($selectDate." 0:0:0");
//$dateEndTime = strtotime($selectDate." 23:59:59");
//$where = " mtime>={$dateStartTime} AND mtime<={$dateEndTime} ";

$where = " 1 ";

$record = $_POST['record'] ? SS($_POST['record']) : LIST_PER_PAGE_RECORDS;

$counts = 0;//总记录
$pageno = getUrlParam('page');//设置初始页
$startNum = ($pageno - 1) * $record; //每页开始位置
//$viewData = getMonsterKillRank($selectDate);
$viewData = getMonsterKillRank($where, $startNum, $record, $counts);
//$viewData = getOrangeEquipDropData($where, $startNum, $record, $counts);

$pageCount = ceil ( $counts/$record );
$pagelist = getPages($pageno, $counts,$record);


$smarty->assign("counts", $counts);
$smarty->assign("record", $record);
$smarty->assign("pagelist", $pagelist);
$smarty->assign("pageCount", $pageCount);
$smarty->assign("pageno", $pageno);

$smarty->assign("selectDate", $selectDate);
$smarty->assign("minDate", ONLINEDATE);
$smarty->assign("maxDate", date("Y-m-d"));
$smarty->assign("viewData", $viewData);
$smarty->assign("lang", $lang);
$smarty->display("module/rank/monster_kill_rank.tpl");

function getMonsterKillRank($where, $startNum, $record, &$counts) {
	
	$sqlMonsterKillCount = "select count(*) as cnt from (select killer_uuid,killer_name,count(*) as cnt from t_log_die where {$where} AND killer_type=3 group by killer_uuid) t1 ";
	$ret = GFetchRowOne($sqlMonsterKillCount);
	$counts = $ret['cnt'] ? $ret['cnt'] : 0;
	
	$sqlMonsterKill = "select killer_uuid,killer_name,count(*) as cnt from t_log_die where {$where} AND killer_type=3 group by killer_uuid order by cnt desc limit {$startNum}, {$record}";	
	$monsterKillData = GFetchRowSet($sqlMonsterKill);
	
//	echo "sql: $sqlMonsterKill"."<br>";
	if(!empty($monsterKillData)){
		foreach($monsterKillData as $k => &$v){
			$v['rank'] = $startNum + $k + 1;
		}		
	}

	
	return $monsterKillData;
}
