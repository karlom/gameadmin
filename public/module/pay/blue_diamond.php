<?php
/**
 * blue_diamond.php
 * Author: huanghaiqing
 * Create on 2014-8-21 05:15:16
 * 蓝钻开通统计
 */
 
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';

$roleName = $_POST['role_name'] ; 
$accountName = $_POST['account_name'] ; 

$lookingday = $_POST['lookingday'];

$today = date("Y-m-d");

//获取时间段
if (! isset ( $_POST ['starttime'] )){
    $dateStart = Datatime::getPrevWeekString ();
}else{
    $dateStart = SS ( $_POST ['starttime'] );
}

$dateStart = (strtotime($dateStart) >= strtotime(ONLINEDATE)) ? $dateStart : ONLINEDATE;
$dateEnd = ! isset ($_POST['endtime']) ? Datatime::getTodayString() :  SS ($_POST['endtime']);

if( !empty($_POST['today']) ) {
	$dateStart = $dateEnd = $today;
}
if( !empty($_POST['all']) ) {
	$dateStart = ONLINEDATE;
	$dateEnd = $today;
}

if(!empty($_POST['preday'])){
	$dateStart = $dateEnd = date("Y-m-d", strtotime($dateStart)-86400 );
}
if(!empty($_POST['nextday'])){
	$dateStart = $dateEnd = date("Y-m-d", strtotime($dateEnd)+86400 );
}

$dateStartTamp = strtotime($dateStart." 0:0:0");
$dateEndTamp = strtotime($dateEnd." 23:59:59");

if($dateStartTamp < strtotime(ONLINEDATE)){
	$dateStart = ONLINEDATE;
}
if( $dateStartTamp > strtotime($today) ){
	$dateStart = $today;
}

if($dateEndTamp > strtotime($today) ){
	$dateEnd = $today;
}
if($dateEndTamp < strtotime(ONLINEDATE)){
	$dateEnd = ONLINEDATE;
}

$dateStartTamp = strtotime($dateStart." 0:0:0");
$dateEndTamp = strtotime($dateEnd." 23:59:59");


$where = " mtime>={$dateStartTamp} AND mtime<={$dateEndTamp} ";
$where2 = $where;
if($roleName) {
	$where .= " AND role_name='{$roleName}' ";
}
if($accountName) {
	$where .= " AND account_name='{$accountName}' ";
}
$record = $_POST['record'] ? SS($_POST['record']) : LIST_PER_PAGE_RECORDS;

$counts = 0;//总记录
$pageno = getUrlParam('page');//设置初始页
$startNum = ($pageno - 1) * $record; //每页开始位置
$viewData = getBlueVipData($where, $startNum, $record, $counts);

$pageCount = ceil ( $counts/$record );
$pagelist = getPages($pageno, $counts,$record);

$statisticsData = getStatisticsData($where2);

$lookingday = $dateEnd;
$maxDate = date ( "Y-m-d" );
$data = array(
    'dateStart' => $dateStart,
    'dateEnd' => $dateEnd,
    'minDate' => ONLINEDATE,
    'maxDate' => $maxDate,
    'role_name' => $roleName,
    'account_name' => $accountName,
    'lookingday' => $lookingday,
    
    'counts' => $counts,
    'record' => $record,
    'pagelist' => $pagelist,
    'pageCount' => $pageCount,
    'pageno' => $pageno,
    
    'lang' => $lang,
    'viewData' => $viewData,
    'statisticsData' => $statisticsData,
);


$smarty->assign ($data);
$smarty->display("module/pay/blue_diamond.tpl");


function getBlueVipData($where,$startNum,$record,&$counts) {
	
	$sqlBlueVipCount = "select count(*) as cnt from  t_log_open_vip2 where {$where} ";
	$result = GFetchRowOne($sqlBlueVipCount);
	$counts = $result['cnt'];
	
	$sqlBlueVip = "select * from t_log_open_vip2  where {$where} order by mtime desc limit {$startNum},{$record} ";
	$result = GFetchRowSet($sqlBlueVip);
	return $result;
}

