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
$onlineDate = $serverList[$_SESSION ['gameAdminServer']]['onlinedate'];//开服日期
$openTimestamp = strtotime( $onlineDate );//开服日期的时间戳
$startMonthString = Datatime::getFormatStringByString('Y-m', $onlineDate);//默认起始月份
$endMonthString = date('Y-m');//默认结束月份
$currentMonth = date('Y-m');//当前月份

if(isPost())
{	
	if( isset($_POST['dateToday']) )//显示本月的统计数据
	{
		$startMonthString = $endMonthString = date('Y-m');
		$currentMonth = $_SESSION['currentMonth'] = date('Y-m');
	}
	elseif( isset($_POST['datePrev']) )//显示前一个月的统计数据
	{
		$currentMonth =  isset($_SESSION['currentMonth'])? $_SESSION['currentMonth']:date('Y-m');
		$currentMonthBeginTimestamp = Datatime::getMonthBeginTimestamp( $currentMonth );
		$startMonthString = $endMonthString = date('Y-m', $currentMonthBeginTimestamp - 1);
		$currentMonth = $_SESSION['currentMonth'] = $startMonthString;
	}
	elseif( isset($_POST['dateNext']) )//显示下一个月的统计数据
	{
		$currentMonth =  isset($_SESSION['currentMonth'])? $_SESSION['currentMonth']:date('Y-m');
		$currentMonthEndTimestamp = Datatime::getMonthEndTimestamp( $currentMonth );
		$startMonthString = $endMonthString = date('Y-m', $currentMonthEndTimestamp + 1);
		$currentMonth = $_SESSION['currentMonth'] = $startMonthString;
	}
	elseif( isset($_POST['dateAll']) )
	{ //保持原值
	}
	else 
	{
		$startMonthString 	= (isset( $_POST['startMonth'] ) && $_POST['startMonth'] > $onlineDate )? SS($_POST['startMonth']) : Datatime::getFormatStringByString('Y-m', $onlineDate);
		$endMonthString 	= isset( $_POST['endMonth'] )? SS($_POST['endMonth']) : date('Y-m');
	}
}
$startMonthTimestamp 	= Datatime::getMonthBeginTimestamp( $startMonthString ) ;
$endMonthTimestamp 		= Datatime::getMonthEndTimestamp( $endMonthString ) ;

// 初始化日期列表，确保数据连续性
$resultArray = array();
$tmpMonth = $startMonthString;
while( true )
{
	$tmp_timestampe = strtotime( $tmpMonth );//
	if( $tmp_timestampe >  $endMonthTimestamp ) break;// 超出日期范围
	$tmpMonth = date('Y-m', $tmp_timestampe);
	$resultArray[$tmpMonth] = array( 
								'pay' => 0, 
								'payers' => 0,
								'payTimes' => 0,
								'arpu' => 0,
								'year' => date('Y', $tmp_timestampe), 
								'month' => date('m', $tmp_timestampe) 
								);
	$tmpMonth = $tmpMonth . ' +1 month';
}
$viewData = getPayDataByMonth ( $startMonthTimestamp, $endMonthTimestamp, $resultArray );
if(!$viewData)$errorMsg[] = $lang->page->dateInvalid;

$keyLabelMap = array(
					'pay' 		=> array('maxValue' => $viewData['maxPay'], 'label' => $lang->page->showType2 . '(' . $lang->page->currencySymbol . ')'), 
					'payers' 	=> array('maxValue' => $viewData['maxPayers'], 'label' => $lang->page->showType3), 
					'payTimes' 	=> array('maxValue' => $viewData['maxPayTimes'], 'label' => $lang->page->showType4), 
					'arpu'		=> array('maxValue' => $viewData['maxARPU'], 'label' => $lang->page->showType5)
				);

