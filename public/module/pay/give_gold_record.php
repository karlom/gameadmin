<?php
/*
 * Author: yangdongbo
 * 2011-11-22
 */
 
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';
include_once SYSDIR_ADMIN_DICT . '/arrItemsAll.php';
global $lang, $dictPayStatisticsType, $arrItemsAll;

$errorMsg = $successMsg = array();// 消息数组
$onlineDate = ONLINEDATE;//开服日期
$openTimestamp = strtotime( $onlineDate );//开服日期的时间戳
$startDayString 	= (isset( $_GET['startDay'] ) && $_GET['startDay'] > $onlineDate )? SS($_GET['startDay']) : Datatime::getFormatStringByString('Y-m-d', $onlineDate);
$endDayString 	= isset( $_GET['endDay'] )? SS($_GET['endDay']) : date('Y-m-d');
$roleName 	= isset( $_GET['roleName'] )? autoAddPrefix( SS($_GET['roleName']) ) : "";

list($page, $pageSize) = getPagesParams();


$startDayTimestamp 	= Datatime::getDayBeginTimestamp( $startDayString ) ;
$endDayTimestamp 	= Datatime::getDayEndTimestamp( $endDayString ) ;

$where = 1;
$where .= $roleName ? " AND role_name='{$roleName}' " : "";
$where .= " AND mtime > {$startDayTimestamp} AND mtime < {$endDayTimestamp} ";//设置开始时间和结束时间的条件语句

$viewData = getGiveGoldRecord ( $where, $page, $pageSize);

if(!$viewData)$errorMsg[] = $lang->page->dateInvalid;

$pager = getPages2( $page, $viewData ['recordCount'], $pageSize );

$smarty->assign ( 'minDate',  $onlineDate );
$smarty->assign ( 'maxDate',  Datatime :: getTodayString() );
$smarty->assign ( 'startDay', $startDayString );
$smarty->assign ( 'endDay', $endDayString );
$smarty->assign ( 'pager', $pager);
$smarty->assign ( 'lang', $lang );
$smarty->assign ( 'arrItemsAll', $arrItemsAll ); 
$smarty->assign ( 'roleName', $roleName ); 
#$smarty->assign ('current_uri' , cleanQueryString( $_SERVER['REQUEST_URI'], array('page') ));
$smarty->assign ( 'viewData', $viewData );
$smarty->assign	( 'errorMsg', 	implode('<br/>', $errorMsg ) );
$smarty->assign	( 'successMsg', 	implode('<br/>', $successMsg ) );
$smarty->display ( "module/pay/give_gold_record.tpl" );

function getGiveGoldRecord($where, $page, $pageSize){//因为页面中需要显示最大单月充值金额，最大单月充值人数，最大单月ARPU，所以没必要分不同类型。
	$limit = '';
	if (!empty($page) && !empty($pageSize)) $limit = ' LIMIT ' . (($page - 1) * $pageSize) . ', ' . $pageSize;
	
	$sql = "SELECT
				mtime, apply_id, role_name, gold, bind_gold, money, bind_money, item_id, num 
			FROM " . T_LOG_APPLY_GOODS  . "
			WHERE {$where}
			ORDER BY mtime DESC
	        {$limit}
			";
	
	$recordSet = GFetchRowSet($sql);	
	
	$sqlCount = 'SELECT 
					count(*) row_count
				 FROM ' . T_LOG_APPLY_GOODS . " WHERE {$where}" ;
	$recordCount = GFetchRowOne( $sqlCount );

	$data = array (
                    'recordCount' => $recordCount['row_count'],
                    'page' => $page,
                    'page_size' => $pageSize,
                    'data' => $recordSet
            );
	
	// 构造结果
	
	return $data;
}