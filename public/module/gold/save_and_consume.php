<?php 
/**
 * 货币存量与消耗统计
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';
include_once SYSDIR_ADMIN_DICT . '/arrItemsAll.php';

//include_once '../../../protected/game_config/webgame/game_function.php';
global $lang, $arrItemsAll;

$openTimestamp = strtotime( ONLINEDATE );

$defaultDays = 6;//默认显示前几天的数据

$errorMsg = $successMsg = array();// 消息数组

$today = date('Y-m-d');
$currentTimestamp = time();
$todayTimestamp = strtotime($today);

if( !empty( $_GET['starttime'] ) ) {
	// 开始日期（从日历）
	$startTime 	= strtotime( SS( $_GET['starttime'] ) );
}
else {
//	$startTime 	= strtotime( "-$defaultDays days 00:00:00" );
	$startTime = $todayTimestamp;
}
if($startTime < $openTimestamp) {
	$startTime = $openTimestamp;
}
if($startTime >= $todayTimestamp) {
	$startTime = $todayTimestamp;
}

$endTime = $startTime + 86400;


$onlineDays = ceil(( $startTime - $openTimestamp) / 86400);	//已开服天数

// 构造$andCondArray
$andCondArray = array();
$notValid = false;

if ( !empty( $startTime ) && !empty( $endTime ) && $startTime > $endTime )
{// 提供了开始和结束时间，但是开始时间大于结束时间
	$errorMsg[] = $lang->page->startTimeGtEndTime;
	$notValid = true;
}

//$andCondArray[] = " 1=1 ";
if ( !empty( $startTime ) )
{
	$andCondArray[] = " mtime >= $startTime ";
}
if ( !empty( $endTime ) )
{ 
	$andCondArray[] = " mtime < $endTime ";
}

//消费类型
$type = array(8,
	10,11,12,13,14,15,16,17,	//神炉
	28,29,	//商店购买
	30,31,57,	//背包、仓库增加格子
	32,33,34,35,46,	//宠物
	38,39,40,41,	//家园
	43,
	48,49,50,	//境界提升
	58,61,64,
	);
$type_gold = $type_liquan = "";
foreach($type as $t) {
	$type_gold .= ($t+20000) . ",";
	$type_liquan .= ($t+50000) . ",";
}
$type_gold = rtrim($type_gold,',');
$type_liquan = rtrim($type_liquan,',');

// 初始化结果数组，保证数据的连续性
$statistics = array();


// 当提供了查询条件则执行查询
if( !$notValid && !empty( $andCondArray ))
{  
// --- gold ---
	$remainGoldAndCondArray = $costGoldAndCondArray = $consumeGoldAndCondArray = $andCondArray;
	
	/* 统计元宝消耗量  */
	$consumeGoldAndCondArray[] = " type in ( {$type_gold} ) ";	//商场购买道具
	$consumeGoldCond 	= implode( ' AND ' , $consumeGoldAndCondArray ) ;
	
	$costGoldAndCondArray[] = ' gold < 0 ';
	$costGoldCond 	= implode( ' AND ' , $costGoldAndCondArray ) ;
	
	$allConsumeGold = 0;	//总消费元宝，不包括 寄卖购买物品、游戏币所消耗的元宝
	$allCostGold = 0;	//总消耗元宝
	
	$sqlCostGold = "SELECT SUM(gold) all_cost_gold 
				FROM " . T_LOG_GOLD ."
				WHERE $costGoldCond 
				";	//统计元宝总消耗
	$costGold = GFetchRowSet($sqlCostGold);
	$allCostGold = ($costGold) ? $costGold[0]['all_cost_gold'] : 0 ;
	
	$sqlConsumeGold = "SELECT 
					uuid, account_name, role_name, level, SUM(gold) all_consume_gold, mtime
				 FROM " . T_LOG_GOLD ."
				 WHERE $consumeGoldCond
				 GROUP BY uuid 
				 ORDER BY all_consume_gold ;";// 统计元宝消费的SQL
//	echo "</br>consume= ".$sqlConsumeGold;
	$consumeGoldList = GFetchRowSet( $sqlConsumeGold );// 执行查询
//	print_r($consumeGoldList);
	foreach ($consumeGoldList as $key => &$record)// 添加元宝消耗记录到结果数组
	{
		$allConsumeGold += $record['all_consume_gold'];	//消费总元宝
	} 
	
	$goldCost = array();
	$goldCost['consumeList'] = $consumeGoldList;
	$goldCost['allCostGold'] = $allCostGold;
	
	/* 统计元宝存量  */
