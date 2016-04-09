<?php

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';
global $lang;

$action = isset($_GET['action']) ? SS($_GET['action']) : "list";

if("list" == $action || "search" == $action){//帮派列表
    // 发起http接口请求
    $method = 'getguildmessage';
    $guid = $_GET['guid'];
    $guildName = SS($_GET['guildName']);
    $params['action'] = $guildName ? "search" : "list";
    $params['guid'] = $guid;
    $params['guildName'] = $guildName;
    $result = interfaceRequest($method, $params);
    
    if(1 == $result['result']){
        if($result['data']){
            $guilds = array();
            foreach($result['data'] as $key => $value){
                $guilds[] = $value;
            }
            $smarty->assign("guilds", $guilds);
        }
    }else{
        $errorMsg = $result['errorMsg'];
    }
    $smarty->assign("guildName", $guildName);
}else if("detail" == $action){//成员列表
    // 发起http接口请求
    $method = 'getguildmessage';
    $params = array(
        'action' => $action,
    	'guid' => $_GET['guid'],
    	'guildName' => SS($_GET['guildName']),
    );
    $posArr = array(
        1 => $lang->guild->leader,
        2 => $lang->guild->pos2,
        3 => $lang->guild->pos3,
    );
    $result = interfaceRequest($method, $params);

    if(1 == $result['result']){
        if($result['data']['members']){
            $guildName = $result['data']['guildName'];
            foreach($result['data']['members'] as $key => $value){
                $value['isOnline'] = $value['isOnline'] ? '<font color="green">'.$lang->page->online.'</font>' : '<font color="red">'.$lang->page->offline.'</font>';
                $value['pos'] = $posArr[$value['pos']];
                $value['isget'] = $value['isget'] ? $lang->guild->hadGet : $lang->guild->noGet;
                $value['sex'] = $value['sex'] ? $lang->player->male : $lang->player->female;
                $value['job'] = $dictOccupationType[$value['job']];
                $value['loginTime'] = date("Y-m-d", $value['loginTime']);
                $members[] = $value;
            }
            $smarty->assign("guildName", $guildName);
            $smarty->assign("members", $members);
        }
    }else{
        $errorMsg = $result['errorMsg'];
    }
}
$smarty->assign("lang", $lang);
$smarty->assign("action", $action);
$smarty->display('module/guild/guild.tpl');