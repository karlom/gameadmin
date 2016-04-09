<?php
/**
 * @desc 引用此文件，则不验证用户是否登录。用于那些不需要登录可使用的功能
 */
header('Content-Type: text/html; charset=UTF-8');
session_start();
session_regenerate_id();
//时间设置
date_default_timezone_set('PRC');

include_once SYSDIR_ADMIN_INCLUDE . '/autoload.php';
include_once SYSDIR_ADMIN_CONFIG . '/config.db.php';
include_once SYSDIR_ADMIN_INCLUDE."/db_defines.php";
include_once SYSDIR_ADMIN_CLASS."/mysql.class.php";
//include_once SYSDIR_ADMIN_CLASS."/infobright.class.php";
include_once SYSDIR_ADMIN_INCLUDE."/functions.php";
include_once SYSDIR_ADMIN_INCLUDE."/db_functions.php";
include_once SYSDIR_ADMIN_LIBRARY."/smarty/Smarty.class.php";
include_once SYSDIR_ADMIN_CONFIG . '/config.memcache.php';

//include_once SYSDIR_ADMIN_CLASS."/user_class.php";
//include_once SYSDIR_ADMIN_CLASS.'/cache.class.php';

global $smarty, $db_log, $db_admin;

//初始化smarty
$smarty = new Smarty();
$smarty->compile_check = SMARTY_COMPILE_CHECK;
$smarty->force_compile = SMARTY_FORCE_COMPILE;
$smarty->template_dir = SYSDIR_ADMIN_SMARTY_TEMPLATE;
$smarty->compile_dir = SYSDIR_ADMIN_SMARTY_TEMPLATE_C;
$smarty->left_delimiter = SMARTY_LEFT_DELIMITER;
$smarty->right_delimiter = SMARTY_RIGHT_DELIMITER;

//初始化管理后台数据库连接(mysql)
//if(!$db_admin) {
//	$db_admin =  new DBMysqlClass();
//	$db_admin->connect($dbConfig['game_admin']);
//}

if(!$serverList){
	$serverList = getServerList();
}