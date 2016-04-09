<?php
/*
* 日/周用户登录量统计
*/

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
global $lang;

//获取时间段
if (!isset ($_POST['starttime'])) {
    $startDate = Datatime :: getPreDay(date("Y-m-d"), 7); 
} else {
    $startDate = trim($_POST['starttime']);
}
if (!isset ($_POST['endtime'])) {
    $endDate   = Datatime :: getTodayString();
} else {
    $endDate   = trim($_POST['endtime']);
}

$startDate = (strtotime($startDate) >= strtotime(ONLINEDATE)) ? $startDate : ONLINEDATE;

$startDateStamp = strtotime($startDate . ' 0:0:0');
$endDateStamp  = strtotime($endDate . ' 23:59:59');

$dateStrPrev = strftime("%Y-%m-%d", strtotime($startDate) - 86400);
$dateStrToday = strftime("%Y-%m-%d");
$dateStrNext = strftime("%Y-%m-%d", strtotime($startDate) + 86400);
$dateOnline = ONLINEDATE;

//日--用户登录
$ary = array();
$maxOnlineNum = $maxOnlinePaid = 0;
for($tempStamp = $startDateStamp;$tempStamp <$endDateStamp; $tempStamp += 60*60*24) {
		$tempAry = array(
			'datestr'=>date("m-d",$tempStamp),
			'serverOnlineDays'=>getServerOpenDays($tempStamp),
			'weekend'=>date('w',$tempStamp),
			'onlineNum' =>getOnlineUserOfEachDay($tempStamp,$tempStamp+60*60*24),
			'onlinePaid'=>getOnlinePaidUserOfTimeSpan($tempStamp,$tempStamp+60*60*24)
			);		
			
		$ary[] = $tempAry;
		$maxOnlineNum = max($maxOnlineNum,$tempAry['onlineNum']);
		$maxOnlinePaid = max($maxOnlinePaid,$tempAry['onlinePaid']);
}

//周--用户登录
$aryWeek = array();
$maxWeekOnline = $maxWeekPaid = 0;
for($tempStamp = $startDateStamp;$tempStamp <$endDateStamp; $tempStamp += 7*60*60*24) {
	list($weekStart,$weekEnd) = getWeekStartAndEnd($tempStamp);
	$tempAry =  array(
			'datestr'=>date("m-d",$tempStamp), //本周开始时间
			'startStr'=>date('m-d',$weekStart),//本周结束时间
			'endStr'=>date('m-d',$weekEnd -24*60*60),
			'weekNo'=>getWeekNo($tempStamp),
			'onlineNum' =>getOnlineUserOfEachDay($weekStart,$weekEnd),
			'onlinePaid'=>getOnlinePaidUserOfTimeSpan($weekStart,$weekEnd),
			'weekend'=>date('w',$tempStamp),
			'serverOnlineDays'=>getServerOpenDays($tempStamp)
		);	
		
		$maxWeekOnline = max($maxWeekOnline,$tempAry['onlineNum']);
		$maxWeekPaid = max($maxWeekPaid,$tempAry['onlinePaid']);
		$aryWeek[] = $tempAry;
}

$smarty->assign("startDate", date('Y-m-d',$startDateStamp));
$smarty->assign("endDate", date('Y-m-d',$endDateStamp));
$smarty->assign(array(
	'maxOnline'=>$maxOnlineNum == 0 ? 0: 120/$maxOnlineNum,
	'maxPaid'=>$maxOnlinePaid == 0 ? 0 :120/$maxOnlinePaid,
	'weekMaxOnline'=>$maxWeekOnline == 0 ? 0:120/$maxWeekOnline,
	'weekMaxPaid'=>$maxWeekPaid == 0 ? 0:120/$maxWeekPaid
));

$smarty->assign("minDate", ONLINEDATE);
$smarty->assign("maxDate", Datatime :: getTodayString());
$smarty->assign("dateStrPrev", $dateStrPrev);
$smarty->assign("dateStrToday", $dateStrToday);
$smarty->assign("dateStrNext", $dateStrNext);
$smarty->assign("dateOnline", $dateOnline);
$smarty->assign("ary", $ary);
$smarty->assign('aryWeek',$aryWeek);
$smarty->assign('lang',$lang);
$smarty->display("module/basedata/user_leave_count.tpl");
exit();

//取得开服第几天
function getServerOpenDays($stamp){
	return intval(($stamp - strtotime(ONLINEDATE))/(24*60*60));
}

//取得开服第几周
function getWeekNo($time){
	$startStr = strtotime(ONLINEDATE);
	$span = $time - $startStr ;
	$weekNo = floor($span/(60*60*24*7))+1;
	return abs($weekNo);
}

//用户登录数
function getOnlineUserOfEachDay($startStamp,$endStamp){
	$sql = "SELECT count(*) as `num` from ".T_LOG_LOGIN." where `mtime` > $startStamp and `mtime` < $endStamp";
	$result = GFetchRowOne($sql);
	return $result['num'];
}

//付费用户登陆量(日/周)
function getOnlinePaidUserOfTimeSpan($start,$end){
	$sql = "SELECT count(distinct `pay`.`account_name`) as `num` from ".T_LOG_LOGIN." as `ext`,".T_LOG_PAY." `pay` where `ext`.`account_name` = `pay`.`account_name` and `ext`.`mtime` > $start and `ext`.`mtime` < $end ";
	$result = GFetchRowOne($sql);
	return $result['num'];
}

//每周开始--结束
function getWeekStartAndEnd($time){
	if (date('w',$time) == 0){
		$start = strtotime(date("Y-m-d",$time));
	}else{
		$start = strtotime('last Sunday',$time);
	}
	$end = $start+7*60*60*24;
	return array($start,$end);
}



