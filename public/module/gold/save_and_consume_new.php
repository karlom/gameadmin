<?php 
/**
 * 元宝日消耗统计
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';
include_once SYSDIR_ADMIN_DICT . '/arrItemsAll.php';
include_once SYSDIR_ADMIN_DICT . '/goldConfig.php';

//include_once '../../../protected/game_config/webgame/game_function.php';
global $lang, $arrItemsAll, $goldType, $dictGoldType;

$openTimestamp = strtotime( ONLINEDATE );

$defaultDays = 6;//默认显示前几天的数据

$errorMsg = $successMsg = array();// 消息数组

$goldFiled = 'SUM(gold) + SUM(bind_gold)';

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
	$andCondArray[] = " mtime >= $startTime ";
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
										'cost' 		=> array('all_cost' => 0, 'all_cost_gold' => 0, 'all_cost_bind_gold' => 0),
										'remain'	=> array('all_remain' => 0, 'all_remain_gold' => 0, 'all_remain_bind_gold' => 0),
										'increase'	=> array('all_increase' => 0, 'all_increase_gold' => 0, 'all_increase_bind_gold' => 0),
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
	$cond = implode( ' AND ' , $andCondArray ) ;
	$sql = 'SELECT * FROM ' . C_GOLD_CONSUME_AND_SAVE . ' WHERE ' . $cond;
	$result = GFetchRowSet($sql);
	$topAllCost = $topAllCostGold = $topAllCostBindGold = 0;
	$sumAllCost = $sumAllCostGold = $sumAllCostBindGold = 0;
	$topAllRemain = $topAllRemainGold = $topAllRemainBindGold = 0;
	$sumAllRemain = $sumAllRemainGold = $sumAllRemainBindGold = 0;
	$topAllIncrease = $topAllIncreaseGold = $topAllIncreaseBindGold = 0;
	$sumAllIncrease = $sumAllIncreaseGold = $sumAllIncreaseBindGold = 0;
	
	foreach($result as $r)
	{
		$since_open_days = ceil(( $r['mtime'] - $openTimestamp ) / 86400) + 1;
		
		//元宝消耗
		$statistics[$since_open_days]['cost']['all_cost'] = $r['consume_sum_unbind'] + $r['consume_sum_bind'];
		$statistics[$since_open_days]['cost']['all_cost_gold'] = $r['consume_sum_unbind'];
		$statistics[$since_open_days]['cost']['all_cost_bind_gold'] = $r['consume_sum_bind'];
		$topAllCost = max( array($statistics[$since_open_days]['cost']['all_cost'], $topAllCost) );
		$topAllCostGold = max( array($statistics[$since_open_days]['cost']['all_cost_gold'], $topAllCostGold) );
		$topAllCostBindGold = max( array($statistics[$since_open_days]['cost']['all_cost_bind_gold'], $topAllCostBindGold) ); 
		$sumAllCost += $statistics[$since_open_days]['cost']['all_cost'];
		$sumAllCostGold += $statistics[$since_open_days]['cost']['all_cost_gold'];
		$sumAllCostBindGold += $statistics[$since_open_days]['cost']['all_cost_bind_gold'];
		
		//元宝存量
		$statistics[$since_open_days]['remain']['all_remain'] = $r['save_sum_unbind'] + $r['save_sum_bind'];
		$statistics[$since_open_days]['remain']['all_remain_gold'] = $r['save_sum_unbind'];
		$statistics[$since_open_days]['remain']['all_remain_bind_gold'] = $r['save_sum_bind'];
		$topAllRemain = max( array($statistics[$since_open_days]['remain']['all_remain'], $topAllRemain) );
		$topAllRemainGold = max( array($statistics[$since_open_days]['remain']['all_remain_gold'], $topAllRemainGold) );
		$topAllRemainBindGold = max( array($statistics[$since_open_days]['remain']['all_remain_bind_gold'], $topAllRemainBindGold) );
		$sumAllRemain += $statistics[$since_open_days]['remain']['all_remain'];
		$sumAllRemainGold += $statistics[$since_open_days]['remain']['all_remain_gold'];
		$sumAllRemainBindGold += $statistics[$since_open_days]['remain']['all_remain_bind_gold'];
		
		//元宝新增
		$record['all_increase'] = $record['all_increase'] < 0? -$record['all_increase']: $record['all_increase'];
		$record['all_increase_gold'] = $record['all_increase_gold'] < 0? -$record['all_increase_gold']: $record['all_increase_gold'];
		$record['all_increase_bind_gold'] = $record['all_increase_bind_gold'] < 0? -$record['all_increase_bind_gold']: $record['all_increase_bind_gold'];
		
		
		$statistics[$since_open_days]['increase']['all_increase'] = max( array( -($r['new_gold_sum_unbind'] + $r['new_gold_sum_bind']), ($r['new_gold_sum_unbind'] + $r['new_gold_sum_bind'])) );
		$statistics[$since_open_days]['increase']['all_increase_gold'] = $r['new_gold_sum_unbind'];
		$statistics[$since_open_days]['increase']['all_increase_bind_gold'] = $r['new_gold_sum_bind'];
		$topAllIncrease = max( array($statistics[$since_open_days]['increase']['all_increase'], $topAllIncrease) );
		$topAllIncreaseGold = max( array($statistics[$since_open_days]['increase']['all_increase_gold'], $topAllIncreaseGold) );
		$topAllIncreaseBindGold = max( array($statistics[$since_open_days]['increase']['all_increase_bind_gold'], $topAllIncreaseBindGold) );
		$sumAllIncrease += $statistics[$since_open_days]['increase']['all_increase'];
		$sumAllIncreaseGold += $statistics[$since_open_days]['increase']['all_increase_gold'];
		$sumAllIncreaseBindGold += $statistics[$since_open_days]['increase']['all_increase_bind_gold'];
	}
	
	// 用于模板中循环输出
	$keyMap = array(
					'cost' => array(
									'top_all' => $topAllCost, 
									'top_all_gold' => $topAllCostGold, 
									'top_all_bind_gold' => $topAllCostBindGold,

									'sum_all' => $sumAllCost, 
									'sum_all_gold' => $sumAllCostGold, 
									'sum_all_bind_gold' => $sumAllCostBindGold,
									
									'key_all' => 'all_cost',
									'key_all_gold'	=> 'all_cost_gold',
									'key_all_bind_gold'	=> 'all_cost_bind_gold',
	
									'label_all' => $lang->gold->allCost,
									'label_all_gold' => $lang->gold->allCostGold,
									'label_all_bind_gold' => $lang->gold->allCostBindGold,
								),
					'remain' => array(
									'top_all' => $topAllRemain, 
									'top_all_gold' => $topAllRemainGold, 
									'top_all_bind_gold' => $topAllRemainBindGold,

									'sum_all' => $sumAllRemain, 
									'sum_all_gold' => $sumAllRemainGold, 
									'sum_all_bind_gold' => $sumAllRemainBindGold,
									
									'key_all' => 'all_remain',
									'key_all_gold'	=> 'all_remain_gold',
									'key_all_bind_gold'	=> 'all_remain_bind_gold',
	
									'label_all' => $lang->gold->allRemain,
									'label_all_gold' => $lang->gold->allRemainGold,
									'label_all_bind_gold' => $lang->gold->allRemainBindGold,
								),
					'increase' => array(
									'top_all' => $topAllIncrease, 
									'top_all_gold' => $topAllIncreaseGold, 
									'top_all_bind_gold' => $topAllIncreaseBindGold,

									'sum_all' => $sumAllIncrease, 
									'sum_all_gold' => $sumAllIncreaseGold, 
									'sum_all_bind_gold' => $sumAllIncreaseBindGold,
									
									'key_all' => 'all_increase',
									'key_all_gold'	=> 'all_increase_gold',
									'key_all_bind_gold'	=> 'all_increase_bind_gold',
	
									'label_all' => $lang->gold->allIncrease,
									'label_all_gold' => $lang->gold->allIncreaseGold,
									'label_all_bind_gold' => $lang->gold->allIncreaseBindGold,
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
$smarty->display( 'module/gold/save_and_consume_new.tpl' );