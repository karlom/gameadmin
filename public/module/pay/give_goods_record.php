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
$roleName 	= isset( $_GET['roleName'] )?  SS($_GET['roleName'])  : "";
$applyID 	= isset( $_GET['applyID'] )?  SS($_GET['applyID'])  : "";
$action = $_POST['action'];

list($page, $pageSize) = getPagesParams();

//删除记录
if(!empty($action) && $action == "deleteRecord"){
	
	$startDay = $_POST['startDay'];
	$endDay = $_POST['endDay'];
	$applyID = SS($_POST['applyID']);
	$roleName = SS($_POST['roleName']);
	
	$mywhere = 1;
	$mywhere .= $startDay ? " and mtime>= " . strtotime($startDay." 00:00:00 ") : "";
	$mywhere .= $endDay ? " and mtime<= " . strtotime($endDay." 23:59:59 ") : "";
	$mywhere .= $applyID ? " and applyID={$applyID} "  : "";
	$mywhere .= $roleName ? " and role_name='{$roleName}' " : "";
	
	$delSql = " update " . T_LOG_ADMIN . " set visible=0 where {$mywhere}";
	GQuery($delSql);
	$successMsg[] = "删除成功！";
	$detail = "开始日期： {$startDay}，结束日期：{$endDay}，申请ID：{$applyID}，角色名：{$roleName}";
	$log = new AdminLogClass();
	$log->Log(AdminLogClass::TYPE_DELETE_SEND_GOODS_RECORD,$detail,'','删除赠送记录','','');
	
	unset($applyID);
	unset($roleName);
}

$startDayTimestamp 	= Datatime::getDayBeginTimestamp( $startDayString ) ;
$endDayTimestamp 	= Datatime::getDayEndTimestamp( $endDayString ) ;

$where = 1;
$where .= $applyID ? " AND applyID={$applyID} " : "";
$where .= $roleName ? " AND role_name='{$roleName}' " : "";
$where .= " AND mtime > {$startDayTimestamp} AND mtime < {$endDayTimestamp} ";//设置开始时间和结束时间的条件语句

$viewData = getGiveGoodsRecord ( $where, $page, $pageSize);

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
$smarty->assign ( 'applyID', $applyID ); 
#$smarty->assign ('current_uri' , cleanQueryString( $_SERVER['REQUEST_URI'], array('page') ));
$smarty->assign ( 'viewData', $viewData );
$smarty->assign	( 'errorMsg', 	implode('<br/>', $errorMsg ) );
$smarty->assign	( 'successMsg', 	implode('<br/>', $successMsg ) );
$smarty->display ( "module/pay/give_goods_record.tpl" );

function getGiveGoodsRecord($where, $page, $pageSize){//因为页面中需要显示最大单月充值金额，最大单月充值人数，最大单月ARPU，所以没必要分不同类型。
	$where .= ' and visible=1 ';	//部分可见
	$limit = '';
	if (!empty($page) && !empty($pageSize)) $limit = ' LIMIT ' . (($page - 1) * $pageSize) . ', ' . $pageSize;
	
	$sql = "SELECT
				mtime, applyID, uuid, account_name, role_name, items 
			FROM " . T_LOG_ADMIN  . "
			WHERE {$where}
			ORDER BY mtime DESC
	        {$limit}
			";
	
	$recordSet = GFetchRowSet($sql);	
	
	foreach ( $recordSet as $key => &$value ) {
		$items = decodeItems($value['items']);
		$value['items'] = itemsArrayToString($items);
	}
	
	
	
	$sqlCount = 'SELECT 
					count(*) row_count
				 FROM ' . T_LOG_ADMIN . " WHERE {$where}" ;
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
