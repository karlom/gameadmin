<?php

/**
 * 单服概况
 * Author: libiao                      
 * 2013-10-09 
 *
 */
include_once "../../../protected/config/config.php";
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';
global $lang;

$this_day_time = GetTime_Today0();
$cur_day_time = $this_day_time - 86400 ;
$now = time();

if (! isset($_REQUEST['dateStart'])) {
//	$dateStart = date('Y-m-d', strtotime("-13day")); 	//默认两周
	$dateStart = date('Y-m-d'); 	//默认两周
} elseif ($_REQUEST['dateStart'] == 'ALL') {
	$dateStart = ONLINEDATE;
} else {
	$dateStart = $_REQUEST['dateStart'];
}

if (! isset($_REQUEST['dateEnd'])) {
	$dateEnd = strftime("%Y-%m-%d", time());
} elseif ($_REQUEST['dateEnd'] == 'ALL') {
	$dateEnd = strftime("%Y-%m-%d", time());
} else {
	$dateEnd = strtotime($_REQUEST['dateEnd']) > time() ? strftime("%Y-%m-%d", time()) : $_REQUEST['dateEnd'];
}

$dateStartStamp = strtotime($dateStart . ' 0:0:0');
$dateEndStamp = strtotime($dateEnd . ' 23:59:59');

$dateStartStamp = intval($dateStartStamp) > 0 ? intval($dateStartStamp) : strtotime(ONLINEDATE);
$dateEndStamp = intval($dateEndStamp) > 0 ? intval($dateEndStamp) : strtotime(ONLINEDATE);

$openTimestamp = strtotime( ONLINEDATE );
if($dateStartStamp < $openTimestamp)
{
	$dateStartStamp = $openTimestamp;
	$dateStart = ONLINEDATE;
}

$dateStartStr = strftime("%Y-%m-%d", $dateStartStamp);
$dateEndStr = strftime("%Y-%m-%d", $dateEndStamp);


$dateStrPrev = strftime("%Y-%m-%d", $dateStartStamp - 86400);
$dateStrToday = strftime("%Y-%m-%d");
$dateStrNext = strftime("%Y-%m-%d", $dateStartStamp + 86400);

$dateStartStamp = SS($dateStartStamp);
$dateEndStamp = SS($dateEndStamp);


if(PROXY == 'qq'){
	$payTable = "t_log_buy_goods";
	$needTotalCost = 'round(sum(total_cost + pubacct + amt/10))';
} else {
	$payTable = "t_log_pay";
	$needTotalCost = 'sum(amt)';
}


//$sqlAccount = " SELECT COUNT(`account_name`) AS `total_account`, COUNT(`role_name`) AS `total_role` FROM ".T_LOG_REGISTER." ";
//改成查创角色流失表来统计全服总帐号，总角色数
$sqlAccount = " SELECT COUNT(distinct `account_name`) AS `total_account`,`step` FROM ".T_LOG_CREATE_LOSS." group by `step` ";
$accountRs = GFetchRowSet($sqlAccount);
foreach($accountRs as $v) {
	if($v['step']==0){
		$totalAccount = $v['total_account'];
	} 
	if($v['step']==1){
		$totalRole = $v['total_account'];
	} 
}

$sqlRole = " SELECT MAX(`level`) AS `max_level` FROM  ".T_LOG_LEVEL_UP;
$roleRs = GFetchRowOne($sqlRole);
$roleMaxLevel = $roleRs['max_level'] ? $roleRs['max_level']:1;
$sqlRoleName= " SELECT `role_name` FROM ".T_LOG_LEVEL_UP." WHERE `level`=".$roleMaxLevel . " group by `uuid`";
$roleNameRs = GFetchRowSet($sqlRoleName);
//print_r($roleNameRs);
$roleNameStr = "";
foreach ( $roleNameRs as $k => $v ) {
       $roleNameStr .= $v['role_name'].",";
}

//付费人数
$sqlPayAccountCnt = "  SELECT COUNT( DISTINCT(`uuid`) ) AS `pay_account_cnt` 
					   FROM ".$payTable .
//					 " WHERE `ts`  BETWEEN {$dateStartStamp} AND {$dateEndStamp} " .
					 "";
$payAccountCntRs = GFetchRowOne($sqlPayAccountCnt);
$payAccountCnt = intval( $payAccountCntRs['pay_account_cnt'] ) ;

