<?php
/**
 * activity_statistics.php
 * 活动数据统计
 * 
 */

include_once '../config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global_not_auth.php';
global $server_db;

$id = $argv[1];

$activity = array(
	//晶幻洞天 每天13:00 - 13:30、16:00 - 16:30、22:00-22:30
	1 => array( "id"=>1, "name" => '晶幻洞天', "level" => 40, "startTime" => 46800, "endTime" => 48600, ),
	//遗迹寻宝 每天19:00 - 19:20
	2 => array( "id"=>2, "name" => '遗迹寻宝', "level" => 35, "startTime" => 68400, "endTime" => 69600, ),
	//仙邪问鼎 每天20:00 - 20:15、20:25 - 20:40
	3 => array( "id"=>3, "name" => '仙邪问鼎', "level" => 40, "startTime" => 72000, "endTime" => 72900, ),
	//不灭试炼 每天15:00 - 15:30
	4 => array( "id"=>4, "name" => '不灭试炼', "level" => 40, "startTime" => 54000, "endTime" => 55800, ),
	//魔物暴动 每天21:00 - 21:30
	5 => array( "id"=>5, "name" => '魔物暴动', "level" => 40, "startTime" => 75600, "endTime" => 77400, ),
	6 => array( "id"=>6, "name" => '晶幻洞天', "level" => 40, "startTime" => 57600, "endTime" => 59400, ),
	7 => array( "id"=>7, "name" => '仙邪问鼎', "level" => 40, "startTime" => 73500, "endTime" => 74400, ),
	8 => array( "id"=>8, "name" => '晶幻洞天', "level" => 40, "startTime" => 79200, "endTime" => 81000, ),
	//家族领地战 周六20:00 - 20:40
	9 => array( "id"=>9, "name" => '家族领地战', "level" => 40, "startTime" => 72000, "endTime" => 74400, ),
	//画境斗才 每天12:00 - 12:20
	10 => array( "id"=>10, "name" => '画境斗才', "level" => 30, "startTime" => 43200, "endTime" => 44400, ),
	//诛魔卫道 (跨服BOSS) 每天12:30 - 12:45
	14 => array( "id"=>14, "name" => '诛魔卫道', "level" => 50, "startTime" => 45000, "endTime" => 45900, ),
    //副本竞速-登云台  每天22:00-22:30
    15 => array('id'=>15, "name" => '登云台', "level" => 40, "startTime" => 79200, "endTime" => 81000, ),
	//仙邪问鼎 两场都参与的玩家数 20:50开始统计
	101 => array( "id"=>37, "name" => '仙邪问鼎', "level" => 40, "startTime" => 75000, "endTime" => 75300, ),
);

$date = date("Y-m-d");
$dateTime = strtotime($date);
$time = time();

$table = "c_activity_join";

// 23:00-12:00 没活动，不处理
if( $time - $dateTime < 43200 || $time - $dateTime > 82800 ) {
	exit;
}

$loadServerList = getAvailableServerList();
if(!$server_db){
	$server_db =  new DBMysqlClass();
}

