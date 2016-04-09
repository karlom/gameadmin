<?php 
/**
 * @abstract 游戏入口参数配置
 */

// 导入配置文件
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';

global $lang;

$action = SS($_POST['action']);

if("submit" == $action){//更新入口参数
	$interface = $_POST['interface'];
	if($interface){
		foreach($interface as $key => $value){
			$data[$key]['id'] = $key;
			$data[$key]['interface'] = $value;
			$data[$key]['isshow'] = 0;
		}
	}
	$ver = $_POST['ver'];
	if($ver){
		foreach($ver as $key => $value){
			$data[$key]['ver'] = $value;
		}
	}
	$isShow = $_POST['isshow'];

	if($isShow){
		foreach($isShow as $key => $value){
			$data[$key]['isshow'] = $value == 'on' ? 1: 0;
		}
	}
	if($data){
		foreach($data as $key => $value){
			$sql = makeDuplicateInsertSqlFromArray($value, T_MENU_CONFIG);
//			print_r($sql . '<br />');
			IQuery($sql);
		}
	}
}

$sql = "select * from ".T_MENU_CONFIG;
$result = IFetchRowSet($sql);

if($result){
	foreach($result as $key => $value){
		$id = $value['id'];
		if(array_key_exists($id, $ADMIN_PAGE_CONFIG)){
			$ADMIN_PAGE_CONFIG[$id]['interface'] = $value['interface'];
			$ADMIN_PAGE_CONFIG[$id]['ver'] = $value['ver'];
			$ADMIN_PAGE_CONFIG[$id]['isshow'] = $value['isshow'];
		}
	}
}

$smarty -> assign('lang', $lang);
$smarty -> assign('action', $action);
$smarty -> assign('result', $ADMIN_PAGE_CONFIG);
$smarty -> assign('msg', $msg);
$smarty -> display("module/system/menu_config.tpl");