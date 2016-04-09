<?php
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/task.php';

global $lang;
$auth->assertModuleAccess(__FILE__);

$nowTime = time();
//获取时间段
if (!isset ($_POST['starttime'])) {
	$startDate = Datatime :: getTodayString();
//	$startDate = ONLINEDATE;
} else {
	$startDate = SS($_POST['starttime']);
}
if (!isset ($_POST['endtime'])) {
	$endDate = Datatime :: getTodayString();
} else {
	$endDate = SS($_POST['endtime']);
}

$openTimestamp = strtotime( ONLINEDATE );
if(strtotime($startDate) < $openTimestamp)
{
	$startDate = ONLINEDATE;
}

$minLevel = isset($_POST["min_level"]) ? SS($_POST["min_level"]) : 1;
$maxLevel = isset($_POST["max_level"]) ? SS($_POST["max_level"]) : GAME_MAXLEVEL ;

//任务类型
$type = SS($_POST['type']);

$viewData = getTaskLoseRate($startDate, $endDate) ;

//第一个任务无日志，创建完角色即接受
$sql = "select count(distinct account_name) num from ".T_LOG_CREATE_LOSS." where mtime>=".strtotime($startDate)." and mtime<=".strtotime($endDate." 23:59:59")." and step=1";
$firstTaskAccept = GFetchRowOne($sql);
//完成数
$sql = "select count(*) as num from t_log_task where mtime>=".strtotime($startDate)." and mtime<=".strtotime($endDate." 23:59:59")." and task_id=1 and task_action=1";
$firstTaskFinish = GFetchRowOne($sql);

$firstTask = array (
	'task_id' => 1,
	'accept' => $firstTaskAccept['num'],
	'finish' => $firstTaskFinish['num'],
);

array_unshift($viewData,$firstTask);
foreach($viewData as $key => &$value){
//	if($value['task_id'] == 1) {
//		$value['accept'] = $firstTaskAccept['num'];
//	}
	$value['accept'] = intval($value['accept']);
	$value['finish'] = intval($value['finish']);
    if(intval($value['accept'])){
	    $value['finishRate'] = number_format(intval($value['finish']) / intval($value['accept']) * 100, 2)."%";
    }else{
        $value['finishRate'] = "N/A";
    }
}

$minDate = ONLINEDATE;
$maxDate = Datatime :: getTodayString();
$smarty->assign("minDate", $minDate);
$smarty->assign("maxDate", $maxDate);
$smarty->assign("startDate", $startDate);
$smarty->assign("endDate", $endDate);
$smarty->assign("minLevel", $minLevel);
$smarty->assign("maxLevel", $maxLevel);

$smarty->assign('dictTask', $dictTask);
$smarty->assign('lang', $lang);
$smarty->assign('viewData', $viewData);
$smarty->assign('type', $type);
$smarty->assign('missionType', $missionType);
$smarty->display('module/basedata/task_lose_rate.tpl');

function getTaskLoseRate($startDate, $endDate ) {

	
	$startTime = strtotime($startDate);
	$endTime = strtotime($endDate." 23:59:59");
	
	$where = 1;
	$where .= " and task_id < 10000 ";
	$where .= " and mtime>=".$startTime;
	$where .= " and mtime<=".$endTime;
	/*
	//这个SQL统计时间段内每个任务接受,完成,放弃的人数
	$sql = "select U30.mission_id missionId,U30.mission_name missionName,U30.accept,U30.finish,U30.groupId,U30.minLevel,U30.maxLevel,U40.cancle from (
		select U10.*, U20.accept from (SELECT mission_id, mission_name, count(mission_id) finish, group_id groupId, min_level minLevel, max_level maxLevel FROM t_log_mission where {$where} and `status`=2  group by mission_id) U10 
		left join (SELECT mission_id, mission_name, count(mission_id) accept FROM t_log_mission where {$where} and `status`=1  group by mission_id) U20 on U10.mission_id=U20.mission_id) U30 
		left join (SELECT mission_id, mission_name, count(mission_id) cancle FROM t_log_mission where {$where} and `status`=3  group by mission_id) U40 on U30.mission_id=U40.mission_id";
	
	$sql = "select 
				U30.task_id, U30.accept, U30.finish, U40.cancle 
			from (
					select U10.*, U20.accept 
					from 
						(
							SELECT task_id, count(task_id) as finish FROM t_log_task where {$where} and `task_action`=1  group by task_id
						) U10 
						left join 
						(
							SELECT task_id, count(task_id) accept FROM t_log_task where {$where} and `task_action`=0  group by task_id
						) U20 on U10.task_id=U20.task_id
				) U30 
				left join 
				(
					SELECT task_id, count(task_id) cancle FROM t_log_task where {$where} and `task_action`=2  group by task_id
				) U40 
			on U30.task_id=U40.task_id"; //此sql只统计指定时间段内的任务情况，包括时间段前接受的任务，完成率可能会超100%
	*/		
	//时间段内接受的任务数
	$sql1 = " select task_id, count(task_id) as accept from t_log_task where {$where} and `task_action`=0 group by task_id ";
	
	//完成任务数
	$sql2 = " select T1.task_id, count(T1.uuid) as finish
			from
			( 	select uuid,task_id,count(task_action) as ff
				from t_log_task
				where {$where} and `task_action`<>2
				group by task_id,uuid having ff=2 
			) T1
			group by T1.task_id  ";
	$sql = "select U10.task_id, U10.accept, U20.finish from ({$sql1}) U10 left join ({$sql2}) U20 on U10.task_id=U20.task_id";

	$task_lose_rate = GFetchRowSet($sql, "task_id");
	
	return $task_lose_rate;
}








