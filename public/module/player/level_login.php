<?php
define('IN_ADMIN_SYSTEM', true);
include_once "../../../protected/config/config.php";
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';

global $lang;

$dateStart = SS($_REQUEST['dateStart']);
$dateEnd = SS($_REQUEST['dateEnd']);

if(empty($dateStart)){
   	 $dateStart = strftime ("%Y-%m-%d", strtotime('-6day',time()));
}
if(empty($dateEnd)){
   	 $dateEnd = date('Y-m-d');
}
$dateStartStamp = strtotime($dateStart.' 0:0:0');
$dateEndStamp = strtotime($dateEnd.' 23:59:59');

$openTimestamp = strtotime( ONLINEDATE );
if($dateStartStamp < $openTimestamp)
{
	$dateStartStamp = $openTimestamp;
	$dateStart = ONLINEDATE;
}

$dateStartStamp = $dateStartStamp < strtotime(SERVER_ONLINE_DATE) ? strtotime(SERVER_ONLINE_DATE) : $dateStartStamp;
$dateStartStamp = $dateStartStamp > $unixTime ? $unixTime:$dateStartStamp;
$dateEndStamp = $dateEndStamp < strtotime(SERVER_ONLINE_DATE) ? strtotime(SERVER_ONLINE_DATE) : $dateEndStamp;
$dateEndStamp = $dateEndStamp > $unixTime ? $unixTime:$dateEndStamp;

$dateStartStamp = strtotime($dateStart.' 0:0:0');
$dateEndStamp = strtotime($dateEnd.' 23:59:59');

$dateStrToday = date('Y-m-d');
$dateStrPrev = date('Y-m-d',strtotime('-1day',$dateEndStamp));
$dateStrNext = date('Y-m-d',strtotime('+1day',$dateEndStamp));
$dateStrOnline = date('Y-m-d',strtotime(SERVER_ONLINE_DATE));

$startTime = $dateStartStamp;
$endTime = $dateEndStamp;

//获取用于显示的数据，这个最好不要在本文件的代码写，这样的耦合度是最高的，最好是用接口的形式提供,现在只是模拟数据用来显示
$viewData = getLevelLoginData($dateStartStamp, $dateEndStamp);

//对返回数据进行检查,对缺少的数据填充0
if ($viewData != "UNKNOWN") {
	$result = array();
	$level_range = $viewData['level_range'];
	$top_level = $viewData['top_level'];
	$max = $top_level/$level_range;
	$level_data = $viewData['level_data'];
	if($level_data){
		for($i = 0 ; $i < $max; $i++){
			foreach($level_data as $key => $row){
				if($row['level'] > $i*$level_range && $row['level'] <= ($i+1)*$level_range){
					$result[($i*$level_range+1)."_".($i+1)*$level_range]['loginCount'] += $row['loginCount'];
					$total += $row['loginCount'];
				}
			}
		}
		$max = 0;
		foreach($result as $key => $row){
			if($max < $row['loginCount']){
				$max = $row['loginCount'];
			}
		}
	}
}
$rate = 0.8;
foreach($result as $key => $row){
	if($row['loginCount'] > $max*$rate){
		$result[$key]['red'] = 1;
	}
}
$max = $max/120;

$minDate = $serverList[$_SESSION ['gameAdminServer']]['onlinedate'];
$maxDate = date("Y-m-d");

$smarty->assign("minDate", $minDate);
$smarty->assign("maxDate", $maxDate);

$smarty->assign("dateStart", $dateStart);
$smarty->assign("dateEnd", $dateEnd);
$smarty->assign("dateStrPrev", $dateStrPrev);
$smarty->assign("dateStrNext", $dateStrNext);
$smarty->assign("dateStrToday", $dateStrToday);
$smarty->assign("dateStrOnline", $dateStrOnline);
$smarty->assign('level_range', $level_range);
$smarty->assign('top_level', $top_level);
$smarty->assign('max', $max);
$smarty->assign('result', $result);
$smarty->assign('total', $total);
$smarty->assign('lang', $lang);
$smarty->assign('level_data', $level_data);
$smarty->display('module/player/level_login.tpl');

function getLevelLoginData($dateStartStamp, $dateEndStamp) {
	$data['level_range'] = 10;
	$data['top_level'] = GAME_MAXLEVEL;
	$sql = "select level, count(account_name) loginCount from ".T_LOG_LOGIN." where mtime>={$dateStartStamp} and mtime<={$dateEndStamp} group by level";
	$result = GFetchRowSet($sql);
	foreach($result as $key => $value){
		$data['level_data'][] = array(
			'level' => $value['level'],
			'loginCount' => $value['loginCount'],
		);
	}
	return $data;
}