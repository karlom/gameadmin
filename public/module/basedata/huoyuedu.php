<?php
/**
 * huoyuedu.php
 */


include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';
include_once SYSDIR_ADMIN_DICT . '/arrItemsAll.php';
include_once SYSDIR_ADMIN_DICT . '/huoyue.php';

//global $dictHuoyueReward, $dictHuoyue;

$today = date('Y-m-d');
$selectDate = isset($_POST['selectDate']) ? $_POST['selectDate'] : $today;

$maxHuoyuedu = 1000;

$viewData = getHuoyueData($selectDate);


$minDate = ONLINEDATE;
$maxDate = $today;
$smarty->assign("minDate",$minDate);
$smarty->assign("maxDate",$maxDate);
$smarty->assign("selectDate",$selectDate);
$smarty->assign("lang",$lang);
$smarty->assign("msg",$msg);

$smarty->assign("viewData", $viewData);
$smarty->display("module/basedata/huoyuedu.tpl");


function getHuoyueData($date) {
	global $dictHuoyueReward, $dictHuoyue, $maxHuoyuedu,$arrItemsAll;
	
	$startTime = strtotime($date." 00:00:00 ");
	$endTime = strtotime($date." 23:59:59 ");
	
	$where = " mtime >= {$startTime} AND mtime <= {$endTime} ";
	
	$huoyueduArr = array();
	$finishArr = array();
	
	
	$rewardArr = array();	//可领礼包活跃度
	$rewardTakeArr = array();	//各礼包领取情况
	
	foreach($dictHuoyueReward as $key => $val){
		$rewardTakeArr[$val['item_id']]['name'] = $arrItemsAll[$val['item_id']]['name'];
		$rewardTakeArr[$val['item_id']]['item_id'] = $val['item_id'];
		$rewardTakeArr[$val['item_id']]['taked'] = 0;
		$rewardTakeArr[$val['item_id']]['all'] = 0;
		$rewardTakeArr[$val['item_id']]['rate'] = 0;
	}
	
	//玩家活跃度
	$sqlHuoyuedu = "select uuid,sum(huoyuedu) as huoyuedu from " . T_LOG_HUOYUE . " where {$where} group by uuid ";
	$sqlHuoyueduResult = GFetchRowSet($sqlHuoyuedu);
	
	if(!empty($sqlHuoyueduResult)) {
		
		for($i = 50 ; $i<=$maxHuoyuedu ; $i+=50) {
			foreach($sqlHuoyueduResult as $k => $v) {
				if($v['huoyuedu'] >= $i ) {
					$huoyueduArr[$i] ++ ;
				}
			}			
		}
		//达到领奖条件玩家
		foreach($dictHuoyueReward as $k => $v ){
			foreach($sqlHuoyueduResult as $j => $w) {
				if($w['huoyuedu'] >= $v['huoyuedu'] ) {
					$rewardArr[$v['huoyuedu']] ++ ;
				}
			}
		}
	}
	
	//活跃行动完成率
	$sqlHyFinish = "select act_id, count(*) as finish_count, count(distinct uuid) as role_count  from " . T_LOG_HUOYUE . " where {$where} group by act_id ";
	$sqlHyFinishResult = GFetchRowSet($sqlHyFinish);
	$sqlOnline = "select count(distinct uuid) as role_count from t_log_login where {$where} AND level>=40 ";
	$sqlOnlineResult = GFetchRowOne($sqlOnline);

	$roleCount = 0;
	
	if(!empty($sqlHyFinishResult)) {
		foreach($sqlHyFinishResult as $v ){
			$roleCount += $v['role_count'];
		}
	}
		
	if($sqlOnlineResult['role_count'] > $roleCount) {
		$roleCount = $sqlOnlineResult['role_count'];
	} 
	
	if(!empty($sqlHyFinishResult) && !empty($roleCount) ) {
		foreach($sqlHyFinishResult as $k => $v) {
			
			$rate = $dictHuoyue[$v['act_id']]['count'] ? $v['finish_count'] / $dictHuoyue[$v['act_id']]['count'] / $roleCount :0;
			
			$finishArr[$v['act_id']]['name'] = $dictHuoyue[$v['act_id']]['name'];
			$finishArr[$v['act_id']]['rate'] = round($rate,4)*100;
		}
	}
	
	//活跃奖励礼包领取率
	//达到领奖条件玩家
//	$sqlHyRewardTake = "select uuid,sum(huoyuedu) as huoyuedu from " . T_LOG_HUOYUE . " where {$where} group by uuid having huoyuedu>=100 ";
//	$sqlHyRewardTakeResult = GFetchRowSet($sqlHyRewardTake);
	//已经领取奖励礼包的玩家数 
	$sqlTake = "select item_id, sum(item_num) as take_count from t_log_item where {$where} AND item_num>0 AND `type`=10091 AND item_id>= 13000 AND item_id<= 13005 group by item_id";
	$sqlTakeResult = IBFetchRowSet($sqlTake);
	
	foreach($dictHuoyueReward as $k => $v) {

		if(!empty($sqlTakeResult) ) {
			foreach($sqlTakeResult as $j => $w){
				if($w['item_id'] == $v['item_id']) {
					$rewardTakeArr[$v['item_id']]['taked'] = $w['take_count'];
				}
			}
		}
		foreach($rewardArr as $j => $w){
			if($v['huoyuedu'] == $j) {
				$rewardTakeArr[$v['item_id']]['all'] = $w;
			}
		}
			
	}
	
	foreach($rewardTakeArr as $key => $val){
		if($val['all'] != 0 ) {
			$rewardTakeArr[$key]['rate'] = round($val['taked']/$val['all'], 4)*100 ;
		}
	}
	
	$data = array(
		'huoyue' => $huoyueduArr,
		'finishRate' => $finishArr,
		'rewardTakeRate' => $rewardTakeArr,
//		'rewardArr' => $rewardArr,
	);
	
	return $data;
}