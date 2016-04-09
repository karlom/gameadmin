<?php
/**
 * 副本道具掉落统计
 */
 
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/arrItemsAll.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';

global $dictColor, $arrItemsAll,$dictQuality, $dictItemUsageType, $dictMapType;
list($page, $pageSize) = getPagesParams();// 从请求中获取分页参数
//if( IS_LUA == 1 )
//{// LUA的数组是从1开始
//	$dictColor = changeArrayBase( $dictColor, 1 );
//}
// 构造副本地图数组
$copySceneTypes = array();
foreach ($dictMapType as $mapType)
{
	if($mapType['isCopyScene'])
	{
		$copySceneTypes[$mapType['id']] = $mapType['name'];
	}
}

// 构造道具数组
$itemList = array();
foreach($arrItemsAll as $item)
{
	$itemList[$item['id']] = $item['name'];
}
$errorMsg = $successMsg = array();// 
$onlineDate = $serverList[$_SESSION ['gameAdminServer']]['onlinedate'];//


//请求参数获取
$copysceneID 	= (isset( $_GET['copyscene_id'] ) && Validator::isInt($_GET['copyscene_id']) )? SS($_GET['copyscene_id'])  : 200;
$roleName 		= (isset( $_GET['role_name'] ) && Validator::stringNotEmpty($_GET['role_name']) )? autoAddPrefix( SS($_GET['role_name']) ) : '';
$accountName 	= (isset( $_GET['account_name'] ) && Validator::stringNotEmpty($_GET['account_name']) )? autoAddPrefix( SS($_GET['account_name']) ) : '';
$startDay		= (isset( $_GET['start_day'] ) && Validator::isDate($_GET['start_day']) )? SS($_GET['start_day']) : date('Y-m-d');
$endDay		= (isset( $_GET['end_day'] ) && Validator::isDate($_GET['end_day']) )? SS($_GET['end_day']) : date('Y-m-d');


//
$startTimestamp = Datatime::getDayBeginTimestamp($startDay);//
$endTimestamp 	= Datatime::getDayEndTimestamp($endDay);//

$openTimestamp = strtotime( ONLINEDATE );
if($startTimestamp < $openTimestamp)
{
	$startTimestamp = $openTimestamp;
	$startDay = ONLINEDATE;
}

if( isset($_GET['search']) )// 
{
	$viewData = getItemUserRecords( $roleName, $accountName, $copysceneID, $startTimestamp, $endTimestamp , $page, $pageSize);

	$pager = getPages2( $page, $viewData ['recordCount'], $pageSize );
	$smarty->assign( 'viewData', $viewData );
	$smarty->assign( 'pager', $pager );
} 


$smarty->assign( 'lang', $lang );
$smarty->assign( 'dictColor', $dictColor);
$smarty->assign( 'copysceneID', $copysceneID);
$smarty->assign( 'copySceneTypes', $copySceneTypes);
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
$smarty->display( 'module/copyscene/copyscene_item.tpl' );


function getItemUserRecords($roleName = '', $accountName = '', $copysceneID = 200, $startTimestamp, $endTimestamp, $page, $pageSize)
{
	$andCond = array();
	$andCond[] = " map_id >= 200 ";
	$andCond[] = " mtime > $startTimestamp";
	$andCond[] = " mtime < $endTimestamp";
	if( Validator::stringNotEmpty($roleName) )
	{
		$andCond[] = " role_name = '$roleName' ";
	}
	if( Validator::stringNotEmpty($accountName) )
	{
		$andCond[] = " account_name = '$accountName' ";
	}
	if( Validator::isInt($copysceneID) && $copysceneID > 0 && intval($copysceneID) !== 200 ) $andCond[] = " map_id = $copysceneID ";
	
	$limit = '';
	if ( Validator::isInt($page) && $page > 0 &&
		 Validator::isInt($pageSize) && $pageSize > 0) 
	{
		$limit = ' LIMIT ' . (($page - 1) * $pageSize) . ', ' . $pageSize;
	}
	
	$whereCond = ' WHERE ' . implode(' AND ', $andCond);
	// 所有记录
	$sqlItemList = 'SELECT mtime, item_id, map_id FROM ' . T_LOG_ITEM  . $whereCond . ' ORDER BY mtime DESC ' . $limit ;
	$itemList = GFetchRowSet($sqlItemList);
	
	$sqlCountItemList = 'SELECT count(*) item_count FROM ' . T_LOG_ITEM  . $whereCond  ;
	$itemCount = GFetchRowOne($sqlCountItemList);
	
	// 统计个数
	$sqlItemStatisticsList = 'SELECT count(*) item_count, item_id FROM ' . T_LOG_ITEM  . $whereCond . ' GROUP BY item_id ORDER BY item_count DESC';

	$itemStatisticsList = GFetchRowSet($sqlItemStatisticsList);
	
	

	$data = array ( 
					'recordCount' => $itemCount['item_count'],
                    'data' => array(
								'itemList' => $itemList,
								'itemStatisticsList' => $itemStatisticsList
							)
            );
	return $data;
	
}