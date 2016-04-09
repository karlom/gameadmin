<?php
/**
 * 联盟渠道注册用户信息
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';

global $lang;

$role = $_POST['role'];
$roleName = $role['role_name'] ; 
$accountName = $role['account_name'] ; 
$pageNum = $_POST['record'] ? SS($_POST['record']) : LIST_PER_PAGE_RECORDS;
$registerWay = $_POST['register_way'] ; 

$action = $_POST['action'] ; 

//获取时间段
if (! isset ( $_POST ['starttime'] )){
    $dateStart = Datatime::getPrevWeekString ();
}else{
    $dateStart = SS ( $_POST ['starttime'] );
}
$dateStart = (strtotime($dateStart) >= strtotime(ONLINEDATE)) ? $dateStart : ONLINEDATE;
$dateEnd = ! isset ($_POST['endtime']) ? Datatime::getTodayString() :  SS ($_POST['endtime']);
$dateStartTamp = strtotime($dateStart." 0:0:0");
$dateEndTamp = strtotime($dateEnd." 23:59:59");
//if($roleName || $accountName){
$record = intval($_POST['record']);
if(empty ($record)){
    $record = LIST_PER_PAGE_RECORDS;
}
$where = " and mtime >= {$dateStartTamp} and mtime <= {$dateEndTamp} ";
$where .= $roleName ? " and role_name = '{$roleName}' " :"";
$where .= $accountName ? " and account_name = '{$accountName}' " : "";
$where .= $registerWay ? " and pf like 'union-10086-{$registerWay}*%' " : " and pf like 'union-10086-%' ";
$counts = 0;//总记录
$pageno = getUrlParam('page');//设置初始页
$startNum = ($pageno - 1) * $record; //每页开始位置

$viewData = getAllPlayerData($where,$startNum,$record,$counts);
//print_r($viewData);

if($action == "downAll"){
	$downData = getAllPlayerData($where,0,$counts,$counts);
	header("Content-type: text/html; charset=gb2312"); 
	header("Content-type:application/vnd.ms-excel");
	header("content-Disposition:filename=union-10086-{$registerWay}a_{$dateStart}_{$dateEnd}.csv ");
	if($downData) {
		echo "\xEF\xBB\xBF";	//解决下载文件乱码的问题，先在文件写入这个
		echo '"角色名","账号名","创建时间","注册IP","等级","平台","今日充值(Q点)","历史充值(Q点)"'."\n";
		foreach($downData as $v){
			echo '"'.$v['role_name'].'","'.$v['account_name'].'","'.$v['registe_time'].'","'.$v['ip'].'","'.$v['level'].'","'.$v['pf'].'","'.$v['pay_today'].'","'.$v['pay_all'].'"'."\n";
		}
	}
	exit ;
} else if ($action == "downCurrent"){
	$downData = $viewData;
	header("Content-type: text/html; charset=gb2312"); 
	header("Content-type:application/vnd.ms-excel");
	header("content-Disposition:filename=union-10086-{$registerWay}a_p{$pageno}_{$dateStart}_{$dateEnd}.csv ");
	if($downData) {
		echo "\xEF\xBB\xBF";	//解决下载文件乱码的问题，先在文件写入这个
		echo '"角色名","账号名","创建时间","注册IP","等级","平台","今日充值(Q点)","历史充值(Q点)"'."\n";
		foreach($downData as $v){
			echo '"'.$v['role_name'].'","'.$v['account_name'].'","'.$v['registe_time'].'","'.$v['ip'].'","'.$v['level'].'","'.$v['pf'].'","'.$v['pay_today'].'","'.$v['pay_all'].'"'."\n";
		}
	}
	exit ;
}

$pageCount = ceil ( $counts/$record );
$pagelist = getPages($pageno, $counts,$record);
//}
$maxDate = date ( "Y-m-d" );
$data = array(
    'counts' => $counts,
    'record' => $record,
//    'minDate' => ONLINEDATE,
    'minDate' => '2014-05-01',
    'maxDate' => $maxDate,
    'role' => $role,
    'pagelist' => $pagelist,
    'pageCount' => $pageCount,
    'pageNum' => $pageNum,
    'pageno' => $pageno,
    'dateStart' => $dateStart,
    'dateEnd' => $dateEnd,
    'lang' => $lang,
    'viewData' => $viewData,
    'register_way' => $registerWay,
);
$smarty->assign ($data);
$smarty->display ( 'module/basedata/union_register_ways.tpl' );

function getAllPlayerData($where,$startNum,$record,& $counts) {
//    $sql = "select U10.*, U20.career from (select uuid, account_name, role_name, mtime registe_time, pf from ".T_LOG_REGISTER." 
//    	WHERE 1 {$where} order by registe_time desc limit {$startNum},{$record}) U10 left join ".T_LOG_CAREER." U20 on U10.uuid=U20.uuid";
	
	$today = strtotime(date('Y-m-d'));
	$todayEnd = $today+86400;
	
    $sql = "select U10.*, U20.level, U30.pay_today, U40.pay_all from " .
    		" (select uuid, account_name, role_name, mtime as registe_time, ip, SUBSTRING_INDEX(pf, '*', 1) as pf from ".T_LOG_REGISTER." 
    	WHERE 1 {$where} order by registe_time desc limit {$startNum},{$record}) U10 " .
    			" left join (select uuid, max(level) as level from ".T_LOG_LEVEL_UP." group by uuid) U20 on U10.uuid=U20.uuid
				 left join (select uuid, round(sum(total_cost + pubacct + amt/10)) as pay_today from t_log_buy_goods where mtime>={$today} and mtime<{$todayEnd} group by uuid ) U30 on U10.uuid=U30.uuid 
				 left join (select uuid, round(sum(total_cost + pubacct + amt/10)) as pay_all from t_log_buy_goods group by uuid ) U40 on U10.uuid=U40.uuid ";

    $rs = GFetchRowSet($sql);

    $data = array();
    if($rs){
        foreach($rs as $key => $value){
            $data[$value['account_name']] = $value;
        }
    }

    $sqlCount = "select count(*) as cnt from ".T_LOG_REGISTER." where 1 {$where} ";
    $rsCount = GFetchRowOne($sqlCount);
    $counts = $rsCount['cnt'];
    
	if($data){
	    foreach($data as &$row){
	        $row['registe_time'] = date('Y-m-d H:i:s',$row['registe_time']);
	        $row['level'] = $row['level'] ? $row['level'] : 1;
	        $row['pay_today'] = $row['pay_today'] ? $row['pay_today'] : 0;
	        $row['pay_all'] = $row['pay_all'] ? $row['pay_all'] : 0;
	    }
	}
    
    return $data;
}