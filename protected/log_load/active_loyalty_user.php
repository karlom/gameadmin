<?php
/**
 * 调用方式:
 * 每天零晨跑一次,活跃与忠诚用户数
 * /usr/local/php/bin/php active_loyalty_user.php s1(服务器)
 *
 * 说明：
 * 活跃用户：最近7天总在线时间不低于7小时的用户。并且最近三天(有一天登录即可)有登录 
 * 忠诚用户：最近7天(不是周区间)最少有3次登录，每天登录多次只算1次，并且玩家级别大于等于20级。 
 * 平均在线：某一天的 09:00:00--23:59:59 期间，游戏实际在线数的平均数值。 （不是24小时平均，因为0点到8点，半夜，人数太少，没有实际统计意义） 
 * -----------------------------------------------------------------------------------------------------------------------------------------
 * 关于运维跑脚本获得一定时间内的数据说明： 
 * 执行脚本方式： /usr/local/php/bin/php active_loyalty_user.php  服务器 开始日期 结束日期 
 * 执行脚本示例： /usr/local/php/bin/php active_loyalty_user.php  s1 2012-04-20 2012-04-25
 * s1 为服务器 ； 
 * 2012-04-20 为开始日期
 * 2012-04-25 为结束日期
 * ----------------------------------------------------------------------------------------------------------------------------------------- 
 * 附特殊情况: 
 * 所有服(all)：/usr/local/php/bin/php active_loyalty_user.php  all 2012-04-20 2012-04-25 
 * 只跑某一天的：/usr/local/php/bin/php active_loyalty_user.php  s1 2012-04-20 2012-04-20 
 *  
 * 另外说明：脚本跑的数据会导入两张表：1.T_LOG_ACTIVE_LOYALTY_USER; 2.T_LOGACTIVE_LEVEL_USER 
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
    echo $message .= "输入参数错误\r\n"."格式应该如这样：/usr/local/php/bin/php active_loyalty_user.php  all 2012-04-20 2012-04-25\r\n". "==============:   执行php  文件路径及文件名  选择服  开始日期  结束日期 ";
}

if(!$error && '' == $message){

		if(!$server_db){
			$server_db =  new DBMysqlClass();
		}
		$allArr = array();
		$activeLevel = array();
		$loyaltyArr  = array();
		$onlineArr   = array();
		$registerArr = array();
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
				$curHistoryTime= time() - strtotime(date('Y-m-d')) + $startTime;

				$sevenStrTime  = $startTime - 86400*6;
				$threeTime     = $startTime - 86400*2;
				$sevenHourTime = 3600*7;

				if(isset($loadServerList)){

				//======活跃用户, 并且参与各副本的20级,25级,30级,35级,40级,45级活跃用户数 ================
				//活跃用户：最近7天总在线时间不低于7小时的用户。并且最近三天(有一天登录即可)有登录; 
				$actSql = " select `account_name`, max(`level`) `level`, SUM(`online_time`) `total_time`,`mtime` from ".T_LOG_LOGOUT." where `mtime`>={$sevenStrTime} and `mtime`<={$endTime} group by `account_name`" ; 

				$daySql = "select distinct `account_name` from ".T_LOG_LOGOUT." where `mtime`>={$threeTime} and `mtime`<={$endTime} "; 

				//活跃用户数
				$activeSql = " select a.`account_name`, a.`level`, a.`mtime` from ($actSql) as a, ($daySql) as b where a.`account_name`=b.`account_name` and a.`total_time`>$sevenHourTime ";

				//进入副本用户数
				$copySql   = " select distinct `account_name`, `map_id`, `level` from ".T_LOG_COPY_SCENE." where `mtime`>={$startTime} and `mtime`<={$endTime} and `status`=0 group by `map_id`,`account_name` "; 

				//进入副本活跃用户数
				$copyActiveSql = " select count(C.`account_name`) `copy_count`, D.`map_id` from ($activeSql) C, ($copySql) D where C.`account_name`=D.`account_name` group by D.`map_id` ";

				if($server == 'all'){
						$config = getLogDb($loadServerList[$k]);
						$server_db->connect($config);
				} else {
						$config = getLogDb($loadServerList[$server]);
						$server_db->connect($config);
				}
				$activeResult = 0;
				$activeResult = GFetchRowSet($activeSql);
				$copyActiveResult = GFetchRowSet($copyActiveSql,'map_id') ;
				$serverId = $k;
	
				$active_total = array();
				foreach ($activeResult as $key => $value){
					if( $value['level'] ){
						//活跃用户总数
						$active_total[$serverId][$endTime] += 1;	
					}
				}
				//======== end ==================


				//=======忠诚用户：===============
				//忠诚用户：最近7天(不是周区间)最少有3次登录，每天登录多次只算1次，并且玩家级别大于等于20级。 
				$loyaltySql = " select `account_name`,max(mtime) logout_time,day from ".T_LOG_LOGOUT." where `mtime`>={$sevenStrTime} and `mtime` <={$endTime} and `level`>20 group by `account_name`, `day` ";
				$loyaltyRs  = GFetchRowSet($loyaltySql); 
				$loyalty = array();
				foreach ($loyaltyRs as $key2 => $value2){
							$loyaltyArr[$serverId][$endTime][$value2['account_name']][$key2] = array('account_name'=>$value2['account_name'],'logout_time'=>$value2['logout_time'],'day'=>$value2['day']);
							if( count($loyaltyArr[$serverId][$endTime][$value2['account_name']]) >=3 ){
								//忠诚用户数
								$loyalty[$serverId][$endTime] += 1;	
							}
				}
				//======== end ==================


				//=======最大在线,平均在线 ============
				$onlineMaxSql = " select max(`online`) `max_online` from ".T_LOG_ONLINE." where `mtime`>={$startTime} and `mtime`<={$endTime} ";
				$onlineMaxRs = GFetchRowOne($onlineMaxSql); 
				
				$onlineAvgSql = " select avg(`online`) `avg_online` from ".T_LOG_ONLINE." where `mtime`>=($startTime+3600*9) and `mtime`<={$endTime} ";
				$onlineAvgRs = GFetchRowOne($onlineAvgSql); 

				$maxOnline = $onlineMaxRs['max_online'];
				$avgOnline = $onlineAvgRs['avg_online']; 
				//======== end ==================
				

				//=======全部注册用户数，当天新注册用户数 ========
				$regTotalSql = " select count(`uuid`) `all_register` from ".T_LOG_REGISTER." where `mtime`<={$endTime} ";
				$regTotalRs = GFetchRowOne($regTotalSql); 

				$regNewSql  = " select count(`uuid`) `new_register` from ".T_LOG_REGISTER." where `mtime`>={$startTime} and `mtime`<={$endTime} ";
				$regNewRs = GFetchRowOne($regNewSql); 

				$allRegister = $regTotalRs['all_register'];
				$newRegister = $regNewRs['new_register']; 
				//======== end ==================

				try{
						//检查并清除历史数据		
						$delSql = "delete from ".T_LOG_ACTIVE_LOYALTY_USER." where `mtime`=({$endTime}+1)";
						GQuery($delSql);
	
						//插入数据
						foreach ($copyActiveResult as $k2 => $v2) {
								$allArr = array( 
									'mtime'  	    => $endTime+1,	
									'active'        => $active_total[$serverId][$endTime],	
									'loyal'	    	=> $loyalty[$serverId][$endTime],	
									'max_online'	=> $maxOnline,
									'avg_online'	=> $avgOnline, 
									'total_user'	=> $allRegister,
									'new_user'  	=> $newRegister,
									'map_id'  	    => $v2['map_id'],	
									'active_level'  => $v2['copy_count'],	
									'year'      	=> date('Y',$curHistoryTime),
									'month'  	    => date('m',$curHistoryTime),
									'day'  	        => date('d',$curHistoryTime),
									'hour'  	    => date('H',$curHistoryTime),
									'min'  	        => date('i',$curHistoryTime),
								);
								if(is_array($allArr)) {
									$sql = makeInsertSqlFromArray($allArr, T_LOG_ACTIVE_LOYALTY_USER);
									GQuery($sql);
								}
						}

						//检查并清除历史数据		
						$ymd = date('Ymd',$startTime);
						$delSqlLevel = "delete from ".T_LOG_ACTIVE_LEVEL_USER." where `ymd`={$ymd}";
						GQuery($delSqlLevel);

						//跑第二个统计表(t_log_active_level_user)的日各级活跃用户数据，不跑统计结果,只跑用户
						$activeLevelUser = array();
						foreach ($activeResult as $lk => $lv){
							$activeLevelUser[$lk] = array(
								'mtime'        => $endTime,
								'account_name' => $lv['account_name'],
								'level'        => $lv['level'],
								'ymd'          => date('Ymd',$endTime),
							);	
							if(is_array($activeLevelUser[$lk])) {
								$sql2 = makeInsertSqlFromArray($activeLevelUser[$lk], T_LOG_ACTIVE_LEVEL_USER);
								GQuery($sql2);
							}
						}

				}catch(Exception $ex){
						$message = "【".date("Y-m-d H:i:s")."】二次统计活跃与忠诚用户数数据发生错误\r\n{$ex}";
				}
			}else{
						$message = "【".date("Y-m-d H:i:s")."】二次统计活跃与忠诚用户数数据发生错误";
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
}
