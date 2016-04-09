<?php
/**
 * xxwd_statistics.php
 * 仙邪问鼎 数据统计
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';
include_once SYSDIR_ADMIN_DICT.'/dict.php';

$copyId = 301;
$mapId = 3001;
$limitLevel = 40;

//副本开启时间：每天20:00 - 20:15、20:25 - 20:40

$today = date('Y-m-d'); 
$todayTime = strtotime($today." 00:00:00 "); 
$todayEndTime = strtotime($today." 23:59:59 "); 


$startDay = $_REQUEST['startDay'] ? $_REQUEST['startDay'] : date("Y-m-d", ($todayTime - 6*86400) );
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
	if(empty($joinData[$d])){
		$joinData[$d] = array(
			'mdate' => $d,
			'act_count1' => '<font color="blue">(-2)</font>',
			'join_count1' => 0,
			'joinRate1' => 0,
			'room_count1' => 0,
			'act_count2' => 0,
			'join_count2' => 0,
			'joinRate2' => 0,
			'room_count2' => 0,
			'both_join_count' => 0,
		);
	}
}

//if(isPost()){
	//历史数据
	$selectDay =  $_REQUEST['selectDay'] ? SS($_REQUEST['selectDay']) : $today;
	
	$weekDays = getWeekDays($selectDay);
		
	//本周各天数据
	foreach($weekDays as $k => $day){
		$viewData[$day] = getXxwdData($day);
	}
	
	//本周数据
	//开始、结束日期
	$weekStartDay = $weekDays[0];
	$weekEndDay = $weekDays[(count($weekDays)-1)];
	
	$thisWeek = $weekStartDay."~".$weekEndDay;
	
	$thisWeekData = getXxwdData($weekStartDay, $weekEndDay);
	
	
	$viewData['thisWeek'] = $thisWeekData;
	
	//上周数据
	$lastWeekDays = getWeekDays( date('Y-m-d', strtotime($selectDay)-7*86400) );
	//开始、结束日期
	$lastWeekStartDay = $lastWeekDays[0];
	$lastWeekEndDay = $lastWeekDays[(count($lastWeekDays)-1)];
	
	$lastWeek = $lastWeekStartDay."~".$lastWeekEndDay;
	
	$lastWeekData = getXxwdData($lastWeekStartDay, $lastWeekEndDay);
	
	
	$viewData['lastWeek'] = $lastWeekData;
		
//}

//dict
$smarty->assign('dictJobs', $dictOccupationType );
$smarty->assign('dictCamp', $dictCamp );
//data
$smarty->assign('joinData', $joinData );
$smarty->assign('viewData', $viewData );

$smarty->assign('thisWeek', $thisWeek );
$smarty->assign('lastWeek', $lastWeek );
//other
$smarty->assign('lang', $lang );
$smarty->assign('minDate', ONLINEDATE );
$smarty->assign('maxDate', $today );
$smarty->assign('startDay', $startDay );
$smarty->assign('endDay', $endDay );
$smarty->assign('selectDay', $selectDay );
$smarty->display( 'module/activity/xxwd_statistics.tpl' );

function getJoinData($date){
//	$table = c_activity_join;
	$act_no1 = 3;
	$act_no2 = 7;
	$act_no3 = 101;
	
	$data = array();
	
	$sql1 = "select * from ". C_ACTIVITY_JOIN . " where act_no={$act_no1} AND mdate='{$date}' ";
	$result1  = GFetchRowOne($sql1);
	$sql2 = "select * from ". C_ACTIVITY_JOIN . " where act_no={$act_no2} AND mdate='{$date}' ";
	$result2  = GFetchRowOne($sql2);
	$sql3 = "select join_count from ". C_ACTIVITY_JOIN . " where act_no={$act_no3} AND mdate='{$date}' ";
	$result3  = GFetchRowOne($sql3);
	
	if(!empty($result1)) {
		$data['mdate'] = $result1['mdate'];
		$data['act_count1'] = $result1['act_count'];
		$data['join_count1'] = $result1['join_count'];
		$data['joinRate1'] = $result1['act_count']? round($result1['join_count']/$result1['act_count'],4)*100 :0;
		$data['room_count1'] = $result1['room_count'];
	} else {
		$data['mdate'] = $date;
		$data['act_count1'] = '<font color="blue">(-1)</font>';
		$data['join_count1'] = 0;
		$data['joinRate1'] = 0;
		$data['room_count1'] = 0;
	}
	if(!empty($result2)) {
		$data['mdate'] = $result2['mdate'];
		$data['act_count2'] = $result2['act_count'];
		$data['join_count2'] = $result2['join_count'];
		$data['joinRate2'] = $result2['act_count']? round($result2['join_count']/$result2['act_count'],4)*100 :0;
		$data['room_count2'] = $result2['room_count'];
	} else {
		$data['mdate'] = $date;
		$data['act_count2'] = '<font color="blue">(-1)</font>';
		$data['join_count2'] = 0;
		$data['joinRate2'] = 0;
		$data['room_count2'] = 0;
	}
	
	if(!empty($result1) && !empty($result2)  ) {
		if(!empty($result1)){
			$data['both_join_count'] = $result3['join_count'];
		} 
	} else {
		$data['both_join_count'] = 0;
	}
	
	return $data;
}
/**
 * 仙邪问鼎副本统计数据
 * @param string1,string2 开始日期【,结束日期】 日期格式："YYYY-MM-DD"
 * @author Libiao
 */
