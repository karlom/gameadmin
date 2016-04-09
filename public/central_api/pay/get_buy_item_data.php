<?php
/**
*	Description:获取道具购买统计，从t_log_gold表中读取数据
*/

define('IN_ADMIN_SYSTEM', true);
//include_once "../../../protected/config/config.php";
//include_once SYSDIR_ROOT . '/class/db.class.php';
include '../central_api_auth.php';
//include SYSDIR_ADMIN.'/class/central.log.php';


	
$beginTime = intval($_GET['begin']);
$endTime = intval($_GET['end']);
$tuoString = $_GET['tuoString'];
if($tuoString){
	$tuoString = str_replace("\\", "", $tuoString);
	$tuoString = str_replace("[", "", $tuoString);
	$tuoString = str_replace("]", "", $tuoString);
	$tuoString = str_replace("\"", "'", $tuoString);

}

// 默认发送昨天的充值数据
if ($beginTime == 0) {
	$beginTime = strtotime('today -1 day');
}
if ($endTime == 0) {
	$endTime = strtotime('today') - 1;
}
$table = T_LOG_GOLD;

//$beginTime = strtotime("2010-09-09");
//$endTime = strtotime("2010-09-09 23:59:59");

$centralLog = new CentralLogClass();
$ip = GetIP();
//$centralLog->start($ip, getCurPageURL(), 26, $beginTime, $endTime);
if ($endTime - $beginTime < 0) {
//	$centralLog->failed(CENTRAL_LOG_TIME_PARAM_ERROR);
	exit();
}

// 不允许一次拉去超过一年的数据
if ($endTime - $beginTime > 86400 * 365) {
//	$centralLog->failed(CENTRAL_LOG_TIME_TOO_LONG);
	exit();
}

// 搜索指定时间内的道具日志, [$beginTime,$endTime) 防止数据丢失和重复！！
try {

	$sql = "SELECT item_id itemid,type, SUM(gold) gold_unbind, SUM(num) counts, count(*) times, year, month, day
			FROM $table
			WHERE `mtime` >= '".$beginTime."' AND `mtime` < '".$endTime."' and account_name not in ($tuoString)
			GROUP BY item_id,type, year, month, day";
	$result = GFetchRowSet($sql);
	foreach ($result as &$ret){
		$ret['mtime'] = mktime(0, 0, 0, $ret['month'], $ret['day'], $ret['year']);
	}
	$result = serialize($result);
	echo $result;
//	$centralLog->end();
} catch (Exception $e) {
	// 数据库中不记录具体失败原因，失败日志放在log文件中
//	$centralLog->failed(CENTRAL_LOG_QUERY_SQL_ERROR, $e->getMessage());
}

exit();




