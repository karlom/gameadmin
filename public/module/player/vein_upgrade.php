<?php
/**
 * 经脉修炼查询
 */
 
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';

$errorMsg = $successMsg = array();// 消息数组
$onlineDate = ONLINEDATE;//开服日期

//请求参数获取
$roleName 		= (isset( $_GET['role_name'] ) && Validator::stringNotEmpty($_GET['role_name']) )? autoAddPrefix( SS($_GET['role_name']) ) : '';
$accountName 	= (isset( $_GET['account_name'] ) && Validator::stringNotEmpty($_GET['account_name']) )? autoAddPrefix( SS($_GET['account_name']) ) : '';
$startDay		= (isset( $_GET['start_day'] ) && Validator::isDate($_GET['start_day']) )? SS($_GET['start_day']) : date('Y-m-d');
$endDay		= (isset( $_GET['end_day'] ) && Validator::isDate($_GET['end_day']) )? SS($_GET['end_day']) : date('Y-m-d');
list($page, $pageSize) = getPagesParams();// 

$startTimestamp = Datatime::getDayBeginTimestamp($startDay);//
$endTimestamp 	= Datatime::getDayEndTimestamp($endDay);//

if( empty($errorMsg) ){
	$viewData = getRecords($roleName, $accountName, $startTimestamp, $endTimestamp, $page, $pageSize );
	$pager = getPages2( $page, $viewData['recordCount'], $pageSize );
	$smarty->assign( 'viewData', $viewData );
	$smarty->assign( 'pager', $pager );
}

$smarty->assign( 'lang', $lang );
$smarty->assign( 'errorMsg', implode('<br/>', $errorMsg ) );
$smarty->assign( 'successMsg', implode('<br/>', $successMsg ) );
$smarty->assign( 'minDate', $onlineDate);
$smarty->assign( 'maxDate', Datatime :: getTodayString());
$smarty->assign( 'startDay', $startDay );
$smarty->assign( 'endDay', $endDay );
$smarty->assign( 'roleName', $roleName );
$smarty->assign( 'accountName', $accountName );
$smarty->assign( 'vein', $vein );
$smarty->display( 'module/player/vein_upgrade.tpl' );


function getRecords($roleName, $accountName, $startTimestamp, $endTimestamp, $page, $pageSize){
    $where = 1;
    $where .= $roleName ? " and role_name='{$roleName}'" : "";
    $where .= $accountName ? " and account_name='{$accountName}'" : "";
    $where .= " and mtime>={$startTimestamp} and mtime<={$endTimestamp}";
    $sql = "select count(id) record_num from ".T_LOG_VEIN_UPGRADE." where {$where}";
    $result = GFetchRowOne($sql);
    $data['recordCount'] = $result['record_num'];
    $limit = " LIMIT ".($page - 1) * $pageSize.",".$pageSize;
    $sql = "select * from ".T_LOG_VEIN_UPGRADE." where {$where} order by id desc {$limit}";
    $result = GFetchRowSet($sql);
    $data['data'] = $result;
	return $data;
}
