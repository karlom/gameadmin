<?php
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';
global $lang,$dictOccupationType;

/*
$sql = "SELECT U3.mlevel, U3.career,count(career) num
		FROM
		(SELECT 
			C1.uuid, C1.account_name, C1.role_name, C1.career, U2.mlevel 
		FROM 
			t_log_career C1, (SELECT MAX(level) mlevel, uuid, account_name, role_name FROM t_log_level_up GROUP BY uuid) U2 
		WHERE
			C1.uuid = U2.uuid
		GROUP BY C1.uuid) U3
		GROUP BY U3.mlevel,U3.career
		ORDER BY U3.mlevel";
	*/
//有升级记录的
$sqlLastLevel = "SELECT L.mtime, L.level as mlevel, L.uuid, L.account_name, L.role_name " .
		" FROM t_log_level_up L, (select max(mtime) as mtime ,uuid from t_log_level_up group by uuid ) T " .
		" WHERE T.mtime=L.mtime AND T.uuid=L.uuid ";
 
$sql = "SELECT U3.mlevel, U3.career,count(career) num
		FROM
		(SELECT 
			C1.uuid, C1.account_name, C1.role_name, C1.career, U2.mlevel 
		FROM 
			t_log_career C1, 
			({$sqlLastLevel}) U2 
		WHERE
			C1.uuid = U2.uuid
		GROUP BY C1.uuid) U3
		GROUP BY U3.mlevel,U3.career
		ORDER BY U3.mlevel";
		
$rqResult = GFetchRowSet($sql);
$data = array();
$maxLevel = 0;

//print_r($rqResult);

if($rqResult){
	
	foreach($rqResult as $k => $v){
		$level = $v['mlevel'];
		$career = $v['career'];
		$num = $v['num'];
		
		if($career == 1){
			$data[$level]['wuzun'] = $num;
		}else if($career == 2){
			$data[$level]['lingxiu'] = $num;
		}else if($career == 3){
			$data[$level]['jianxian'] = $num;
		}
//		$data[$level][$career] = $num;
		
		$maxLevel = ($maxLevel>$level)?$maxLevel:$level ;
	}
}

//无升级记录的
$sqlNoUp = " SELECT R.job as career,R.level as mlevel,count(R.uuid) as num FROM t_log_register R LEFT JOIN t_log_level_up L ON R.uuid=L.uuid WHERE L.uuid IS NULL group by R.job,R.level ;";
$sqlNoUpResult = GFetchRowSet($sqlNoUp);

if(!empty($sqlNoUpResult)) {
	foreach($sqlNoUpResult as $k => $v){
		$level = $v['mlevel'];
		$career = $v['career'];
		$num = $v['num'];
		
		if($career == 1){
			$data[$level]['wuzun'] = $num;
		}else if($career == 2){
			$data[$level]['lingxiu'] = $num;
		}else if($career == 3){
			$data[$level]['jianxian'] = $num;
		}
	}
}

for($i=1; $i<= $maxLevel; $i++){
	if(!isset($data[$i])){
		$data[$i]['wuzun'] = 0;
		$data[$i]['lingxiu'] = 0;
		$data[$i]['jianxian'] = 0;
	} else {
		if(!$data[$i]['wuzun']){
			$data[$i]['wuzun'] = 0;
		}
		if(!$data[$i]['lingxiu']){
			$data[$i]['lingxiu'] = 0;
		}
		if(!$data[$i]['jianxian']){
			$data[$i]['jianxian'] = 0;
		}
	}
}

//按键名排序
ksort($data);

//print_r($data);

$onlineDate = ONLINEDATE;
$onlineDays = ceil(( time() - strtotime($onlineDate)) / 86400);	//已开服天数

$smarty->assign('onlineDate',$onlineDate);
$smarty->assign('onlineDays',$onlineDays);
$smarty->assign('data',$data);
$smarty->assign('lang',$lang);
$smarty->assign('dictOccupationType',$dictOccupationType);
$smarty->display("module/player/player_career.tpl");
