<?php 
/**
 * @abstract 服务器配置数据的增删改查
 */

// 导入配置文件
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';

global $lang;

$data['id'] = SS($_POST['id']);
$data['name'] = SS($_POST['name']);
//$data['ver'] = SS($_POST['ver']);
$data['url'] = SS(htmlspecialchars($_POST['url']));
$data['ip'] = SS($_POST['ip']);
$data['port'] = SS($_POST['port']);
$data['dbuser'] = SS($_POST['dbuser']);
$data['dbpwd'] = SS($_POST['dbpwd']);
$data['dbname'] = SS($_POST['dbname']);
$data['md5'] = SS($_POST['md5']);
$data['onlinedate'] = SS($_POST['onlinedate']);
$data['iscombine'] = SS($_POST['iscombine']);
$data['combinedate'] = SS($_POST['combinedate']);
$data['available'] = SS($_POST['available']);
$data['entranceUrl'] = rtrim(SS($_POST['entranceUrl']), "/")."/";
$action = SS($_GET['action']);

switch ($action) {
	case 'add':
	if (0 <= $data['id']){
		$sql = getInsertSQL($data, T_SERVER_CONFIG);
		IQuery($sql);
		$data['id'] = (10 > $data['id']) ? "0".$data['id'] : $data['id'];
		$pathLog = SYSDIR_GAME_LOG. "/" . $data['id'];
		if(!is_dir($pathLog)){
			mkdir($pathLog, 0777, 1);
		}
		$pathLogOK = SYSDIR_GAME_LOG_OK. "/" . $data['id'];
		if(!is_dir($pathLogOK)){
			mkdir($pathLogOK, 0777, 1);
		}
		$pathLogError = SYSDIR_GAME_LOG_ERROR. "/" . $data['id'];
		if(!is_dir($pathLogError)){
			mkdir($pathLogError, 0777, 1);
		}
		$pathCvs = SYSDIR_GAME_ETL_CSV. "/" . $data['id'];
		if(!is_dir($pathCvs)){
			mkdir($pathCvs, 0777, 1);
		}
		//echo json_encode(array("result" => 1));
	}
	//exit();
	break;
	
	case 'update':
	if (0 <= $data['id']) {
		if(empty($data['dbpwd'])) {
			unset($data['dbpwd']);
			$sql = getUpdateSQL($data, T_SERVER_CONFIG);
		} else {
			$sql = getUpdateSQL($data, T_SERVER_CONFIG);
		}
		IQuery($sql);
		echo json_encode(array("result" => 1));
	}
	exit();
	break;
	
	case 'delete':	
	$sql = "DELETE FROM t_server_config WHERE id='{$data['id']}'";
	IQuery($sql);
	echo json_encode(array("result" => 1));
	exit();
	break;

	default:
	break;
}

$serverList = getServerList();
arsort($serverList);

$smarty -> assign('lang', $lang);
$smarty -> assign('serverList', $serverList);
$smarty -> assign('action', $action);
$smarty -> display("module/system/server_config.tpl");