//	$remainCondGold = implode( ' AND ' , $remainGoldAndCondArray ) ;
	$sqlRemainGold = "SELECT t1.last_login_time,t3.max_id, t2.uuid, t2.account_name,t2.role_name,t2.level,t2.remain_gold 
				FROM 
					(SELECT MAX(mtime) last_login_time, uuid, account_name FROM " . T_LOG_LOGIN . " GROUP BY uuid ) t1, 
					(SELECT MAX(id) max_id, uuid, account_name FROM " . T_LOG_GOLD . " GROUP BY uuid) t3, " .
					T_LOG_GOLD. " t2 
				WHERE 
					t3.uuid=t1.uuid AND t1.uuid=t3.uuid AND t2.id=t3.max_id  
				ORDER BY t2.remain_gold DESC";	// 统计元宝存量的SQL
	$remainGoldList = GFetchRowSet( $sqlRemainGold );// 执行查询	
	
	$activeGold = $allRemainGold = 0;
	
	foreach ($remainGoldList as $key => &$record)// 添加元宝存量记录到结果数组
	{
//		$since_open_days = ceil( ($record['mtime'] - $openTimestamp  + 1) / 86400) ;
		$allRemainGold += $record['remain_gold'] ;
		if ( $todayTimestamp - $record['last_login_time'] < 604800 ) {
			//最后登录时间距离现在在7天以内的
			$activeGold += $record['remain_gold'];
		}
	} 
	
	$goldRemain = array();
	$goldRemain['remainList'] = $remainGoldList;
	$goldRemain['allRemainGold'] = $allRemainGold;
	$goldRemain['activeGold'] = $activeGold;
		
	$gold = array( 'gold_remain' => $goldRemain , 'gold_cost' => $goldCost,);
	
	$statistics['gold'] = $gold;

// --- liquan ---
	$remainLiquanAndCondArray = $costLiquanAndCondArray = $consumeLiquanAndCondArray = $andCondArray;
	
//	 统计礼券消耗量  
	$consumeLiquanAndCondArray[] = " type in ( {$type_liquan} ) ";	//商场购买道具
	$consumeLiquanCond 	= implode( ' AND ' , $consumeLiquanAndCondArray ) ;
	
	$costLiquanAndCondArray[] = ' liquan < 0 ';
	$costLiquanCond 	= implode( ' AND ' , $costLiquanAndCondArray ) ;
	
	$allConsumeLiquan = 0;	//总消费礼券，不包括 寄卖购买物品、游戏币所消耗的礼券
	$allCostLiquan = 0;	//总消耗礼券
	
	$sqlCostLiquan = "SELECT SUM(liquan) all_cost_liquan FROM " . T_LOG_LIQUAN ."	WHERE $costLiquanCond ";	//统计礼券总消耗

	$costLiquan = GFetchRowSet($sqlCostLiquan);
	$allCostLiquan = ($costLiquan) ? $costLiquan[0]['all_cost_liquan'] : 0 ;
	
	$sqlConsumeLiquan = "SELECT 
					uuid, account_name, role_name, level, SUM(liquan) all_consume_liquan, mtime
				 FROM " . T_LOG_LIQUAN ."
				 WHERE $consumeLiquanCond
				 GROUP BY uuid 
				 ORDER BY all_consume_liquan ;";// 统计礼券消费的SQL

	$consumeList = GFetchRowSet( $sqlConsumeLiquan );// 执行查询
//	print_r($consumeList);
	foreach ($consumeList as $key => &$record)// 添加礼券消耗记录到结果数组
	{
		$allConsumeLiquan += $record['all_consume_liquan'];	//消费总礼券
	} 
	
	$liquanCost = array();
	$liquanCost['consumeList'] = $consumeList;
	$liquanCost['allCostLiquan'] = $allCostLiquan;
	
	/* 统计礼券存量  */
//	$remainLiquanCond = implode( ' AND ' , $remainLiquanAndCondArray ) ;
	
	$sqlRemainLiquan = "SELECT t1.last_login_time,t3.max_id,t2.uuid, t2.account_name,t2.role_name,t2.level,t2.remain_liquan 
				FROM 
					(SELECT MAX(mtime) last_login_time, uuid, account_name FROM " . T_LOG_LOGIN . " GROUP BY uuid ) t1, 
					(SELECT MAX(id) max_id, uuid, account_name FROM " . T_LOG_LIQUAN . " GROUP BY uuid) t3, " .
					T_LOG_LIQUAN. " t2 
				WHERE 
					t3.uuid=t1.uuid AND t1.uuid=t3.uuid AND t2.id=t3.max_id  
				ORDER BY t2.remain_liquan DESC";		// 统计礼券存量的SQL
	$remainLiquanList = GFetchRowSet( $sqlRemainLiquan );// 执行查询	
	
	$activeLiquan = $allRemainLiquan = 0;
	
	foreach ($remainLiquanList as $key => &$record)// 添加礼券存量记录到结果数组
	{
//		$since_open_days = ceil( ($record['mtime'] - $openTimestamp  + 1) / 86400) ;
		$allRemainLiquan += $record['remain_liquan'] ;
		if ( $todayTimestamp - $record['last_login_time'] < 604800 ) {
			//最后登录时间距离现在在7天以内的
			$activeLiquan += $record['remain_liquan'];
		}
	} 
	
	$liquanRemain = array();
	$liquanRemain['remainList'] = $remainLiquanList;
	$liquanRemain['allRemainLiquan'] = $allRemainLiquan;
	$liquanRemain['activeLiquan'] = $activeLiquan;
		
	$liquan = array( 'liquan_remain' => $liquanRemain , 'liquan_cost' => $liquanCost,);
	
	$statistics['liquan'] = $liquan;
