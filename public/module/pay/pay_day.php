<?php
/*
 * Author: yangdongbo
 * 2011-11-22
 */
 
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';
global $lang, $dictPayStatisticsType;

$errorMsg = $successMsg = array();// 消息数组
$defaultDays = 6;//默认显示多少天内的统计数据
$onlineDate = $serverList[$_SESSION ['gameAdminServer']]['onlinedate'];//开服日期
$openTimestamp = strtotime( $onlineDate );//开服日期的时间戳
$startDayString = date('Y-m-d', strtotime(" -$defaultDays days"));//默认起始日期
$startDayString = (strtotime($startDayString) >= strtotime(ONLINEDATE)) ? $startDayString : ONLINEDATE;
$endDayString = date('Y-m-d');//默认结束日期
$currentDay = date('Y-m-d');//当前日期

if(isPost())
{
	if( isset($_POST['dateToday']) )//显示本日的统计数据
	{
		$startDayString = $endDayString = date('Y-m-d');
		$currentDay = $_SESSION['currentDay'] = date('Y-m-d');
	}
	elseif( isset($_POST['datePrev']) )//显示前一日的统计数据
	{
		$currentDay =  isset($_SESSION['currentDay'])? $_SESSION['currentDay']:date('Y-m-d');
		$currentDayBeginTimestamp = Datatime::getDayBeginTimestamp( $currentDay );
		$startDayString = $endDayString = date('Y-m-d', $currentDayBeginTimestamp - 1);
		$currentDay = $_SESSION['currentDay'] = $startDayString;
	}
	elseif( isset($_POST['dateNext']) )//显示下一日的统计数据
	{
		$currentDay =  isset($_SESSION['currentDay'])? $_SESSION['currentDay']:date('Y-m-d');
		$currentDayEndTimestamp = strtotime($currentDay." 23:59:59");
		$startDayString = $endDayString = date('Y-m-d', $currentDayEndTimestamp + 1);
		$currentDay = $_SESSION['currentDay'] = $startDayString;
	}
	elseif( isset($_POST['dateAll']) )
	{ //保持原值
		$startDayString = $onlineDate;//起始日期
		$endDayString = date('Y-m-d');//结束日期
	}
	else 
	{
		$startDayString 	= (isset( $_POST['startDay'] ) && $_POST['startDay'] > $onlineDate )? SS($_POST['startDay']) : Datatime::getFormatStringByString('Y-m-d', $onlineDate);
		$endDayString 	= isset( $_POST['endDay'] )? SS($_POST['endDay']) : date('Y-m-d');
	}
}
$startDayTimestamp 	= Datatime::getDayBeginTimestamp( $startDayString );
$endDayTimestamp 	= strtotime( $endDayString." 23:59:59" );

// 初始化日期列表，确保数据连续性
$resultArray = array();
$tmpDay = $startDayString;
while( true )
{
	$tmp_timestampe = strtotime( $tmpDay );//
	if( $tmp_timestampe >  $endDayTimestamp ) break;// 超出日期范围
	$tmpDay = date('Y-m-d', $tmp_timestampe);
	$resultArray[$tmpDay] = array( 
								'pay' => 0, 
								'payers' => 0,
								'payTimes' => 0,
								'arpu' => 0,
								'year' => date('Y', $tmp_timestampe), 
								'month' => date('m', $tmp_timestampe) 
								);
	$tmpDay = $tmpDay . ' +1 day';
}



$viewData = getPayDataByDay ( $startDayTimestamp, $endDayTimestamp, $resultArray );

if(!$viewData)$errorMsg[] = $lang->page->dateInvalid;

$keyLabelMap = array(
					'pay' 		=> array('maxValue' => $viewData['maxPay'], 'label' => $lang->page->showType2 . '(' . $lang->page->currencySymbol . ')'), 
					'payers' 	=> array('maxValue' => $viewData['maxPayers'], 'label' => $lang->page->showType3), 
					'payTimes' 	=> array('maxValue' => $viewData['maxPayTimes'], 'label' => $lang->page->showType4), 
					'arpu'		=> array('maxValue' => $viewData['maxARPU'], 'label' => $lang->page->showType5)
				);

