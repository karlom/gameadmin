<?php 
/**
 * 当前在线用户
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';
include_once SYSDIR_ADMIN_DICT . '/map.php';

global $lang, $dictOccupationType, $dictSideType, $dictMap;


$opGap = 15;// 操作间隔

$openTimestamp = strtotime( $serverList[$_SESSION ['gameAdminServer']]['onlinedate'] );

$errorMsg = $successMsg = array();// 消息数组


$onlineList = array();


if ( isPost() && isset($_POST['update']))
{// 删除缓存
	if( isset( $_SESSION['last_update_time'] ) && (time() - $_SESSION['last_update_time']) < $opGap )
	{// 防止频繁点击刷新按钮
		$errorMsg[] = $lang->player->noFrequentUpdate . $opGap . ' s';
	}
	else
	{
		$_SESSION['last_update_time'] = time();
		RequestCollection::delOnlineListCache();
	}
}

$onlineList = RequestCollection::getOnlineList();

//print_r($onlineList);die();



if($onlineList["data"]) {
	foreach ($onlineList["data"] as $key => $row) {
		$onlineList['data'][$key]['lastCG'] = empty($row['lastCG']) ? 0 : date("Y-m-d H:i:s", $row['lastCG']/1000);	
	}
}

$payUserCount = 0 ;
$payUserCount = getPayUserOnlineCount();

// 格式化以IP分组的记录
$onlineListGroupedRaw = groupByIndexValue($onlineList['data'], 'ip');
//print_r($onlineListGroupedRaw);
$onlineListGrouped = array();
foreach ( $onlineListGroupedRaw as $key => $list)
{
	$onlineListGrouped[$key] = array();
	$accountNameList = $roleNameList = array();
	foreach ($list as $log)
	{
		if($log['isPay']){
			$accountNameList[] = '<a href="#" class="cmenu" title="' . $log['roleName'] . '" style="color:#FF8800">' . $log['accountName'] . '</a>';
			$roleNameList[] = '<a href="#" class="cmenu" title="' . $log['roleName'] . '" style="color:#FF8800">' . $log['roleName'] . '</a>';
		} else {
			$accountNameList[] = '<a href="#" class="cmenu" title="' . $log['roleName'] . '">' . $log['accountName'] . '</a>';
			$roleNameList[] = '<a href="#" class="cmenu" title="' . $log['roleName'] . '">' . $log['roleName'] . '</a>';
		}
	}
	$onlineListGrouped[$key]['ip'] = $key;
	$onlineListGrouped[$key]['count'] = count($list);
	$onlineListGrouped[$key]['accountNameStr'] = implode(', ', $accountNameList);
	$onlineListGrouped[$key]['roleNameStr'] = implode(', ', $roleNameList);
}

$onlineListGrouped = sortArrayByKey($onlineListGrouped, 'ip', 'desc');
$onlineListGrouped = sortArrayByKey($onlineListGrouped, 'count', 'desc');
// 格式化以地图分组的记录
$onlineCountByMap = array();
foreach( $dictMap as $map )
{
	$onlineCountByMap[$map['id']]['count'] = 0;
	$onlineCountByMap[$map['id']]['percentage'] = '0%';
}
if (is_array($onlineList['data']))
{
	foreach ( $onlineList['data'] as $key => $record)
	{
		$onlineCountByMap[$record['mapID']]['count']++;
	}
}
$onlineCount = count($onlineList['data']);
if($onlineCount > 0)
{
	foreach($onlineCountByMap as &$count)
	{
		$count['percentage'] = round($count['count'] / $onlineCount, 2) * 100 . '%';
	}
}
// 设置smarty的变量
$smarty->assign( 'player_statistics', $playerStatistics );
$minDate = $serverList[$_SESSION ['gameAdminServer']]['onlinedate'];
$maxDate = Datatime :: getTodayString();
$smarty->assign( 'minDate', $minDate);
$smarty->assign( 'maxDate', $maxDate); 
$smarty->assign( 'onlineCountByMap', $onlineCountByMap); 
$smarty->assign( 'onlineList', $onlineList); 
$smarty->assign( 'onlineListGrouped', $onlineListGrouped); 
$smarty->assign( 'dictOccupationType', $dictOccupationType); 
$smarty->assign( 'dictSideType', $dictSideType); 
$smarty->assign( 'dictMap', $dictMap); 
$smarty->assign( 'errorMsg', 	implode('<br/>', $errorMsg ) );
$smarty->assign( 'successMsg', 	implode('<br/>', $successMsg ) );
$smarty->assign( 'lang', 	$lang );
$smarty->assign( 'payUserCount', $payUserCount);
$smarty->display( 'module/player/online_user.tpl' );
