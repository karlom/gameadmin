<?php
/**
 * Name: gold_consume_and_save_statistics.ph
 * Description: 用于统计每日的元宝消耗与存量，不提供任何参数则默认对所有服昨天的数据进行统计
 * Usage: php wealth_statistics.php 
		--serverID=s1(不提供则对所有服进行) 
		--dateStart=2012-2-2(指定统计的开始日期，用于批量统计) 
		--dateStart=2012-2-2(指定统计的结束日期，用于批量统计) 
		--date=2012-2-2(指定统计那一天，如果指定了该参数，则dateStart和dateEnd则被忽略)
 */

include_once '../config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global_not_auth.php';
include_once 'cli.php';
global $server_db;
$loadServerList = getAvailableServerList();

$cli = new CLI();

if(!$server_db){
	$server_db =  new DBMysqlClass();
}

$serverID = $cli->getOption('serverID');
if($serverID)
{
	if(array_key_exists($serverID, $loadServerList))
	{
		$tmp = $loadServerList[$serverID];
		$loadServerList = array();
		$loadServerList[$serverID] = $tmp;
	}
	else
	{
		echo "服务器代号不存在,请输入正确的服号!\n";
		exit;
	}
}
$dateStartTimestamp = Datatime::getDayBeginTimestamp('yesterday');
$dateEndTimestamp = Datatime::getDayEndTimestamp('yesterday');
$dateStart = $cli->getOption('dateStart');
if( $dateStart )
{
	if( Validator::isDate( $dateStart ) )
	{
		$dateStartTimestamp = Datatime::getDayBeginTimestamp($dateStart);
	}
	else 
	{
		echo "开始日期的格式不正确!\n";
		exit;
	}
}

$dateEnd = $cli->getOption('dateEnd');
if( $dateEnd )
{
	if( Validator::isDate( $dateEnd ) )
	{
		$dateEndTimestamp = Datatime::getDayEndTimestamp( $dateEnd );
	}
	else 
	{
		echo "结束日期的格式不正确!\n";
		exit;
	}
}

if( $dateStartTimestamp > $dateEndTimestamp )
{
	
	echo "开始日期不能大于结束日期!\n";
	exit;
}

$date = $cli->getOption('date');
if( $date )
{
	if( Validator::isDate( $date ) )
	{
		$dateStartTimestamp = Datatime::getDayBeginTimestamp( $date );
		$dateEndTimestamp = Datatime::getDayEndTimestamp( $date );
	}
	else 
	{
		echo "指定日期的格式不正确!\n";
		exit;
	}
}



foreach($loadServerList as $key =>$server)
{
	$config = getLogDb($loadServerList[$key]);
	$server_db->connect($config);
	$result = getGoldConsumeAndSaveStatistics($dateStartTimestamp, $dateEndTimestamp);
	updateInsertRecord($result);
}
$timeUsed = $cli->getTimeUsed();
echo "总耗时：$timeUsed s\n";



