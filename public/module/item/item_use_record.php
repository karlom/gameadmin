<?php
/**
 * 玩家道具使用记录
 */
 
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/arrItemsAll.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';

global $dictColor, $arrItemsAll,$dictQuality, $dictItemUsageType;
//if( IS_LUA == 1 )
//{// LUA的数组是从1开始
//	$dictColor = changeArrayBase( $dictColor, 1 );
//}

$itemList = array();
foreach($arrItemsAll as $item)
{
	$itemList[$item['id']] = $item['name'];
}
$errorMsg = $successMsg = array();// 
$onlineDate = $serverList[$_SESSION ['gameAdminServer']]['onlinedate'];//
$allowedFields = array('item_id' => $lang->item->itemID, 'mtime' => $lang->item->datetime, 'type' => $lang->item->type, 'isbind' => $lang->item->bind);
$defaultOrderBy = array('mtime', 'desc');

//请求参数获取
$roleName 		= (isset( $_GET['role_name'] ) && Validator::stringNotEmpty($_GET['role_name']) )?  SS($_GET['role_name'])  : '';
$accountName 	= (isset( $_GET['account_name'] ) && Validator::stringNotEmpty($_GET['account_name']) )?  SS($_GET['account_name'])  : '';
//$itemID 	= (isset( $_GET['item_id'] ) && Validator::isInt($_GET['item_id']) )? SS($_GET['item_id'])  : 0;
$item_id_widget 	= ( !empty( $_GET['item_id_widget'] ) ) ? SS($_GET['item_id_widget'])  : 0;
$startDay		= (isset( $_GET['start_day'] ) && Validator::isDate($_GET['start_day']) )? SS($_GET['start_day']) : date('Y-m-d', strtotime('-6 days'));
$endDay		= (isset( $_GET['end_day'] ) && Validator::isDate($_GET['end_day']) )? SS($_GET['end_day']) : date('Y-m-d');

//获取道具ID
if(Validator::isInt($item_id_widget)) {
	$itemID = $item_id_widget;
} else {
	$itemArr = explode('|',$item_id_widget);
	$itemID = trim($itemArr['0']);
}


list($page, $pageSize) = getPagesParams();// 从请求中获取分页参数
$orderBy = getSortOrder('sortby', $allowedFields);//从请求中获取选中的排序方法
$orderBy = $orderBy? $orderBy : $defaultOrderBy;//判断是否存在
list($sortArray, $selectedSortLine) = generateSortArray($allowedFields, $orderBy);//生成排序方法的下拉列表

//
$startTimestamp = Datatime::getDayBeginTimestamp($startDay);//
$endTimestamp 	= Datatime::getDayEndTimestamp($endDay);//

$openTimestamp = strtotime( ONLINEDATE );
if($startTimestamp < $openTimestamp)
{
	$startTimestamp = $openTimestamp;
	$startDay = ONLINEDATE;
}

$startTimestamp = Datatime::getDayBeginTimestamp($startDay);//
$endTimestamp 	= Datatime::getDayEndTimestamp($endDay);//

if( empty($errorMsg) )// 
{
	$viewData = getItemUserRecords($roleName, $accountName, $itemID, $startTimestamp, $endTimestamp, $page, $pageSize , $orderBy);

	$pager = getPages2( $page, $viewData ['recordCount'], $pageSize );
	$smarty->assign( 'viewData', $viewData );
	$smarty->assign( 'pager', $pager );
} 

$smarty->assign( 'lang', $lang );
$smarty->assign( 'dictColor', $dictColor);
$smarty->assign( 'sortArray', $sortArray);
$smarty->assign( 'selectedSortLine', $selectedSortLine);
$smarty->assign( 'dictQuality', $dictQuality);
$smarty->assign( 'dictItemUsageType', $dictItemUsageType);
$smarty->assign( 'itemList', $itemList);
$smarty->assign( 'itemID', $itemID);
$smarty->assign( 'errorMsg', implode('<br/>', $errorMsg ) );
$smarty->assign( 'successMsg', implode('<br/>', $successMsg ) );
$smarty->assign( 'minDate', $onlineDate);
$smarty->assign( 'maxDate', Datatime :: getTodayString());
$smarty->assign( 'startDay', $startDay );
$smarty->assign( 'endDay', $endDay );
$smarty->assign( 'roleName', $roleName );
$smarty->assign( 'accountName', $accountName );
$smarty->display( 'module/item/item_use_record.tpl' );


function getItemUserRecords($roleName = '', $accountName = '', $item_id = 0, $startTimestamp, $endTimestamp, $page, $pageSize, $orderBy)
{
	$andCond = array();
	$andCond[] = " mtime > $startTimestamp";
	$andCond[] = " mtime < $endTimestamp";
	if( Validator::stringNotEmpty($roleName) ) $andCond[] = " role_name = '$roleName' ";
	if( Validator::stringNotEmpty($accountName) ) $andCond[] = " account_name = '$accountName' ";
	if( Validator::isInt($item_id) && $item_id > 0 ) $andCond[] = " item_id = $item_id ";

	$limit = '';
	if ( Validator::isInt($page) && $page > 0 &&
		 Validator::isInt($pageSize) && $pageSize > 0) 
	{
		$limit = ' LIMIT ' . (($page - 1) * $pageSize) . ', ' . $pageSize;
	}
	
	$whereCond = ' WHERE ' . implode(' AND ', $andCond);
	$orderBy = ' ORDER BY ' .  $orderBy[0] . ' ' . $orderBy[1] . ' ';
	$sql = 'SELECT * FROM ' . T_LOG_ITEM  . $whereCond . $orderBy . $limit;

	$recordSet = IBFetchRowSet($sql);
	
	foreach($recordSet as &$record)
	{
		if( Validator::stringNotEmpty($record['detail']) )
		{
			$attr = getItemDetailArray($record['detail']);
			$record['detail'] = itemsArrayToString($attr,"detail","all");	
		}
	}
	
	$sqlCount = 'SELECT COUNT(*) row_count FROM ' . T_LOG_ITEM . $whereCond ;
	$recordCount = IBFetchRowOne( $sqlCount );

	$data = array (
                    'recordCount' => $recordCount['row_count'],
                    'data' => $recordSet
            );
	return $data;
	
}