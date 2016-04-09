<?php
/**
 * 副本道具掉落统计
 */
 
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/arrItemsAll.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';

global $dictColor, $arrItemsAll,$dictQuality, $dictItemUsageType, $dictMapType;
//if( IS_LUA == 1 )
//{// LUA的数组是从1开始
//	$dictColor = changeArrayBase( $dictColor, 1 );
//}
// 构造副本地图数组
$billTypeList = array(1 => '挂单求购元宝', 2=> '挂单卖元宝');


// 构造道具数组
$itemList = array();
foreach($arrItemsAll as $item)
{
	$itemList[$item['id']] = $item['name'];
}
$errorMsg = $successMsg = array();// 
$onlineDate = $serverList[$_SESSION ['gameAdminServer']]['onlinedate'];//


//请求参数获取
$selectedBillType 	= (isset( $_GET['bill_type'] ) && Validator::isInt($_GET['bill_type']) )? SS($_GET['bill_type'])  : 1;
$startDay		= (isset( $_GET['start_day'] ) && Validator::isDate($_GET['start_day']) )? SS($_GET['start_day']) : date('Y-m-d', strtotime('-6 days'));
$endDay		= (isset( $_GET['end_day'] ) && Validator::isDate($_GET['end_day']) )? SS($_GET['end_day']) : date('Y-m-d');


//
$startTimestamp = Datatime::getDayBeginTimestamp($startDay);//
$endTimestamp 	= Datatime::getDayEndTimestamp($endDay);//
$openTimestamp = strtotime( ONLINEDATE );
if($startTimestamp < $openTimestamp)
{
	$startTimestamp = $openTimestamp;
	$startDay = ONLINEDATE;
}


if( isset($_GET['search']) )// 
{
	$viewData = getMarketStatistics( $selectedBillType, $startTimestamp, $endTimestamp );

	$smarty->assign( 'viewData', $viewData );
} 


$smarty->assign( 'lang', $lang );
$smarty->assign( 'selectedBillType', $selectedBillType);
$smarty->assign( 'highlightPercentage', HIGHTLIGHT_PERCENTAGE);
$smarty->assign( 'billTypeList', $billTypeList);
$smarty->assign( 'errorMsg', implode('<br/>', $errorMsg ) );
$smarty->assign( 'successMsg', implode('<br/>', $successMsg ) );
$smarty->assign( 'minDate', $onlineDate);
$smarty->assign( 'maxDate', Datatime :: getTodayString());
$smarty->assign( 'startDay', $startDay );
$smarty->assign( 'endDay', $endDay );
$smarty->assign( 'roleName', $roleName );
$smarty->assign( 'accountName', $accountName );
$smarty->display( 'module/basedata/market_bill_statistics.tpl' );


