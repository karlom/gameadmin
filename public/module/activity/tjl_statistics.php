<?php
/**
 * 通辑令 数据统计
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';
include_once SYSDIR_ADMIN_DICT.'/dict.php';
/*
$dictMonsterType = array(
	605001 => array( 'id' => 605001, 'name' => '血牙', 'hotLevel' => 5, ),
	605002 => array( 'id' => 605002, 'name' => '蛮奴', 'hotLevel' => 5, ),
	605003 => array( 'id' => 605003, 'name' => '毒蛟王', 'hotLevel' => 5, ),
	
	605101 => array( 'id' => 605101, 'name' => '蛮奴', 'hotLevel' => 10, ),
	605102 => array( 'id' => 605102, 'name' => '毒蛟王', 'hotLevel' => 10, ),
	605103 => array( 'id' => 605103, 'name' => '石核源', 'hotLevel' => 10, ),

	605201 => array( 'id' => 605201, 'name' => '毒蛟王', 'hotLevel' => 15, ),
	605202 => array( 'id' => 605202, 'name' => '石核源', 'hotLevel' => 15, ),
	605203 => array( 'id' => 605203, 'name' => '不死鸟', 'hotLevel' => 15, ),
	
	605301 => array( 'id' => 605301, 'name' => '石核源', 'hotLevel' => 25, ),
	605302 => array( 'id' => 605302, 'name' => '不死鸟', 'hotLevel' => 25, ),
	605303 => array( 'id' => 605303, 'name' => '霸天', 'hotLevel' => 25, ),
	
	605401 => array( 'id' => 605401, 'name' => '不死鸟', 'hotLevel' => 30, ),
	605402 => array( 'id' => 605402, 'name' => '霸天', 'hotLevel' => 30, ),
	605403 => array( 'id' => 605403, 'name' => '诡诈黑鸟', 'hotLevel' => 30, ),
	
	605501 => array( 'id' => 605501, 'name' => '霸天', 'hotLevel' => 35, ),
	605502 => array( 'id' => 605502, 'name' => '诡诈黑鸟', 'hotLevel' => 35, ),
	605503 => array( 'id' => 605503, 'name' => '霜满地', 'hotLevel' => 35, ),
	
	605601 => array( 'id' => 605601, 'name' => '诡诈黑鸟', 'hotLevel' => 40, ),
	605602 => array( 'id' => 605602, 'name' => '霜满地', 'hotLevel' => 40, ),
	605603 => array( 'id' => 605603, 'name' => '影手琴魔', 'hotLevel' => 40, ),
	
	605701 => array( 'id' => 605701, 'name' => '霜满地', 'hotLevel' => 50, ),
	605702 => array( 'id' => 605702, 'name' => '影手琴魔', 'hotLevel' => 50, ),
	605703 => array( 'id' => 605703, 'name' => '神秘人', 'hotLevel' => 50, ),
	
	605250 => array( 'id' => 605250, 'name' => '浴火卵', 'hotLevel' => 15, ),
	605350 => array( 'id' => 605350, 'name' => '浴火卵', 'hotLevel' => 25, ),
	605450 => array( 'id' => 605450, 'name' => '浴火卵', 'hotLevel' => 30, ),
);
*/
//$copyId = 512;
//$mapId = 3003;
$limitLevel = 35;
$copyIds = array (
	'510','511','512','513','514','515','516','517','518','519',
);

//$copyId = implode(',', $copyIds);

//副本开启时间：全天

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
	$viewData[$d] = getTjlData($d);
	if(empty($joinData[$d])){
		$joinData[$d] = array(
			'mdate' => $d,
			'act_count' => '<font color="blue">(-1)</font>',
			'join_count' => 0,
			'joinRate' => 0,
		);
	}
}


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
$smarty->assign('today', $today );
$smarty->assign('selectDay', $selectDay );
$smarty->display( 'module/activity/tjl_statistics.tpl' );

function getJoinData($date){

	$startTime = strtotime($date." 00:00:00 "); 
	$endTime = strtotime($date." 23:59:59 "); 
	
	//参与人数
	$sqlJoinCount = " select count(distinct uuid) as `count` from " . T_LOG_WANTED . " where mtime>={$startTime} and mtime<={$endTime} ";
	$sqlJoinCountResult = GFetchRowOne($sqlJoinCount);
	/*
	//当天最大在线人数
	$sqlMaxOnline = " select max(online) as `count` from " . T_LOG_ONLINE . " where mtime>={$startTime} and mtime<={$endTime} ";
	$sqlMaxOnlineResult = GFetchRowOne($sqlMaxOnline);
	*/
	
	//当天登录过的，等级>=35的所有用户
	$sqlMaxOnline = " select count(distinct uuid) as `count` from " . T_LOG_LOGIN . " where mtime>={$startTime} and mtime<={$endTime} AND level>= 35";
	$sqlMaxOnlineResult = GFetchRowOne($sqlMaxOnline);
	
	//刷新次数统计
	$sqlRefresh = "select  count(id) as opCount, sum(-gold) as sumGold from " . T_LOG_GOLD . " where mtime>={$startTime} and mtime<={$endTime} AND type=20203 and gold<0  ";
	
	$sqlRefreshResult = GFetchRowOne($sqlRefresh);
//	echo $sqlRefresh."<br>";
	
	$result  = array(
		'mdate' => $date,
		'act_count' => $sqlMaxOnlineResult['count'] ? $sqlMaxOnlineResult['count']:0,
		'join_count' => $sqlJoinCountResult['count'],
		'joinRate' => $sqlMaxOnlineResult['count']? round($sqlJoinCountResult['count']/$sqlMaxOnlineResult['count'], 4)*100 : 0,
		'refresh' => $sqlRefreshResult,
	);

	return $result;
}