function getGoldConsumeAndSaveStatistics($dateStartTimestamp, $dateEndTimestamp)
{
	$result = array();	
	$tmpDate = date( 'Y-m-j', 	$dateStartTimestamp );
	$endDate = date( 'Y-m-j' , 	$dateEndTimestamp );
	while( true )
	{// 初始化结果数组，确保数据连贯性
		$tmpTimestampe = strtotime( $tmpDate );
		$tmpDate = date( 'Y-m-d',  $tmpTimestampe);
		$result[$tmpDate] = generateEmptyRecord( $tmpTimestampe );
		if( $tmpDate ==  $endDate ) 
		{// 到截止日期
			break;
		}
		$tmpDate = $tmpDate . ' +1 day';
	}

	$generalCondArray = array();
	$generalCondArray[] = " mtime > $dateStartTimestamp "; 
	$generalCondArray[] = " mtime < $dateEndTimestamp "; 
	
	/* 统计元宝消耗量  begin*/
	$costAndCondArray = $generalCondArray;
	$costAndCondArray[] = ' type >= 10000'; // 过滤元宝增加的数据
	$costAndCondArray[] = ' type < 20000'; // 过滤元宝增加的数据
	$costCond 	= implode( ' AND ' , $costAndCondArray ) ;

	$sqlCost = "SELECT 
					SUM(gold) consume_sum_unbind, SUM(bind_gold) consume_sum_bind, mtime
				 FROM " . T_LOG_GOLD ."
				 WHERE $costCond
				 GROUP BY year, month, day;";// 统计元宝消耗的SQL
	$costLogList = GFetchRowSet( $sqlCost );// 执行查询
	
	foreach($costLogList as $recordCost)
	{
		$date = date('Y-m-d', $recordCost['mtime']);
		$result[$date]['consume_sum_unbind'] 	= $recordCost['consume_sum_unbind'];
		$result[$date]['consume_sum_bind'] 		= $recordCost['consume_sum_bind'];
	}
	/* 统计元宝消耗量  end*/
	
	/* 统计元宝增加量 begin */
	$increaseAndCondArray = $generalCondArray;
	$increaseAndCondArray[] = ' type >= 20000';
	$increaseCond = implode( ' AND ' , $increaseAndCondArray ) ;
	$sqlIncrease = "SELECT 
					SUM(gold) new_gold_sum_unbind, SUM(bind_gold) new_gold_sum_bind, mtime 
				  FROM " . T_LOG_GOLD ." 
				  WHERE $increaseCond
				  GROUP BY year,month,day";// 统计元宝增加量的SQL
	
	$increaseLogList = GFetchRowSet( $sqlIncrease );// 执行查询
	
	foreach($increaseLogList as $recordIncrease)
	{
		$date = date('Y-m-d', $recordIncrease['mtime']);
		$result[$date]['new_gold_sum_unbind'] 	= $recordIncrease['new_gold_sum_unbind'];
		$result[$date]['new_gold_sum_bind']		= $recordIncrease['new_gold_sum_bind'];
	}
	/* 统计元宝增加量 end */
	
	/* 统计近七天的登录玩家数和付费玩家数以及元宝的留存量 begin */
	foreach( $result as $key => &$r )
	{
		$dds = Datatime::getDayBeginTimestamp($key);//统计日当天开始时间戳
		$ds = $dds - 86400*6;//活跃玩家的开始时间戳
		$de = Datatime::getDayEndTimestamp($key);//活跃玩家的结束时间戳
		
		/* 统计活跃玩家数量  begin*/
		$sqlActiveUserCount = "SELECT COUNT(DISTINCT uuid) active_user_count FROM " . T_LOG_LOGIN . " WHERE mtime > $ds AND mtime < $de";
		$activeUserCount = GFetchRowOne( $sqlActiveUserCount );// 执行查询
		$r['active_user_count'] = $activeUserCount['active_user_count'];
		/* 统计活跃玩家数量  end*/
		
		/* 统计活跃付费玩家数量  begin*/
		$sqlActivePayUserCount = "SELECT COUNT(DISTINCT t1.uuid) payer_active_user_count FROM " . T_LOG_LOGIN . " t1 RIGHT JOIN " . T_LOG_PAY . " t2 ON t1.uuid = t2.uuid WHERE t1.mtime > $ds AND t1.mtime < $de";
		$activePayUserCount = GFetchRowOne( $sqlActivePayUserCount );// 执行查询
		$r['payer_active_user_count'] = $activePayUserCount['payer_active_user_count'] === null? 0 : $activePayUserCount['payer_active_user_count'];
		/* 统计活跃付费玩家数量  end*/
		
		/* 统计元宝存量  begin*/
		$remainCond = " mtime < $de ";
		$sqlRemain = "SELECT 
						 SUM(t.remain_gold) save_sum_unbind, SUM(t.remain_bind_gold) save_sum_bind
					  FROM (
					  		SELECT * 
					  		FROM (
								SELECT  
							  		t1.id, t1.role_name, t1.mtime, t1.remain_gold, t1.remain_bind_gold, t1.year, t1.month, t1.day 
							  	FROM " . T_LOG_GOLD ." t1 
								RIGHT JOIN
								(
									SELECT 
										role_name, remain_gold, max(mtime) max_time 
									FROM " . T_LOG_GOLD ." 
									WHERE $remainCond
									GROUP BY role_name, year, month, day
								) t2
							  	ON t1.role_name = t2.role_name and t1.mtime = t2.max_time
							  	ORDER BY t1.id DESC
					  		) tgroup
					  		GROUP BY tgroup.role_name
					  ) t ";// 统计元宝存量的SQL
	
		$remainLog = GFetchRowOne( $sqlRemain );// 执行查询

		$r['save_sum_unbind'] 	= $remainLog['save_sum_unbind'];
		$r['save_sum_bind'] 	= $remainLog['save_sum_bind'];
		/* 统计元宝存量  end*/
	
		/* 统计活跃玩家元宝存量  begin*/
		$remainCond2 = " in1.mtime < $de ";
		$sqlActiveRemain = "SELECT 
						 SUM(t.remain_gold) active_gold_count_unbind, SUM(t.remain_bind_gold) active_gold_count_bind
					  FROM (
					  		SELECT * 
					  		FROM (
								SELECT  
							  		t1.id, t1.uuid, t1.mtime, t1.remain_gold, t1.remain_bind_gold, t1.year, t1.month, t1.day 
							  	FROM " . T_LOG_GOLD ." t1 
								RIGHT JOIN
								(
									SELECT 
										in1.uuid, in1.remain_gold, max(in1.mtime) max_time 
									FROM " . T_LOG_GOLD ." in1
									RIGHT JOIN (
										SELECT DISTINCT(uuid) FROM " . T_LOG_LOGIN . " WHERE mtime > $ds AND mtime < $de
									) in2
									ON in1.uuid = in2.uuid
									WHERE $remainCond
									GROUP BY in1.uuid, in1.year, in1.month, in1.day
								) t2
							  	ON t1.uuid = t2.uuid and t1.mtime = t2.max_time
							  	ORDER BY t1.id DESC
					  		) tgroup
					  		GROUP BY tgroup.uuid
					  ) t ";// 统计活跃玩家元宝存量的SQL
	
		$activeRemainLog = GFetchRowOne( $sqlActiveRemain );// 执行查询
		$r['active_gold_count_unbind'] 	= $activeRemainLog['active_gold_count_unbind'];
		$r['active_gold_count_bind'] 	= $activeRemainLog['active_gold_count_bind'];
		/* 统计活跃玩家元宝存量  end*/
	}
	/* 统计近七天的登录玩家数和付费玩家数以及元宝的留存量 end */
	
	
	
	print_r($result);
	return $result;
}

