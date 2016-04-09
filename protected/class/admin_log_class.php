<?php
global $ADMIN_LOG_TYPE;

$ADMIN_LOG_TYPE = array(
 0 => '显示全部',

 1001 => '封禁帐号',
 1002 => '解封帐号',
 1003 => '封禁IP',
 1004 => '解封IP',
 1005 => '踢玩家下线',
 1006 => '玩家禁言',
 1007 => '玩家解除禁言',
 1008=>  '踢摊位下线',
 1009=>  '送回新手村',
 1010=>  '消除已解禁的禁言记录',
 1011=>  '消除过期已解禁的IP',
 1012=>  '同步IP封禁列表到游戏服',
 1013 => '踢全部玩家下线',

 1014 => '修改玩家闯开封铁塔次数',
 1015 => '修改玩家精力值',
 1016 => '修改玩家幸运值',
 1017 => '修改玩家连续登录天数',
 1018 => '修改玩家宗族贡献度',
 1019 => '修改玩家防沉迷状态',
 1020 => '防沉迷开关操作',
 1021 => '添加多倍经验设置',
 1022 => '删除多倍经验设置',
 1023 => '信息提示按钮获得仙石',
 1024 => '游戏开关操作',
 1025 => '赛马开关操作',
 1026 => '添加称号',
 1027 => '删除称号',
 1028 => '修改玩家进入银子副本次数',
 1029 => '修改玩家进入宠物副本次数',
 1030 => '修改登录公告',
 1031 => '开封铁塔开关',
 1032 => '修改已做悬壶济世任务次数',
 1033 => '修改已做采集草药任务次数',
 1034 => '修改已做狩猎任务次数',
 1035 => '修改已进入时装副本次数',
 1036 => '修改已戳背次数',
 1037 => '修改玩家数据',
 1038 => '修改招财进宝次数',
 1039 => '修改猎魂次数',
 1040 => '修改PK值',
 1041 => '修改竞技场可挑战次数',
 1042 => '修改玩家等级',
 1043 => '修改玩家仙石',

 2001 => '赠送道具',
 2002 => '赠送银两',
 2003 => '赠送仙石',
 2004 => '充值补单',
 2005 => '按玩家名批量发道具',
 2006 => '按条件批量发道具',
 2007 => '信息提示按钮获得仙石',
 2008 => '删除赠送道具申请记录',
 2009 => '删除赠送道具记录',

 3001 => '消息广播',
 3002 => '给玩家发信',
 3003 => '按玩家名批量发信',
 3004 => '按条件批量发信',
 3005 => '导入消息广播',
 3006 => '新增消息广播',
 3007 => '删除消息广播',
 3008 => '修改消息广播',
 3009 => '同步消息广播',
// 3008 => '导入boss群',
// 3009 => '新增boss群',
// 3010 => '删除boss群',

 4001 => '直接登录玩家帐号',
 4002 => '模拟平台登录帐号',
 4003 => '直接注册GM角色',
 4004 => '使用后台GM指令',
 4005 => '恢复玩家数据',

 9001 => '登录系统',
 9002 => '修改密码',
 9003 => '新设后台用户',
 9004 => '修改后台用户',
 9005 => '修改后台用户密码',
 9006 => '新增道具权限组',
 9007 => '修改道具权限组',
 9008 => '新建后台权限组',
 9009 => '修改后台权限组',
 9010 => '删除后台权限组',
);

//loadBaseCache('building');
//loadBaseCache('tech');
//loadBaseCache('items');

class AdminLogClass
{
	const TYPE_ALL		= 0;		//显示全部

	const TYPE_BAN_USER		= 1001;		//封禁帐号
	const TYPE_UNBAN_USER	= 1002;	//解封帐号
	const TYPE_BAN_IP		= 1003;		//封禁IP
	const TYPE_UNBAN_IP		= 1004;		//解封IP
	const SET_PLAYER_OFF_LINE	= 1005;	//踢玩家下线
	const TYPE_BAN_CHAT		= 1006;		//玩家禁言
	const TYPE_UNBAN_CHAT		= 1007;		//玩家解除禁言
	const TYPE_KICK_STALL	=1008; 		//踢摆摊
	const TYPE_SEND_RETURN_PEACE_VILLAGE	=1009; 		//送回新手村
	const TYPE_CLEAR_OVERDUE_BAN_CHAT	=1010; 		//消除已解禁的禁言记录
	const TYPE_CLEAR_OVERDUE_BAN_IP	=1011; 		//消除过期已解禁的IP
	const TYPE_REWRITE_BAN_IP	=1012; 		//刷新IP封禁列表缓存
	const SET_ALL_PLAYER_OFF_LINE	= 1013;	//踢所有玩家下线

