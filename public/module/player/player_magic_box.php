<?php
/**
 * 玩家武魂背包查询
 */
 
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';
include_once SYSDIR_ADMIN_DICT . '/arrItemsAll.php';

$action = SS($_GET['action']);
$errorMsg = $successMsg = array();// 消息数组
if("search" == $action){
    $role['account_name'] = autoAddPrefix(SS($_GET['account_name']));
    $role['role_name'] = autoAddPrefix(SS($_GET['role_name']));
    $searchItemId = intval($_GET['item_id']);
    
    $method = "getmagicbox";
    $params = array(
        'accountName' => $role['account_name'],
        'roleName' => $role['role_name'],
    );
    
    $interResult = interfaceRequest($method, $params);
    if(1 == $interResult['result']){
        $result = array();
        unset($interResult['data']['magicGridsLen']);
        $len = 0;
        if($interResult['data']){
            foreach($interResult['data'] as $key => $value){
                $itemId = $value['grid']['id'];
                if(($searchItemId && $searchItemId == $itemId) || !$searchItemId){
                    $result[$len]['id'] = $itemId;
                    $result[$len]['name'] = $arrItemsAll[$itemId]['name'];
                    $result[$len]['isBind'] = $value['grid']['isBind'] ? $lang->page->bind : $lang->page->unbind;
                    $result[$len]['count'] = $value['grid']['count'];
                    if(1 == substr($itemId, 0, 1)){
                        $result[$len]['color'] = substr($itemId, 5, 1);
                    }else if(2 == substr($itemId, 0, 1)){
                        $result[$len]['color'] = $value['grid']['equip']['color'];
                        $result[$len]['quality'] = $value['grid']['equip']['quality'];
                    }else if(3 == substr($itemId, 0, 1)){
                        $result[$len]['color'] = substr($itemId, 6, 1);
                    }
                    $len += 1;
                }
            }
        }
        $smarty->assign( 'viewData', $result);
        $smarty->assign( 'itemId', $searchItemId);
    }else{
        $errorMsg[] = $interResult['errorMsg'];
    }
    $smarty->assign( 'roleName', $role['role_name'] );
    $smarty->assign( 'accountName', $role['account_name'] );
}
$itemList = array();
foreach($arrItemsAll as $item){
	$itemList[$item['id']] = $item['name'];
}

$dictColorValue[0] = "black";//这里0的颜色为黑色

$smarty->assign( 'lang', $lang );
$smarty->assign( 'dictColorValue', $dictColorValue);
$smarty->assign( 'dictQuality', $dictQuality);
$smarty->assign( 'errorMsg', implode('<br/>', $errorMsg ) );
$smarty->assign('itemList', $itemList);
$smarty->display( 'module/player/player_magic_box.tpl' );