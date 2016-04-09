<?php
/**
 * 踢全部玩家下线
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
global $lang;
$msg =array();
$action = SS($_POST['action']);

$online = getOnlineCount();

if(isPost()){
	
	$time = $_POST['time'];
	
	if($time > 0) {
		$countdown = $time * 60;
	} else {
		$countdown = 15;
	}
	
	for($i=$countdown;$i>=0;$i--) {
		$api = "broadcast";
		$params = array(
//			"method" => "broadcast",
			"type" => 16,
			"msg" => "游戏即将维护，请做好下线准备！{$i}",
		);
		$ret = interfaceRequest($api,$params);

		sleep(1);
	}
	
    $method = 'alluseroffline';
    $result = interfaceRequest($method);
    
	if( $result && 1 == $result['result'] ){
        //写日志
        $log = new AdminLogClass();
        $log->Log(AdminLogClass::SET_ALL_PLAYER_OFF_LINE,'','','','','');
        $msg  = $lang->msg->killAllPlayerSucc;
	}else{
	    $msg  = $result['errorMsg'];
	}
}
$killAllPlayerDes = str_replace("#serverCname#", $serverCname, $lang->msg->killAllPlayerDes);
$smarty->assign("lang",$lang);
$smarty->assign("killAllPlayerDes", $killAllPlayerDes);
$smarty->assign("msg",$msg);
$smarty->assign("online", $online);
$smarty->display("module/player/kill_all_player.tpl");


