<?php
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';


if(isPost()){
	$action = $_POST['action'];
	$date = $_POST['onlinedate'];
	
	$params = array();
	if ( $action == "settime" ) {
		if(!empty($date) && $time = strtotime($date)) {
			$params['type'] = 1;
			$params['year'] = intval(date("Y",$time));
			$params['month'] = intval(date("m",$time));
			$params['day'] = intval(date("d",$time));	
		} else {
			$msg = "日期错误";
			die();
		}

	} else if ( $action == "cleantime" ) {
		$params['type'] = 2;
	}
	
	$result = interfaceRequest("mergetime",$params );
	if($result['result'] == 1) {
		$msg = $lang->verify->opSuc;
	} else {
		$msg = $result['msg'];
	}
}

$result = interfaceRequest("mergetime", array("type" => 3,) );

if($result['result'] == 1) {
	if($result['time'] == 0) {
		$onlineDate = 0;
	} else {
		$onlineDate = date("Y-m-d", $result['time']);
	}
}

$attention = "注意，这里是 ".$serverCname." 服，如不清楚合服时间作用请不要随便操作！";

$smarty->assign("today",date("Y-m-d"));
$smarty->assign("lang",$lang);
$smarty->assign("attention", $attention);
$smarty->assign("msg",$msg);
$smarty->assign("onlineDate", $onlineDate);
$smarty->display("module/system/change_combine_time.tpl");