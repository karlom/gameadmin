<?php
/**
 * zmwd_statistics.php
 * 诛魔卫道 数据统计
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';
include_once SYSDIR_ADMIN_DICT.'/dict.php';

$copyId = 700;
$mapId = 700;
$limitLevel = 50;


//副本开启时间：每天12:30 - 12:45

$today = date('Y-m-d'); 
$todayTime = strtotime($today." 00:00:00 "); 
$todayEndTime = strtotime($today." 23:59:59 "); 

$startTime = $todayTime;
$endTime = $todayEndTime;


$startDay = $_REQUEST['startDay'] ? $_REQUEST['startDay'] : date("Y-m-d", ($todayTime - 2*86400) );
$endDay = $_REQUEST['endDay'] ? $_REQUEST['endDay'] : $today;

if( strtotime($startDay) < strtotime(ONLINEDATE) ) {
	$startDay = ONLINEDATE;
}

$days = array();
for($i = strtotime($startDay); $i<=  strtotime($endDay) ; $i+= 86400){
	$days[] = date("Y-m-d", $i);
}

foreach( $days as $d ){
	$joinData[$d] = getJoinData($d);
	$viewData[$d] = getZmwdData($d);
	if(empty($joinData[$d])){
		$joinData[$d] = array(
			'mdate' => $d,
			'act_count' => '<font color="blue">(-1)</font>',
			'join_count' => 0,
			'joinRate' => 0,
		);
	}
}
//print_r($viewData);
//data
$smarty->assign('joinData', $joinData );
$smarty->assign('viewData', $viewData );

$smarty->assign('thisWeek', $thisWeek );
$smarty->assign('lastWeek', $lastWeek );
//other
$smarty->assign('lang', $lang );
$smarty->assign('dictJobs', $dictJobs );
$smarty->assign('minDate', ONLINEDATE );
$smarty->assign('maxDate', $today );
$smarty->assign('startDay', $startDay );
$smarty->assign('endDay', $endDay );
$smarty->assign('today', $today );
$smarty->assign('selectDay', $selectDay );
$smarty->display( 'module/activity/zmwd_statistics.tpl' );

function getJoinData($date){
	$act_no = 14;

	$sql = "select * from ". C_ACTIVITY_JOIN . " where act_no={$act_no} AND mdate='{$date}' ";
	$result  = GFetchRowOne($sql);
	
	if(!empty($result)) {
		$result['joinRate'] = $result['act_count'] ? round($result['join_count']/$result['act_count'],4)*100 :0;
	}
	
	return $result;
}

/**
 * 诛魔卫道 统计数据
 * @param string1,string2 开始日期【,结束日期】 日期格式："YYYY-MM-DD"
 * @author Libiao
 */
function getZmwdData($startDay, $endDay=""){
	global $mapId, $copyId;
	
	$startTime = strtotime($startDay." 00:00:00 ");
	if("" == $endDay){
		$endTime = strtotime($startDay." 23:59:59 ");
	} else {
		$endTime = strtotime($endDay." 23:59:59 ");
	}

	$data = array();
	
	//副本结果
	$sql = "select * from " . T_LOG_MIDDLE_BOSS_RESULT . " where mtime>={$startTime} and mtime<={$endTime}  ";
	$sqlResult = GFetchRowOne($sql);
	
	//伤害排行
	$sqlRank = "select * from " . T_LOG_MIDDLE_BOSS_BOARD . " where mtime>={$startTime} and mtime<={$endTime} order by `rank` limit 5 ";
	$sqlRankResult = GFetchRowSet($sqlRank);

	if ($sqlResult || $sqlRankResult) {
		$data = array(
			'result' => $sqlResult ,
			'rank' => $sqlRankResult ,
		);
	}

	return $data;
	
}