foreach($activity as $k => $v){
	////
	$abSt = $time - $dateTime - $v['startTime'];
	$abEt = $time - $dateTime - $v['endTime'];
    
	if( abs($abSt) < 60 ) {
		foreach($loadServerList as $key => $value) {
            
			//连接数据库
			$config = getLogDb($loadServerList[$key]);
			$server_db->connect($config);
			
			//活动开始
//			$result = interfaceRequest("getonlinelist");
			$result = socketRequestResult($key, "getonlinelist");
			//获取满足参加条件的在线玩家数
			if($result['result'] == 1){
				$count = 0;
				foreach($result['data'] as $j => $w){
					if($w['level'] >= $v['level']){
						$count++;
					}
				}
			}
			$data['mdate'] = $date;
			$data = array(
				'mdate' => $date,
				'mtime' => $time,
				'activity' => $v['name'],
				'act_no' => $v['id'],
				'act_count' => $count,
				'year' => date("Y"),
				'month' => date("m"),
				'day' => date("d"),
			);
			$sql = makeInsertSqlFromArray($data,$table);
			if(GQuery($sql) ){
				echo "INSERT SUCC! act_no={$v['id']}, act_count={$count}.";
			} else {
				echo "sql=$xxwdSql";
			}
		}
	}
	if( ($abEt >=600 && $abEt < 660) || $id==$k ){
		foreach($loadServerList as $key => $value){
			//连接数据库
			$config = getLogDb($loadServerList[$key]);
			$server_db->connect($config);
			
			//活动结束10分钟后，统计活动参与人数、房间数 
			$updateData = array();
			$startTime = $v['startTime']+$dateTime;
			$endTime = $v['endTime']+$dateTime;
			switch($v['id']){
				case 1:
				case 6:
				case 8:
					$updateData = jhdt($startTime, $endTime);
					break;
				case 2:
					$updateData = yjxb($startTime, $endTime);
					break;
				case 3:
				case 7:
					$updateData = xxwd($startTime, $endTime);
					break;
				case 4:
					$updateData = bmsl($startTime, $endTime);
					break;
				case 5:
					$updateData = mwbd($startTime, $endTime);
					break;
				case 10:
					$updateData = hjdc($startTime, $endTime);
					break;
				case 14:
					$updateData = zmwd($startTime, $endTime);
					break;
                case 15:
                    $updateData =  dyt($startTime, $endTime);
                    break;
				case 101:
					$data = xxwdBoth($activity[3]['startTime'], $activity[3]['endTime'],$activity[7]['startTime'], $activity[7]['endTime']);
					
					$xxwdSql = " update {$table} set join_count={$data['join_count']} " .
						" where act_no={$v['id']} and mdate='{$date}' ";
						
					if(GQuery($xxwdSql) ){
						echo "UPDATE SUCC! act_no={$v['id']}, join_count={$data['join_count']}.";
					} else {
						echo "sql=$xxwdSql";
					}
					break;
			}
			if(!empty($updateData)){
				$updateSql = " update {$table} set join_count={$updateData['join_count']}, room_count={$updateData['room_count']}" .
						" where act_no={$v[id]} and mdate='{$date}' ";
	//			GQuery($updateSql);
				if(GQuery($updateSql) ){
					echo "UPDATE SUCC! act_no={$v['id']}, join_count={$updateData['join_count']}, room_count={$updateData['room_count']}";
				} else {
					echo "sql=$updateSql";
				}			
			}

		}
			
	}
}

function jhdt($startTime,$endTime){
	$endTime += 300;
	$copyId = 304;
	$sqlJoinCount = "select count(distinct uuid) as `count` from t_log_copy where mtime >=$startTime and mtime< $endTime and copy_id='{$copyId}' and action=1 ";
	$sqlJoinCountResult = GFetchRowOne($sqlJoinCount);
	
	$data = array(
		'join_count' => $sqlJoinCountResult['count'],
		'room_count' => 1,
	);
	return $data;
}

function yjxb($startTime,$endTime){
	$endTime += 300;
	$copyId = 300;
	$sqlJoinCount = "select count(distinct uuid) as `count` from t_log_copy where mtime >=$startTime and mtime< $endTime and copy_id='{$copyId}' and action=1 ";
	$sqlJoinCountResult = GFetchRowOne($sqlJoinCount);
	//房间数
	$sqlRoomCount = "select count(distinct scene_id) as `count` from t_log_yjxb_collect where mtime >=$startTime and mtime< $endTime ";
	$sqlRoomCountResult = GFetchRowOne($sqlRoomCount);
	
	$data = array(
		'join_count' => $sqlJoinCountResult['count'],
		'room_count' => $sqlRoomCountResult['count'],
	);
	return $data;
}

function xxwd($startTime,$endTime){
	$endTime += 300;
//	$copyId = 301;
	$sqlJoinCount = "select count(distinct uuid) as `count` from t_log_xxwd_board where mtime >=$startTime and mtime< $endTime ";
	$sqlJoinCountResult = GFetchRowOne($sqlJoinCount);
	
	//房间数
	$sqlRoomCount = "select count(distinct room_id) as `count` from t_log_xxwd_score where mtime >=$startTime and mtime< $endTime ";
	
	$sqlRoomCountResult = GFetchRowOne($sqlRoomCount);
	
	$data = array(
		'join_count' => $sqlJoinCountResult['count'],
		'room_count' => $sqlRoomCountResult['count'],
	);
	return $data;
}

