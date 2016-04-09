<?php
/*
 * Author:linruirong 
 * modify:linlisheng@feiyou.com
 * 2012-03-15
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
global $lang;

//时间
$startDay = strtotime($_POST['dateStart']);
$endDay = strtotime($_POST['dateEnd']);
$startDay = $startDay ? $startDay : strtotime(date('Y-m-d',strtotime('-6day')));
$endDay = $endDay ? $endDay : strtotime(date('Y-m-d'));
$dateStart = date('Y-m-d',$startDay);
$dateEnd =  date('Y-m-d',$endDay);
$dateStart = (strtotime($dateStart) >= strtotime(ONLINEDATE)) ? $dateStart : ONLINEDATE;
$diffDay = abs(strtotime($dateEnd) - strtotime($dateStart))/(3600*24) + 1 ;
$startStamp = strtotime($dateStart);
$endStamp = strtotime($dateEnd.' 23:59:59');

$where = " 1 AND `pay_time` >= {$startStamp} AND `pay_time` <= {$endStamp} ";

$sqlLevelTotalCnt = "  SELECT COUNT(`account_name`) AS `total_cnt` FROM `".T_LOG_PAY."` WHERE {$where} ";
$rsLevelTotalCnt = GFetchRowOne($sqlLevelTotalCnt);
$levelTotalCnt = $rsLevelTotalCnt['total_cnt'];

//$sqlLevel = " SELECT `role_level`, COUNT(`account_name`) AS `cnt` FROM `".T_LOG_PAY."` WHERE {$where} and `pay_money`=`total_pay` GROUP BY `role_level` ORDER BY `role_level` ASC ";
$sqlLevel = "select U10.`role_level`, COUNT(U10.`account_name`) AS `cnt` FROM (select `role_level`, `account_name`, min(`pay_time`) pay_time from `".T_LOG_PAY."` where {$where} group by `account_name`) U10 left join `".T_LOG_PAY."` U20 on U10.pay_time=U20.pay_time group by U10.`role_level` order by U10.`role_level`";
$rsLevel = GFetchRowSet($sqlLevel);

//单日充值金额，人数
//$sqlFirstByDate = " SELECT pay_money AS total_money,cnt,mdate ,min_pay_time FROM (
//                             SELECT sum(pay_money) as pay_money, mdate, mtime as min_pay_time,COUNT(account_name) AS cnt
//                             FROM ".T_LOG_PAY." WHERE {$where} AND `pay_money`=`total_pay` GROUP BY mdate 
//                         ) AS tmp ";
$sqlFirstByDate = "select sum(U10.pay_money) as total_money, U10.mdate, U10.min_pay_time,COUNT(U10.account_name) AS cnt FROM (select `role_level`, `account_name`, min(`pay_time`) pay_time,pay_money,pay_time min_pay_time,mdate from `".T_LOG_PAY."` where {$where} group by `account_name`) U10 left join `".T_LOG_PAY."` U20 on U10.pay_time=U20.pay_time group by `year`,`month`,`day`";
$rsFirstByDate = GFetchRowSet($sqlFirstByDate);
foreach ($rsLevel as &$row) {
	$row['rate'] = $levelTotalCnt > 0 ? round($row['cnt']/$levelTotalCnt*100, 2) : 0 ;
}

$diffDay = intval( ($endStamp - $startStamp)/86400) + 1 ;
$dateStartDiffOnline = ( ( $startStamp - strtotime(ONLINEDATE) ) /86400) + 1 ;

$resultFirstByDate = array();
$maxPersonByDate = 0;
$maxMoneyByDate = 0;
$maxGoldByDate = 0;
$allMoney=0;

for ($i=0;$i<$diffDay;$i++){
	$current = strtotime("+{$i}day",$startStamp);
	$resultFirstByDate[$i] = array(
		'index' => $i+$dateStartDiffOnline,
		'date' => $current,
		'person'=>0,
		'total_money'=>0,
	);
	foreach ($rsFirstByDate as $key => &$row) {
		if (date('Y-m-d',$row['min_pay_time']) == date('Y-m-d',$current) ) {
			$resultFirstByDate[$i]['person'] = $row['cnt'];
			$resultFirstByDate[$i]['total_money'] = round($row['total_money'],1);
			$maxPersonByDate = $row['cnt'] > $maxPersonByDate ? $row['cnt'] : $maxPersonByDate;
			$maxMoneyByDate = $row['total_money'] > $maxMoneyByDate ? $row['total_money'] : $maxMoneyByDate;
			$allPerson += $row['cnt'];
			$allMoney += $row['total_money'];
			unset($rsFirstByDate[$key]);
			break;
		}
	}
	$avgMoneyByDate = $allMoney > 0 ?  round($allMoney/$diffDay,1) : 0;
}

foreach ($rsFirstByDate as &$row) {
	$row['days'] = intval( ($row['min_pay_time'] - $startStamp)/86400 ) + 1; //开服距首付天数
}
$data = array(
	'rsLevel' => $rsLevel,
	'resultFirstByDate' => $resultFirstByDate,
	'maxPersonByDate' => $maxPersonByDate,
	'maxMoneyByDate' => round($maxMoneyByDate,1),
	'maxGoldByDate' => $maxGoldByDate,
	'avgMoneyByDate'=>$avgMoneyByDate,
	'allPerson'=>round($allPerson,1),
	'allMoney'=>round($allMoney,1),

	'dateStart'=>$dateStart,
	'dateEnd'=>$dateEnd,
    'dateToday'=>date('Y-m-d'),
    'datePrev'=>date('Y-m-d',strtotime('-1day',$startStamp)),
    'dateNext'=>date('Y-m-d',strtotime('+1day',$startStamp)),
    'onlineDay'=> ONLINEDATE,
    'minDate' => ONLINEDATE,
	'maxDate' => Datatime :: getTodayString() ,
    'lang'=>$lang,
);

$smarty->assign($data);
$smarty->display("module/pay/first_pay.tpl");

