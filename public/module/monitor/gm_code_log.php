<?php
/**
 * GM指令日志
 * 
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';

$startDay =  SS($_REQUEST['startDay']);
$endDay =  SS($_REQUEST['endDay']);
$roleName =  SS(trim($_REQUEST['roleName']));
$accountName =  SS(trim($_REQUEST['accountName']));
$cmd =  SS(trim($_REQUEST['cmd']));

$today = date('Y-m-d');

if($startDay){
	$startDay = (strtotime($startDay) >= strtotime(ONLINEDATE)) ? $startDay : ONLINEDATE;
}
if($endDay){
	$endDay = (strtotime($endDay) < strtotime($today)) ? $endDay : $today;
}

if(!$startDay && !$endDay ) {
	$startDay = date('Y-m-d', strtotime($today)-7*86400);
	$endDay = $today;
}

$startTime = strtotime($startDay . " 00:00:00 ");
$endTime = strtotime($endDay . " 23:59:59 ");

list($page,$pageSize) = getPagesParams();


$where = 1;
if($roleName) {
	$where .= " AND role_name = '{$roleName}' ";
}
if($accountName) {
	$where .= " AND account_name = '{$accountName}' ";
}
if($cmd) {
	$where .= " AND cmd = '{$cmd}' " ;
}
if(!empty($startTime)){
	$where .= " AND mtime >= '{$startTime}' " ;
}
if(!empty($endTime)){
	$where .= " AND mtime <= '{$endTime}' " ;
}

$data = getRecord($where, $page, $pageSize);

$pager = getPages2($page, $data['recordCount'], $pageSize);

$minDate = ONLINEDATE;
$maxDate = $today;

$smarty->assign('data', $data );
$smarty->assign('pager', $pager );
$smarty->assign('cmd', $cmd );
$smarty->assign('roleName', $roleName );
$smarty->assign('accountName', $accountName );
$smarty->assign('startDay', $startDay );
$smarty->assign('endDay', $endDay );
$smarty->assign('minDate', $minDate );
$smarty->assign('maxDate', $maxDate );
$smarty->assign('lang', $lang );
$smarty->display( 'module/monitor/gm_code_log.tpl' );

function getRecord($where, $page, $pageSize){
	
	if ( !empty($page) && !empty($pageSize) ) {
		$limit = ' LIMIT ' . (($page - 1) * $pageSize) . ', ' . $pageSize;
	}
	
	
	$sql = "SELECT * FROM " . T_LOG_GM_CODE . " WHERE {$where} ORDER BY mtime DESC,id DESC {$limit}" ;
	
	$sqlCount = "SELECT count(*) cnt FROM " . T_LOG_GM_CODE . " WHERE {$where} " ;
	
//	echo $sql;
	
	$result = GFetchRowSet($sql);
	$count = GFetchRowOne($sqlCount);
	
	$data = array(
		"recordCount" => $count['cnt'],
		"page" => $page,
		"page_size" => $pageSize,
		"data" => $result,
	);
	
	return $data;
}

