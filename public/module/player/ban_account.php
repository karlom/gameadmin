<?php
/**
 * 封禁玩家账号
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_CLASS.'/user_class.php';
global $lang;

$msg = array ();
$action = SS($_REQUEST['action']);
$method = 'banaccountname';
$msg = array();
if('ban' == $action){
    $accountNameSearch = autoAddPrefix( SS($_POST['account_name']) );
    $roleNameSearch = autoAddPrefix( SS($_POST['role_name']) );
    $serverId = intval($_POST['server_id']);
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
    $params = array(
        'accountName' => $accountNameSearch,
        'roleName' => $roleNameSearch,
        'reason' => $reasonArr,
        'banTime' => $banTime,
    );
    if( empty($msg) ){
        $viewData = interfaceRequest($method, $params);
        if(1 == $viewData['result']){
            $user = UserClass::getUser($roleNameSearch, $accountNameSearch);
            $data['role_name'] = $user['role_name'];
            $data['account_name'] = $user['account_name'];
            $data['ip'] = $viewData['data']['ip'];
            $data['level'] = $viewData['data']['level'];
            $data['ban_time'] = time();
            $data['free_time'] = ($banTime*60)+time();
            $data['ban_reason'] = $params['reason'];
            $data['status'] = 1;
            $data['op_user'] = $auth->username();
//            if( !empty ($data['account_name'])){
                $sql = makeInsertSqlFromArray($data, T_BAN_ACCOUNT);
                GQuery($sql);
                $msg = $lang->verify->opSuc;
                //写日志
                $log = new AdminLogClass();
                $log->Log(AdminLogClass::TYPE_BAN_USER,$lang->page->accountName.":{$data['account_name']},".$lang->page->roleName.":{$data['role_name']}",'','','','');
//            }
        }else{
            $msg = $viewData['errorMsg'];
        }
    }
    
}elseif('unban' == $action){

    $account_name = autoAddPrefix(SS($_REQUEST['account_name']));
    $role_name = autoAddPrefix(SS($_REQUEST['role_name']));
    
    $banTime = SS($_REQUEST['banTime']);
    $reasonArr = SS($_REQUEST['reason']);
    $id= SS($_REQUEST['id']);
    $params = array(
        'accountName' => $account_name,
        'banTime' => $banTime,
    );

    $view = interfaceRequest($method, $params);

    if(1 == $view['result']){
        $sql = " update ".T_BAN_ACCOUNT." set status = 2 , free_time = ".time()." ,op_user='".$auth->username()."' where id = {$id} and account_name = '{$account_name}' limit 1 ";
        $rs = GQuery($sql);
        $msg = $lang->verify->opSuc;
        //写日志
        $log = new AdminLogClass();
        $log->Log(AdminLogClass::TYPE_UNBAN_USER,$lang->page->accountName.":{$account_name},".$lang->page->roleName.":{$role_name}",'','','','');
    }else{
         $msg = $view['errorMsg'];
    }
}
/*
if($_POST['rolename']){
    $roleName = autoAddPrefix( SS($_POST['rolename']) );
    $where = isset ($_POST['rolename'])?" and role_name = '$roleName' " :"";
}
if($_POST['account']){
	$accountName = autoAddPrefix( SS($_POST['account']) );
    $where .= isset ($_POST['account'])?" and account_name = '$accountName' ":"";
}*/

if( isset($_POST['searchAccount']) && isset($_POST['term']) )
{
	if(!Validator::stringNotEmpty(SS($_POST['term'])))
	{
		$msg[] = $lang->page->inputIPOrRolename;
	}else{
		$term = SS($_POST['term']);
		$userList = array();
		if(Validator::isIpv4($term))
		{
			$userList = UserClass::getUserListByIP($term);
		}else{
			$term = autoAddPrefix($term);
			$tmpUser = UserClass::getUser($term);
			if($tmpUser)
			{
				$userList[] = $tmpUser;
			}
    		if(empty($userList)){
    		    $method = 'getuserbasestatus';
                $params = array(
                    'accountName' => "",
                    'roleName' => $term,
                );
                $viewData = interfaceRequest($method, $params);
                $userList[0]['account_name'] = $viewData['data']['accountName'];
                $userList[0]['role_name'] = $viewData['data']['roleName'];
                $userList[0]['level'] = $viewData['data']['level'];
                $userList[0]['total_pay'] = $viewData['data']['totalPay'];
                $userList[0]['online'] = $viewData['data']['isOnline'] ? $viewData['data']['isOnline'] : 0;
                $userList[0]['ip'] = $viewData['data']['ip'];
    		}

		}
		$smarty->assign('term', $term);
		if(!empty($userList))
		{ 
			addTotalPay($userList);
			addOnlineStatus($userList); 
			$smarty->assign("userList",$userList);
		}else{
			//todo
			$msg[] = '用户不存在';
		}
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
$smarty->display("module/player/ban_account.tpl");

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