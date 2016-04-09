<?php
/**
 * upload_logout.php
 * 运行方式：php upload_logout.php [startDate [endDate [server]]] 
 * date format 2014-01-07
 * server format s10001
 */

include_once '../config/config.php';
include_once 'config.tslog.php';
//include_once SYSDIR_ADMIN_INCLUDE.'/global_for_shell.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global_not_auth.php';

//set_time_limit(300); 
set_time_limit(0); 
ini_set("memory_limit", "1024M");

$now = time() - 30*60 ; //上传30分钟前的数据
$date = date("Y-m-d H:i:s");
$day = date("Y-m-d");

$timeFile = "ts_logout_time.txt";
$timeFileFullPath = TS_LOG_DIR."/".$timeFile;
$toWrite = true;

$logFileName = "log_logout_{$day}.log";
$errLogName = "err_log_logout_{$day}.log";

if(file_exists($timeFileFullPath)){
	if($fp = fopen($timeFileFullPath,"r") ) {
		$lastTime = fgets($fp);	//读取一行
		$lastTime = trim($lastTime);
		fclose($fp);
	} else {
		echo "Error: Cannot read file [{$timeFileFullPath}].";
	}	
}

if(!$lastTime) {
	$lastTime = strtotime(TS_LOG_START_DATE);
}

//$ag1 = strtotime($argv[1]);
//$ag2 = strtotime($argv[2]);
if($ag1 = strtotime($argv[1])){
	if($ag1 >= strtotime(TS_LOG_START_DATE) && $ag1 <= $now){
		$sTime = $arg1 ;
	} else {
	//	$sTime = strtotime(TS_LOG_START_DATE) ;
		echo "Error: [{$argv[1]}] not a date";
		exit;
	}	
}

if($ag2 = strtotime($argv[2])){
	if($ag2 <= $now && $ag2 >= $ag1){
		$eTime = $ag2 ;
	} else {
	//	$eTime = $now ;
		echo "Error: [{$argv[2]}] not a date";
		exit;
	}	
}

$server = $argv[3];

$startTime = $sTime ? $sTime : $lastTime;

if($eTime) {
	$endTime = $eTime;
	$toWrite = false;
} else {
	$endTime = $now;
}

$table = "t_log_logout";
$logName = "log_logout";

$allCnt = 0;	//总数
$allSuccCnt = 0;	//成功数
$allFailCnt = 0;	//失败数

