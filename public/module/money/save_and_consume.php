<?php 
/**
 * 银子日消耗统计
 * 
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';
include_once SYSDIR_ADMIN_DICT . '/arrItemsAll.php';
include_once SYSDIR_ADMIN_DICT . '/moneyConfig.php';

//include_once '../../../protected/game_config/webgame/game_function.php';
global $lang, $arrItemsAll, $moneyType, $dictMoneyType;

$openTimestamp = strtotime( ONLINEDATE );

$defaultDays = 6;//默认显示前几天的数据

$errorMsg = $successMsg = array();// 消息数组

$moneyFiled = 'SUM(money) + SUM(bind_money)';

if( !empty( $_GET['starttime'] ) )// 开始日期（从日历）
{
	$startTime 	= strtotime( SS( $_GET['starttime'] ) );
}
else
{
	$startTime 	= strtotime( "-$defaultDays days 00:00:00" );	
}

if($startTime < $openTimestamp)
{
	$startTime = $openTimestamp;
}

if( !empty( $_GET['endtime'] ) )// 结束日期（从日历）
{
	$endTime 		= strtotime( SS( $_GET['endtime'] ) . ' 23:59:59' );
}
else
{ 
	$endTime 		= strtotime( 'today 23:59:59' );
}

$countOfDays = ceil(( $endTime - $startTime) / 86400);//当前查看多少天



// 构造$andCondArray
$andCondArray = array();
$notValid = false;

if ( !empty( $startTime ) && !empty( $endTime ) && $startTime > $endTime )
{// 提供了开始和结束时间，但是开始时间大于结束时间
	$errorMsg[] = $lang->page->startTimeGtEndTime;
	$notValid = true;
}
if ( !empty( $startTime ) )
{
	$andCondArray[] = " mtime > $startTime ";
}
if ( !empty( $endTime ) )
{ 
	$andCondArray[] = " mtime < $endTime ";
}


// 初始化结果数组，保证数据的连续性
$statistics = array();
$tmpDate = date('Y-n-j', $startTime );
$endDate = date( 'Y-n-j' , $endTime );
while( true )
{
	$tmp_timestampe = strtotime( $tmpDate );
	$since_open_days = ceil(( $tmp_timestampe - $openTimestamp ) / 86400) + 1;
//	echo $tmp_timestampe - $openTimestamp ;
	$tmpDate = date( 'Y-n-j',  $tmp_timestampe);
	$statistics[$since_open_days] = array(
										'cost' 		=> array('all_cost' => 0, 'all_cost_money' => 0, 'all_cost_bind_money' => 0),
										'remain'	=> array('all_remain' => 0, 'all_remain_money' => 0, 'all_remain_bind_money' => 0),
										'increase'	=> array('all_increase' => 0, 'all_increase_money' => 0, 'all_increase_bind_money' => 0),
										'mtime'		=> $tmp_timestampe,
										'weekday'	=> date('w', $tmp_timestampe)
										);
	if( $tmpDate ==  $endDate ) 
	{// 到截止日期
		break;
	}
	
	$tmpDate = $tmpDate . ' +1 day';
}

// 当提供了查询条件则执行查询
$cond = '';
if( !$notValid && !empty( $andCondArray ))
{  
	$increaseAndCondArray = $remainAndCondArray = $costAndCondArray = $andCondArray;
	
	/* 统计银子消耗量  */
	$costAndCondArray[] = ' type >= 10000'; // 过滤银子增加的数据
	$costAndCondArray[] = ' type < 20000'; // 过滤银子增加的数据
	$costCond 	= implode( ' AND ' , $costAndCondArray ) ;
	$topAllCost = $topAllCostMoney = $topAllCostBindMoney = 0;
	$sqlCost = "SELECT 
					SUM(money) + SUM(bind_money) all_cost, SUM(money) all_cost_money, SUM(bind_money) all_cost_bind_money, mtime
				 FROM " . T_LOG_MONEY ."
				 WHERE $costCond
				 GROUP BY year, month, day;";// 统计银子消耗的SQL
	$costLogList = GFetchRowSet( $sqlCost );// 执行查询
	foreach ($costLogList as $key => &$record)// 添加银子消耗记录到结果数组
	{
		$since_open_days = ceil( ($record['mtime'] - $openTimestamp  + 1) / 86400) ;
		$statistics[$since_open_days]['cost'] = array_merge ( $statistics[$since_open_days]['cost'], $record);
		$topAllCost = $record['all_cost'] > $topAllCost? $record['all_cost'] : $topAllCost;
		$topAllCostMoney = $record['all_cost_money'] > $topAllCostMoney? $record['all_cost_money'] : $topAllCostMoney;
		$topAllCostBindMoney = $record['all_cost_bind_money'] > $topAllCostBindMoney? $record['all_cost_bind_money']:$topAllCostBindMoney;
	} 
	
	/* 统计银子存量  */
	$remainCond = implode( ' AND ' , $remainAndCondArray ) ;
	$topAllRemain = $topAllRemainMoney = $topAllRemainBindMoney = 0;
	$sqlRemain = "SELECT 
					SUM(t.remain_money) + SUM(t.remain_bind_money) all_remain, SUM(t.remain_money) all_remain_money, SUM(t.remain_bind_money) all_remain_bind_money, t.mtime
				  FROM (
				  		SELECT * 
				  		FROM (
							SELECT  
						  		t1.id, t1.account_name, t1.mtime, t1.remain_money, t1.remain_bind_money, t1.year, t1.month, t1.day 
						  	FROM " . T_LOG_MONEY ." t1 
							RIGHT JOIN
							(
								SELECT 
									account_name, remain_money, max(mtime) max_time 
								FROM " . T_LOG_MONEY ." 
								WHERE $remainCond 
								GROUP BY account_name, year, month, day
							) t2
						  	ON t1.account_name = t2.account_name and t1.mtime = t2.max_time
						  	ORDER BY t1.id DESC
				  		) tgroup
				  		GROUP BY tgroup.account_name
				  ) t 
				  GROUP BY t.year, t.month, t.day;";// 统计银子存量的SQL
	$remainLogList = GFetchRowSet( $sqlRemain );// 执行查询
