<?php
/**
 * 道具消耗排行
 */
 
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/arrItemsAll.php';

global $arrItemsAll;

$errorMsg = $successMsg = array();// 消息数组
$onlineDate = $serverList[$_SESSION ['gameAdminServer']]['onlinedate'];//开服日期

//请求参数获取
$startDay		= (isset( $_GET['start_day'] ) && Validator::isDate($_GET['start_day']) )? SS($_GET['start_day']) : date('Y-m-d', strtotime('-6 days'));
$endDay		= (isset( $_GET['end_day'] ) && Validator::isDate($_GET['end_day']) )? SS($_GET['end_day']) : date('Y-m-d');
$selectedDay = date('Y-m-d');
if(isPost())
{
	if(isset($_POST['selectedDay']) && Validator::isDate($_POST['selectedDay']))
	{
		$selectedDay = SS($_POST['selectedDay']);
	}
	if(isset($_POST['dateToday']))
	{
		$selectedDay = $startDay = $endDay = date('Y-m-d');
	}
	elseif(isset($_POST['datePrev']))
	{
		$selectedDay = $startDay = $endDay = date('Y-m-d', strtotime($selectedDay) - 86400);
	}
	elseif(isset($_POST['dateNext']))
	{
		$selectedDay = $startDay = $endDay = date('Y-m-d', strtotime($selectedDay) + 86400);
	}
	else
	{
		$startDay = $onlineDate;
		$selectedDay = $endDay = date('Y-m-d');
	}
	
}
//
$startTimestamp = Datatime::getDayBeginTimestamp($startDay);//
$endTimestamp 	= Datatime::getDayEndTimestamp($endDay);//

$openTimestamp = strtotime( ONLINEDATE );
if($startTimestamp < $openTimestamp)
{
	$startTimestamp = $openTimestamp;
	$startDay = ONLINEDATE;
}

if($startTimestamp > $endTimestamp)
{
	$errorMsg[] = $lang->page->startTimeGtEndTime;
}
if( empty($errorMsg) )// 
{
	$viewData = getItemConsumeStatistics($startTimestamp, $endTimestamp);
	$smarty->assign( 'viewData', $viewData );
}

$smarty->assign( 'lang', $lang );
$smarty->assign( 'selectedDay', $selectedDay);
$smarty->assign( 'arrItemsAll', $arrItemsAll);
$smarty->assign( 'errorMsg', implode('<br/>', $errorMsg ) );
$smarty->assign( 'successMsg', implode('<br/>', $successMsg ) );
$smarty->assign( 'minDate', $onlineDate);
$smarty->assign( 'maxDate', Datatime :: getTodayString());
$smarty->assign( 'startDay', $startDay );
$smarty->assign( 'endDay', $endDay );
$smarty->assign( 'roleName', $roleName );
$smarty->assign( 'accountName', $accountName );
$smarty->display( 'module/item/item_consume_statistics.tpl' );


function getItemConsumeStatistics( $startTimestamp, $endTimestamp)
{	
	// 当期统计
	$sqlCurrent = 'SELECT 
						SUM(item_num) consume_count, item_id 
				   FROM ' . T_LOG_ITEM . " 
				   WHERE mtime >  $startTimestamp AND  mtime < $endTimestamp
				   GROUP BY item_id 
				   ORDER BY consume_count DESC";
	$currentResult = IBFetchRowSet($sqlCurrent);
	
	// 上一期统计
	$preStartTimeStamp = $startTimestamp - ($endTimestamp - $startTimestamp + 1);
	$preEndTimeStamp = $startTimestamp - 1;
	$sqlPre = 'SELECT 
						SUM(item_num) consume_count, item_id 
				   FROM ' . T_LOG_ITEM . " 
				   WHERE mtime >  $preStartTimeStamp AND  mtime < $preEndTimeStamp
				   GROUP BY item_id 
				   ORDER BY consume_count DESC";
	$preResult = IBFetchRowSet($sqlPre);
	$preRank = array();
	foreach ($preResult as $key => $record)
	{
		$preRank[ $record['item_id'] ] = $key + 1;
	}

	// 计算排名变化
	foreach ($currentResult as $key => &$record)
	{
		$pRank = $preRank[ $record['item_id'] ];
		if (!is_null($pRank))
		{
			$record['rank_change'] = $pRank - ($key + 1);
		}
		else 
		{
			$record['rank_change'] = 0;
		}
	}

	return $currentResult;
	
}