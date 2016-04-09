<?php
/**
 * 武魂吞噬
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
list($page, $pageSize) = getPagesParams();// 

$startTimestamp = Datatime::getDayBeginTimestamp($startDay);//
$endTimestamp 	= Datatime::getDayEndTimestamp($endDay);//

if( empty($errorMsg) ){
    $where = 1;
    $where .= $wuhunName ? " and src_name='{$wuhunName}' or target_name='{$wuhunName}' " : "";
    $where .= $color ? " and src_color={$color} or target_color={$color} " : "";
	$viewData = getWuhunMergeRecords($where, $roleName, $accountName, $startTimestamp, $endTimestamp, $page, $pageSize );
	$pager = getPages2( $page, $viewData['recordCount'], $pageSize );
	$smarty->assign( 'viewData', $viewData );
	$smarty->assign( 'pager', $pager );
	$smarty->assign( 'wuhunName', $wuhunName );
	$smarty->assign( 'color', $color );
}

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
$smarty->display( 'module/player/wuhun_merge.tpl' );

function getWuhunMergeRecords($where, $roleName, $accountName, $startTimestamp, $endTimestamp, $page, $pageSize){
    $where .= $roleName ? " and role_name='{$roleName}'" : "";
    $where .= $accountName ? " and account_name='{$accountName}'" : "";
    $where .= " and mtime>={$startTimestamp} and mtime<={$endTimestamp}";
    $sql = "select count(id) record_num from ".T_LOG_WUHUN_MERGE." where {$where}";
    $result = GFetchRowOne($sql);
    $data['recordCount'] = $result['record_num'];
    $limit = " LIMIT ".($page - 1) * $pageSize.",".$pageSize;
    $sql = "select account_name,role_name,level,src_name,src_color,src_lv,target_name,target_color,target_lv,mtime from ".T_LOG_WUHUN_MERGE." where {$where} order by id desc {$limit}";
    $result = GFetchRowSet($sql);
    $data['data'] = $result;
	return $data;
}
