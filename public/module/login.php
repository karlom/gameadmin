<?php
include_once '../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global_not_auth.php';
include_once SYSDIR_ADMIN_CLASS."/admin_log_class.php";
include_once SYSDIR_ADMIN_CLASS."/auth.class.php";

$isPost = isPost();
$action = $isPost ? trim($_POST['action']) : trim($_GET['action']);

global $auth;
if (!$auth) {
	$auth = new AuthClass();
}

if ('logout'==$action) {
	$auth->logout();
	header("Location:/module/login.php");
	exit();
}else {
	if ($_SESSION['username']) {
		header("Location:/module/index.php");
		exit();
	}
	if ($isPost) {
		$username = SS($_POST['username']);
		$password = SS($_POST['password']);
		$checkcode = trim($_POST['checkcode']);
		
		$errorMsg = '';
		if (!$username || !$password) {
			$errorMsg = '用户名、密码不能为空！';
		}
		if ( ''==$errorMsg && CHECK_CODE_SWITCH && strtolower($checkcode) != strtolower($_SESSION['admin_checkcode'])) {
			$errorMsg = '验证码不正确！';
		}
		if ( ''==$errorMsg && !$auth->login($username, $password)) {
			$errorMsg = '用户名或者密码错误，请重新输入！';
		}
		if ( ''==$errorMsg ) {
			//写日志
			$log = new AdminLogClass();
			$log->Log(AdminLogClass::TYPE_SYS_LOGIN,'','','','','');
			if (time() - $_SESSION['last_change_passwd'] > 60 * 86400) {
				header("Location:/module/system/password.php");//若已经太久没改密码，跳转到修改密码页
			}else {
				header("Location:/module/index.php");//登录成功，跳转到首页
			}
		}
	}
	$data = array(
		'errorMsg'=> $errorMsg,
		'CHECK_CODE_SWITCH'=>CHECK_CODE_SWITCH,
	);
	render('login.html', $data);
}