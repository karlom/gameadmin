<?php
/**
*	Description:idip设置禁言接口。
*/

include dirname(dirname(__FILE__)).'/idip_api/idip_auth.php';
include_once SYSDIR_ADMIN_CLASS.'/user_class.php';
$openid = $_GET['openid'];
$serverid = $_GET['serverID'];
$serverid = str_replace("s", "", $serverid);
$value = intval($_GET['value']);
$action = $_GET['action'];



// $entranceUrl = $serverList[$_SESSION['gameAdminServer']]['url'];
// $apiUrl = $entranceUrl."api/ban_account.php";
// new dBug($apiUrl);
// die();
$table = 't_ban_chat';
$method = 'ban_say';
if($openid){
	$method1 = "getuserstatus";

	$params1 = array();
	// $params1['accountName'] = $serverid.'-'.$openid;
    if(intval($serverid) == 1){
        $params1['accountName'] = '01-'.$openid;
    }elseif (intval($serverid) == 2) {
        $params1['accountName'] = $openid;
    }else{
        $params1['accountName'] = $serverid.'-'.$openid;
    }

	$player = @json_encode(interfaceRequest($method1, $params1));
	$player = json_decode($player,true);
	//new dBug($player);
    if($player[result] == 3){
        $rsp = array(
            'result' => 2,
            'msg' => $player[errorMsg],
            );
        echo(json_encode($rsp));
        die();
    }
	$roleid = $player[data][player][accountName];
	$roleName = $player[data][player][roleName];
	$level = $player[data][player][level];
}

if('ban' == $action){
    if( empty ( $roleName ) || empty ( $ban_reason ) ){
        $msg = $lang->verify->isNotNull;
    }
	$params = array(
	    'name' => $roleName,
	    'minute' => $value,
	);
    if( empty ( $msg ) ){
        $viewData = interfaceRequest($method, $params);
        // new dBug($viewData);
        if(1 == $viewData['result']){
        	
        	$reSql = "select * from t_log_login L , (select max(mtime) as mtime, role_name from t_log_login where account_name='{$roleid}') M " .
        			" where L.mtime=M.mtime and L.role_name=M.role_name ";
        	
        	$rqResult = GFetchRowOne($reSql);

            $data['op_user'] = 'idip';
            $data['uuid'] = $rqResult['uuid'];
            $data['role_name'] = $roleName;
            $data['account_name'] = $rqResult['account_name'];
            $data['ip'] = '0.0.0.0';
            $data['level'] = $level;
            $data['ban_time'] = time();
            $data['status'] = 1;
            $data['ban_reason'] = 'idip发起禁言';
            $data['free_time'] = ($value * 60) + $data['ban_time'];
            $sql = makeInsertSqlFromArray($data, $table);
            // new dBug($sql);
            GQuery($sql);
            //写日志
            // $log = new AdminLogClass();
            // $log->Log(AdminLogClass::TYPE_BAN_CHAT,$lang->page->accountName.":{$data['account_name']},".$lang->page->roleName.":{$data['role_name']}",'','','','');
        }else{
                $msg  = $viewData['msg'];
        }
        echo(@json_encode($viewData));
    }
}elseif('unban' == $action){
    $roleNameGet=  $roleName ;
    $params = array(
        'name' => $roleNameGet,
        'minute' => 0,
    );
    $view = interfaceRequest($method, $params);
    if(1 == $view['result']){
        $sql = " update {$table} set status = 2,free_time = ".time()." where role_name = '{$roleNameGet}' and status = 1 and op_user='idip' limit 1 ";
        $rs = GQuery($sql);
        $msg = $lang->verify->opSuc;
        //写日志
        // $log = new AdminLogClass();
        // $log->Log(AdminLogClass::TYPE_UNBAN_CHAT,$lang->page->roleName.":{$roleNameGet}",'','','','');
    }else{
         $msg = $view['errorMsg'];
    }
    echo(@json_encode($view));
}
