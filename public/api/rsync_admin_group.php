<?php
/**
 * 同步后台用户组
 */

include_once('../../protected/config/config.php');
include_once('../../protected/include/global_not_auth.php');

$timestamp = $_POST['timestamp'];
$key = $_POST['key']; 
$action = $_POST['action']; 
$authKey = md5($timestamp.ADMIN_GAME_AUTH_KEY);

if ($key != $authKey) {
	dieJsonMsg(2,'同步数据出错:验证不通过!');
}
if (abs($timestamp-time()) > 60*5 ) { //超过5分钟,则超时
	dieJsonMsg(3,'同步数据超时!');
}


$jsonBanList = stripslashes($_POST['jsonBanList']);

$arrBanList = json_decode($jsonBanList,true);
if (!is_array($arrBanList)) {
	dieJsonMsg(4,'同步数据出错:数据格式不正确!');
}
$succ = true;
if($action == 'sync') {
//	print_r($arrBanList);
	foreach($arrBanList as $v) {
		$sql = makeDuplicateInsertSqlFromArray($v,"t_admin_group");
//		echo $sql;
		if(IQuery($sql)) {
			$msgStr .= "用户组【{$v['name']}(id={$v['id']})】同步成功!\n";
		} else {
			$msgStr .= "用户组【{$v['name']}(id={$v['id']})】同步失败!\n";
			$succ = false;
		}
	}
} else {
	dieJsonMsg(6,"无效参数：action={$action}!");
} 


$datetime = date('Y-m-d H:i:s');

if (!$succ) {
	dieJsonMsg(5,$msgStr);
}
dieJsonMsg(1,'OK');//成功