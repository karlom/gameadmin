<?php
/**
 * 封禁玩家账号
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_CLASS.'/user_class.php';
global $lang;

$action = SS($_REQUEST['action']);
$msg = array();

$entranceUrl = $serverList[$_SESSION['gameAdminServer']]['url'];
$apiUrl = $entranceUrl."api/ban_account.php";

if('ban' == $action){
	if(!$entranceUrl){
		die($lang->msg->entranceUrlNull);
	}
	
    $accountNameSearch =  SS($_POST['account_name']) ;
    $roleNameSearch =  SS($_POST['role_name']) ;
//    $serverId = intval($_POST['server_id']);
    $banTimeArr = SS($_POST['ban_time_arr']);
    $banTimeCell = intval($_POST['ban_time']);
    $reasonArr = SS($_POST['reasonArr']);
    $banTime = ($banTimeArr == 1) ? $banTimeCell : ($banTimeArr + $banTimeCell);
    if( empty ( $accountNameSearch ) && empty ( $roleNameSearch ) ){
        $msg = $lang->verify->recRoleNameOrAccount ;
    }
    if( empty ($banTime) ){
        $msg = $lang->verify->banTimeNotNull;
    }
//    if($accountNameSearch && empty ( $roleNameSearch ) ){
//        $role = UserClass::getUser($roleNameSearch, $accountNameSearch);
//        $roleNameSearch = $role['role_name'];
//    }

	$freeTime = ($banTime*60)+time();
    $paramsArr = array(
        'accountName' => $accountNameSearch,
        'roleName' => $roleNameSearch,
        'reason' => $reasonArr,
        'freeTime' => $freeTime,
    );
    if( empty($msg) ){
    	//向入口API请求
    	$ac = 'add';
    	$timestamp = time();
    	$key = urlencode(md5($timestamp.ADMIN_GAME_AUTH_KEY));
    	$jsonBanList = urlencode(json_encode($paramsArr));
    	
    	$paramStr = "timestamp={$timestamp}&key={$key}&action={$ac}&jsonBanList={$jsonBanList}";
//		$apiUrl = $entranceUrl."api/ban_account.php";
		
		$result = json_decode(curlPost($apiUrl, $paramStr), true);
		
		if(1 == $result['result']){

        	//写入数据库
	        $data['role_name'] = $paramsArr['roleName'];
	        $data['account_name'] = $paramsArr['accountName'];
	        $data['ip'] = $_POST['ip'];
	        $data['level'] = $_POST['level'];
	        $data['ban_time'] = time();
	        $data['free_time'] = $paramsArr['freeTime'];
	        $data['ban_reason'] = $paramsArr['reason'];
	        $data['status'] = 1;
	        $data['op_user'] = $auth->username();
	        $sql = makeInsertSqlFromArray($data, T_BAN_ACCOUNT,'replace');
	        GQuery($sql);
        	
        	if(!empty($_POST['kickuser']) && $_POST['kickuser'] == $paramsArr['roleName']) {
        		//T下线
        		
	            $rs = interfaceRequest("useroffline", array('roleName' => $paramsArr['roleName'],) );
	            
	            if($rs['result'] == 1) {
	            	$msg[] = '玩家[ '.$paramsArr['roleName'].' ]已被踢下线';
	            } else {
	            	$msg[] = "踢下线失败！原因：{$rs['errorMsg']}";
	            }
        	}
        	
//            $msg[] = $lang->verify->opSuc;
            $msg[] = '封号成功';
            //写日志
            $log = new AdminLogClass();
            $log->Log(AdminLogClass::TYPE_BAN_USER,$lang->page->accountName.":{$data['account_name']},".$lang->page->roleName.":{$data['role_name']}",'','','','');

        }else{
            $msg = $result['errorMsg'];
        }
    }
    
}elseif('unban' == $action){
	if(!$entranceUrl){
		die($lang->msg->entranceUrlNull);
	}
	
    $account_name = SS($_REQUEST['account_name']);

    $banTime = SS($_REQUEST['banTime']);
    $reasonArr = SS($_REQUEST['reason']);
    $id= SS($_REQUEST['id']);
    
    $paramsArr = array(
        'accountName' => $account_name,
//        'banTime' => $banTime,
    );

	//向入口API请求
	$ac = 'delete';
	$timestamp = time();
	$key = urlencode(md5($timestamp.ADMIN_GAME_AUTH_KEY));
	$jsonBanList = urlencode(json_encode($paramsArr));
	
	$paramStr = "timestamp={$timestamp}&key={$key}&action={$ac}&jsonBanList={$jsonBanList}";
//	$apiUrl = $entranceUrl."api/ban_account.php";
	
	$result = json_decode(curlPost($apiUrl, $paramStr), true);


    if(1 == $result['result']){
        $sql = " update ".T_BAN_ACCOUNT." set status = 2 , free_time = ".time()." where id = {$id} and account_name = '{$account_name}' limit 1 ";
        $rs = GQuery($sql);
        $msg = $lang->verify->opSuc;
        //写日志
        $log = new AdminLogClass();
        $log->Log(AdminLogClass::TYPE_UNBAN_USER,$lang->page->accountName.":{$account_name}",'','','','');
    }else{
         $msg = $result['errorMsg'];
    }
}


if( isset($_POST['searchAccount']) && isset($_POST['term']) )
{
	if(!Validator::stringNotEmpty(SS($_POST['term'])))
	{
		$msg[] = $lang->page->pleaseInputRolename;
	}else{
		$term = SS($_POST['term']);
		$userList = array();

	    $method = 'getuserbasestatus';
        $params = array(
            'accountName' => "",
            'roleName' => $term,
        );
        $viewData = interfaceRequest($method, $params);
        if($viewData['result'] == 1){
	        $userList['account_name'] = $viewData['data']['accountName'];
	        $userList['role_name'] = $viewData['data']['roleName'];
	        $userList['level'] = $viewData['data']['level'];
	        $userList['total_pay'] = $viewData['data']['totalPay'];
	        $userList['online'] = $viewData['data']['isOnline'] ? $viewData['data']['isOnline'] : 0;
	        $userList['ip'] = $viewData['data']['ip'];	
	    } else {
	    	$msg[] = $viewData['errorMsg'];
	    }

		$smarty->assign('term', $term);
		if(!empty($userList))
		{ 
//			addTotalPay($userList);
//			addOnlineStatus($userList); 
			$smarty->assign("userList",$userList);
		}else{
			//todo
			$msg[] = '用户不存在';
		}
	}
	
}

if( isset($_POST['loadList']) && $_POST['loadList'] == 1 ) {
	//向入口API请求
	$ac = 'get';
	$timestamp = time();
	$key = urlencode(md5($timestamp.ADMIN_GAME_AUTH_KEY));
	
	$paramStr = "timestamp={$timestamp}&key={$key}&action={$ac}";
//	$apiUrl = $entranceUrl."api/ban_account.php";
	
	$result = json_decode(curlPost($apiUrl, $paramStr), true);
//	print_r($result);
	if($result['result'] == 1 && !empty($result['data']) ){
		foreach($result['data'] as $ac => $v ) {

        	//写入数据库
	        $data['role_name'] = $v['roleName'];
	        $data['account_name'] = $v['accountName'];
	        $data['free_time'] = $v['freeTime'];
	        $data['ban_reason'] = $v['reason'];
		    $data['ban_time'] = time();
		    if( $data['free_time'] - time() < 0 ) {
		    	$data['status'] = 0;
		    } else {
		    	$data['status'] = 1;
		    }
		    
	        $rs = interfaceRequest('getuserbasestatus', array('roleName'=>$v['roleName']) );
	        if($rs['result'] == 1) {
	        	$data['ip'] = $rs['data']['ip'];
		        $data['level'] = $rs['data']['level'];
	        } else {
	        	$data['ip'] = "0.0.0.0";
		        $data['level'] = 0;
	        }
	        
	        $data['op_user'] = $auth->username();
	        $sql = makeInsertSqlFromArray($data, T_BAN_ACCOUNT,'replace');
//	        echo "sql= ".$sql ."<br>";
	        GQuery($sql);
        	
		}
		
        $msg = $lang->verify->opSuc;
        //写日志
        $log = new AdminLogClass();
        $log->Log(AdminLogClass::TYPE_BAN_USER,"从服务器同步禁封账号列表",'','','','');

	} else{
        $msg = $result['errorMsg'];
    }
}

$record = isset($_POST['record']) ? intval($_POST['record']) : LIST_PER_PAGE_RECORDS;
$countResult = 0;//总记录
$pageno = getUrlParam('page');//设置初始页
$startNum = ($pageno - 1) * $record; //每页开始位置
$keywordlist	= getBanAccountList($where,$startNum,$record,$countResult);

if(isset ($_POST) && count($keywordlist)>0) {
    $now = time();
    foreach ($keywordlist as &$row) {
        if($row['free_time'] <= $now){
            $sqlUpdate = "update ".T_BAN_ACCOUNT." set status = 0 where id = {$row['id']} and status = 1 ";
        	GQuery($sqlUpdate);
        }
        $row['ban_time'] = date('Y-m-d H:i:s',$row['ban_time']);
        $row['free_time'] = date('Y-m-d H:i:s',$row['free_time']);
    }
}

$strMsg = is_array($msg) && $msg ? implode('<br />', $msg) :$msg ;
$pagelist = getPages($pageno, $countResult,$record);
$pageCount = ceil($countResult/$record);
$smarty->assign("strMsg",$strMsg);
$smarty->assign("account",$_POST['account']);
$smarty->assign("role_name",$_POST['rolename']);
$smarty->assign("lang", $lang);
$smarty->assign("viewData", $viewData);
$smarty->assign("banReason", getReason());
$smarty->assign("banTime", getBanTime());
$smarty->assign("pageno",$pageno);
$smarty->assign("pagelist",$pagelist);
$smarty->assign("record",$record);
$smarty->assign("count_result",$countResult);
$smarty->assign("page_count",$pageCount);
$smarty->assign("role_name_search",$roleNameSearch);
$smarty->assign("account_name_search",$accountNameSearch);
$smarty->assign("keywordlist",$keywordlist);
$smarty->display("module/msg/ban_account.tpl");

function getBanAccountList($where,$startNum,$record,& $counts){
    $sql = "select * from ".T_BAN_ACCOUNT." where 1 {$where} order by free_time desc limit {$startNum},{$record}";
    $rs = GFetchRowSet($sql);

    $sqlCount = "select count(*) as counts FROM ".T_BAN_ACCOUNT." where 1 {$where} ";
    $counts = GFetchRowOne($sqlCount);
    $counts = $counts['counts'];
    return $rs;
}

function addTotalPay(&$userList)
{
	foreach ($userList as &$user)
	{
		$sqlTotalPay = "SELECT SUM(pay_money) total FROM " . T_LOG_PAY . " WHERE account_name = '{$user['account_name']}' GROUP BY account_name;";
		$result = GFetchRowOne($sqlTotalPay);
		$user['total_pay'] = isset( $result['total'] )? $result['total']:0;
	}
}

function addOnlineStatus(&$userList)
{
	$onlineList = RequestCollection::getOnlineList();
	
	$onlineAccountList = array();
	foreach ($onlineList['data'] as $record)
	{
		if(!in_array($record['roleName'], $onlineAccountList))
		{
			$onlineAccountList[] = $record['roleName'];
		}
	} 
	foreach ($userList as &$user)
	{
		if(in_array($user['role_name'], $onlineAccountList))
		{
			$user['online'] = 1;
		}
		else 
		{
			$user['online'] = 0;
		}
	}
}