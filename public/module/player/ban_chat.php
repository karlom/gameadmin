<?php
/**
 * 玩家禁言
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
global $lang;
$table = T_BAN_CHAT;
$msg = array ();
$action = SS($_REQUEST['action']);
$roleName = autoAddPrefix( SS($_POST['nick_name'] ));
$serverId = intval($_POST['server_id']);
$banTimeArr = SS($_POST['ban_time_arr']);
$banTimeCell = intval($_POST['ban_time']);
$reasonArr = SS($_POST['reasonArr']);
$method = 'chatbanuser';
if('ban' == $action){
	$banTime = ($banTimeArr == 1) ? $banTimeCell:$banTimeArr+$banTimeCell;
    if( empty ( $roleName ) || empty ( $reasonArr ) ){
        $msg = $lang->verify->isNotNull;
    }
	$params = array(
	    'roleName' => $roleName,
	    'reason' => $reasonArr,
	    'banTime' => $banTime,
	);
    if( empty ( $msg ) ){
        $viewData = interfaceRequest($method, $params);
        if(1 == $viewData['result']){
            $data['op_user'] = $auth->username();
            $data['role_name'] = $viewData['data']['roleName'];
            $data['account_name'] = $viewData['data']['accountName'];
            $data['ip'] = $viewData['data']['ip'];
            $data['level'] = $viewData['data']['level'];
            $data['ban_time'] = time();
            $data['status'] = 1;
            $data['ban_reason'] = $reasonArr;
            $data['free_time'] = ($banTime * 60) + $data['ban_time'];
            $sql = makeInsertSqlFromArray($data, $table);
            GQuery($sql);
            //写日志
            $log = new AdminLogClass();
            $log->Log(AdminLogClass::TYPE_BAN_CHAT,$lang->page->accountName.":{$data['account_name']},".$lang->page->roleName.":{$data['role_name']}",'','','','');
        }else{
                $msg  = $viewData['errorMsg'];
        }
    }
}elseif('unban' == $action){
    $roleNameGet= autoAddPrefix( SS($_REQUEST['roleName']) );
    $banTime = SS($_REQUEST['banTime']);
    $id= SS($_REQUEST['id']);
    $params = array(
        'roleName' => $roleNameGet,
        'banTime' => $banTime,
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
$accountNameSearch = autoAddPrefix( SS($_POST['account']) );
$roleNameSearch = autoAddPrefix( SS($_POST['role_name']) );
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
$smarty->display("module/player/ban_chat.tpl");

function getBanChatList($where,$startNum,$record,& $counts){
    global $table;
    $sql = "select * from {$table} where 1 {$where} order by ban_time desc limit {$startNum},{$record}";
    $rs = GFetchRowSet($sql);
    
    $sqlCount = "select count(*) as counts FROM {$table} where 1 {$where} ";
    $counts = GFetchRowOne($sqlCount);
    $counts = $counts['counts'];
    return $rs;
}