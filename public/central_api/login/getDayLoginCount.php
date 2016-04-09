<?php
/**
*	Description:给中央后台提供接口，读取每天登录信息
*/

include dirname(dirname(__FILE__)).'/central_api_auth.php';

$beginTime = intval($_REQUEST['begin']);
$endTime = intval($_REQUEST['end']);

// 默认发送昨天的数据
if ($beginTime == 0) {
	$beginTime = strtotime(date('Y-m-d 00:00:00',strtotime('today -1 day')));
}
if ($endTime == 0) {
	$endTime = strtotime(date('Y-m-d 23:59:59',strtotime('today -1 day')));;
}

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

$agentId   = SS($_GET['agentID']);
$serverId  = SS($_GET['serverID']);
$tableName = 't_log_login';


$sql = " select COUNT(DISTINCT ip) as total_ip,COUNT(DISTINCT account_name) as total_role, DATE_FORMAT(FROM_UNIXTIME(mtime),'%Y-%m-%d') as date, year, month, day
			from {$tableName} 
			where (mtime between {$beginTime} and {$endTime}) 
			GROUP BY date";
$rs = GFetchRowSet($sql);
if (!empty($rs)) {
	foreach ($rs as $log) {
		//以下字段顺序按中央后台t_gold_remain表顺序，不可随便更改
		$arr[$log['date']] = array(
			'agent_id'=>$agentId,
			'server_id'=>substr($serverId, 1),
			//'mdatetime'=>$beginTime,
			'mdatetime'=>strtotime($log['date']),
			'total_role'=>$log['total_role'],
			'total_ip'=>$log['total_ip'],
			'year'=>$log['year'],
			'month'=>$log['month'],
			'day'=>$log['day'],
		);
	//print_r($arr);
	echo $result = serialize($arr);
	}
}