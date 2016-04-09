<?php
/**
 * lingqi_output_and_usage.php
 * 
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_LANG . '/zh-cn.php';
global $lang;


$today = date( 'Y-m-d' );
$todayTimestamp = strtotime($today);

$openTimestamp = strtotime(ONLINEDATE);

if(isset($_REQUEST['startDate'])) {
	$startDate = SS($_REQUEST['startDate']);
} else {
	$startDate = date('Y-m-d', $todayTimestamp - 7*86400) ;
}
if(isset($_REQUEST['endDate'])) {
	$endDate = SS($_REQUEST['endDate']);
} else {
	$endDate = $today ;
}
if(isset($_REQUEST['roleName'])){
	$roleName = SS($_REQUEST['roleName']);
}

$startDateTimestamp = strtotime($startDate);
$endDateTimestamp = strtotime($endDate." 23:59:59");

if($startDateTimestamp < $openTimestamp){
	$startDate = ONLINEDATE;
	$startDateTimestamp = strtotime($startDate);
}
if($endDateTimestamp > $todayTimestamp) {
	$endDate = $today ;
	$endDateTimestamp = strtotime($endDate." 23:59:59");
}


$timeCond = " mtime >= $startDateTimestamp AND mtime < $endDateTimestamp ";

$outputCond = " lingqi > 0 AND $timeCond ";
$expendCond = " lingqi < 0 AND $timeCond ";

$lingqiOutput = array();
//灵气产出
//$lingqiOutput = array( 'all' => '',	'sit' => '',	'other' => '',);
//
$sqlAllOutput = "select from_unixtime(mtime,'%Y-%m-%d') as date,sum(lingqi) sum_lingqi from t_log_lingqi where $outputCond  group by year,month,day";
$output_all = GFetchRowSet($sqlAllOutput);
insertIntoArray($lingqiOutput, $output_all, "all");

$sqlSitOutput = "select from_unixtime(mtime,'%Y-%m-%d') as date,sum(lingqi) sum_lingqi from t_log_lingqi where $outputCond and type=40005 group by year,month,day";
$output_sit = GFetchRowSet($sqlSitOutput);
insertIntoArray($lingqiOutput, $output_sit, "sit");

$sqlOtherOutput = "select from_unixtime(mtime,'%Y-%m-%d') as date,sum(lingqi) sum_lingqi from t_log_lingqi where $outputCond and type not in (40005) group by year,month,day";
$output_other = GFetchRowSet($sqlOtherOutput);
insertIntoArray($lingqiOutput, $output_other, "other");

//填0
foreach($lingqiOutput as $k => $v){
	if(!isset($v['sit'])){
		$lingqiOutput[$k]['sit'] = 0;
	}
	if(!isset($v['other'])){
		$lingqiOutput[$k]['other'] = 0;
	}
}

//灵气消耗
//$lingqiExpend = array('all' => '',	'jingjieUpgrade' => '',	'other' => '',);

$lingqiExpend = array();

$sqlAllExpend = "select from_unixtime(mtime,'%Y-%m-%d') as date,sum(lingqi) sum_lingqi from t_log_lingqi where $expendCond group by year,month,day";
$expend_all = GFetchRowSet($sqlAllExpend);
insertIntoArray($lingqiExpend, $expend_all, "all");


$sqlJingjieExpend = "select from_unixtime(mtime,'%Y-%m-%d') as date,sum(lingqi) sum_lingqi from t_log_lingqi where $expendCond and type in (40048,40049,40050) group by year,month,day";
$expend_jingjie = GFetchRowSet($sqlJingjieExpend);
insertIntoArray($lingqiExpend, $expend_jingjie, "jingjieUpgrade");


$sqlOtherExpend = "select from_unixtime(mtime,'%Y-%m-%d') as date,sum(lingqi) sum_lingqi from t_log_lingqi where $expendCond and type not in (40048,40049,40050) group by year,month,day";
$expend_other = GFetchRowSet($sqlOtherExpend);
insertIntoArray($lingqiExpend, $expend_other, "other");

//填0
foreach($lingqiExpend as $k => $v){
	if(!isset($v['jingjieUpgrade'])){
		$lingqiExpend[$k]['jingjieUpgrade'] = 0;
	}
	if(!isset($v['other'])){
		$lingqiExpend[$k]['other'] = 0;
	}
}


$data = array();
$data['lingqiOutput'] = $lingqiOutput;
$data['lingqiExpend'] = $lingqiExpend;

//print_r($data);

$minDate = ONLINEDATE ;
$maxDate = $today;

$smarty->assign('startDate',$startDate);
$smarty->assign("endDate",$endDate);
$smarty->assign("minDate",$minDate);
$smarty->assign("maxDate",$maxDate);
$smarty->assign("lang",$lang);
$smarty->assign("data",$data);
$smarty->display("module/lingqi/lingqi_output_and_expend.tpl");

function insertIntoArray(&$array, $data, $key){
	foreach($data as $k => $v){
		if(is_array($v)){
			$array[$v['date']][$key] = ($v['sum_lingqi']?$v['sum_lingqi']:0 );
		}
	}
}