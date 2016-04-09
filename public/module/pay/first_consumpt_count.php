<?php
/**
 * first_consumpt_count.php
 * 首充礼包领取计数
 * Author: Libiao
 * Create on 2014-01-20 13:56:07
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';

$this_day_time = GetTime_Today0();
$cur_day_time = $this_day_time - 86400 ;
$now = time();

if (! isset($_REQUEST['dateStart'])) {
	$dateStart = date('Y-m-d', $now - 6*86400);
} else {
	$dateStart = $_REQUEST['dateStart'];
}
if( strtotime($dateStart) < strtotime(ONLINEDATE) ) {
	$dateStart = ONLINEDATE;
}

if (! isset($_REQUEST['dateEnd'])) {
	$dateEnd = date('Y-m-d');
} else {
	$dateEnd = $_REQUEST['dateEnd'];
}
if( strtotime($dateEnd) < strtotime(ONLINEDATE) ) {
	$dateEnd = ONLINEDATE;
}


//$startTime = strtotime($dateStart);
//$endTime = strtotime($dateEnd . "23:59:59");

$viewData = array();
$viewData = get_first_consumpt_data($dateStart, $dateEnd);



$smarty->assign("viewData", $viewData);
$smarty->assign("dateStart", $dateStart);
$smarty->assign("dateEnd", $dateEnd);
$smarty->assign("minDate", ONLINEDATE);
$smarty->assign("maxDate", date("Y-m-d"));
$smarty->assign("lang", $lang);
$smarty->display("module/pay/first_consumpt_count.tpl");

function get_first_consumpt_data($startDate, $endDate){
	$startTime = strtotime($startDate. " 00:00:00");
	$endTime = strtotime($endDate. " 23:59:59");
	
	$data = array();
	
	$item1 = "23006";
	$op1 = "10100";
	
	$item2 = "20245";
	$op2 = "10143";
	
	//1重充值礼包 23006 对应操作码10100
	//concat(year, '-' ,month,'-' , day) as mdate,
	$sql = "select  from_unixtime(mtime, '%Y-%m-%d') as mdate, count(*) as cnt from t_log_item where item_id={$item1} and item_num>0 and type={$op1} and mtime>={$startTime} and mtime<={$endTime} group by year,month,day ";
	$ret = IBFetchRowSet($sql);
	
//	$data['consumpt1'] = $ret['cnt'] ? $ret['cnt'] : 0;
	if(!empty($ret)){
		foreach($ret as $k => $v){
			$date = $v['mdate'];
			$data[$date]['date'] = $v['mdate'];
			$data[$date]['consumpt1'] = $v['cnt'];
		}
	}
	
	//2重充值礼包 20245 对应操作码10143
	$sql = "select  from_unixtime(mtime, '%Y-%m-%d') as mdate, count(*) as cnt from t_log_item where item_id={$item2} and item_num>0 and type={$op2} and mtime>={$startTime} and mtime<={$endTime}  group by year,month,day ";
	$ret = IBFetchRowSet($sql);
	
//	$data['consumpt2'] = $ret['cnt'] ? $ret['cnt'] : 0;
	if(!empty($ret)){
		foreach($ret as $k => $v){
			$date = $v['mdate'];
			$data[$date]['date'] = $v['mdate'];
			$data[$date]['consumpt2'] = $v['cnt'];
		}
	}
	
	if(!empty($data)){
		foreach($data as $k => $v){
			$data[$k]['consumpt1'] = $data[$k]['consumpt1'] ? $data[$k]['consumpt1'] : 0 ;
			$data[$k]['consumpt2'] = $data[$k]['consumpt2'] ? $data[$k]['consumpt2'] : 0 ;
		}
	}
	
	
	return $data;
}
