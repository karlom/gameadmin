<?php
/**
 * talisman_data.php
 * 法宝进阶、幻化统计
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';


$today = date( 'Y-m-d' );
$todayTimestamp = strtotime($today);

$openTimestamp = strtotime(ONLINEDATE);

if(isset($_REQUEST['startDate'])) {
	$startDate = SS($_REQUEST['startDate']);
} else {
	$startDate = date('Y-m-d', $todayTimestamp - 6*86400) ;
}
if(isset($_REQUEST['endDate'])) {
	$endDate = SS($_REQUEST['endDate']);
} else {
	$endDate = $today ;
}


$viewData = getTalismanData($startDate, $endDate);


$smarty->assign("minDate", ONLINEDATE);
$smarty->assign("maxDate", $today);
$smarty->assign("startDate", $startDate);
$smarty->assign("endDate", $endDate);
$smarty->assign("lang", $lang);
$smarty->assign("viewData", $viewData);
$smarty->display("module/basedata/talisman_data.tpl");


function getTalismanData($startDate, $endDate){
	
	$startTime = strtotime($startDate);
	$endTime = strtotime($endDate . " 23:59:59 ");
	
	$upgradeData = array();
//	$illusionData = array();
	
	//upgrade 进阶
	$sqlUpgrade = "select talisman_name as name , sum(CASE WHEN result=1 THEN 1 ELSE 0 END) as success, sum(CASE WHEN result=0 THEN 1 ELSE 0 END) as failed " .
			" from ". T_LOG_TALISMAN_UPGRADE . 
			" where mtime>={$startTime} AND mtime<={$endTime} " .
			" group by talisman_name ";
	$sqlUpgradeResult = GFetchRowSet($sqlUpgrade);
	
	if(!empty($sqlUpgradeResult)){
		foreach($sqlUpgradeResult as $k => $v){
			
			$v['all_count'] = $v['success'] + $v['failed'];
			$v['rate'] = $v['all_count'] ? round($v['success']/$v['all_count'] , 4)*100 : 0;
			
			$upgradeData[] = $v;
		}		
	}
	
	//illusion 幻化
	$sqlIllusion = " select talisman_name as name , count(distinct uuid) as active_count " .
			" from " . T_LOG_TALISMAN_ILLUSION . 
			" group by talisman_name ";
	$sqlIllusionResult = GFetchRowSet($sqlIllusion);
	
	$data = array(
		'upgrade' => $upgradeData,
		'illusion' => $sqlIllusionResult,
	);
	
	return $data;
}