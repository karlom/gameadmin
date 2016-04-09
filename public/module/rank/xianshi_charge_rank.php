<?php
/**
 * xianshi_charge_rank.php
 * 仙尊经验排行(充值排行)
 * 
 */


include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';

$selectDate = $_POST['selectDate'];

if(!$selectDate) {
	$selectDate = date("Y-m-d");
}

$endTime = strtotime($selectDate . "23:59:59");

$where = " mtime <= {$endTime} ";

$record = $_POST['record'] ? SS($_POST['record']) : LIST_PER_PAGE_RECORDS;

$counts = 0;//总记录
$pageno = getUrlParam('page');//设置初始页
$startNum = ($pageno - 1) * $record; //每页开始位置

$viewData = getChargeRank($where, $startNum, $record, $counts);

$pageCount = ceil ( $counts/$record );
$pagelist = getPages($pageno, $counts,$record);


//print_r($viewData);

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
$smarty->display("module/rank/xianshi_charge_rank.tpl");

function getChargeRank($where, $startNum, $record, &$counts) {
	
	$sqlCount = "SELECT COUNT(DISTINCT t1.uuid) AS cnt " .
			" FROM t_log_yuanbao_sum t1, (SELECT uuid, MAX(mtime) AS mtime FROM t_log_yuanbao_sum where {$where} GROUP BY uuid) t2 " .
			" WHERE t2.mtime = t1.mtime AND t1.uuid=t2.uuid ";
	$ret = GFetchRowOne($sqlCount);
	$counts = $ret['cnt'] ? $ret['cnt'] : 0;
	
	$sql = "SELECT t1.mtime, t1.uuid, t1.account_name, t1.role_name, t1.yuanbaosum " .
			" FROM t_log_yuanbao_sum t1 , (SELECT uuid, max(mtime) AS mtime FROM t_log_yuanbao_sum where {$where} GROUP BY uuid) t2 " .
			" WHERE t2.mtime = t1.mtime AND t1.uuid=t2.uuid AND t1.yuanbaosum>0 " .
			" GROUP BY t1.uuid ORDER BY t1.yuanbaosum DESC " .
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