	const SET_PLAYER_TOWER_TIMES	= 1014;	//修改玩家闯开封铁塔次数
	const SET_PLAYER_ENERGY	        = 1015;	//修改玩家精力值
	const SET_PLAYER_LUCKY      	= 1016;	//修改玩家幸运值
	const SET_PLAYER_LOGIN_DAYS	    = 1017;	//修改玩家连续登录天数
	const SET_PLAYER_FAMILY_CONTRIBUTION	= 1018;	//修改玩家宗族贡献度
	const SET_PLAYER_FCM	        = 1019;	//修改玩家防沉迷状态
    const SET_FCM_STATUS            = 1020;//防沉迷开关
    const SET_DOUBLE_EXP_ADD            = 1021;//添加多倍经验设置
	const SET_DOUBLE_EXP_DELETE     =1022;//删除多倍经验设置
    const SET_SERVER_STATUS     = 1024;//游戏开关操作
    const SET_RACE_STATUS       = 1025;//赛马开关操作
    const SET_TITLE            = 1026;//添加称号
    const DELETE_TITLE         = 1027;//删除称号
    const SET_PLAYER_SILVER_FB_TIMES = 1028;//修改玩家进入银子副本次数
    const SET_PLAYER_PET_FB_TIMES   = 1029;//修改玩家进入宠物副本次数
    const SET_NOTICE               = 1030;//修改登录公告
    const SET_TOWER_STATUS       = 1031;//开封铁塔开关
    const SET_PLAYER_HELP_TIMES       = 1032;//修改已做悬壶济世任务次数
    const SET_PLAYER_DRUG_TIMES       = 1033;//修改已做采集草药任务次数
    const SET_PLAYER_SHOOT_TIMES       = 1034;//修改已做狩猎任务次数
    const SET_PLAYER_FASHION_FB_TIMES       = 1035;//修改已进入时装副本次数
    const SET_PLAYER_SPA_TIMES       = 1036;//修改已戳背次数
    const SET_PLAYER_DATA       = 1037;//修改玩家数据
    const SET_PLAYER_ZCJB_TIMES       = 1038;//修改招财进宝次数
    const SET_PLAYER_WUHUN_TIMES       = 1039;//修改猎魂次数
    const SET_PLAYER_PK_VALUE       = 1040;//修改PK值
    const SET_PLAYER_JJC_TIMES       = 1041;//修改竞技场可挑战次数
    const SET_PLAYER_LEVEL       = 1042;//修改玩家等级
    const SET_PLAYER_GOLD       = 1043;//修改玩家仙石

	const TYPE_SEND_GOODS		= 2001;		//赠送道具
	const TYPE_SEND_SILVER		= 2002;		//赠送银两
	const TYPE_SEND_GOLD		= 2003;		//赠送仙石
	const TYPE_DO_ORDERS		= 2004;		//充值补单
	const TYPE_SEND_GOODS_BY_ROLE_NAME	= 2005;		//按玩家名批量发道具
	const TYPE_SEND_GOODS_BY_CONDITION	= 2006;		//按条件批量发道具
	const TYPE_GET_GOLD_BY_INFO_BUTTON      = 2007;  //信息提示按钮获得仙石
	const TYPE_DELETE_APPLY_GOODS_RECORD      = 2008;  //删除赠送道具申请记录
	const TYPE_DELETE_SEND_GOODS_RECORD      = 2009;  //删除赠送道具记录
	
	const TYPE_MSG_BROADCAST	= 3001;		//消息广播
	const TYPE_SEND_EMAIL	= 3002;		//给玩家发信
	const TYPE_SEND_EMAIL_BY_ROLE_NAME	= 3003;		//按玩家名批量发信
	const TYPE_SEND_EMAIL_BY_CONDITION	= 3004;		//按条件批量发信
	const TYPE_MSG_BROADCAST_LOAD	= 3005;		//导入消息广播
	const TYPE_MSG_BROADCAST_CREATE	= 3006;		//新增消息广播
	const TYPE_MSG_BROADCAST_DELETE	= 3007;		//删除消息广播
	const TYPE_MSG_BROADCAST_MODIFY	= 3008;		//修改消息广播
	const TYPE_MSG_BROADCAST_SYNC	= 3009;		//同步消息广播
//        const TYPE_BOSS_GROUP_LOAD      = 3008;         //导入boss群
//        const TYPE_BOSS_GROUP_CREATE    = 3009;         //新增boss群
//        const TYPE_BOSS_GROUP_DELETE    = 3010;         //删除boss群

