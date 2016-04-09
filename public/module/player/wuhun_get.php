<?php
/**
 * 猎魂/出售/丢弃/兑换查询
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
$wuhunName		= (isset( $_GET['wuhun_name'] ) && Validator::stringNotEmpty($_GET['wuhun_name']) )? SS($_GET['wuhun_name']) : "";
$color		= (isset( $_GET['color'] ) && Validator::isInt($_GET['color']) )? SS($_GET['color']) : "";
$type = isset($_GET['type']) ? intval($_GET['type']) : 0;
list($page, $pageSize) = getPagesParams();// 

$startTimestamp = Datatime::getDayBeginTimestamp($startDay);//
$endTimestamp 	= Datatime::getDayEndTimestamp($endDay);//

if( empty($errorMsg) ){
    $where = 1;
    $where .= $type ? " and op_type={$type} " : "";
    $where .= $wuhunName ? " and wuhun_name='{$wuhunName}' " : "";
    $where .= $color ? " and wuhun_color={$color} " : "";
	$viewData = getWuhunGetRecords($where, $roleName, $accountName, $startTimestamp, $endTimestamp, $page, $pageSize );
	$pager = getPages2( $page, $viewData['recordCount'], $pageSize );
	$subType = array(
	    1 => "5000".$lang->currency->copper,
	    2 => "20000".$lang->currency->copper,
	    3 => $lang->gold->gold,
	);
	$smarty->assign( 'viewData', $viewData );
	$smarty->assign( 'pager', $pager );
	$smarty->assign( 'subType', $subType );
	$smarty->assign( 'wuhunName', $wuhunName );
	$smarty->assign( 'color', $color );
}

$typeArr = array(
    0 => $lang->page->showType1,
    1 => $lang->wuhun->hunt,
    2 => $lang->wuhun->sale,
    3 => $lang->wuhun->drop,
    4 => $lang->wuhun->exchange,
);

unset($dictColorValue[5]);
unset($dictColor[5]);
$dictColor = changeArrayBase($dictColor, 1);
$dictColor[0] = $lang->page->showType1;
ksort($dictColor);

$smarty->assign( 'lang', $lang );
$smarty->assign( 'dictColorValue', changeArrayBase($dictColorValue, 1));
$smarty->assign( 'dictColor', $dictColor);
$smarty->assign( 'errorMsg', implode('<br/>', $errorMsg ) );
$smarty->assign( 'successMsg', implode('<br/>', $successMsg ) );
$smarty->assign( 'minDate', $onlineDate);
$smarty->assign( 'maxDate', Datatime :: getTodayString());
$smarty->assign( 'startDay', $startDay );
$smarty->assign( 'endDay', $endDay );
$smarty->assign( 'roleName', $roleName );
$smarty->assign( 'accountName', $accountName );
$smarty->assign( 'typeArr', $typeArr );
$smarty->assign( 'type', $type );
$smarty->display( 'module/player/wuhun_get.tpl' );

function getWuhunGetRecords($where, $roleName, $accountName, $startTimestamp, $endTimestamp, $page, $pageSize){
    $where .= $roleName ? " and role_name='{$roleName}'" : "";
    $where .= $accountName ? " and account_name='{$accountName}'" : "";
    $where .= " and mtime>={$startTimestamp} and mtime<={$endTimestamp}";
    $sql = "select count(id) record_num from ".T_LOG_WUHUN_GET." where {$where}";
    $result = GFetchRowOne($sql);
    $data['recordCount'] = $result['record_num'];
    $limit = " LIMIT ".($page - 1) * $pageSize.",".$pageSize;
    $sql = "select account_name,role_name,level,wuhun_name,wuhun_color,wuhun_lv,type,op_type,mtime from ".T_LOG_WUHUN_GET." where {$where} order by id desc {$limit}";
    $result = GFetchRowSet($sql);
    $data['data'] = $result;
	return $data;
}
