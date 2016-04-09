<?php
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
global $lang;

$action = isset($_POST['action']) ? SS($_POST['action']) : "";
if("setLoginNotice" == $action){
    $content = stripslashes(SS($_POST['content']));
    if($content){
        $api = "setloginnotice";
        $params = array(
            "content" => $content,
        );
        $loginNoticeServerList = $_POST['loginNoticeServerList'];
        if($loginNoticeServerList){
            $log = new AdminLogClass();
            foreach($loginNoticeServerList as $key => $value){
                $httpResult = interfaceRequest($api, $params, 'GET', 60, $value);
                if(1 == $httpResult['result']){
                    $msg[] = $lang->verify->opSuc.":{$value}";
                    //写日志
                    $log->Log(AdminLogClass::SET_NOTICE,$lang->verify->opSuc.":{$value}",'','','','');
                }else{
                    $msg[] = $lang->page->errorReason.":{$value}".$httpResult['errorMsg'];
                }
            }
        }
    }else{
        $msg[] = $lang->page->errorReason.":".$lang->msg->loginNoticeContentIsNull;
    }
}

$api = "getloginnotice";
$httpResult = interfaceRequest($api, array());
if(1 == $httpResult['result']){
    $loginNotice = stripcslashes($httpResult['data']);
}else{
    $msg[] = $lang->page->errorReason.":".$httpResult['errorMsg'];
}

$smarty->assign('lang', $lang);
$smarty->assign('loginNotice', $loginNotice);
$smarty->assign('msg', $msg);
$smarty->assign('serverList', $serverList);
$smarty->display('module/basedataconfig/login_notice.tpl');