function getXxwdData($startDay, $endDay=""){
	
	$startTime = strtotime($startDay." 00:00:00 ");
	if("" == $endDay){
		$endTime = strtotime($startDay." 23:59:59 ");
	} else {
		$endTime = strtotime($endDay." 23:59:59 ");
	}
		
	//最高击杀次数
	$sqlMaxKill = "select max(kill_cnt) as `max_kill_cnt` from t_log_xxwd_board where mtime>={$startTime} and mtime<={$endTime}";
	
	$sqlMaxKillResult = GFetchRowOne($sqlMaxKill);
	
	//平均击杀次数
	$sqlAvgKill = "select avg(kill_cnt) as `avg_kill_cnt` from t_log_xxwd_board where mtime>={$startTime} and mtime<={$endTime}";
	
	$sqlAvgKillResult = GFetchRowOne($sqlAvgKill);
	
	//最高死亡次数
	$sqlMaxDie = "select max(die_cnt) as `max_die_cnt` from t_log_xxwd_board where mtime>={$startTime} and mtime<={$endTime}";
	
	$sqlMaxDieResult = GFetchRowOne($sqlMaxDie);
	
	//平均死亡次数
	$sqlAvgDie = "select avg(die_cnt) as `avg_die_cnt` from t_log_xxwd_board where mtime>={$startTime} and mtime<={$endTime}";
	
	$sqlAvgDieResult = GFetchRowOne($sqlAvgDie);
	
	//平均持鼎持旗时间
	$sqlAvgKeepDingTime = "select `type`, avg(time) as `avg_keep_time` from t_log_xxwd_collect where mtime>={$startTime} and mtime<={$endTime} group by type";
	$tmpResult = GFetchRowSet($sqlAvgKeepDingTime);
	
	if(!empty($tmpResult)) {
		foreach($tmpResult as $k => $v){
			$v['avg_keep_time'] = round($v['avg_keep_time']);
			$sqlAvgKeepDingTimeResult[$v['type']] = $v ;
		}
	}
	
	
	//最长持鼎时间的玩家数据
	$sqlMaxKeepDingTime = "select max(time) as `time` from t_log_xxwd_collect where type=1 and mtime>={$startTime} and mtime<={$endTime}";
	$sqlMaxKeepDingUser = "select t1.uuid, t1.account_name, t1.role_name, t1.time from t_log_xxwd_collect t1, ({$sqlMaxKeepDingTime}) t2 where t1.time = t2.time";
	
	$sqlMaxKeepDingUserResult = GFetchRowOne($sqlMaxKeepDingUser);
	
	//最高击杀次数  和 最高死亡次数房间排名
	if(!empty($sqlMaxKillResult['max_kill_cnt'])) {
//		$sqlMaxKillRank = "select * from t_log_xxwd_board where room_id in (select room_id from t_log_xxwd_board WHERE mtime>={$startTime} AND mtime<={$endTime} AND kill_cnt={$sqlMaxKillResult['max_kill_cnt']} group by room_id) group by room_id,rank order by rank";
		$sqlMaxKillRank = "select * from t_log_xxwd_board t1, (select mtime,room_id from t_log_xxwd_board WHERE mtime>={$startTime} AND mtime<={$endTime} AND kill_cnt={$sqlMaxKillResult['max_kill_cnt']} group by room_id) t2 where t1.room_id=t2.room_id and t1.mtime=t2.mtime group by t1.room_id,t1.rank order by t1.rank";
		$sqlMaxKillRankResult = GFetchRowSet($sqlMaxKillRank);
	}
	if(!empty($sqlMaxDieResult['max_die_cnt'])) {
//		$sqlMaxDieRank = "select * from t_log_xxwd_board where room_id in (select room_id from t_log_xxwd_board WHERE mtime>={$startTime} AND mtime<={$endTime} AND die_cnt={$sqlMaxDieResult['max_die_cnt']} group by room_id) group by room_id,rank order by rank";
		$sqlMaxDieRank = "select * from t_log_xxwd_board t1, (select mtime,room_id from t_log_xxwd_board WHERE mtime>={$startTime} AND mtime<={$endTime} AND die_cnt={$sqlMaxDieResult['max_die_cnt']} group by room_id) t2 where t1.room_id=t2.room_id and t1.mtime=t2.mtime group by t1.room_id,t1.rank order by t1.rank";
		$sqlMaxDieRankResult = GFetchRowSet($sqlMaxDieRank);
	}
	
	
	//胜负得分
	$sqlScore = "select room_id, score1, score2, mdate from t_log_xxwd_score where mtime >=$startTime and mtime< $endTime order by mtime, room_id ";
	$sqlScoreResult = GFetchRowSet($sqlScore);

	
	$data = array(
		'maxKill' => $sqlMaxKillResult['max_kill_cnt']?$sqlMaxKillResult['max_kill_cnt']:0,
		'avgKill' => $sqlAvgKillResult['avg_kill_cnt']?$sqlAvgKillResult['avg_kill_cnt']:0,
		'maxDie' => $sqlMaxDieResult['max_die_cnt']?$sqlMaxDieResult['max_die_cnt']:0,
		'avgDie' => $sqlAvgDieResult['avg_die_cnt']?$sqlAvgDieResult['avg_die_cnt']:0,
		'avgKeepTime' => $sqlAvgKeepDingTimeResult,
		'maxKeepDingTime' => $sqlMaxKeepDingUserResult['time']?$sqlMaxKeepDingUserResult['time']:0,
		'maxKeepDingUser' => $sqlMaxKeepDingUserResult['role_name']?$sqlMaxKeepDingUserResult['role_name']:"-",
		'maxKillRoomRank' => $sqlMaxKillRankResult,
		'maxDieRoomRank' => $sqlMaxDieRankResult,
		'score' => $sqlScoreResult,
	);
	
	return $data;
	
}
