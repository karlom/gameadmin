<?php
/**
*	Description:付费用户最近登录数据，不需要指定时间
*/

define('IN_ADMIN_SYSTEM', true);
//include_once "../../../protected/config/config.php";
//include_once SYSDIR_ROOT . '/class/db.class.php';
include '../central_api_auth.php';
//include SYSDIR_ADMIN.'/class/central.log.php';

/*
$sql = " SELECT pp.account_name,pp.role_name,pp.role_id,MAX(last_login_time) AS max_login_time 
from {$table1} pp , {$table2} rp where pp.role_id = rp.role_id {$whereDate} GROUP BY pp.role_id";
*/
// 搜索指定时间内的玩家登录日志, [$beginTime,$endTime) 防止数据丢失和重复！！
try {

	$sql = "SELECT MAX(t1.mtime) last_login_time, t1.ip, t1.role_id, t1.role_name, t1.account_name FROM " . T_LOG_LOGIN . " t1 RIGHT JOIN " . T_LOG_PAY . " t2 ON t1.role_name = t2.role_name GROUP BY t1.role_name;";
	$result = GFetchRowSet($sql);
	echo serialize($result);
//	$centralLog->end();
} catch (Exception $e) {
	// 数据库中不记录具体失败原因，失败日志放在log文件中
//	$centralLog->failed(CENTRAL_LOG_QUERY_SQL_ERROR, $e->getMessage());
}
exit();
