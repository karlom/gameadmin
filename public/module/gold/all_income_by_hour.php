<?php
include_once "../../../protected/config/config.php";
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';
global $lang;
if ( !isset($_POST['starttime'])){
	$dateStart = date('Y-m-d');
}else{
	$dateStart  = trim(SS($_POST['starttime']));
}


$todayStamp = strtotime($dateStart . ' 0:0:0');
$yesterdayStamp = $todayStamp-86400;
$day7Stamp = $todayStamp-86400*7;

$dateStartStr = strftime ("%Y-%m-%d", $todayStamp);

$today = getSqlData($todayStamp);
$yesterday = getSqlData($yesterdayStamp);
$day7 = getSqlData($day7Stamp);

$grap_data = array();
$grap_data[date ("Y-n-j", $todayStamp)] = $today;
$grap_data[date ("Y-n-j", $yesterdayStamp)] = $yesterday;
$grap_data[date ("Y-n-j", $day7Stamp)] = $day7;

$totalCost = 0;
	for($i=0; $i<24; $i++){
    	$totalCost += $today[$i];
	}

$maxdate = date("Y-m-d", strtotime('-1day'));

$smarty->assign("mindate", 0);
$smarty->assign("maxdate", $maxdate);

$smarty->assign("startDate", $dateStartStr);
$smarty->assign("endDate", $dateEndStr);
$smarty->assign("maxdate", $maxdate);
$smarty->assign("lang",$lang);
$smarty->assign("totalCost", $totalCost);
$smarty->assign("grap_data", $grap_data);

$smarty->display("module/gold/all_income_by_hour.tpl");
exit;
//////////////////////////////////////////////////////////////
/*
function getAllRegCount()
{
	$sql = "SELECT COUNT(uuid) as c FROM `".T_LOG_REGISTER."`";
	$arr = GFetchRowOne($sql);
	return intval($arr['c']);
}

function getSqlData($startTime, $endTime, $dateType){

    	$select = "`year`,  `month`,`day`,  `hour`, ";
		$groupby = "`year`,`month`,`day`,`hour`";


	$sql = "SELECT {$select}"
		 . " COUNT(`uuid`) as c FROM `".T_LOG_REGISTER."` "
		 . " WHERE `mtime`>={$startTime} AND `mtime`<={$endTime} "
		 . " GROUP BY {$groupby} WITH ROLLUP" ;
	$result = GFetchRowSet($sql);
	return $result;
}*/
	
function getSqlData($startTime){
	$endTime = $startTime+86400;
	$sqlList = "select name, dbname from t_server_config where available=1 order by id desc";
	$dbList = IFetchRowSet($sqlList);
	$day = array();
	for($i=0; $i<24; $i++){
    	$day[$i] = 0;
	}
	if(!empty($dbList)){
		foreach($dbList as $k => $v){
			$dbname=$v['dbname'];
			
			//充值
			$sql = "select `hour`,round(sum(t1.total_cost + t1.pubacct + t1.amt/10)) as cost from (select * from {$dbname}.t_log_buy_goods where mtime>={$startTime} and mtime<{$endTime} group by billno) t1 GROUP BY `year`,`month`,`day`,`hour`";	//t_log_buy_good
			$result = IFetchRowSet($sql);
			
            foreach($result as $row){
                $day[$row['hour']] += $row['cost'];
            }
		}
	}
	return $day;
}