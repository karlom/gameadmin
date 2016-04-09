<?php
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';
include_once SYSDIR_ADMIN_CLASS.'/user_class.php';
include_once SYSDIR_ADMIN_CLASS.'/templates.class.php';
include_once SYSDIR_ADMIN_DICT.'/arrItemsAll.php';
include_once SYSDIR_ADMIN_DICT.'/gem.php';
include_once SYSDIR_ADMIN_DICT.'/dict.php';
global $lang;

$action = SS($_REQUEST['action']);
$data['sendType'] = $_POST['sendType'];
$curTime = time();

if ('send' == $action) {	
//	$data['yuanbao'] = SS($_POST['yuanbao']);
//	$data['liquan'] = SS($_POST['liquan']);
//	$data['yinliang'] = SS($_POST['yinliang']);
	$data['mailTitle'] = SS($_POST['mailTitle']);
	$data['mailContent'] = SS($_POST['mailContent']);
	$data['apply_reason'] = SS($_POST['reason']);	
	$data['apply_person'] = $auth->username();	
	$data['apply_time'] = time();
	
	$tmp = $_POST['item'];
	
	if(!empty($tmp)){
		$tmp = changeArrayBase($tmp, 0);
		$item = array();
	
		for ($i=0;$i<count($tmp); $i++){
			$item[$i]['cnt'] = intval($tmp[$i]['item_num']);
			$item[$i]['bind'] = intval($tmp[$i]['item_bind']);
			$item[$i]['strengthenLv'] = $tmp[$i]['item_strength'] ? intval($tmp[$i]['item_strength']) : 0;
			$item[$i]['quality'] = $tmp[$i]['item_quality']?intval($tmp[$i]['item_quality']):0;
			$item[$i]['craftLv'] = $tmp[$i]['item_craftLv']?intval($tmp[$i]['item_craftLv']):0;
			$item[$i]['randAttrStar'] = $tmp[$i]['item_randAttrStar']?intval($tmp[$i]['item_randAttrStar']):0;
			$item[$i]['vipAttrStar'] = $tmp[$i]['item_vipAttrStar']?intval($tmp[$i]['item_vipAttrStar']):0;
		}

		for($i=0; $i<count($tmp); $i++){
			$itemId = explode("|", $tmp[$i]['item_id']);
			$item[$i]['id'] = intval(trim($itemId[0]));
		}
		
		$gems = array();
		for($i=0; $i<count($tmp); $i++){
			if(!$tmp[$i]['item_gems_type_id']) {
				$item[$i]['gems'] = array();
				continue;
			}
			$itemGemsId = explode(",", $tmp[$i]['item_gems_type_id']);
			for($j=0; $j<count($itemGemsId); $j++){
				$gemsId = explode("|", $itemGemsId[$j]);
				$gems[$j] = intval(trim($gemsId[0]));
			}
			$item[$i]['gems'] = $gems;
		}
		
		$data['item'] = decodeUnicode(json_encode($item));
	}

	if (0 == $data['sendType']){
		$fliter = str_replace("\n", "*", $_POST['role_name_list']);
//		$fliter = $_POST['role_name_list'];
		$fliter = deleteSpaceTabEnter($fliter);
		$fliter = trim($fliter,'*');
		$str = explode("*", $fliter);

		$data['roleNameList'] = decodeUnicode(json_encode($str));
		$sql = getInsertSQL($data, T_APPLY_GOODS);
		GQuery($sql);
		$submitApply = 'done';
		//写日志
		$log = new AdminLogClass();
		$itemList = $data['item'];
		$roleNameList = $fliter;
		$detail = "赠送原因：{$data['apply_reason']},申请时间：{$data['apply_time']},申请人：{$data['apply_person']},玩家列表：{$roleNameList},道具列表：{$itemList}";
//		$detail = SS($detail);
		$log->Log(AdminLogClass::TYPE_SEND_GOODS_BY_ROLE_NAME,$detail,'','道具赠送申请','','');
	} else if (1 == $data['sendType']){
		$byCondition['selectedCompare'] = $_POST['selectedCompare'];
		$byCondition['startLv'] = intval($_POST['startLevel']);
		$byCondition['endLv'] = intval($_POST['endLevel']);
		$byCondition['lastLoginTime'] = $_POST['timeFromLastLogin'] ? ($curTime - intval($_POST['timeFromLastLogin']) * 86400):0;	//距离上次登录时间
		$byCondition['sex'] = $_POST['sex']?intval($_POST['sex']):0;
		$byCondition['job'] = $_POST['job']?intval($_POST['job']):0;
		$byCondition['online'] = !empty($_POST['online']) ? intval($_POST['online']):0;
		$byCondition['pf'] = (!empty($_POST['pf']) && array_key_exists($_POST['pf'],$dictPlatform)) ? $_POST['pf'] : "";
		$byCondition['familyName'] = $_POST['family'];
		if(empty($_POST['family'])){
			$byCondition['familyUuid'] = "";
		} else {
			//获取family uuid
			$rs = interfaceRequest( "findFamilyByName",array("familyName"=>$byCondition['familyName']) );
			if(!empty($rs) && $rs['result'] == 1) {
				$byCondition['familyUuid'] = $rs['familyUuid'];
			} else {
				echo "<script type='text/javascript'>alert('获取familyUuid失败！');</script>";
				exit;
			}
		}
		
		
		switch ( $byCondition['selectedCompare'] ) {
			//处理等级限制，模板中没有做处理
			case 0:
			//不限等级
				$byCondition['startLv'] = 1;
				$byCondition['endLv'] = 200;
				break;
			case 1:
			//等级>=x
				$byCondition['startLv'] = $byCondition['endLv'];
				$byCondition['endLv'] = 200;
				break;
			case 2:
			//等级=x
				$byCondition['startLv'] = $byCondition['endLv'];
				break;
			case 3:
			//等级<=x
				$byCondition['startLv'] = 1;
				break;
			case 4:
			//y<=等级<=x
				break;
			default:
				break;
		}
				
		$data['roleNameList'] = decodeUnicode(json_encode($byCondition));

		$sql = getInsertSQL($data, T_APPLY_GOODS);
		GQuery($sql);
		$submitApply = 'done';
		
		//写日志
		$log = new AdminLogClass();
		$itemList = $data['item'];
		$roleNameList = $data['roleNameList'];
		$detail = "赠送原因：{$data['apply_reason']},申请时间：{$data['apply_time']},申请人：{$data['apply_person']},赠送条件：{$roleNameList},道具列表：{$itemList}";
		$log->Log(AdminLogClass::TYPE_SEND_GOODS_BY_ROLE_NAME,$detail,'','道具赠送申请','','');
	}
}

//$dictStrength = array(0,1,2,3,4,5,6,7,8,9,10);
//$dictHole = array(0,1,2,3,4,5,6);

$data = array(
    'URL_SELF' => $_SERVER['PHP_SELF'],
    'lang' => $lang,
    'role_name_list' => $role_name_list,
//    'strMsg' => $strMsg,
//    'dictStrength' => $dictStrength,
//	'dictColor' => $dictColor,
//	'dictHole' => $dictHole,
	'dictQuality' => $dictQuality,
    'items' => $arrItemsAll,
	'gems' => $dictGem,
	'submitApply' => $submitApply,
	'dictPlatform' => $dictPlatform,
);
$smarty->assign($data);
$smarty->display ( 'module/pay/apply_goods_by_rolenames.tpl' );
exit;