<?php
/**
 * personal_chat_statistic.php
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
global $channelArray;

$errorMsg = $successMsg = array();
$roleName 	= isset( $_REQUEST['role_name'] )? SS($_REQUEST['role_name']) : "";

$chatChannelArray = array(
	"world" => 1,
	"family" => 2,
	"team" => 3,
	"near" => 7,
	"laba" => 6,
	"activity" => 8,
	"friend" => 9,
	"all" => 10,
);

$nowTime = time();
//$today = date("Y-m-d H:i:s");
$today = date("Y-m-d");

$viewData = array();

if(!empty($roleName)) {
	$chatDataAll = getChatData($roleName);

	if(!empty($chatDataAll)) {
		$data['all'] = $chatDataAll;
		$viewData['uuid'] = $chatDataAll['uuid'];
		$viewData['account_name'] = $chatDataAll['account_name'];
		$viewData['role_name'] = $chatDataAll['role_name'];
		$viewData['lastSpeakTime'] = $chatDataAll['lastSpeakTime'];
		$viewData['lastSpeakChannel'] = $chatDataAll['lastSpeakChannel'];
		$all = $chatDataAll['chat'][10]['cnt'];
		foreach($chatChannelArray as $k => $v ) {
			$viewData['chat'][$k]['cnt'] = isset($chatDataAll['chat'][$v]['cnt'])?$chatDataAll['chat'][$v]['cnt']:0;
			$viewData['chat'][$k]['perc'] = "(".ceil($viewData['chat'][$k]['cnt']*100/$all)."%)";
		}
	}
//	$chatDataWeek = getChatData($roleName,strtotime($today." 00:00:00 -7 day"));
//	$chatDataMonth = getChatData($roleName,strtotime($today." 00:00:00 -30 day"));

} 

//print_r($viewData);

$smarty->assign( 'viewData', 	$viewData );
$smarty->assign( 'roleName', 	$roleName );
$smarty->assign( 'lang', 	$lang );
$smarty->assign( 'errorMsg', 	implode('<br/>', $errorMsg ) );
$smarty->assign( 'successMsg', 	implode('<br/>', $successMsg ) );
$smarty->display( 'module/msg/personal_chat_statistic.tpl' );

function getChatData($roleName, $startTime=""){
	$cond = " 1 ";
	if(!empty($roleName)) {
		$cond .= " AND role_name='{$roleName}' ";
	}
	
	if(!empty($startTime) && is_numeric($startTime)) {
		$cond .= " AND mtime>={$startTime} ";
	}
	
	//各频道说话记录数
	$sql_channel = "SELECT uuid, account_name, role_name, channel, count(id) cnt FROM " 
		. T_LOG_CHAT . 
		" WHERE $cond GROUP BY channel" ;
	$data1 = GFetchRowSet( $sql_channel );

	$all = 0 ;
	if(!empty($data1)) {
		global $channelArray;
		foreach($data1 as $key => $value){
			$data['uuid'] = $value['uuid'];
			$data['account_name'] = $value['account_name'];
			$data['role_name'] = $value['role_name'];
			$data['chat'][$value['channel']]['id'] = $value['channel'];
			$data['chat'][$value['channel']]['name'] = $channelArray[$value['channel']];
			$data['chat'][$value['channel']]['cnt'] = $value['cnt'];
			$all += $value['cnt'];
		}
	}
	
	//好友说话记录数
	$sql_friend = "SELECT uuid, account_name, role_name, count(id) cnt FROM "
		. T_LOG_FRIEND_CHAT . 
		" WHERE $cond GROUP BY uuid";
	$data2 = GFetchRowOne( $sql_friend );

	if(!empty($data2)) {
			$data['chat'][9]['id'] = 9;
			$data['chat'][9]['name'] = '好友';
			$data['chat'][9]['cnt'] = $data2['cnt'];
			$all += $data2['cnt'];
	}
	
	if(!empty($data)){
		$data['chat'][10]['id'] = 10;
		$data['chat'][10]['name'] = '全部';
		$data['chat'][10]['cnt'] = $all;
	}
	
	$sql = "SELECT uuid, account_name, role_name, channel, mtime, mdate FROM "
			. T_LOG_CHAT . 
			" WHERE mtime=(SELECT MAX(mtime) FROM ". T_LOG_CHAT . " WHERE $cond )";
	$data3 = GFetchRowOne($sql);
	
	$sql2 = "SELECT uuid, account_name, role_name, targetName, mtime, mdate FROM "
			. T_LOG_FRIEND_CHAT . 
			" WHERE mtime=(SELECT MAX(mtime) FROM ". T_LOG_FRIEND_CHAT ." WHERE $cond )";
	$data4 = GFetchRowOne($sql2);
	
	//最后聊天时间、频道
	if($data3['mtime'] > $data4['mtime']){
		$data['lastSpeakTime'] = $data3['mtime'];
		$data['lastSpeakChannel'] = $channelArray[$data3['channel']];
	} else if(!empty($data4['mtime'])){
		$data['lastSpeakTime'] = $data4['mtime'];
		$data['lastSpeakChannel'] = '好友';
	}
	
	return $data;
}