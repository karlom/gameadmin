<?php
/**
 * jhdt_statistics.php
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';
include_once SYSDIR_ADMIN_DICT.'/dict.php';


//$copyId = 304;
$mapId = array(
	'1' => 1017,
	'2' => 1015,
	'3' => 1016,
);
$limitLevel = 40;


//副本开启时间：每天21:00 - 21:30

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
	
	$selectDayTimestamp = strtotime($selectDay);

	//前后三天
	$days = array();
	for($i = -3; $i<4;$i++) {
		$tmpT = intval($selectDayTimestamp) + $i*86400;
		$days[] = date('Y-m-d',$tmpT);
	}
		
	//前后三天的数据
	foreach($days as $day){
		$viewData[$day] = getMwbdData($day);
	}
	
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
$smarty->display( 'module/activity/mwbd_statistics.tpl' );

function getJoinData($date){
//	$table = c_activity_join;
	$act_no = 5;

	$sql = "select * from ". C_ACTIVITY_JOIN . " where act_no={$act_no} AND mdate='{$date}' ";
	$result  = GFetchRowOne($sql);
	if(!empty($result)) {
		$result['joinRate'] = $result['act_count'] ? round($result['join_count']/$result['act_count'],4)*100 :0;
	}
	return $result;
}

/**
 * 魔物暴动副本统计数据
 * @param string1,string2 开始日期【,结束日期】 日期格式："YYYY-MM-DD"
 * @author Libiao
 */
function getMwbdData($startDay, $endDay=""){
	global $mapId;
	
	$startTime = strtotime($startDay." 00:00:00 ");
	if("" == $endDay){
		$endTime = strtotime($startDay." 23:59:59 ");
	} else {
		$endTime = strtotime($endDay." 23:59:59 ");
	}
	
	//地图人数分布
	$sqlMapMaxCount = "select mapID, max(cnt) as `max_cnt` from t_log_mwbd_role_cnt where mtime >=$startTime and mtime< $endTime group by mapID ";
	$sqlMapMaxCountResult = GFetchRowSet($sqlMapMaxCount);
	
	$sqlMapAvgCount = "select mapID, avg(cnt) as `avg_cnt` from t_log_mwbd_role_cnt where mtime >=$startTime and mtime< $endTime group by mapID ";
	$sqlMapAvgCountResult = GFetchRowSet($sqlMapAvgCount);
	
	$maxCount = array('1'=>0,'2'=>0,'3'=>0,);
	$avgCount = array('1'=>0,'2'=>0,'3'=>0,);
	
	if(!empty($sqlMapMaxCountResult)) {
		foreach($sqlMapMaxCountResult as $k => $v) {
			foreach($mapId as $j => $w) {
				if($v['mapID'] == $w) {
					$maxCount[$j] = $v['max_cnt'];
				}
			}
		}
	}
	if(!empty($sqlMapAvgCountResult)) {
		foreach($sqlMapAvgCountResult as $k => $v) {
			foreach($mapId as $j => $w) {
				if($v['mapID'] == $w) {
					$avgCount[$j] = round($v['avg_cnt'],1);
				}
			}
		}
	}
	
	
	//8类怪物死亡情况
//	$sqlMonsterDie1 = "select count(id) as `count` from t_log_mwbd_role_cnt where mtime >=$startTime and mtime< $endTime and monsterID = 400000 ";
//	$sqlMonsterDie2 = "select count(id) as `count` from t_log_mwbd_role_cnt where mtime >=$startTime and mtime< $endTime and monsterID in (400011,400021,400031,400041,400051,400061,400071,400081,400091,400101,400111,400121) ";
//	$sqlMonsterDie3 = "select count(id) as `count` from t_log_mwbd_role_cnt where mtime >=$startTime and mtime< $endTime and monsterID in (400012,400022,400032,400042,400052,400062,400072,400082,400092,400102,400112,400122) ";
//	$sqlMonsterDie4 = "select count(id) as `count` from t_log_mwbd_role_cnt where mtime >=$startTime and mtime< $endTime and monsterID in (400013,400023,400033,400043,400053,400063,400073,400083,400093,400103,400113,400123)  ";
//	$sqlMonsterDie5 = "select count(id) as `count` from t_log_mwbd_role_cnt where mtime >=$startTime and mtime< $endTime and monsterID = 401000 ";
//	$sqlMonsterDie6 = "select count(id) as `count` from t_log_mwbd_role_cnt where mtime >=$startTime and mtime< $endTime and monsterID in (401011,401021,401031,401041,401051,401061,401071,401081,401091,401101,401111,401121)  ";
//	$sqlMonsterDie7 = "select count(id) as `count` from t_log_mwbd_role_cnt where mtime >=$startTime and mtime< $endTime and monsterID in (401012,401022,401032,401042,401052,401062,401072,401082,401092,401102,401112,401122)  ";
//	$sqlMonsterDie8 = "select count(id) as `count` from t_log_mwbd_role_cnt where mtime >=$startTime and mtime< $endTime and monsterID in (401013,401023,401033,401043,401053,401063,401073,401083,401093,401103,401113,401123)  ";
	$sqlMonsterDie = "select monsterID, count(id) as `count` from t_log_mwbd_monster_die where mtime >=$startTime and mtime< $endTime group by  monsterID ";
	$sqlMonsterDieResult = GFetchRowSet($sqlMonsterDie);
	
	$monsterType = array(
		1 => array(400000),
		2 => array(400011,400021,400031,400041,400051,400061,400071,400081,400091,400101,400111,400121),
		3 => array(400012,400022,400032,400042,400052,400062,400072,400082,400092,400102,400112,400122),
		4 => array(400013,400023,400033,400043,400053,400063,400073,400083,400093,400103,400113,400123),
		5 => array(401000),
		6 => array(401011,401021,401031,401041,401051,401061,401071,401081,401091,401101,401111,401121),
		7 => array(401012,401022,401032,401042,401052,401062,401072,401082,401092,401102,401112,401122),
		8 => array(401013,401023,401033,401043,401053,401063,401073,401083,401093,401103,401113,401123),
	);
	
	$monsterDie = array( 1 => 0, 2 => 0, 3 => 0,  4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, );
	if(!empty($sqlMonsterDieResult)) {
		
		foreach( $monsterType as $k => $v ){
			foreach( $sqlMonsterDieResult as $w ){
				if( in_array($w['monsterID'], $v) ){
					$monsterDie[$k] += $w['count'];
				}
			}
		}
		
	}
	
	//BOSS死亡时间
	$sqlBossDieTime = "select monsterID, mdate, mtime from t_log_mwbd_monster_die where mtime >=$startTime and mtime< $endTime and monsterID = 401001 ";
	$sqlBossDieTimeResult = GFetchRowOne($sqlBossDieTime);
	
	//排名数据
	$sqlRank = "select `rank`, `score`, `familyUuid`, `familyName` from t_log_mwbd_family_rank where mtime >=$startTime and mtime< $endTime order by `rank` ";
	$sqlRankResult = GFetchRowSet($sqlRank);
	
	$data = array(
		'maxCount' => $maxCount,
		'avgCount' => $avgCount,
		'monsterDie' => $monsterDie,
		'bossDieTime' => $sqlBossDieTimeResult['mdate'], 
		'familyRank' => $sqlRankResult,
	);
	
	return $data;
	
}
