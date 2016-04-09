<?php
/**
*	Description:idip发送道具接口。
*/

include dirname(dirname(__FILE__)).'/idip_api/idip_auth.php';
include_once SYSDIR_ADMIN_CLASS.'/user_class.php';
$openid = $_GET['openid'];
$serverid = $_GET['serverID'];
$serverid = str_replace("s", "", $serverid);
$itemid = intval($_GET['itemid']);
$itemcount = intval($_GET['itemcount']);
$strenlevel = intval($_GET['strenlevel']);
$validtime = $_GET['validtime'];
$mailtitle = $_GET['mailtitle'];
$mailcontent = $_GET['mailcontent'];



$method = 'applygoods';

$params = array();
if($openid){
	$method1 = "getuserstatus";

	$params1 = array();

	if(intval($serverid) == 1){
		$params1['accountName'] = '01-'.$openid;
	}elseif (intval($serverid) == 2) {
		$params1['accountName'] = $openid;
	}else{
		$params1['accountName'] = $serverid.'-'.$openid;
	}

	$player = @json_encode(interfaceRequest($method1, $params1));
	$player = json_decode($player,true);
	//new dBug($player);
	if($player[result] == 3){
		$rsp = array(
			'result' => 2,
			'msg' => $player[errorMsg],
			);
		echo(json_encode($rsp));
		die();
	}
	$roleid = $player[data][player][accountName];
	$roleName = $player[data][player][roleName];
}
$params['sendType'] = 0;  //发给指定玩家
$params['applyID'] = 0;
$params['mailTitle'] = $mailtitle;
$params['mailContent'] = $mailcontent;
$params['roleNameList'] = array($roleName);//角色名？
unset($params['roleNameList']['selectedCompare']);
unset($params['roleNameList']['familyName']);
$item = array(
	'id' => $itemid, 
	// 'id' => 12527,
	'bind' => 1, 
	'cnt' => $itemcount, 
	'quality' => 1, 
	'strengthenLv' => $strenlevel, 
	'gems' => array(), 
	);
// id,			--物品id
// 	bind   		–物品绑定
// 	cnt		–物品数量
// 	quality		--装备品质
// 	strengthenLv –装备强化等级
// 	gems		--装备灵石  {灵石id1,灵石id2}

// $params['items'] = $item;
$items = array();
array_push($items, $item);
$params['items'] = $items;

// new dBug("method:".$method);
// new dBug($params);

$result = interfaceRequest($method, $params);
// new dBug($result);
// die();
echo(@json_encode($result));
