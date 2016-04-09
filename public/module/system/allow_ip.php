<?php

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
$ip = SS ( trim ( $_POST ["ip"] ) );
$action = SS ( trim ( $_GET ["action"] ) );
$id = SS ( trim ( $_GET ["id"] ) );

//增加允许访问的IP
if ($action == 'add') {
	if (! empty ( $ip )) {
		$sql = "insert into " . T_IP_ACCESS . " (`ip`) values ('" . $ip . "');";
		IQuery ( $sql );
	}
}

//删除列表中的IP
if ($action == 'delete') {
	if (! empty ( $id )) {
		$sql = "delete from " . T_IP_ACCESS . " where id =" . $id . ";";
		IQuery ( $sql );
	}
}
$smarty->assign ( "IPLIST", getIpAllowList () );
$smarty->display ( "module/system/allow_ip_list.tpl" );

function getIpAllowList() {
	$sql = "select id,ip from " . T_IP_ACCESS . ";";
	$ipList = IFetchRowSet ( $sql );
	return $ipList;
}