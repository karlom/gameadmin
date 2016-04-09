<?php
/**
*	Description:获取服务器中的管理服数据，一个是开服ID，一个是开服日期，一个是是否可用。
*/

ob_start();
session_start();
session_regenerate_id();
include_once dirname(dirname(dirname(__FILE__))) . '/../protected/config/config.php';
include dirname(dirname(dirname(__FILE__))) . '/../protected/config/config.key.php';
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
	try {
		$sql = " select id,onlinedate,available,url,port,combinedate  from `t_server_config` where id>10000 order by id";
		$result = IFetchRowSet($sql);
		$result = serialize($result);
		echo $result;
	} catch (Exception $e) {
		// 数据库中不记录具体失败原因，失败日志放在log文件中
//		$centralLog->failed(CENTRAL_LOG_QUERY_SQL_ERROR, $e->getMessage());
	}
//$centralLog->end();
exit();