$smarty->assign ( 'minDate',  Datatime::getFormatStringByString('Y-m', $onlineDate));
$smarty->assign ( 'maxDate',  Datatime::getFormatStringByString('Y-m', Datatime :: getTodayString()));
$smarty->assign ( 'startMonth', $startMonthString );
$smarty->assign ( 'endMonth', $endMonthString );
$smarty->assign ( 'currentMonth', $currentMonth);
$smarty->assign ( 'lang', $lang );
$smarty->assign ( 'dictPayStatisticsType', $dictPayStatisticsType );
$smarty->assign ( 'highlightPercentage', HIGHTLIGHT_PERCENTAGE);
$smarty->assign ( 'keyLabelMap', $keyLabelMap);
$smarty->assign ( 'viewData', $viewData );
$smarty->assign	( 'errorMsg', 	implode('<br/>', $errorMsg ) );
$smarty->assign	( 'successMsg', 	implode('<br/>', $successMsg ) );
$smarty->display ( "module/pay/pay_month.tpl" );

function getPayDataByMonth($startTimestamp,$endTimestamp, $dataList){//因为页面中需要显示最大单月充值金额，最大单月充值人数，最大单月ARPU，所以没必要分不同类型。
	if( $startTimestamp > $endTimestamp ) return false;//开始时间必须小于结束时间
	$cond = " mtime > $startTimestamp AND mtime < $endTimestamp ";//设置开始时间和结束时间的条件语句
	
	$keyMap = array('pay', 'payers', 'payTimes', 'arpu');//类型
	$sqlMap = array();
	$sqlMap['pay'] 		= "SELECT SUM(pay_money) data, mtime FROM " . T_LOG_PAY . " WHERE $cond GROUP BY year, month;";//充值金额统计SQL
	$sqlMap['payers'] 	= "SELECT COUNT(DISTINCT account_name) data, mtime FROM " . T_LOG_PAY . " WHERE $cond GROUP BY year, month;";//充值人数统计SQL
	$sqlMap['payTimes'] = "SELECT COUNT(*) data, mtime FROM " . T_LOG_PAY . " WHERE $cond GROUP BY year, month;";//充值次数统计SQL
	$sqlMap['arpu']		= "SELECT AVG(t1.data) data , t1.mtime, t1.year, t1.month FROM (
									SELECT account_name, SUM(pay_money) data, year, month, mtime FROM " . T_LOG_PAY . " WHERE $cond GROUP BY year, month, account_name
								)t1 GROUP BY t1.year, t1.month";//充值ARPU统计SQL
	
	// 执行查询
	foreach( $keyMap as $key )
	{
		if( !isset( $sqlMap[$key] ) ) return false;//SQL未定义
		$sql = $sqlMap[$key];//获取对应的SQL
		$recordSet = GFetchRowSet($sql);		
		foreach ($recordSet as $record)
		{
			$monthString = date('Y-m', $record['mtime']);
			$dataList[$monthString][$key] = $record['data'];
		}
	}
	
	// 构造结果
	$data = array('totalPay' => 0, 'avgPay' => 0, 'maxPay' => 0, 'maxPayers' => 0, 'maxPayTimes' => 0, 'maxARPU' => 0);
	foreach( $dataList as $monthData )
	{
		$data['totalPay'] 	   += $monthData['pay'];//充值总额
		$data['maxPay'] 		= $monthData['pay'] > $data['maxPay']? $monthData['pay'] : $data['maxPay'];//最高月充值
		$data['maxPayers'] 		= $monthData['payers'] > $data['maxPayers']? $monthData['payers'] : $data['maxPayers'];//最高月充值人数
		$data['maxPayTimes'] 	= $monthData['payTimes'] > $data['maxPayTimes']? $monthData['payTimes'] : $data['maxPayTimes'];//最高月充值订单数
		$data['maxARPU'] 		= $monthData['arpu'] > $data['maxARPU']? $monthData['arpu'] : $data['maxARPU'];//最高月ARPU值
	}
	$data['avgPay'] = $data['totalPay'] / count($dataList);//月平均充值
	$data['data'] 	= $dataList;
	return $data;
}