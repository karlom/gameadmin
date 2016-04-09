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
	
	// ajax 获取当天即时数据：每小时的在线情况
	try {
        // $sql = " select count(*) online from ".T_LOG_REGISTER." where 1 and mtime>={$beginTime} and mtime<={$endTime} ";
        // $rs = GFetchRowOne($sql);
        // $result = $rs['online'];
        //$pfsql = " select pf,count(id) as pfcount from ".$tableName." where mtime>={$beginTime} and mtime<={$endTime} group by pf ";
        $pfsql = "select pf,count(id) as pfcount,totalRequest FROM
                (
                    select count(distinct account_name) as totalRequest from t_log_create_loss where mtime between {$beginTime} and {$endTime} and step=0
                )a,t_log_register b where mtime between {$beginTime} and {$endTime} group by pf";
//		echo($pfsql);die();
		$pfrs = GFetchRowSet($pfsql);
		$result = serialize($pfrs);
		echo $result;
		// $result = $pfrs['online'];
		// echo $result;
	} catch (Exception $e) {
		// 数据库中不记录具体失败原因，失败日志放在log文件中
//		$centralLog->failed(CENTRAL_LOG_QUERY_SQL_ERROR, $e->getMessage());
	}
}else 
{
	
	// 其它情况都是获取昨天在线数据：每天在线情况
	if (empty($beginTime))
	{
		$beginTime = strtotime(date('Y-m-d',strtotime('-1day')));//默认跑前一天的数据;
	}
	if (empty($endTime))
	{
		$endTime = $beginTime + 86399;
	}
	$sql = " select max(`online`) as max_online, min(`online`) as min_online, avg(`online`) as avg_online,year,month,day from `".$tableName."` where `mtime` >= '".$beginTime."' and `mtime` <= '".$endTime."' group by year,month,day";
//	die($sql);
	try {
		$result = GFetchRowSet($sql);
		echo serialize($result);
	} catch (Exception $e) {
		// 数据库中不记录具体失败原因，失败日志放在log文件中
//		$centralLog->failed(CENTRAL_LOG_QUERY_SQL_ERROR, $e->getMessage());
	}
}
//$centralLog->end();
exit();

