<?php
/**
*	Description:获取道具存留统计，从t_stat_remain_item表中读取数据
*/

define('IN_ADMIN_SYSTEM', true);
//include_once "../../../config/config.php";
//include_once SYSDIR_INCLUDE."/global.php";
//include_once SYSDIR_ROOT . '/class/db.class.php';
//include '../central_api_auth.php';
//include SYSDIR_ADMIN.'/class/central.log.php';
include '../central_api_auth.php';
//include_once '../../../protected/class/central.log.php';

$beginTime = intval(SS($_REQUEST['begin']));
$endTime = intval(SS($_REQUEST['end']));

// 默认发送昨天的充值数据
if ($beginTime == 0) {
	$beginTime = strtotime('today -1 day');
}
if ($endTime == 0) {
	$endTime = strtotime('today') - 1;
}
$table = T_STAT_REMAIN_ITEM;

//$centralLog = new CentralLogClass();
$ip = GetIP();
//$centralLog->start($ip, getCurPageURL(), GAMER_STAT_REMAIN_ITEM, $beginTime, $endTime);
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
	$sql = "SELECT `typeid` , SUM( `num` ) AS num, `timezero` as mtime FROM {$table} WHERE `timezero` BETWEEN {$beginTime} AND {$endTime}  GROUP BY `typeid` , `timezero`";
	$rsidst = GFetchRowSet($sql);
	//print_r($rsidst);
	$result = serialize($rsidst);
	echo $result;
//	$centralLog->end();
} catch (Exception $e) {
	// 数据库中不记录具体失败原因，失败日志放在log文件中
//	$centralLog->failed(CENTRAL_LOG_QUERY_SQL_ERROR, $e->getMessage());
}

exit();




