<?php
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';
include_once SYSDIR_ADMIN_CLASS.'/admin_user.class.php';
include_once SYSDIR_ADMIN_CLASS."/admin_group.class.php";

$action = SS($_REQUEST['action']);

if ('enabled' == $action) {
	$uid = intval($_GET['id']);
	$username = SS($_GET['username']);
	$now = time();
	$sql = " update ".T_ADMIN_USER." set `user_status`=1, `last_login_time`={$now} where `uid`={$uid} and `username`='{$username}' ";
	IQuery($sql);
}

if ('disabled' == $action) {
	$uid = intval($_GET['id']);
	$username = SS($_GET['username']);
	$sql = " update ".T_ADMIN_USER." set `user_status`=0  where `uid`={$uid} and `username`='{$username}' ";
	IQuery($sql);
}


//显示添加，编辑界面
if($action == 'add' || $action == 'modify')
{
	if (isset($_GET['id']))
	{
		$uid = intval($_GET['id']);
		$enum = AdminUserClass::enum();
		$udata = $enum[$uid];
		$smarty->assign("udata", $udata);
		$smarty->assign("uid",$uid);
	}
	$groups = AdminGroupClass::enum();
	if (is_array($groups)) {
		foreach($groups as $groupid => $group) {
			if(!$auth->assertAdminGroupAccess($groupid)) {
				unset($groups[$groupid]);
			}
		}
	}
	$smarty->assign("groups", $groups);
	$smarty->assign("action", $action);
	$smarty->display("module/system/admin_user_edit.tpl");
	exit;
}

if($action == 'add_submit')
{
	$username = trim($_POST['username']);
	$password = trim($_POST['passwd']);
	$validUserName = validUsername($username);
	$validPassword = validPassword($password);
	if (true !== $validUserName) {
		die($validUserName);
	}
	if (true !== $validPassword) {
		die($validPassword);
	}
	if (strlen($password) < 6){
		die('密码要求至少6位');
	}
	$comment = SS(trim($_POST['comment']));
	if (empty($comment)){
		die('描述说明不能为空');
	}
	$sqlChkExist = "SELECT `uid` FROM `".T_ADMIN_USER."` WHERE `username`='{$username}' ";
	$rsChkExist = IFetchRowOne($sqlChkExist);
	if ($rsChkExist['uid']) {
		die("用户名 {$username} 已经被使用");
	}
	$uid = AdminUserClass::create($username, $password, $comment);
	if(!empty($_POST['groupid']))
	{
		$groupid = intval($_POST['groupid']);
		AdminUserClass::changeGroup($uid, $groupid);
		$log = new AdminLogClass();
		$desc = '权限组：'.$groupid;
		$log->Log(AdminLogClass::TYPE_SYS_CREATE_ADMIN, $desc, 0, '', 0, $username);
	}
	if($uid){
		echo "添加新用户 {$username} 成功";
	}
}

if($action == 'modify_submit')
{
	$uid = intval($_GET['id']);
	$enum = AdminUserClass::enum();
	$udata = $enum[$uid];
	if(!$udata) {
		die('用户不存在');
	}

	$password = trim($_POST['passwd']);
	if ($password) {
		$validPassword = validPassword($password);
		if (true !== $validPassword) {
			die($validPassword);
		}
		if (strlen($password) < 6){
			die('密码要求至少6位');
		}
		$password = md5($password);
	}else {
		$password = null;
	}

	$comment = SS(trim($_POST['comment']));
	if (empty($comment)){
		$comment = null;
	}
	if(!empty($_POST['groupid'])) {
		$groupid = intval($_POST['groupid']);
	} else{
		$groupid = null;
	}
	if(AdminUserClass::update($uid, $password, $groupid, $comment)) {
		$log = new AdminLogClass();
		if($groupid !== null) {
			$desc = '权限组：'.$groupid;
			$log->Log(AdminLogClass::TYPE_SYS_MODIFY_ADMIN_GROUPID, $desc, 0, '', 0, $username);
		}
		if($password !== null) {
			$log->Log(AdminLogClass::TYPE_SYS_MODIFY_ADMIN_PASSWORD, '', 0, '', 0, $username);
		}
	}
	echo "修改成功";
}

$enum = AdminUserClass::enum();
$admins = gen_admins($enum);
foreach($admins as $key => $user)
{// 最后检查数组，把没有记录的移除。
    if(!isset($user['uid']))
    {       
        unset($admins[$key]);
    }
}

$adminList = get_admin_list('all');

if(isPost() && isset($_POST['selectItem']) && isset($_POST['adminList']) ){

	$list = $_POST['adminList'];
	$users = $_POST['selectItem'];
	
	if(!empty($list)){
		foreach($list as $v){
			$syncTolist[$v] = $adminList[$v];
		}
	}
	if(!empty($users)){
		foreach($users as $v){
			$syncUsers[$v] = $enum[$v];
			unset($syncUsers[$v]['uid']);
			unset($syncUsers[$v]['groupname']);
		}
	}
	
//	print_r($syncUsers);
	if($syncTolist && $syncUsers) {
		foreach($syncTolist as $v){
			
	    	//向后台API请求
//			print_r($syncUsers);
	    	$timestamp = time();
	    	$key = urlencode(md5($timestamp.ADMIN_GAME_AUTH_KEY));
	    	$jsonBanList = urlencode(decodeUnicode(json_encode($syncUsers)));
	    	
	    	$action = "sync";
	    	
	    	$paramStr = "timestamp={$timestamp}&key={$key}&action={$action}&jsonBanList={$jsonBanList}";
			$apiUrl = rtrim($v['url'], '/').'/api/rsync_admin_user.php';
			
			$resultJson = curlPost($apiUrl, $paramStr);
			
			$result = json_decode($resultJson, true);
			
			if($result['result'] == 1){
				$msg[] = "成功同步到【{$v['name']}】.";
			} else {
				$msg[] = "同步到【{$v['name']}】 出错！";
			}
//			var_dump($resultJson);
		}
	}
}
//print_r($admins);
$smarty->assign("enum", array_values($admins));
$smarty->assign("adminList", $adminList);
$smarty->assign("msg", $msg);
$smarty->display("module/system/admin_user_list.tpl");
exit;

function gen_admins($enum) {
	global $auth;
	$admins = array();
	foreach($enum as $uid => $udata) {
		if($auth->assertAdminGroupAccess(intval($udata['groupid']))) {
			$admins[$uid] = $udata;
    		if ( 0 == $udata['user_status'] ) {
    			$admins[$uid]['user_status_str'] = '已被禁用';
    		}elseif ((time() - $udata['last_login_time'])  > LOGIN_FROST_TIME * 86400) {
    			$admins[$uid]['user_status_str'] = '超'.LOGIN_FROST_TIME.'天未登录被系统冻结';
    			$admins[$uid]['user_status'] = 2 ;
    		}else{
    			$admins[$uid]['user_status_str'] = '正常';
    		}
    		$admins[$uid]['last_login_time'] =  date('Y-m-d H:i',$udata['last_login_time'] );
		}
	}
	return $admins;
}

function get_admin_list($all="") {
	if(!$all){
		$where = "where available=1";
	}
	$sql = "select * from t_admin_list {$where}";
	$list = IFetchRowSet($sql);
	
	$data = array();
	if(!empty($list)){
		foreach($list as $v ){
			$data[$v['id']] = $v;
		}
	}
	
	return $data;
}
