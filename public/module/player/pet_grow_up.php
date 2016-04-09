<?php
/**
 * 灵兽成长/天赋/资质查询
 */
 
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/arrItemsAll.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';

global $dictColor, $dictPet;
$typeList = array(0=> '不限', 1 => '成长', 2 => '资质', 3 => '天赋');
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

//请求参数获取
$roleName 		= (isset( $_GET['role_name'] ) && Validator::stringNotEmpty($_GET['role_name']) )? autoAddPrefix( SS($_GET['role_name']) ) : '';
$accountName 	= (isset( $_GET['account_name'] ) && Validator::stringNotEmpty($_GET['account_name']) )? autoAddPrefix( SS($_GET['account_name']) ) : '';
$petUID		 	= (isset( $_GET['pet_uid'] ) && Validator::stringNotEmpty($_GET['pet_uid']) )?  SS($_GET['pet_uid']) : '';
$startDay		= (isset( $_GET['start_day'] ) && Validator::isDate($_GET['start_day']) )? SS($_GET['start_day']) : date('Y-m-d', strtotime('-6 days'));
$endDay		= (isset( $_GET['end_day'] ) && Validator::isDate($_GET['end_day']) )? SS($_GET['end_day']) : date('Y-m-d');
$type		= (isset( $_GET['type'] ) && Validator::isInt($_GET['type']) )? intval( SS($_GET['type']) ) : 0;
list($page, $pageSize) = getPagesParams();// 从请求中获取分页参数

//
$startTimestamp = Datatime::getDayBeginTimestamp($startDay);//
$endTimestamp 	= Datatime::getDayEndTimestamp($endDay);//

$openTimestamp = strtotime( ONLINEDATE );
if($startTimestamp < $openTimestamp)
{
	$startTimestamp = $openTimestamp;
	$startDay = ONLINEDATE;
}
//
/* 不查是否存在
if( Validator::stringNotEmpty($roleName) || Validator::stringNotEmpty($accountName) )
{// 
	$user = UserClass::getUser($roleName, $accountName);
	if( !$user )
	{
		$errorMsg[] = $lang->msg->userNotExists;
	}
	$roleName 		= $user['role_name'];
	$accountName 	= $user['account_name'];
}*/
$startTimestamp = Datatime::getDayBeginTimestamp($startDay);//
$endTimestamp 	= Datatime::getDayEndTimestamp($endDay);//

if( empty($errorMsg) )// 
{
	$viewData = getPetGrowupRecords($roleName, $accountName, $petUID, $type, $startTimestamp, $endTimestamp, $page, $pageSize);

	$pager = getPages2( $page, $viewData ['recordCount'], $pageSize );
	$smarty->assign( 'viewData', $viewData );
	$smarty->assign( 'pager', $pager );
} 


$smarty->assign( 'lang', $lang );
$smarty->assign( 'dictColor', $dictColor);
$smarty->assign( 'dictPet', $dictPet );
$smarty->assign( 'type', $type);
$smarty->assign( 'typeList', $typeList);
$smarty->assign( 'sortArray', $sortArray);
$smarty->assign( 'petUID', $petUID);
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
$smarty->display( 'module/player/pet_grow_up.tpl' );


function getPetGrowupRecords($roleName = '', $accountName = '', $petUID = null, $type = 0, $startTimestamp, $endTimestamp, $page, $pageSize)
{
	$andCond = array();
	$andCond[] = " mtime > $startTimestamp";
	$andCond[] = " mtime < $endTimestamp";
	if( Validator::stringNotEmpty($roleName) ) $andCond[] = " role_name = '$roleName' ";
	if( Validator::stringNotEmpty($accountName) ) $andCond[] = " account_name = '$accountName' ";
	if( Validator::stringNotEmpty($petUID) ) $andCond[] = " pet_uid = $petUID ";
	if( Validator::isInt($type) && $type > 0 ) $andCond[] = " type = $type ";
	
	$limit = '';
	if ( Validator::isInt($page) && $page > 0 &&
		 Validator::isInt($pageSize) && $pageSize > 0) 
	{
		$limit = ' LIMIT ' . (($page - 1) * $pageSize) . ', ' . $pageSize;
	}
	
	$whereCond = ' WHERE ' . implode(' AND ', $andCond);
	$sql = 'SELECT * FROM ' . T_LOG_PET_GROW_UP  . $whereCond . ' ORDER BY mtime DESC' . $limit;

	$recordSet = GFetchRowSet($sql);
	
	$sqlCount = 'SELECT COUNT(*) row_count FROM ' . T_LOG_PET_GROW_UP . $whereCond  ;
	$recordCount = GFetchRowOne( $sqlCount );

	$data = array (
                    'recordCount' => $recordCount['row_count'],
                    'data' => $recordSet
            );
	return $data;
	
}