// 增加一个空的记录到数组
function generateEmptyRecord($timestamp)
{
	return array(
		'mtime' 					=> Datatime::getDayBeginTimestamp(date('Y-m-d', $timestamp)),
		'user_level' 				=> -1,
		'consume_sum_unbind' 		=> 0,    	
		'consume_sum_bind' 			=> 0,  
		'save_sum_unbind' 			=> 0,    	
		'save_sum_bind' 			=> 0,  
		'new_gold_sum_unbind' 		=> 0,    	
		'new_gold_sum_bind' 		=> 0, 
		'active_user_count' 		=> 0,
		'payer_active_user_count' 	=> 0,
		'active_gold_count_unbind' 	=> 0,    	
		'active_gold_count_bind' 	=> 0, 
		'active_total' 				=> 0,
		'year' 						=> date('Y', $timestamp),
		'day'  						=> date('d', $timestamp),
		'month'						=> intval(date('m', $timestamp)),
	);
}

function updateInsertRecord($result)
{
	foreach($result as $r)
	{
		$sqlDelete = 'DELETE FROM ' . C_GOLD_CONSUME_AND_SAVE . " WHERE year={$r['year']} AND month={$r['month']} AND day={$r['day']};";
		GQuery( $sqlDelete );
		$sqlInsert = makeInsertSqlFromArray($r, C_GOLD_CONSUME_AND_SAVE);
		GQuery( $sqlInsert );
	}
}