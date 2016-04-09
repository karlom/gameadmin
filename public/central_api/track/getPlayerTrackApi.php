<?php
/**
*	Description:给中央后台提供接口，从c_player_track_update表中读取数据
*/

define('IN_ADMIN_SYSTEM', true);
//include_once "../../../config/config.php";
//include_once SYSDIR_INCLUDE."/global.php";
//include_once SYSDIR_ROOT . '/class/db.class.php';
//include '../central_api_auth.php';
//include SYSDIR_ADMIN.'/class/central.log.php';

//include_once '../../../protected/class/central.log.php';
include '../central_api_auth.php';

$beginTime = intval($_REQUEST['begin']);
$endTime = intval($_REQUEST['end']);

// 默认发送昨天的数据
if ($beginTime == 0) {
	$beginTime = strtotime('today -1 day');
}
if ($endTime == 0) {
	$endTime = strtotime('today') - 1;
}
$table ='c_play_track_update';

//$centralLog = new CentralLogClass();
$ip = GetIP();
//$centralLog->start($ip, getCurPageURL(), 20, $beginTime, $endTime);
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
	$sql = "SELECT `agent_id`,`server_id`,`create_roles_account`, `create_roles`, `toGameCount`, `finishGuideCount`, `countTime`,DATE_FORMAT(FROM_UNIXTIME(countTime),'%Y-%m-%d') as date FROM `".$table."` WHERE `counttime` >= '".$beginTime."' AND `counttime` <= '".$endTime."' GROUP BY date ";
	$result = GFetchRowSet($sql);
	$result = serialize($result);
	echo $result;
//	$centralLog->end();
} catch (Exception $e) {
	// 数据库中不记录具体失败原因，失败日志放在log文件中
//	$centralLog->failed(CENTRAL_LOG_QUERY_SQL_ERROR, $e->getMessage());
}

exit();




