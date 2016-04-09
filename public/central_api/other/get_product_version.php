<?php
/**
*	Description:获取当前服务端的版本号
*/

define('IN_ADMIN_SYSTEM', true);
include_once "../../../config/config.php";
include_once SYSDIR_INCLUDE."/global.php";
include '../central_api_auth.php';

$result = getPoroduct_version();
$result = serialize($result);
echo $result;
exit();
