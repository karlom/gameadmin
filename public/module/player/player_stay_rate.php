<?php
/**
 * 次日、周、月留存统计
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT.'/dict.php';

global $lang;


//获取时间
if (!isset ($_POST['starttime'])) {
//    $startDate = Datatime :: getPreDay(date("Y-m-d"), 7); 
    $startDate = ONLINEDATE; 
} else {
    $startDate = trim($_POST['starttime']);
}

$startDate = (strtotime($startDate) >= strtotime(ONLINEDATE)) ? $startDate : ONLINEDATE;


$startDateStamp = strtotime($startDate . ' 0:0:0');
//$endDateStamp  = strtotime($startDate . ' 23:59:59');

$oneDay = 86400;
$oneWeek = 7*$oneDay;
$oneMonth = 30*$oneDay;

$player = array();


$player['day']['reg'] = getRegisterUserAmount($startDateStamp, 1);
$player['day']['login'] = getOnlineUserAmount($startDateStamp, 1, 1);

//$player['week']['reg'] = getRegisterUserAmount($startDateStamp, 1);
$player['week']['login'] = getOnlineUserAmount($startDateStamp, 7, 7);

//$player['month']['reg'] = getRegisterUserAmount($startDateStamp, 1);
$player['month']['login'] = getOnlineUserAmount($startDateStamp, 30, 30);

//2-7天数据
$player['day2']['login'] = getOnlineUserAmount($startDateStamp,2, 1);
$player['day3']['login'] = getOnlineUserAmount($startDateStamp,3, 1);
$player['day4']['login'] = getOnlineUserAmount($startDateStamp,4, 1);
$player['day5']['login'] = getOnlineUserAmount($startDateStamp,5, 1);
$player['day6']['login'] = getOnlineUserAmount($startDateStamp,6, 1);
	
if($player['day']['reg']){
	$player['day']['stay_rate'] = round($player['day']['login']/$player['day']['reg'],4)*100;
	$player['week']['stay_rate'] = round($player['week']['login']/$player['day']['reg'],4)*100;
	$player['month']['stay_rate'] = round($player['month']['login']/$player['day']['reg'],4)*100;
	
	$player['day2']['stay_rate'] = round($player['day2']['login']/$player['day']['reg'],4)*100;
	$player['day3']['stay_rate'] = round($player['day3']['login']/$player['day']['reg'],4)*100;
	$player['day4']['stay_rate'] = round($player['day4']['login']/$player['day']['reg'],4)*100;
	$player['day5']['stay_rate'] = round($player['day5']['login']/$player['day']['reg'],4)*100;
	$player['day6']['stay_rate'] = round($player['day6']['login']/$player['day']['reg'],4)*100;
	
} else {
	$player['day']['stay_rate'] = "-";
	$player['week']['stay_rate'] = "-";
	$player['month']['stay_rate'] = "-";
	
	$player['day2']['stay_rate'] = "-";
	$player['day3']['stay_rate'] = "-";
	$player['day4']['stay_rate'] = "-";
	$player['day5']['stay_rate'] = "-";
	$player['day6']['stay_rate'] = "-";
}

//qqgame
$pf = "qqgame";
$qqgame = array();
$qqgame['day']['reg'] = getRegisterUserAmount($startDateStamp, 1, $pf);
$qqgame['day']['login'] = getOnlineUserAmount($startDateStamp, 1, 1, $pf);

$qqgame['week']['login'] = getOnlineUserAmount($startDateStamp, 7, 7, $pf);

$qqgame['month']['login'] = getOnlineUserAmount($startDateStamp, 30, 30, $pf);

//2-7天数据
$qqgame['day2']['login'] = getOnlineUserAmount($startDateStamp,2, 1, $pf);
$qqgame['day3']['login'] = getOnlineUserAmount($startDateStamp,3, 1, $pf);
$qqgame['day4']['login'] = getOnlineUserAmount($startDateStamp,4, 1, $pf);
$qqgame['day5']['login'] = getOnlineUserAmount($startDateStamp,5, 1, $pf);
$qqgame['day6']['login'] = getOnlineUserAmount($startDateStamp,6, 1, $pf);
	
if($qqgame['day']['reg']){
	$qqgame['day']['stay_rate'] = round($qqgame['day']['login']/$qqgame['day']['reg'],4)*100;
	$qqgame['week']['stay_rate'] = round($qqgame['week']['login']/$qqgame['day']['reg'],4)*100;
	$qqgame['month']['stay_rate'] = round($qqgame['month']['login']/$qqgame['day']['reg'],4)*100;
	
	$qqgame['day2']['stay_rate'] = round($qqgame['day2']['login']/$qqgame['day']['reg'],4)*100;
	$qqgame['day3']['stay_rate'] = round($qqgame['day3']['login']/$qqgame['day']['reg'],4)*100;
	$qqgame['day4']['stay_rate'] = round($qqgame['day4']['login']/$qqgame['day']['reg'],4)*100;
	$qqgame['day5']['stay_rate'] = round($qqgame['day5']['login']/$qqgame['day']['reg'],4)*100;
	$qqgame['day6']['stay_rate'] = round($qqgame['day6']['login']/$qqgame['day']['reg'],4)*100;
	
} else {
	$qqgame['day']['stay_rate'] = "-";
	$qqgame['week']['stay_rate'] = "-";
	$qqgame['month']['stay_rate'] = "-";
	
	$qqgame['day2']['stay_rate'] = "-";
	$qqgame['day3']['stay_rate'] = "-";
	$qqgame['day4']['stay_rate'] = "-";
	$qqgame['day5']['stay_rate'] = "-";
	$qqgame['day6']['stay_rate'] = "-";
}

$data['player'] = $player;
$data['qqgame'] = $qqgame;
$data['lang'] = $lang;


$minDate = ONLINEDATE;
$maxDate = date ( "Y-m-d" );

$smarty->assign('minDate', $minDate);
$smarty->assign('maxDate', $maxDate);
$smarty->assign('startDate', $startDate);
$smarty->assign($data);
$smarty->display("module/player/player_stay_rate.tpl");

//注册用户数
function getRegisterUserAmount($startStamp, $days, $pf=""){
	$endStamp = $startStamp + $days*86400;
	
	if($pf){
		$wherePf = " and pf='{$pf}'";
	}
	
	$sql = "SELECT count(distinct `uuid`) as `num` from ".T_LOG_REGISTER." where `mtime` >= $startStamp and `mtime` < $endStamp {$wherePf} ";
	
	$result = GFetchRowOne($sql);
	return $result['num'];
}

//登录用户数
function getOnlineUserAmount($startStamp, $d, $days, $pf=""){
	//$startStamp开始时间， $d第几天，$days统计几天

	if($pf){
		$wherePf1 = " and l.pf='{$pf}'";
		$wherePf2 = " and r.pf='{$pf}'";
	}
	
	//注册起始
	$regStartStamp = $startStamp;
	$regEndStamp = $regStartStamp + 86400;
	//登录起始
	$loginStartStamp = $d*86400 + $startStamp;
	$loginEndStamp = $loginStartStamp + $days*86400;
	
	
	$sql = "SELECT count(distinct l.`uuid`) as `num` FROM ".T_LOG_LOGIN." l INNER JOIN ".T_LOG_REGISTER." r ON l.`uuid`=r.`uuid`" .
			" WHERE l.`mtime` >= $loginStartStamp AND l.`mtime` < $loginEndStamp" .
			" AND r.`mtime` >= $regStartStamp AND r.`mtime` < $regEndStamp {$wherePf1} {$wherePf2}" ;
	 
	$result = GFetchRowOne($sql);
	return $result['num'];
}