//	echo $sqlRemain;
	foreach ($remainLogList as $key => &$record)// 添加银子存量记录到结果数组
	{
		$since_open_days = ceil( ($record['mtime'] - $openTimestamp  + 1) / 86400) ;
		$statistics[$since_open_days]['remain'] = array_merge ($statistics[$since_open_days]['remain'], $record );
		$topAllRemain = $record['all_remain'] > $topAllRemain? $record['all_remain'] : $topAllRemain;
		$topAllRemainMoney = $record['all_remain_money'] > $topAllRemainMoney? $record['all_remain_money'] : $topAllRemainMoney;
		$topAllRemainBindMoney = $record['all_remain_bind_money'] > $topAllRemainBindMoney? $record['all_remain_bind_money']:$topAllRemainBindMoney;
	} 
	
	/* 统计银子增加量  */
	$increaseAndCondArray[] = ' type >= 20000';
	$increaseCond = implode( ' AND ' , $increaseAndCondArray ) ;
	$topAllIncrease = $topAllIncreaseMoney = $topAllIncreaseBindMoney = 0;
	$sqlIncrease = "SELECT 
					SUM(money) + SUM(bind_money) all_increase, SUM(money) all_increase_money, SUM(bind_money) all_increase_bind_money, mtime 
				  FROM " . T_LOG_MONEY ." 
				  WHERE $increaseCond
				  GROUP BY year,month,day";// 统计银子增加量的SQL
	
	$increaseLogList = GFetchRowSet( $sqlIncrease );// 执行查询
	foreach ($increaseLogList as $key => &$record)// 添加银子增加记录到结果数组
	{
		$since_open_days = ceil( ($record['mtime'] - $openTimestamp  + 1) / 86400) ;
		$record['all_increase'] = $record['all_increase'] < 0? -$record['all_increase']: $record['all_increase'];
		$record['all_increase_money'] = $record['all_increase_money'] < 0? -$record['all_increase_money']: $record['all_increase_money'];
		$record['all_increase_bind_money'] = $record['all_increase_bind_money'] < 0? -$record['all_increase_bind_money']: $record['all_increase_bind_money'];
		
		
		$statistics[$since_open_days]['increase'] = array_merge ( $statistics[$since_open_days]['increase'], $record);
		$topAllIncrease = $record['all_increase'] > $topAllIncrease? $record['all_increase'] : $topAllIncrease;
		$topAllIncreaseMoney = $record['all_increase_money'] > $topAllIncreaseMoney? $record['all_increase_money'] : $topAllIncreaseMoney;
		$topAllIncreaseBindMoney = $record['all_increase_bind_money'] > $topAllIncreaseBindMoney? $record['all_increase_bind_money']:$topAllIncreaseBindMoney;
	}
	
	// 用于模板中循环输出
	$keyMap = array(
					'cost' => array(
									'top_all' => $topAllCost, 
									'top_all_money' => $topAllCostMoney, 
									'top_all_bind_money' => $topAllCostBindMoney,
									
									'key_all' => 'all_cost',
									'key_all_money'	=> 'all_cost_money',
									'key_all_bind_money'	=> 'all_cost_bind_money',
	
									'label_all' => $lang->money->allCost,
									'label_all_money' => $lang->money->allCostMoney,
									'label_all_bind_money' => $lang->money->allCostBindMoney,
								),
					'remain' => array(
									'top_all' => $topAllRemain, 
									'top_all_money' => $topAllRemainMoney, 
									'top_all_bind_money' => $topAllRemainBindMoney,
									
									'key_all' => 'all_remain',
									'key_all_money'	=> 'all_remain_money',
									'key_all_bind_money'	=> 'all_remain_bind_money',
	
									'label_all' => $lang->money->allRemain,
									'label_all_money' => $lang->money->allRemainMoney,
									'label_all_bind_money' => $lang->money->allRemainBindMoney,
								),
					'increase' => array(
									'top_all' => $topAllIncrease, 
									'top_all_money' => $topAllIncreaseMoney, 
									'top_all_bind_money' => $topAllIncreaseBindMoney,
									
									'key_all' => 'all_increase',
									'key_all_money'	=> 'all_increase_money',
									'key_all_bind_money'	=> 'all_increase_bind_money',
	
									'label_all' => $lang->money->allIncrease,
									'label_all_money' => $lang->money->allIncreaseMoney,
									'label_all_bind_money' => $lang->money->allIncreaseBindMoney,
								)
				);
	
	// 传递变量到模板
	$smarty->assign( 'statistics', $statistics );
	
	$smarty->assign( 'keyMap', $keyMap );
	
	
}


// 设置smarty的变量
$smarty->assign( 'player_statistics', $playerStatistics );
$minDate = $serverList[$_SESSION ['gameAdminServer']]['onlinedate'];
$maxDate = Datatime :: getTodayString();
$smarty->assign( 'minDate', $minDate);
$smarty->assign( 'maxDate', $maxDate);
$smarty->assign( 'highlightPercentage', HIGHTLIGHT_PERCENTAGE);
$smarty->assign( 'countOfDays', $countOfDays);
$smarty->assign( 'startTime', 	$startTime );
$smarty->assign( 'endTime', 	$endTime);
$smarty->assign( 'op_type' , $opType);
$smarty->assign( 'errorMsg', 	implode('<br/>', $errorMsg ) );
$smarty->assign( 'successMsg', 	implode('<br/>', $successMsg ) );
$smarty->assign( 'lang', 	$lang );
$smarty->display( 'module/money/save_and_consume.tpl' );