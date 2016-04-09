<?php
/**
 * bmsl_statistics.php
 * 不灭试炼 数据统计
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';
include_once SYSDIR_ADMIN_DICT.'/dict.php';

$copyId = 302;
$mapId = 3004;
$limitLevel = 45;


//副本开启时间：每天15:00 - 15:30
$today = date('Y-m-d'); 
$todayTime = strtotime($today." 00:00:00 "); 
$todayEndTime = strtotime($today." 23:59:59 "); 
/*
//$startTime = 54000 + $todayTime;
//$endTime = 55800 + $todayTime;
$startTime = $todayTime;
$endTime = $todayEndTime;

//参与人数
$sqlJoinCount = "select count(distinct uuid) as `count` from t_log_copy where mtime >=$startTime and mtime< $endTime and copy_id='{$copyId}' and action=1 ";
$sqlJoinCountResult = GFetchRowOne($sqlJoinCount);

//活跃用户数
$sqlActiveUserCount = "select count(uuid) as `count` from c_role_label where active=1 ";
$sqlActiveUserCountResult = GFetchRowOne($sqlActiveUserCount);

//活跃用户
$sqlActiveUser = "select uuid from c_role_label where active=1 ";

//level
$sqlLevel = "select uuid, max(level) as level from t_log_level_up group by uuid ";
//$sqlLevel = "select t1.uuid,t1.account_name,t1.role_name,t1.level from t_log_level_up t1,(select uuid, max(id) id, max(mtime) mtime from t_log_level_up group by uuid) t2 WHERE t1.uuid=t2.uuid AND t1.id=t2.id AND t1.mtime=t2.mtime";
//满足参加活动条件的活跃用户数
$sqlMeetCount = "select count(*) as `count` from ({$sqlActiveUser}) t1, ({$sqlLevel}) t2 where t1.uuid=t2.uuid and t2.level>{$limitLevel} ";

$sqlMeetCountResult = GFetchRowOne($sqlMeetCount);

//房间数
$sqlRoomCount = "select count(distinct scene_id) as `count` from t_log_bmsl_live where mtime >=$startTime and mtime< $endTime ";
$sqlRoomCountResult = GFetchRowOne($sqlRoomCount);


$todayData = array(
	'data' => array( 
		'actUser' => $sqlActiveUserCountResult['count'],
		'joinCount' => $sqlJoinCountResult['count'], 
		'participation' => $sqlMeetCountResult['count']?round($sqlJoinCountResult['count']/$sqlMeetCountResult['count'], 4)*100:0,
		'roomCount' => $sqlRoomCountResult['count'],
		),
);
*/

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
		$viewData[$day] = getBmslData($day);
	}
	
	//本周数据
	//开始、结束日期
	$weekStartDay = $weekDays[0];
	$weekEndDay = $weekDays[(count($weekDays)-1)];
	
	$thisWeek = $weekStartDay."~".$weekEndDay;
	
	$thisWeekData = getBmslData($weekStartDay, $weekEndDay);
	
	
	$viewData['thisWeek'] = $thisWeekData;
	
	//上周数据
	$lastWeekDays = getWeekDays( date('Y-m-d', strtotime($selectDay)-6*86400) );
	//开始、结束日期
	$lastWeekStartDay = $lastWeekDays[0];
	$lastWeekEndDay = $lastWeekDays[(count($lastWeekDays)-1)];
	
	$lastWeek = $lastWeekStartDay."~".$lastWeekEndDay;
	
	$lastWeekData = getBmslData($lastWeekStartDay, $lastWeekEndDay);
	
	
	$viewData['lastWeek'] = $lastWeekData;
	
//}

//dict
$smarty->assign('dictJobs', $dictOccupationType );
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
$smarty->display( 'module/activity/bmsl_statistics.tpl' );

function getJoinData($date){
//	$table = c_activity_join;
	$act_no = 4;

	$sql = "select * from ". C_ACTIVITY_JOIN . " where act_no={$act_no} AND mdate='{$date}' ";
	$result  = GFetchRowOne($sql);
	if(!empty($result)) {
		$result['joinRate'] = $result['act_count'] ? round($result['join_count']/$result['act_count'],4)*100 :0;
	}
	return $result;
}

