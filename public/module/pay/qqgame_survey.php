<?php

/**
 * 游戏大厅单服概况
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
					   FROM ".T_LOG_BUY_GOODS .
//					 " WHERE `ts`  BETWEEN {$dateStartStamp} AND {$dateEndStamp} " .
					 "";
$payAccountCntRs = GFetchRowOne($sqlPayAccountCnt);
$payAccountCnt = intval( $payAccountCntRs['pay_account_cnt'] ) ;

//总消耗Q点
$sqlAllTotalCost = "select round(sum(total_cost + pubacct + amt/10)) as totalCost from " . T_LOG_BUY_GOODS . "  ";
$sqlAllTotalCostResult = GFetchRowOne($sqlAllTotalCost);

$allPayCount = $sqlAllTotalCostResult['totalCost'] ? $sqlAllTotalCostResult['totalCost'] : 0;

//付费率（付费人数/注册人数）
$allPayRate = $totalRole ? round($payAccountCnt/$totalRole,4)*100 : 0;
//APRU值（元宝/付费人数/10）
$allArpu = $payAccountCnt? round($allPayCount/$payAccountCnt/10, 2) : 0 ;

//二次付费人数
$sqlAllSecPayRoleCount = "select count(*) as secPayCount from (select uuid,account_name,role_name,count(*) as cnt from " . T_LOG_BUY_GOODS . " group by uuid having cnt>=2 ) t1 ";
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
$sqlAllMaxPay = "select  year,month,day,mtime, sum(total_cost + pubacct + amt/10) as totalCost from " . T_LOG_BUY_GOODS . " group by year,month,day order by totalCost desc limit 1";
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

//登陆人数
$sqlLoginCount = "select count(distinct uuid) as loginCount from " . T_LOG_LOGIN . " WHERE `mtime`  BETWEEN {$dateStartStamp} AND {$dateEndStamp} and pf='qqgame' ";
$sqlLoginCountResult = GFetchRowOne($sqlLoginCount);

//创建角色数
$sqlRegisterCount = "select count(distinct uuid) as createRoleCount from " . T_LOG_REGISTER . " WHERE `mtime`  BETWEEN {$dateStartStamp} AND {$dateEndStamp} and pf='qqgame' ";
$sqlRegisterCountResult = GFetchRowOne($sqlRegisterCount);

//创建角色并付费人数
$sqlRegister = "select distinct uuid from " . T_LOG_REGISTER . " WHERE `mtime`  BETWEEN {$dateStartStamp} AND {$dateEndStamp} and pf='qqgame' ";
$sqlPay = "select distinct uuid from " . T_LOG_BUY_GOODS . " WHERE `mtime`  BETWEEN {$dateStartStamp} AND {$dateEndStamp} ";
$sqlRegisterAndPay = "select count(*) as newPayCount from ({$sqlRegister}) t1, ({$sqlPay}) t2 where t1.uuid=t2.uuid ";
$sqlRegisterAndPayResult = GFetchRowOne($sqlRegisterAndPay);

//总消耗Q点
$sqlTotalCost = "select round(sum(t1.total_cost + t1.pubacct + t1.amt/10)) as totalCost " .
		"from (select * from t_log_buy_goods WHERE `mtime`  BETWEEN {$dateStartStamp} AND {$dateEndStamp} ) t1, (select distinct uuid from t_log_register where pf='qqgame' ) t2 " .
		" where t1.uuid=t2.uuid ";
$sqlTotalCostResult = GFetchRowOne($sqlTotalCost);

//付费人数
$sqlPayRoleCount = "select count(distinct t1.uuid) as payRoleCount " .
		" from (select * from t_log_buy_goods WHERE `mtime`  BETWEEN {$dateStartStamp} AND {$dateEndStamp} ) t1, (select distinct uuid from t_log_register where pf='qqgame' ) t2 " .
		" where t1.uuid=t2.uuid ";
$sqlPayRoleCountResult = GFetchRowOne($sqlPayRoleCount);

//次日留存率
//创建角色数
$dayend = $dateStartStamp+86400;
$sql = "select count(distinct uuid) as registerCount from " . T_LOG_REGISTER . " WHERE `mtime`  BETWEEN {$dateStartStamp} AND {$dayend} and pf='qqgame' ";
$ret = GFetchRowOne($sql);
$registerCount = $ret ? $ret['registerCount'] : 0 ;
//次日登录数
$secdaystart = $dateStartStamp+86400;
$secdayend = $secdaystart+86400;
$sql = "select count(distinct t2.uuid ) as loginCount " .
		" from (select distinct uuid from t_log_register where `mtime`  BETWEEN {$dateStartStamp} AND {$dayend} and pf='qqgame' ) t1," .
		" (select distinct uuid from t_log_login where `mtime`  BETWEEN {$secdaystart} AND {$secdayend} and pf='qqgame' )t2" .
		" where t1.uuid=t2.uuid ";
$ret = GFetchRowOne($sql);
$secLoginCount = $ret ? $ret['loginCount'] : 0 ;

$secStayRate = $registerCount? round($secLoginCount/$registerCount,4)*100 : 0;

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
	'arup' => $sqlPayRoleCountResult['payRoleCount'] ? round($sqlTotalCostResult['totalCost']/($sqlPayRoleCountResult['payRoleCount']*10),2) :0,
	
	'totalCost' => $sqlTotalCostResult['totalCost'],
	'xsCostCount' => -$sqlXsCostCountResult['xsCostCount'],

	'registerCount' => $registerCount,	
	'secLoginCount' => $secLoginCount,	
	'secStayRate' => $secStayRate,	
	
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
	'maxPayMoney' => round($maxPay/10,1),
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
$smarty->display("module/pay/qqgame_survey.tpl");
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
