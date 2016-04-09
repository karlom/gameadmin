<?php
/**
 * user_data.php
 * 玩家json数据
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';

$account_name = trim($_POST['account_name']);
$role_name = trim($_POST['role_name']);

if(isPost()){
	
	if(!$account_name && !$role_name) {
		$strMsg = '请输入账号名或角色名';
	}
	
	if(!$strMsg) {
		$method = "getuserbasestatus";
		$role = array(
			"roleName" => $role_name,
			"accountName" => $account_name,
		);
		$result = interfaceRequest($method, $role);
		if($result['result'] == 1){
			$role['level'] = $result['data']['level'];
			$role['ip'] = $result['data']['ip'];
			$role['accountName'] = $result['data']['accountName'];
			$role['roleName'] = $result['data']['roleName'];
		} else {
			$strMsg = '查询用户失败';
		}
	}
	
	if(!$strMsg && !empty($role)){
		if($entranceUrl = $serverList[$_SESSION['gameAdminServer']]['url']){
			$timestamp = time();
			$key = urlencode(md5($timestamp.ADMIN_GAME_AUTH_KEY));
			
			$role_name = urlencode($role['roleName']);
			$params = "timestamp={$timestamp}&key={$key}&rolename={$role_name}";
			$apiUrl = $entranceUrl."api/getUserJsonData.php";

			$jsonData = curlPost($apiUrl, $params);
			$resultArray = json_decode($jsonData,true);
//			print_r($resultArray);
			if(empty($resultArray)){
				$strMsg = '获取玩家数据失败！'.$jsonData;
			} else {
				$userData = decodeUnicode($jsonData);
			}
		}	
	}
	
}


$smarty->assign("role", $role);
$smarty->assign("userData", $userData);
$smarty->assign("lang", $lang);
$smarty->assign("strMsg", $strMsg);
$smarty->display("module/player/user_data.tpl");