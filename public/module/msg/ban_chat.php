<?php
/**
 * ban_chat.php
 * 玩家禁言
 * 
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
global $lang;

$table = T_BAN_CHAT;

$msg = array ();
$action = SS($_REQUEST['action']);
$roleName =  SS($_POST['nick_name'] );
$banTime = intval($_POST['ban_time']);
$ban_reason = SS($_POST['ban_reason']);
$method = 'ban_say';

if('ban' == $action){
    if( empty ( $roleName ) || empty ( $ban_reason ) ){
        $msg = $lang->verify->isNotNull;
    }
	$params = array(
	    'name' => $roleName,
	    'minute' => $banTime,
	);
    if( empty ( $msg ) ){
        $viewData = interfaceRequest($method, $params);
        if(1 == $viewData['result']){
        	
        	$reSql = "select * from t_log_login L , (select max(mtime) as mtime, role_name from t_log_login where role_name='{$roleName}') M " .
        			" where L.mtime=M.mtime and L.role_name=M.role_name ";
        	$rqResult = GFetchRowOne($reSql);
//        	$reqResult = interfaceRequest( "getuserbasestatus", array( "roleName"=>$roleName) );
//        	if($reqResult['result'] != 1) {
//        		$reqResult['data'] = GFetchRowOne($reSql);
//        	}
        	
            $data['op_user'] = $auth->username();
            $data['uuid'] = $rqResult['uuid'];
            $data['role_name'] = $roleName;
            $data['account_name'] = $rqResult['account_name'];
            $data['ip'] = $rqResult['ip'];
            $data['level'] = $rqResult['level'];
            $data['ban_time'] = time();
            $data['status'] = 1;
            $data['ban_reason'] = $ban_reason;
            $data['free_time'] = ($banTime * 60) + $data['ban_time'];
            $sql = makeInsertSqlFromArray($data, $table);
            GQuery($sql);
            //写日志
            $log = new AdminLogClass();
            $log->Log(AdminLogClass::TYPE_BAN_CHAT,$lang->page->accountName.":{$data['account_name']},".$lang->page->roleName.":{$data['role_name']}",'','','','');
        }else{
                $msg  = $viewData['msg'];
        }
    }
}elseif('unban' == $action){
    $roleNameGet=  SS($_REQUEST['roleName']) ;
    $banTime = SS($_REQUEST['banTime']);
    $id= SS($_REQUEST['id']);
    $params = array(
        'name' => $roleNameGet,
        'minute' => 0,
    );
    $view = interfaceRequest($method, $params);
    if(1 == $view['result']){
        $sql = " update {$table} set status = 2,free_time = ".time()." where id = {$id} and role_name = '{$roleNameGet}' and status = 1 limit 1 ";
        $rs = GQuery($sql);
        $msg = $lang->verify->opSuc;
        //写日志
        $log = new AdminLogClass();
        $log->Log(AdminLogClass::TYPE_UNBAN_CHAT,$lang->page->roleName.":{$roleNameGet}",'','','','');
    }else{
         $msg = $view['errorMsg'];
    }
}
$accountNameSearch =  SS($_POST['account']) ;
$roleNameSearch =  SS($_POST['role_name']) ;
$record = isset($_POST['record']) ? intval($_POST['record']) : LIST_PER_PAGE_RECORDS;

$where = $roleNameSearch ? " and role_name = '{$roleNameSearch}' " : "";
$where .= $accountNameSearch ? " and account_name = '{$accountNameSearch}' " : "";
$countResult = 0;//总记录
$pageno = getUrlParam('page');//设置初始页
$startNum = ($pageno - 1) * $record; //每页开始位置
$keywordlist = getBanChatList($where,$startNum,$record,$countResult);
if(isset ($_POST) && count($keywordlist)>0) {
    $now = time();
    foreach ($keywordlist as &$row) {
        if($row['free_time'] <= $now && 1 == $row['status']){
            $sqlUpdate = "update {$table} set status = 0 where id = {$row['id']} and status = 1 limit 1";
            $row['status'] = 0;
        	GQuery($sqlUpdate);
        }
        $row['free_time'] = date('Y-m-d H:i:s',$row['free_time']);
        $row['ban_time'] = date('Y-m-d H:i:s',$row['ban_time']);
    }
}
$pagelist = getPages($pageno, $countResult,$record);
$pageCount = ceil($countResult/$record);
$smarty->assign("msg",$msg);
$smarty->assign("lang", $lang);
$smarty->assign("viewData", $viewData);
$smarty->assign("banReason", getReason());
$smarty->assign("banTime", getBanTime());
$smarty->assign("keyWord", $keyWord);
$smarty->assign("pageno",$pageno);
$smarty->assign("pagelist",$pagelist);
$smarty->assign("record",$record);
$smarty->assign("count_result",$countResult);
$smarty->assign("page_count",$pageCount);
$smarty->assign("role_name_search",$roleNameSearch);
$smarty->assign("account_name_search",$accountNameSearch);
$smarty->assign("keywordlist",$keywordlist);
$smarty->display("module/msg/ban_chat.tpl");

function getBanChatList($where,$startNum,$record,& $counts){
    global $table;
    $sql = "select * from {$table} where 1 {$where} order by ban_time desc limit {$startNum},{$record}";
    $rs = GFetchRowSet($sql);
    
    $sqlCount = "select count(*) as counts FROM {$table} where 1 {$where} ";
    $sqlCountResult = GFetchRowOne($sqlCount);
    $counts = $sqlCountResult['counts'];
    return $rs;
}