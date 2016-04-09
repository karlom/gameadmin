<?php
/**
 * regular_send_item.php
 * Author: Libiao
 * Create on 2013-09-30 14:52:38
 * 定时发送道具
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';
include_once SYSDIR_ADMIN_CLASS.'/user_class.php';
include_once SYSDIR_ADMIN_CLASS.'/templates.class.php';
include_once SYSDIR_ADMIN_DICT.'/arrItemsAll.php';
include_once SYSDIR_ADMIN_DICT.'/gem.php';
include_once SYSDIR_ADMIN_DICT.'/dict.php';

$dictStatus = array(
	0 => '未启动',
	1 => '正常',
	2 => '已结束',
	3 => '手动停止',
);

$action = SS($_REQUEST['action']);
$data['sendType'] = $_POST['sendType'];
$curTime = time();

//新增
if ('send' == $action) {
	$data['mailTitle'] = SS($_POST['mailTitle']);
	$data['mailContent'] = SS($_POST['mailContent']);
	$data['reason'] = SS($_POST['reason']);	
	$data['add_person'] = $auth->username();	
	$data['add_time'] = time();
	$data['begin_time'] = strtotime($_POST['startdate']);
	$data['end_time'] = strtotime($_POST['enddate']);
	
	$data['send_time'] = strtotime($_POST['sendTime']) - strtotime(date("Y-m-d"));
	
	//状态,0未启动,1正常,2结束,3手动停止
	$data['status'] = 0;
	
	$tmp = $_POST['item'];
	
	if(!empty($tmp)){
		$tmp = changeArrayBase($tmp, 0);
		$item = array();
	
		for ($i=0;$i<count($tmp); $i++){
			$item[$i]['cnt'] = intval($tmp[$i]['item_num']);
			$item[$i]['bind'] = intval($tmp[$i]['item_bind']);
			$item[$i]['strengthenLv'] = $tmp[$i]['item_strength'] ? intval($tmp[$i]['item_strength']) : 0;
			$item[$i]['quality'] = $tmp[$i]['item_quality']?intval($tmp[$i]['item_quality']):0;
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
		$fliter = str_replace("，", ",", $_POST['role_name_list']);
		$fliter = deleteSpaceTabEnter($fliter);
		$fliter = trim($fliter,',');
		$str = explode(",", $fliter);

		$data['roleNameList'] = decodeUnicode(json_encode($str));
		$sql = getInsertSQL($data, T_REGULAR_SEND_ITEM);
		GQuery($sql);
		$submitApply = 'done';
		//写日志
		$log = new AdminLogClass();
		$itemList = $data['item'];
		$roleNameList = $fliter;
		$detail = "赠送原因：{$data['apply_reason']},操作时间：{$data['apply_time']},操作人：{$data['apply_person']},玩家列表：{$roleNameList},道具列表：{$itemList}";
//		$detail = SS($detail);
		$log->Log(AdminLogClass::TYPE_SEND_GOODS_BY_ROLE_NAME,$detail,'','增加定时赠送道具','','');
	} else if (1 == $data['sendType']){
		$byCondition['selectedCompare'] = $_POST['selectedCompare'];
		$byCondition['startLv'] = intval($_POST['startLevel']);
		$byCondition['endLv'] = intval($_POST['endLevel']);
		$byCondition['lastLoginTime'] = $_POST['timeFromLastLogin'] ? ($curTime - intval($_POST['timeFromLastLogin']) * 86400):0;	//距离上次登录时间
		$byCondition['sex'] = $_POST['sex']?intval($_POST['sex']):0;
		$byCondition['job'] = $_POST['job']?intval($_POST['job']):0;
		$byCondition['online'] = !empty($_POST['online']) ? intval($_POST['online']):0;
		$byCondition['familyName'] = $_POST['family'];
		if(empty($_POST['family'])){
			$byCondition['familyUuid'] = "";
			unset($byCondition['familyName']);
		} else {
			//获取family uuid
			$rs = interfaceRequest( "findFamilyByName",array("familyName"=>$byCondition['familyName']) );
			if(!empty($rs) && $rs['result'] == 1) {
				$byCondition['familyUuid'] = $rs['familyUuid'];
				unset($byCondition['familyName']);
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
				
		unset($byCondition['selectedCompare']);
		$data['roleNameList'] = decodeUnicode(json_encode($byCondition));

		$sql = getInsertSQL($data, T_REGULAR_SEND_ITEM);
		GQuery($sql);
		$submitApply = 'done';
		$msg = '添加成功';
		//写日志
		$log = new AdminLogClass();
		$itemList = $data['item'];
		$roleNameList = $data['roleNameList'];
		$detail = "赠送原因：{$data['apply_reason']},操作时间：{$data['apply_time']},操作人：{$data['apply_person']},赠送条件：{$roleNameList},道具列表：{$itemList}";
		$log->Log(AdminLogClass::TYPE_SEND_GOODS_BY_ROLE_NAME,$detail,'','增加定时赠送道具','','');
	}
}

$id = $_GET['id'];
$verifyResult = $_GET['verifyResult'];
$end_time = $_GET['endTime'];

/** START **/
if( $action == 'yes' && !empty($id) && $verifyResult == $dictStatus[0] ){
	if( $end_time < $curTime) {
		$msg = '结束时间小于当前时间';
	} else {
		$sql = "update `t_regular_send_item` set `status`=1 where `id`={$id} ";
		GQuery($sql);
		$msg = '启动成功';
		//写日志
		$log = new AdminLogClass();
		$detail = "id={$id}";
		$log->Log(AdminLogClass::TYPE_SEND_GOODS_BY_ROLE_NAME,$detail,'','启动定时赠送道具','','');		
	}
} elseif ( $action == 'no' && !empty($id) && $verifyResult == $dictStatus[1] ){
	if( $end_time < $curTime) {
		echo $end_time.":".$curTime;
		$msg = '结束时间小于当前时间。';
	} else {
		$sql = "update `t_regular_send_item` set `status`=3 where `id`={$id} ";
		GQuery($sql);
		$msg = '停止成功';
		//写日志
		$log = new AdminLogClass();
		$detail = "id={$id}";
		$log->Log(AdminLogClass::TYPE_SEND_GOODS_BY_ROLE_NAME,$detail,'','停止定时赠送道具','','');
	}
}
/** END **/

