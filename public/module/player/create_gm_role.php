<?php
/**
 * create_gm_role.php
 * 创建GM角色
 * 注意，请勿滥用本功能。
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';
include_once SYSDIR_ADMIN_DICT.'/dict.php';
//include_once SYSDIR_ADMIN_CLASS.'/user_class.php';
include_once SYSDIR_ADMIN_CLASS."/admin_group.class.php";

$dictCreateRoleErrorMsg = array(
	1 => '创建帐号成功',
	2 => '传入参数错误',
	3 => '角色名字长度不合法',
	4 => '角色名含有非法字符',
	5 => '角色名已存在',
	7 => '账号已有角色存在',
	8 => '性别非法',
	9 => '职业非法',
	10 => 'gm权限非法',
);

$action = SS($_POST['action']);

// 创建GM账号
if ($action == 'create') 
{
	$roleName = SS(trim($_POST['rolename']));
	if (empty($roleName)) {
		$msg = $lang->create->noNull;
    }

//	if(substr($roleName,0,2)!='GM' && $msg==''){
	if($msg != ''){
		$msg = $lang->create->pre;
	} else {
		$value = getRoleName($roleName);
		if ( $value == 1 ) {
			$msg = $lang->create->created;
		}
	}
	
	$sex = SS($_POST['sex']);
	$job = SS($_POST['job']);
	$gm = SS($_POST['gm']);

	if($msg == '') {
		$method = 'createrole';
		$params = array(
			'accountName' => "GM-".$roleName,
			'roleName' => $roleName,
		    'job' => $job,
			'sex' => $sex,
			'ip' => GetIP(),
			'gm' => $gm,
			'pf' => '',
		); 

		$view = interfaceRequest($method,$params);

		if($view['result'] == 1) {
			$msg = $lang->create->success;
			$data = array(
				'mtime' => time(),
				'account_name' => "GM-".$roleName,
				'role_name' => $roleName,
			    'job' => $job,
				'sex' => $sex,
				'ip' => GetIP(),
				'gm' => $gm,
				'add_person' => $auth->username(),
			);
			$sql = makeInsertSqlFromArray($data, T_CREATE_GM_ROLE );
			GQuery($sql);

			$log = new AdminLogClass();
			$log->Log( AdminLogClass::TYPE_CREATE_GM_ROLE, $lang->create->createGmRole . $roleName, 0, '', 0, $roleName); //第一个变量为帐号名, 帐号名跟角色名一样
		}
		else {
			$msg = $lang->create->failed . ": " . $dictCreateRoleErrorMsg[$view['result']];
		}
	}
//	echo "<font color=red>".$msg."</font>";
}

$row = getRoleName();

$smarty->assign('msg',$msg);
$smarty->assign('lang',$lang);
$smarty->assign('row',$row);
$smarty->assign('dictJobs',$dictJobs);
$smarty->display("module/player/create_gm_role.tpl");
exit;

function getRoleName($roleName=''){
	if(!empty($roleName)) {
		$sql = " select * from  ".T_CREATE_GM_ROLE." where `role_name`='$roleName' ";
		$name = GFetchRowOne($sql);
		if($name['role_name']) {
			$value = 1;
		} else {
			$value = 0;
		}
		return $value;
	} else {
		$sqlAll = " select * from  ".T_CREATE_GM_ROLE." ";
		$row = GFetchRowSet($sqlAll);
		return $row;	
	}
}

