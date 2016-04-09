<?php 
/**
 * @abstract 游戏入口参数配置
 */

// 导入配置文件
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';

global $lang;

$action = SS($_POST['action']);

$serverId = isset($_SESSION['gameAdminServer']) ? ltrim($_SESSION['gameAdminServer'], "s") : -1;

if(-1 != $serverId){
    if($entranceUrl = $serverList[$_SESSION['gameAdminServer']]['url']){
    	$timestamp = time();
    	$key = urlencode(md5($timestamp.ADMIN_GAME_AUTH_KEY));
    	
    	if("update" == $action){//更新入口参数
    		$data['websiteTitle'] = SS($_POST['websiteTitle']);
    		$data['officialWebsite'] = SS($_POST['officialWebsite']);
    		$data['webHost'] = SS($_POST['webHost']);
    		$data['serviceHost'] = SS($_POST['serviceHost']);
    		$data['resourceHost'] = SS($_POST['resourceHost']);
    		$data['ip'] = rtrim(SS($_POST['ip']), "/");
    		$data['port'] = intval($_POST['port']);
    		$data['playerQQGroup'] = SS($_POST['playerQQGroup']);
    		$data['version'] = SS($_POST['version']);
    		$data['activateCodeUrl'] = SS($_POST['activateCodeUrl']);
    		$data['bbsUrl'] = SS($_POST['bbsUrl']);
    		$data['firstPayTitle'] = SS($_POST['firstPayTitle']);
    		$data['firstPayUrl'] = SS($_POST['firstPayUrl']);
    		$data['gonglueUrl'] = SS($_POST['gonglueUrl']);
    		$data['jiHuoMaUrl'] = SS($_POST['jiHuoMaUrl']);
    		$data['payUrl'] = SS($_POST['payUrl']);
    		$data['serverListUrl'] = SS($_POST['serverListUrl']);
    		$data['gmUrl'] = SS($_POST['gmUrl']);
    		
    		$postData = urlencode(base64_encode(json_encode($data)));
			$params = "timestamp={$timestamp}&key={$key}&data={$postData}";
			$apiUrl = $entranceUrl."api/setClientVars.php";
			
			$result = json_decode(curlPost($apiUrl, $params), true);

			if(1 == $result['result']){
				$msg[] = $lang->msg->editSucc;
			}else{
				$msg[] = $lang->msg->editFailure.":".$result['errorMsg'];
			}
    	}else if("updateentrance" == $action){//设置游戏入口的开关
    		$switch = SS($_POST['switch']);
    		$params = "timestamp={$timestamp}&key={$key}&switch={$switch}";
    		$apiUrl = $entranceUrl."api/setServerStatus.php";
    		
    		$result = json_decode(curlPost($apiUrl, $params), true);
    		if(1 == $result['result']){
    			$msg[] = $lang->msg->editSucc;
    		}else{
    			$msg[] = $lang->msg->editFailure.":".$result['errorMsg'];
    		}
    	}else if("updatesimulationlogin" == $action){//设置游戏模拟登录的开关
    		$switch = SS($_POST['switch']);
    		$params = "timestamp={$timestamp}&key={$key}&switch={$switch}";
    		$apiUrl = $entranceUrl."api/setSimulationLoginStatus.php";
    		
    		$result = json_decode(curlPost($apiUrl, $params), true);
    		if(1 == $result['result']){
    			$msg[] = $lang->msg->editSucc;
    		}else{
    			$msg[] = $lang->msg->editFailure.":".$result['errorMsg'];
    		}
    	}else if("updateseveronline" == $action){//设置充值状态
    		$switch = SS($_POST['switch']);
    		$params = "timestamp={$timestamp}&key={$key}&switch={$switch}";
    		$apiUrl = $entranceUrl."api/setServerOnlineStatus.php";
    		
    		$result = json_decode(curlPost($apiUrl, $params), true);
    		if(1 == $result['result']){
    			$msg[] = $lang->msg->editSucc;
    		}else{
    			$msg[] = $lang->msg->editFailure.":".$result['errorMsg'];
    		}
    	}else if("updatecdn" == $action){//设置CDN开启状态
    		$cdn = SS($_POST['cdn']);
    		$params = "timestamp={$timestamp}&key={$key}&cdn={$cdn}";
    		$apiUrl = $entranceUrl."api/setCDNStatus.php";
    		
    		$result = json_decode(curlPost($apiUrl, $params), true);
    		if(1 == $result['result']){
    			$msg[] = $lang->msg->editSucc;
    		}else{
    			$msg[] = $lang->msg->editFailure.":".$result['errorMsg'];
    		}
    	}else if("updatefcm" == $action){//设置防沉迷开启状态
    		$fcm = intval($_POST['fcm']);
    		$api = "setfcm";
    		$params = array("fcm" => $fcm);
    		$result = interfaceRequest($api, $params);
    		if(1 == $result['result']){
    			$msg[] = $lang->msg->editSucc;
    		}else{
    			$msg[] = $lang->msg->editFailure.":".$result['errorMsg'];
    		}
    	}else if("updatemaxnum" == $action){//设置最大在线数和排队人数
    		$maxNum = intval($_POST['maxNum']);
    		$paidui = intval($_POST['paidui']);
    		$api = "setmaxnum";
    		$params = array("max" => $maxNum, "paidui" => $paidui);
    		$result = interfaceRequest($api, $params);
    		if(1 == $result['result']){
    			$msg[] = $lang->msg->editSucc;
    		}else{
    			$msg[] = $lang->msg->editFailure.":".$result['errorMsg'];
    		}
    	}else if("updatemagicbox" == $action){//设置结界开关
    		$magicbox = intval($_POST['magicbox']);
    		$api = "setmagicboxstatus";
    		$params = array("magicbox" => $magicbox);
    		$result = interfaceRequest($api, $params);
    		if(1 == $result['result']){
    			$msg[] = $lang->msg->editSucc;
    		}else{
    			$msg[] = $lang->msg->editFailure.":".$result['errorMsg'];
    		}
    	}
    
		$params = "timestamp={$timestamp}&key={$key}";
		
		$apiUrl = $entranceUrl."api/getClientVars.php";
		$clientVars = curlPost($apiUrl, $params);
		$clientVars = json_decode($clientVars, true);
		if($clientVars['result'] && $clientVars['data']){
    		foreach($clientVars['data'] as $k => $value){
    		    $config[$k] = $value;
    		}
		}else{
    		$msg[] = $lang->page->errorReason.":".$clientVars['errorMsg'];
		}

	    $config['websiteTitle'] = (isset($config['websiteTitle']) && "" != $config['websiteTitle']) ? $config['websiteTitle'] : GAME_ZH_NAME.$serverId."服";
		
//	    //获取游戏入口开关状态
//		$params = "timestamp=".time()."&key={$key}";
//		$apiUrl = $entranceUrl."api/getServerStatus.php";
//		$serverStatus = curlPost($apiUrl, $params);
//		
//	    //获取游戏服务器开服状态,1已开服 2还没开服(主要用于充值接口判断预充值)
//		$params = "timestamp=".time()."&key={$key}";
//		$apiUrl = $entranceUrl."api/getServerOnlineStatus.php";
//		$serverOnlineStatus = curlPost($apiUrl, $params);
//		
//	    //获取CDN状态,1开启,2关闭
//		$params = "timestamp=".time()."&key={$key}";
//		$apiUrl = $entranceUrl."api/getCDNStatus.php";
//		$cdnStatus = curlPost($apiUrl, $params);
		
		//获取入口开关设置状态
		$apiUrl = $entranceUrl."api/getSwitchStatus.php";
		$resultSwitchStatus = curlPost($apiUrl, $params);
		$switchStatus = json_decode($resultSwitchStatus, true);
		/*
		$api = "getfcm";
		$httpResult = interfaceRequest($api, array());
		if(1 == $httpResult['result']){
		    $fcmStatus = $httpResult['status'] ? 1 : 0;
		}else{
		    $msg[] = $lang->page->errorReason.":".$lang->msg->getFcmStatusError;
		}
		$api = "getmaxnum";
		$httpResult = interfaceRequest($api, array());
		if(1 == $httpResult['result']){
		    $maxNum = $httpResult['maxNum'];
		    $paidui = $httpResult['paidui'];
		}else{
		    $msg[] = $lang->page->errorReason.":".$lang->msg->getMaxOnlineNumError;
		}
		$api = "getmagicboxstatus";
		$httpResult = interfaceRequest($api, array());
		if(1 == $httpResult['result']){
		    $magicBoxStatus = $httpResult['status'];
		}else{
		    $msg[] = $lang->page->errorReason.":".$lang->msg->getMagicBoxStatusError;
		}
		*/
		$fcmStatus = "1";
		$maxNum = "1";
		$paidui = "1";
//		$magicBoxStatus = "1";	//结界
		
		$smarty -> assign('serverStatus', $switchStatus['server_switch']);
		$smarty -> assign('simulationLoginStatus', $switchStatus['simulation_login_switch']);
		$smarty -> assign('serverOnlineStatus', $switchStatus['server_online_switch']);
		$smarty -> assign('cdnStatus', $switchStatus['cdn_switch']);
		$smarty -> assign('fcmStatus', $fcmStatus);
		$smarty -> assign('maxNum', $maxNum);
		$smarty -> assign('paidui', $paidui);
//		$smarty -> assign('magicBoxStatus', $magicBoxStatus);
    	$smarty -> assign('lang', $lang);
    	$smarty -> assign('action', $action);
    	$smarty -> assign('config', $config);
    	$smarty -> assign('msg', $msg);
    	$smarty -> display("module/system/game_entrance_config.tpl");
    }else{
	    die($lang->msg->entranceUrlNull);
    }
}else{
	die($lang->msg->getServerIdFailure);
}