<?php
/**
 * 3天有奖
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

//$startDate = (strtotime($startDate) >= strtotime(ONLINEDATE)) ? $startDate : ONLINEDATE;

$startDateStamp = strtotime($startDate . ' 0:0:0');
$endDateStamp  = strtotime($endDate . ' 23:59:59');

$dateStrPrev = strftime("%Y-%m-%d", strtotime($startDate) - 86400);
$dateStrToday = strftime("%Y-%m-%d");
$dateStrNext = strftime("%Y-%m-%d", strtotime($startDate) + 86400);
$dateOnline = ONLINEDATE;

$sql = "select count(distinct role_name) as role from t_log_level_up where level>='29' and mtime>={$startDateStamp} and mtime<={$endDateStamp} ";
$count = GFetchRowOne($sql);
$sqlgroup = "select times,count(*) as count from t_log_threepolite group by times";
$result = GFetchRowSet($sqlgroup);
$data = array();
$data['29'] = $count['role'];
foreach($result as $key =>$val)
{
    $data[$val['times']] = $val['count'];
}

$smarty->assign(array(
        'lang'      => $lang,
	'startDate' => $startDate,
	'endDate'   => $endDate,
	'dateStrPrev' => $dateStrPrev,
	'dateStrToday'=> $dateStrToday,
	'dateStrNext' => $dateStrNext,
	'dateOnline'  => $dateOnline,
        'data'        => $data,
));

$smarty->display('module/basedata/threepolite.tpl');