//列表
$sqlList = "select * from t_regular_send_item order by id desc";
$recordList = GFetchRowSet($sqlList);

if(!empty($recordList)) {
	foreach($recordList as $k => $v ) {
		if($v['end_time'] < $curTime) {
			$sql = "update `t_regular_send_item` set `status`=2 where `id`={$v['id']} ";
			GQuery($sql);
		}
		
		$hour = floor($v['send_time']/3600);
		$min = floor(($v['send_time']%3600)/60);
		$sec = floor($v['send_time']%60);
		$hour = ($hour)>9? $hour : "0".$hour;
		$min = ($min)>9? $min : "0".$min;
		$sec = ($sec)>9? $sec : "0".$sec;
		
		$recordList[$k]['send_time'] = $hour.":".$min.":".$sec;
		
		$itemList = json_decode($v['item'], true);
//		print_r($itemList);
		$itemListStr = "";
		if(!empty($itemList)){
			foreach($itemList as $x) {
				if(!empty($x) && is_array($x)) {
						$itemListStr = '{ ';
					foreach($x as $j => $w ) {
//						$itemListStr .= $j.":".$w.", ";
						switch($j){
							case "cnt": $itemListStr .= "数量:".$w.", ";	 break;
							case "bind": $itemListStr .= "是否绑定:". ($w?"是":"否") . ", ";	 break;
							case "strengthenLv": $itemListStr .= "强化等级:".$w.", ";	 break;
							case "quality": $itemListStr .= "品质:". $w .", ";	 break;
							case "id": $itemListStr .= "道具:[". $w. "]" .$arrItemsAll[$w]['name'] .", ";	 break;
							case "gems": 
								if($w[0] || $w[1]){
									$gems = "孔1:".$arrItemsAll[$w[0]]['name'].",孔2:".$arrItemsAll[$w[1]]['name'];
								} else {
									$gems = "无";
								}
								$itemListStr .= "镶嵌宝石:". $gems .", ";
							break;
						}
					}
					$itemListStr .= '}<br>';
				}
			}
		}
		$recordList[$k]['item'] = $itemListStr;
		
		$roleList = json_decode($v['roleNameList'],true);
		$roleListStr = "";
		
		if($v['sendType'] == 0) {
			$roleListStr = implode(",", $roleList);
		} else {
			if(!empty($roleList)) {
				foreach($roleList as $j => $w ) {
//					$roleListStr .= $j.":".$w.", ";
					switch($j){
						case "startLv": $roleListStr .= "最小等级:".$w.", ";	 break;
						case "endLv": $roleListStr .= "最大等级:".$w.", ";	 break;
						case "lastLoginTime": $roleListStr .= "距离上次登录时间:". ( empty($w) ? "无" : $w ) . ", ";	 break;
						case "sex": $roleListStr .= "性别:". $dictSex[$w] .", ";	 break;
						case "job": $roleListStr .= "职业:". ( $w ? $dictJobs[$w] : "不限" ) .", ";	 break;
						case "online": $roleListStr .= "只发在线玩家:". ($w?"是":"否") .", ";	 break;
						case "familyUuid": $roleListStr .= "指定家族:". ($w?"uuid：{$w}":"否") .", ";	 break;
					}
				}					
			}
		}
		
		$recordList[$k]['roleNameList'] = $roleListStr;
	}
}

$data = array(
    'URL_SELF' => $_SERVER['PHP_SELF'],
    'lang' => $lang,
    'role_name_list' => $role_name_list,
	'dictQuality' => $dictQuality,
    'items' => $arrItemsAll,
	'gems' => $dictGem,
	'submitApply' => $submitApply
);

$smarty->assign($data);
$smarty->assign("msg",$msg);
$smarty->assign("recordList",$recordList);
$smarty->assign("dictStatus",$dictStatus);
$smarty->assign("startDate",date("Y-m-d")." 00:00:00 ");
$smarty->assign("endDate",date("Y-m-d")." 23:59:59");
//$smarty->assign("minDate",ONLINEDATE." 00:00:00 ");
//$smarty->assign("maxDate",date("Y-m-d")." 23:59:59");
$smarty->display("module/pay/regular_send_item.tpl");
