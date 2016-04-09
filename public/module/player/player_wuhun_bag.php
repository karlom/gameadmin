<?php
/**
 * 玩家武魂背包查询
 */
 
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';

$action = SS($_GET['action']);
$errorMsg = $successMsg = array();// 消息数组
if("search" == $action){
    $role['account_name'] = autoAddPrefix(SS($_GET['account_name']));
    $role['role_name'] = autoAddPrefix(SS($_GET['role_name']));
    
    $method = "getwuhunbag";
    $params = array(
        'accountName' => $role['account_name'],
        'roleName' => $role['role_name'],
    );
    
    $interResult = interfaceRequest($method, $params);
    if(1 == $interResult['result']){
        $numUper = array(
            1 => $lang->jingjie->one,
            2 => $lang->jingjie->two,
            3 => $lang->jingjie->three,
        );
        $smarty->assign( 'viewData', $interResult['data']);
        $smarty->assign( 'numUper', $numUper);
    }else{
        $errorMsg[] = $interResult['errorMsg'];
    }
    $smarty->assign( 'roleName', $role['role_name'] );
    $smarty->assign( 'accountName', $role['account_name'] );
}

$smarty->assign( 'lang', $lang );
$smarty->assign( 'dictColorValue', changeArrayBase($dictColorValue, 1));
$smarty->assign( 'errorMsg', implode('<br/>', $errorMsg ) );
$smarty->display( 'module/player/player_wuhun_bag.tpl' );