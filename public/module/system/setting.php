<?php
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';

$timestamp = time();
$key = md5($timestamp.ADMIN_GAME_AUTH_KEY);
if (isPost()) {
	$conf = $_POST['conf'];
	$encodeConf = urlencode( base64_encode(json_encode($conf)) );
	$params = 'key='.$key.'&timestamp='.$timestamp.'&data='.$encodeConf;
	$result = curlPost(GAMER_SERVER_SET_CLIENT_CONF_URL,$params);
	$result = json_decode($result,true);
	if (!$result || 1 != $result['result']) {
		$result['errorMsg'] = $result['errorMsg'] ? $result['errorMsg'] : '同步数据出错:可能无法连接游戏服务器!';
		$msg[] = $result['errorMsg'];
	}else{
		$msg[] = '保存成功！';
	}
}

$params = "?timestamp={$timestamp}&key={$key}";
$getJsonClientConf = @file_get_contents(GAMER_SERVER_GET_CLIENT_CONF_URL.$params);
$result = json_decode($getJsonClientConf,true);
if (1!=$result['result']) {
	$result['errorMsg'] = $result['errorMsg'] ? $result['errorMsg'] : '获取数据出错:可能无法连接游戏服务器!';
	$msg[] = $result['errorMsg'];
}

$data=array(
	'conf'=>$result['data'],
	'strMsg'=>empty($msg) ? '' : implode('<br />',$msg),
	'AGENT_ID'=>AGENT_ID,
	'AGENT_NAME'=>AGENT_NAME,
	'SERVER_ID'=>SERVER_ID,
	'SERVER_NAME'=>SERVER_NAME,
);
render('module/system/setting.tpl',$data);
