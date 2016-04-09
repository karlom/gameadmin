<?php
/**
 * 中央API接口，用于获取充值礼包
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
        $result = array();
        
        $item1 = "23006";
	$op1 = "10100";
	
	$item2 = "20245";
	$op2 = "10143";
        $sql="select id,mdate,mtime,type,item_id from t_log_item where item_id in({$item1},{$item2})  and type in({$op1},{$op2}) and mtime>={$beginTime} and mtime<={$endTime} "; 
        $res= IBFetchRowSet($sql);
         if(!empty($res)){
            foreach ($res as $k => $v){
                $result[$k]['mdate']=$v['mdate'];
                $result[$k]['mtime']=$v['mtime'];
                $result[$k]['type']=$v['type'];
                $result[$k]['item_id']=$v['item_id'];
            }
        }
   
        if(!empty($result)){
		foreach($result as $k => $v){
			$result[$k]['mdate']       = $result[$k]['mdate']     ? $result[$k]['mdate'] : 0 ;
			$result[$k]['mtime']       = $result[$k]['mtime']     ? $result[$k]['mtime'] : 0 ;
                        $result[$k]['type']         = $result[$k]['type']       ? $result[$k]['type'] : 0 ;
			$result[$k]['item_id']      = $result[$k]['item_id']    ? $result[$k]['item_id'] : 0 ;
		}
	}
        $result = serialize($result);
	echo $result;
} catch (Exception $e) {
} 
exit();
