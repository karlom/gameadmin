<?php
/**
 * 副本道具掉落统计
 */
 
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/arrItemsAll.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';
global $dictWealthType;
$errorMsg = $successMsg = array();
$versionList = getWealthStatisticsVersionList();
$history = array();
foreach($versionList as $version)
{
	$history[$version['mtime']] = date('Y-m-d, H', $version['mtime']);
}

$selectedVersion = (isset($_GET['selected_version']) && Validator::isInt($_GET['selected_version']) && array_key_exists($_GET['selected_version'], $history) )?$_GET['selected_version']: $history[-1];
$selectedType = (isset($_GET['selected_type']) && Validator::isInt($_GET['selected_type']) && array_key_exists($_GET['selected_type'], $dictWealthType) )?$_GET['selected_type']: -1;
//dump(getWealthStatistics('gold'));
$typeArray = array($selectedType);

//$typeArray = array(0,1);
$viewData = getWealthStatisticsResult($typeArray, $selectedVersion);


$smarty->assign( 'lang', $lang );
$smarty->assign( 'history', $history);
$smarty->assign( 'selectedVersion', $selectedVersion);
$smarty->assign( 'dictWealthType', $dictWealthType);
$smarty->assign( 'selectedType', $selectedType);
$smarty->assign( 'viewData', $viewData);
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
$smarty->display( 'module/basedata/wealth_statistics.tpl' );


function getWealthStatisticsResult($type = array(0), $timestamp = -1)
{
	$andCond = array();
	$result = array();
	if( $timestamp > 0)
	{
		$andCond[] = " mtime = $timestamp ";
	}
	else
	{
		$sqlNewestVersion = 'SELECT MAX(mtime) new_version FROM ' . T_LOG_WEALTH;
		$newestVersion = GFetchRowOne($sqlNewestVersion);
		if($newestVersion['new_version']){
			$andCond[] = ' mtime = ' . $newestVersion['new_version'] . ' ';
		}
	}
	if (empty($andCond))
	{
		return $result;
	}
	
	if( is_array($type) )
	{
		if( !in_array(-1, $type) )
		{
			$typeStr = implode(', ', $type);
			$andCond[] = " type in ($typeStr) ";
		}
	}
	$andStr = implode(' AND ', $andCond);
	$sqlWealthStatisticsResult = "SELECT * FROM " . T_LOG_WEALTH . " WHERE 1 AND " . $andStr;
	
	$wealthStatistics = GFetchRowSet($sqlWealthStatisticsResult);
	

	foreach($wealthStatistics as $wealthStatisticsRecord)
	{
		if($result[$wealthStatisticsRecord['type']]['total_men_count'] == null)
			$result[$wealthStatisticsRecord['type']]['total_men_count'] = 0;
		if($result[$wealthStatisticsRecord['type']]['total_value_count'] == null)
			$result[$wealthStatisticsRecord['type']]['total_value_count'] = 0;
			
		$result[$wealthStatisticsRecord['type']]['total_men_count'] += $wealthStatisticsRecord['men_count'];
		$result[$wealthStatisticsRecord['type']]['total_value_count'] += $wealthStatisticsRecord['total_value'];
		$result[$wealthStatisticsRecord['type']]['data'][] = $wealthStatisticsRecord;
	}
	
//	dump($result);
	$data = array( 'data' => $result );
	return $data;
	
}

function getWealthStatisticsVersionList()
{
	$sql = "SELECT DISTINCT(mtime) FROM " . T_LOG_WEALTH;
	return GFetchRowSet($sql);
}