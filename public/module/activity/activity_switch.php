<?php
/**
 * activity_switch.php
 * 活动开关
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';

$dictStatus = array(
	'0' => '未开启',
	'1' => '进行中',
//	'2' => '已结束',
);

//遗迹寻宝，仙邪问鼎，不灭试炼，晶幻洞天，魔物暴动
//
//300,301,302,303,304

$today = date('Y-m-d');
$strMsg = "";

$activityStatus = array(
	'2' => array( 'copy_id' => 300, 'name' => '遗迹寻宝', 'status' => '0', 'start_time' => '(每天19:00 - 19:20)', ),
	'3' => array( 'copy_id' => 301, 'name' => '仙邪问鼎', 'status' => '0', 'start_time' => '(每天20:00 - 20:15、20:25 - 20:40)', ),
	'4' => array( 'copy_id' => 302, 'name' => '不灭试炼', 'status' => '0', 'start_time' => '(每天15:00 - 15:30)', ),
	'1' => array( 'copy_id' => 303, 'name' => '晶幻洞天', 'status' => '0', 'start_time' => '(每天13:00 - 13:30、16:00 - 16:30、22:00-22:30)', ),
	'5' => array( 'copy_id' => 304, 'name' => '魔物暴动', 'status' => '0', 'start_time' => '(每天21:00 - 21:30)', ),
);


$statusResult = @interfaceRequest("queryact", array() );

if( isset($statusResult['result']) && $statusResult['result'] == 1 ) {
	if( !empty($statusResult['activity']) ) {
		foreach( $statusResult['activity'] as $v ) {
			$activityStatus[$v]['status'] = '1' ;
		}
	}
} else {
	$strMsg = $statusResult['msg'];
}

if(isPost()){
	$id = isset($_POST['id']) ? trim($_POST['id']) : 0;
	
	if(empty($id)) {
		die("ID error.");
	}
	
	if( isset($_POST['open']) && !empty($_POST['open']) ){
		$api = "startact";
		if( !empty($id) ) {
			$param = array( "actType" => intval($id), );
			$result = @interfaceRequest($api, $param);
			
			if($result['result'] == 1 ) {
				$activityStatus[$id]['status'] = 1;
				$strMsg = "活动【".$activityStatus[$id]['name']."】开启成功！";
			} else {
				$strMsg = "活动【".$activityStatus[$id]['name']."】开启失败！ ". $result['msg'];
			}
			
		} 
	} else if ( isset($_POST['close']) && !empty($_POST['close']) ){
		$api = "endact";
		if( !empty($id) ) {
			$param = array( "actType" => intval($id), );
			$result = @interfaceRequest($api, $param);
			
			if($result['result'] == 1 ) {
				$activityStatus[$id]['status'] = 0;
				$strMsg = "活动【".$activityStatus[$id]['name']."】关闭成功！";
			} else {
				$strMsg = "活动【".$activityStatus[$id]['name']."】关闭失败！ ". $result['msg'];
			}
			
		} 
	} else {
		echo "param error, stoped. ";
		exit ;
	}
	
}

$ret = interfaceRequest("getopentime");
if($ret['result'] == 1) {
	$onlinedate = $ret['time'] ? date("Y-m-d", $ret['time']) : 0;
} else {
	$onlinedate = "*获取失败*";
}

$smarty->assign('dictStatus', $dictStatus );
$smarty->assign('strMsg', $strMsg );

$smarty->assign('activityStatus', $activityStatus );
$smarty->assign('lang', $lang );
$smarty->assign('onlinedate', $onlinedate );
$smarty->assign('minDate', ONLINEDATE );
$smarty->assign('maxDate', $today );
$smarty->display( 'module/activity/activity_switch.tpl' );
