<?php
/**
 * 玩家道具使用记录
 */
 
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/arrItemsAll.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';
include_once SYSDIR_ADMIN_DICT . '/opTypeConfig.php';

global $dictColor, $arrItemsAll, $dictOperation, $dictCurrency2;


$itemList = array();
foreach($arrItemsAll as $item)
{
	$itemList[$item['id']] = $item['name'];
}

$errorMsg = $successMsg = array();// 
$onlineDate = $serverList[$_SESSION ['gameAdminServer']]['onlinedate'];//
$allowedFields = array('item_id' => $lang->item->itemID, 'mtime' => $lang->item->datetime, 'type' => $lang->item->type, 'color' => $lang->item->color, 'isbind' => $lang->item->bind);
$defaultOrderBy = array('mtime', 'desc');

//请求参数获取
$roleName 		= (isset( $_GET['role_name'] ) && Validator::stringNotEmpty($_GET['role_name']) )?  SS($_GET['role_name'])  : '';
$accountName 	= (isset( $_GET['account_name'] ) && Validator::stringNotEmpty($_GET['account_name']) )?  SS($_GET['account_name'])  : '';
//$itemID 	= (isset( $_GET['item_id'] ) && Validator::isInt($_GET['item_id']) )? SS($_GET['item_id'])  : 0;
$item_id_widget 	= ( !empty( $_GET['item_id_widget'] ) ) ? SS($_GET['item_id_widget'])  : 0;
$startDay		= (isset( $_GET['start_day'] ) && Validator::isDate($_GET['start_day']) )? SS($_GET['start_day']) : date('Y-m-d', strtotime('-6 days'));
$endDay		= (isset( $_GET['end_day'] ) && Validator::isDate($_GET['end_day']) )? SS($_GET['end_day']) : date('Y-m-d');
$selectedOperation		= (isset( $_GET['usageFilter'] ) && is_array($_GET['usageFilter']) )? $_GET['usageFilter'] : array() ;
$selectedCurrency		= (isset( $_GET['currencyFilter'] ) && is_array($_GET['currencyFilter']) )? $_GET['currencyFilter'] : array_keys($dictCurrency2);
$selectedAll		= ( $_GET['selectAll'] == "on" ) ? true : false;
$useItem = ( $_GET['useItem'] ) ? 1 : 0;
$getItem = ( $_GET['getItem'] ) ? 2 : 0;

if (!$useItem && !$getItem) {
	$useItem = 1; 
	$getItem = 2;
}

//获取道具ID
if(Validator::isInt($item_id_widget)) {
	$itemID = $item_id_widget;
} else {
	$itemArr = explode('|',$item_id_widget);
	$itemID = trim($itemArr['0']);
}
// new dBug("到这里都还没有数据库操作————————————————————");
// new dBug(time());
list($page, $pageSize) = getPagesParams();	// 从请求中获取分页参数
// new dBug(time());
$useOrGet = $useItem+$getItem;

$orderBy = getSortOrder('sortby', $allowedFields);	//从请求中获取选中的排序方法
$orderBy = $orderBy? $orderBy : $defaultOrderBy;	//判断是否存在
list($sortArray, $selectedSortLine) = generateSortArray($allowedFields, $orderBy);//生成排序方法的下拉列表
// new dBug(time());
$selectType = array();

foreach($selectedCurrency as  $v) {
	foreach($selectedOperation as $w) {
		$t = $v+$w;
		array_push( $selectType,$t );
	}
}


$startTimestamp = Datatime::getDayBeginTimestamp($startDay);//
$endTimestamp 	= Datatime::getDayEndTimestamp($endDay);//

$openTimestamp = strtotime( ONLINEDATE );
if($startTimestamp < $openTimestamp)
{
	$startTimestamp = $openTimestamp;
	$startDay = ONLINEDATE;
}
//

