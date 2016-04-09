<?php
/**
*	Description:获取元宝的消耗与留存量
*/

define('IN_ADMIN_SYSTEM', true);
//include_once "../../../protected/config/config.php";
//include_once SYSDIR_ROOT . '/class/db.class.php';
include '../central_api_auth.php';
//include SYSDIR_ADMIN.'/class/central.log.php';

$beginTime = intval(SS($_GET['begin']));
$endTime = intval(SS($_GET['end']));

if ($beginTime == NULL) {
	//默认是计算昨天的数据
	$beginTime = strtotime(strftime ("%Y-%m-%d", time() - 86400));
}

if ($endTime == NULL) {
	$endTime = $beginTime + 86400;
}

if ($endTime < $beginTime) {
	echo '时间参数有误，结束时间必须大于开始时间';
	exit();
}

$table = C_GOLD_CONSUME_AND_SAVE;

$centralLog = new CentralLogClass();
$ip = GetIP();
//$centralLog->start($ip, getCurPageURL(), CENT_API_UPDATE_GOLD_COMSUM_AND_SAVE, $beginTime, $endTime);
if ($endTime - $beginTime < 0) {
//	$centralLog->failed(CENTRAL_LOG_TIME_PARAM_ERROR);
	exit();
}

// 不允许一次拉去超过一年的数据
if ($endTime - $beginTime > 86400 * 365) {
//	$centralLog->failed(CENTRAL_LOG_TIME_TOO_LONG);
	exit();
}

// 搜索指定时间内的充值日志, [$beginTime,$endTime) 防止数据丢失和重复！！
try {
	$sql = "SELECT * FROM `".$table."` WHERE `mtime` >= '".$beginTime."' AND `mtime` < '".$endTime."'";
	$result = GFetchRowSet($sql);

	$result = serialize($result);
	echo $result;
//	$centralLog->end();
} catch (Exception $e) {
	// 数据库中不记录具体失败原因，失败日志放在log文件中
//	$centralLog->failed(CENTRAL_LOG_QUERY_SQL_ERROR, $e->getMessage());
}

exit();




