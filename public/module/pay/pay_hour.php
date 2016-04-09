<?php
/*
 * Author:linruirong 
 * modify:linlisheng@feiyou.com
 * 2012-3-14
 */
 
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
global $lang;

//时间
$startDay = strtotime($_POST['startDay']);
$endDay = strtotime($_POST['endDay']);
$startDay = $startDay ? $startDay : strtotime(date('Y-m-d',strtotime('-6day')));
$endDay = $endDay ? $endDay : strtotime(date('Y-m-d'));

$viewType = intval($_POST['viewType']) ? intval($_POST['viewType']) : 1 ; //默认显示综合统计图
$showType = intval($_POST['showType']) ? intval($_POST['showType']) : 1 ;
$dateStart = date('Y-m-d',$startDay);
$dateEnd =  date('Y-m-d',$endDay);
$dateStart = (strtotime($dateStart) >= strtotime(ONLINEDATE)) ? $dateStart : ONLINEDATE;
$diffDay = abs(strtotime($dateStart) - strtotime($dateEnd))/(3600*24) + 1 ;
$startStamp = strtotime($dateStart);
$endStamp = strtotime($dateEnd.' 23:59:59');

$arrShowType = array(9=>$lang->page->showType1,1=>$lang->page->showType2,2=>$lang->page->showType3,3=>$lang->page->showType4,4=>$lang->page->showType5,);
$arrViewType = array(1=>$lang->page->viewType1,2=>$lang->page->viewType2);

//======== 查结果 =====
if (1==$viewType) { //查多天，只计算综合结果
	$sqlSumHour = " SELECT SUM(`pay_money`) AS totalMoney, COUNT(DISTINCT(account_name)) AS totalPerson,
					COUNT(`account_name`) AS totalPersonTime,`hour`
					FROM ".T_LOG_PAY."
					WHERE `mtime` BETWEEN {$startStamp} AND {$endStamp}
					GROUP BY `hour`
					ORDER BY `hour` ASC ";
	$resultSumHour = GFetchRowSet($sqlSumHour);

	$showType = intval($_POST['showType']) ? intval($_POST['showType']) :1 ;
	$maxSumMoney = 0;
	$maxSumPerson = 0;
	$maxSumPersonTime = 0;
	$maxSumArpu = 0;
	$allSumTotalMoney = 0;
	$paySumHours = array();
	if (is_array($resultSumHour) && !empty($resultSumHour)) {
		for ($hour=0; $hour <= 23 ; $hour++){
			$existSum = false;
			foreach ($resultSumHour as $key => $row) {
				if ($row['hour'] == $hour) {
					$maxSumMoney = $row['totalMoney'] > $maxSumMoney ? $row['totalMoney'] : $maxSumMoney;
					$maxSumPerson = $row['totalPerson'] > $maxSumPerson ? $row['totalPerson'] : $maxSumPerson;
					$maxSumPersonTime = $row['totalPersonTime'] > $maxSumPersonTime ? $row['totalPersonTime'] : $maxSumPersonTime;

					$allSumTotalMoney += $row['totalMoney'];
					$paySumHours[$hour]['totalMoney'] = round($row['totalMoney'],1);
					$paySumHours[$hour]['totalPerson'] = $row['totalPerson'];
					$paySumHours[$hour]['totalPersonTime'] = $row['totalPersonTime'];
					$existSum = true;
					unset($resultSumHour[$key]);
					break;
				}
			}
			if (!$existSum) {
				$paySumHours[$hour]['totalMoney'] = 0;
				$paySumHours[$hour]['totalPerson'] = 0;
				$paySumHours[$hour]['totalPersonTime'] = 0;
			}
			$paySumHours[$hour]['arpu'] = $paySumHours[$hour]['totalPerson'] > 0 ? round($paySumHours[$hour]['totalMoney']/$paySumHours[$hour]['totalPerson'],1) : 0 ;
			$paySumHours[$hour]['tip'] = "金额：{$paySumHours[$hour]['totalMoney']}，人数：{$paySumHours[$hour]['totalPerson']}，人次：{$paySumHours[$hour]['totalPersonTime']}，ARPU值：{$paySumHours[$hour]['arpu']}";
			$maxSumArpu = $paySumHours[$hour]['arpu'] > $maxSumArpu ? $paySumHours[$hour]['arpu'] : $maxSumArpu;
		}
	}
	$avgSumMoney = round($allSumTotalMoney/$diffDay/24, 2);

}else {
	$select = " SUM(`pay_money`) AS totalMoney , COUNT(DISTINCT(account_name)) AS totalPerson,
				COUNT(`account_name`) AS totalPersonTime,
				CONCAT(`year`,'-',`month`,'-',`day` ) AS `date`,
				`year`,`month`,`day`,`hour` ";

	$sql = " SELECT {$select}
			 FROM ".T_LOG_PAY."
			 WHERE `mtime` BETWEEN {$startStamp} AND {$endStamp}
			 GROUP BY `year`,`month`,`day`,`hour`
			 ORDER BY  `mtime` ";
	$result = GFetchRowSet($sql);

	$maxMoney = 0;
	$maxPerson = 0;
	$maxPersonTime = 0;
	$maxArpu = 0;
	$allTotalMoney = 0;
	$showType = isset($_POST['showType']) ? intval($_POST['showType']) : 1 ; //默认显示“金额”视图
	$payHours = array();
	if (is_array($result) && !empty($result)) {
		$timeStamp =  $endStamp >  $startStamp ? $endStamp : $startStamp ;
		for ($day=0; $day < $diffDay; $day++){
			$date = date('Y-n-j',strtotime('-'.$day.'day',$timeStamp));
			for ($hour=0; $hour <= 23 ; $hour++){
				$exist = false;
				foreach ($result as $key => $row) {
					if ($row['date'] == $date && $row['hour'] == $hour) {
						$maxMoney = $row['totalMoney'] > $maxMoney ? $row['totalMoney'] : $maxMoney;
						$maxPerson = $row['totalPerson'] > $maxPerson ? $row['totalPerson'] : $maxPerson;
						$maxPersonTime = $row['totalPersonTime'] > $maxPersonTime ? $row['totalPersonTime'] : $maxPersonTime;

						$allTotalMoney += $row['totalMoney'];
						$payHours[$date][$hour]['totalMoney'] = round($row['totalMoney'],1);
						$payHours[$date][$hour]['totalPerson'] = $row['totalPerson'];
						$payHours[$date][$hour]['totalPersonTime'] = $row['totalPersonTime'];
						$exist = true;
						unset($result[$key]);
						break;
					}
				}
				if (!$exist) {
					$payHours[$date][$hour]['totalMoney'] = 0;
					$payHours[$date][$hour]['totalPerson'] = 0;
					$payHours[$date][$hour]['totalPersonTime'] = 0;
				}
				$payHours[$date][$hour]['arpu'] = $payHours[$date][$hour]['totalPerson'] > 0 ? round($payHours[$date][$hour]['totalMoney']/$payHours[$date][$hour]['totalPerson'],1) : 0 ;
				$payHours[$date][$hour]['tip'] = "金额：{$payHours[$date][$hour]['totalMoney']}，人数：{$payHours[$date][$hour]['totalPerson']}，人次：{$payHours[$date][$hour]['totalPersonTime']}，ARPU值：{$payHours[$date][$hour]['arpu']}";
				$maxArpu = $payHours[$date][$hour]['arpu'] > $maxArpu ? $payHours[$date][$hour]['arpu'] : $maxArpu;
			}
		}
	}
	$avgMoney = round($allTotalMoney/$diffDay/24, 2);
}

