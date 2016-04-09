<?php
define('IN_ADMIN_SYSTEM', true);
include '../central_api_auth.php';

$serverid = $_GET['serverID'];
$serverid = str_replace("s", "", $serverid);
$content = $_GET['content'];

$method = "getActInfo";
$params = array(
);
$httpResult = @interfaceRequest($method, $params);
echo(@json_encode($httpResult));
