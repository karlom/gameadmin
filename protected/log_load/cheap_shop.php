<?php
/**
 * Name: cheap_shop.php
 * Description: 定时把预设的促销设置发送到游戏端和更新预设的状态， 推荐一分钟执行一次。
 */

include_once '../config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global_not_auth.php';

$sql = '';
$message = '';
$error = 0;
define('CS_WAITING', 0);
define('CS_IN_PROGRESS', 1);
define('CS_FINISHED', 2);

if(!$error && '' == $message){
	global $server_db;
	if(!$server_db){
		$server_db =  new DBMysqlClass();
	}
	$loadServerList = getAvailableServerList();
	if($loadServerList){
    	$time = time();
    	$api = "setcheapshop";
    
    	foreach ($loadServerList as $k => $v){
    		try{
        		$config = getLogDb($loadServerList[$k]);
        		$server_db->connect($config);
    			$onlinedateTimestamp = strtotime($v['onlinedate']);
    			$sinceOnlinedateTimestamp = $time - $onlinedateTimestamp;
    			
    			// 更新状态为进行中且结束时间已经过去了的配置为已结束(确切日期)。
    			$sql = 'UPDATE ' . T_CHEAP_SHOP . ' SET status = ' . CS_FINISHED . ' WHERE status = ' . CS_IN_PROGRESS . ' AND date_type = 0 AND end_time <= ' . $time;
    			GFetchRowOne($sql);
    			
    			// 更新状态为进行中且结束时间已经过去了的配置为已结束(按开服日期)。
    			$sql = 'UPDATE ' . T_CHEAP_SHOP . ' SET status = ' . CS_FINISHED . ' WHERE status = ' . CS_IN_PROGRESS . ' AND date_type = 1 AND end_open_day_time <= ' . $sinceOnlinedateTimestamp;
    			GFetchRowOne($sql);
    		
        		$inProgress = false;
    			// 查询指定时间范围是否存在正在进行的活动(确切日期)
    			$sql = "SELECT count(*) in_progress_count FROM ".T_CHEAP_SHOP." WHERE start_time <= $time AND end_time >= $time AND date_type = 0 AND status = " . CS_IN_PROGRESS;
    			$countResult = GFetchRowOne($sql);
    			if ( $countResult['in_progress_count'] > 0 )
    			{
    				echo "In progress activity exists!(type: 0)\n";
    				$inProgress = true;
    			}
    			else
    			{
    				// 查询指定时间范围是否存在正在进行的活动(按开服日起)
    				$sql = "SELECT count(*) in_progress_count FROM ".T_CHEAP_SHOP." WHERE start_open_day_time <= $sinceOnlinedateTimestamp AND end_open_day_time >= $sinceOnlinedateTimestamp AND date_type = 1 AND status = " . CS_IN_PROGRESS;
    				$countResult = GFetchRowOne($sql);
    				if ( $countResult['in_progress_count'] > 0 )
    				{
    					echo "In progress activity exists!(type: 1)\n";
    					$inProgress = true;
    				}
    			}
    			if ( !$inProgress )
    			{// 如果指定时间范围内没有进行中的活动，则准备发送
    				// 获取等待发送中开始时间最接近的一条配置(确切日期)。
    				$sql = "SELECT * FROM ".T_CHEAP_SHOP." WHERE start_time <= $time AND end_time >= $time AND status = " . CS_WAITING . " AND date_type = 0 ORDER BY start_time ASC LIMIT 1";
    				$result = GFetchRowOne($sql);
    				
    				// 获取等待发送中开始时间最接近的一条配置(按开服日期)。
    				$sql2 = "SELECT * FROM ".T_CHEAP_SHOP." WHERE start_open_day_time <= $sinceOnlinedateTimestamp AND end_open_day_time >= $sinceOnlinedateTimestamp AND status = " . CS_WAITING . " AND date_type = 1 ORDER BY start_open_day_time ASC LIMIT 1";
    				$result2 = GFetchRowOne($sql2);
    				
    				if ( isset($result['id']) && isset($result2['id']) )
    				{
    					if ( ( $result2['start_open_time'] + $onlinedateTimestamp ) < $result['start_time'] )
    					{// 按开服日期的结果早与确切日期，则采用按开服日期的配置
    						$result = $result2;
    					}					
    				}
    				if ( !isset($result['id']) && isset($result2['id']) )
    				{// 按确切日期不存在且按开服日期存在
    					$result = $result2;
    				}
    				
    				if ( isset($result['id']) )
    				{
    					$params = json_decode($result['content'], true);
    					foreach ($params as &$param)
    					{					
    						if($result['date_type'] == 0)
    						{// 确切日期
    							$param['startTime'] = $result['start_time'];
    							$param['keepTime']	= $result['end_time'] - $result['start_time'];
    						}
    						else
    						{// 按开服日期
    							$param['startTime'] = $result['start_open_day_time'] + $onlinedateTimestamp;
    							$param['keepTime']	= $result['end_open_day_time'] - $result['start_open_day_time'];
    						}
    					}
    					echo 'sending activity #' . $result['id'] . "/n";
    					echo 'params: ' .  print_r($params, true);
    					$ret = httpRequestResult($k, 'setcheapshop', array('cheapshop' => json_encode($params) ));
    					echo 'response: ' . print_r($ret, true);
    					if($ret['result'] == 1)
    					{
    						//更新配置的状态为正在进行
    						$sql = 'UPDATE ' . T_CHEAP_SHOP . ' SET status = ' . CS_IN_PROGRESS . ' WHERE id = ' . $result['id'];
    						GFetchRowOne($sql);
    						
    					//	echo $sql;
    					}
    					else
    					{
    						$message = "【".date("Y-m-d H:i:s")."】cheapshop set id = ".$result['id']." failure\n\r";
    					}
    				}
    				else
    				{
    					echo "No activities.";
    				}
    			}
    			
    			
    		}catch(Exception $ex){
    			$message = "【".date("Y-m-d H:i:s")."】促销配置发送失败\r\n{$ex->getMessage()}\r\n";
    		}
            if('' != $message){
            	$logfile = "/tmp/cheapshop_log_".date("Y-m-d", $time ).".log";
            	$handle = @ fopen($logfile, "a+");
            	fwrite($handle, $message);
            	fclose($handle);
            }
            
            
    	}
	}
}
