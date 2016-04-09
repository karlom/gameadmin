<?php
include_once '../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global_not_auth.php';
include_once SYSDIR_ADMIN_CLASS."/auth.class.php";
//退出管理后台

define('IN_ADMIN_SYSTEM', true);
$auth = new AuthClass();
$auth->logout();
header("Location:/module/login.php");