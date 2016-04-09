<?php
/**
 * 赠送元宝
 * Author: zhangyoucheng
 * 2012-05-16
 */
 
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';

$action = SS($_GET['action']);
$errorMsg = $successMsg = array();// 消息数组
if("send" == $action){
    $role_name = autoAddPrefix(SS($_GET['role_name']));
    $yuanbao = intval($_GET['yuanbao']);
    $type = intval($_GET['type']);
    
    if("" != $yuanbao && "" != $role_name){
        $method = "sendyuanbao";
        $params = array(
            'roleName' => $role_name,
            'yuanbao' => $yuanbao,
            'type' => $type,
        );
        
        $interResult = interfaceRequest($method, $params);
        if(1 == $interResult['result']){
            $successMsg[] = $lang->gold->sendSuccess;
            $insert = array(
                "role_name" => $role_name,
                "send_num" => $yuanbao,
                "type" => $type,
                "mtime" => NOW_TIMESTAMP,
                "admin_name" => $auth->username(),
            );
            $sql = makeInsertSqlFromArray($insert, T_LOG_SEND_YUANBAO);
            GQuery($sql);
            //写日志
            $log = new AdminLogClass();
            $log->Log(AdminLogClass::TYPE_SEND_GOLD,$lang->page->roleName.":{$role_name} ".$lang->page->sendNum.":{$yuanbao}",'','','','');
        }else{
            $errorMsg[] = $interResult['errorMsg'];
        }
    }else{
        $errorMsg[] = $lang->msg->paramsErr;
    }
}

$smarty->assign( 'lang', $lang );
$smarty->assign( 'successMsg', implode('<br/>', $successMsg ) );
$smarty->assign( 'errorMsg', implode('<br/>', $errorMsg ) );
$smarty->display( 'module/pay/send_yuanbao_by_rolename.tpl' );