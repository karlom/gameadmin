<?php

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


$viewData = getPetData($startDate, $endDate);


$smarty->assign("minDate", ONLINEDATE);
$smarty->assign("maxDate", $today);
$smarty->assign("startDate", $startDate);
$smarty->assign("endDate", $endDate);
$smarty->assign("lang", $lang);
$smarty->assign("viewData", $viewData);
$smarty->display("module/pet/pet_data.tpl");


function getPetData( $startDate, $endDate) {
	
	$startTime = strtotime($startDate." 00:00:00 ");
	$endTime = strtotime($endDate." 23:59:59 ");
	
	$where = " mtime >= {$startTime} AND mtime <= {$endTime} ";

	//新增宠物
	$sqlNewPet = "select year,month,day, SUBSTRING_INDEX(`mdate`,' ',1) as mdate, count(*) as cnt  from t_log_pet_create where {$where} group by year,month,day ";
	$sqlNewPetResult = GFetchRowSet($sqlNewPet);
	
	//融合次数
	$sqlRonghePet = "select year,month,day, SUBSTRING_INDEX(`mdate`,' ',1) as mdate, count(*) as cnt  from t_log_pet_ronghe where {$where} group by year,month,day ";
	$sqlRonghePetResult = GFetchRowSet($sqlRonghePet);
	
	//放生宠物数
	$sqlDeletePet = "select year,month,day, SUBSTRING_INDEX(`mdate`,' ',1) as mdate, count(*) as cnt from t_log_pet_del where {$where} group by year,month,day";
	$sqlDeletePetResult = GFetchRowSet($sqlDeletePet);

	$data = array();
	$dayCount = ($endTime - $startTime)/86400 ;
	
	for($i = 0 ; $i< $dayCount; $i++) {
		$cd = $i * 86400 + $startTime;
		$day = date("Y-m-d",$cd);
		if(!empty($sqlNewPetResult)) {
			foreach($sqlNewPetResult as $k => $v) {
				if( $v['mdate'] == $day) {
					$data[$day]['create'] = $v['cnt'];
				}
			}
		}
		if(!empty($sqlRonghePetResult)) {
			foreach($sqlRonghePetResult as $k => $v) {
				if( $v['mdate'] == $day) {
					$data[$day]['ronghe'] = $v['cnt'];
				}
			}
		}
		if(!empty($sqlDeletePetResult)) {
			foreach($sqlDeletePetResult as $k => $v) {
				if( $v['mdate'] == $day) {
					$data[$day]['delete'] = $v['cnt'];
				}
			}
		}
	}
	
	return $data;

}