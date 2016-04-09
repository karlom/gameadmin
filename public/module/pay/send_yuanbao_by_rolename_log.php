<?php
/**
 * 按玩家名赠送元宝日志查询
 * Author: zhangyoucheng
 * 2012-05-23
 */
 
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';

$errorMsg = $successMsg = array();// 消息数组
$onlineDate = ONLINEDATE;//开服日期

//请求参数获取
$roleName 		= (isset( $_GET['role_name'] ) && Validator::stringNotEmpty($_GET['role_name']) )? autoAddPrefix( SS($_GET['role_name']) ) : '';
$startDay		= (isset( $_GET['start_day'] ) && Validator::isDate($_GET['start_day']) )? SS($_GET['start_day']) : date('Y-m-d');
$endDay		= (isset( $_GET['end_day'] ) && Validator::isDate($_GET['end_day']) )? SS($_GET['end_day']) : date('Y-m-d');
$type		= (isset( $_GET['type'] ) && Validator::isInt($_GET['type']) )? intval($_GET['type']) : -1;
list($page, $pageSize) = getPagesParams();// 

$startTimestamp = Datatime::getDayBeginTimestamp($startDay);//
$endTimestamp 	= Datatime::getDayEndTimestamp($endDay);//

if( empty($errorMsg) ){
    $where = 1;
    $where .= $roleName ? " and role_name='{$roleName}'" : "";
    $where .= (0 < $type) ? " and type={$type}" : "";
    $where .= " and mtime>={$startTimestamp} and mtime<={$endTimestamp}";
	$viewData = getRecords($where, $page, $pageSize );
	$pager = getPages2( $page, $viewData['recordCount'], $pageSize );
	$smarty->assign( 'viewData', $viewData );
	$smarty->assign( 'pager', $pager );
}

$typeArr = array(
    -1 => $lang->page->showType1, 
    1 => $lang->gold->addTotalPay, 
    2 => $lang->gold->notAddTotalPay,
);

$smarty->assign( 'lang', $lang );
$smarty->assign( 'errorMsg', implode('<br/>', $errorMsg ) );
$smarty->assign( 'successMsg', implode('<br/>', $successMsg ) );
$smarty->assign( 'minDate', $onlineDate);
$smarty->assign( 'maxDate', Datatime :: getTodayString());
$smarty->assign( 'startDay', $startDay );
$smarty->assign( 'endDay', $endDay );
$smarty->assign( 'roleName', $roleName );
$smarty->assign( 'typeArr', $typeArr );
$smarty->assign( 'type', $type );
$smarty->display( 'module/pay/send_yuanbao_by_rolename_log.tpl' );


function getRecords($where, $page, $pageSize){
    $sql = "select count(id) record_num from ".T_LOG_SEND_YUANBAO." where {$where}";
    $result = GFetchRowOne($sql);
    $data['recordCount'] = $result['record_num'];
    $limit = " LIMIT ".($page - 1) * $pageSize.",".$pageSize;
    $sql = "select * from ".T_LOG_SEND_YUANBAO." where {$where} order by id desc {$limit}";
    $result = GFetchRowSet($sql);
    $data['data'] = $result;
	return $data;
}
