<?php
/**
 * 下线查询
 * 
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';
include_once SYSDIR_ADMIN_DICT . '/map.php';

global $lang;

$role = $_POST['role'];
$roleName =  SS( $role['role_name'] ) ;
$accountName =  SS( $role['account_name'] ) ;
$pageNum = $_POST['record'] ? SS($_POST['record']) : LIST_PER_PAGE_RECORDS;

//获取时间段
if (! isset ( $_POST ['starttime'] )){
    $dateStart = Datatime::getTodayString ();
}else{
    $dateStart = SS ( $_POST ['starttime'] );
}
$dateStart = (strtotime($dateStart) >= strtotime(ONLINEDATE)) ? $dateStart : ONLINEDATE;
$dateEnd = ! isset ($_POST['endtime']) ? Datatime::getTodayString() :  SS ($_POST['endtime']);
$dateStartTamp = strtotime($dateStart." 0:0:0");
$dateEndTamp = strtotime($dateEnd." 23:59:59");

$where = " 1 ";
$where .= " and mtime >= {$dateStartTamp} and mtime <= {$dateEndTamp} ";
if($roleName || $accountName){
    $where .= $roleName ? " and role_name = '{$roleName}' " :"";
    $where .= $accountName ? " and account_name = '{$accountName}' " : "";
}  

$record = $_POST['record'] ? intval($_POST['record']) : LIST_PER_PAGE_RECORDS;

$counts = 0;//总记录
$pageno = getUrlParam('page');//设置初始页
$startNum = ($pageno - 1) * $record; //每页开始位置

$viewData = getLogoutHistoryData($where,$startNum,$record,$counts);

if($roleName || $accountName){
	//从查询结果中获取账号名和角色名
	foreach($viewData as $row){
        $role['role_name'] = $row['role_name'];
        $role['account_name'] = $row['account_name'];
	    if($role['role_name'] && $role['account_name']) {
	    	break;
	    }
    }
}

foreach($viewData as &$row){
    $row['online_time'] = Datatime::secondToDay($row['online_time']);
    $row['map_name'] = $dictMap[$row['map_id']]['name'];
    $row['reason'] = $offLineReason[$row['reason']];
}


$pageCount = ceil ( $counts/$record );
$pagelist = getPages($pageno, $counts,$record);  
    
$maxDate = date ( "Y-m-d" );
$data = array(
    'counts' => $counts,
    'record' => $record,
    'minDate' => ONLINEDATE,
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
);
$smarty->assign ($data);
$smarty->display ( 'module/player/logout_history.tpl' );

function getLogoutHistoryData($where,$startNum,$record,& $counts) {
    $sql = "SELECT * FROM ".T_LOG_LOGOUT." WHERE {$where} ORDER BY mtime DESC limit {$startNum},{$record}";
    $rs = GFetchRowSet($sql);

    $sqlCount = "select count(*) as cnt from ".T_LOG_LOGOUT." where {$where} ";
    $rsCount = GFetchRowOne($sqlCount);
    $counts = $rsCount['cnt'];
    
    return $rs;
}