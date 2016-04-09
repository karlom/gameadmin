<?php

/**
 * 查看在线数据
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
global $lang;

//获取当前时间
$nowTime = time();
$action = isset($_POST['action']) ? SS($_POST['action']) : '';

$type = HOW_LONG_TIME_PER_POINT; //表示n分钟一个点

if ('ajax_online' == $action) {
	$timeStamp = strtotime(date("Y-m-d H:i", strtotime($startDate) + floor($nowTime / ($type * 60)) * ($type * 60)));
	$avgNum = getCurrentPoint($timeStamp, $type); //n分钟平均
//	$maxOnline = MaxCount($timeStamp - $type * 60, $timeStamp);//最高在线
	$avgNum = (0 < $avgNum) ? $avgNum : 0;
	$maxOnline = (0 < $maxOnline) ? $maxOnline : 0;
	$result = array (
		'avgnum' => $avgNum,
		'maxonline' => $maxOnline
	);
	echo json_encode($result);
	exit ();
}

//获取时间段
if (!isset ($_POST['starttime'])) {
	$startDate = Datatime :: getPreDay(date("Y-m-d"), 6);
} else {
	$startDate = SS($_POST['starttime']);
}
if (!isset ($_POST['endtime'])) {
	$endDate = Datatime :: getTodayString();
} else {
	$endDate = SS($_POST['endtime']);
}
$startDate = (strtotime($startDate) >= strtotime(ONLINEDATE)) ? $startDate : ONLINEDATE;
$ajaxLoad = ($endDate == date("Y-m-d", $nowTime)) ? true : false;
$showType = (isset($_POST['search']) && "search" == $_POST['search']) ? 1 : 2;

//获取用于显示的数据，这个最好不要在本文件的代码写，这样的耦合度是最高的，最好是用接口的形式提供,现在只是模拟数据用来显示
$viewData = getOnlineData($startDate, $endDate, $showType, $type);
$viewData['timeType'] = $type;

//对返回数据进行检查,对缺少的数据填充0
if ($viewData['data']) {
	foreach ($viewData['data'] as $key => & $data) {
		$end = ($key == date("Y-m-d")) ? ($nowTime -strtotime($key)) / ($type * 60) : 24 * 3600 / ($type * 60);
		for ($i = 0; $i < $end; $i++) {
			if (!array_key_exists($i, $data)) {
				$data[$i] = array (
					"num" => 0,
					"point" => $i
				);
			}
		}
		ksort($data);
	}
}

krsort($viewData['data']);
//连续曲线
$viewData2 = getOnlineData2($startDate, $endDate);
$end = ($endDate == date("Y-m-d")) ? intval(($nowTime - strtotime($startDate)) / ($viewData2['timeType'] * 60)) : $viewData2['days'] * 24 * 3600 / 60;
for ($i = 0; $i < $end; $i++) {
	if (!array_key_exists($i, $viewData2['data'])) {
		$viewData2['data'][$i] = array (
			"num" => 0,
			"point" => $i
		);
	}
}
$viewData2['year'] = date("Y", strtotime($startDate));
$viewData2['month'] = date("m", strtotime($startDate));
$viewData2['day'] = date("d", strtotime($startDate));
$viewData2['chartName'] = $startDate."~".$endDate;
ksort($viewData2['data']);
//print_r($viewData['data']);exit();

$maxDate = date("Y-m-d");

$smarty->assign("minDate", ONLINEDATE);
$smarty->assign("maxDate", $maxDate);
$smarty->assign("startDate", $startDate);
$smarty->assign("endDate", $endDate);

$smarty->assign('lang', $lang);
$smarty->assign('ajaxLoad', $ajaxLoad);
$smarty->assign('viewData', $viewData);
$smarty->assign('viewData2', $viewData2);
$smarty->display('module/online/online.tpl');

function getOnlineData($startDate, $endDate, $showType, $type) {
	if(1 == $showType){
		$diff = Datatime :: getTotleDay($startDate, $endDate) + 1;
		for($i = 0; $i < $diff; $i++){
			$data['data'][date("Y-m-d", strtotime($startDate) + $i * 86400)] = getValue(date("Y-m-d", strtotime($startDate) + $i * 86400), $type);
		}
	}else{
		$dataArr = array(
			$endDate, Datatime :: getPreDay($endDate)
		);
		if(strtotime($startDate) < strtotime(Datatime :: getPreDay($endDate, 7))){
		    $dataArr[] = Datatime :: getPreDay($endDate, 7);
		}
		foreach($dataArr as $value){
			$data['data'][$value] = getValue($value, $type);
		}
	}
	return $data;
}

function getOnlineData2($startDate, $endDate) {
	$diff = Datatime :: getTotleDay($startDate, $endDate) + 1;
	$startTimeStamp = strtotime($startDate);
	$endTimeStamp = strtotime($endDate." 23:59:59");
	$sql = "select round(avg(`online`)) `num`, floor((`mtime`-{$startTimeStamp})/".(HOW_LONG_TIME_PER_POINT * 60).") as `point` from ".T_LOG_ONLINE." where mtime >= {$startTimeStamp} and mtime<={$endTimeStamp} group by point";
    $result['data'] = GFetchRowSet($sql, "point");
    $result['timeType'] = HOW_LONG_TIME_PER_POINT;
    $result['days'] = $diff;
	return $result;
}

function getCurrentPoint($timeStamp, $type) {
	$starttime = $timeStamp - $type * 60;
	$sql = "SELECT round(avg(`online`)) `online` FROM ".T_LOG_ONLINE." WHERE `mtime`>={$starttime} and `mtime`<={$timeStamp}";
	$row = GFetchRowOne($sql);
	return $row['online'];
}

function getValue($date, $type){
	global $nowTime;
	
	$datetime = strtotime($date);
	$dateEndTime = strtotime($date." 23:59:59 ");
	$sql = "select round(avg(`online`)) `num`, floor((`mtime`-$datetime)/".($type * 60).") as `point` from ".T_LOG_ONLINE." where mtime>={$datetime} and mtime<={$dateEndTime} group by point";
    $rs = GFetchRowSet($sql, "point");

	return $rs;
}