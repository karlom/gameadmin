<?php
include_once '../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE."/global.php";
include_once SYSDIR_ADMIN_CLASS."/admin_group.class.php";

$smarty->assign('ADMIN_MENU_TITLE', ADMIN_MENU_TITLE);
$smarty->assign("catalogue", page_structure($ADMIN_PAGE_CONFIG));
$smarty->display("left_gen.html");

exit();

function page_structure($config) {
	global $auth;
	$struct = array();
	$classes = array();
	foreach($config as $pid => $page) {
		if ($page['hide']) {//如果是隐藏的菜单（只有权限，没菜单），直接忽略
			continue;
		}
		$url = $page['url'];
		if($auth->assertModuleIDAccess($pid, false)) {
			if($class = $page['class']) {
				if(!isset($classes[$class])) {
					$classes[$class] = count($struct);
					$struct[$classes[$class]]['name'] = $class;
				}
				$struct[$classes[$class]]['pages'][$pid] = $page;
			}
		}
	}
	return $struct;
}