function xxwdBoth($startTime1,$endTime1,$startTime2,$endTime2){
	//两场都参加的玩家数
	$endTime += 300;
//	$copyId = 301;

	
	//两场都参与的人数
	$sqlJoin1 = "select distinct uuid from t_log_xxwd_board where mtime >=$startTime1 and mtime< $startTime2 ";
	$sqlJoin2 = "select distinct uuid from t_log_xxwd_board where mtime >=$startTime2 and mtime< ($endTime2+600) ";
	
	$sqlJoinAll = "select count(*) as `count` from ({$sqlJoin1}) t1, ({$sqlJoin2}) t2 where t1.uuid=t2.uuid";
	
	$sqlJoinAllResult = GFetchRowOne($sqlJoinAll);
	
	$data = array(
		'join_count' => $sqlJoinAllResult['count'],
	);
	return $data;
}

function bmsl($startTime,$endTime){
	$endTime += 300;
	$copyId = 302;
	//参与人数
	$sqlJoinCount = "select count(distinct uuid) as `count` from t_log_copy where mtime >=$startTime and mtime< $endTime and copy_id='{$copyId}' and action=1 ";
	$sqlJoinCountResult = GFetchRowOne($sqlJoinCount);
	
	//房间数
	$sqlRoomCount = "select count(distinct scene_id) as `count` from t_log_bmsl_live where mtime >=$startTime and mtime< $endTime ";
	$sqlRoomCountResult = GFetchRowOne($sqlRoomCount);
	
	$data = array(
		'join_count' => $sqlJoinCountResult['count'],
		'room_count' => $sqlRoomCountResult['count'],
	);
	return $data;
}

function mwbd($startTime,$endTime){
	$endTime += 300;
//	$copyId = 302;
	//参与人数
	$sqlJoinCount = "select count(distinct uuid) as `count` from t_log_mwbd_join_info where mtime >=$startTime and mtime<= $endTime ";
	$sqlJoinCountResult = GFetchRowOne($sqlJoinCount);

	
	$data = array(
		'join_count' => $sqlJoinCountResult['count'],
		'room_count' => 1,
	);
	return $data;
}

//进行中。。。
//画境斗才
function hjdc($startTime,$endTime){
	$endTime += 300;
	$copyId = 303;
	//参与人数
	$sqlJoinCount = "select count(distinct uuid) as `count` from t_log_copy where mtime >=$startTime and mtime< $endTime and copy_id='{$copyId}' and action=1 ";
	$sqlJoinCountResult = GFetchRowOne($sqlJoinCount);
	
	//房间数
//	$sqlRoomCount = "select count(distinct scene_id) as `count` from {ooxx} where mtime >=$startTime and mtime< $endTime ";
//	$sqlRoomCountResult = GFetchRowOne($sqlRoomCount);
	
	$data = array(
		'join_count' => $sqlJoinCountResult['count'],
		'room_count' => 0,
	);
	return $data;
}

//诛魔卫道
function zmwd($startTime,$endTime){
	$endTime += 300;
	$copyId = 700;
	//参与人数
	$sqlJoinCount = "select count(distinct uuid) as `count` from t_log_copy where mtime >=$startTime and mtime< $endTime and copy_id='{$copyId}' and action=1 ";
	$sqlJoinCountResult = GFetchRowOne($sqlJoinCount);

	
	$data = array(
		'join_count' => $sqlJoinCountResult['count'],
		'room_count' => 1,
	);
	return $data;
}

//副本-登云台
function dyt($startTime,$endTime){
    $endTime += 300;
    $copyId = 321;
    //参与人数
    $sqlJoinCount = "select count(distinct uuid) as count from t_log_copy where mtime >=$startTime and mtime< $endTime and copy_id='{$copyId}' and action=1";
    $sqlJoinCountResult = GFetchRowSet($sql);
    
    $data = array(
       'join_count' => $sqlJoinCountResult['count'],
        'room_count' => 0,
    );
    return $data;
}