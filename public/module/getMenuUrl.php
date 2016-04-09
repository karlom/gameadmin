<?php
/**
 * 本文件的作用是获取传过来的参数根据当前选择的区服的版本号构建目标URL然后跳转，同时记录用户点击。
 */
include_once '../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . "/global.php";
include_once '../../protected/library/dBug.php';
session_start ();
session_regenerate_id();

$target = SS ( trim ( $_GET ['target'] ) );
$targetUrl = $ADMIN_PAGE_CONFIG [$target] ['url'];

if (! $_SESSION ['serverid']) {
	$_SESSION ['serverid'] = 'default';
}
$module = split ( '/', $targetUrl );
$module = ($module [0]);
if ($targetUrl != '404.php') {
	if ($ADMIN_PAGE_CONFIG [$target]['ver'] != '') {
		$targetUrl = $_SESSION ['adminver'] . '/' . $targetUrl;
	}
}
$click = array ();
$click ['admin_id'] = $_SESSION ['uid'];
$click ['admin_name'] = $_SESSION ['username'];
$click ['admin_ip'] = GetIP ();
$click ['version'] = $_SESSION ['adminver'];
$click ['menu_id'] = $target;
$click ['menu_name'] = $ADMIN_PAGE_CONFIG [$target] ['name'];
$click ['menu_url'] = $ADMIN_PAGE_CONFIG [$target] ['url'];
$sql = DBMysqlClass::makeInsertSqlFromArray ( $click, T_LOG_MENU );
IQuery ( $sql );
header ( "Location:" . $targetUrl );
