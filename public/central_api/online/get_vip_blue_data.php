<?php

/*
 * 中央API接口，用于获取开通蓝钻的数据
 */
include dirname(dirname(__FILE__)) . '/central_api_auth.php';
session_start();
session_regenerate_id();

$action = SS($_GET['action']);
$beginTime = intval($_REQUEST['begin']);
$endTime = intval($_REQUEST['end']);

if ($endTime - $beginTime < 0) {
    exit();
}
// 不允许一次拉去超过一年的数据
if ($endTime - $beginTime > 86400 * 365) {
    exit();
}
if ($action == 'ajax') {
    
    if (empty($beginTime)) {
        $beginTime = GetTime_Today0();
    }
    if (empty($endTime)) {
        $endTime = strtotime(date('Y-m-d H:m') . ':59');
    }

    // ajax 获取当天即时数据：每小时的在线情况
    try {
        $sql = " select count(*) as count_vip_blue  from  t_log_open_vip_blue" ." where mtime>={$beginTime} and mtime<={$endTime}";
        $res = GFetchRowOne($sql);

       $result = serialize($res);
        echo $result;
    } catch (Exception $e) {
        // 数据库中不记录具体失败原因，失败日志放在log文件中
//		$centralLog->failed(CENTRAL_LOG_QUERY_SQL_ERROR, $e->getMessage());
    }
} else {
    // 其它情况都是获取昨天在线数据：每天在线情况
    if (empty($beginTime)) {
        $beginTime = strtotime(date('Y-m-d', strtotime('-1day'))); //默认跑前一天的数据;
    }
    if (empty($endTime)) {
        $endTime = $beginTime + 86399;
    }
    $sql = " select * from `" . t_log_open_vip_blue . "` where `mtime` >= '" . $beginTime . "' and `mtime` <= '" . $endTime . "'";
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