function getStatisticsData($where){
	//总
	//开通
	$sql01 = "select count(distinct uuid ) as open_pt_count from t_log_open_vip2  where isYear=0 AND blue=0"; //总普通开通
	$sql02 = "select count(distinct uuid ) as open_year_count from t_log_open_vip2 where isYear=1 AND blueYear=0"; //总年费开通
	$sql01Result = GFetchRowOne($sql01);
	$sql02Result = GFetchRowOne($sql02);
	
	//续费人数
	$sql03 = "select count(distinct uuid ) as renew_pt_role_count from t_log_open_vip2  where isYear=0 AND blue=1 ";//总普通续费
	$sql04 = "select count(distinct uuid ) as renew_year_role_count from t_log_open_vip2  where isYear=1 AND blueYear=1 ";//总年费续费
	$sql03Result = GFetchRowOne($sql03);
	$sql04Result = GFetchRowOne($sql04);
	
	//续费次数
	$sql05 = "select count(*) as renew_pt_count from t_log_open_vip2  where isYear=0 AND blue=1 ";
	$sql06 = "select count(*) as renew_year_count from t_log_open_vip2  where isYear=1 AND blueYear=1 ";
	$sql05Result = GFetchRowOne($sql05);
	$sql06Result = GFetchRowOne($sql06);

	//最高单日开通次数
	$sql07 = "select mtime,year,month,day,count(*) as count from t_log_open_vip2  where (blue=0 AND isYear=0) or (blueYear=0 AND isYear=1 ) group by year, month, day";
	$sql07Result = GFetchRowSet($sql07);
	$maxOpen = array( "count" => 0, "date" => "-");
	if(!empty($sql07Result)) {
		foreach($sql07Result as $k => $v){
			if($v['count'] > $maxOpen['count']) {
				$maxOpen['count'] = $v['count'];
				$maxOpen['date'] = date("Y-m-d", $v['mtime']);
			}
		}
	}
	
	//最高单日续费次数
	$sql08 = "select mtime,year,month,day,count(*) as count from t_log_open_vip2  where (blue=1 AND isYear=0) or (blueYear=1 AND isYear=1 )  group by year, month, day";
	$sql08Result = GFetchRowSet($sql08);
	$maxRenew = array( "count" => 0, "date" => "-");
	if(!empty($sql08Result)) {
		foreach($sql08Result as $k => $v){
			if($v['count'] > $maxOpen['count']) {
				$maxRenew['count'] = $v['count'];
				$maxRenew['date'] = date("Y-m-d", $v['mtime']);
			}
		}
	}
	
	//最高单人单日续费次数
	$sql09 = "select mtime,year,month,day,uuid, account_name, role_name, count(*) as count from t_log_open_vip2  where (blue=1 AND isYear=0) or (blueYear=1 AND isYear=1 )  group by year, month, day,uuid";
	$sql09Result = GFetchRowSet($sql09);
	$maxRoleRenew = array( "count" => 0, "date" => "-", "role_name"=> "=", );
	if(!empty($sql09Result)) {
		foreach($sql09Result as $k => $v){
			if($v['count'] > $maxRoleRenew['count']) {
				$maxRoleRenew['count'] = $v['count'];
				$maxRoleRenew['date'] = date("Y-m-d", $v['mtime']);
				$maxRoleRenew['role_name'] = $v['role_name'];
			}
		}
	}
	
	//日期范围内
	//开通
	$sql11 = "select count(distinct uuid ) as open_pt_count from t_log_open_vip2  where {$where} AND isYear=0 AND blue=0";
	$sql12 = "select count(distinct uuid ) as open_year_count from t_log_open_vip2  where {$where} AND isYear=1 AND blueYear=0";
	$sql11Result = GFetchRowOne($sql11);
	$sql12Result = GFetchRowOne($sql12);
	//续费人数
	$sql13 = "select count(distinct uuid ) as renew_pt_role_count from t_log_open_vip2  where {$where} AND isYear=0 AND blue=1 ";
	$sql14 = "select count(distinct uuid ) as renew_year_role_count from t_log_open_vip2  where {$where} AND isYear=1 AND blueYear=1 ";
	$sql13Result = GFetchRowOne($sql13);
	$sql14Result = GFetchRowOne($sql14);
	//续费次数
	$sql15 = "select count(*) as renew_pt_count from t_log_open_vip2  where {$where} AND isYear=0 AND blue=1 ";
	$sql16 = "select count(*) as renew_year_count from t_log_open_vip2 where {$where} AND isYear=1 AND blueYear=1 ";
	$sql15Result = GFetchRowOne($sql15);
	$sql16Result = GFetchRowOne($sql16);
	
	$data = array(
		"all" => array(
			"open_pt_count" => $sql01Result['open_pt_count'] ? $sql01Result['open_pt_count'] : 0,
			"open_year_count" => $sql02Result['open_year_count'] ? $sql02Result['open_year_count'] : 0,
			"renew_pt_role_count" => $sql03Result['renew_pt_role_count'] ? $sql03Result['renew_pt_role_count'] : 0,
			"renew_year_role_count" => $sql04Result['renew_year_role_count'] ? $sql04Result['renew_year_role_count'] : 0,
			"renew_pt_count" => $sql05Result['renew_pt_count'] ? $sql05Result['renew_pt_count'] : 0,
			"renew_year_count" => $sql06Result['renew_year_count'] ? $sql06Result['renew_year_count'] : 0,
			"maxOpen" => $maxOpen,
			"maxRenew" => $maxRenew,
			"maxRoleRenew" => $maxRoleRenew,
		),
		"date" => array(
			"open_pt_count" => $sql11Result['open_pt_count'] ? $sql11Result['open_pt_count'] : 0,
			"open_year_count" => $sql12Result['open_year_count'] ? $sql12Result['open_year_count'] : 0,
			"renew_pt_role_count" => $sql13Result['renew_pt_role_count'] ? $sql13Result['renew_pt_role_count'] : 0,
			"renew_year_role_count" => $sql14Result['renew_year_role_count'] ? $sql14Result['renew_year_role_count'] : 0,
			"renew_pt_count" => $sql15Result['renew_pt_count'] ? $sql15Result['renew_pt_count'] : 0,
			"renew_year_count" => $sql16Result['renew_year_count'] ? $sql16Result['renew_year_count'] : 0,
		),
	);
	return $data;
}