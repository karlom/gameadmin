<?php
include_once '../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE."/global.php";
include_once SYSDIR_ADMIN_CLASS."/admin_group.class.php";

//常用菜单
$commonMenu = getCommonMenu();

if(!empty($commonMenu)){
	$smarty->assign('COMMON_MENU', page_structure($commonMenu));
}

$smarty->assign('lang', $lang);
$smarty->assign('SERVER', $serverCname);
$smarty->assign('ADMIN_MENU_TITLE', ADMIN_MENU_TITLE);
$smarty->assign('GAME_ZH_NAME',GAME_ZH_NAME);
$smarty->assign("catalogue", page_structure($ADMIN_PAGE_CONFIG));
$smarty->display("left_gen.html");
exit();

function getCommonMenu(){
	global $lang, $ADMIN_PAGE_CONFIG;
	$sql = "SELECT `menu_id` as id,count(`menu_id`) as times,`menu_name` as name,`menu_url` as url,`version` as ver FROM `t_log_menu` where `admin_id`="
			.$_SESSION['uid']." and `version` = '".$_SESSION['adminver']."' group by  `menu_name` order by times desc limit ".COMMON_MENU;
	$result = IFetchRowSet($sql);
	$commonMenu = array();
	if($result){
		foreach ($result as $k=>$v){
			$isShow = isset($ADMIN_PAGE_CONFIG[$v['id']]['isshow']) ? $ADMIN_PAGE_CONFIG[$v['id']]['isshow'] : 0;
			$commonMenu[$v['id']] = array('name'=>$v['name'],'class'=>$lang->menu->class->common,'url'=>$v['url'],'ver'=>$v['ver'], 'isshow'=>$isShow);
		}
	}
	return $commonMenu;
}