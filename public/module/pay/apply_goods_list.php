<?php
/**
 * 玩家赠送申请列表
 * @author ligengbin@feiyouonline.com
 * 2012-03-17
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';
include_once SYSDIR_ADMIN_DICT.'/arrItemsAll.php';
include_once SYSDIR_ADMIN_DICT.'/dict.php';
global $lang;


$action = $_GET['action'];
$dateStart = SS ( $_POST['starttime'] );
$dateEnd = SS ( $_POST['endtime'] );
$dateStart = (strtotime($dateStart) >= strtotime(ONLINEDATE)) ? $dateStart : ONLINEDATE;
$type = 1;
$id = SS($_GET['id']);
$verifyResult = $_GET['verifyResult'];

$method = 'applygoods';
$verifyPerson = $auth->username();

/** 处理通过审核，立即发送道具 START **/
if( $action == 'yes' && !empty($id) && $verifyResult == '未审核'){

	$where = "where applyID =" . $id;
	$data = getApplyList($where, true);
	$params['sendType'] = intval($data['sendType']);
	$params['applyID'] = $data['applyID'];
//	$params['apply_time'] = $data['apply_time'];
	$params['mailTitle'] = $data['mailTitle'];
	$params['mailContent'] = $data['mailContent'];
	
	$params['roleNameList'] = json_decode($data['roleNameList'],TRUE);
	unset($params['roleNameList']['selectedCompare']);
	unset($params['roleNameList']['familyName']);
		
	// 所有物品，一次请求。
	if ($data['item'] != null){
		$preItem = json_decode($data['item'], TRUE);
		$params['items'] = $preItem;
		$result = interfaceRequest($method, $params);
		if ($result['result'] == 1 ) {
			//写日志
			$log = new AdminLogClass();
			$itemList = SS(itemsArrayToString($params['items']));
			if($params['sendType'] == 0) {
				$roleNameList = implode(',',$params['roleNameList']);
				$detail = "id={$params['applyID']},赠送原因：{$data['apply_reason']},申请时间：{$data['apply_time']},申请人：{$data['apply_person']},玩家列表：{$roleNameList},道具列表：{$itemList}";
				$log->Log(AdminLogClass::TYPE_SEND_GOODS_BY_ROLE_NAME,$detail,'','通过道具赠送申请','','');
			} else if ($params['sendType'] == 1) {
				$detail = "id={$params['applyID']},赠送原因：{$data['apply_reason']},申请时间：{$data['apply_time']},申请人：{$data['apply_person']},发送条件：{$roleNameList},道具列表：{$itemList}";
				$log->Log(AdminLogClass::TYPE_SEND_GOODS_BY_CONDITION,$detail,'','通过道具赠送申请','','');
			}
			
			$result_msg = "赠送成功：applyID=".$params['applyID'];
			$done = true;
		} else {
			$result_msg = "赠送失败：applyID=".$params['applyID'] . $result['msg'];
		}
	}	
	
	if ( $done == TRUE ){
		$arr = array(
			'applyID' => $id,
			'verify_result' => '2',
			'verify_person' => $verifyPerson 
		);
		$sql = makeUpdateSqlFromArray($arr, T_APPLY_GOODS, 'applyID');
		GQuery($sql);
	}

//		print_r($params);die();
} elseif ( $action == 'no' && !empty($id) && $verifyResult == '未审核' ){
    $arr = array(
		'applyID' => $id,
		'verify_result' => '3',
		'verify_person' => $verifyPerson 
	);
	$sql = makeUpdateSqlFromArray($arr, T_APPLY_GOODS, 'applyID');
	GQuery($sql);
	//写日志
	$log = new AdminLogClass();
//	$itemList = itemsArrayToString($params['items']);
//	$roleNameList = implode(',',$params['roleNameList']);
	$detail = "id={$id}";
	$log->Log(AdminLogClass::TYPE_SEND_GOODS_BY_ROLE_NAME,$detail,'','拒绝道具赠送申请','','');
} elseif ( $action == 'del' && !empty($id)  ){

	$sql ="update " . T_APPLY_GOODS . " set visible=0 where applyID={$id}";
	GQuery($sql);
	//写日志
	$log = new AdminLogClass();
	$detail = "id={$id}";
	$log->Log(AdminLogClass::TYPE_DELETE_APPLY_GOODS_RECORD,$detail,'','删除赠送申请记录','','');
} 
/** 处理通过审核，立即发送道具 END **/


if( !empty($action) && $action == 'search' ){	// 条件查询
	$selectType = SS($_POST['type']);
	$applyID = SS($_POST['applyID']);
	$applyIDStr = empty($applyID) ? "" : " and applyID={$applyID}";
	$type = empty($selectType) ? "" : " and verify_result={$selectType}";
	$start = strtotime($dateStart);
	$end = strtotime($dateEnd." 23:59:59");
	$where = "where apply_time >= {$start} and apply_time <= {$end} {$type} {$applyIDStr} ";
	$applyList = getApplyList($where);
}else{
//	$where = "where verify_result={$type}";
	$applyList = getApplyList($where);	//默认情况下选择全部
}

if ( empty ( $dateStart ) ){
    $dateStart = strftime ("%Y-%m-%d", strtotime('-6day',time()));
}
if ( empty ( $dateEnd ) ){
	$dateEnd = date('Y-m-d');
}

$typeArr = array(0=>$lang->verify->all,1=>$lang->verify->uncheck,2=>$lang->verify->pass,3=>$lang->verify->reject);

