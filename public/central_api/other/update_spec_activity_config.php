<?php
/**
*   Description: 热更新特殊活动配置
*/

define('IN_ADMIN_SYSTEM', true);
include_once "../../../config/config.php";
include_once SYSDIR_INCLUDE."/global.php";
include '../central_api_auth.php';

$configName = $_POST['config_name'];
$config = $_POST['config'];
$config = stripslashes($config);

$url = ERLANG_WEB_URL."/spec_activity/hot_update" ;
$params = "config_name={$configName}"."&config={$config}";
$result = curlPost($url, $params);

echo $result;
exit();