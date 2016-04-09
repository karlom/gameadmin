<?php
/**
 * 直接登录玩家帐号
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';
include_once SYSDIR_ADMIN_CLASS.'/user_class.php';

global $lang;

if( PROXY == "tt" ) {
	$dictPf['tw'] = "tw";
}
$dictPf['qzone'] = '空间';
$dictPf['3366'] = '3366';
$dictPf['qqgame'] = '游戏大厅';
/*
$dictPf = array(
	'qzone' => '空间',
	'3366' => '3366',
	'qqgame' => '游戏大厅',
);
*/
$action = isset($_POST['action']) ? SS($_POST['action']) : "";

if("loginplayer" == $action){//直接登录玩家账号
    $accountName = SS($_POST['account_name']);
    $roleName = SS($_POST['role_name']);
    $pf = SS($_POST['pf']);
    if("" != $accountName || "" != $roleName){
//        $role = UserClass::getUser($roleName, $accountName);
        
        if(!$accountName){
            $api = "getuserbasestatus";

            $params = array();
	        if($accountName){
	        	$params['accountName'] = $accountName;
	        }
	        if($roleName){
	        	$params['roleName'] = $roleName;
	        }
            $result = interfaceRequest($api, $params);
            if(1 == $result['result']){
                $accountName = $result['data']['accountName'];
                $roleName = $result['data']['roleName'];
            } else if(0 === $result['result']) {
            	$msg[] = $lang->msg->userNotExists;
            } else {
            	
            }
//        } else {
//            $accountName = $role['account_name'];
//            $logType = AdminLogClass::TYPE_DIRECT_LOGIN_USER;
//        }else{
//            $msg[] = $lang->msg->userNotExists;
        }
        $logType = AdminLogClass::TYPE_DIRECT_LOGIN_USER;
    }else{
        $msg[] = $lang->msg->requireAccAndRoleName;
    }
}else if("imitation" == $action){//模拟登录
    $accountName = isset($_POST['account_name']) ? "acname".SS($_POST['account_name']) : "";
    $logType = AdminLogClass::TYPE_DIRECT_LOGIN_PLATFORM;
}

if("" != $accountName && 0 == count($msg)){
    $entranceUrl = $serverList[$_SESSION['gameAdminServer']]['entranceUrl'];
	if($entranceUrl){
        //写日志
        $log = new AdminLogClass();
        $log->Log($logType,$lang->page->accountName.":{$accountName}",'','','','');
		$timestamp = time();
		$fcm = 1;
		$fromAdmin = 1;
		$agentid = PROXYID;
		$serverid = intval(ltrim($_SESSION['gameAdminServer'], "s"));
		$ticket = md5($accountName.$timestamp.$agentid.$serverid.$fcm.GAME_TICKET_SUBFIX);
		$accountName = urlencode($accountName);
		$url = $entranceUrl."start.php?timestamp={$timestamp}&agentid={$agentid}&serverid={$serverid}&from_admin={$fromAdmin}&account={$accountName}&fcm={$fcm}&ticket={$ticket}&pf={$pf}";
		echo "<script type='text/javascript'>window.open('{$url}');</script>";
//		echo "<script type='text/javascript'>window.top.location.href='{$url}';</script>";
		//echo $url ;die();
		//header("locatin:$url");die();
	}else{
		$msg[] = $lang->msg->entranceSetError;
	}
}

$smarty->assign("lang", $lang);
$smarty->assign("msg", $msg);
$smarty->assign("dictPf", $dictPf);
$smarty->display("module/player/login_player.tpl");