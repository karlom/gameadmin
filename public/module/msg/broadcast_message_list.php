<?php
/**
 * 消息广播列表
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';

$dictBroadcast = array(
	'1' => '全服广播',
	'2' => '突出高亮信息',
	'4' => '浮动提示',
	'8' => '鼠标',
	'16' => '系统聊天频道',
	'32' => '活动聊天频道',
	'16384' => '全频道',
);

$action = trim($_REQUEST['action']);
if(empty($action)){
	$action='list';
}

if ($action == 'add') {
    $type = 16;
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
	$sql = "select * from ".T_MESSAGE_BROADCAST." where id={$id}";
	$result = GFetchRowOne($sql);
	if($result){
	    $result['start_date'] = date("Y-m-d", $result['begindate']);
	    $result['end_date'] = date("Y-m-d", $result['enddate']);
	    $result['start_date_time'] = date("H:i:s", $result['begindate']);
	    $result['end_date_time'] = date("H:i:s", $result['enddate']);
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
            	$getDtSql = "select * from ".T_MESSAGE_BROADCAST." where id={$value}";
            	$rs = GFetchRowOne($getDtSql);
            	//写日志
            	
            	$time = $rs['type']==1 ?"开始时间={$rs['beginDate']},结束时间={$rs['endDate']},":"";
            	$detail = "id={$rs['id']},消息位置={$rs['type']},发送类型={$rs['send_type']},{$time} 内容={$rs['content']}";
            	$log = new AdminLogClass();
            	$log->Log(AdminLogClass::TYPE_MSG_BROADCAST_DELETE,$detail,'','','','');
            	
            	$sql = "delete from ".T_MESSAGE_BROADCAST." where id={$value}";
            	GQuery($sql);
    	    }else{
    	        $errorMsg[] = "服务器删除ID为{$value}的消息失败:{$httpResult[errorMsg]}";
    	    }
	    }
	}
}else if($action == 'save'){
	$id = intval($_POST['id']);
	$typeArr = $_POST['type'];
	foreach($typeArr as $k => $v ){
//		$type += pow(2,$v);
		$type += 1 << $v;
	}
	$arr = array(
	    "type" => intval($type),
	    "send_type" => intval($_POST['send_type']),
	    "beginDate" => strtotime($_POST['start_date'] ." ". $_POST['start_date_time']),
	    "endDate" => strtotime($_POST['end_date']." ".$_POST['end_date_time']),
	    "beginTime" => SS($_POST['start_time']),
	    "endTime" => SS($_POST['end_time']),
	    "interval" => intval($_POST['interval']),
	    "content" => removeHtmlLable( SS($_POST['content']), "TEXTFORMAT"),
	    "mtime" => time(),
	    "admin_name" => $auth->username(),
	);
	if(0 < $id){
	    $arr['id'] = $id;
	    $sql = makeUpdateSqlFromArray($arr, T_MESSAGE_BROADCAST);
	    $httpAction = 2;//修改
	}else{
	    $sql = makeInsertSqlFromArray($arr, T_MESSAGE_BROADCAST);
	    $httpAction = 1;//新增
	}
	if((1 == $httpAction && $result = GQuery($sql, true)) || (2 == $httpAction && GQuery($sql))) {
		if( 1 == $httpAction ){
			$detail = "消息位置={$arr['type']},发送类型={$arr['send_type']},开始时间={$arr['beginDate']},结束时间={$arr['endDate']},内容={$arr['content']}";
			$log = new AdminLogClass();
			$log->Log(AdminLogClass::TYPE_MSG_BROADCAST_CREATE,$detail,'','','','',$arr['admin_name']);
		}
		if ( 2 == $httpAction ){
			$detail = "id={$id},消息位置={$arr['type']},发送类型={$arr['send_type']},开始时间={$arr['beginDate']},结束时间={$arr['endDate']},内容={$arr['content']}";
			$log = new AdminLogClass();
			$log->Log(AdminLogClass::TYPE_MSG_BROADCAST_MODIFY,$detail,'','','','');
		}
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
			$detail = "消息位置={$params['type']},发送类型={$arr['send_type']},内容={$params['content']}";
			$log = new AdminLogClass();
			$log->Log(AdminLogClass::TYPE_MSG_BROADCAST_CREATE,'','','','','','');
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
	        "beginDate" => $arr['beginDate'],
	        "endDate" =>  $arr['endDate'],
	        "beginTime" => strtotime($arr['beginTime']) - strtotime(date("Y-m-d")),
	        "endTime" => strtotime($arr['endTime']) - strtotime(date("Y-m-d")),
	        "interval" => $arr['interval'],
	        "content" => stripslashes($arr['content']),
	    );
	    
	    $httpResult = @interfaceRequest($api, $params);
	    if(1 == $httpResult['result']){
			$detail = "id={$id},消息位置={$arr['type']},发送类型={$arr['send_type']},开始时间={$arr['beginDate']},结束时间={$arr['endDate']},内容={$arr['content']}";
			$log = new AdminLogClass();
			$log->Log(AdminLogClass::TYPE_MSG_BROADCAST_SYNC,$detail,'','','','');
	        $errorMsg[] = "同步消息到服务器成功";
	    }else{
	        $errorMsg[] = "同步消息到服务器失败:{$httpResult[errorMsg]}";
	    }
	}
}else if("copy" == $action){//同步到管理后台的其它服
    $msgIds = SS($_GET['msg_ids']);
    $serverIds = explode(",", SS($_GET['server_ids']));
    $sql = "select * from ".T_MESSAGE_BROADCAST." where id in ({$msgIds})";
    $result = GFetchRowSet($sql);
    foreach($serverIds as $serverId){
        if(isset($serverList[$serverId]) && $serverList[$serverId]['available']){
            $insertSql = "";
            foreach($result as $key => $value){
                //修改开始和结束日期
//                $value['enddate'] = strtotime(date("Y-m-d", strtotime($value['enddate']) + strtotime($serverList[$serverId]['onlinedate']) - strtotime($value['begindate'])));//结束时间对应加上差值
//                $value['begindate'] = strtotime($serverList[$serverId]['onlinedate']);//开始时间等于开服时间

                unset($value['id']);
                $value['admin_name'] = $auth->username();//替换操作人
                $value['mtime'] = NOW_TIMESTAMP;
                $insertSql = makeInsertSqlFromArray($value, $serverList[$serverId]['dbname'].".".T_MESSAGE_BROADCAST);
                GQuery($insertSql);  
            }
        }
    }
	$detail = "id={$msgIds},服务器列表={$_GET['server_ids']}";
	$log = new AdminLogClass();
	$log->Log(AdminLogClass::TYPE_MSG_BROADCAST_SYNC,$detail,'','','','');  
    $errorMsg[] = "消息同步成功";
}else if("sync" == $action){//一键将消息同步到游戏服务器
    //把send_type=1按日期时间发布的消息同步到游戏服务器
    $msgIds = SS($_GET['msg_ids']);
    $serverIds = explode(",", SS($_GET['server_ids']));
    $sql = "select * from ".T_MESSAGE_BROADCAST." where id in ({$msgIds}) and send_type=1";
    $result = GFetchRowSet($sql);
    foreach($result as $key => $value){
	    $api = "configbroadcast";
	    $content = $value['content'];
	    $params = array(
	        "id" => $value['id'],
	        "action" => 1,
	        "type" => $value['type'],
	        "beginDate" => $value['begindate'],
	        "endDate" => $value['enddate'],
	        "beginTime" => strtotime($value['begintime']) - strtotime(date("Y-m-d")),
	        "endTime" => strtotime($value['endtime']) - strtotime(date("Y-m-d")),
	        "interval" => $value['interval'],
	        "content" => $content,
	    );
	    $httpResult = @interfaceRequest($api, $params);
	    
	    if(1 == $httpResult['result']){
	    	$log = new AdminLogClass();
	    	$log->Log(AdminLogClass::TYPE_MSG_BROADCAST_SYNC,"id=({$msgIds})",'','','','');
	        $errorMsg[] = "同步消息到服务器成功";
	    }else{
	        $errorMsg[] = "同步消息到服务器失败:{$httpResult['errorMsg']}";
	    }
    }
}
$sql = "select * from ".T_MESSAGE_BROADCAST." order by id desc";
$result = GFetchRowSet($sql);
if($result){
    foreach($result as $key => &$value){
//        $value['content'] = stripslashes($value['content']);
//        $value['begindate'] = date("Y-m-d", $value['begindate'])." ".$value['begintime'];
//        $value['enddate'] = date("Y-m-d", $value['enddate'])." ".$value['endtime'];
        $value['begindate'] = date("Y-m-d H:i:s", $value['begindate']);
        $value['enddate'] = date("Y-m-d H:i:s", $value['enddate']);
    }
}
$smarty->assign (array('dataResultSet' => $result));
$smarty->assign('serverList', $serverList);
$smarty->assign('errorMsg',$errorMsg);
$smarty->display ( "module/msg/broadcast_message_list.tpl" );

