<?php
/**
 * send_items.php
 * 定时发送道具 每分钟运行一次
 */

include_once '../config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global_not_auth.php';
global $server_db ;

$loadServerList = getAvailableServerList();
if(!$server_db){
	$server_db =  new DBMysqlClass();
}

foreach($loadServerList as $key => $value) {
	//连接数据库
	$config = getLogDb($loadServerList[$key]);
	$server_db->connect($config);
	
	$now = time();
	
	$sqlGetList = "select * from t_regular_send_item where `begin_time`<{$now} and  `end_time`>{$now} and `status`=1 ";
	$sendList = GFetchRowSet($sqlGetList);
	if(!empty($sendList)) {
//		$now = time();
		foreach($sendList as $k => $data) {
			$sendTime = $data['send_time'] + strtotime(date("Y-m-d"));
			$abTime = $now - $sendTime;
			if( 0 < $abTime && $abTime < 65 && ($now - $data['last_send_time'] > 10*60) ) {
				//设定发送时间距离现在1分钟以内，并且距离上次发送时间要超过10分钟
				$method = "applygoods";
				$params = array();
				
				$params['sendType'] = intval($data['sendType']);
				$params['applyID'] = $data['id']+1000;
				$params['mailTitle'] = $data['mailTitle'];
				$params['mailContent'] = $data['mailContent'];
				$params['roleNameList'] = json_decode($data['roleNameList'],TRUE);
				
					// 所有物品，一次请求。
				if ($data['item'] != null){
					$params['items'] = json_decode($data['item'], TRUE);
					
//					$result = interfaceRequest($method, $params);
					$result = socketRequestResult($key, $method, $params);
					
					if ($result['result'] == 1 ) {
						//更新时间
						$updateSql = "update t_regular_send_item set last_send_time={$now} where id={$data['id']}";
						GQuery($updateSql);
						$msgStr = '发送成功';
					} else {
						$msgStr = '发送失败';
					}
					//写日志
					sendItemLog($params,$result,$k.": ".$msgStr,$now);
				}
				
			} else {
				$str = "SERVER: {$key}".", ST: ".$sendTime.", ABT: $abTime";
				sendItemLog($data,array(),$str);
			}
		}
	}
}


function sendItemLog($params=array(), $result=array(), $msgStr='', $time=''){
	$fileName = dirname(__FILE__)."/send_items.log";
	
	if(!$time){
		$time = time();
	}
	
	$paramsJsonStr = decodeUnicode(json_encode($params)); 
	$resultJsonStr = decodeUnicode(json_encode($result)); 
	
	$timeStr = date("Y-m-d H:i:s", $time);
	
	$str = $timeStr."\n" .
			"\tPARAMS:  ".$paramsJsonStr."\n".
			"\tFROM_SERVER:  ".$resultJsonStr."\n".
			"\tMSG:  ".$msgStr."\n".
			""
			;
	
	$fp = fopen($fileName,"a+");
	if($fp ) {
		if( fwrite($fp, $str) ) {
			return false;
		}
	}
	fclose($fp);
	return true;
}