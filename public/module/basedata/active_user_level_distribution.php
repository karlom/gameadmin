<?php
/**
 * 活跃用户等级分布 
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';
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

$sql = "select count(`id`) as `cid`,count(distinct `account_name`) as crid ,floor(`level`/5) as `new_level`,`mtime`,`ymd` from ".T_LOG_ACTIVE_LEVEL_USER." where`mtime` >= $startDateStamp and `mtime` <= $endDateStamp group by `new_level`,`ymd` order by `new_level`,`ymd`";
$result = GFetchRowSet($sql);

list($max,$dailyData) = flattenByDay($result);
$max['cid'] =  $max['cid'] / 120;
$max['crid'] = $max['crid'] /120;

//统计
$countSql = "select count(`id`) `total`,`mtime`,`ymd` from ".T_LOG_ACTIVE_LEVEL_USER." where `mtime` >= $startDateStamp and `mtime` <= $endDateStamp group by `ymd`";
$countRs  = GFetchRowSet($countSql);
foreach ($countRs as &$value){
	$value['date'] = date('Y-m-d',$value['mtime']);
}

$smarty->assign(array(
	'rs'       => $countRs,
	'data'     => $dailyData,
	'startDate'=> $startDate,
	'endDate'  => $endDate,
	'cid'      => $max['cid'],
	'crid'     => $max['crid'],
	'max'      => $max,
	'prev'     => $dateStrPrev,
	'today'    => $dateStrToday,
	'next'     => $dateStrNext,
	'online'   => $dateOnline,
    'minDate'  => ONLINEDATE,
    'maxDate'  => Datatime :: getTodayString(),
	'lang'     => $lang
));
$smarty->display('module/basedata/active_user_level_distribution.tpl');

function flattenByDay($result){
	$max = array('cid'=>0,'crid'=>0);
	$ret = array();
	foreach ($result as $key => $item) {
		$item['ymd'] = date('Y-m-d',$item['mtime']);

		if (!isset($ret[$item['ymd']])) {
			$ret[$item['ymd']] = array();
		}

		$ret[$item['ymd']][$item['new_level']] = array(
			'ymd'  => $item['ymd'],
			'cid'  => $item['cid'],
			'crid' => $item['crid'],
			'label'=> "[".($item['new_level']*5)."~".($item['new_level']*5+5).")",
		);		

		$max['cid']  = max($max['cid'],$item['cid']);
		$max['crid'] = max($max['crid'],$item['crid']);
	}
	return array($max,$ret);
}


