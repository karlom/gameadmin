<?php
/**
 * create_guide_role.php
 * 创建引导员角色
 * 
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';
include_once SYSDIR_ADMIN_DICT.'/dict.php';
//include_once SYSDIR_ADMIN_CLASS.'/user_class.php';
include_once SYSDIR_ADMIN_CLASS."/admin_group.class.php";

//固定只能创建的角色名
$guideRoleArray = array(
	1 => '[官方]GM梦楹上仙（剑仙女）',
	2 => '[官方]GM春茗仙子（武尊女）',
	3 => '[官方]GM太白星君（灵修男）',
	4 => '[官方]GM云桂真君（灵修女）',
);

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

$guides = array(
	1 => array(
		'desc' => '[官方]GM梦楹上仙（剑仙女）',
		'roleName' => '[官方]GM梦楹上仙',
		'accountName' => '[官方]GM梦楹上仙',
		'job' => 3,
		'sex' => 2,
	),
	2 => array(
		'desc' => '[官方]GM春茗仙子（武尊女）',
		'roleName' => '[官方]GM春茗仙子',
		'accountName' => '[官方]GM春茗仙子',
		'job' => 1,
		'sex' => 2,
	),
	3 => array(
		'desc' => '[官方]GM太白星君（灵修男）',
		'roleName' => '[官方]GM太白星君',
		'accountName' => '[官方]GM太白星君',
		'job' => 2,
		'sex' => 1,
	),
	4 => array(
		'desc' => '[官方]GM云桂真君（灵修女）',
		'roleName' => '[官方]GM云桂真君',
		'accountName' => '[官方]GM云桂真君',
		'job' => 2,
		'sex' => 2,
	),
);

$action = SS($_POST['action']);

// 创建GM账号
if ($action == 'create') 
{
	$guide = SS(trim($_POST['guide']));
	if (empty($guide)) {
		$msg = $lang->create->noNull;
    }
    
    $accountName = $roleName = $guides[$guide]['roleName'];
    $sex = $guides[$guide]['sex'];
    $job = $guides[$guide]['job'];
    $gm = 100;	//引导员固定100

	$value = getRoleName($roleName);
	if ( $value == 1 ) {
		$msg = $lang->create->created;
	}

	if($msg == '') {
		$method = 'createrole';
		$params = array(
			'accountName' => $accountName,
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
				'account_name' => $accountName,
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
$smarty->assign('guideRole',$guideRoleArray);
$smarty->display("module/player/create_guide_role.tpl");
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
		$sqlAll = " select * from  ".T_CREATE_GM_ROLE." where gm=100 ";
		$row = GFetchRowSet($sqlAll);
		return $row;	
	}
}

