<?php
/**
*	Description:idip发送公告接口。
*/

include dirname(dirname(__FILE__)).'/idip_api/idip_auth.php';
include_once SYSDIR_ADMIN_CLASS.'/user_class.php';
$serverid = $_GET['serverID'];
$serverid = str_replace("s", "", $serverid);
$content = $_GET['content'];

$method = "broadcast";
$params = array(
    "type" => 16,
    "msg" => stripslashes($content),
);
$httpResult = @interfaceRequest($method, $params);
echo(@json_encode($httpResult));