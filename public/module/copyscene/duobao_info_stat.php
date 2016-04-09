<?php
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT.'/dict.php';
include_once SYSDIR_ADMIN_DICT.'/arrItemsAll.php';
global $lang;

$nowTime = time();
$action  = isset($_POST['action']) ? SS($_POST['action']) : '';
$role    = $_REQUEST['role'];
$role['roleName'] = $roleName    = $role['roleName'] ? autoAddPrefix( SS($role['roleName']) ): '';
$role['accountName'] = $accountName = $role['accountName'] ? autoAddPrefix( SS($role['accountName'])) : '';
$page    = getUrlParam('page');           //设置初始页
$pageLine  = $_POST['pageLine'] ? SS($_POST['pageLine']) : LIST_PER_PAGE_RECORDS;

//获取时间段
if (!isset ($_POST['starttime'])) {
	$startDate = Datatime :: getPreDay(date("Y-m-d"), 1);
} else {
	$startDate = trim($_POST['starttime']);
}
if (!isset ($_POST['endtime'])) {
	$endDate   = Datatime :: getTodayString();
} else {
	$endDate   = trim($_POST['endtime']);
}

$startDateStamp = strtotime($startDate . ' 0:0:0');
$endDateStamp  = strtotime($endDate . ' 23:59:59');
$openTimestamp = strtotime( ONLINEDATE );
if($startDateStamp < $openTimestamp)
{
	$startDateStamp = $openTimestamp;
	$startDate = ONLINEDATE;
}

$where = 1;
$where .= " and `mtime`>=$startDateStamp and `mtime`<=$endDateStamp ";

$where .=  $accountName ? " and `account_name` = '{$accountName}' ":'';
$where .=  $roleName ? " and `role_name` = '{$roleName}' ":'';

//页数
$recordCount = 0;                          //总记录
$startNum  = ($page - 1) * $pageLine;      //每页开始位置
$viewArr   = getTimeData($where);
$viewData  = getCopySceneRecord(1,$where,$order,$startNum,$pageLine,&$recordCount);
$pageCount = ceil($recordCount/$pageLine ); //总页数
$pageList  = getPages($page, $recordCount, $pageLine);

$enterTime = array();
$outTime = array();
$data = array();

foreach ($viewArr as $key => $value) {
	if($value['state']==1) {
		$enterTime[] = array('account_name'=>$value['account_name'],'itime'=>$value['itime'],'mapid'=>$value['mapid']);
	}

	if($value['state']==3) {
		$outTime[]['otime'] = $value['otime'];
	}
}

foreach ($enterTime as $key => &$value) {
	foreach ($outTime as $v) {
		$value['otime'] = $outTime[$key]['otime'];
	}
}

foreach ($viewData as $key => $value2) {
	if($value2['state']== 2) {
		foreach($enterTime as $k=>$v2) {
			if($value2['account_name']==$v2['account_name'] && $v2['itime'] < $value2['mtime'] && $v2['otime']>$value2['mtime']) {
				$value2['itime'] = date('Y-m-d H:i:s', $v2['itime']);
				$value2['otime'] = date('Y-m-d H:i:s', $v2['otime']);
				$value2['mapid'] = $v2['mapid'];
				$value2['ttime'] = transTotalTime($v2['otime'],$v2['itime']);
			}
		}

		$value2['tbox']   = $dictDuoBaoType[$value2['tbox']];
		$value2['gitem']  = $arrItemsAll[$value2['gitem']]['name'];
		$value2['mapid']  = $dictMapType[$value2['mapid']]['name'];

		$data[$key] = $value2;
	}	
}

$dateStrPrev = strftime("%Y-%m-%d", strtotime($startDate) - 86400);
$dateStrToday = strftime("%Y-%m-%d");
$dateStrNext = strftime("%Y-%m-%d", strtotime($startDate) + 86400);
$dateOnline = ONLINEDATE;

$minDate = ONLINEDATE;
$maxDate = Datatime :: getTodayString();
$smarty->assign("minDate", $minDate);
$smarty->assign("maxDate", $maxDate);
$smarty->assign("dateStrPrev", $dateStrPrev);
$smarty->assign("dateStrToday", $dateStrToday);
$smarty->assign("dateStrNext", $dateStrNext);
$smarty->assign("dateOnline", $dateOnline);
$smarty->assign("startDate", $startDate);
$smarty->assign("endDate", $endDate);

$smarty->assign('lang', $lang);
$smarty->assign('viewData', $data);
$smarty->assign('page', $page);
$smarty->assign('dictMapType', $dictMapType);
$smarty->assign('pageList', $pageList);
$smarty->assign('pageLine', $pageLine);
$smarty->assign('pageCount', $pageCount);
$smarty->assign('role', $role);
$smarty->assign('recordCount', $recordCount);
$smarty->display("module/copyscene/duobao_info_stat.tpl");
exit;

/**
 * @param $tmp 是否使用LIMIT
 */
function getCopySceneRecord($tmp,$where='',$order='',$startNum='',$record='',&$counts=''){
		$sql = " select `mtime`,`role_name`,`account_name`,`level`,`mapid`,`itime`,`otime`,`tbox`,`gitem`,`state` from `".T_LOG_DUOBAO."` where {$where}  and `state`=2 order by `account_name`,`mtime`";
		if(!empty($order)) {
			$sql .= " {$order} ";
		}
		if($tmp==1) {
			$sql.= " LIMIT {$startNum}, {$record} ";
		} 
		$result = GFetchRowSet($sql);
		$counts = GFetchRowOne("SELECT COUNT(`account_name`) as counts FROM `".T_LOG_DUOBAO."`  where {$where} and `state`=2 ");
		$counts = $counts['counts'];
		return $result;
}

function getTimeData($where) {
	$timeSql = "select `mtime`,`account_name`,`mapid`,`itime`,`otime`,`state` from ".T_LOG_DUOBAO." where {$where} order by `account_name`,`mtime`";
	$timeRs  = GFetchRowSet($timeSql);
	return $timeRs;
}

//副本时长(30分以内)
function transTotalTime($outTime, $enterTime) {
	$time = $outTime - $enterTime;
	$min  = floor($time /60);
	$sec  = floor(($time-strtotime($min))/60);
	return $arr = $min."分".$sec."秒";	
}







