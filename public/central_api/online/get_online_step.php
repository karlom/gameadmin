<?php
/**
 * 中央API接口，用于获取安装游戏应用数据
 */
include dirname(dirname(__FILE__)).'/central_api_auth.php';
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

$ip = GetIP();
if ($endTime - $beginTime < 0) {
	exit();
}

// 不允许一次拉去超过一年的数据
if ($endTime - $beginTime > 86400 * 365) {
	exit();
}

// 搜索指定时间内的首充日志, [$beginTime,$endTime) 防止数据丢失和重复！！
try {
    $result=array();
        $sql="  select year,month,day,mtime, count(step) as step_count from t_log_create_loss  WHERE mtime >= {$beginTime} and mtime < {$endTime} and step=0  group by year,month,day";  //只拉取step步骤为0的数据，step= 0,-- 入口请求
        $res= GFetchRowSet($sql);   
         if(!empty($res)){
            foreach ($res as $k => $v){
                $result[$k]['mtime']=$v['mtime'];
                $result[$k]['step_count']=$v['step_count'];
                $result[$k]['year']=$v['year'];
                $result[$k]['month']=$v['month'];
                $result[$k]['day']=$v['day'];   
            }
        }
        $result = serialize($result);
	echo $result;
} catch (Exception $e) {
} 
exit();
