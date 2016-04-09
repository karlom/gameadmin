<?php
/**
 * all_server_pay.php
 * Author: Libiao
 * Create on 2013-11-16 13:56:07
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';

$this_day_time = GetTime_Today0();
$cur_day_time = $this_day_time - 86400 ;
$now = time();

if (! isset($_REQUEST['dateStart'])) {
	$dateStart = date('Y-m-d');
} else {
	$dateStart = $_REQUEST['dateStart'];
}


$startTime = strtotime($dateStart);
$endTime = strtotime($dateStart . "23:59:59");

$viewData = array();

$sqlList = "select name, dbname from t_server_config where available=1 order by id desc";
$dbList = IFetchRowSet($sqlList);

if(PROXY == 'qq'){
	$payTable = "t_log_buy_goods";
	$needTotalCost = 'round(sum(t1.total_cost + t1.pubacct + t1.amt/10))';
} else {
	$payTable = "t_log_pay";
	$needTotalCost = 'sum(amt)';
}

if(!empty($dbList)){
	foreach($dbList as $k => $v){
		$dbname=$v['dbname'];
		
		$viewData[$dbname]['server'] = $v['name'];
		$viewData[$dbname]['db'] = $dbname;
		
		//充值
		$sql = "select $needTotalCost as totalCost from (select * from {$dbname}.$payTable where mtime>={$startTime} and mtime<{$endTime} group by billno) t1 ";
		$result = IFetchRowOne($sql);

		$viewData[$dbname]['pay'] = $result['totalCost']?$result['totalCost']:0;

		//登录请求
		$sql = "select count(distinct account_name) as totalRequest from {$dbname}.t_log_create_loss where mtime>={$startTime} and mtime<{$endTime} and step=0 ";
		$result2 = IFetchRowOne($sql);

		$viewData[$dbname]['totalRequest'] = $result2['totalRequest']?$result2['totalRequest']:0;
		
		//付费人数，次数
		$sql = "select count(distinct t1.uuid) as payUserCount, count(t1.id) as payCount from (select * from {$dbname}.$payTable where mtime>={$startTime} and mtime<{$endTime} group by billno) t1 ";
		$result3 = IFetchRowOne($sql);
		
		$viewData[$dbname]['payUserCount'] = $result3['payUserCount']?$result3['payUserCount']:0;
		$viewData[$dbname]['payCount'] = $result3['payCount']?$result3['payCount']:0;

		//从任务集市进来的人数
		$sql = "select count(distinct R.uuid) as contract from {$dbname}.t_log_login L, {$dbname}.t_log_register R where L.uuid=R.uuid and R.mtime>={$startTime} and R.mtime<{$endTime} and L.contract_id<>'' ";
		$result4 = IFetchRowOne($sql);

		$viewData[$dbname]['contract'] = $result4['contract']?$result4['contract']:0;

		//在线人数
		$sql = "select online from {$dbname}.t_log_online order by mtime desc limit 1";
		$result5 = IFetchRowOne($sql);

		$viewData[$dbname]['online'] = $result5['online']?$result5['online']:0;

		//注册人数
		$sql = "select count(distinct uuid) as totalRegister from {$dbname}.t_log_register where mtime>={$startTime} and mtime<{$endTime}";
		$result6 = IFetchRowOne($sql);

		$viewData[$dbname]['totalRegister'] = $result6['totalRegister']?$result6['totalRegister']:0;

		//活跃人数，登录过的人数
		$sql = "select count(distinct uuid) as totalLogin from {$dbname}.t_log_login where mtime>={$startTime} and mtime<{$endTime}";
		$result6 = IFetchRowOne($sql);

		$viewData[$dbname]['totalLogin'] = $result6['totalLogin']?$result6['totalLogin']:0;

		//从任务集市进来玩家的消费情况：人数、金额(Q点)
		$sql = "select count(distinct t1.uuid) as roleCount, $needTotalCost as totalCost " .
				"from " .
				" (select * from {$dbname}.$payTable where mtime>={$startTime} and mtime<{$endTime} group by billno) t1, " .
				" (select distinct uuid from {$dbname}.t_log_login where contract_id<>'' ) t2 " .
				" where t1.uuid=t2.uuid ";
		$result7 = IFetchRowOne($sql);

		$viewData[$dbname]['taskPayUser'] = $result7['roleCount']?$result7['roleCount']:0;
		$viewData[$dbname]['taskPay'] = $result7['totalCost']?$result7['totalCost']:0;

		//从游戏大厅进来的人数
		$sql = "select count(distinct R.uuid) as qqgame from {$dbname}.t_log_login L, {$dbname}.t_log_register R where L.uuid=R.uuid and R.mtime>={$startTime} and R.mtime<{$endTime} and L.pf='qqgame' ";
		$result8 = IFetchRowOne($sql);

		$viewData[$dbname]['qqgame'] = $result8['qqgame']?$result8['qqgame']:0;

	}
}

$totalPay = 0;
$totalRequest = 0;
$totalPayUserCount = 0;
$totalPayCount = 0;
$totalFromTaskCount = 0;
$totalOnline = 0;
$totalRegister = 0;
$totalLogin = 0;
$totalTaskPayUser = 0;
$totalTaskPay = 0;

if(!empty($viewData)){
	foreach($viewData as $db => $value){
		$totalPay += $value['pay'];
		$totalRequest += $value['totalRequest'];
		$totalPayUserCount += $value['payUserCount'];
		$totalPayCount += $value['payCount'];
		$totalFromTaskCount += $value['contract'];
		$totalOnline += $value['online'];
		$totalRegister += $value['totalRegister'];
		$totalLogin += $value['totalLogin'];
		$totalTaskPayUser += $value['taskPayUser'];
		$totalTaskPay += $value['taskPay'];
		$totalFromQQgame += $value['qqgame'];
	}	
}
$totalData = array(
	"totalPay" => $totalPay,
	"totalRequest" => $totalRequest,
	"totalPayUserCount" => $totalPayUserCount,
	"totalPayCount" => $totalPayCount,
	"totalFromTaskCount" => $totalFromTaskCount,
	"totalOnline" => $totalOnline,
	"totalRegister" => $totalRegister,
	"totalLogin" => $totalLogin,
	"totalTaskPay" => $totalTaskPay,
	"totalTaskPayUser" => $totalTaskPayUser,
	"totalFromQQgame" => $totalFromQQgame,
);

$smarty->assign("viewData", $viewData);
$smarty->assign("totalData", $totalData);
$smarty->assign("dateStart", $dateStart);
$smarty->assign("lang", $lang);
$smarty->display("module/pay/all_server_pay.tpl");