//总消耗Q点
$sqlAllTotalCost = "select $needTotalCost as totalCost from " . $payTable . "  ";
$sqlAllTotalCostResult = GFetchRowOne($sqlAllTotalCost);

$allPayCount = $sqlAllTotalCostResult['totalCost'] ? $sqlAllTotalCostResult['totalCost'] : 0;

//付费率（付费人数/注册人数）
$allPayRate = $totalRole ? round($payAccountCnt/$totalRole,4)*100 : 0;
//APRU值（元宝/付费人数/10）
$allArpu = $payAccountCnt? round($allPayCount/$payAccountCnt/10, 2) : 0 ;

$allArpu = (PROXY == 'qq') ? $allArpu : $allArpu*10;

//二次付费人数
$sqlAllSecPayRoleCount = "select count(*) as secPayCount from (select uuid,account_name,role_name,count(*) as cnt from " . $payTable . " group by uuid having cnt>=2 ) t1 ";
$sqlAllSecPayRoleCountResult = GFetchRowOne($sqlAllSecPayRoleCount);

$allSecondPayCount = $sqlAllSecPayRoleCountResult['secPayCount'] ? $sqlAllSecPayRoleCountResult['secPayCount'] : 0;

//二次付费率（二次付费人数/付费人数）
$allSecondPayRate = $payAccountCnt ? round($allSecondPayCount/$payAccountCnt, 4)*100 : 0 ;

//仙石使用数
$sqlAllXsCostCount = "select sum(gold) as xsCostCount from " . T_LOG_GOLD . " WHERE gold < 0 AND type <> 20019 ";
$sqlAllXsCostCountResult = GFetchRowOne($sqlAllXsCostCount);

$allXsCostCount = $sqlAllXsCostCountResult ? $sqlAllXsCostCountResult['xsCostCount'] : 0;

//消费的数据都是负数的，获取出来显示正数
$allXsCostCount = $sqlAllXsCostCountResult['xsCostCount'] ? -$sqlAllXsCostCountResult['xsCostCount'] : 0 ;	

//单日最高充值（消耗Q点）
$sqlAllMaxPay = "select  year,month,day,mtime, $needTotalCost as totalCost from " . $payTable . " group by year,month,day order by totalCost desc limit 1";
$sqlAllMaxPayResult = GFetchRowOne($sqlAllMaxPay);

$allMaxPay = array(
	'allMaxPay' => $sqlAllMaxPayResult ? $sqlAllMaxPayResult['totalCost'] : 0,
	'allMaxPayDate' => $sqlAllMaxPayResult ? date("Y-m-d", $sqlAllMaxPayResult['mtime'] ) : "-",
);

//单日最高在线
$sqlAllMaxOnline = "select  year,month,day,mtime, max(online) as online from " . T_LOG_ONLINE . " group by year,month,day order by online desc limit 1";
$sqlAllMaxOnlineResult = GFetchRowOne($sqlAllMaxOnline);

$allMaxOnline = array(
	'allMaxOnline' => $sqlAllMaxOnlineResult ? $sqlAllMaxOnlineResult['online'] : 0,
	'allMaxOnlineDate' => $sqlAllMaxOnlineResult ? date("Y-m-d", $sqlAllMaxOnlineResult['mtime'] ) : "-",
);




// ***** 选择时间内 start *****

//在线数据
$sqlOnline = " SELECT MAX(`online`) AS max_online, MAX(`mtime`) AS `date` 
			   FROM ".T_LOG_ONLINE. 
			  " WHERE `mtime`  BETWEEN {$dateStartStamp} AND {$dateEndStamp} ". 
			  " GROUP BY `year`,`month`,`day`  ".
			  " ORDER BY `date` ASC ";
$online = GFetchRowSet($sqlOnline);
//消费数据
$sqlPay = " SELECT $needTotalCost AS total_pay, `ts` AS `date` 
			FROM ".$payTable."" .
		" WHERE `ts`  BETWEEN {$dateStartStamp} AND {$dateEndStamp} " .
		" GROUP BY `year`,`month`,`day` ";

$pays = GFetchRowSet($sqlPay);

