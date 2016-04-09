<?php
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
global $lang;
$auth->assertModuleAccess(__FILE__);

$nowTime = time();
//获取时间段
if (!isset ($_POST['starttime'])) {
	$startDate = Datatime :: getTodayString();
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

$minLevel = isset($_POST["min_level"]) ? SS($_POST["min_level"]) : "";
$maxLevel = isset($_POST["max_level"]) ? SS($_POST["max_level"]) : "";

//任务类型
$type = SS($_POST['type']);
$missionType = array(
	'0' => $lang->page->allTime,
	'1' => $lang->page->mainTask,
	'2' => $lang->page->extensionTask,
	'3' => $lang->page->cycleTask,
);
//获取用于显示的数据，这个最好不要在本文件的代码写，这样的耦合度是最高的，最好是用接口的形式提供,现在只是模拟数据用来显示
$viewData = json_decode(getTaskLoseRate($startDate, $endDate, $type, $minLevel, $maxLevel), true);
//因为第一个任务没有接受的日志，用到达欢迎页面的人数来填充
$sql = "select count(distinct account_name) num from ".T_LOG_CREATE_LOSS." where mtime>=".strtotime($startDate)." and mtime<=".strtotime($endDate." 23:59:59")." and step=2";
$firstTask = GFetchRowOne($sql);
$viewData['data'][1]['accept'] = $firstTask['num'];
foreach($viewData['data'] as $key => &$value){
	$value['accept'] = intval($value['accept']);
	$value['finish'] = intval($value['finish']);
	$value['cancle'] = intval($value['cancle']);
    if(intval($value['accept'])){
	    $value['finishRate'] = number_format(intval($value['finish']) / intval($value['accept']) * 100, 2)."%";
    }else{
        $value['finishRate'] = "N/A";
    }
    if(intval($value['accept'])){
	    $value['cancleRate'] = number_format(intval($value['cancle']) / intval($value['accept']) * 100, 2)."%";
    }else{
        $value['cancleRate'] = "N/A";
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

$smarty->assign('lang', $lang);
$smarty->assign('viewData', $viewData);
$smarty->assign('type', $type);
$smarty->assign('missionType', $missionType);
$smarty->display('module/analysis/task_lose_rate.tpl');

function getTaskLoseRate($startDate, $endDate, $type, $minLevel="", $maxLevel="") {
	$where = 1;
	if(0 < $type){
		$where .= " and group_id={$type} ";
	}
	if("" != $minLevel){
		$where .= " and min_level>={$minLevel} ";
	}
	if("" != $maxLevel){
		$where .= " and max_level<={$maxLevel} ";
	}
	$where .= " and mtime>=".strtotime($startDate);
	$where .= " and mtime<=".strtotime($endDate." 23:59:59");
	//这个SQL统计时间段内每个任务接受,完成,放弃的人数
	$sql = "select U30.mission_id missionId,U30.mission_name missionName,U30.accept,U30.finish,U30.groupId,U30.minLevel,U30.maxLevel,U40.cancle from (
		select U10.*, U20.accept from (SELECT mission_id, mission_name, count(mission_id) finish, group_id groupId, min_level minLevel, max_level maxLevel FROM t_log_mission where {$where} and `status`=2  group by mission_id) U10 
		left join (SELECT mission_id, mission_name, count(mission_id) accept FROM t_log_mission where {$where} and `status`=1  group by mission_id) U20 on U10.mission_id=U20.mission_id) U30 
		left join (SELECT mission_id, mission_name, count(mission_id) cancle FROM t_log_mission where {$where} and `status`=3  group by mission_id) U40 on U30.mission_id=U40.mission_id";
	$result['data'] = GFetchRowSet($sql, "missionId");

	return json_encode($result);
}








