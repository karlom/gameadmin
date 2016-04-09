<?php
include_once '../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE."/global.php";
include_once SYSDIR_ADMIN_CLASS."/admin_group.class.php";
global $lang;
//取得用户信息用于跟其它后台通信
$user_info = $auth->user_info();

//通过帐号ID取得用户的权限数组
$gid 	   = getAdminGroupID($_SESSION['uid']);
$power_arr = AdminGroupClass::enum();
$woner_arr = $power_arr[$gid];
$new_arr   = empty($woner_arr)?array():$woner_arr[rule_arr][0];

//把用户有权限访问的页面ID重组为一个新数组
if(ROOT_USERNAME!=$user_info['username']){
	if( $new_arr !== null )
	{
		foreach($new_arr as $k=>$v){
			if($v==1){
				$new_page_arr[] = $k;
			}
		}
	}
	$new_page_str = @implode("|",$new_page_arr);
}else{
	$new_page_str = 'all';
}

$flag = md5($user_info['username'].$new_page_str.$user_info['uid'].$user_info['last_op_time'].ADMIN_FLAG_KEY);
$servers = array();
$combine_servers = array();
if (!empty($serverList)){
	foreach ( $serverList as $sid => $server ) {
	    
	    if($server['iscombine'] == 1){
	    	$combine_servers[$sid] = $server['name'];
	    } else {
	    	$servers[$sid] = $server['name'];
	    }
	    if(PROXY == 'qq') {
		    if($sid == 's0'){
		    	$s0 = $server;
		    	unset($servers[$sid]);
		    }	    	
	    }

//		array_push($servers, $sid);
	}
	unset($combine_servers['s0']);
	$combine_servers['s0'] = $s0['name'];
}

$data = array(
	'username' => $user_info['username'],
	'user_info' => $user_info,
	'user_power' => $new_page_str,
	'flag' => $flag,
	'admin_prefix' => ADMIN_USE_PREFIX,
	'admin_url' => ADMIN_USE_URL,
	'admin_sys_quantity' => $ADMIN_SYS_QUANTITY,
	'GAME_ZH_NAME'=>GAME_ZH_NAME,
	'CFG_VERSION'=>CFG_VERSION,
	'server_list'=>$servers,
	'combine_server_list'=>$combine_servers,
	'lang'=>$lang
);

render('top.html',$data);


///////////////====================
exit();

function getAdminGroupID($uid)
{
        $sql = "SELECT `groupid` FROM `".T_ADMIN_USER
                        ."` where `uid`='$uid'";
        $row = IFetchRowOne($sql);
        return intval($row['groupid']);
}
