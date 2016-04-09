<?php
/**
 * yjxb_statistics.php
 * 遗迹寻宝 数据统计
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';
include_once SYSDIR_ADMIN_DICT.'/dict.php';
/*
$dictYjxbSkill = array(
	'5006' => '鞭炮',
	'5008' => '缩小术',
	'5009' => '跳跃',
	'5010' => '笨重术',
	'5011' => '痊愈',
);
*/
$dictMonsterType = array(
	'xunluo' => '巡逻' ,
	'dingdian' => '定点蹲守' ,
	'jiguan' => '机关类型' ,
	'boss' => 'BOSS' ,
);

$copyId = 300;
$mapId = 3003;
$limitLevel = 40;


//副本开启时间：每天14:00 - 14:30

$today = date('Y-m-d'); 
$todayTime = strtotime($today." 00:00:00 "); 
$todayEndTime = strtotime($today." 23:59:59 "); 

$startDay = $_REQUEST['startDay'] ? $_REQUEST['startDay'] : date("Y-m-d", ($todayTime - 7*86400) );
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
			'act_count' => '<font color="blue">(-1)</font>',
			'join_count' => 0,
			'joinRate' => 0,
			'room_count' => 0,
		);
	}
}

//if(isPost()){
	//历史数据
	$selectDay =  $_REQUEST['selectDay'] ? SS($_REQUEST['selectDay']) : $today;
	
	$weekDays = getWeekDays($selectDay);
		
	//本周各天数据
	foreach($weekDays as $k => $day){
		$viewData[$day] = getYjxbData($day);
	}
	
	//本周数据
	//开始、结束日期
	$weekStartDay = $weekDays[0];
	$weekEndDay = $weekDays[(count($weekDays)-1)];
	
	$thisWeek = $weekStartDay."~".$weekEndDay;
	
	$thisWeekData = getYjxbData($weekStartDay, $weekEndDay);
	
	
	$viewData['thisWeek'] = $thisWeekData;
	
	//上周数据
	$lastWeekDays = getWeekDays( date('Y-m-d', strtotime($selectDay)-7*86400) );
	//开始、结束日期
	$lastWeekStartDay = $lastWeekDays[0];
	$lastWeekEndDay = $lastWeekDays[(count($lastWeekDays)-1)];
	
	$lastWeek = $lastWeekStartDay."~".$lastWeekEndDay;
	
	$lastWeekData = getYjxbData($lastWeekStartDay, $lastWeekEndDay);
	
	
	$viewData['lastWeek'] = $lastWeekData;
	
//}

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
$smarty->display( 'module/activity/yjxb_statistics.tpl' );

function getJoinData($date){
//	$table = c_activity_join;
	$act_no = 2;

	$sql = "select * from ". C_ACTIVITY_JOIN . " where act_no={$act_no} AND mdate='{$date}' ";
	$result  = GFetchRowOne($sql);
	if(!empty($result)) {
		$result['joinRate'] = $result['act_count'] ? round($result['join_count']/$result['act_count'],4)*100 :0;
	}
	return $result;
}
/**
 * 遗迹寻宝副本统计数据
 * @param string1,string2 开始日期【,结束日期】 日期格式："YYYY-MM-DD"
 * @author Libiao
 */
