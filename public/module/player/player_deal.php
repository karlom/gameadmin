<?php
/**
 * 玩家交易记录
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
$onlineDate = ONLINEDATE;//


//请求参数获取
$roleName 		= (isset( $_GET['role_name'] ) && Validator::stringNotEmpty($_GET['role_name']) )? SS($_GET['role_name']) : '';
$accountName 	= (isset( $_GET['account_name'] ) && Validator::stringNotEmpty($_GET['account_name']) )?  SS($_GET['account_name']) : '';
$itemID 	= (isset( $_GET['item_id'] ) && Validator::isInt($_GET['item_id']) )? SS($_GET['item_id'])  : 0;
$startDay		= (isset( $_GET['start_day'] ) && Validator::isDate($_GET['start_day']) )? SS($_GET['start_day']) : date('Y-m-d', strtotime('-6 days'));
$endDay		= (isset( $_GET['end_day'] ) && Validator::isDate($_GET['end_day']) )? SS($_GET['end_day']) : date('Y-m-d');
list($page, $pageSize) = getPagesParams();// 从请求中获取分页参数


//
$startDay = (strtotime($startDay) >= strtotime(ONLINEDATE)) ? $startDay : ONLINEDATE;
//$startTimestamp = Datatime::getDayBeginTimestamp($startDay);//
//$endTimestamp 	= Datatime::getDayEndTimestamp($endDay);//
//
/*
if( Validator::stringNotEmpty($roleName) || Validator::stringNotEmpty($accountName) )
{// 
	$user = UserClass::getUser($roleName, $accountName);
	if( !$user )
	{
		$errorMsg[] = $lang->msg->userNotExists;
	}
	$roleName 		= $user['role_name'];
	$accountName 	= $user['account_name'];
}
*/
$startTimestamp = Datatime::getDayBeginTimestamp($startDay);//
$endTimestamp 	= Datatime::getDayEndTimestamp($endDay);//

if( empty($errorMsg) )// 
{
	$viewData = getDealRecords($roleName, $accountName, $startTimestamp, $endTimestamp, $page, $pageSize );
	$pager = getPages2( $page, $viewData ['recordCount'], $pageSize );
	$smarty->assign( 'viewData', $viewData );
	$smarty->assign( 'pager', $pager );
} 


$smarty->assign( 'lang', $lang );
$smarty->assign( 'dictColor', $dictColor);

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
$smarty->display( 'module/player/player_deal.tpl' );


function getDealRecords($roleName = '', $accountName = '', $startTimestamp, $endTimestamp, $page, $pageSize)
{
	$andCond = array();
	$andCond[] = " mtime > $startTimestamp";
	$andCond[] = " mtime < $endTimestamp";
	if( Validator::stringNotEmpty($roleName) && Validator::stringNotEmpty($accountName) )
	{
		$andCond[] = " ( ( role_name = '$roleName' AND account_name = '$accountName' ) OR ( target_name = '$roleName' AND target_account = '$accountName' ) ) ";
	} 
	elseif( Validator::stringNotEmpty($roleName) ) 
	{
		$andCond[] = " role_name = '$roleName' OR target_name = '$roleName' ";
	}
	elseif( Validator::stringNotEmpty($accountName) ) 
	{	
		$andCond[] = " account_name = '$accountName' OR target_account = '$accountName' ";
	}

	$limit = '';
	if ( Validator::isInt($page) && $page > 0 &&
		 Validator::isInt($pageSize) && $pageSize > 0) 
	{
		$limit = ' LIMIT ' . (($page - 1) * $pageSize) . ', ' . $pageSize;
	}
	
	$whereCond = ' WHERE ' . implode(' AND ', $andCond);
//	$orderBy = ' ORDER BY ' .  $orderBy[0] . ' ' . $orderBy[1] . ' ';
	$orderBy = ' ORDER BY mtime DESC ';
	$sql = 'SELECT * FROM ' . T_LOG_DEAL  . $whereCond . $orderBy . $limit;

	$recordSet = GFetchRowSet($sql);
	
	
	foreach($recordSet as &$record)
	{
		if( Validator::stringNotEmpty($record['item_get']) )
		{/*
			// 解析发起方获得的物品
			$record['get_item_list'] = array();
			$items = explode( '$', $record['item_get'] );
			foreach( $items as $item )
			{
				if(Validator::stringNotEmpty($item))
				{
					list($item_id, $item_count, $is_bind, $item_attr_str) = explode('*', $item);
					$record['get_item_list'][$item_id] = getItemDetailArray($item_attr_str);
					$record['get_item_list'][$item_id]['item_count'] = $item_count;
					$record['get_item_list'][$item_id]['is_bind'] = $is_bind?"是":"否";
				}
			}*/
			$record['get_item_list'] = decodeItems($record['item_get']);
		}
		if( Validator::stringNotEmpty($record['item_lose']) )
		{/*
			// 解析目标方获得的物品
			$record['lose_item_list'] = array();
			
			$items = explode( '$', $record['item_lose'] );

			foreach( $items as $item )
			{
				if(Validator::stringNotEmpty($item))
				{
					list($item_id, $item_count, $is_bind, $item_attr_str) = explode('*', $item);
					$record['lose_item_list'][$item_id] = getItemDetailArray($item_attr_str);
					$record['lose_item_list'][$item_id]['item_count'] = $item_count;
					$record['lose_item_list'][$item_id]['is_bind'] = $is_bind?"是":"否";
				}
			}*/
			$record['lose_item_list'] =  decodeItems($record['item_lose']);
		}
	}
//echo "get_item_list=";print_r($record['get_item_list']);
//echo "lose_item_list=";print_r($record['lose_item_list']);
	$sqlCount = 'SELECT COUNT(*) row_count FROM ' . T_LOG_DEAL . $whereCond ;
	$recordCount = GFetchRowOne( $sqlCount );

	$data = array (
                    'recordCount' => $recordCount['row_count'],
                    'data' => $recordSet
            );
	return $data;
	
}