<?php
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT.'/dict.php';
global $lang;

$petUid = $_GET['petUid'];
$accountName = $_GET['accountName'];

$method = 'getuserpet';
$params = array(
	'accountName' => $accountName,
	'roleName' => '',
	'petUid' => $petUid,
);
$result = interfaceRequest($method, $params);

for ($i=0; $i<count($result['data']['pet']['skill']); $i++) {
	$skill .= $result['data']['pet']['skillName'][$i] . ":" . $lang->page->level . $result['data']['pet']['skillLv'][$i] . ' ';
}
$result['data']['pet']['color'] = $dictColor[$result['data']['pet']['color']];

$data = array(
	'pet' => $result['data']['pet'],
	'skill' => $skill,
	'roleName' => $result['data']['roleName'],
	'lang' => $lang,
); 

$smarty -> assign($data);
$smarty -> display('module/player/pet_detail.tpl');