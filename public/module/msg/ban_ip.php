<?php
/**
 * 封IP
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_CLASS.'/user_class.php';
global $lang;

$action = SS($_REQUEST['action']);
$msg = array();

$entranceUrl = $serverList[$_SESSION['gameAdminServer']]['url'];
$apiUrl = $entranceUrl."api/ban_ip.php";

if('ban' == $action){
	if(!$entranceUrl){
		die($lang->msg->entranceUrlNull);
	}
	
    $ipSearch =  SS($_POST['ip']) ;
    $banTimeArr = SS($_POST['ban_time_arr']);
    $banTimeCell = intval($_POST['ban_time']);
    $reasonArr = SS($_POST['reasonArr']);
    $banTime = ($banTimeArr == 1) ? $banTimeCell : ($banTimeArr + $banTimeCell);
    if( empty ( $ipSearch )  ){
        $msg = $lang->page->inputIP ;
    }
    if( empty ($banTime) ){
        $msg = $lang->verify->banTimeNotNull;
    }


	$freeTime = ($banTime*60)+time();
    $paramsArr = array(
        'ip' => $ipSearch,
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
		
		$result = json_decode(curlPost($apiUrl, $paramStr), true);

		if(1 == $result['result']){
			
			$roleListStr = "";
			$getRoleListSql = "select ip,role_name from t_log_login where ip='{$paramsArr['ip']}' group by role_name ";
			$roleListArr = GFetchRowSet($getRoleListSql) ;
			if(!empty($roleListArr)) {
				foreach ($roleListArr as $v ) {
					$roleListStr .= $v['role_name'].", ";
				}
			}
			$roleListStr = rtrim($roleListStr, ',');
        	//写入数据库
	        $data['ip'] = $paramsArr['ip'];
	        $data['role_name_list'] = $roleListStr;
	        $data['ban_time'] = time();
	        $data['free_time'] = $paramsArr['freeTime'];
	        $data['ban_reason'] = $paramsArr['reason'];
	        $data['status'] = 1;
	        $data['op_user'] = $auth->username();
	        $sql = makeInsertSqlFromArray($data, T_BAN_IP,'replace');
	        GQuery($sql);
	        
			$onlineList = RequestCollection::getOnlineList();
			if( !empty($onlineList['data']) && is_array($onlineList['data']) ) {
//				$entranceUrl = $serverList[$_SESSION['gameAdminServer']]['url'];
				$banAccountUrl = $entranceUrl."api/ban_account.php";
				foreach( $onlineList['data'] as $k => $v ){
					if( strcmp($v['ip'], $paramsArr['ip']) == 0 ) {

						$arr = array(
							'accountName' => $v['accountName'],
					        'roleName' => $v['roleName'],
					        'reason' => $reasonArr,
					        'freeTime' => $freeTime,
						);
						$jsonBanList = urlencode(json_encode($arr));
						$arrStr = "timestamp={$timestamp}&key={$key}&action=add&jsonBanList={$jsonBanList}";
						
						$ret = json_decode(curlPost($banAccountUrl, $arrStr), true);
						if($ret['result'] == 1) {
			            	$msg[] = '玩家[ '.$v['roleName'].' ]封号成功！';
			            } else {
			            	$msg[] = '玩家[ '.$v['roleName'].' ]封号失败！原因：'.$rs['errorMsg'];
			            }
					}
				}
	
		    } else {
		    	$msg[] = $onlineList['errorMsg'];
		    }
        	
        	if(isset($_POST['kickuser']) && Validator::stringNotEmpty($_POST['kickuser']) ) {
        		//T下线
//        		echo "post:";
        		$list = explode(',',$_POST['kickuser']);
//        		print_r($list);
        		if(is_array($list)) {
        			foreach($list as $role) {
        				$rs = interfaceRequest("useroffline", array('roleName' => $role,) );
        				
			            if($rs['result'] == 1) {
			            	$msg[] = '玩家[ '.$role.' ]已被踢下线';
			            } else {
			            	$msg[] = "踢下线失败！原因：{$rs['errorMsg']}";
			            }
        			}
        		}
        	}
        	
            $msg[] = $lang->verify->opSuc;
            //写日志
            $log = new AdminLogClass();
            $log->Log(AdminLogClass::TYPE_BAN_IP,"IP:{$data['ip']}",'','','','');

        }else{
            $msg[] = $result['errorMsg'];
        }
    }
    
}elseif('unban' == $action){
	if(!$entranceUrl){
		die($lang->msg->entranceUrlNull);
	}
	
    $ip = SS($_REQUEST['ip']);

    $banTime = SS($_REQUEST['banTime']);
    $reasonArr = SS($_REQUEST['reason']);
    $id= SS($_REQUEST['id']);
    
    $paramsArr = array(
        'ip' => $ip,
    );

	//向入口API请求
	$ac = 'delete';
	$timestamp = time();
	$key = urlencode(md5($timestamp.ADMIN_GAME_AUTH_KEY));
	$jsonBanList = urlencode(json_encode($paramsArr));
	
	$paramStr = "timestamp={$timestamp}&key={$key}&action={$ac}&jsonBanList={$jsonBanList}";
	
	$result = json_decode(curlPost($apiUrl, $paramStr), true);

    if(1 == $result['result']){
        $sql = " update ".T_BAN_IP." set status = 2 , free_time = ".time()." where id = {$id} and ip = '{$ip}' limit 1 ";
        $rs = GQuery($sql);
        $msg = $lang->verify->opSuc;
        //写日志
        $log = new AdminLogClass();
        $log->Log(AdminLogClass::TYPE_UNBAN_IP,"IP: {$ip}",'','','','');
    }else{
         $msg = $result['errorMsg'];
    }
}


if( isset($_POST['searchIP']) )
{
	if( empty($_POST['term']) && empty($_POST['roleName']) ) {
		$msg[] = $lang->page->inputIPOrRolename;
	} else if(Validator::stringNotEmpty(SS($_POST['term']))) {
		if(!Validator::isIpv4($_POST['term']) ) {
			$msg[] = $lang->page->mustBeIP;
		} else {
			$ip = $_POST['term'];
		}
		
	} else if ( Validator::stringNotEmpty(SS($_POST['roleName'])) ) {
		$role = SS($_POST['roleName']);
		$ret = interfaceRequest("getuserbasestatus",array("roleName"=> $role,) );
		if($ret['result'] == 1){
			$ip = $ret['data']['ip'];
		} else {
			$sql = "select account_name,role_name, ip from t_log_login where role_name='{$role}' ";
			$ret = GFetchRowOne($sql);
			if(!empty($ret['ip'])) {
				$ip = $ret['ip'];
			}
		}
		
	} 
	if(!empty($ip)) {
		
		$term = $ip;
		$userList = array();
		$onlineCount = 0;
		$onlineListStr = "";

		$onlineList = RequestCollection::getOnlineList();
		
		if( !empty($onlineList['data']) && is_array($onlineList['data']) ) {
			foreach( $onlineList['data'] as $k => $v ){
				if( strcmp($v['ip'], $term) == 0 ) {
					$userList[$v['accountName']] = $v;
					$userList[$v['accountName']]['online'] = 1;
					$onlineListStr .= $v['roleName'].",";
					$onlineCount ++ ;
				}
			}

	    } else {
	    	$msg[] = $onlineList['errorMsg'];
	    }
		
		$offlineCount = 0;
		$sql = "select uuid, account_name as accountName, role_name as roleName, max(level) as level, max(mtime) as mtime from t_log_logout where ip='{$term}' group by uuid";
		$offlineList = GFetchRowSet($sql);
		if( !empty($offlineList) ) {
			foreach($offlineList as $k => $v) {
				if( array_key_exists($v['account_name'], $userList ) ) {
					continue;
				} 
				$userList[$v['account_name']] = $v;
				$offlineCount ++;
//				$userList[$v['account_name']]['online'] = 0;
			}
		}
		
		$smarty->assign('term', $term);
		$smarty->assign('roleName', $role);
		if(!empty($userList))
		{ 
//			addTotalPay($userList);
//			addOnlineStatus($userList); 
			$smarty->assign("userList",$userList);
			$smarty->assign("onlineListStr",rtrim($onlineListStr, ',') );
			$smarty->assign("onlineCount",$onlineCount);
			$smarty->assign("offlineCount",$offlineCount);
			$smarty->assign("allCount",$onlineCount+$offlineCount);
		}else{
			$msg[] = '此IP无用户';
		}
	}
	
}

if( isset($_POST['loadList']) && $_POST['loadList'] == 1 ) {
	//向入口API请求
	$ac = 'get';
	$timestamp = time();
	$key = urlencode(md5($timestamp.ADMIN_GAME_AUTH_KEY));
	
	$paramStr = "timestamp={$timestamp}&key={$key}&action={$ac}";
	
	$result = json_decode(curlPost($apiUrl, $paramStr), true);
	
	if($result['result'] == 1 && !empty($result['data']) ){
		foreach($result['data'] as $ac => $v ) {
			
			$roleListStr = "";
			$getRoleListSql = "select ip,role_name from t_log_login where ip='{$v['ip']}' group by role_name ";
			$roleListArr = GFetchRowSet($getRoleListSql) ;
			if(!empty($roleListArr)) {
				foreach ($roleListArr as $r ) {
					$roleListStr .= $r['role_name'].", ";
				}
			}
			$roleListStr = rtrim($roleListStr, ',');
			
        	//写入数据库
	        $data['ip'] = $v['ip'];
	        $data['role_name_list'] = $roleListStr;
	        $data['ban_time'] = time();
	        $data['free_time'] = $v['freeTime'];
	        $data['ban_reason'] = $v['reason'];
//	        $data['status'] = 1;
	        if( $data['free_time'] - time() < 0 ) {
		    	$data['status'] = 0;
		    } else {
		    	$data['status'] = 1;
		    }
	        $data['op_user'] = $auth->username();
	        $sql = makeInsertSqlFromArray($data, T_BAN_IP,'replace');
	        GQuery($sql);
        	
		}
		
        $msg = $lang->verify->opSuc;
        //写日志
        $log = new AdminLogClass();
        $log->Log(AdminLogClass::TYPE_BAN_IP,"从服务器同步禁封IP列表",'','','','');

	} else{
        $msg = $result['errorMsg'];
    }
}

$record = isset($_POST['record']) ? intval($_POST['record']) : LIST_PER_PAGE_RECORDS;
$countResult = 0;//总记录
$pageno = getUrlParam('page');//设置初始页
$startNum = ($pageno - 1) * $record; //每页开始位置
$keywordlist	= getBanIpList($where,$startNum,$record,$countResult);

if(isset ($_POST) && count($keywordlist)>0) {
    $now = time();
    foreach ($keywordlist as &$row) {
        if($row['free_time'] <= $now){
            $sqlUpdate = "update ".T_BAN_IP." set status = 0 where id = {$row['id']} and status = 1 ";
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
//$smarty->assign("account",$_POST['account']);
//$smarty->assign("role_name",$_POST['rolename']);
$smarty->assign("lang", $lang);
$smarty->assign("viewData", $viewData);
$smarty->assign("banReason", getReason());
$smarty->assign("banTime", getBanTime());
$smarty->assign("pageno",$pageno);
$smarty->assign("pagelist",$pagelist);
$smarty->assign("record",$record);
$smarty->assign("count_result",$countResult);
$smarty->assign("page_count",$pageCount);
//$smarty->assign("role_name_search",$roleNameSearch);
//$smarty->assign("account_name_search",$accountNameSearch);
$smarty->assign("keywordlist",$keywordlist);
$smarty->display("module/msg/ban_ip.tpl");

function getBanIpList($where,$startNum,$record,& $counts){
    $sql = "select * from ".T_BAN_IP." where 1 {$where} order by free_time desc limit {$startNum},{$record}";
    $rs = GFetchRowSet($sql);

    $sqlCount = "select count(*) as counts FROM ".T_BAN_IP." where 1 {$where} ";
    $counts = GFetchRowOne($sqlCount);
    $counts = $counts['counts'];
    return $rs;
}
