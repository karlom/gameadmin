<?php
/**
 * jhdt_statistics.php
 * 晶幻洞天 数据统计
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';
include_once SYSDIR_ADMIN_DICT.'/dict.php';


$copyId = 304;
$mapId = 4003;
$limitLevel = 40;


//副本开启时间：每天13:00 - 13:30、19:00 - 19:30

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
//			'room_count1' => 0,
			'act_count2' => 0,
			'join_count2' => 0,
			'joinRate2' => 0,
//			'room_count2' => 0,
		);
	}
}

//if(isPost()){
	//历史数据
	$selectDay =  $_REQUEST['selectDay'] ? SS($_REQUEST['selectDay']) : $today;
	
	$weekDays = getWeekDays($selectDay);
		
	//本周各天数据
	foreach($weekDays as $k => $day){
		$viewData[$day] = getJhdtData($day);
	}
	
	//本周数据
	//开始、结束日期
	$weekStartDay = $weekDays[0];
	$weekEndDay = $weekDays[(count($weekDays)-1)];
	
	$thisWeek = $weekStartDay."~".$weekEndDay;
	
	$thisWeekData = getJhdtData($weekStartDay, $weekEndDay);
	
	
	$viewData['thisWeek'] = $thisWeekData;
	
	//上周数据
	$lastWeekDays = getWeekDays( date('Y-m-d', strtotime($selectDay)-7*86400) );
	//开始、结束日期
	$lastWeekStartDay = $lastWeekDays[0];
	$lastWeekEndDay = $lastWeekDays[(count($lastWeekDays)-1)];
	
	$lastWeek = $lastWeekStartDay."~".$lastWeekEndDay;
	
	$lastWeekData = getJhdtData($lastWeekStartDay, $lastWeekEndDay);
	
	
	$viewData['lastWeek'] = $lastWeekData;
		
//}

//data
//$smarty->assign('todayData', $todayData );
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
$smarty->display( 'module/activity/jhdt_statistics.tpl' );

function getJoinData($date){
//	$table = c_activity_join;
	$act_no1 = 1;
	$act_no2 = 6;
	$act_no3 = 8;
	
	$data = array();
	
	$sql1 = "select * from ". C_ACTIVITY_JOIN . " where act_no={$act_no1} AND mdate='{$date}' ";
	$result1  = GFetchRowOne($sql1);
	$sql2 = "select * from ". C_ACTIVITY_JOIN . " where act_no={$act_no2} AND mdate='{$date}' ";
	$result2  = GFetchRowOne($sql2);
	$sql3 = "select * from ". C_ACTIVITY_JOIN . " where act_no={$act_no3} AND mdate='{$date}' ";
	$result3  = GFetchRowOne($sql3);
	
	if(!empty($result1)) {
		$data['mdate'] = $result1['mdate'];
		$data['act_count1'] = $result1['act_count'];
		$data['join_count1'] = $result1['join_count'];
		$data['joinRate1'] = $result1['act_count']? round($result1['join_count']/$result1['act_count'],4)*100 :0;
//		$data['room_count1'] = $result1['room_count'];
	} else {
		$data['mdate'] = $date;
		$data['act_count1'] = '<font color="blue">(-1)</font>';
		$data['join_count1'] = 0;
		$data['joinRate1'] = 0;
	}
	if(!empty($result2)) {
		$data['mdate'] = $result2['mdate'];
		$data['act_count2'] = $result2['act_count'];
		$data['join_count2'] = $result2['join_count'];
		$data['joinRate2'] = $result2['act_count']? round($result2['join_count']/$result2['act_count'],4)*100 :0;
//		$data['room_count2'] = $result2['room_count'];
	} else {
		$data['mdate'] = $date;
		$data['act_count2'] = '<font color="blue">(-1)</font>';
		$data['join_count2'] = 0;
		$data['joinRate2'] = 0;
	}
	if(!empty($result3)) {
		$data['mdate'] = $result3['mdate'];
		$data['act_count3'] = $result3['act_count'];
		$data['join_count3'] = $result3['join_count'];
		$data['joinRate3'] = $result3['act_count']? round($result3['join_count']/$result3['act_count'],4)*100 :0;
	} else {
		$data['mdate'] = $date;
		$data['act_count3'] = '<font color="blue">(-1)</font>';
		$data['join_count3'] = 0;
		$data['joinRate3'] = 0;
	}
	return $data;
}

/**
 * 晶幻洞天副本统计数据
 * @param string1,string2 开始日期【,结束日期】 日期格式："YYYY-MM-DD"
 * @author Libiao
 */
