<?php 
/**
 * @abstract 服务器配置数据的增删改查
 */

// 导入配置文件
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';

global $lang;

$data['id'] = SS($_POST['id']);
$data['url'] = SS($_POST['urlname']);
$data['name'] = SS($_POST['adminname']);
$data['available'] = SS($_POST['available']);
$action = SS($_GET['action']);

switch ($action) {
  case 'add':
  $urlname = trim($_POST['urlname']);
  $adminname = trim($_POST['adminname']);
  $validUrlName = validUrlname($urlname);
  $validAdminname = validAdminname($adminname);
  if (true !== $validUrlName) {
	  die($validUrlName);
  }
  if (true !== $validAdminname) {
  	die($validAdminname);
  }
  if(!empty($_POST['available'])) {
  	$able_id = intval($_POST['available']);
  } else{
	  $able_id = null;
  }
  $sqlChkExist = "SELECT `id` FROM `".T_ADMIN_LIST."` WHERE `url`='{$urlname}' ";
  $rsChkExist = IFetchRowOne($sqlChkExist);
  if ($rsChkExist['id']) {
	  die("管理后台 {$urlname} 已经被使用");
  }
  $data = array();
  $data['url'] = $urlname;
  $data['name'] = $adminname;
  $data['available'] = SS($_POST['available']);
  $sql = DBMysqlClass::makeInsertSqlFromArray($data, T_ADMIN_LIST);
	IQuery($sql);
	break;
	
case 'update':
  if (0 < $data['id']) {
	$sql = getUpdateSQL($data, T_ADMIN_LIST);
	IQuery($sql);
	echo json_encode(array("result" => 1));
  }  
  exit();
  break;

case 'delete':	
	$sql = "DELETE FROM t_admin_list WHERE id='{$data['id']}'";
	IQuery($sql);
	echo json_encode(array("result" => 1));
	exit();
break;
default:
break;
}

$adminList = getAdminList();
arsort($adminList);

$smarty -> assign('lang', $lang);
$smarty -> assign('adminList', $adminList);
$smarty -> assign('action', $action);
$smarty -> display("module/system/admin_config.tpl");