$payOnline = array();
$maxOnline = 0;
$maxPay = 0;
//$allTotalPay = 0;
$diffDay = intval( ($dateEndStamp - $dateStartStamp )/86400) + 1; //算出相差的天数
for ( $day = 0; $day < $diffDay; $day++ ){
	$curStamp = strtotime('+'.$day.'day',$dateStartStamp );
	
	//======= start =充值数据=========
	$flagPay = false;
	foreach ($pays as $key => &$rowPay) {
		if ($rowPay['date'] > $curStamp+86400 ) {
			break;
		}
		if (date('Y-m-d',$rowPay['date']) == date('Y-m-d',$curStamp) ) {
			$flagPay = true;
//			$allTotalPay +=  $rowPay['total_pay'];
			$maxPay = $rowPay['total_pay'] > $maxPay ? $rowPay['total_pay'] : $maxPay;
			$payOnline[$curStamp]['total_pay'] = (PROXY == 'qq') ? round($rowPay['total_pay']/10,1) : $rowPay['total_pay'];
			unset($pays[$key]);
			break;
		}
	}
	if (!$flagPay) {
		$payOnline[$curStamp]['total_pay'] = 0;
	}	
	//======= end =充值数据=========
	
	//======= start =在线数据=========
	$flagOnlie = false;
	foreach ($online as $key => &$rowOnline) {
		if ($rowOnline['date'] > $curStamp+86400 ) {
			break;
		}
		if (date('Y-m-d',$rowOnline['date']) == date('Y-m-d',$curStamp) ) {
			$flagOnlie = true;
			$payOnline[$curStamp]['max_online'] = $rowOnline['max_online'];
			$maxOnline = $rowOnline['max_online'] > $maxOnline ? $rowOnline['max_online'] : $maxOnline;
			unset($online[$key]);
			break;
		}
	}
	if (!$flagOnlie) {
		$payOnline[$curStamp]['max_online'] = 0;
	}
	//======= end =在线数据=========
}

//登陆人数
$sqlLoginCount = "select count(distinct uuid) as loginCount from " . T_LOG_LOGIN . " WHERE `mtime`  BETWEEN {$dateStartStamp} AND {$dateEndStamp} ";
$sqlLoginCountResult = GFetchRowOne($sqlLoginCount);

//创建角色数
$sqlRegisterCount = "select count(distinct uuid) as createRoleCount from " . T_LOG_REGISTER . " WHERE `mtime`  BETWEEN {$dateStartStamp} AND {$dateEndStamp} ";
$sqlRegisterCountResult = GFetchRowOne($sqlRegisterCount);

//创建角色并付费人数
$sqlRegister = "select distinct uuid from " . T_LOG_REGISTER . " WHERE `mtime`  BETWEEN {$dateStartStamp} AND {$dateEndStamp} ";
$sqlPay = "select distinct uuid from " . $payTable . " WHERE `mtime`  BETWEEN {$dateStartStamp} AND {$dateEndStamp} ";
$sqlRegisterAndPay = "select count(*) as newPayCount from ({$sqlRegister}) t1, ({$sqlPay}) t2 where t1.uuid=t2.uuid ";
$sqlRegisterAndPayResult = GFetchRowOne($sqlRegisterAndPay);

//最高在线人数
$sqlMaxOnline = "select max(online) as maxOnline from " . T_LOG_ONLINE . " WHERE `mtime`  BETWEEN {$dateStartStamp} AND {$dateEndStamp} ";
$sqlMaxOnlineResult = GFetchRowOne($sqlMaxOnline);

//总消耗Q点
$sqlTotalCost = "select $needTotalCost as totalCost from " . $payTable . " WHERE `mtime`  BETWEEN {$dateStartStamp} AND {$dateEndStamp} ";
$sqlTotalCostResult = GFetchRowOne($sqlTotalCost);

//付费人数
$sqlPayRoleCount = "select count(distinct uuid) as payRoleCount from " . $payTable . " WHERE `mtime`  BETWEEN {$dateStartStamp} AND {$dateEndStamp} ";
$sqlPayRoleCountResult = GFetchRowOne($sqlPayRoleCount);

//二次付费人数
$sqlSecPayRoleCount = "select count(*) as secPayCount from (select uuid,account_name,role_name,count(*) as cnt from " . $payTable . " WHERE `mtime`  BETWEEN {$dateStartStamp} AND {$dateEndStamp}  group by uuid having cnt>=2 ) t1 ";
$sqlSecPayRoleCountResult = GFetchRowOne($sqlSecPayRoleCount);

//仙石消耗数
$sqlXsCostCount = "select sum(gold) as xsCostCount from " . T_LOG_GOLD . " WHERE gold < 0 AND `mtime`  BETWEEN {$dateStartStamp} AND {$dateEndStamp} AND type <> 20019 ";
$sqlXsCostCountResult = GFetchRowOne($sqlXsCostCount);

