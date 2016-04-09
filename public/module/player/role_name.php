<?php
/**
 * 角色名模糊查询
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';

global $lang;
if (isPost()) {
    $roleName = $_REQUEST['role_name'];
    $sql = "select  * from t_log_register where role_name like '%{$roleName}%'";
    $result = GFetchRowSet($sql);   
}
$data=array(
    'roleName'=>$roleName,
    'lang'=>$lang,
    'result'=>$result,
);
$smarty->assign($data);
$smarty->display ( 'module/player/role_name.tpl' );