<?php
/**
 * 中央API接口，用于获取注册日志
 */

include '../central_api_auth.php';

$beginTime = intval($_REQUEST['begin']);
$endTime = intval($_REQUEST['end']);

// 默认发送昨天的注册数据
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

// 搜索指定时间内的注册日志, [$beginTime,$endTime) 防止数据丢失和重复！！
try {
   
    $sql = "SELECT count(distinct account_name) as register_count,mtime,`year`, `month`,`day` FROM " . T_LOG_REGISTER . " WHERE mtime >= {$beginTime} and mtime < {$endTime} group by `year`, `month`,`day`";		
    print_r($sql);
    $res = GFetchRowSet($sql);
     if(!empty($res)){
            foreach ($res as $k => $v){
                $result[$k]['mtime']=$v['mtime'];
                $result[$k]['register_count']=$v['register_count'];
                $result[$k]['year']=$v['year'];
                $result[$k]['month']=$v['month'];
                $result[$k]['day']=$v['day'];   
            }
        }
    $result = serialize($result);
    echo $result;
} catch (Exception $e) {
	// 数据库中不记录具体失败原因，失败日志放在log文件中
	echo $e->getMessage();
//	$centralLog->failed(CENTRAL_LOG_QUERY_SQL_ERROR, $e->getMessage());
}

exit();
