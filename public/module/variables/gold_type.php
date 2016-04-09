<?php
/**
 * 元宝类型配置
 */
 
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/goldConfig.php';

if(isset($_POST['save']))
{
	$newGoldType = array();
	$newGoldType[1] = array();
	$newGoldType[2] = array();

	$decreaseNameList = $_POST['decreasenames'];
	$decreaseIdList = $_POST['decreaseids'];
	foreach($decreaseNameList as $key => $decreasename)
	{
		$id = intval( $decreaseIdList[$key] );
		$newGoldType[1][$id] = trim( $decreasename );
	}


	$increaseNameList = $_POST['increasenames'];
	$increaseIdList = $_POST['increaseids'];
	foreach($increaseNameList as $key => $increasename)
	{
		$id = intval( $increaseIdList[$key] );
		$newGoldType[2][$id] = trim( $increasename );
	}
	Variables::set('gold_type', serialize( $newGoldType ));
	$goldType = $newGoldType;
}

$smarty->assign( 'lang', $lang );
$smarty->assign( 'goldType', $goldType);
$smarty->display( 'module/variables/gold_type.tpl' );

