<?php
header ( 'Content-Type: text/html; charset=UTF-8' );
session_start ();
session_regenerate_id();
//if (! $_SESSION ['username']) {
//	header ( 'Location:/module/login.php' );
//	exit ();
//}
include_once SYSDIR_ADMIN_INCLUDE . '/autoload.php';
include_once SYSDIR_ADMIN_CONFIG . '/config.db.php';
include_once SYSDIR_ADMIN_CONFIG . '/config.memcache.php';
include_once SYSDIR_ADMIN_CONFIG . '/config.ver.php';
include_once SYSDIR_ADMIN_PROTECTED . '/library/dBug.php';
include_once SYSDIR_ADMIN_INCLUDE . "/db_defines.php";
//include_once SYSDIR_ADMIN_CLASS . "/mysql.class.php";
include_once SYSDIR_ADMIN_INCLUDE . "/functions.php";
include_once SYSDIR_ADMIN_INCLUDE . "/db_functions.php";
//include_once SYSDIR_ADMIN_CLASS . "/auth.class.php";
include_once SYSDIR_ADMIN_LIBRARY . "/smarty/Smarty.class.php";
//include_once SYSDIR_ADMIN_CLASS . '/admin_log_class.php';
//include_once SYSDIR_ADMIN_CLASS . "/Language.class.php";
//include_once SYSDIR_ADMIN_CLASS . "/Help.class.php";
//include_once SYSDIR_ADMIN_CLASS . "/Datatime.php";
include_once SYSDIR_ADMIN_LANG . "/zh-cn.php";

if(file_exists(SYSDIR_ADMIN_GAME_CONFIG."/".GAME_EN_NAME."/base_config.php")){
	include_once(SYSDIR_ADMIN_GAME_CONFIG."/".GAME_EN_NAME."/base_config.php");
}

global $smarty, $auth, $db_mysql, $lang;
//初始化语言对象
if (! is_object ( $lang )){
	$lang = new language ();
}
//new dBug($lang);

//时间设置
date_default_timezone_set ( 'PRC' );
//初始化数据库连接


//更新最后操作时间
$_SESSION ['last_op_time'] = time ();

//初始化管理后台数据库连接(mysql)
//if (! $db_admin) {
//	$db_admin = new DBMysqlClass ();
//	$db_admin->connect ( $dbConfig ['game_admin'] );
//}

include_once SYSDIR_ADMIN_CONFIG . "/base.config.php";

if (! $auth) {
	$auth = new AuthClass ();
}
if (! $auth->auth () || ! $_SESSION ['username']) {
    echo '<script type="text/javascript">window.open( "/module/login.php", "_top");</script>';
//	header ( "Location:/module/login.php" );
	exit ();
}

//$gameAdminServer =  SS($_GET['gameadmin_server']);
$gameAdminServer =  addslashes($_GET['gameadmin_server']);
if("" != $gameAdminServer){
	$_SESSION['gameAdminServer'] = $gameAdminServer;
    echo '<script type="text/javascript">window.open( "/module/index.php", "_top");</script>';
}

$execFile = realpath ( $_SERVER ['SCRIPT_FILENAME'] );
if (! in_array ( $execFile, $ADMIN_LOGIN_USER_ACCESS )) {
	$auth->assertModuleAccess ( $execFile );
}

if(!$serverList){
	$serverList = getServerList();
}
if($gameAdminServer){
	$_SESSION['adminver'] = $serverList[$gameAdminServer]['ver'];
}else{
	if(!isset($_SESSION['gameAdminServer'])){
		$index = 1;
		if(!empty($serverList)){
			foreach ( $serverList as $sid => $configData ){
				if($index === 1 && $sid != 's0'){
					$gameAdminServer = $sid;
					$index = $index+1;
					$_SESSION['gameAdminServer'] = $gameAdminServer;
					break;
				}
			}
		}
	}
}
//服务器别名
$serverCname = $serverList[$_SESSION['gameAdminServer']]['name'] ? $serverList[$_SESSION['gameAdminServer']]['name'] : $_SESSION['gameAdminServer'];

define( "ONLINEDATE", $serverList[$_SESSION ['gameAdminServer']]['onlinedate']);

//初始化smarty
$smarty = new Smarty ();
$smarty->compile_check = SMARTY_COMPILE_CHECK; 
$smarty->force_compile = SMARTY_FORCE_COMPILE;
$smarty->template_dir = SYSDIR_ADMIN_SMARTY_TEMPLATE;
$smarty->compile_dir = SYSDIR_ADMIN_SMARTY_TEMPLATE_C;
$smarty->left_delimiter = SMARTY_LEFT_DELIMITER;
$smarty->right_delimiter = SMARTY_RIGHT_DELIMITER;
$smarty->debuging = true;
