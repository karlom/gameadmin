<?php
/**
*	Description:获取道具使用情况
*/

include dirname(dirname(__FILE__)).'/central_api_auth.php';

$action = SS($_GET['action']);
$beginTime = intval($_REQUEST['begin']);
$endTime = intval($_REQUEST['end']);
$beginTime = empty($beginTime)?strtotime(date('Y-m-d 00:00:00',strtotime("-1day"))):$beginTime;
$endTime = empty($endTime)?strtotime(date('Y-m-d 23:59:59',strtotime('-1day'))):$endTime;

$whereTime = " and mtime>={$beginTime} and mtime<={$endTime} ";
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
try {
 	    $sql = "SELECT `item_id` , `type`, sum(item_num) as num, DATE_FORMAT( FROM_UNIXTIME(mtime), '%Y-%m-%d') AS mdate  FROM `".T_LOG_ITEM."` where 1 {$whereTime} and item_num>0 GROUP BY year,month,day,`item_id`,`type` " .
 	    		" union all " .	
 	    	"SELECT `item_id` , `type`, sum(item_num) as num, DATE_FORMAT( FROM_UNIXTIME(mtime), '%Y-%m-%d') AS mdate  FROM `".T_LOG_ITEM."` where 1 {$whereTime} and item_num<0 GROUP BY year,month,day,`item_id`,`type`";	
		$rs = IBFetchRowSet($sql);
		echo serialize($rs);
		
	} catch (Exception $e) {
		// 数据库中不记录具体失败原因，失败日志放在log文件中
//		$centralLog->failed(CENTRAL_LOG_QUERY_SQL_ERROR, $e->getMessage());
	}

//$centralLog->end();
