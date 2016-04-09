<?php
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
global $lang;

$roleName = SS( $_GET['roleName'] );
$accountName = SS( $_GET['accountName'] );

// 发起http接口请求
$method = 'getuserpet';
if ( !empty($accountName) || !empty($roleName) ) {
	$params = array(
		'accountName' => empty($accountName) ? '' : autoAddPrefix($accountName),
		'roleName' => empty($roleName) ? '' : autoAddPrefix($roleName),
		'petUid' => '',
	);
	$result = interfaceRequest($method, $params);
}

$data = array(
	'accountName' => $result['data']['accountName'],
	'roleName' => $result['data']['roleName'],
	'pets' => $result['data']['pet'],
	'lang' => $lang,
);

if ( $result['errorMsg'] == 'UserNotExist'){
	$data['UserNotExist'] = true;
}

$smarty->assign($data);
$smarty->display('module/player/pet_info.tpl');