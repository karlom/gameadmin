<?php
/**
 * 调用方式:
 * 每分钟跑一次,读取在线数据
 * /usr/local/php/bin/php get_online_data.php s1(服务器)
 */

include_once '../config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global_not_auth.php';

$sql = '';
$message = '';
$error = 0;
//$server = $argv[1];

if(!$error && '' == $message){
	global $server_db;
	if(!$server_db){
		$server_db =  new DBMysqlClass();
	}
	$loadServerList = getAvailableServerList();
	if($loadServerList){
    	$api = "getonlinecount";
    	foreach ($loadServerList as $k => $v){
            $message = '';
            for($i = 0; $i < 3; $i++){
//        	    $result = httpRequestResult($k, $api);
        	    $result = socketRequestResult($k, $api);
//		print_r($result);
        	    if(isset($result['time']) && isset($result['online'])){
        	        break;
        	    }
            }
        	if(isset($result['time']) && isset($result['online'])){
        	    if(0 <= $result['online']){
            		$data['year'] = date("Y", $result['time']);
            		$data['month'] = date("m", $result['time']);
            		$data['day'] = date("d", $result['time']);
            		$data['hour'] = date("H", $result['time']);
            		$data['min'] = date("i", $result['time']);
            		$data['mdate'] = date("Y-m-d H:i:s", $result['time']);
            		$data['mtime'] = $result['time'];
            		$data['online'] = $result['online'];
            		$data['onlineVip'] = $result['onlineVip'];
            		
            		try{
                		$config = getLogDb($loadServerList[$k]);
                		$server_db->connect($config);
            			$sql = makeInsertSqlFromArray($data, T_LOG_ONLINE);
            			GQuery($sql);
            		}catch(Exception $ex){
            			$message = "【".date("Y-m-d H:i:s")."】{$k}服拉取在线数据发生错误\r\n{$ex}";
            		}
        	    }
        	}else{
    	        $message = "【".date("Y-m-d H:i:s")."】{$k}服拉取在线数据发生错误\r\n";
    	    }
            if('' != $message){
            	$logfile = "/tmp/msg_log_".date("Y-m-d",time()).".log";
            	$handle = @fopen($logfile, "a+");
            	fwrite($handle, $message);
            	fclose($handle);
            }
    	}
	}
}