function getYjxbData($startDay, $endDay=""){
	global $mapId, $copyId;
	
	$startTime = strtotime($startDay." 00:00:00 ");
	if("" == $endDay){
		$endTime = strtotime($startDay." 23:59:59 ");
	} else {
		$endTime = strtotime($endDay." 23:59:59 ");
	}
	
	
	//普通宝箱ID：3003801，3003803，3003805
	//高级宝箱ID：3003802，3003804，3003806
	//华丽宝箱ID：3003807
	$sqlCommonBox = "select count(*) as `count` from t_log_yjxb_collect where collect_id in (3003801, 3003803, 3003805) AND mtime>={$startTime} and mtime<={$endTime} ";
	$sqlAdvancedBox = "select count(*) as `count` from t_log_yjxb_collect where collect_id in (3003802, 3003804, 3003806) AND mtime>={$startTime} and mtime<={$endTime}  ";
	$sqlGorgeousBox = "select count(*) as `count` from t_log_yjxb_collect where collect_id=3003807  AND mtime>={$startTime} and mtime<={$endTime} ";
		
	$sqlCommonBoxResult = GFetchRowOne($sqlCommonBox);
	$sqlAdvancedBoxResult = GFetchRowOne($sqlAdvancedBox);
	$sqlGorgeousBoxResult = GFetchRowOne($sqlGorgeousBox);
	
	//参与人数
	$sqlJoinCount = "select count(distinct uuid) as `count` from t_log_copy where mtime >=$startTime and mtime< $endTime and copy_id='{$copyId}' and action=1 ";
	$sqlJoinCountResult = GFetchRowOne($sqlJoinCount);
	
	//死亡转移寻宝金币数量
	$sqlDieDivertJb = "select sum(jb) as `jb` from t_log_yjxb_jb where mtime >=$startTime and mtime< $endTime AND jb>0 AND is_from_human=1 ";
	$sqlDieDivertJbResult = GFetchRowOne($sqlDieDivertJb);

	
	//怪物击杀
	$sqlMonsterKill = "select killer_uuid, count(id) as `die_cnt` from t_log_die where mtime>={$startTime} and mtime<={$endTime} AND map_id={$mapId} AND killer_type=3 group by killer_uuid";
	$sqlMonsterKillResult = GFetchRowSet($sqlMonsterKill);

	//死亡总次数
	$allKillCount = 0;
	if(!empty($sqlMonsterKillResult)) {
		foreach($sqlMonsterKillResult as $key => $value) {
			$allKillCount += $value['die_cnt'];
		}
	}
	//平均死亡次数
	$avgDie = ($sqlJoinCountResult['count']!=0) ? round($allKillCount/$sqlJoinCountResult['count'],1):0;
	
	//怪物击杀比率
	//巡逻 怪物ID：3003003，3003004，3003005，3003006，3003007，3003008，3003009，3003010，3003011，3003014，3003015
	//定点蹲守 怪物ID：3003012，3003013
	//机关类型 怪物ID：3003002
	//BOSS怪物ID：3003001
	$monsterKill = array(
		'xunluo' => array('count' => 0, 'percent' => 0, ) ,
		'dingdian' => array('count' => 0, 'percent' => 0, )  ,
		'jiguan' => array('count' => 0, 'percent' => 0, )  ,
		'boss' => array('count' => 0, 'percent' => 0, )  ,
	);
	foreach($sqlMonsterKillResult as $key => $value) {
		//分类统计
		switch($value['killer_uuid']) {
			case 3003001 :
				$monsterKill['boss']['count'] += $value['die_cnt'];
				break;
			case 3003002 :
				$monsterKill['jiguan']['count'] += $value['die_cnt'];
				break;
			case 3003012 :
			case 3003013 :
				$monsterKill['dingdian']['count'] += $value['die_cnt'];
				break;
			default:
				$monsterKill['xunluo']['count'] += $value['die_cnt'];
				break;
		}
	}

	if( !empty($allKillCount) ) {
		foreach( $monsterKill as $key => $value ) {
			$monsterKill[$key]['percent'] = round( ($value['count']/$allKillCount)*100 );
		}
	}
	
	
	//技能使用情况
	$sqlSkillUse = "select skill_id, count(*) as `count` from t_log_yjxb_skill where mtime>={$startTime} and mtime<={$endTime} group by skill_id ";
	
	$sqlSkillUseResult = GFetchRowSet($sqlSkillUse);
	
	$skillUse = array( 
		'5006' => array('skill_id' => 5006, 'count'=>0, 'percent' => 0,), 
		'5008' => array('skill_id' => 5008, 'count'=>0, 'percent' => 0,), 
		'5009' => array('skill_id' => 5009, 'count'=>0, 'percent' => 0,), 
		'5010' => array('skill_id' => 5010, 'count'=>0, 'percent' => 0,), 
		'5011' => array('skill_id' => 5011, 'count'=>0, 'percent' => 0,), 
		);
	if(!empty($sqlSkillUseResult)){
		$allUse = 0;
		foreach($sqlSkillUseResult as $key => $value) {
			$allUse += $value['count'];
			$skillID = $value['skill_id'];
			$skillUse[$skillID]['count'] = $value['count'];
		}
		if( $allUse != 0 ) {
			foreach($skillUse as $key => &$value) {
				$value['percent'] = round( ($value['count']/$allUse)*100, 2 );
			}
		}
	}
	
	if( ($endTime - $startTime) > 86400 ) {
		$tmpRank = sortArrayByKey($monsterKill, 'count', 'desc');
		$i = 1;
		global $dictMonsterType;
		foreach($tmpRank as $key => $value) {
			$monsterKillRank[$i]['rank'] = $i;
			$monsterKillRank[$i]['name'] = $dictMonsterType[$key];
			$monsterKillRank[$i]['count'] = $value['count'];
			$monsterKillRank[$i]['percent'] = $value['percent'];
			
			$i++;
		}
	}
	
	$data = array(
		'joinCount' => $sqlJoinCountResult['count'], 
		'dieDivertJb' => $sqlDieDivertJbResult['jb'] ? $sqlDieDivertJbResult['jb'] : 0 , 
		'commonBox' => $sqlCommonBoxResult['count'] ,
		'advancedBox' => $sqlAdvancedBoxResult['count'] ,
		'gorgeousBox' => $sqlGorgeousBoxResult['count'] ,
		'avgDie' => $avgDie ,
		'skillUse' => $skillUse ,
		'monsterKill' => $monsterKill ,
		'monsterKillRank' => $monsterKillRank ,
	);
	
	return $data;
	
}
