<?php
/**
 * 中央API接口，用于获取当前登录玩家
 */

define('IN_ADMIN_SYSTEM', true);
//include_once "../../../protected/config/config.php";
//include_once SYSDIR_ROOT . '/class/db.class.php';
include '../central_api_auth.php';
//include SYSDIR_ADMIN.'/class/central.log.php';
global $INTAERFACE;
$INTAERFACE = 'http';
$userList = RequestCollection::getOnlineList();
echo serialize( $userList );