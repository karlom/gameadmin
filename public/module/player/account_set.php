<?php
/**
 * @desc 称号设置
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';

$action = $_REQUEST['action'] ? $_REQUEST['action'] : '';
$role = $_POST['role'];
$API = 'setguidtitle';

if (!empty($role)) {
	$roleName    = autoAddPrefix(SS($role['role_name']));
	$accountName = autoAddPrefix(SS($role['account_name']));
}  

if ('search' == $action) {
	if(empty($role['role_name']) && empty($role['account_name'])) {
		$msg = $lang->account->noNull;
	} else {
		$role = UserClass::getUser($role['role_name'],$role['account_name']);
		if (empty($role)) {
			if($roleName) {
				$msg = $lang->account->noPlayerRole.$roleName;
			} 
			if($accountName) {
				$msg = $lang->account->noPlayerAccount.$accountName;
			}
		} else {
			if($roleName) {
				$where = " where `role_name`= '{$roleName}' ";
			} 
			if($accountName){
				$where = " where `account_name`= '{$accountName}' ";
			}
			$sql = "select * from ".T_ACCOUNT_SET." $where";
			$rs  = GFetchRowOne($sql); 
			if($rs['etime']>time()){
				$msg = $lang->account->beSet;
			} else {
				$set = 1;
				$msg = $lang->account->roleNameSetTip;
			}
		}
	}
}elseif ('set' == $action) {
	$params = array(
		'accountName' => $accountName,	
		'roleName' => $roleName,	
		'operate' => 1,
	);
	$result = interfaceRequest($API,$params);
	if($result['result'] == 1){
		$etime = $result['data']['day']*3600*24 + time();
		$all = array(
			'role_name'	    => $result['data']['roleName'],
			'account_name'	=> $result['data']['accountName'],
			'ctime'	        => time(),
			'etime'			=> $etime,
		);
		$sql = makeInsertSqlFromArray($all, T_ACCOUNT_SET);
		GQuery($sql);
		$msg = $lang -> account -> setSuccess;
	} else {
		$msg = $result['errorMsg'];
	}
}elseif ('del'== $action ) {
	$params = array(
		'accountName' => autoAddPrefix(SS($_GET['account_name'])),	
		'roleName'    => autoAddPrefix(SS($_GET['role_name'])),
		'operate'     => 2,
	);
	$result = interfaceRequest($API,$params);
	if($result['result'] == 1){
		$result['data']['operate'];
		$delSql = " delete from ".T_ACCOUNT_SET." where `role_name`='{$result['data']['roleName']}' ";
		GQuery($delSql);
		$msg = $lang -> account -> delSuccess;
	} else {
		$msg = $result['errorMsg'];
	}
}

$sql = " select * from ".T_ACCOUNT_SET." order by `etime` desc ";
$rs  = GFetchRowSet($sql);

$data = array(
	'set'  => $set,
	'role' => $role,
	'rs'   => $rs,
	'msg'  => $msg,
);

$smarty->assign('lang',$lang);
$smarty->assign($data);
$smarty->display('module/player/account_set.tpl');
exit();


