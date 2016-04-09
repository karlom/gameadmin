<?php
/**
 * 中央API接口，用于获取退出日志
 */

//include_once "../../../protected/config/config.php";
//include_once SYSDIR_ROOT . '/class/db.class.php';
include '../central_api_auth.php';
//include SYSDIR_ADMIN.'/class/central.log.php';

$beginTime = intval($_REQUEST['begin']);
$endTime = intval($_REQUEST['end']);


// 默认发送昨天的充值数据
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

// 搜索指定时间内的充值日志, [$beginTime,$endTime) 防止数据丢失和重复！！
try {
	$step = 1000;//控制每次输出多少条,因为一次输出全部，保存结果的数组太大会造成PHP内存溢出
	$sqlCount = "SELECT count(*) c FROM " . T_LOG_LOGIN . " WHERE mtime >= {$beginTime} and mtime < {$endTime}";
	$count = GFetchRowOne($sqlCount);

	$count = intval( $count['c'] );
	$times = ceil( $count / $step ) ;
	$index = 1;
        $sql = "SELECT `year`, `day`, `month`, `mtime`,  `account_name`, `role_name`, `level`, `ip` FROM " . T_LOG_LOGIN . " WHERE mtime >= {$beginTime} and mtime < {$endTime} LIMIT $start, $step";   
	while( $times-- )
	{
		$start = ($index - 1) * $step;
		$sql = "SELECT `year`, `day`, `month`, `mtime`,  `account_name`, `role_name`, `level`, `ip` FROM " . T_LOG_LOGIN . " WHERE mtime >= {$beginTime} and mtime < {$endTime} LIMIT $start, $step";  	
		$result = GFetchRowSet($sql);
		$result = serialize($result);
		echo $result;
		echo '|separator|';
		$index++;
		ob_flush();
		flush();
	}
	
//	$sql = "SELECT `year`, `day`, `month`, `mtime`, `account_id`, `account_name`, `role_id`, `role_name`, `level`, `ip` FROM " . T_LOG_LOGIN . " WHERE mtime >= {$beginTime} and mtime < {$endTime}";
//	$result = GFetchRowSet($sql);

//	$result = serialize($result);
//	echo $result;
//	$centralLog->end();
} catch (Exception $e) {
	// 数据库中不记录具体失败原因，失败日志放在log文件中
	echo $e->getMessage();
//	$centralLog->failed(CENTRAL_LOG_QUERY_SQL_ERROR, $e->getMessage());
}

exit();
