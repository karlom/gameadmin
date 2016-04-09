<?php

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT.'/dict.php';
include_once SYSDIR_ADMIN_DICT.'/arrItemsAll.php';
global $lang;

$role    = $_REQUEST['role'];
$role['roleName'] = $roleName    = $role['roleName'] ? autoAddPrefix( SS($role['roleName']) ): '';
$role['accountName'] = $accountName = $role['accountName'] ? autoAddPrefix( SS($role['accountName'])) : '';

$where = 1;
$where .=  $accountName ? " and `account_name` = '{$accountName}' ":'';
$where .=  $roleName ? " and `role_name` = '{$roleName}' ":'';
if(!empty($accountName) || !empty($roleName)){
$sql = "select * from t_log_gamsrder where {$where}";
$data = GFetchRowSet($sql);
$count = count($data);
}
$smarty->assign("lang",$lang);
$smarty->assign("data",$data);
$smarty->assign("roleName",$roleName);
$smarty->assign("role",$role);
$smarty->assign("count",$count);
$smarty->display("module/basedata/gemsrder.tpl");
exit;