/**
 * 不灭试炼副本统计数据
 * @param string1,string2 开始日期【,结束日期】 日期格式："YYYY-MM-DD"
 * @author Libiao
 */
function getBmslData($startDay, $endDay=""){
	global $mapId, $copyId;
	
	$startTime = strtotime($startDay." 00:00:00 ");
	if("" == $endDay){
		$endTime = strtotime($startDay." 23:59:59 ");
	} else {
		$endTime = strtotime($endDay." 23:59:59 ");
	}
	
	//房间数
	$sqlRoomCount = "select count(distinct scene_id) as `count` from t_log_bmsl_live where mtime >=$startTime and mtime< $endTime ";
	$sqlRoomCountResult = GFetchRowOne($sqlRoomCount);
	
	//各房间怪物强度
	$sqlMonsterStrength = "select scene_id, room_monster_strength from t_log_bmsl_live where mtime >=$startTime and mtime< $endTime group by scene_id ";
	//平均怪物强度
	$sqlAvgMonsterStrength = " select avg(t.room_monster_strength) as `avg_monster_strength` from ({$sqlMonsterStrength}) t ";
	$sqlAvgMonsterStrengthResult = GFetchRowSet($sqlAvgMonsterStrength);

	//最高怪物强度
	$sqlMaxMonsterStrength = "select max(room_monster_strength) as `max_strength` from t_log_bmsl_live where mtime >=$startTime and mtime< $endTime ";
	$sqlMaxMonsterStrengthResult = GFetchRowOne($sqlMaxMonsterStrength);
	
	//最高怪物强度房间排名
	$sqlMaxMonsterStrengthRank = "select * from t_log_bmsl_live where mtime >=$startTime and mtime< $endTime AND room_monster_strength={$sqlMaxMonsterStrengthResult['max_strength']}";
	if( isset($sqlMaxMonsterStrengthResult['max_strength']) && $sqlMaxMonsterStrengthResult['max_strength'] >= 0 ) {
		$sqlMaxMonsterStrengthRankResult = GFetchRowSet($sqlMaxMonsterStrengthRank);
	}
	
	
	//各房间存活人数
	$sqlAlive = "select scene_id, count(distinct uuid) as `count` from t_log_bmsl_live where mtime >=$startTime and mtime< $endTime group by scene_id  ";
	$sqlMaxAliveResult = GFetchRowSet($sqlAlive);
	
	
	//存活最多人数及房间号
	$maxAlive = array( 'scene_id' => 0, 'aliveCount' => 0, );
	$allAlive = 0 ;
	if(!empty($sqlMaxAliveResult)) {
		foreach($sqlMaxAliveResult as $key => $value){
			if($value['count'] > $maxAlive['aliveCount']) {
				$maxAlive['aliveCount'] = $value['count'];
				$maxAlive['scene_id'] = $value['scene_id'];
			}
			$allAlive += $value['count'];
		}
	}
	
	//平均存活人数
	$avgAlive = ($sqlRoomCountResult['count']) ? $allAlive/$sqlRoomCountResult['count'] : 0 ;
	
	//存活最多人数房间排名
	if( $maxAlive['aliveCount']>0 && !empty($maxAlive['scene_id']) ) {
		$sqlMaxAliveRank = "select * from t_log_bmsl_live where mtime >=$startTime and mtime< $endTime AND scene_id={$maxAlive['scene_id']} ";
		$sqlMaxAliveRankResult = GFetchRowSet($sqlMaxAliveRank);
	}
	
	//存活名单
	$sqlAllAliveList = "select * from t_log_bmsl_live where mtime >=$startTime and mtime< $endTime ";
	$sqlAllAliveListResult = GFetchRowSet($sqlAllAliveList);

	//救助次数
	$sqlHelpCount =  "select count(id) as `count` from t_log_collect_revive where mtime >=$startTime and mtime< $endTime AND map_id={$mapId} ";
	$sqlHelpCountResult = GFetchRowOne($sqlHelpCount);
	
	//平均每房间救助次数
	$avgHelpCount = 0;
	if( $sqlRoomCountResult['count'] != 0 && $sqlHelpCountResult['count'] ) {
		$avgHelpCount = round($sqlHelpCountResult['count']/$sqlRoomCountResult['count'] , 1) ;
	}
		
	//记忆之石
	$itemId = 10017;
	$buyType = 70028;
	$useTypes = array( '70081', '70082', '70083', '70084',);
	$useTypeStr = implode("," , $useTypes ) ;
	
	//消耗途径，消耗总量
	//消耗 t_log_item
	$sqlStoneUseItem = " select `type`, sum(`item_num`) as `count` from t_log_item where mtime >=$startTime and mtime< $endTime AND item_num < 0 AND item_id={$itemId} AND `type` in ( {$useTypeStr} ) group by `type` ";
	$sqlStoneUseItemResult = IBFetchRowSet($sqlStoneUseItem);
	
	//消耗 t_log_bmsl_jyzs
	$sqlStoneUseJyzs = " select `type`, sum(`jyzs`) as `count` from t_log_bmsl_jyzs where mtime >=$startTime and mtime< $endTime AND jyzs < 0 group by `type` ";
	$sqlStoneUseJyzsResult = GFetchRowSet($sqlStoneUseJyzs);
	
	$jyzsUse = array( 'attack' => 0 , 'defense' => 0 , 'restore' => 0 , 'relive' => 0 , 'all' => 0 , );
	if( !empty($sqlStoneUseItemResult) ) {
		foreach( $sqlStoneUseItemResult as $key => $value ) {
			$jyzsUse['all'] += $value['count'];
			switch($value['type']) {
				case 70081:
					$jyzsUse['attack'] += $value['count'];
					break;
				case 70082:
					$jyzsUse['defense'] += $value['count'];
					break;
				case 70083:
					$jyzsUse['restore'] += $value['count'];
					break;
				case 70084:
					$jyzsUse['relive'] += $value['count'];
					break;
				default:
					break;
			}
		}
	}
	if( !empty($sqlStoneUseJyzsResult) ) {
		foreach( $sqlStoneUseJyzsResult as $key => $value ) {
			$jyzsUse['all'] += $value['count'];
			switch($value['type']) {
				case 70081:
					$jyzsUse['attack'] += $value['count'];
					break;
				case 70082:
					$jyzsUse['defense'] += $value['count'];
					break;
				case 70083:
					$jyzsUse['restore'] += $value['count'];
					break;
				case 70084:
					$jyzsUse['relive'] += $value['count'];
					break;
				default:
					break;
			}
		}
	}
	
	//生成总量
	$sqlStoneUseWay = "select sum(jyzs) as `count` from t_log_bmsl_jyzs where mtime >=$startTime and mtime< $endTime AND jyzs > 0 ";
	$sqlStoneUseWayResult = GFetchRowOne($sqlStoneUseWay);

	//购买总量
	$sqlStoneBuy = " select sum(item_num) as `count` from t_log_item where mtime >=$startTime and mtime< $endTime AND item_num > 0 AND item_id={$itemId} AND type={$buyType} ";
	$sqlStoneBuyResult = IBFetchRowOne($sqlStoneBuy);

	
	$data = array(
		'roomCount' => $sqlRoomCountResult['count'], 
		'avgMonsterStrength' => $sqlAvgMonsterStrengthResult['avg_monster_strength'] , 
		'maxMonsterStrength' => $sqlMaxMonsterStrengthResult['max_strength'] , 
		'maxMonsterStrengthRank' => $sqlMaxMonsterStrengthRankResult , 
		'avgAlive' => $avgAlive , 
		'maxAlive' => $maxAlive , 
		'maxAliveRank' => $sqlMaxAliveRankResult , 
		'allAliveList' => $sqlAllAliveListResult , 
		'avgHelpCount' => $avgHelpCount , 
		'stoneAllUse' => $jyzsUse['all'] , 
		'stoneAllBuy' => $sqlStoneBuyResult['count'] , 
		'stoneAllOutput' =>  $sqlStoneUseWayResult['count'], 
		'stoneUseWay' => $jyzsUse , 
	);
	
	return $data;
	
}
