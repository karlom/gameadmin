<?php
/**
 * 调用方式:
 * 每分钟跑一次,读取在线数据
 * /usr/local/php/bin/php broadcast_message_to_server.php
 */

include_once '../config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global_not_auth.php';

$sql = '';
$message = '';
$error = 0;

if(!$error && '' == $message){
	global $server_db;
	if(!$server_db){
		$server_db =  new DBMysqlClass();
	}
	$loadServerList = getAvailableServerList();
	if($loadServerList){
    	$api = "broadcast";
    	foreach ($loadServerList as $k => $v){
    		try{
        		$config = getLogDb($loadServerList[$k]);
        		$server_db->connect($config);
        		$time = time();
    			$sql = "select * from ".T_MESSAGE_BROADCAST." where stime<={$time} and etime>={$time} and send_type<>0";
    			$result = GFetchRowSet($sql);
    			foreach($result as $key => $value){
    			    if(60 > ($time - $value['stime']) % $value['interval']){
                	    $params = array(
                	        "type" => $value['type'],
                	        "msg" => $value['content'],
                	    );
                	    $httpResult = httpRequestResult($k, $api, $params);
                	    if(1 != $httpResult['result']){
                	        $message = "【".date("Y-m-d H:i:s")."】broadcast ".$value['content']." failure\n\r";
                	    }
    			    }
    			}
    		}catch(Exception $ex){
    			$message = "【".date("Y-m-d H:i:s")."】广播消息发生错误\r\n{$ex}";
    		}
            if('' != $message){
            	$logfile = "/tmp/broadcast_log_".date("Y-m-d",time()).".log";
            	$handle = @ fopen($logfile, "a+");
            	fwrite($handle, $message);
            	fclose($handle);
            }
    	}
	}
}