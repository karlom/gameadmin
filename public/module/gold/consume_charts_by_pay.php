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

$selectConsumptionType = $selectGoldType = -1;//选择的元宝类型和消费类型

$goldFiled = 'SUM(gold) + SUM(bind_gold)';

$startDay		= (isset( $_GET['start_day'] ) && Validator::isDate($_GET['start_day']) )? SS($_GET['start_day']) : date('Y-m-d', strtotime('-6 days'));
$endDay		= (isset( $_GET['end_day'] ) && Validator::isDate($_GET['end_day']) )? SS($_GET['end_day']) : date('Y-m-d');

$startTimestamp = Datatime::getDayBeginTimestamp($startDay);//
$endTimestamp 	= Datatime::getDayEndTimestamp($endDay);//

$openTimestamp = strtotime( ONLINEDATE );
if($startTimestamp < $openTimestamp)
{
	$startTimestamp = $openTimestamp;
	$startDay = ONLINEDATE;
}

if( isset( $_GET['select_gold_type'] ) )// 元宝类型，绑定和非绑定
{
	$selectGoldType = SS( $_GET['select_gold_type'] );

	switch( $selectGoldType )
	{
		case -1: $goldFiled = 'SUM(gold) + SUM(bind_gold)';break;
		case 0 : $goldFiled = 'SUM(bind_gold)';break;
		default: $goldFiled = 'SUM(gold)';break;
	}
}

if( !empty( $_GET['consumption_type'] ) )// 消费类型
{
	$selectConsumptionType = SS( $_GET['consumption_type'] );
}

$viewData = getConsumeStatisticsByPay($startTimestamp, $endTimestamp, $selectGoldType, $selectConsumptionType);


// 设置smarty的变量
$smarty->assign( 'viewData', $viewData );
$minDate = $serverList[$_SESSION ['gameAdminServer']]['onlinedate'];
$maxDate = Datatime :: getTodayString();
$smarty->assign( 'minDate', $minDate);
$smarty->assign( 'maxDate', $maxDate);
$smarty->assign( 'highlightPercentage', HIGHTLIGHT_PERCENTAGE);
$smarty->assign( 'selectGoldType', $selectGoldType);
$smarty->assign( 'selectConsumptionType', $selectConsumptionType);
$smarty->assign( 'startDay', 	$startDay );
$smarty->assign( 'endDay', 	$endDay);
$smarty->assign( 'dictGoldType', $dictGoldType);
$smarty->assign( 'consumptionType', $goldType[1]);
$smarty->assign( 'op_type' , $opType);
$smarty->assign( 'errorMsg', 	implode('<br/>', $errorMsg ) );
$smarty->assign( 'successMsg', 	implode('<br/>', $successMsg ) );
$smarty->assign( 'lang', 	$lang );
$smarty->display( 'module/gold/consume_charts_by_pay.tpl' );

function getConsumeStatisticsByPay($startTimestamp, $endTimestamp, $selectGoldType = -1, $selectConsumptionType = 0)
{
	$andCond = array();
	$andCond[] = " t.mtype = 1 ";
	$andCond[] = " t.mtime > $startTimestamp ";
	$andCond[] = " t.mtime < $endTimestamp ";
	
	switch( $selectGoldType )
	{
		case -1: $goldFiled = 'SUM(t.gold) + SUM(t.bind_gold)';break;
		case 0 : $goldFiled = 'SUM(t.bind_gold)';break;
		default: $goldFiled = 'SUM(t.gold)';break;
	}
	
	if( $selectConsumptionType > 0 )
	{
		$andCond[] = " type = $selectConsumptionType ";
	}
	$table_gold = T_LOG_GOLD;
	$table_pay = T_LOG_PAY;
	$whereString = implode('AND', $andCond) ;
	
	$sql = "SELECT $goldFiled all_gold, SUM(t.num) item_count, count(*) op_count, ranges FROM $table_gold t
			LEFT JOIN
			(
				SELECT t1.role_name, t1.total_pay_money, elt(interval(t1.total_pay_money, 0, 1, 10, 100, 500, 1000, 5000, 10000, 50000), '0', '1-10', '10-100', '100-500', '500-1000', '1000-5000', '5000-10000', '10000-50000', '50000') ranges 
				FROM 
				(
					SELECT role_name, SUM(pay_money) total_pay_money FROM $table_pay GROUP BY role_name
				) t1
				GROUP BY t1.role_name, elt(interval(t1.total_pay_money, 0, 1, 10, 100, 500, 1000, 5000, 10000, 50000), '0', '1-10', '10-100', '100-500', '500-1000', '1000-5000', '5000-10000', '10000-50000', '50000')
			) t2
			ON t.role_name = t2.role_name
			WHERE $whereString
			GROUP BY t2.ranges";
	
	$consumeStatisticsByPay = GFetchRowSet($sql);
	$viewData = array();
	$viewData['max_gold_count'] = $viewData['max_item_count'] = $viewData['max_op_count'] = 0;
	
	foreach($consumeStatisticsByPay as &$record)
	{
		$viewData['max_gold_count'] = $viewData['max_gold_count'] < $record['all_gold']? $record['all_gold']:$viewData['max_gold_count'];
		$viewData['max_item_count'] = $viewData['max_item_count'] < $record['item_count']? $record['item_count']:$viewData['max_item_count'];
		$viewData['max_op_count'] 	= $viewData['max_op_count'] < $record['op_count']? $record['op_count']:$viewData['max_op_count'];
		if(!is_null($record['ranges']))
		{
			$rangesTmp = explode('-', $record['ranges']);
			$record['ranges_label'] = "[{$rangesTmp[0]}, {$rangesTmp[1]})";
		}
		else
		{
			$record['ranges_label'] = 0;
		}
	}
	
	$viewData['data'] = $consumeStatisticsByPay;
	
	return $viewData;
//	dump($consumeStatisticsByPay);
}