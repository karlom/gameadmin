<?php
/**
 * gm_code.php
 * 后台使用GM指令
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';

$account_name = trim($_POST['account_name']);
$role_name = trim($_POST['role_name']);
$action = trim($_POST['action']);

$strMsg = array();

if(isPost()){
	
	if(!$account_name && !$role_name) {
		$strMsg[] = '请输入账号名或角色名';
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
			$role['isOnline'] = $result['data']['isOnline'] ;
			
		} else {
			$strMsg[] = '查询用户信息失败：'.$result['errorMsg'];
		}
		
	}
	
	if(!$strMsg && !empty($role) && $action == "update"){
		
		$cmd = $_POST['selectCode'];
		$input = trim($_POST['value']);
		
		if($cmd == "gmfabaolucky") {
			$value = $role['roleName'] . ";" . $input ;
		} else {
			$value = $role['roleName'] . " " . $input ;
		}
		
		$method = "AdminGm";
		
		if(!$strMsg){
			$paramArr = array(
				"cmd" => $cmd,
				"value" => $value,
			);
			$result = interfaceRequest($method, $paramArr );
			if($result['result'] == 1){
				$detail = $strMsg[] = "指令[{$cmd} {$role['roleName']} {$input}]使用成功";
			} else {
				$detail = $strMsg[] = "指令[{$cmd} {$role['roleName']} {$input}]使用失败";
			}

			$desc = " 对玩家 【".$role['roleName']."】使用GM指令：【".$dictGmCode[$cmd]['desc']."】";
			
			$log = new AdminLogClass();
			$log->Log(AdminLogClass::TYPE_USE_GM_CODE, $detail, $num, $desc, 0, $role['roleName']);		
		}
	}
}

$smarty->assign("role", $role);
$smarty->assign("dictGmCode", $dictGmCode);
$smarty->assign("change", $change);
$smarty->assign("lang", $lang);
$smarty->assign("strMsg", $strMsg);
$smarty->display("module/msg/gm_code.tpl");