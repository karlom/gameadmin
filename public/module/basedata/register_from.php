<?php
/**
 * register_from.php
 * 联盟推量渠道注册统计
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';

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

$startTime = strtotime($startDate);
$endTime = strtotime($endDate." 23:59:59");

//日期范围内注册
$sql = "select SUBSTRING_INDEX(pf, '*', 1) as opf, count(*) as cnt from t_log_register where pf like 'union-10086-%' and mtime>={$startTime} and mtime<{$endTime} group by opf";
$viewData = GFetchRowSet($sql);

//付费
$sql = "select r.opf as opf, sum(b.cost) as totalCost 
	from 
	(select SUBSTRING_INDEX(pf, '*', 1) as opf, account_name from t_log_register where pf like 'union-10086-%' group by account_name ) r,
	(select account_name,round(sum(total_cost + pubacct + amt/10)) as cost  from t_log_buy_goods where mtime>={$startTime} and mtime<{$endTime} group by account_name ) b
	where r.account_name = b.account_name
	group by r.opf";
$viewDataPay = GFetchRowSet($sql);

//留存
//起始日注册
$de = $startTime + 86400;
$ds2 = $de;
$de2 = $ds2 + 86400;
$ds7 = $startTime + 86400*6;
$de7 = $ds7 + 86400;
$sqlReg = "select SUBSTRING_INDEX(pf, '*', 1) as opf,count(*) as reg_cnt from t_log_register where pf like 'union-10086-%' and mtime>={$startTime} and mtime<{$de} group by opf";
$regData = GFetchRowSet($sqlReg);
//次日登录
$sqlStay2 = "select r.opf as opf, count(r.account_name ) as login_cnt
	from 
	(select SUBSTRING_INDEX(pf, '*', 1) as opf, account_name from t_log_register where pf like 'union-10086-%' and mtime>={$startTime} and mtime<{$de} group by account_name ) r,
	(select account_name  from t_log_login where mtime>={$ds2} and mtime<{$de2} group by account_name ) b
	where r.account_name = b.account_name
	group by r.opf";
$viewDataStay2 = GFetchRowSet($sqlStay2);
//7日登录
$sqlStay7 = "select r.opf as opf, count(r.account_name ) as login_cnt
	from 
	(select SUBSTRING_INDEX(pf, '*', 1) as opf, account_name from t_log_register where pf like 'union-10086-%' and mtime>={$startTime} and mtime<{$de} group by account_name ) r,
	(select account_name  from t_log_login where mtime>={$ds7} and mtime<{$de7} group by account_name ) b
	where r.account_name = b.account_name
	group by r.opf";
$viewDataStay7 = GFetchRowSet($sqlStay7);

if(!empty($regData)){
	foreach($regData as $k => $v ){
		if(!empty($viewDataStay2)){
			foreach($viewDataStay2 as $j => $w ){
				if($w['opf'] == $v['opf']) {
					$regData[$k]['login2'] = $w['login_cnt'];
					$regData[$k]['rate2'] = $v['reg_cnt'] ? round($w['login_cnt']/$v['reg_cnt']*100,2) : 0;
				}
			}
		}
		if(!empty($viewDataStay7)){
			foreach($viewDataStay7 as $j => $w ){
				if($w['opf'] == $v['opf']) {
					$regData[$k]['login7'] = $w['login_cnt'];
					$regData[$k]['rate7'] = $v['reg_cnt'] ? round($w['login_cnt']/$v['reg_cnt']*100,2) : 0;
				}
			}
		}
	}
}

//$minDate = ONLINEDATE;
$minDate = '2014-05-01';
$maxDate = Datatime :: getTodayString();
$smarty->assign("minDate", $minDate);
$smarty->assign("maxDate", $maxDate);
$smarty->assign("startDate", $startDate);
$smarty->assign("endDate", $endDate);

$smarty->assign('lang', $lang);
$smarty->assign('dictAppCustom', $dictAppCustom);
$smarty->assign('viewData', $viewData);
$smarty->assign('viewDataPay', $viewDataPay);
$smarty->assign('viewDataStay', $regData);
$smarty->display('module/basedata/register_from.tpl');
