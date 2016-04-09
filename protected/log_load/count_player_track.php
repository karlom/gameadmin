<?php
/**
 * 获取全部数据请运行 count_player_track_all_history.php
 * @desc 开服数据统计
 * -----------------------------------------------------------------------------------------------------------------------------------------
 * 关于运维跑脚本获得一定时间内的数据说明： 
 * 执行脚本方式： /usr/local/php/bin/php count_player_track.php  服务器 开始日期 结束日期 
 * 执行脚本示例： /usr/local/php/bin/php count_player_track.php  s1 2012-04-20 2012-04-25
 * s1 为服务器 ； 
 * 2012-04-20 为开始日期
 * 2012-04-25 为结束日期
 * ----------------------------------------------------------------------------------------------------------------------------------------- 
 * 附特殊情况: 
 * 所有服(all)：/usr/local/php/bin/php count_player_track.php  all 2012-04-20 2012-04-25 
 * 只跑某一天的：/usr/local/php/bin/php count_player_track.php  s1 2012-04-20 2012-04-20 
 *  
 */

include_once '../config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global_not_auth.php';
global $server_db;
$loadServerList = getAvailableServerList();

//echo $argc."\n";
//print_r($argv);

$sql     = '';
$message = '';
$error   = 0;

if(1 == $argc){
	$server = 'all';
    	$startTimeStamp = strtotime(date("Y-m-d",strtotime("-1day")));
    	$endTimeStamp = $startTimeStamp + 86399;
}else if(4 == $argc){
	$server = $argv[1];
	//验证服号
	if(isset($server) && $server != 'all'){
		foreach ($loadServerList as $l=>$t){
				$serverArr[] = $l;
		}
		if(in_array($server,$serverArr)) {
			true;
		} else {
			echo $message .= "服务器代号不存在,请输入正确的服号!";
			exit;
		}
	}
    	$startDate = $argv[2];
    	$endDate   = $argv[3];
	//日期验证
	$checkOne  = explode('-',$startDate);
	$checkTwo  = explode('-',$endDate);
	if(checkdate($checkOne[1],$checkOne[2],$checkOne[0])) {
    	$startTimeStamp = strtotime($startDate);
	} else {
		echo $message .= "开始日期格式不正确，请重新输入!";
		exit;
	}
	if(checkdate($checkTwo[1],$checkTwo[2],$checkTwo[0])) {
    	$endTimeStamp   = strtotime($endDate." 23:59:59");
	} else {
		echo $message .= "结束日期格式不正确，请重新输入!";
		exit;
	}
	if($startTimeStamp > $endTimeStamp) {
		echo $message .= " 开始日期大于结束日期 !";
	}
}else{
    $error = 1;
    echo $message .= "输入参数错误\r\n"."格式应该如这样：/usr/local/php/bin/php count_player_track.php  all 2012-04-20 2012-04-25\r\n". "==============:   执行php  文件路径及文件名  选择服  开始日期  结束日期 ";
}

if(!$error && '' == $message){

		if(!$server_db){
			$server_db =  new DBMysqlClass();
		}
		foreach ($loadServerList as $k => $v) {

			if($server =='all'){
				true;
			} else {
				if($server !=$k){
					continue;
				}
			}

			for ($i=0; $i<($endTimeStamp - $startTimeStamp + 1)/86400; $i++){

				$startTime     = $startTimeStamp + $i*86400;
				$endTime       = $startTime + 86399;

				if(isset($loadServerList)){
				//每天开服分类统计
				$sql = "select mtime,step,count(distinct account_name) user_num,count(distinct ip) dist_ip_num  from ".T_LOG_CREATE_LOSS." WHERE mtime>={$startTime} and mtime<={$endTime} group by step order by step";

				if($server == 'all'){
						$config = getLogDb($loadServerList[$k]);
						$server_db->connect($config);
				} else {
						$config = getLogDb($loadServerList[$server]);
						$server_db->connect($config);
				}

				$rs = 0;
				$rs = GFetchRowSet($sql,'step');
				$agentId  = PROXYID;
				$serverId = substr($k,1);
				$result   = array();
				foreach ($rs as $key => $value) {
					$result['agent_id']  = $agentId;	
					$result['server_id'] = $serverId;	
					$result['countTime'] = strtotime(date('Y-m-d',$value['mtime']).' 0:0:0');
					$result['mtime'] = strtotime(date('Y-m-d',($value['mtime']+86400)).' 0:0:0');
					switch ($key) {
						case 0:
							$result['create_roles_account'] = $value['user_num'];
							$result['create_roles_account_ip'] = $value['dist_ip_num'];
						case 1:
							$result['create_roles'] = $value['user_num'];
							$result['create_roles_ip'] = $value['dist_ip_num'];
						case 2:
							$result['toGameCount'] = $value['user_num'];
							$result['toGameCount_ip'] = $value['dist_ip_num'];
						case 3:
							$result['finishGuideCount'] = $value['user_num'];
							$result['finishGuideCount_ip'] = $value['dist_ip_num'];
					}
				}
				
				try{

						if(count($result)>0) {
							//检查并清除历史数据		
							$delSql = "delete from ".C_PLAY_TRACK_UPDATE." where `countTime`=({$endTime}+1)";
							GQuery($delSql);
							//插入数据
							$sql = makeInsertSqlFromArray($result, C_PLAY_TRACK_UPDATE);
							GQuery($sql);
						} else {
							$message =  "【".date("Y-m-d H:i:s")."】二次统计每天新玩家（开服）数据为空";
						}

				}catch(Exception $ex){
						$message = "【".date("Y-m-d H:i:s")."】二次统计每天新玩家（开服）数据发生错误\r\n{$ex}";
				}

				}else{
						$message = "【".date("Y-m-d H:i:s")."】二次统计每天新玩家（开服）数据发生错误";
				}

			}

			if('' != $message){
						$logfile = "/tmp/msg_log_".date("Y-m-d",time()).".log";
						$handle = @fopen($logfile, "a+");
						fwrite($handle, $message);
						fclose($handle);
			}

			if($server == 'all'){
				true;
			} else { 
					if($server !=$k){
						break;
					}
			}

		}
}
