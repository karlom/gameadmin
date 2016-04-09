<?php
/**
 * restore_family.php
 * 查询历史玩家信息，并进行恢复
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';
include_once SYSDIR_ADMIN_CLASS.'/user_class.php';
include_once SYSDIR_ADMIN_DICT.'/dict.php';
include_once SYSDIR_ADMIN_DICT.'/arrItemsAll.php';
include_once SYSDIR_ADMIN_DICT.'/map.php';

global $lang,$dictMap;

$arrFcm = array(
	0=>$lang->verify->pass,
	1=>$lang->verify->notPass,
	2=>$lang->verify->notReg,
	3=>$lang->verify->use.GAME_ZH_NAME.$lang->verify->fcmSYS,
);
$action = $_POST['action'];
$role = isPost() ? $_POST['role'] : "";
$stones = array();
$itemsOrd = array();
$familyName = $_POST['familyName'];
$newFamilyName = $_POST['newFamilyName'];


$serv = "s0";	//固定从s0取
if(!isset($serverList[$serv])){
	$msg[] = '没有找到中转服务器的配置，请先配置！';
}
	
if($familyName && $role){

	if ('restoreData' == $action ) {
       	
       	if($newFamilyName) {
       		
	        if($serverList[$serv]){
				        	
	        	$params = array(
	        		'familyName' => $familyName,
	        		'account' => $role['account_name'],
	        	);
				$toRestoreData = socketRequestResult($serv, "getFamily", $params);
				if($toRestoreData['result'] == 1) {
					$toRestoreFamily = $toRestoreData['family'];
					$toRestoreAccount = $toRestoreData['account'];
					$toRestoreFamilyStr = decodeUnicode(json_encode($toRestoreFamily));
				} else {
					$msg[] = '获取家族旧数据失败！<br>'.$toRestoreData['errorMsg'];
				}
        	 
			} else {
				$msg[] = "服务器地址配置错误";
			}
        	
        	if(empty($msg)) {
        		
        		//恢复旧数据前先保存当前数据start
				$params = array(
	        		'familyName' => $newFamilyName,
	        		'account' => $role['account_name'],
	        	);
	        	$currentData = interfaceRequest("getFamily", $params);
				if($currentData['result'] != 1) {
					$msg[] = '获取家族当前数据失败！<br>'.$currentData['msg'];
				} else {
					$currentFamily = $currentData['family'];
					$currentAccount = $currentData['account'];
					$currentFamilyStr = decodeUnicode(json_encode($currentFamily));
					
					$insertArr = array(
						'mtime' => time(),
						'family_name' => $familyName,
						'new_family_name' => $newFamilyName,
						'account_name' => $currentAccount,
						'old_data' => $currentFamilyStr,
						'new_data' => $toRestoreFamilyStr,
						'add_person' => $auth->username(),
					);
					
					$sql = makeInsertSqlFromArray($insertArr, "t_restore_family_data");
					if(!@GQuery($sql)){
						$msg[] = '插入数据失败，请稍候再试！';
					}
				}
        		//恢复旧数据前先保存玩家当前数据end
        	}
        	
        	if(empty($msg)) {
        		
        		$toRestoreFamily['familyName'] = $currentFamily['familyName'];
        		
        		//开始恢复旧数据
	            $method = "setFamily";
	            $params = array(
	                'familyName' => $newFamilyName,
	                'account' => $role['account_name'],
	                'family' => $toRestoreFamily,
	            );
//	            print_r($resultArray);
	            $viewData = interfaceRequest($method, $params);
	
	        	if (1 == $viewData['result']) {
	        		$msg[] = "操作成功！成功恢复家族数据：【{$familyName}】->【{$newFamilyName}】";
	                //写日志
	                $log = new AdminLogClass();
	                $log->Log(AdminLogClass::TYPE_RESTORE_PLAYER_DATA,$lang->page->familyName.":{$newFamilyName},".$lang->page->accountName.":{$role['account_name']}",'',"【{$familyName}】->【{$newFamilyName}】",'','');
	        	}else {
	        		$msg[] = "操作失败！恢复家族【{$newFamilyName}】数据失败：".$viewData['msg'];
	        	}
        	}
       	} else {
       		$msg[] = '目标家族名或操作无效！';
       	}
	} 
        
    //查询玩家账号角色名
    $accountName = $role['account_name'];
    $roleName = $role['role_name'];
    if(!$accountName || !$roleName){
    	$params = array();
    	if($accountName) {
    		$params['accountName'] = $accountName;
    	}
    	if($roleName) {
    		$params['roleName'] = $roleName;
    	}
    	$baseData = interfaceRequest("getuserbasestatus", $params );
    	
    	if($baseData['result']==1){
    		$accountName = $role['account_name'] = $baseData['data']['accountName'];
    		$roleName = $role['role_name'] = $baseData['data']['roleName'];
    	} else {
    		$msg[] = '查询玩家基本信息失败：'.$baseData['errorMsg'];
    	}
    }

	$family = array();
    //从旧数据备份里查询家族信息start
    $method = "getFamily";
	$params = array( 'familyName' => $familyName, 'account' => $accountName,);

//        $familyData = interfaceRequest($method, $params );
	$familyData = socketRequestResult($serv, $method, $params);
//        print_r($familyData);
    if($familyData['result'] == 1) {
//        	$family['familyName'] = $familyData['family']['familyName'];
    	$family = $familyData['family'];
    	$account = $familyData['account'];
    } else {
    	$msg[] = '查询旧数据家族信息失败！'.$familyData['msg'];
    }
    //从旧数据备份里查询家族信息end
    
    
    $strMsg = empty($msg) ? '' : implode('<br />', $msg);
    $data = array(
        'role' => $role,
        'arrItemsAll' => $arrItemsAll,
        'familyName' => $familyName,
        'newFamilyName' => $newFamilyName,
        'family' => $family,
        'account' => $account,
        'dictJobs' => $dictJobs,
        'dictSex' => $dictSex,
        'dictFamilyOffical' => $dictFamilyOffical,
    );

} else {
	$msg[] = '请输入家族名和 族长角色或族长账号。';
}

$data['lang'] = $lang;
$data['strMsg'] = $strMsg;
$data['dictMap'] = $dictMap;
$smarty->assign($data);
$smarty->display("module/manager/restore_family.tpl");