//	---- Liquan end ----

// ---- money start ----
	$remainMoneyAndCondArray = $andCondArray;
/*
	$sqlRemainMoney = "SELECT t2.account_name,t2.role_name,t2.level,t2.remain_money,t2.last_login_time 
				FROM 
				(SELECT MAX(t1.lmtime) last_login_time,t1.* 
					FROM 
						(SELECT l.mtime lmtime, g.* 
							FROM " . T_LOG_MONEY . " g 
							LEFT JOIN " . T_LOG_LOGIN . " l ON l.account_name = g.account_name 
						) t1 
					GROUP BY id,account_name 
				) t2 
				JOIN
				(SELECT MAX(mtime) last_mtime,account_name 
					FROM  " . T_LOG_MONEY . "
					GROUP BY account_name
				) t3 
				ON t2.mtime = t3.last_mtime 
				ORDER BY t2.remain_money DESC ";	// 统计银两存量的SQL
*/
	$sqlRemainMoney = "SELECT t1.last_login_time,t3.max_id, t2.uuid, t2.account_name,t2.role_name,t2.level,t2.remain_money 
				FROM 
					(SELECT MAX(mtime) last_login_time, uuid, account_name FROM " . T_LOG_LOGIN . " GROUP BY uuid ) t1, 
					(SELECT MAX(id) max_id, uuid, account_name FROM " . T_LOG_MONEY . " GROUP BY uuid) t3, " .
					T_LOG_MONEY. " t2 
				WHERE 
					t3.uuid=t1.uuid AND t1.uuid=t3.uuid AND t2.id=t3.max_id AND t2.remain_money>10000 
				ORDER BY t2.remain_money DESC";		// 统计银两存量的SQL		
	$remainMoneyList = GFetchRowSet( $sqlRemainMoney );// 执行查询	
	
	$activeMoney = $allRemainMoney = 0;
	
	foreach ($remainMoneyList as $key => &$record)// 添加银两存量记录到结果数组
	{
		$allRemainMoney += $record['remain_money'] ;
		if ( $todayTimestamp - $record['last_login_time'] < 604800 ) {
			//最后登录时间距离现在在7天以内的
			$activeMoney += $record['remain_money'];
		}
	} 
	
	$moneynRemain = array();
	$moneyRemain['remainList'] = $remainMoneyList;
	$moneyRemain['allRemainMoney'] = $allRemainMoney;
	$moneyRemain['activeMoney'] = $activeMoney;
		
	$money = array( 'money_remain' => $moneyRemain , );
	
	$statistics['money'] = $money;
// ---- money end ----

	//寄卖手续费
	$where 	= implode( ' AND ' , $andCondArray ) ;
	$whereFeeMoney = $where . " AND `money` <0 AND `type` = 30018 ";
	$whereFeeGold = $where . " AND `gold` <0 AND `type` = 20018 ";
	
	$sqlMarketSellFeeMoney = "select sum(`money`) as `money` from t_log_money where $whereFeeMoney  ";
	$sqlMarketSellFeeGold = "select sum(`gold`) as `gold` from t_log_gold where $whereFeeGold  ";
	
	$sqlMarketSellFeeMoneyResult = GFetchRowOne( $sqlMarketSellFeeMoney );
	$sqlMarketSellFeeGoldResult = GFetchRowOne( $sqlMarketSellFeeGold );
	
	$statistics['marketSellFee'] = array(
		'money' => $sqlMarketSellFeeMoneyResult['money'] ? -$sqlMarketSellFeeMoneyResult['money'] : 0,
		'gold' => $sqlMarketSellFeeGoldResult['gold'] ? -$sqlMarketSellFeeGoldResult['gold'] : 0,
	);
	
	// 传递变量到模板
	$smarty->assign( 'statistics', $statistics );
}


// 设置smarty的变量
$minDate = $serverList[$_SESSION ['gameAdminServer']]['onlinedate'];
$maxDate = Datatime :: getTodayString();
$smarty->assign( 'minDate', $minDate);
$smarty->assign( 'maxDate', $maxDate);
$smarty->assign( 'highlightPercentage', HIGHTLIGHT_PERCENTAGE);
$smarty->assign( 'onlineDays', $onlineDays);
$smarty->assign( 'currentTime', $currentTimestamp);
$smarty->assign( 'startTime', 	$startTime );
$smarty->assign( 'endTime', 	$endTime);
$smarty->assign( 'errorMsg', 	implode('<br/>', $errorMsg ) );
$smarty->assign( 'successMsg', 	implode('<br/>', $successMsg ) );
$smarty->assign( 'lang', 	$lang );
$smarty->display( 'module/gold/save_and_consume.tpl' );
