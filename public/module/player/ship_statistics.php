<?php
/**
 * 船运统计
 */
 
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';

global $dictColor, $dictShipResult;
unset($dictColor[count($dictColor) - 1]);//去掉金色
$dictColor = changeArrayBase($dictColor, 1);

$errorMsg = $successMsg = array();// 消息数组
$onlineDate = $serverList[$_SESSION ['gameAdminServer']]['onlinedate'];//开服日期

//请求参数获取
$startDay		= (isset( $_GET['start_day'] ) && Validator::isDate($_GET['start_day']) )? SS($_GET['start_day']) : date('Y-m-d', strtotime('-6 days'));
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

if($startTimestamp > $endTimestamp)
{
	$errorMsg[] = $lang->page->startTimeGtEndTime;
}
if( empty($errorMsg) )// 
{
	$viewData = getShipStatistics($startTimestamp, $endTimestamp, $dictColor);
	$smarty->assign( 'viewData', $viewData );
}

$smarty->assign( 'lang', $lang );
$smarty->assign( 'dictColor', $dictColor);
$smarty->assign( 'dictShipResult', $dictShipResult);
$smarty->assign( 'errorMsg', implode('<br/>', $errorMsg ) );
$smarty->assign( 'successMsg', implode('<br/>', $successMsg ) );
$smarty->assign( 'minDate', $onlineDate);
$smarty->assign( 'maxDate', Datatime :: getTodayString());
$smarty->assign( 'startDay', $startDay );
$smarty->assign( 'endDay', $endDay );
$smarty->assign( 'roleName', $roleName );
$smarty->assign( 'accountName', $accountName );
$smarty->display( 'module/player/ship_statistics.tpl' );


