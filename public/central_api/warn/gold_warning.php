<?php
/**
 * 中央API接口，用于拉取元宝、铜币异常数据
 */

include dirname(dirname(__FILE__)).'/central_api_auth.php';
//include SYSDIR_ADMIN.'/class/central.log.php';

$beginTime = intval($_GET['begin']);
$endTime = intval($_GET['end']);

try {
    $sql = "select * from ".C_GOLD_AND_SILVER_WARN." where mtime>={$beginTime} and mtime<={$endTime}";
    $result = GFetchRowSet($sql);
	$result = serialize($result);
	echo $result;
}catch (Exception $ex){
    echo $ex;
}