$currentOnline = getOnlineCount();
$payUserOnline = getPayUserOnlineCount();

$arup = $sqlPayRoleCountResult['payRoleCount'] ? round($sqlTotalCostResult['totalCost']/($sqlPayRoleCountResult['payRoleCount']*10),2) :0;

$arup = (PROXY == 'qq') ? $arup : $arup*10;

$viewData = array(
	'loginCount' => $sqlLoginCountResult['loginCount'],
	'createRoleCount' => $sqlRegisterCountResult['createRoleCount'],
	'maxOnline' => $sqlMaxOnlineResult['maxOnline'],
	
	'payRoleCount' => $sqlPayRoleCountResult['payRoleCount'],
	'payRate' => $sqlLoginCountResult['loginCount'] ? round($sqlPayRoleCountResult['payRoleCount']/$sqlLoginCountResult['loginCount'], 4)*100 :0 ,	//付费率（付费人数/注册人数）
	'newPayCount' => $sqlRegisterAndPayResult['newPayCount'],
	'newPayRate' => $sqlRegisterCountResult['createRoleCount'] ? round($sqlRegisterAndPayResult['newPayCount']/$sqlRegisterCountResult['createRoleCount'],4)*100 : 0,
	'secPayCount' => $sqlSecPayRoleCountResult['secPayCount'],
	'secPayRate' => $sqlPayRoleCountResult['payRoleCount'] ? round($sqlSecPayRoleCountResult['secPayCount']/$sqlPayRoleCountResult['payRoleCount'] ,4)*100 :0,	//二次付费率（二次付费人数/付费人数）
	'arup' => $arup,
	
	'totalCost' => $sqlTotalCostResult['totalCost'],
	'xsCostCount' => -$sqlXsCostCountResult['xsCostCount'],
	
);
// ***** 选择时间内 end *****


$version = getVersion();

$data = array(
	'lang' => $lang,
	
	'agent' => PROXY,
	'agentId' => PROXYID,
	'areaName'=> $_SESSION['gameAdminServer'],
	
	'serverOnlineDay' => ONLINEDATE,
	'hasOnlineDay' => intval( ( time()-strtotime(ONLINEDATE) ) / 86400 ) ,
	'version' => $version,
	
	'totalAccount' => $totalAccount,
	'totalRole' => $totalRole,
	'roleMaxLevel' => $roleMaxLevel,
	'maxLevelRoleNames' => $roleNameStr,
	
	'allArpu' => $allArpu,
	'payAccountCnt' => $payAccountCnt,
	'allPayRate' => $allPayRate,
	
	'allPayCount' => $allPayCount,
	'allSecondPayCount' => $allSecondPayCount,
	'allSecondPayRate' => $allSecondPayRate,
	
	'allXsCostCount' => $allXsCostCount,
	'allMaxPay' => $allMaxPay,
	'allMaxOnline' => $allMaxOnline,
	
	'maxOnline' => $maxOnline,
	'maxPay' => round($maxPay,1),
	'maxPayMoney' => (PROXY == 'qq') ? round($maxPay/10,1): $maxPay,
//	'allTotalPay'=>round($allTotalPay,1),
	'dateStart' =>  $dateStartStr,
	'dateEnd' =>  $dateEndStr,
	'dateStrPrev' =>  $dateStrPrev,
	'dateStrNext' =>  $dateStrNext,
	'dateStrToday' =>  $dateStrToday,
	'diffDay'=>$diffDay,
	'payOnline' => $payOnline,
	
	'currentOnline' => $currentOnline,
	'payUserOnline' => $payUserOnline,
);
$smarty->assign($data);
$smarty->assign('viewData', $viewData);
$smarty->display("module/pay/survey.tpl");
exit;

function getVersion(){
	global $serverList;
	$serverId = isset($_SESSION['gameAdminServer']) ? ltrim($_SESSION['gameAdminServer'], "s") : -1;
	
    if($entranceUrl = $serverList[$_SESSION['gameAdminServer']]['url']){
    	$timestamp = time();
    	$key = urlencode(md5($timestamp.ADMIN_GAME_AUTH_KEY));
		$params = "timestamp={$timestamp}&key={$key}";
		
		$apiUrl = $entranceUrl."api/getClientVars.php";
		$clientVars = curlPost($apiUrl, $params);
		$clientVars = json_decode($clientVars, true);
		if($clientVars['result'] && $clientVars['data']){
    		return $clientVars['data']['version'];
		}else{
			return -1;
		}
    }
    return 0;
}
