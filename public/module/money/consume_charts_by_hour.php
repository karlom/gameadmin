<?php 
/**
 * 银子日消耗统计
 * 
 * 
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';
include_once SYSDIR_ADMIN_DICT . '/arrItemsAll.php';
include_once SYSDIR_ADMIN_DICT . '/moneyConfig.php';

//include_once '../../../protected/game_config/webgame/game_function.php';
global $lang, $arrItemsAll, $moneyType, $dictMoneyType;

$openTimestamp = strtotime( $serverList[$_SESSION ['gameAdminServer']]['onlinedate'] );

$defaultDays = 6;//默认显示前几天的数据

$errorMsg = $successMsg = array();// 消息数组

$selectConsumptionType = $selectMoneyType = -1;//选择的银子类型和消费类型

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

if( isset( $_GET['select_money_type'] ) )// 银子类型，绑定和非绑定
{
	$selectMoneyType = SS( $_GET['select_money_type'] );

	switch( $selectMoneyType )
	{
		case -1: $moneyFiled = 'SUM(money) + SUM(bind_money)';break;
		case 0 : $moneyFiled = 'SUM(bind_money)';break;
		default: $moneyFiled = 'SUM(money)';break;
	}
}

if( !empty( $_GET['consumption_type'] ) )// 消费类型
{
	$selectConsumptionType = SS( $_GET['consumption_type'] );
}

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

if ( !empty( $selectConsumptionType ) && $selectConsumptionType >= 0 )
{ 
	$andCondArray[] = " type = $selectConsumptionType ";
}

// 初始化结果数组，保证数据的连续性
$playerStatistics = $logByHourResult = $logByDayHourResult = array();
$tmpDate = date('Y-n-j', $startTime );
$endDate = date( 'Y-n-j' , $endTime );
while( true )
{
	$tmp_timestampe = strtotime( $tmpDate );
	$since_open_days = ceil(( $tmp_timestampe - $openTimestamp ) / 86400) + 1;
//	echo $tmp_timestampe - $openTimestamp ;
	$tmpDate = date( 'Y-n-j',  $tmp_timestampe);
	$playerStatistics[$since_open_days] = array(
										'men_count' => 0,
										'cost'		=> 0,
										'mtime'		=> $tmp_timestampe,
										'weekday'	=> date('w', $tmp_timestampe)
										);
	$logByDayHourResult[$since_open_days]['mtime'] = $tmp_timestampe;
	$hour = 0;						
	while( true )
	{
		$logByDayHourResult[$since_open_days]['weekday'] = date('w', $tmp_timestampe);
		$logByDayHourResult[$since_open_days]['max'] = 0;
		$logByDayHourResult[$since_open_days]['data'][$hour] = array('cost' => 0);
		if( $hour >= 23)
		{
			break;
		}
		$hour++;
	}
	if( $tmpDate ==  $endDate ) 
	{// 到截止日期
		break;
	}
	
	$tmpDate = $tmpDate . ' +1 day';
}
$hour = 0;
while( true )
{
	$logByHourResult[$hour] = 0;
	if( $hour >= 23)
	{
		break;
	}
	$hour++;
}



// 当提供了查询条件则执行查询
$cond = '';
if( !$notValid && !empty( $andCondArray ))
{  
	$andCondArray[] = ' type >= 10000'; // 过滤银子增加的数据
	$andCondArray[] = ' type < 20000'; // 过滤银子增加的数据
	$cond 	= implode( ' AND ' ,$andCondArray ) ;
	$sql 	= "SELECT 
					COUNT( DISTINCT account_name) men_count, $moneyFiled cost, mtime, year, month, day
			   FROM " . T_LOG_MONEY ." 
			   WHERE $cond
			   GROUP BY year, day, month";
	//echo $sql;
	$tmpPlayerStatistics = GFetchRowSet( $sql );
	$topMenCount		= 0;//最大人数
	$topMoneyCount		= 0;//最大银子数
	foreach ($tmpPlayerStatistics as $key => &$record)
	{
	//	$date = $record['year'] . '-' . $record['month'] . '-' . $record['day'] . ' 00:00:00';
		$since_open_days = ceil( ($record['mtime'] - $openTimestamp  + 1) / 86400) ;
		$topMenCount = $record['men_count'] >= $topMenCount? $record['men_count'] : $topMenCount;
		$topMoneyCount = $record['cost'] >= $topMoneyCount? $record['cost'] : $topMoneyCount;
		
		$playerStatistics[$since_open_days] = array_merge($playerStatistics[$since_open_days] , $record);
	} 
	
	$smarty->assign( 'top_men_count', $topMenCount );
	$smarty->assign( 'top_money_count', $topMoneyCount );
	
	$sqlByHour = "SELECT 
					 $moneyFiled cost, mtime, year, month, day, hour
				  FROM " . T_LOG_MONEY ." 
				  WHERE $cond
				  GROUP BY year, day, month, hour";
					 
	$logByDayHour = GFetchRowSet( $sqlByHour );
	foreach ( $logByDayHour as $record )
	{
		$since_open_days = ceil( ($record['mtime'] - $openTimestamp  + 1) / 86400) ;
		$logByDayHourResult[$since_open_days]['data'][$record['hour']] = $record;
		$logByDayHourResult[$since_open_days]['max'] = $record['cost'] >= $logByDayHourResult[$since_open_days]['max']? $record['cost'] : $logByDayHourResult[$since_open_days]['max'];
		$logByHourResult[$record['hour']] += $record['cost'];
	}
		
	$smarty->assign( 'logByHourResult', $logByHourResult );
	$smarty->assign( 'topCostByHourResult', max( $logByHourResult ) );
	
	
	$smarty->assign( 'logByDayHourResult', $logByDayHourResult );
}


// 设置smarty的变量
$smarty->assign( 'player_statistics', $playerStatistics );
$minDate = $serverList[$_SESSION ['gameAdminServer']]['onlinedate'];
$maxDate = Datatime :: getTodayString();
$smarty->assign( 'minDate', $minDate);
$smarty->assign( 'maxDate', $maxDate);
$smarty->assign( 'highlightPercentage', HIGHTLIGHT_PERCENTAGE);
$smarty->assign( 'countOfDays', $countOfDays);
$smarty->assign( 'selectMoneyType', $selectMoneyType);
$smarty->assign( 'selectConsumptionType', $selectConsumptionType);
$smarty->assign( 'startTime', 	$startTime );
$smarty->assign( 'endTime', 	$endTime);
$smarty->assign( 'dictMoneyType', $dictMoneyType);
$smarty->assign( 'consumptionType', $moneyType[1]);
$smarty->assign( 'op_type' , $opType);
$smarty->assign( 'errorMsg', 	implode('<br/>', $errorMsg ) );
$smarty->assign( 'successMsg', 	implode('<br/>', $successMsg ) );
$smarty->assign( 'lang', 	$lang );
$smarty->display( 'module/money/consume_charts_by_hour.tpl' );