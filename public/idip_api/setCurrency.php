<?php
/**
*	Description:idip增加货币接口。
*/

include dirname(dirname(__FILE__)).'/idip_api/idip_auth.php';
include_once SYSDIR_ADMIN_CLASS.'/user_class.php';
$openid = $_GET['openid'];
$serverid = $_GET['serverID'];
$serverid = str_replace("s", "", $serverid);
$value = intval($_GET['value']);
$moneytype = intval($_GET['moneytype']);


$method = 'updateMoney';

$params = array();
if($openid){
	$method1 = "getuserstatus";

	$params1 = array();
	// $params1['accountName'] = $serverid.'-'.$openid;
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
$params['roleName'] = $roleName;  
$params['accountName'] = $roleid;
$params['MoneyCount'] = $value;
$params['MoneyType'] = $moneytype;



// new dBug("method:".$method);
// new dBug($params);

$result = interfaceRequest($method, $params);
// new dBug($result);
// die();
echo(@json_encode($result));
