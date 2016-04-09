<?php
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';
include_once SYSDIR_ADMIN_API_CLASS.'/server_api.php';

$msg = array();
$api = new ServerApi();
if(isPost()){
    $op = 1;
    $content = stripslashes($_POST['content']);
    $len = strlen($content);
     if( 0== $len ){
        $msg[] ='所填信息不能为空';
    }
    if($len > 8190 ){
        $msg[] ='字节数超出范围';
    }
    if(empty ($msg)){
       $resultSet = $api->loginRewardNoteSet($op,$content);
       if( 1 != $resultSet['result']){
            $msg[] = '修改操作失败，失败原因是：'.$resultSet['errorMsg'];
        }else{
            $msg[] = '操作成功！';
            $log = new AdminLogClass();
            $log -> Log(AdminLogClass::SET_NOTICE, '连续登录公告设置成功!', '', '', 0, '');
        }
    }
}else{
    $op = 2;
    $resultGet = $api->loginRewardNoteGet($op);
    $content = $resultGet['content'];
    if( 1 != $resultGet['result']){
        $msg[] = '查询操作失败，失败原因是：'.$resultGet['errorMsg'];
    }
}
$flashConent = str_replace('"','\\"',$content);
$strMsg = empty($msg) ? '' : implode('<br />', $msg);
$smarty->assign('agent_name',AGENT_NAME);
$smarty->assign('server_id',SERVER_ID);
$smarty->assign('strMsg',$strMsg);
$smarty->assign('flashConent',$flashConent);
$smarty->assign('content',$content);
$smarty->assign('URL_SELF',$_SERVER['PHP_SELF']);
$smarty->display("module/system/left_notice.tpl");