<?php
/**
*	Description:给中央后台提供接口，从c_day_gold_reamin表中读取数据
*/

include dirname(dirname(__FILE__)).'/central_api_auth.php';

$beginTime = intval($_REQUEST['begin']);
$endTime = intval($_REQUEST['end']);

// 默认发送昨天的充值数据
if ($beginTime == 0) {
	$beginTime = strtotime('today -1 day');
}
if ($endTime == 0) {
	$endTime = strtotime('today') - 1;
}
//$table = C_DAY_GOLD_REMAIN;

//$centralLog = new CentralLogClass();
$ip = GetIP();
//$centralLog->start($ip, getCurPageURL(), 20, $beginTime, $endTime);
if ($endTime - $beginTime < 0) {
	//$centralLog->failed(CENTRAL_LOG_TIME_PARAM_ERROR);
	exit();
}

// 不允许一次拉去超过一年的数据
if ($endTime - $beginTime > 86400 * 365) {
	//$centralLog->failed(CENTRAL_LOG_TIME_TOO_LONG);
	exit();
}

// 搜索指定时间内的充值日志, [$beginTime,$endTime) 防止数据丢失和重复！！
try {
	//$sql = "SELECT * FROM `".$table."` WHERE `mtime` >= '".$beginTime."' AND `mtime` <= '".$endTime."'";
	$sql = "SELECT * FROM (
			SELECT t1.id, t1.role_name, t1.account_name, t1.level as role_level, t1.remain_bind_gold as gold_bind, t1.remain_gold as gold_unbind, (t1.remain_bind_gold+t1.remain_gold)as gold_all,t1.mtime, t1.mdate as mdatetime, t1.year, t1.month, t1.day 
			FROM t_log_gold t1 
			RIGHT JOIN(
			SELECT role_name, remain_gold, max(mtime) max_time 
			FROM t_log_gold
			GROUP BY role_name, year, month, day) t2
			ON t1.role_name = t2.role_name and t1.mtime = t2.max_time
			ORDER BY t1.id DESC) tgroup
			WHERE mtime BETWEEN $beginTime AND $endTime
			GROUP BY tgroup.role_name";
	
	$result = GFetchRowSet($sql);
	foreach($result as &$value){
		$tmp = explode(' ', $value['mdatetime']);
		$value['mdatetime'] = strtotime($tmp[0]);
	};
	$result = serialize($result);
	echo $result;
	//$centralLog->end();
} catch (Exception $e) {
	// 数据库中不记录具体失败原因，失败日志放在log文件中
	//$centralLog->failed(CENTRAL_LOG_QUERY_SQL_ERROR, $e->getMessage());
}

exit();