function getJhdtData($startDay, $endDay=""){
	global $copyId,$mapId;
	
	$startTime = strtotime($startDay." 00:00:00 ");
	if("" == $endDay){
		$endTime = strtotime($startDay." 23:59:59 ");
	} else {
		$endTime = strtotime($endDay." 23:59:59 ");
	}
	
	//参与人数
	$sqlJoinCount = "select count(distinct uuid) as `count` from t_log_copy where mtime >=$startTime and mtime< $endTime and copy_id='{$copyId}' and action=1 ";
	$sqlJoinCountResult = GFetchRowOne($sqlJoinCount);
	
	//参与队伍数
	$sqlJoinTeamCount = "select count(id) as `count` from t_log_jhdt_info where mtime >=$startTime and mtime< $endTime ";
	$sqlJoinTeamCountResult = GFetchRowOne($sqlJoinTeamCount);
	
	//通关队伍数
	$sqlClearedTeamCount = "select count(id) as `count` from t_log_jhdt_info where mtime >=$startTime and mtime< $endTime AND result=1 "; 
	$sqlClearedTeamCountResult = GFetchRowOne($sqlClearedTeamCount);
	
	//队伍人数 10
	$sqlTeamMemberCount = "select name1,name2,name3,name4,name5, result from t_log_jhdt_info where mtime >=$startTime and mtime< $endTime ";
	$sqlTeamMemberCountResult = GFetchRowSet($sqlTeamMemberCount);
	
	//队伍人数，成功通关队伍数
	$memberCount = array( '1' => array('count'=>0,'succeed'=> 0 ,), '2' => array('count'=>0,'succeed'=>0,), '3' => array('count'=>0,'succeed'=>0,), '4' => array('count'=>0,'succeed'=>0,), '5' => array('count'=>0,'succeed'=>0,),);
	if(!empty($sqlTeamMemberCountResult)) {
		foreach($sqlTeamMemberCountResult as $key => $value){
			$cnt = 0;
			for($i=1;$i<=5;$i++){
				$var = "name".$i;
				if( strlen($value[$$var])>0 ){
					$cnt ++;
				}
			}
			$memberCount[$cnt]['count'] ++;
			if($value['result'] == 1) {
				$memberCount[$cnt]['succeed'] ++;
			}
			/*
			if(!empty($value) && is_string($value['teamMemberInfo'])) {
				$members = explode('|',$value['teamMemberInfo']);
				array_pop($members);
				$memberCount[count($members)]['count'] ++;
				if($value['result'] == 1) {
					$memberCount[count($members)]['succeed'] ++;
				}
			}
			*/
		}
	}

	//通关成功率
	$clearedRate = array();
	foreach ( $memberCount as $key => $value ) {
		$clearedRate[$key]['rate'] =  ($value['count']==0)? 0 : round($value['succeed']/$value['count']*100, 2);
	}
	//总通关成功率
	$clearedRate['all']['rate'] = $sqlJoinTeamCountResult['count'] ? round($sqlClearedTeamCountResult['count']/$sqlJoinTeamCountResult['count']*100, 2) : 0 ;
	
	//平均队伍人数 11
	$avgTeamMember = 0;
	//最常用队伍人数 12
	$commonTeamMember = 0;
	if(!empty($memberCount)){
		$team = 0;
		$member = 0;
		foreach ( $memberCount as $key => $value ) {
			$team += $value['count'];
			$member += $key*$value['count'];
			if($value['count'] > $commonTeamMember) {
				$commonTeamMember = $key;
			}
		}
		$avgTeamMember = ($team!=0) ? $member/$team : 0;
	}
	
	//救助次数
	$sqlHelpCount =  "select count(id) as `count` from t_log_collect_revive where mtime >=$startTime and mtime< $endTime AND map_id={$mapId} ";
	$sqlHelpCountResult = GFetchRowOne($sqlHelpCount);
	
	//平均通关时间  21
	$sqlClearedAvgTime = "select avg(copy_time) as avg_time from t_log_jhdt_info where mtime >=$startTime and mtime< $endTime AND result=1 ";
	$sqlClearedAvgTimeResult = GFetchRowOne($sqlClearedAvgTime);
	
	
	//最短通关时间  22
	$sqlMinClearedTime = "select min(copy_time) as `min_time` from t_log_jhdt_info where mtime >=$startTime and mtime< $endTime AND  result=1";
	$sqlMinClearedTimeResult = GFetchRowOne($sqlMinClearedTime);
	
	//最快通关队伍信息
	$sqlMinClearedTimeTeamInfo = "select copy_time, name1,name2,name3,name4,name5  from t_log_jhdt_info where copy_time=({$sqlMinClearedTime}) ";
	$sqlMinClearedTimeTeamInfoResult = GFetchRowSet($sqlMinClearedTimeTeamInfo);
	
	//最快通关队伍信息 23
	$minClearedTimeTeamMember = array();
	if(!empty($sqlMinClearedTimeTeamInfoResult)) {
//		$minClearedTimeTeamMember = explode('|',$sqlMinClearedTimeTeamInfoResult['teamMemberInfo']);
//		array_pop($minClearedTimeTeamMember);
		foreach($sqlMinClearedTimeTeamInfoResult as $key => $value) {
			$team = array(
				$value['name1'],
				$value['name2'],
				$value['name3'],
				$value['name4'],
				$value['name5'],
			);
//			$team = explode('|',$value['teamMemberInfo']);
//			array_pop($team);
			$minClearedTimeTeamMember[] = $team;
		}
	}

	
	$data = array(
		'joinCount' => $sqlJoinCountResult['count'],
		'joinTeamCount' => $sqlJoinTeamCountResult['count'],
		'avgHelpCount' => round($sqlHelpCountResult['count']/2), //平均数，每天两次副本
		'avgMember' => $avgTeamMember,
		'comMember' => $commonTeamMember,
		'avgClearedTime' =>$sqlClearedAvgTimeResult['avg_time'] ? round($sqlClearedAvgTimeResult['avg_time']/1000,1) : 0,
		'minClearedTime' => $sqlMinClearedTimeResult['min_time'] ? round($sqlMinClearedTimeResult['min_time']/1000,1) : 0,
		'minClearedTeam' => $minClearedTimeTeamMember,
		'clearedRate' => $clearedRate,
	);
	
	return $data;
	
}
