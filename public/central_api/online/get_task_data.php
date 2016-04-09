<?php


include dirname(dirname(__FILE__)).'/central_api_auth.php';
$action = SS($_GET['action']);
$beginTime = intval($_REQUEST['begin']);
$endTime = intval($_REQUEST['end']);
$tableName = T_LOG_REGISTER;

if ($endTime - $beginTime < 0) {
	exit();
}

// 不允许一次拉去超过一年的数据
if ($endTime - $beginTime > 86400 * 365) {
	exit();
}
if ($action == 'ajax')
{
	
	if (empty($beginTime))
	{
		$beginTime = GetTime_Today0();
	}
	
	if (empty($endTime))
	{
		$endTime = strtotime(date('Y-m-d H:m').':59');
	}
	
	// ajax 获取当天即时数据：每小时的任务集市数据
	try {
       
        $sql1 = "select count(distinct R.uuid) as contract from t_log_login L, t_log_register R where L.uuid=R.uuid and R.mtime>={$beginTime} and R.mtime<{$endTime} and L.contract_id<>'' ";
		$result1 = GFetchRowOne($sql1);
      
        $sql2 = "select count(distinct t1.uuid) as roleCount, round(sum(t1.total_cost + t1.pubacct + t1.amt/10)) as totalCost " .
				"from " .
				" (select * from t_log_buy_goods where mtime>={$beginTime} and mtime<{$endTime} group by billno) t1, " .
				" (select distinct uuid from t_log_login where contract_id<>'' ) t2 " .
				" where t1.uuid=t2.uuid ";
		$result2 = GFetchRowOne($sql2);

        $res = array_merge($result1, $result2);
		$result = serialize($res);
		echo $result;
		// $result = $pfrs['online'];
		// echo $result;
	} catch (Exception $e) {
		// 数据库中不记录具体失败原因，失败日志放在log文件中
//		$centralLog->failed(CENTRAL_LOG_QUERY_SQL_ERROR, $e->getMessage());
	}
}
//$centralLog->end();
exit();

