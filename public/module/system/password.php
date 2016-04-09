<?php
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';
$auth->assertModuleAccess(__FILE__);

$userid = $auth->userid();
$username = $auth->username();
$smarty->assign('username', $username);

if(!$userid) {
	die('不可修改此用户的密码');
}

if ($_POST['action'] == 'update')
{
	$oldpass = trim($_POST['oldpass']);
	$newpass1 = trim($_POST['newpass1']);
	$newpass2 = trim($_POST['newpass2']);
	$validResult = checkPasswdRate($newpass1);
	if (0 == $validResult) {
		$msg[] = '新密码长度太短！';
		display($msg);
	}elseif (1 == $validResult){
		$msg[] = '新密码强度太弱，太容易被破解了！';
		display($msg);
	}
	if ($newpass1 != $newpass2) {
		$msg[] = '两次输入的密码不一致！';
		display($msg);
	}
	if ($oldpass == $newpass1) {
		$msg[] = '输入的新旧密码一样，不执行修改！';
		display($msg);
	}
	$md5old = strtolower(md5($oldpass));
	$md5new = strtolower(md5($newpass1));
	$sql = "SELECT * FROM `".T_ADMIN_USER."` WHERE `uid`='{$userid}' AND `passwd`='{$md5old}' LIMIT 1";
	$result = IFetchRowOne($sql);
	if ($result['uid'] != $userid) {
		$msg[] = '旧密码错误';
		display($msg);
	}
	$now = time();
	$sql = "UPDATE `".T_ADMIN_USER."` SET `passwd`='{$md5new}',`last_change_passwd`={$now} WHERE `uid`='{$userid}' LIMIT 1";
	if ($result = IQuery($sql)) {
		$log = new AdminLogClass();
		$log->Log(AdminLogClass::TYPE_SYS_MODIFY_ADMIN_PASSWORD, '', 0, '', 0, $username);
		$_SESSION['last_change_passwd'] = $now;
		$msg = array('修改密码成功');
		$changeOk = true;
	} else {
		$msg[] = '修改密码出错，请联系管理员解决！';
	}
	display($msg, $changeOk);
} else {
    if (time() - $_SESSION['last_change_passwd'] > 60 * 86400) {
        $msg[] = '新帐号要求改密码 或 已经超过60天未更改密码了。请及时更改密码，以确保帐号安全。';
    }
    $now = time();
    $sql = "UPDATE `" . T_ADMIN_USER . "` SET `last_change_passwd`={$now} WHERE `uid`='{$userid}' LIMIT 1";
    if ($result = IQuery($sql)) {
        $_SESSION['last_change_passwd'] = $now;
    }
    display($msg);
} 
//==============

function display($msg,$changeOk=false)
{
	$data = array(
		'changeOk'=>$changeOk,
		'errorMsg'=>is_array($msg) ? implode('<br>',$msg) : '' ,
	);
	render('module/system/password.tpl',$data);
	die();
}
