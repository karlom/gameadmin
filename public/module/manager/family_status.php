<?php
/**
 * restore_family.php
 * 查询历史玩家信息，并进行恢复
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';
include_once SYSDIR_ADMIN_CLASS.'/user_class.php';
include_once SYSDIR_ADMIN_DICT.'/dict.php';
include_once SYSDIR_ADMIN_DICT.'/arrItemsAll.php';
include_once SYSDIR_ADMIN_DICT.'/map.php';

global $lang,$dictMap;

$arrFcm = array(
	0=>$lang->verify->pass,
	1=>$lang->verify->notPass,
	2=>$lang->verify->notReg,
	3=>$lang->verify->use.GAME_ZH_NAME.$lang->verify->fcmSYS,
);
$action = $_POST['action'];
//$role = isPost() ? $_POST['role'] : "";
$stones = array();
$itemsOrd = array();
$familyName = $_POST['familyName'];
//$newFamilyName = $_POST['newFamilyName'];

/*
$serv = "s0";	//固定从s0取
if(!isset($serverList[$serv])){
	$msg[] = '没有找到中转服务器的配置，请先配置！';
}
*/	
if($familyName ){

	$family = array();
   
    $method = "getFamilyByName";
	$params = array( 'familyName' => $familyName, );

	$familyData = interfaceRequest($method, $params );
	
    if($familyData['result'] == 1) {
    	$family = $familyData['family'];
    } else {
    	$msg[] = '查询家族信息失败！'.$familyData['msg'];
    }
//    print_r($family);
    
    $strMsg = empty($msg) ? '' : implode('<br />', $msg);
    $data = array(
        'role' => $role,
        'arrItemsAll' => $arrItemsAll,
        'familyName' => $familyName,
        'newFamilyName' => $newFamilyName,
        'family' => $family,
        'account' => $account,
        'dictJobs' => $dictJobs,
        'dictSex' => $dictSex,
        'dictFamilyOffical' => $dictFamilyOffical,
    );

} else {
	$msg[] = '请输入家族名';
}

$data['lang'] = $lang;
$data['strMsg'] = $strMsg;
$data['dictMap'] = $dictMap;
$smarty->assign($data);
$smarty->display("module/manager/family_status.tpl");