function getMarketStatistics($selectedBillType = 1, $startTimestamp, $endTimestamp)
{
	// 初始化结果数组，保证数据联系性
	$resultData = array();
	$tmpDay = date('Y-m-d', $startTimestamp);
	while( true )
	{
		$tmp_timestampe = strtotime( $tmpDay );//
		if( $tmp_timestampe >  $endTimestamp ) break;// 超出日期范围
		$tmpDay = date('Y-m-d', $tmp_timestampe);
		$resultData[$tmpDay] = array( 
									'mtime' => $tmp_timestampe, //时间戳
									'weekday' => date('w', $tmp_timestampe),//星期几
									'bill_count' => 0,// 挂单单数
									'sell_rmb_count' => 0,// 挂单元宝总数（须减去撤单总数的部分）
									'sell_money_count' => 0,// 挂单铜币总数（须减去撤单总数的部分）
									'avg_sell_rmb' => 0,// 平均挂单的元宝价格（用铜币作为表示）
									'get_rmb_count' => 0,// 求购元宝总数 （须减去撤单总数的部分）
									'get_money_count' => 0,// 求购铜币总数（须减去扯淡总数的部分）
									'cancel_bill_count' => 0,// 撤单单数
									'closed_bill_count' => 0,// 成交单数
									'closed_rmb_count' => 0,// 成交的挂单元宝总数
									'closed_money_count' => 0,// 成交的挂单铜币总数
									'min_closed_rmb' => 0,// 元宝最低成交价格
									'max_closed_rmb' => 0,// 元宝最高成交价格
									'avg_closed_rmb' => 0// 元宝平均成交价格
									);
		$tmpDay = $tmpDay . ' +1 day';
	}
	
	$cond = " mtime > $startTimestamp AND mtime < $endTimestamp ";
	//$condJoin = " t1.mtime > $startTimestamp AND t1.mtime < $endTimestamp AND t2.mtime > $startTimestamp AND t2.mtime < $endTimestamp ";
	$condJoin = " t2.mtime > $startTimestamp AND t2.mtime < $endTimestamp ";
	//统计挂单数据
	if($selectedBillType == 1)
	{// 统计求购元宝的挂单数据
		$sqlBill = "SELECT mtime, COUNT(*) bill_count, SUM(money) sell_money_count, SUM(sell_rmb) get_rmb_count FROM  " . T_LOG_MARKET_SELL . " WHERE bill_type = 1 AND $cond GROUP BY year, month, day";
	}
	else
	{
		$sqlBill = "SELECT mtime, COUNT(*) bill_count, SUM(rmb) sell_rmb_count, SUM(sell_money) get_money_count FROM  " . T_LOG_MARKET_SELL . " WHERE bill_type = 2 AND $cond GROUP BY year, month, day";
	}
	$billData = GFetchRowSet($sqlBill);
	
	//统计撤单数据
	if($selectedBillType == 1)
	{// 统计求购元宝的挂单数据
		$sqlCancelBill = "SELECT t1.mtime, COUNT(*) cancel_bill_count, SUM(t1.money) cancle_sell_money_count, SUM(t1.sell_rmb) cancle_get_rmb_count FROM  " . T_LOG_MARKET_SELL . " t1 RIGHT JOIN " . T_LOG_MARKET_CANCEL_SELL . " t2 ON t1.market_id = t2.market_id WHERE t1.bill_type = 1 AND $condJoin GROUP BY t1.year, t1.month, t1.day";
	}
	else
	{
		$sqlCancelBill = "SELECT t1.mtime, COUNT(*) cancel_bill_count, SUM(t1.rmb) cancle_sell_rmb_count, SUM(t1.sell_money) cancle_get_money_count FROM " . T_LOG_MARKET_SELL . " t1 RIGHT JOIN " . T_LOG_MARKET_CANCEL_SELL . " t2 ON t1.market_id = t2.market_id WHERE t1.bill_type = 2 AND $condJoin GROUP BY t1.year, t1.month, t1.day ";
	}
	$cancelBillData = GFetchRowSet($sqlCancelBill);
	
	//统计成交数据
	if($selectedBillType == 1)
	{
		$sqlClosedBill = "SELECT t1.mtime, COUNT(*) closed_bill_count, SUM(t1.money) closed_money_count, SUM(t1.sell_rmb) closed_rmb_count, min(t1.money/t1.sell_rmb) min_closed_rmb, max(t1.money/t1.sell_rmb) max_closed_rmb FROM  " . T_LOG_MARKET_SELL . " t1 RIGHT JOIN " . T_LOG_MARKET_BUY . " t2 ON t1.market_id = t2.market_id WHERE t1.bill_type = 1 AND $condJoin GROUP BY t1.year, t1.month, t1.day";
	}
	else 
	{
		$sqlClosedBill = "SELECT t1.mtime, COUNT(*) closed_bill_count, SUM(t1.sell_money) closed_money_count, SUM(t1.rmb) closed_rmb_count, min(t1.sell_money/t1.rmb) min_closed_rmb, max(t1.sell_money/t1.rmb) max_closed_rmb FROM  " . T_LOG_MARKET_SELL . " t1 RIGHT JOIN " . T_LOG_MARKET_BUY . " t2 ON t1.market_id = t2.market_id WHERE t1.bill_type = 2 AND $condJoin GROUP BY t1.year, t1.month, t1.day";
	}
	//$sqlClosedBill = "SELECT mtime, COUNT(*) closed_bill_count, SUM(use_money) closed_money_count, SUM(use_rmb) closed_rmb_count FROM " . T_LOG_MARKET_BUY . " WHERE bill_type = $selectedBillType AND $cond GROUP BY year, month, day ";
	$closedBillData = GFetchRowSet($sqlClosedBill);
	
	//执行汇总计算
	$field_sell = 'sell_money_count';
	$field_get = 'get_rmb_count';
	$field_sell_cancle = 'cancle_sell_money_count';
	$field_get_cancle = 'cancle_get_rmb_count';
	if($selectedBillType == 2)
	{
		$field_sell = 'sell_rmb_count';
		$field_get = 'get_money_count';
		$field_sell_cancle = 'cancle_sell_rmb_count';
		$field_get_cancle = 'cancle_get_money_count';
	}
	
	// 统计挂单总数
	foreach($billData as $bData)
	{
		$date = date('Y-m-d', $bData['mtime']);
		$resultData[$date]['bill_count'] = $bData['bill_count'];
		$resultData[$date][$field_sell] = $bData[$field_sell];
		$resultData[$date][$field_get] = $bData[$field_get];
		
	}
	
	// 减去撤单的总数
	foreach($cancelBillData as $caData)
	{
		$date = date('Y-m-d', $caData['mtime']);
		$resultData[$date][$field_sell] = $resultData[$date][$field_sell] - $caData[$field_sell_cancle];
		$resultData[$date][$field_get] = $resultData[$date][$field_get] - $caData[$field_get_cancle];
		$resultData[$date]['cancel_bill_count'] = $caData['cancel_bill_count'];
	}
	
	// 统计成交数
	foreach($closedBillData as $clData)
	{
		$date = date('Y-m-d', $clData['mtime']);
		$resultData[$date]['closed_bill_count'] = $clData['closed_bill_count'];
		$resultData[$date]['closed_rmb_count'] = $clData['closed_rmb_count'];
		$resultData[$date]['closed_money_count'] = $clData['closed_money_count'];
		$resultData[$date]['min_closed_rmb'] = $clData['min_closed_rmb'];
		$resultData[$date]['max_closed_rmb'] = $clData['max_closed_rmb'];
		
		if ($clData['closed_rmb_count'] > 0)
		{
			$resultData[$date]['avg_closed_rmb'] = $clData['closed_money_count'] / $clData['closed_rmb_count'];
		}
		else
		{
			$resultData[$date]['avg_closed_rmb'] = 0;
		}
	}
	
	// 计算元宝平均挂单价格
	$max_avg_closed_rmb = 0;
	foreach($resultData as &$data)
	{
		if ($selectedBillType == 1)
		{
			$data['avg_sell_rmb'] = $data[$field_get] == 0? 0 : $data[$field_sell] / $data[$field_get];
		}
		else
		{
			$data['avg_sell_rmb'] = $data[$field_sell] == 0? 0 : $data[$field_get] / $data[$field_sell];
		}
		$max_avg_closed_rmb = $max_avg_closed_rmb < $data['avg_sell_rmb']?$data['avg_sell_rmb']:$max_avg_closed_rmb;
	}
	
	return array('data' => $resultData, 'max_avg_closed_rmb' => $max_avg_closed_rmb);
	
}