	const TYPE_DIRECT_LOGIN_USER		= 4001;		//直接登录玩家帐号
	const TYPE_DIRECT_LOGIN_PLATFORM	= 4002;		//模拟平台登录帐号
	const TYPE_CREATE_GM_ROLE			= 4003;		//直接注册GM角色
	const TYPE_USE_GM_CODE			= 4004;		//使用后台GM指令
	const TYPE_RESTORE_PLAYER_DATA			= 4005;		//恢复玩家数据

	const TYPE_SYS_LOGIN			= 9001;			//登录系统
	const TYPE_SYS_SET_PASSWORD		= 9002;		//修改自己密码
	const TYPE_SYS_CREATE_ADMIN		= 9003;		//新设后台用户
	const TYPE_SYS_MODIFY_ADMIN_GROUPID		= 9004;		//修改用户所属组
	const TYPE_SYS_MODIFY_ADMIN_PASSWORD		= 9005;		//修改后台用户密码
	const TYPE_SYS_CREATE_ITEM_GOOP				= 9006;		//新增道具权限组
	const TYPE_SYS_MODIFY_ITEM_GOOP				= 9007;		//修改道具权限组
	const TYPE_SYS_CREATE_ADMIN_GROUP		= 9008;		//新建用户组
	const TYPE_SYS_MODIFY_ADMIN_GROUP		= 9009;		//修改用户组
	const TYPE_SYS_DELETE_ADMIN_GROUP		= 9010;		//删除用户组

	var $userid;
	var $username;
	var $key;

	function __construct()
 	{
 		global $auth;
		$this->userid    = $auth->userid();
		$this->username  = $auth->username();
 		//assert(is_int($ADMIN->userid) && $ADMIN->userid > 0);
 	}

	function __destruct()
	{
	}

	//使用金币
	// $type 的取值根据 $ADMIN_LOG_TYPE 数组
	// $detail 与 $type 匹配，如果使用赠送道具，则$detail为道具的ID
	// $number 为具体的数量，比如赠送金币的数量
	// $desc 为中文的详细描述，如“赠送道具”，“赠送金币”
	// $user_id, $user_name为被操作对象
	public function Log($type, $detail, $number, $desc, $user_id, $user_name)
	{
		$f['admin_id']   = $this->userid;
		$f['admin_name'] = $this->username;
		$f['admin_ip']   = GetIP();

		$f['user_id']    = $user_id;
		$f['user_name']  = $user_name;

		$f['mtime']    = time();
		$f['mtype']    = $type;
		$f['mdetail']  = $detail;
		$f['number']   = $number;
		if (!empty($desc))
		    $f['desc']     = $desc;
		else {
		    global $ADMIN_LOG_TYPE;
		    $f['desc']     = $ADMIN_LOG_TYPE[$type];
		}

		$sql = DBMysqlClass::makeInsertSqlFromArray($f, T_LOG_ADMIN);

		IQuery($sql);
	}

	//历史记录
	public function getLogs($start = 0, $end = 0, $admin_name = '', $type = 0)
	{
		global $_DCACHE;
		$sql = "SELECT * FROM ".T_LOG_ADMIN." WHERE 1 ";
		if ($admin_name)
			$sql .= " AND `admin_name`='{$admin_name}'";
		if ($start)
			$sql .= " AND `mtime` >= {$start}";
		if ($end)
			$sql .= " AND `mtime` <= {$end}";
		if ($type>0)
			$sql .= " AND mtype='{$type}'";

		$sql .= " ORDER BY `mtime` DESC";
		$rs = IFetchRowSet($sql);

		if(!is_array($rs))
			$rs = array();

		//var_dump($sql);

		for($i = 0; $i < count($rs); $i++)
		{
			if($rs[$i]['mtime'])
				$rs[$i]['time_str'] = strftime('%D %T', $rs[$i]['mtime']);

			$mtype = $rs[$i]['mtype'];
			$str = '';
			if($rs[$i]['mdetail'])
			{
				if($mtype == 5)
				{
					$res = extractData($rs[$i]['mdetail']);
					if(intval($res['W']))
						$str .= '木: ' .intval($res['W']);
					if(intval($res['M']))
						$str .= '  铁: ' .intval($res['M']);
					if(intval($res['F']))
						$str .= '  粮: ' .intval($res['F']);
				}
				elseif($mtype == 2)
				{
					$tid = $rs[$i]['mdetail'];
					$tname = $_DCACHE['tech'][$tid]['name'];
					$str .= $tname;

				}
				elseif($mtype == 1)
				{
					$bid = $rs[$i]['mdetail'];
					$bname = $_DCACHE['building'][$bid]['name'];
					$str .= $bname;
				}
				elseif($mtype == 3)
				{
					$sid = $rs[$i]['mdetail'];
					$num = $rs[$i]['number'];
					$sname = $_DCACHE['soldier'][$sid]['name'];
					//$str .= $sname . ' ' . $num . '个';
				}
				elseif($mtype == 4)
				{
					$iid = $rs[$i]['mdetail'];
					$num = $rs[$i]['number'];
					$iname = $_DCACHE['item'][$iid]['name'];
					//$str .= $iname . ' ' . $num . '个';
				}
			}
			if($mtype == 6)
			{
				$num = $rs[$i]['number'];
				if($rs[$i]['desc']=='赠送仙石')
				{
					$str .= '赠送'.$num.' 仙石';
				}
				elseif($rs[$i]['desc']=='赠送金砖')
				{
					$str .= '赠送'.$num.' 金砖';
				}
				//else $str .= $num.' 仙石';
			}
			elseif($mtype == 92)
			{
				$admin_level = $rs[$i]['number'];
				$pos = strpos($rs[$i]['mdetail'],'权限组');
				if($pos === false)
				{
					$str .= '级别 '.$admin_level;
				}
			}
			$rs[$i]['mdetail_str'] = $str;
		}

		return $rs;
	}