$data = array(
	'payHours' => $payHours,
	'maxMoney' => round($maxMoney,1),
	'avgMoney' => $avgMoney,
	'allTotalMoney' => round($allTotalMoney,1),
	'maxPerson' => $maxPerson,
	'maxPersonTime' => $maxPersonTime,
	'maxArpu' => $maxArpu,

	'maxSumMoney' =>    round($maxSumMoney,1),
	'maxSumPerson' =>   $maxSumPerson,
	'maxSumPersonTime'=>$maxSumPersonTime,
	'maxSumArpu' =>     $maxSumArpu,
	'allSumTotalMoney'=>round($allSumTotalMoney,1),
	'paySumHours' =>    $paySumHours,
	'avgSumMoney' => $avgSumMoney,

	'startDay' => $dateStart,
	'endDay' => $dateEnd,
	'showType'=>$showType,
	'arrShowType'=>$arrShowType,
	'viewType'=>$viewType,
	'arrViewType'=>$arrViewType,
	'dateToday'=>date('Y-m-d'),
	'datePrev'=>date('Y-m-d',strtotime('-1day',$startDay)),
	'dateNext'=>date('Y-m-d',strtotime('+1day',$startDay)),
	'onlineDay'=> ONLINEDATE,
    'minDate' => ONLINEDATE,
	'maxDate' => Datatime :: getTodayString() ,
	'lang'=>$lang,
);

$smarty->assign($data);
$smarty->display("module/pay/pay_hour.tpl");