$smarty->assign ( 'minDate',  $onlineDate );
$smarty->assign ( 'maxDate',  Datatime :: getTodayString() );
$smarty->assign ( 'startDay', $startDayString );
$smarty->assign ( 'endDay', $endDayString );
$smarty->assign ( 'currentDay', $currentDay);
$smarty->assign ( 'lang', $lang );
$smarty->assign ( 'dictPayStatisticsType', $dictPayStatisticsType );
$smarty->assign ( 'highlightPercentage', HIGHTLIGHT_PERCENTAGE);
$smarty->assign ( 'keyLabelMap', $keyLabelMap);
$smarty->assign ( 'viewData', $viewData );
$smarty->assign	( 'errorMsg', 	implode('<br/>', $errorMsg ) );
$smarty->assign	( 'successMsg', 	implode('<br/>', $successMsg ) );
$smarty->display ( "module/pay/pay_day.tpl" );

function getPayDataByDay($startTimestamp,$endTimestamp, $dataList){//因为页面中需要显示最大单月充值金额，最大单月充值人数，最大单月ARPU，所以没必要分不同类型。
	if( $startTimestamp > $endTimestamp ) return false;//开始时间必须小于结束时间
	$cond = " mtime >= $startTimestamp AND mtime <= $endTimestamp ";//设置开始时间和结束时间的条件语句
	
	$keyMap = array('pay', 'payers', 'payTimes', 'arpu');//类型
	$sqlMap = array();
	$sqlMap['pay'] 		= "SELECT SUM(pay_money) data, pay_time FROM " . T_LOG_PAY . " WHERE $cond GROUP BY FROM_UNIXTIME(pay_time, '%Y'), FROM_UNIXTIME(pay_time, '%m'), FROM_UNIXTIME(pay_time, '%d')";//充值金额统计SQL
	$sqlMap['payers'] 	= "SELECT COUNT(DISTINCT account_name) data, pay_time FROM " . T_LOG_PAY . " WHERE $cond GROUP BY FROM_UNIXTIME(pay_time, '%Y'), FROM_UNIXTIME(pay_time, '%m'), FROM_UNIXTIME(pay_time, '%d');";//充值人数统计SQL
	$sqlMap['payTimes'] = "SELECT COUNT(*) data, pay_time FROM " . T_LOG_PAY . " WHERE $cond GROUP BY FROM_UNIXTIME(pay_time, '%Y'), FROM_UNIXTIME(pay_time, '%m'), FROM_UNIXTIME(pay_time, '%d');";//充值次数统计SQL
	$sqlMap['arpu']		= "SELECT AVG(t1.data) data , t1.pay_time, t1.year, t1.month, t1.day FROM (
									SELECT account_name, SUM(pay_money) data, FROM_UNIXTIME(pay_time, '%Y') year, FROM_UNIXTIME(pay_time, '%m') month, FROM_UNIXTIME(pay_time, '%d') day, pay_time FROM " . T_LOG_PAY . " WHERE $cond GROUP BY FROM_UNIXTIME(pay_time, '%Y'), FROM_UNIXTIME(pay_time, '%m'), FROM_UNIXTIME(pay_time, '%d'), account_name
								)t1 GROUP BY t1.year, t1.month, t1.day";//充值ARPU统计SQL
	
	// 执行查询
	foreach( $keyMap as $key )
	{
		if( !isset( $sqlMap[$key] ) ) return false;//SQL未定义
		$sql = $sqlMap[$key];//获取对应的SQL
		$recordSet = GFetchRowSet($sql);		
		foreach ($recordSet as $record)
		{
			$monthString = date('Y-m-d', $record['pay_time']);
			$dataList[$monthString][$key] = $record['data'];
		}
	}
	
	// 构造结果
	$data = array('totalPay' => 0, 'avgPay' => 0, 'maxPay' => 0, 'maxPayers' => 0, 'maxPayTimes' => 0, 'maxARPU' => 0);
	foreach( $dataList as $monthData )
	{
		$data['totalPay'] 	   += $monthData['pay'];//充值总额
		$data['maxPay'] 		= $monthData['pay'] > $data['maxPay']? $monthData['pay'] : $data['maxPay'];//最高日充值
		$data['maxPayers'] 		= $monthData['payers'] > $data['maxPayers']? $monthData['payers'] : $data['maxPayers'];//最高日充值人数
		$data['maxPayTimes'] 	= $monthData['payTimes'] > $data['maxPayTimes']? $monthData['payTimes'] : $data['maxPayTimes'];//最高日充值订单数
		$data['maxARPU'] 		= $monthData['arpu'] > $data['maxARPU']? $monthData['arpu'] : $data['maxARPU'];//最高日ARPU值
	}
	$data['avgPay'] = $data['totalPay'] / count($dataList);//日平均充值
	$data['data'] 	= $dataList;
	return $data;
}