function getShipStatistics( $startTimestamp, $endTimestamp, $dictColor)
{
	$andCond = array();
	$andCond[] = " mtime > $startTimestamp";
	$andCond[] = " mtime < $endTimestamp";
	$generalWhereCond = implode(' AND ', $andCond);
	
	// 初始化结果数组
	$viewData = array();
	$viewData['accept_color'] = $viewData['refresh_color'] = $viewData['refresh_color_times'] = array();
	$tmpColorList = array();
	foreach( array_keys($dictColor) as $key )
	{
		$viewData['accept_color'][$key] = $viewData['refresh_color'][$key] = 0;
		$tmpColorList[$key] = 0;
	}
	//$sqlMaxRefreshTimes = "SELECT MAX(refresh_times) max_refresh_times FROM " . T_LOG_ESCORT . " WHERE $generalWhereCond";
	$sqlMaxRefreshTimes = 'SELECT MAX(refresh_times) max_refresh_times FROM (SELECT SUM(refresh_times) refresh_times  FROM ' . T_LOG_SHIP_REFRESH . " WHERE $generalWhereCond GROUP BY role_name, ship_times, year, month, day) t1";
	$resultMaxRefreshTimes = GFetchRowOne($sqlMaxRefreshTimes);
	$maxRefreshTimesLayer = floor($resultMaxRefreshTimes['max_refresh_times'] / 10);
	for ( $i = 0; $i <= $maxRefreshTimesLayer; $i++ )
	{
		$start = $i == 0? 1: $i * 10;
		$end   = ($i + 1) * 10 - 1;
		$viewData['refresh_color_times'][$i] = array('label' => $start . ' - ' . $end, 'data' => $tmpColorList);
	}

	
	// 汇总统计
	$sqlGeneral = "SELECT 
					(SELECT COUNT(*) FROM " . T_LOG_SHIP . " WHERE result = 1 AND $generalWhereCond) accept_times,
					(SELECT COUNT(*) FROM " . T_LOG_SHIP . " WHERE result = 2 AND $generalWhereCond) finish_times,
					(SELECT COUNT(*) FROM " . T_LOG_SHIP . " WHERE result = 4 AND $generalWhereCond) abandon_times,
					(SELECT COUNT(distinct(account_name)) FROM " . T_LOG_SHIP . " WHERE result = 1 AND $generalWhereCond) accept_role_counts,
				    (SELECT COUNT(distinct(account_name)) FROM " . T_LOG_SHIP . " WHERE result = 2 AND $generalWhereCond) finish_role_counts";
	$viewData['general'] = GFetchRowOne($sqlGeneral);
	
	// 船运颜色分布统计
	$sqlInitColor = "SELECT COUNT(*) times, ship_type FROM " . T_LOG_SHIP . " WHERE result = 1 AND $generalWhereCond GROUP BY ship_type";
	$initColor = GFetchRowSet($sqlInitColor);
	foreach( $initColor as $item )
	{
		$viewData['accept_color'][$item['ship_type']] = $item['times'];
	}
	
	// 刷新后船运颜色分布统计
//	$sqlRefreshColor = "SELECT COUNT(*) times, escort_type FROM " . T_LOG_ESCORT . " WHERE result = 1 AND refresh_times > 0 GROUP BY escort_type";
	$sqlRefreshColor = 'SELECT COUNT(t.refresh_times) times, t.ship_type
						FROM (
							SELECT 
								t1.mtime, t1.role_name, t1.account_name,  t2.refresh_times, t1.ship_type, t1.result 
							FROM ' . T_LOG_SHIP . ' t1 
							LEFT JOIN (
								SELECT SUM(refresh_times) refresh_times, role_name, ship_times, year, day, month FROM ' . T_LOG_SHIP_REFRESH ." WHERE $generalWhereCond GROUP BY role_name, ship_times, year, month, day
								) t2 
							ON 
								t1.role_name = t2.role_name AND t1.ship_times = t2.ship_times AND t1.`year` = t2.`year` AND t1.`month` = t2.`month` AND t1.`day` = t2.`day` 
							 WHERE $generalWhereCond AND t1.result = 1 AND t2.refresh_times > 0
						) t GROUP BY t.ship_type";

	$refreshColor = GFetchRowSet($sqlRefreshColor);
	foreach( $refreshColor as $item )
	{
		$viewData['refresh_color'][$item['ship_type']] = $item['times'];
	}
	
	// 刷新船运颜色次数分布统计
//	$sqlRefreshColorTimes = "SELECT COUNT(*) times, escort_type, FLOOR(refresh_times/10) layer FROM " . T_LOG_ESCORT . " WHERE result = 1 AND refresh_times > 0 GROUP BY FLOOR(refresh_times/10)";
	$sqlRefreshColorTimes = 'SELECT count(t.refresh_times) times, t.ship_type, FLOOR(t.refresh_times/10) layer
								FROM (
									SELECT 
										t1.mtime, t1.role_name, t1.account_name, t2.refresh_times, t1.ship_type, t1.result 
									FROM ' . T_LOG_SHIP . ' t1 
									LEFT JOIN (
										SELECT SUM(refresh_times) refresh_times, role_name, ship_times, year, day, month FROM ' . T_LOG_SHIP_REFRESH ." WHERE $generalWhereCond GROUP BY role_name, ship_times, year, month, day
										) t2 
									ON 
										t1.role_name = t2.role_name AND t1.ship_times = t2.ship_times AND t1.`year` = t2.`year` AND t1.`month` = t2.`month` AND t1.`day` = t2.`day` 
									 WHERE $generalWhereCond AND t1.result = 1 AND t2.refresh_times > 0
								) t GROUP BY FLOOR(t.refresh_times/10), t.ship_type";
	
	$refreshColorTimes= GFetchRowSet($sqlRefreshColorTimes);
	//dump($sqlRefreshColorTimes);
	foreach($refreshColorTimes as $item)
	{
		$viewData['refresh_color_times'][$item['layer']]['data'][$item['ship_type']] = $item['times'];
	}
	
	
	//dump($viewData);
	return $viewData;
	
}