//过滤道具名
for($i=0; $i<count($applyList); $i++){
	if($applyList[$i]['item'] != null){
		for($j=0; $j<count($applyList[$i]['item']); $j++){
			$index = "<font size=2 color='#0000EE'>".($j+1).": </font>";
			$str = trim($applyList[$i]['item'][$j]->id);
			$tmp = $applyList[$i]['item'][$j]->id;
			//公共部分：道具名称，数量，是否绑定
			$itemId = empty($tmp)?"":$arrItemsAll[trim($tmp)]['name'];
			$itemNum = " 数量:" . $applyList[$i]['item'][$j]->cnt;
			$itemBind = $applyList[$i]['item'][$j]->bind == 1 ? "(绑定)" : "(不绑定)";
			//特殊部分：如果是武器，还有详细信息
			$firStr = substr($str,0,1);
			if ($firStr == '2'){
				$itemStrength = " 强化等级:" . $applyList[$i]['item'][$j]->strengthenLv;
				$itemQuality = " 品质:" . $dictQuality[$applyList[$i]['item'][$j]->quality];
				$itemCraftLv = " 工匠等级:" . ($applyList[$i]['item'][$j]->craftLv ? $applyList[$i]['item'][$j]->craftLv : 0);
				$itemRandAttrStar = " 附加属性星级:" . ($applyList[$i]['item'][$j]->randAttrStar ? $applyList[$i]['item'][$j]->randAttrStar : 0);
				$itemVipAttrStar = " 专有属性星级:" . ($applyList[$i]['item'][$j]->vipAttrStar ? $applyList[$i]['item'][$j]->vipAttrStar : 0);
				$gemsSplit = $applyList[$i]['item'][$j]->gems;
				for ($k=0; $k<count($gemsSplit); $k++){
					$gems[$k] = $arrItemsAll[trim($gemsSplit[$k])]['name'];
				}
				$itemGems = $gems?" 镶嵌宝石(" . implode(",", $gems) . ")":"";
				$subItem[$j] = $index . $itemId . $itemBind . $itemNum . $itemStrength . $itemQuality . $itemCraftLv . $itemRandAttrStar . $itemVipAttrStar . $itemGems;
			}else if($str == 10006){
				//货币
				$subItem[$j] = $index . "<font color='red'>" .$itemId . $itemBind . $itemNum . "</font>";
			} else {
				$subItem[$j] = $index . $itemId . $itemBind . $itemNum;
			}
		}
		$applyList[$i]['item'] = implode(",<br>", $subItem);
		unset($subItem);
	}
}

//处理赠送人物列表格式 
for($i=0; $i<count($applyList);$i++){
	if ($applyList[$i]['sendType'] == 1){
		$str = json_decode($applyList[$i]['roleNameList'],TRUE);
		switch ($str['selectedCompare']) {
			case 0:
				$level = "";
				break;
			case 1:
				$level = "大于等于". $str['startLv']. "级";
				break;
			case 2:
				$level = "等于". $str['startLv']. "级";
				break;
			case 3:
				$level = "小于等于".$str['endLv']. "级";
				break;
			case 4:
				$level = "大于".$str['startLv']."级小于".$str['endLv'] . "级";
				break;
		}
		if(!empty($str['lastLoginTime'])) {
			$days = ceil( ( $applyList[$i]['apply_time'] - $str['lastLoginTime']) / 86400 );
			$loginLastTime = "距离上次登陆".$days."天之内";
		}
//		$loginLastTime = empty($str['timeFromLastLogin'])?"":"距离上次登陆$str['timeFromLastLogin']天之内";
		switch ($str['sex']) {
			case '1':
				$gender = "性别:男";
				break;
			case '2':
				$gender = "性别:女";
				break;
		}
		switch ($str['job']) {
			case '0':
				$occupation = "";
				break;
			case '1':
				$occupation = $lang->occupation->occupation.":".$lang->occupation->wusheng;
				break;
			case '2':
				$occupation = $lang->occupation->occupation.":".$lang->occupation->lingxiu;
				break;
			case '3':
				$occupation = $lang->occupation->occupation.":".$lang->occupation->jianxian;
				break;
		}
		$family = $str['familyName'] ? "家族:".$str['familyName'] : "";
		$online = $str['online'] ? "{$lang->apply->onlineOnly}" : "";
		$pf = $str['pf'] ? "从".$dictPlatform[$str['pf']]."登录" : "";
		$applyList[$i]['roleNameList'] = "赠送条件：" . $level . " " . $loginLastTime . " " . $occupation . " " . $gender . " " . $family . " " . $pf . " " . $online;
	}else{
		$tmp = json_decode($applyList[$i]['roleNameList'], TRUE);
		$applyList[$i]['roleNameList'] = "赠送玩家：" . implode(",", $tmp);
	}
}

//转换时间格式
for($i=0; $i<count($applyList); $i++){
	$applyList[$i]['apply_time'] = date("Y-m-d H:i:s", $applyList[$i]['apply_time']);
}

//处理审核状态
for($i=0; $i<count($applyList); $i++){
	$applyList[$i]['verify_result'] = $typeArr[$applyList[$i]['verify_result']];
}

$maxDate = date( 'Y-m-d' );
$data = array (
	'minDate' => ONLINEDATE,
	'maxDate' => $maxDate,
	'lang' => $lang,
	'typeArr' => $typeArr,
	'type' => $selectType,
	'dateStart' => $dateStart,
	'dateEnd' => $dateEnd,
	'pager' => $pager,
	'applyList' => $applyList,
	'result_msg' => $result_msg,
	'applyID' => $applyID,
);
$smarty->assign( $data );
$smarty->display( 'module/pay/apply_goods_list.tpl' );
exit;
