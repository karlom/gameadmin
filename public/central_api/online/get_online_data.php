<?php
/**
*	Description:获取游戏在线数据,读取数据库中的最新数据，不去游戏服取即时数据。
*/
//include dirname(dirname(__FILE__)).'/central_api_auth.php';
//include SYSDIR_ADMIN.'/class/central.log.php';
//include_once '../central_api_auth.php';
//include_once '../../../protected/class/central.log.php';

include dirname(dirname(__FILE__)).'/central_api_auth.php';

$action = SS($_GET['action']);
$beginTime = intval($_REQUEST['begin']);
$endTime = intval($_REQUEST['end']);
$tableName = T_LOG_ONLINE;

//$centralLog = new CentralLogClass();
//$ip = GetIP();

//$centralLog->start($ip, getCurPageURL(), 2, $beginTime, $endTime);
if ($endTime - $beginTime < 0) {
//	$centralLog->failed(CENTRAL_LOG_TIME_PARAM_ERROR);
	exit();
}

// 不允许一次拉去超过一年的数据
if ($endTime - $beginTime > 86400 * 365) {
//	$centralLog->failed(CENTRAL_LOG_TIME_TOO_LONG);
	exit();
}
if ($action == 'ajax') {
	
	if (empty($beginTime)) {
		$beginTime = GetTime_Today0();
	}
	
	if (empty($endTime)) {
		$endTime = strtotime(date('Y-m-d H:i').':59');
	}
	
	// ajax 获取当天即时数据：每小时的在线情况
	try {
		$sql = " select online, mtime as log_time from `t_log_online` order by id desc limit 0,1;";
		$rs = GFetchRowOne($sql);
		$result = $rs['online'];
		echo $result;
	} catch (Exception $e) {
		// 数据库中不记录具体失败原因，失败日志放在log文件中
//		$centralLog->failed(CENTRAL_LOG_QUERY_SQL_ERROR, $e->getMessage());
	}
} else {
	
	// 其它情况都是获取昨天在线数据：每天在线情况
	if (empty($beginTime)) {
		$beginTime = strtotime(date('Y-m-d',strtotime('-1day')));//默认跑前一天的数据;
	}
	if (empty($endTime)) 	{
		$endTime = $beginTime + 86399;
	}
	$sql = " select max(`online`) as max_online, min(`online`) as min_online, avg(`online`) as avg_online,year,month,day from `".$tableName."` where `mtime` >= '".$beginTime."' and `mtime` <= '".$endTime."' group by year,month,day";
//die($sql);
	try {
		$rs = GFetchRowSet($sql);
		$result = handleData($rs,0);
		echo serialize($result);
	} catch (Exception $e) {
		// 数据库中不记录具体失败原因，失败日志放在log文件中
//		$centralLog->failed(CENTRAL_LOG_QUERY_SQL_ERROR, $e->getMessage());
	}
}
//$centralLog->end();
exit();
/**
 * 将数据拼凑成中央后台需要的数据
 * @param $rs		原始数据
 * @param $type		是否是即时数据 1-是 其它-不是
 */
function handleData($rs,$type)
{
	if ($type == 1) 	{
		foreach ($rs as $k => $v) {
			$result[$v['year']."-".$v['month']."-".$v['day']]['max_online'][$v['hour']] = $v['max_online'];
			$result[$v['year']."-".$v['month']."-".$v['day']]['min_online'][$v['hour']] = $v['min_online'];
			$result[$v['year']."-".$v['month']."-".$v['day']]['avg_online'][$v['hour']] = intval(strval($v['avg_online']));
			$result[$v['year']."-".$v['month']."-".$v['day']]['agentid'] = AGENT_ID;
			$result[$v['year']."-".$v['month']."-".$v['day']]['serverid'] = SERVER_ID;
		}
	}else {
		foreach ($rs as $k => $v) {
			$result[$v['year']."-".$v['month']."-".$v['day']]['max_online'] = $v['max_online'];
			$result[$v['year']."-".$v['month']."-".$v['day']]['min_online'] = $v['min_online'];
			$result[$v['year']."-".$v['month']."-".$v['day']]['avg_online'] = intval(strval($v['avg_online']));
			$result[$v['year']."-".$v['month']."-".$v['day']]['agentid'] = AGENT_ID;
			$result[$v['year']."-".$v['month']."-".$v['day']]['serverid'] = SERVER_ID;
		}
	}
	return $result;
}
