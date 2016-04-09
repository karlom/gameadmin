<?php
/**
 * 消息广播列表
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';

$action = trim($_REQUEST['action']);
if(empty($action)){
	$action='list';
}

if ($action == 'add') {
    $type = 2;
    $send_type = 0;
    $data = array(
    	'action' => $action,
    	'type' => $type,
    	'send_type' => $send_type,
    );
	$smarty->assign ($data);
	$smarty->display ( "module/msg/broadcast_message_edit.tpl" );
	exit();
} else if ($action == 'show' || $action == 'edit') {
	$id = trim($_GET['id']);
	$sql = "select * from ".T_MESSAGE_BROADCAST2." where id={$id}";
	$result = GFetchRowOne($sql);
	if($result){
	    $result['start_date'] = date("Y-m-d", $result['begindate']);
	    $result['end_date'] = date("Y-m-d", $result['enddate']);
	    $result['start_time'] = $result['begintime'];
	    $result['end_time'] = $result['endtime'];
        $result['content'] = stripslashes($result['content']);
    	$smarty->assign($result);
    	$smarty->assign("action", $action);
    	$smarty->display ( "module/msg/broadcast_message_edit.tpl" );
    	exit();
	}else{
	    $errorMsg[] = "记录不存在";
	}
} else if($action == 'del'){
	$ids = trim($_GET['ids']);
	$idArr = explode(",", $ids);
	if($idArr){
	    foreach($idArr as $key => $value){//删除消息
    	    $api = "configbroadcast";
    	    $params = array(
    	        "id" => $value,
    	        "action" => 3,
    	    );
    	    $httpResult = @interfaceRequest($api, $params);
    	    if(1 == $httpResult['result']){
            	$sql = "delete from ".T_MESSAGE_BROADCAST2." where id={$value}";
            	GQuery($sql);
    	    }else{
    	        $errorMsg[] = "服务器删除ID为{$value}的消息失败:{$httpResult[errorMsg]}";
    	    }
	    }
	}
}else if($action == 'save'){
	$id = intval($_POST['id']);
	$arr = array(
	    "type" => intval($_POST['type']),
	    "send_type" => intval($_POST['send_type']),
	    "beginDate" => strtotime($_POST['start_date']),
	    "endDate" => strtotime($_POST['end_date']." 23:59:59"),
	    "beginTime" => SS($_POST['start_time']),
	    "endTime" => SS($_POST['end_time']),
	    "interval" => intval($_POST['interval']),
	    "content" => SS($_POST['content']),
	    "mtime" => time(),
	    "admin_name" => $auth->username(),
	);
	if(0 < $id){
	    $arr['id'] = $id;
	    $sql = makeUpdateSqlFromArray($arr, T_MESSAGE_BROADCAST2);
	    $httpAction = 2;//修改
	}else{
	    $sql = makeInsertSqlFromArray($arr, T_MESSAGE_BROADCAST2);
	    $httpAction = 1;//新增
	}
	if((1 == $httpAction && $result = GQuery($sql, true)) || (2 == $httpAction && GQuery($sql))) {
	    $errorMsg[] = "保存消息成功";
	}else{
	    $errorMsg[] = "保存消息失败";
	}

	if(0 == $arr['send_type']){//发送即时消息
	    $api = "broadcast";
	    $params = array(
	        "type" => $arr['type'],
	        "msg" => stripslashes($arr['content']),
	    );
	    $httpResult = @interfaceRequest($api, $params);
	    if(1 == $httpResult['result']){
	        $errorMsg[] = "发布消息成功";
	    }else{
	        $errorMsg[] = "发布消息失败";
	    }
	}else{
    	if(1 == $httpAction){
    	    $arr['id'] = $result;
    	}
	    $api = "configbroadcast";
	    $params = array(
	        "id" => $arr['id'],
	        "action" => $httpAction,
	        "type" => $arr['type'],
	        "beginDate" => date("Ymd", $arr['beginDate']),
	        "endDate" => date("Ymd", $arr['endDate']),
	        "beginTime" => strtotime($arr['beginTime']) - strtotime(date("Y-m-d")),
	        "endTime" => strtotime($arr['endTime']) - strtotime(date("Y-m-d")),
	        "interval" => $arr['interval'],
	        "content" => stripslashes($arr['content']),
	    );
	    
	    $httpResult = @interfaceRequest($api, $params);
	    if(1 == $httpResult['result']){
	        $errorMsg[] = "同步消息到服务器成功";
	    }else{
	        $errorMsg[] = "同步消息到服务器失败:{$httpResult[errorMsg]}";
	    }
	}
}else if("copy" == $action){//同步到管理后台的其它服
    $msgIds = SS($_GET['msg_ids']);
    $serverIds = explode(",", SS($_GET['server_ids']));
    $sql = "select * from ".T_MESSAGE_BROADCAST2." where id in ({$msgIds})";
    $result = GFetchRowSet($sql);
    foreach($serverIds as $serverId){
        if(isset($serverList[$serverId]) && $serverList[$serverId]['available']){
            $insertSql = "";
            foreach($result as $key => $value){
                //修改开始和结束日期
                $value['enddate'] = strtotime(date("Y-m-d", $value['enddate'] + strtotime($serverList[$serverId]['onlinedate']) - $value['begindate']));//结束时间对应加上差值
                $value['begindate'] = strtotime($serverList[$serverId]['onlinedate']);//开始时间等于开服时间
                unset($value['id']);
                $value['admin_name'] = $auth->username();//替换操作人
                $value['mtime'] = NOW_TIMESTAMP;
                $insertSql = makeInsertSqlFromArray($value, $serverList[$serverId]['dbname'].".".T_MESSAGE_BROADCAST2);
                GQuery($insertSql);
            }
        }
    }
    $errorMsg[] = "消息同步成功";
}else if("sync" == $action){//一键将消息同步到游戏服务器
    //把send_type=1按日期时间发布的消息同步到游戏服务器
    $msgIds = SS($_GET['msg_ids']);
    $serverIds = explode(",", SS($_GET['server_ids']));
    $sql = "select * from ".T_MESSAGE_BROADCAST2." where id in ({$msgIds}) and send_type=1";
    $result = GFetchRowSet($sql);
    foreach($result as $key => $value){
	    $api = "configbroadcast";
	    $content = $value['content'];
	    $params = array(
	        "id" => $value['id'],
	        "action" => 1,
	        "type" => $value['type'],
	        "beginDate" => date("Ymd", $value['begindate']),
	        "endDate" => date("Ymd", $value['enddate']),
	        "beginTime" => strtotime($value['begintime']) - strtotime(date("Y-m-d")),
	        "endTime" => strtotime($value['endtime']) - strtotime(date("Y-m-d")),
	        "interval" => $value['interval'],
	        "content" => $content,
	    );
	    $httpResult = @interfaceRequest($api, $params);
	    if(1 == $httpResult['result']){
	        $errorMsg[] = "同步消息到服务器成功";
	    }else{
	        $errorMsg[] = "同步消息到服务器失败:{$httpResult['errorMsg']}";
	    }
    }
}
$sql = "select * from ".T_MESSAGE_BROADCAST2." order by id desc";
$result = GFetchRowSet($sql);
if($result){
    foreach($result as $key => &$value){
        $value['content'] = stripslashes($value['content']);
        $value['begindate'] = date("Y-m-d", $value['begindate'])." ".$value['begintime'];
        $value['enddate'] = date("Y-m-d", $value['enddate'])." ".$value['endtime'];
    }
}
$smarty->assign (array('dataResultSet' => $result));
$smarty->assign('serverList', $serverList);
$smarty->assign('errorMsg',$errorMsg);
$smarty->display ( "module/msg/broadcast_message_list.tpl" );

