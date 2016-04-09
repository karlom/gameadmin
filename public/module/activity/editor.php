<?php
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';
include_once SYSDIR_ADMIN_DICT . '/arrItemsAll.php';
global $lang;

$title = $_GET['title'];
$action = $_GET['action'];
$id = $_GET['id'];

$itemList = array();
foreach($arrItemsAll as $items){
	$itemList[$items['id']] = $items['name'];
};

$rankType = array(
	'' => '',
	'board_lv' => '个人等级',
	'board_guild' => '帮派等级(成员都可领取)',
	'board_guild_lord_award' => '帮派等级(由帮主领取)',
	'board_equip' => '装备评分',
	'board_weapon' => '武器评分',
	'board_flower_recv_yesterday' => '收花',
	'board_flower_send_yesterday' => '送花',
	'board_pet_atk' => '宠物战斗力',
	'board_pet_grow' => '宠物成长',
	'board_pet_zizhi' => '宠物资质',
	'board_fight' => '个人战斗力',
	'board_tomb' => '盗墓迷城',
);

$collectType = array(
	'' => '',
	'collect_item' => '收集道具',
	'collect_suit' => '收集套装',
);

$chargeType = array(
	'' => '',
	'single_pay' => '单笔充值',
	'total_pay' => '累积充值',
	'consume' =>  '充值消费',
);

if ( $action == 'view' or $action == 'update' ){
	$sql = "SELECT * FROM t_activity WHERE state=0 AND id=$id";
	$item = GFetchRowOne($sql);
	//$desc = str_replace('\\', '', $item['desc']);
	$desc = stripslashes($item['desc']);
	$item['conditionAward'] = json_decode($item['conditionAward'],TRUE);
	if ( $item['fromOnlineDate'] == 1 ){
		$v = 1;
		$a = 1;
		$r = 1;
		
		$vBegin = explode('-', $item['showTimeBegin']);
		$item['v_start_open_day'] = $vBegin[0];
		$item['v_start_open_time'] = $vBegin[1];
		$vEnd = explode('-', $item['showTimeEnd']);
		$item['v_end_open_day'] = $vEnd[0];
		$item['v_end_open_time'] = $vEnd[1];
		
		$aBegin = explode('-', $item['actBegin']);
		$item['a_start_open_day'] = $aBegin[0];
		$item['a_start_open_time'] = $aBegin[1];
		$aEnd = explode('-', $item['actEnd']);
		$item['a_end_open_day'] = $aEnd[0];
		$item['a_end_open_time'] = $aEnd[1];
		
		$rBegin = explode('-', $item['timeAwardBegin']);
		$item['r_start_open_day'] = $rBegin[0];
		$item['r_start_open_time'] = $rBegin[1];
		$rEnd = explode('-', $item['timeAwardEnd']);
		$item['r_end_open_day'] = $rEnd[0];
		$item['r_end_open_time'] = $rEnd[1];
	}
	$item['id'] = $id;
}

$rs = array(
	'title' => $title,
	'lang' => $lang,
	'rankType' => $rankType,
	'collectType' => $collectType,
	'chargeType' => $chargeType,
	'equipQuality' => $dictQuality,
	'equipColor' => $dictColor,
	'action' => $action,
	'item' => $item,
	'cmd' => $item['cmd'],
	'itemList' => $itemList,
	'suitList' => $dictSuitID,
	'v_status' => json_encode($v),
	'a_status' => json_encode($a),
	'r_status' => json_encode($r),
	'desc' => $desc,
);

$smarty -> assign($rs);
$smarty -> display('module/activity/editor.tpl');
