<?php
/**
 * 中央API接口，用于获取充值日志
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

// 搜索指定时间内的充值日志, [$beginTime,$endTime) 防止数据丢失和重复！！
try {
	if (PROXY == 'qq') {
        $sql = "select year, day, month, hour, min, uuid, account_name, role_name, IF(LENGTH(account_name)>32, SUBSTRING(`account_name` from 7), `account_name` ) as openid, level, item_id, item_cnt, price, total_cost, ts, billno, pubacct, amt, round(total_cost + pubacct + amt/10) as consume,ts as pay_time,pf from t_log_buy_goods where ts >= {$beginTime} and ts < {$endTime}";
    } else {
         $sql = "select year, day, month, hour, min, uuid, account_name, role_name, account_name as openid, level, amt as total_cost, ts, billno, amt as consume, ts as pay_time from t_log_pay where ts >= {$beginTime} and ts < {$endTime}";
    }
    $result = GFetchRowSet($sql);
    $result = serialize($result);
    echo $result;
//	$centralLog->end();
} catch (Exception $e) {
	// 数据库中不记录具体失败原因，失败日志放在log文件中
//	$centralLog->failed(CENTRAL_LOG_QUERY_SQL_ERROR, $e->getMessage());
} 

exit();
