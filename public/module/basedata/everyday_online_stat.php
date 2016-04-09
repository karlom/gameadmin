<?php
/**
 * 每日登录统计 
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

$login = array();
$paid = array();
for ($itr = $startDateStamp; $itr <= $endDateStamp; $itr += 24*60*60 ){
	$cur     = strtotime(date('Y-m-d',$itr));
	$paid[]  = getPaidData($cur);
	$login[] = getLoginData($cur);
}

$data = array();
for ($itr = 0; $itr < count($paid);$itr++){
	$data[] = array(
		'date'   =>$paid[$itr]['label'],
		'weekend'=>$paid[$itr]['weekend'],
		'cid'    =>$login[$itr]['cid'],
		'crid'   =>$login[$itr]['crid'],
		'cip'    =>$login[$itr]['cip'],
		'login'  =>$paid[$itr]['login'],
		'loss'   =>$paid[$itr]['loss']
	);
}

$max = array(
	'cid'  =>0,
	'crid' =>0,
	'cip'  =>0,
	'login'=>0,
	'loss' =>0,
);

$idxAry = array('cid','crid','cip','loss','login');
foreach ($data as $item){
	foreach ($idxAry as $idx){
		$max[$idx] = max($item[$idx],$max[$idx]);
	}
}
foreach ($max as &$item){
	$item = $item/120;
}

$smarty->assign(array(
	'startDate' => $startDate,
	'endDate'   => $endDate,
	'minDate'   => ONLINEDATE,
	'maxDate'   => Datatime :: getTodayString(),
	'dateStrPrev' => $dateStrPrev,
	'dateStrToday'=> $dateStrToday,
	'dateStrNext' => $dateStrNext,
	'dateOnline'  => $dateOnline,
	'data' => $data,
	'max'  => $max,
	'lang' => $lang
));

$smarty->display('module/basedata/everyday_online_stat.tpl');

function getLoginData($startDateStamp){
	$endDateStamp = $startDateStamp + 60*60*24;
	$sql = "select count(`account_name`) as `cid`, count(distinct `account_name` ) as `crid`,count(distinct `ip`) as `cip` from ".T_LOG_LOGIN." where `mtime` >= $startDateStamp and `mtime` < $endDateStamp ";
//echo $sql."<br>";
	return GFetchRowOne($sql);
}

/**
 * 充值信息综合
 */
function getPaidData($startDateStamp){
	$ary['login'] = getLatestThreeDaysOnline($startDateStamp+60*60*24);
	$ary['loss'] = getPaidLoss($startDateStamp, $startDateStamp+60*60*24);
	$ary['label'] = date('Y-m-d',$startDateStamp);
//	$ary['weekend'] = judgeIfWeekend($startDateStamp+1);
	$ary['weekend'] = date('w',$startDateStamp+1);
	return $ary;
}

/**
 * 付费用户某一天的停留数
 * @param $startDateStamp
 * @param $endDateStamp
 */
function getPaidLoss($startDateStamp,$endDateStamp){
	$sql = "SELECT count(distinct `pay`.`account_name`) as num from ".T_LOG_LOGIN." `ext`, ".T_LOG_PAY." `pay` where `ext`.`account_name` = `pay`.`account_name` and `ext`.`mtime` > $startDateStamp and `ext`.`mtime` < $endDateStamp ";
	$result = GFetchRowOne($sql);	
	return $result['num'];
}

/**
 * 
 * 近三日有登录信息的付费玩家
 * @param unknown_type $endDate
 */
function getLatestThreeDaysOnline($endDateStamp){
	$startDateStamp = $endDateStamp - 60*60*24*3;
	$sql = "SELECT count(distinct `login`.`account_name`) as `num` from ".T_LOG_LOGIN." `login` ,".T_LOG_PAY." `pay` where `pay`.`account_name` = `login`.`account_name` and `login`.`mtime` > $startDateStamp and `login`.`mtime` < $endDateStamp ";
	$result = GFetchRowOne($sql);
	return $result['num'];
}