$startTimestamp = Datatime::getDayBeginTimestamp($startDay);//
$endTimestamp 	= Datatime::getDayEndTimestamp($endDay);//
// new dBug(time());
if( empty($errorMsg) && !empty($_GET))// 
// if( !empty($accountName) || !empty($roleName) )// 
{
	$viewData = getItemUseRecords($roleName, $accountName, $itemID, $useOrGet, $selectType, $startTimestamp, $endTimestamp, $page, $pageSize , $orderBy ,$selectedAll);

	$pager = getPages2( $page, $viewData ['recordCount'], $pageSize );
	$smarty->assign( 'viewData', $viewData );
	$smarty->assign( 'pager', $pager );
} 
// new dBug(time());

$smarty->assign( 'lang', $lang );
$smarty->assign( 'selectedOperation', $selectedOperation);
$smarty->assign( 'selectedCurrency', $selectedCurrency);
$smarty->assign( 'selectedAll', $selectedAll);
$smarty->assign( 'useItem', $useItem);
$smarty->assign( 'getItem', $getItem);
$smarty->assign( 'sortArray', $sortArray);
$smarty->assign( 'selectedSortLine', $selectedSortLine);
$smarty->assign( 'dictOperation', $dictOperation);
$smarty->assign( 'dictCurrency', $dictCurrency2);
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
$smarty->display( 'module/item/item_follow.tpl' );


function getItemUseRecords($roleName = '', $accountName = '', $item_id = 0, $useOrGet, $selectedOperation = array(), $startTimestamp, $endTimestamp, $page, $pageSize, $orderBy, $selectedAll)
{
	global $inforbright,$serverList;

	$andCond = array();
	$andCond[] = " mtime > $startTimestamp";
	$andCond[] = " mtime < $endTimestamp";
	if( Validator::stringNotEmpty($roleName) ) $andCond[] = " role_name = '$roleName' ";
	if( Validator::stringNotEmpty($accountName) ) $andCond[] = " account_name = '$accountName' ";
	if( Validator::isInt($item_id) && $item_id > 0 ) $andCond[] = " item_id = $item_id ";
	if(!$selectedAll){
		if( is_array($selectedOperation) && !empty($selectedOperation) ) {
			$andCond[] = " type in (" . implode(',', $selectedOperation) . ')';
		}
	}
	

	if($useOrGet == 1) {
		$andCond[] = " item_num < 0 ";
	} else if ($useOrGet == 2 ) {
		$andCond[] = " item_num > 0 ";
	}
	
	$limit = '';
	if ( Validator::isInt($page) && $page > 0 &&
		 Validator::isInt($pageSize) && $pageSize > 0) 
	{
		$limit = ' LIMIT ' . (($page - 1) * $pageSize) . ', ' . $pageSize;
	}
	
	$whereCond = ' WHERE ' . implode(' AND ', $andCond);
	$orderBy = ' ORDER BY ' .  $orderBy[0] . ' ' . $orderBy[1] . ' ';
	$sql = 'SELECT mtime,mdate,account_name,role_name,level,type,item_id,item_num,is_bind,detail FROM ' . T_LOG_ITEM  . $whereCond . $orderBy . $limit;
	 $recordSet = IBFetchRowSet($sql);
	global $dictOperation,$dictCurrency2;
	foreach($recordSet as &$record)
	{
		if( Validator::stringNotEmpty($record['detail']) )
		{
			$attr = getItemDetailArray($record['detail']);
			$record['detail'] =  itemsArrayToString($attr,"detail","all");
		} else {
			$record['detail'] = "-";
		}
		$record['cuType'] = $dictCurrency2[(intval($record['type']/10000)*10000)];
		$record['opType'] = $record['type']. " | " .$dictOperation[($record['type']%10000)];
		
	}
	
	$sqlCount = 'SELECT COUNT(*) row_count FROM ' . T_LOG_ITEM . $whereCond ;
	$recordCount = IBFetchRowOne($sqlCount);
	$data = array (
                    'recordCount' => $recordCount['row_count'],
                    'data' => $recordSet
            );
	return $data;
	
}