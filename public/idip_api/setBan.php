<?php
/**
*	Description:idip设置封号接口。
*/

include dirname(dirname(__FILE__)).'/idip_api/idip_auth.php';
include_once SYSDIR_ADMIN_CLASS.'/user_class.php';
$openid = $_GET['openid'];
$serverid = $_GET['serverID'];
$serverid = str_replace("s", "", $serverid);
$value = intval($_GET['value']);
$action = $_GET['action'];



$entranceUrl = $serverList[$_SESSION['gameAdminServer']]['url'];
$apiUrl = $entranceUrl."api/ban_account.php";
// new dBug($apiUrl);
// die();

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
	$level = $player[data][player][Level];
}

if('ban' == $action){

    $accountNameSearch =  $roleid;
    $roleNameSearch =  $roleName;

    $banTimeArr = 1;// 指定时间单位为分钟
    $banTimeCell = $value;// 封号的时间数
    $reasonArr = "IDIP发起封号";//这里写死是IDIP发起封号
    $banTime = ($banTimeArr == 1) ? $banTimeCell : ($banTimeArr + $banTimeCell);
    if( empty ( $accountNameSearch ) && empty ( $roleNameSearch ) ){
        $msg = $lang->verify->recRoleNameOrAccount ;
    }
    if( empty ($banTime) ){
        $msg = $lang->verify->banTimeNotNull;
    }

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
		// new dBug($paramStr);
		// die($apiUrl);
		$result = @json_decode(curlPost($apiUrl, $paramStr), true);
		// die(new dBug($result));
		if(1 == $result['result']){

        	//写入数据库
	        $data['role_name'] = $roleName;
	        $data['account_name'] = $roleid;
	        $data['ip'] = '0.0.0.0';
	        $data['level'] = $level;
	        $data['ban_time'] = time();
	        $data['free_time'] = $paramsArr['freeTime'];
	        $data['ban_reason'] = $paramsArr['reason'];
	        $data['status'] = 1;
	        $data['op_user'] = "idip";
	        $sql = makeInsertSqlFromArray($data, T_BAN_ACCOUNT,'replace');
	        // new dBug($sql);
	        GQuery($sql);
        	
        	if(!empty($paramsArr['roleName'])) {
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
   //          global $auth;
   //          new dBug($auth);
			// $auth->userid = 9999;
			// $auth->username = 'idip';
   //          $log = new AdminLogClass();
   //          $log->Log(AdminLogClass::TYPE_BAN_USER,$lang->page->accountName.":{$data['account_name']},".$lang->page->roleName.":{$data['role_name']}",'','','','');

        }else{
            $msg = $result['errorMsg'];
        }
        echo(@json_encode($result));
    }
    
}elseif('unban' == $action){

    $account_name = $roleid;

   //$banTime = SS($_REQUEST['banTime']);
    $reasonArr = 'idip发起解封请求';
    
    $paramsArr = array(
        'accountName' => $account_name,
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
        $sql = " update ".T_BAN_ACCOUNT." set status = 2 , free_time = ".time()." where account_name = '{$account_name}' limit 1 ";
        $rs = GQuery($sql);
        $msg = $lang->verify->opSuc;
        //写日志
        // $log = new AdminLogClass();
        // $log->Log(AdminLogClass::TYPE_UNBAN_USER,$lang->page->accountName.":{$account_name}",'','','','');
    }else{
         $msg = $result['errorMsg'];
    }
    echo(@json_encode($result));
}
