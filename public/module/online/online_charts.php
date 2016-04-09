<?php
/**
 * 在线柱状图
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
global $lang;

$nowTime = time();
$viewType = isset ($_POST['viewtype']) ? SS($_POST['viewtype']) : 1;

//获取时间段
if (!isset ($_POST['starttime'])) {
	$startDate = Datatime :: getPreDay(date("Y-m-d"), 7);
} else {
	$startDate = SS($_POST['starttime']);
}
if (!isset ($_POST['endtime'])) {
	$endDate = Datatime :: getTodayString();
} else {
	$endDate = SS($_POST['endtime']);
}
$startDate = (strtotime($startDate) >= strtotime(ONLINEDATE)) ? $startDate : ONLINEDATE;

$viewArr = array (
	1 => $lang->page->hourMaximum,
	2 => $lang->page->dayMaximum,
	3 => $lang->page->dayAvg,
	
);
$startDateTamp = strtotime($startDate);
$endDateTamp = strtotime($endDate." 23:59:59");

$openTimestamp = strtotime( ONLINEDATE );
if($startDateTamp < $openTimestamp)
{
	$startDateTamp = $openTimestamp;
	$startDate = ONLINEDATE;
}

$viewData = getValue($startDateTamp, $endDateTamp, $viewType);

if(count($viewData['data'])){
    foreach ($viewData['data'] as $id => & $row) {
        $row['height'] = intval(200 * ($row['onlineNum'] / $viewData['maxOnline']));
    }
//    krsort($viewData['data']);
}
$maxDate = date("Y-m-d");

//今日注册信息
$todayStartTime = strtotime($maxDate);
$sqlTodayRegister = "select count(distinct uuid) as today_register from " . T_LOG_REGISTER . " where mtime>={$todayStartTime} ";
$sqlTodayRegisterResult = GFetchRowOne($sqlTodayRegister);

$todayRegister = $sqlTodayRegisterResult['today_register'] ? $sqlTodayRegisterResult['today_register'] : 0;


$smarty->assign("todayRegister", $todayRegister);
$smarty->assign("minDate", SERVER_ONLINE_DATE);
$smarty->assign("maxDate", $maxDate);
$smarty->assign("startDate", $startDate);
$smarty->assign("endDate", $endDate);
$smarty->assign('lang', $lang);
$smarty->assign('viewArr', $viewArr);
$smarty->assign('viewType', $viewType);
$smarty->assign('viewData', $viewData);
$smarty->display('module/online/online_charts.tpl');

function getValue($startDate, $endDate, $viewType) {
	$result = array ();
	$total = 0;
	$tempArr = array ();
	if (1 == $viewType) {
        $sql = "SELECT FROM_UNIXTIME(mtime,'%Y') AS `year`, FROM_UNIXTIME(mtime,'%m') AS `month`, FROM_UNIXTIME(mtime,'%d') AS `day`, FROM_UNIXTIME(mtime,'%H') AS `hour`, MAX(online) AS max_online
                FROM ".T_LOG_ONLINE." where `mtime`>=".$startDate." and `mtime`<=".$endDate."
                GROUP BY `year`,`month`,`day`,`hour`";
        $result = GFetchRowSet($sql);
        foreach($result as  $value){
            $time = $value['year'].'-'.$value['month'].'-'.$value['day'];
            $mtime = strtotime($time."$value[hour]:0:0");
            $total += $value['max_online'];
            $tempArr[] = $value['max_online'];
            $result['data'][] = array(
                "mtime" => $mtime,
                "onlineNum" => $value['max_online'],
            );
        }
	} elseif (2 == $viewType) {
        $sql= " SELECT floor(avg(`online`)) as avgonline,FROM_UNIXTIME(`mtime`, '%Y') `year`,FROM_UNIXTIME(`mtime`, '%m') `month`,FROM_UNIXTIME(`mtime`, '%d') `day` FROM `".T_LOG_ONLINE."` WHERE 1=1 ";
        $sql.=" and `mtime`>=".$startDate." and `mtime`<=".$endDate;
        $sql.=" group by year,month,day";
        $result = GFetchRowSet($sql);
        foreach($result as $value){
            $day = $value['year'].'-'.$value['month'].'-'.$value['day'];
            $mday = strtotime($day);
            $total += $value['avgonline'];
            $tempArr[] = $value['avgonline'];
            $result['data'][] = array(
                "mtime" => $day,
                "onlineNum" => $value['avgonline'],
            );
        }
	}elseif(3 == $viewType){
        $sql= "SELECT MAX( `online` ) as avgonline ,FROM_UNIXTIME(`mtime`, '%Y') `year`,FROM_UNIXTIME(`mtime`, '%m') `month`,FROM_UNIXTIME(`mtime`, '%d') `day`,FROM_UNIXTIME(`mtime`, '%H') `hour`,FROM_UNIXTIME(`mtime`, '%i') `min` FROM `".T_LOG_ONLINE."` WHERE 1=1 ";
        $sql.=" and `mtime`>=".$startDate." and `mtime`<=".$endDate;
        $sql.=" GROUP BY `year` , `month` , `day` ";
        $result = GFetchRowSet($sql);
        foreach($result as $value){
            $day = $value['year'].'-'.$value['month'].'-'.$value['day'];
            $mday = strtotime($day);
            $total += $value['avgonline'];
            $tempArr[] = $value['avgonline'];
            $result['data'][] = array(
                "mtime" => $day,
                "onlineNum" => $value['avgonline'],
            );
        }
    }
	$result['maxOnline'] = count($tempArr) ? max($tempArr) : 0;
	$result['avgOnline'] = count($result['data']) ? intval($total / count($result['data'])) : 0;
	return $result;
}
