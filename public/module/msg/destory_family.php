<?php
/**
 * destory_family.php
 * 解散家族
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';

$action = trim($_POST['action']);
$familyName = trim($_POST['family_name']);

if($action == "destory"){
	if($familyName) {
		$rs = interfaceRequest( "findFamilyByName",array("familyName"=>$familyName) );
		if($rs['result'] == 1){
			$ret = interfaceRequest( "destoryfamily",array("familyName"=>$familyName) );
			if($ret['result'] == 1){
				$msg[] = "家族[{$familyName}]已成功解散。";
			} else {
				$msg[] = "家族[{$familyName}]解散失败：{$ret['msg']}。";
			}
		} else {
			$msg[] = $rs['msg'] or $msg[] = $rs['errorMsg'];
		}
	} else {
		$msg[] = $lang->page->inputFamilyName;
	}
}

$smarty->assign("viewData", $viewData);
$smarty->assign("lang", $lang);
$smarty->assign("msg", $msg);
$smarty->display("module/msg/destory_family.tpl");