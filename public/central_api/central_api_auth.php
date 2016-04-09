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
//参数 md5 和 参数 time ，是用于验证传递的其它参数的有效性的
$_md5 = SS($_REQUEST['md5']);

//if (empty ($_md5))
//	die('md5');
//
//$_time = SS($_REQUEST['time']);
//if (empty ($_time))
//	die('time');
	
$testMode = intval($_REQUEST['is_test']);

$RRR = $_GET;
unset($RRR['md5']);
unset($RRR['time']);

$centralKey = null;
if ($testMode) {
	$centralKey = CENTRAL_API_MD5_KEY_TEST;
} else {
	$centralKey = CENTRAL_API_MD5_KEY;
}

$str = $centralKey . '#' . $_time ;
foreach($RRR as $k => $v)
{
	$str .= '#' . $k . '|' . $v;
}

//切换数据库
$serverID = Validator::stringNotEmpty(SS($_GET['serverID']))? SS($_GET['serverID']) : 's0';
$_SESSION ['gameAdminServer'] = $serverID;
switchGameDB($serverID);
//if ($_md5 !== md5($str))
//	die('md5 fail');


//if ($_time + 3600 < time()) //超过1个钟，连接则失效
//	die('timeout');

unset($_md5);
unset($_time);
unset($str);
