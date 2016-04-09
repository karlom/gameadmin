<?php
/**
 * role_label.php
 * 角色标签查询
 * 
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';

$dictActive = array(
	'name' => '活跃标签',
	'1' => '活跃用户',
	'2' => '久不登录',
);
$dictOnline = array(
	'name' => '在线时间标签',
	'1' => '短在线',
	'2' => '中在线',
	'3' => '长在线',
	'4' => '超长在线',
);
$dictLevel = array(
	'name' => '等级标签',
	'1' => '高级角色',
	'2' => '练级角色',
	'3' => '新手角色',
);
$dictConsume = array(
	'name' => '消费标签',
	'1' => '无付费',
	'2' => '低额付费',
	'3' => '小额付费',
	'4' => '中额付费',
	'5' => '大额付费',
	'6' => '超额付费',
);
$dictRoleLabel = array(
//	'active' => '活跃标签',
//	'online' => '在线时间标签',
//	'level' => '等级标签',
	'active' => $dictActive,
	'online' => $dictOnline,
	'level' => $dictLevel,
	'vip' => 'VIP',
//	'consume' => '消费标签',
	'consume' => $dictConsume,
	'interactive' => '注重社交',
	'deal' => '注重交易',
	'activity' => '喜好活动',
	'boss' => '喜好野外BOSS',
	'copy' => '喜好副本',
	'task' => '喜好日常任务',
	'home_manage' => '喜好家园管理',
	'plant' => '喜好种植',
	'pk' => '喜好PK',
	'sit' => '喜好打坐',
	'pet_mix' => '喜好宠物融合',
);



$searchType = isset($_REQUEST['search_type'])?intval($_REQUEST['search_type']):1;
$lable = isset($_POST['label'])?$_POST['label']:array();
$roleName = isset($_POST['role_name'])?trim(SS($_POST['role_name'])):"";
$accountName = isset($_POST['account_name'])?trim(SS($_POST['account_name'])):"";

//分页参数
$pageNum = intval($_POST['record']) ? SS($_POST['record']) : LIST_PER_PAGE_RECORDS;

$counts = 0;//总记录
$pageno = getUrlParam('page');//设置初始页
$startNum = ($pageno - 1) * $pageNum; //每页开始位置

$errorMsg = "";

$selectLabel = array();
foreach($lable as $k => $v){
	if(!$_REQUEST[$v]) {
		$selectLabel[$v] = "1";
	} else {
		$selectLabel[$v] = $_REQUEST[$v];
	}
}

if ( isPost() ){
	if($searchType == 1 && empty($roleName) && empty($accountName)) {
		$errorMsg = $lang->player->accountNameOrRoleNameNotValid ;
	}
	if($searchType == 2 && empty($lable)) {
		$errorMsg = $lang->verify->recLabel;
	}
	
	$condArr = array();
	if($searchType == 1) {
		if($roleName) {
			$condArr[] = " `role_name` = '{$roleName}' ";
		}
		if($accountName) {
			$condArr[] = " `account_name` = '{$accountName}' ";
		}
	} elseif ($searchType == 2) {
		foreach($selectLabel as $k => $v) {
			$condArr[] = " `{$k}` = '{$v}' ";
		}
	}
	
	$where = implode(" AND ", $condArr);
	
	if($searchType == 1) {
		$sql = "select * from " . C_ROLE_LABEL . " where $where ";
//		$result = GFetchRowOne($sql);
		
		$result = GFetchRowSet($sql);
		$viewData = handleData($result,$accountName,$roleName);
		/*
		if (!empty($result)) {
			$accountName = $result['account_name'];
			$roleName = $result['role_name'];
			foreach ( $result as $key => $value ) {
				if(array_key_exists($key,$dictRoleLabel)) {
					if(is_array($dictRoleLabel[$key]) && !empty($value)) {
						$hasLabel .= $dictRoleLabel[$key][$value]."," ;
					} elseif ( !empty($value) ){
						$hasLabel .= $dictRoleLabel[$key]."," ;
					}
				} else {
					$viewData[$key] = $value;
				}
			}
			
			$viewData['hasLabel'] = trim($hasLabel,",");
		}
		*/
	} else {
		$sqlCnt = "select count(*) as count from " . C_ROLE_LABEL . " where {$where}";
		$cntResult = GFetchRowOne($sqlCnt);
		$counts = $cntResult['count'];
		$sql = "select * from  " . C_ROLE_LABEL . "  where {$where} order by `account_name` limit {$startNum},{$pageNum}";
		$result = GFetchRowSet($sql);
		$viewData = handleData($result);
	}

}

//print_r($viewData);

//分页参数
$pageCount = ceil ( $counts/$pageNum );
$pagelist = getPages($pageno, $counts,$pageNum);

$smarty->assign('counts', $counts );
$smarty->assign('pagelist', $pagelist );
$smarty->assign('pageCount', $pageCount );
$smarty->assign('pageNum', $pageNum );
$smarty->assign('pageno', $pageno );

$smarty->assign('lang', $lang );
$smarty->assign('roleName', $roleName );
$smarty->assign('accountName', $accountName );
$smarty->assign('search_type', $searchType );
$smarty->assign('selectLabel', $selectLabel );
$smarty->assign('dictRoleLabel', $dictRoleLabel );
$smarty->assign('viewData', $viewData );
$smarty->assign('errorMsg', $errorMsg );
$smarty->display( 'module/basedata/role_label.tpl' );


function handleData($result, &$accountName="", &$roleName="") {
	global $dictRoleLabel,$selectLabel;
	
	if(empty($result)){
		return false;
	}
	
	$viewData = array();
	
	foreach ( $result as $key => $value ) {
		if(is_array($value)) {
			if($accountName || $roleName) {
				$accountName = $value['account_name'];
				$roleName = $value['role_name'];
			}
			$hasLabel = "";
			foreach($value as $k => $v ) {
				//处理label
				if(array_key_exists($k, $dictRoleLabel)) {
					
					if(is_array($dictRoleLabel[$k]) && !empty($v)) {
						
						if(array_key_exists($k,$selectLabel)) {
							$hasLabel .= '<font color="#900">'.$dictRoleLabel[$k][$v]."</font>," ;
						} else {
							$hasLabel .= $dictRoleLabel[$k][$v]."," ;
						}
					} elseif ( !empty($v) ){
						if(array_key_exists($k,$selectLabel)) {
							$hasLabel .= '<font color="#900">'.$dictRoleLabel[$k]."</font>," ;
						} else {
							$hasLabel .= $dictRoleLabel[$k]."," ;
						}
						
					}
				} else {
					$viewData[$value['uuid']][$k] = $v;
				}
			}
			$viewData[$value['uuid']]['hasLabel'] = trim($hasLabel,",");
		}
		
	}

	
	return $viewData;
}