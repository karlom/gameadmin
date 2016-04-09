<?php
/**
*	Description:获取金玉临门道具领取情况
*/

include dirname(dirname(__FILE__)).'/central_api_auth.php';
//include SYSDIR_ADMIN.'/class/central.log.php';
session_start ();
session_regenerate_id();

$beginTime = intval($_REQUEST['begin']);
$endTime = intval($_REQUEST['end']);

// 默认发送昨天的充值数据
if ($beginTime == 0) {
	$beginTime = strtotime('today -1 day');
}
if ($endTime == 0) {
	$endTime = strtotime('today');
}

//$centralLog = new CentralLogClass();
$ip = GetIP();
//$centralLog->start($ip, getCurPageURL(), 24, $beginTime, $endTime);
if ($endTime - $beginTime < 0) {
//	$centralLog->failed(CENTRAL_LOG_TIME_PARAM_ERROR);
	exit();
}

// 不允许一次拉去超过一年的数据
if ($endTime - $beginTime > 86400 * 365) {
//	$centralLog->failed(CENTRAL_LOG_TIME_TOO_LONG);
	exit();
}

// 搜索指定时间内的领取日志, [$beginTime,$endTime) 防止数据丢失和重复！！
try {
    $item_id="17921,17031,17006,17002,17005,16238,17044,17043,15012,15011,15013";
    $sql = "select mdate,mtime,uuid,account_name,role_name,item_id,item_num,year,month,day  from t_log_item  where mtime >={$beginTime} and mtime<={$endTime} and item_id in ({$item_id}) and item_num>0";

    $result = GFetchRowSet($sql);
    $result = serialize($result);
    echo $result;
//	$centralLog->end();
} catch (Exception $e) {
	// 数据库中不记录具体失败原因，失败日志放在log文件中
//	$centralLog->failed(CENTRAL_LOG_QUERY_SQL_ERROR, $e->getMessage());
} 

exit();
