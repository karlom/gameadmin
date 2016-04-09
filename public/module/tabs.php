<?php 
/**
 * 标签化通用
 */
 
include_once '../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
$errorMsg = $successMsg = array();

global $ADMIN_PAGE_CONFIG;
$id = Validator::isInt($_GET['pid'])?SS($_GET['pid']):0;

if( isset($ADMIN_PAGE_CONFIG[$id]) )
{
	$current = $ADMIN_PAGE_CONFIG[$id];
	
	$relatedMenuIDs = $current['menus'];
	$relatedMenus = array();
	foreach($relatedMenuIDs as $m)
	{
		$relatedMenus[$m] = $ADMIN_PAGE_CONFIG[$m];
	}
	
	$smarty->assign( 'current', $current );
	$smarty->assign( 'menus', $relatedMenus );
}else{
	$errorMsg[] = 'id不存在';
}

$smarty->assign( 'errorMsg', implode('<br/>', $errorMsg ) );
$smarty->assign( 'successMsg', implode('<br/>', $successMsg ) );
$smarty->assign( 'lang',  $lang );
$smarty->display( 'module/tabs.tpl' );