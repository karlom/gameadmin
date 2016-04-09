<?php
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';
include_once SYSDIR_ADMIN_CLASS."/admin_group.class.php";

$action = SS($_REQUEST['action']);
//显示添加，编辑界面
if($action == 'add' || $action == 'modify')
{
	if (isset($_GET['id']))
	{
		$groupid = intval($_GET['id']);
		$groups = AdminGroupClass::enum();
		$group = $groups[$groupid];
		$smarty->assign("group", $group);
	}

	global $ADMIN_PAGE_CONFIG;

	$page_list = array();
	foreach($ADMIN_PAGE_CONFIG as $k=>$v)
	{
		if(!$auth->assertModuleIDAccess($k, false)) {
			continue;
		}
		if (isset($v['v']))
		{
			if ($v['v'] == 'not')     //未开放的功能
					continue;
			if ($v['v'] == 'dev')     //只在 非实际运营服的状态下有效。
				if ( SERVER_IS_REAL_RUN != false)
					continue;
			if ($v['v'] == 'debug')     //只有debug有开启时才能使用
				if ( ODINXU_DEBUG != true)
					continue;
		}

		$v['id'] = $k;
		$v['access'] = $group['rule_arr'][ADMIN_ACCESS_PAGE][$k]?true:false;

		$page_list[ $v['class'] ]['func'][] = $v;
	}
	$i = 0;
	foreach($page_list as $k=>$v)
	{
		$page_list[$k]['index'] = ++$i;
	}
	unset($i);
//print_r($ADMIN_PAGE_CONFIG);
	$smarty->assign("page_list", $page_list);
	$smarty->assign("page_config", $ADMIN_PAGE_CONFIG);
	$smarty->assign("action", $action);
	$smarty->display("module/system/admin_group_edit.tpl");
	exit;
}

//处理添加用户提交的数据
if($action == 'add_submit')
{
	if (!empty($_POST['name'])) {
		$group_name = SS(trim($_POST['name']));
	}
	else {
		die('没有输入组名');
	}
	$comment = SS(trim($_POST['comment']));
	if (empty($comment)){
		die('描述说明不能为空');
	}
	$access_arr = array();
	foreach($_REQUEST as $k=>$v){
		if (substr($k,0,3) == 'cb_')
		{
			$_p = intval(substr($k,3));
			if (!isset($access_arr[$_p])){
				$access_arr[$_p] = ($v == 'on');
			} else {
				die('参数重复');
			}
		}
	}
	if($groupid = AdminGroupClass::create($group_name, $comment)) {
		$group_obj = new AdminGroupClass($groupid);
		$group_obj->import(ADMIN_ACCESS_PAGE, $access_arr);
		$groupdata = $group_obj->groupdata();

		$log = new AdminLogClass();
		$log->Log(AdminLogClass::TYPE_SYS_CREATE_ADMIN_GROUP, $groupdata['rule'], 0, '', 0, $group_name);
		echo "添加 <font color=red>{$group_name}</font> 成功";
	}
}

//处理修改用户提交的数据
if($action == 'modify_submit')
{
	$groupid = intval($_GET['id']);
	$enum = AdminGroupClass::enum();
	$group = $enum[$groupid];

	if (!$group = $enum[$groupid]) {
		die('参数错误');
	}
	$group_name = $group['name'];
	$group_obj = new AdminGroupClass($groupid);
	if (!empty($_POST['comment'])) {
		$comment = SS($_POST['comment']);
		$group_obj->setComment($comment);
	}
	$access_arr = array();
	foreach($_REQUEST as $k=>$v) {
		if (substr($k,0,3) == 'cb_')
		{
			$_p = intval(substr($k,3));
			if (!isset($access_arr[$_p])) {
				$access_arr[$_p] = ($v == 'on');
			} else {
				die('参数重复');
			}
		}
	}
	$group_obj->import(ADMIN_ACCESS_PAGE, $access_arr);
	$groupdata = $group_obj->groupdata();
	$log = new AdminLogClass();
	$log->Log(AdminLogClass::TYPE_SYS_MODIFY_ADMIN_GROUP, $groupdata['rule'], 0, '', 0, $group_name);//日志：修改权限
	echo '修改成功';
}

if($action == 'del_submit')
{
	$groupid = intval($_GET['id']);
	AdminGroupClass::delete($groupid);
	$log = new AdminLogClass();
	$log->Log(AdminLogClass::TYPE_SYS_DELETE_ADMIN_GROUP, $groupdata['rule'], 0, '', 0, $group_name);//日志：修改权限
}


$adminList = get_admin_list('all');
$groupsData = AdminGroupClass::getGroupData();
//print_r($groupsData);

if(isPost() && isset($_POST['selectItem']) && isset($_POST['adminList']) ){

	$list = $_POST['adminList'];
	$users = $_POST['selectItem'];
	
	if(!empty($list)){
		foreach($list as $v){
			$syncTolist[$v] = $adminList[$v];
		}
	}
	if(!empty($users)){
		foreach($users as $v){
			$syncUsers[$v] = $groupsData[$v];
			$nameStr .= "【".$groupsData[$v]['name']."】,";
		}
		$nameStr = rtrim($nameStr,',');
	}
	
	if($syncTolist && $syncUsers) {
		foreach($syncTolist as $v){
			
	    	//向后台API请求
	    	$timestamp = time();
	    	$key = urlencode(md5($timestamp.ADMIN_GAME_AUTH_KEY));
	    	$jsonBanList = urlencode(decodeUnicode(json_encode($syncUsers)));
	    	
	    	$action = "sync";
	    	
	    	$paramStr = "timestamp={$timestamp}&key={$key}&action={$action}&jsonBanList={$jsonBanList}";
			$apiUrl = rtrim($v['url'], '/').'/api/rsync_admin_group.php';
			
			$resultJson = curlPost($apiUrl, $paramStr);
			
			$result = json_decode($resultJson, true);
			
			if($result['result'] == 1){
				$msg[] = "{$nameStr}成功同步到【{$v['name']}】.";
			} else {
				$msg[] = "{$nameStr}同步到【{$v['name']}】 出错！";
			}
//			var_dump($resultJson);
		}
	}
}

$groups = gen_groups(AdminGroupClass::enum());
$smarty->assign("groups", array_values($groups));
$smarty->assign("adminList", $adminList);
$smarty->assign("msg", $msg);
$smarty->display("module/system/admin_group_list.tpl");

exit();

function gen_groups($groups)
{
	global $auth;
	if(!is_array($groups))
		return array();
	$my_acess = array();
	foreach($groups as $gid => $gdata) {
		$rule_arr = $gdata['rule_arr'][ADMIN_ACCESS_PAGE];
		if($auth->assertRuleArrayAccess($rule_arr)) {
			$gdata['page_access_string'] = gen_page_access_string($rule_arr);
			$groups[$gid] = $gdata;
		} else {
			unset($groups[$gid]);
		}
	}
	return $groups;
}

function gen_page_access_string($access_array)
{
	global $ADMIN_PAGE_CONFIG;
	$str = "";
	if(is_array($access_array)) {
		foreach($access_array as $id => $access) {
			if($access) {
				$str .= $ADMIN_PAGE_CONFIG[$id]['name'] . ', ';
			}
		}
	}
	return $str;
}

function get_admin_list($all="") {
	if(!$all){
		$where = "where available=1";
	}
	$sql = "select * from t_admin_list {$where}";
	$list = IFetchRowSet($sql);
	
	$data = array();
	if(!empty($list)){
		foreach($list as $v ){
			$data[$v['id']] = $v;
		}
	}
	
	return $data;
}