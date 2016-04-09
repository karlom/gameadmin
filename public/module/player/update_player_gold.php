<?php
/**
 * update_player_gold.php
 * 修改玩家仙石、绑定仙石
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';

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
			
			$paramArr = array(
				"roleName" => $role['roleName'],
				"accountName" => $role['accountName'],
				"MoneyType" => 1, //仙石
				"MoneyCount" => 0, //0表示不修改
			);
			$result = interfaceRequest("updateMoney", $paramArr );
			if($result['result'] == 1){
				$role['xianshi'] = $result['data']['newMoneyCount'];
			} else {
				$strMsg[] = '查询用户仙石失败: '.$result['errorMsg'];
			}
			
			$paramArr['MoneyType'] = 2;
			$result = interfaceRequest("updateMoney", $paramArr );
			if($result['result'] == 1){
				$role['bindXianshi'] = $result['data']['newMoneyCount'];
			} else {
				$strMsg[] = '查询用户绑定仙石失败: '.$result['errorMsg'];
			}
			
		} else {
			$strMsg[] = '查询用户信息失败';
		}
		
	}
	
	if(!$strMsg && !empty($role) && $action == "update"){
		$money = intval($_POST['money']);
		$opera = $_POST['opera'];
		$num = abs($_POST['num']);
		
		if($opera == 1) {
			$num = $num;
		} else if ($opera == 2) {
			$num = -$num;
		} else {
			$strMsg[] = "Attack!";
		}
		
		if(!$strMsg){
			$paramArr = array(
				"roleName" => $role['roleName'],
				"accountName" => $role['accountName'],
				"MoneyType" => $money, //仙石类型
				"MoneyCount" => $num, //0表示不修改
			);
			$result = interfaceRequest("updateMoney", $paramArr );
			if($result['result'] == 1){
				$change = true;
				if($money == 1){
					$role['xianshi'] = "<font color='red'>".$result['data']['newMoneyCount']."</font>";
					$role['oldXianshi'] = "<font color='blue'>".$result['data']['oldMoneyCount']."</font>";
					
					$role['oldBindXianshi'] = $role['bindXianshi'];
					
					$strMsg[] = '修改用户【仙石】成功！';
				} else {
					$role['bindXianshi'] = "<font color='red'>".$result['data']['newMoneyCount']."</font>";
					$role['oldBindXianshi'] = "<font color='blue'>".$result['data']['oldMoneyCount']."</font>";
					
					$role['oldXianshi'] = $role['xianshi'];
					
					$strMsg[] = '修改用户【绑定仙石】成功！';
				}
			} else {
				if($money == 1){
					$strMsg[] = '修改用户【仙石】失败！';
				} else {
					$strMsg[] = '修改用户【绑定仙石】失败！';
				}
			}
			$isBind =  $money==1 ? '【仙石】': '【绑定仙石】';
			$isAdd =  $opera==1 ? '增加': '扣除';
			
			$detail = '类型：'.$isBind.'，数量：'.$num.'，账号角色：['.$role['accountName'].']['.$role['roleName'].']';
			$desc = $isAdd." 玩家 【".$role['roleName']."】".$num."个".$isBind;
			$log = new AdminLogClass();
			$log->Log(AdminLogClass::SET_PLAYER_GOLD, $detail, $num, $desc, 0, $role['roleName']);		
		}
	}
}

$smarty->assign("role", $role);
$smarty->assign("change", $change);
$smarty->assign("lang", $lang);
$smarty->assign("strMsg", $strMsg);
$smarty->display("module/player/update_player_gold.tpl");