/**
 * 通辑令 统计数据
 * @param string1,string2 开始日期【,结束日期】 日期格式："YYYY-MM-DD"
 * @author Libiao
 */
function getTjlData($startDay, $endDay=""){
	global $mapId, $copyId;
	
	$startTime = strtotime($startDay." 00:00:00 ");
	if("" == $endDay){
		$endTime = strtotime($startDay." 23:59:59 ");
	} else {
		$endTime = strtotime($endDay." 23:59:59 ");
	}
	
	/*
	//参与人数
	$sqlJoinCount = " select count(distinct uuid) as `count` from " . T_LOG_WANTED . " where mtime>={$startTime} and mtime<={$endTime} ";
	$sqlJoinCountResult = GFetchRowOne($sqlJoinCount);
	//当天最大在线人数
	$sqlMaxOnline = " select max(online) as `count` from " . T_LOG_ONLINE . " where mtime>={$startTime} and mtime<={$endTime} ";
	$sqlMaxOnlineResult = GFetchRowOne($sqlMaxOnline);
	*/
	
	//通缉令消耗量
	$sqlCost = "select uuid,account_name,role_name, sum(costCnt) as cnt from " . T_LOG_WANTED . " where mtime>={$startTime} and mtime<={$endTime} group by uuid ";
	
	$sqlCostResult = GFetchRowSet($sqlCost);
	

	//副本通关成功率
	$sqlAllCount = "select hot, monsterID, monsterName, count(id) as cnt, sum(op) as `clean` from " . T_LOG_WANTED . " where mtime>={$startTime} and mtime<={$endTime}  group by hot, monsterName ";
//	$sqlClean = "select hot, monsterID, monsterName, count(id) as cnt from " . T_LOG_WANTED . " where mtime>={$startTime} and mtime<={$endTime} AND op=1 group by hot, monsterName ";
	
	$sqlAllCountResult = GFetchRowSet($sqlAllCount);
	
	
	if(!empty($sqlAllCountResult)){
		$allCleanPercent = array();
		foreach( $sqlAllCountResult as $k => $v ){
			$fail_cnt = ( $v['cnt'] - $v['clean'] );
			$cleanPerc = $v['clean']/$v['cnt'];
			$cleanPerc = ( round($cleanPerc,4)*100 )."%";
			$v['fail'] = $fail_cnt;
			$v['cleanRate'] = $cleanPerc;
			$allCleanPercent[$v['hot']][] = $v;
		}		
	}
	
	//放弃缉捕统计
	$sqlAbort = "select uuid, count(id) as `abort` from " . T_LOG_WANTED . " where mtime>={$startTime} and mtime<={$endTime} AND type=2 group by uuid ";
	$sqlAbortRate = "select t1.abort, count(t1.uuid) as cnt from ($sqlAbort) t1 group by t1.abort ; ";
	
	$sqlAbortStsResult = GFetchRowSet($sqlAbortRate);
		
	//处理
	if(!empty($sqlAbortStsResult)){
		$abortSts = array();
		$allAbortCount = 0;
		$ab5 = 0;
		foreach($sqlAbortStsResult as $k => $v){
			$allAbortCount += $v['cnt'];
			if($v['abort'] >=5){
				$ab5 += $v['cnt'];
			}
		}
		foreach($sqlAbortStsResult as $k => $v){
			$rate = round($v['cnt']/$allAbortCount,4)*100;
			$v['rate'] = $rate;
			if($v['abort'] <5 ){
				$abortSts[] = $v;
			} else if ($v['abort'] >=5 ) {
				$abortSts[5] = array(
					'abort' => 5,
					'cnt' => $ab5,
					'rate' => round($ab5/$allAbortCount,4)*100 ,
				);
			}
		}
	}
	
	$data = array(
//		'joinCount' => $sqlJoinCountResult['count'], 
//		'maxOnline' => $sqlMaxOnlineResult['count'], 
		'costCount' => $sqlCostResult ,
		'cleanRate' => $allCleanPercent ,
		'abortRate' => $abortSts ,
	);
	
	return $data;
	
}