$loadServerList = getAvailableServerList();
if(!empty($loadServerList)){
	$logWriteStr = $date . "\n";
	foreach($loadServerList as $k => $v){
		if(!empty($server) && $k != $server) {
			continue;
		}
		   		
		global $server_db;
		//动态建立游戏日志库的连接
		if(!$server_db){
			$server_db =  new DBMysqlClass();
		}
		$config = getLogDb($loadServerList[$k]);
		$server_db->connect($config);
		
		$sid = $v['id'];
		
		$succCnt = 0;	//成功数
		$failCnt = 0;	//失败数
		$aCnt = 0;
		
		$sqlCnt = "select count(*) as cnt from " . $table . " where mtime>={$startTime} and mtime<{$endTime} ";
		$retCnt = GFetchRowOne($sqlCnt);
		$aCnt = $retCnt['cnt'] ? $retCnt['cnt'] : 0;
		$allCnt += $aCnt;
		
		//排除reason = 1 , reason = 1时玩家还没有真正退出
		$sql = " select t1.*, t2.remain_gold, t3.remain_liquan, t4.remain_money from " .
				"(select id, pf, mtime, mdate, uuid, IF( LENGTH(account_name)>32, substring(account_name, 1, 5), '0') as sid, " .
				" IF( LENGTH(account_name)>32, substring(account_name, 7), account_name) as openid, role_name, level, ip, online_time " .
				" from " . $table . " where mtime>={$startTime} and mtime<{$endTime} and reason<>1 ) t1," .
				" ( select a1.uuid, a1.remain_gold, a1.mtime from t_log_gold a1, (select uuid, max(mtime) as mtime from t_log_gold group by uuid) a2 " .
				" where a1.uuid=a2.uuid and a1.mtime=a2.mtime ) t2, " .
				"( select a1.uuid, a1.remain_liquan, a1.mtime from t_log_liquan a1, (select uuid, max(mtime) as mtime from t_log_liquan group by uuid) a2 " .
				" where a1.uuid=a2.uuid and a1.mtime=a2.mtime ) t3, " .
				"( select a1.uuid, a1.remain_money, a1.mtime from t_log_money a1, (select uuid, max(mtime) as mtime from t_log_money group by uuid) a2 " .
				" where a1.uuid=a2.uuid and a1.mtime=a2.mtime ) t4" .
				" where t1.uuid=t2.uuid and t1.uuid=t3.uuid and t1.uuid=t4.uuid ";
		$ret = GFetchRowSet($sql);
		
		if(!empty($ret)) {
			foreach($ret as $j => $w){
				//天神数据上报
				$pf = $w['pf'];
				if( substr($pf,0,5) == "union" ){
					$pos = strpos($pf,'*');	//查找pf里*号的位置
					if($pos > 0){
						$prepf = substr($pf, 0, $pos);
						$sufpf = substr($pf, $pos+1);
						if(array_key_exists($sufpf,$dictTsPlatform)){
							$pf = $sufpf;
						} else {
							$pf = "union";	//联盟pf
						}
					}
				}
				$tsLogArray = array(
					'f_dept' => $dictTsPlatform[$pf] ? $dictTsPlatform[$pf] : $dictTsPlatform['tx'],
					'f_server_address_id' => $sid,
					'f_game_id' => TS_GAME_ID,
					'f_time' => $w['mdate'],
					'f_sid' => $w['sid'],
					'f_yunying_id' => $w['openid'],
					'f_character_id' => $w['role_name'],
					'f_character_grade' => $w['level'],
					'f_character_ip' => $w['ip'],
					'f_jinbi' => $w['remain_money'],
					'f_yuanbao' => $w['remain_gold'],
					'f_bangjin' => $w['remain_liquan'],
					'f_online_time' => $w['online_time'],
				);
				$tsLog = urlencode(decodeUnicode(json_encode($tsLogArray)));
				$tsLogUrl = TS_LOG_URL . "?logname={$logName}&logs={$tsLog}";
				$resStr = @getUrlFileContents($tsLogUrl,"GET","2");
				$resArr = json_decode($resStr, true);
				if(isset($resArr['ret']) && $resArr['ret'] === 0) {
					$succCnt ++;
				} else {
					$failCnt ++;
					$errMsg =  "\tSID: {$sid}, TID: {$w['id']}, RET:{$resStr},\tURL: {$tsLogUrl}\n";
					tsLogs($errLogName, $errMsg, "a+");
				}
			}
			$allFailCnt += $failCnt;
			$allSuccCnt += $succCnt;
		}
		$logWriteStr .= "\tSid: {$sid}, All: {$aCnt}, Succ: {$succCnt}, Fail: {$failCnt}, " .
				"Time: {$startTime} -> {$endTime}, " . date("Y-m-d H:i:s", $startTime) . " -> " .  date("Y-m-d H:i:s", $endTime) . "\n";
	}
	if($toWrite){
		if($allCnt == $allFailCnt && $allCnt !== 0){
			//全部失败
			tsLogs($timeFile, $startTime, "w");
		} else {
			tsLogs($timeFile, $endTime, "w");
		}
		
	}
	$logWriteStr .= "\tSid: ALL, All: {$allCnt}, Succ: {$allSuccCnt}, Fail: {$allFailCnt}, " .
			 date("Y-m-d H:i:s", $startTime) . " -> " .  date("Y-m-d H:i:s", $endTime) . "\n";
	tsLogs($logFileName, $logWriteStr, "a+");
}

