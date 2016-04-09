<?php
ob_start();
session_start();
session_regenerate_id();
include_once dirname(dirname(dirname(__FILE__))) . '/protected/config/config.php';
include dirname(dirname(dirname(__FILE__))) . '/protected/config/config.key.php';
include_once SYSDIR_ADMIN_INCLUDE . '/autoload.php';
include_once SYSDIR_ADMIN_CONFIG . '/config.db.php';
include_once SYSDIR_ADMIN_CONFIG . '/config.memcache.php';
include_once SYSDIR_ADMIN_CONFIG . '/config.ver.php';
include_once SYSDIR_ADMIN_PROTECTED . '/library/dBug.php';
include_once SYSDIR_ADMIN_INCLUDE . "/db_defines.php";
include_once SYSDIR_ADMIN_INCLUDE . "/functions.php";
include_once SYSDIR_ADMIN_INCLUDE . "/db_functions.php";
global $db_mysql,$serverList,$db_admin;
	
if(!$db_admin){
	connectDB("db_admin");
}
if(!$serverList){
	$serverList = getServerList();
}

//切换数据库
$dbID = Validator::stringNotEmpty(SS($_GET['dbID']))? SS($_GET['dbID']) : 's0';
$_SESSION ['gameAdminServer'] = $dbID;
switchGameDB($dbID);

