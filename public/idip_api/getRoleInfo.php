<?php
/**
*	Description:idip查询角色信息接口。
*/

include dirname(dirname(__FILE__)).'/idip_api/idip_auth.php';
include_once SYSDIR_ADMIN_CLASS.'/user_class.php';
$openid = $_REQUEST['openid'];
$serverid = $_REQUEST['serverID'];
$serverid = str_replace("s", "", $serverid);

$method = "getuserstatus";

$params = array();
if($openid){
	if(intval($serverid) == 1){
		$params['accountName'] = '01-'.$openid;
	}elseif (intval($serverid) == 2) {
		$params['accountName'] = $openid;
	}else{
		$params['accountName'] = $serverid.'-'.$openid;
	}
	
}

//new dBug($params);
echo(@json_encode(interfaceRequest($method, $params)));