	/*
	 * 取得有过滤条件的数据
	 */
	public function getGlvLogs($start = 0, $end = 0, $admin_name = '', $gulvxt, $op_type, $type = 0)
	{
		global $_DCACHE;
		$sql = "SELECT * FROM ".T_LOG_ADMIN." WHERE 1 ";
		if ($admin_name)
			$sql .= " AND `admin_name`='{$admin_name}'";
		if ($gulvxt)
			$sql .= " AND `mtype` <> '{$gulvxt}'";
		if ($op_type != '0')
			$sql .= " AND `mtype`= '{$op_type}'";
		if ($start)
			$sql .= " AND `mtime` >= {$start}";
		if ($end)
			$sql .= " AND `mtime` <= {$end}";
		if ($type>0)
			$sql .= " AND mtype='{$type}'";


		$sql .= " ORDER BY `mtime` DESC";
		$rs = IFetchRowSet($sql);

		if(!is_array($rs))
			$rs = array();

		//var_dump($sql);

		for($i = 0; $i < count($rs); $i++)
		{
			if($rs[$i]['mtime'])
				$rs[$i]['time_str'] = strftime('%D %T', $rs[$i]['mtime']);

			$mtype = $rs[$i]['mtype'];
			$str = '';
			if($rs[$i]['mdetail'])
			{
				if($mtype == 5)
				{
					$res = extractData($rs[$i]['mdetail']);
					if(intval($res['W']))
						$str .= '木: ' .intval($res['W']);
					if(intval($res['M']))
						$str .= '  铁: ' .intval($res['M']);
					if(intval($res['F']))
						$str .= '  粮: ' .intval($res['F']);
				}
				elseif($mtype == 2)
				{
					$tid = $rs[$i]['mdetail'];
					$tname = $_DCACHE['tech'][$tid]['name'];
					$str .= $tname;

				}
				elseif($mtype == 1)
				{
					$bid = $rs[$i]['mdetail'];
					$bname = $_DCACHE['building'][$bid]['name'];
					$str .= $bname;
				}
				elseif($mtype == 3)
				{
					$sid = $rs[$i]['mdetail'];
					$num = $rs[$i]['number'];
					$sname = $_DCACHE['soldier'][$sid]['name'];
					//$str .= $sname . ' ' . $num . '个';
				}
				elseif($mtype == 4)
				{
					$iid = $rs[$i]['mdetail'];
					$num = $rs[$i]['number'];
					$iname = $_DCACHE['item'][$iid]['name'];
					//$str .= $iname . ' ' . $num . '个';
				}
			}
			if($mtype == 6)
			{
				$num = $rs[$i]['number'];
				if($rs[$i]['desc']=='赠送仙石')
				{
					$str .= '赠送'.$num.' 仙石';
				}
				elseif($rs[$i]['desc']=='赠送金砖')
				{
					$str .= '赠送'.$num.' 金砖';
				}
				//else $str .= $num.' 仙石';
			}
			elseif($mtype == 92)
			{
				$admin_level = $rs[$i]['number'];
				$pos = strpos($rs[$i]['mdetail'],'权限组');
				if($pos === false)
				{
					$str .= '级别 '.$admin_level;
				}
			}
			$rs[$i]['mdetail_str'] = $str;
		}

		return $rs;
	}

	/**
	 * 记录管理员批量赠送道具
	 *
	 * @param string $detail
	 */
	public function logBatchSendItem($detail)
	{
	    $this->Log(9, '', 0, $detail);
	}
}