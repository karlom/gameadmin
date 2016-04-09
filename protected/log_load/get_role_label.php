<?php
/**
 * role_label.php
 * 角色标签统计入库
 */

include_once '../config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global_not_auth.php';
global $server_db;
$loadServerList = getAvailableServerList();

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
    echo $message .= "输入参数错误\r\n"."格式应该如这样：/usr/local/php/bin/php active_loyalty_user.php  all 2012-04-20 2012-04-25\r\n". "==============:   执行php  文件路径及文件名  选择服  开始日期  结束日期 \n\r";
    exit();
}


if(!$error && !$message ){

	if(!$server_db){
		$server_db =  new DBMysqlClass();
	}
	
	foreach($loadServerList as $key => $value ) {
		
		if($server =='all'){
			true;
		} else {
			if($server !=$key){
				continue;
			}
		}
		
		for ($i=0; $i<($endTimeStamp - $startTimeStamp + 1)/86400; $i++){
			
			if(isset($loadServerList)){
				
				if($server == 'all'){
					$config = getLogDb($loadServerList[$key]);
					$server_db->connect($config);
				} else {
					$config = getLogDb($loadServerList[$server]);
					$server_db->connect($config);
				}
				
				$startTime     = $startTimeStamp + $i*86400;
				$endTime       = $startTime + 86399;
				
				$sevenDayTime  = $startTime - 86400*6;
				$threeDayTime     = $startTime - 86400*2;
				$oneHourTime = 3600;
				$threeHourTime = $oneHourTime*3;
				$eightHourTime = $oneHourTime*8;
				
				/********start 活跃标签**********/
				//活跃用户：在最近3天内至少登录一次、且在线时间总和超过1小时的用户
				$onlineSql = " select `uuid`,`account_name`, `role_name`, max(`level`) `level`, SUM(`online_time`) `total_time`,`mtime` from ".T_LOG_LOGOUT." where `mtime`>={$threeDayTime} and `mtime`<={$endTime} group by `uuid` " ; 
				//$daySql = "select distinct `uuid`,`account_name` from ".T_LOG_LOGOUT." where `mtime`>={$threeDayTime} and `mtime`<={$endTime} ";
				//$activeSql = " select a.`uuid`, a.`account_name`, a.`role_name`, a.`level`,a.`total_time`, a.`mtime` from ($actSql) as a, ($daySql) as b where a.`uuid`=b.`uuid` and a.`total_time`>$oneHourTime ";
				$activeSql = $onlineSql." having `total_time`>{$oneHourTime} ";
				
				//在线时间标签，按3天内平均在线划分
				//短在线：<1小时
				$shortOnlineSql = $onlineSql." having `total_time`<($oneHourTime*3) ";
				//中在线：1~3小时
				$middleOnlineSql = $onlineSql." having `total_time`>=($oneHourTime*3) and `total_time`<($threeHourTime*3) ";
				//长在线：3~8小时以下
				$longOnlineSql = $onlineSql." having `total_time`>=($threeHourTime*3) and `total_time`<($eightHourTime*3) ";
				//超长在线：>8小时
				$veryLongOnlineSql = $onlineSql." having `total_time`>=($eightHourTime*3) ";
				
				//久不登录
				$noLoginSql = " select * from (select `uuid`,`account_name`, `role_name`, max(`mtime`) as mtime from ".T_LOG_LOGOUT." group by uuid ) a where a.`mtime`<{$threeDayTime} ";
				
				$activeResult = GFetchRowSet($activeSql);
				$noLoginResult = GFetchRowSet($noLoginSql);
				
				$shortOnlineResult = GFetchRowSet($shortOnlineSql);
				$minddleOnlineResult = GFetchRowSet($middleOnlineSql);
				$longOnlineResult = GFetchRowSet($longOnlineSql);
				$veryLongOnlineResult = GFetchRowSet($veryLongOnlineSql);
				
				//$onlineResult = GFetchRowSet($onlineSql);
				
				/********end 活跃标签**********/
				
				/********start 等级标签 *******/
				//世界平均等级
				$levelSql = "select uuid, account_name, role_name, max(mtime) mtime, max(level) level from t_log_level_up group by uuid,account_name";
				$worldLevelSql = "select avg(a.level) as worldLevel from  ($levelSql) a ";
				
				$worldLevelRes = GFetchRowOne($worldLevelSql);
				$worldLevel = round($worldLevelRes['worldLevel'],2);
				
				//高级角色，练级角色，新手角色
				$highLevelSql = "select a.`uuid`,a.`account_name`, a.`role_name`, a.`level` from ($levelSql) a where a.level>={$worldLevel} ";
				$trainLevelSql = "select a.`uuid`,a.`account_name`, a.`role_name`, a.`level` from ($levelSql) a where a.level<{$worldLevel} and a.level>=($worldLevel/2)";
				$newcomerLevelSql = "select a.`uuid`,a.`account_name`, a.`role_name`, a.`level` from ($levelSql) a where a.level<($worldLevel/2) ";
				
				//query
				$highLevelResult =  GFetchRowSet($highLevelSql);
				$trainLevelResult =  GFetchRowSet($trainLevelSql);
				$newcomerLevelResult =  GFetchRowSet($newcomerLevelSql);
				
				/********end 等级标签 *******/
				
				
				/********start 消费标签 *******/
				
				
				$consumeSql = "select uuid, account_name, role_name, sum(gold) all_gold, count(distinct year,month) months, year, month from t_log_gold where gold<0 group by uuid, year ";
				//每月平均消费
				$avgConsumeSql = "select a.uuid, a.account_name, a.role_name, a.year, a.month, a.all_gold/a.months as avg_gold from ($consumeSql) a ";
				
				$lowConsumeSql = $avgConsumeSql." having avg_gold>=-3000 and avg_gold<0 ";
				$lessConsumeSql = $avgConsumeSql." having avg_gold>=-15000 and avg_gold<-3000 ";
				$middleConsumeSql = $avgConsumeSql." having avg_gold>=-60000 and avg_gold<-15000 ";
				$moreConsumeSql = $avgConsumeSql." having avg_gold>=-120000 and avg_gold<-60000 ";
				$highConsumeSql = $avgConsumeSql." having avg_gold<-120000 ";
				
				//no consume
				$noConsumeSql = " select r.uuid uuid, r.account_name account_name, r.role_name role_name, g.gold from ".T_LOG_REGISTER." r left join ".T_LOG_GOLD." g on r.account_name=g.account_name where g.gold is null ";
				
				//query
				$noConsumeResult =  GFetchRowSet($noConsumeSql);
				$lowConsumeResult =  GFetchRowSet($lowConsumeSql);
				$lessConsumeResult =  GFetchRowSet($lessConsumeSql);
				$middleConsumeResult =  GFetchRowSet($middleConsumeSql);
				$moreConsumeResult =  GFetchRowSet($moreConsumeSql);
				$highConsumeResult =  GFetchRowSet($highConsumeSql);
				
				/********end 消费标签 *******/
				
				/********start 交互标签 *******/
				//注重交易标签
				$where = " `mtime`>={$threeDayTime} and `mtime`<={$endTime} ";
				$dealSql =  " select uuid, account_name, role_name, count(*) as count from " . T_LOG_DEAL . " where {$where} group by uuid ";
				$marketSellSql =  " select uuid, account_name, role_name, count(*) as count from " . T_LOG_MARKET_SELL . " where {$where} group by uuid ";
				$marketBuySql =  " select uuid, account_name, role_name, count(*) as count from " . T_LOG_MARKET_BUY . " where {$where} group by uuid ";
				$dealCareSql = "select uuid, account_name, role_name, sum(count) as times from ( ($dealSql) union ($marketSellSql) union ($marketBuySql) ) a group by uuid having times >= 3 ";
				
				$careDealResult = GFetchRowSet($dealCareSql);
				
				
				//注重社交标签
				$interactiveCareResult = array();
				/********end 交互标签 *******/
				
				/********start 喜好标签 *******/
				//喜好打坐
				$where = " `mtime`>={$sevenDayTime} and `mtime`<={$endTime} ";
				$sitSql = "select uuid, account_name, role_name, sum(time) as sit_time from ". T_LOG_HANG ." where {$where} group by uuid having sit_time > 50400";
				
				$sitResult = GFetchRowSet($sitSql);
				/********end 喜好标签 *******/
				
				/*********处理数据*************/
				$data = array(
					'active' => array(
						'1' => $activeResult,
						'2' => $noLoginResult,
					),
					'online' => array(
						'1' => $shortOnlineResult,
						'2' => $minddleOnlineResult,
						'3' => $longOnlineResult,
						'4' => $veryLongOnlineResult,
				//		$onlineResult,
					),
					'level' => array(
						'1' => $highLevelResult,
						'2' => $trainLevelResult,
						'3' => $newcomerLevelResult,
					),
					'consume' => array(
						'1' => $noConsumeResult,
						'2' => $lowConsumeResult,
						'3' => $lessConsumeResult,
						'4' => $middleConsumeResult,
						'5' => $moreConsumeResult,
						'6' => $highConsumeResult,
					),
					'deal' => array(
						'1' => $careDealResult,
					),
					'sit' => array(
						'1' => $careDealResult,
					),
					
				);
				$insertData = array();
				$mtime = time();
				$mdate = date("Y-m-d H:i:s",$mtime);
				foreach($data as $label => $results){
					foreach($results as $k => $v){
						if(!empty($v)){
							foreach($v as $j => $w) {
								$uuid = $w['uuid'];
								$insertData[$uuid]['uuid'] = $uuid;
								$insertData[$uuid]['account_name'] = $w['account_name'];
								$insertData[$uuid]['role_name'] = $w['role_name'];
								$insertData[$uuid]['mtime'] = $mtime;
								$insertData[$uuid]['mdate'] = $mdate;
								$insertData[$uuid]['last_update_word'] .= $label."|";
								$insertData[$uuid][$label] = $k;
								if($label == "online" && !$insertData[$uuid]['active']) {
									$insertData[$uuid]['active'] = 0;
								}
							}
						}
						
					}
				}
	//			echo "******************************\n\r";
				//print_r($insertData);
				foreach($insertData as $k => $v){
					$rt = makeDuplicateInsertSqlFromArray($v, C_ROLE_LABEL);
			//		echo " ** ";print_r($rt);echo "\n\r\n\r";
					GQuery($rt);
				}
			
			}else{
				$message = "【".date("Y-m-d H:i:s")."】二次统计活跃用户数数据发生错误";
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
				if($server != $key){
					break;
				}
			}
			
		}
	}
}