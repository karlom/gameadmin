<?php
include_once('admin_group.class.php');
define('LOGIN_TIMEOUT_SEC', ADMIN_LOGIN_TIMEOUT);
class AuthClass
{
	/**
     * 验证是否有权限
     * 
     * @return bool 
     */
	public function auth()
	{
		if($this -> alreadyLogin() || $this -> _checkTicket()){
			return true;
		}
		return false;
	}

	public function alreadyLogin(){
//		$lastOPTime = $_SESSION['last_op_time'];
//		if(time() - $lastOPTime > LOGIN_TIMEOUT_SEC){
//			return false;
//		}else{
//			$_SESSION['last_op_time'] = time();
//		}
		if($_SESSION['uid'] > 0 && $_SESSION['username'] != ''){
			return true;
		}elseif($_SESSION['overlord']){
			return true;
		}
		return false;
	}

	public function logout()
	{
		session_destroy();
	}

	public function username()
	{
		if($this -> alreadyLogin())
		return $_SESSION['username'];
		return null;
	}

	public function userid()
	{
		if($this -> alreadyLogin())
		return $_SESSION['uid'];
		return null;
	}

	public function user_info(){
		if($this->alreadyLogin())
		return $_SESSION;
		return null;
	}

	
	/**
     * 用户登录认证
     * 
     * @param string $username 
     * @param string $password 
     * @return integer | false
     */
	public function login($username, $password)
	{
		
		// 优先判断ROOT登陆
		if(defined("ROOT_USERNAME") && ROOT_USERNAME && $username === ROOT_USERNAME)
		return $this -> _loginROOT($password);
		//判断是否是来自允许登录后台的IP
		if(!canLoginIp()){
				die('<font color="red">你所在的网络没有登录本系统的权限，请联系管理员。</font>');
			}
		// 用户名和密码都是已经经过过滤的了
		$username = addslashes($username);
		$password = strtolower(md5($password));
		$sql = "SELECT * FROM `" . T_ADMIN_USER . "` where `username`='{$username}' and `passwd`='{$password}'";
		$result = IFetchRowOne($sql);
		if(!empty($result)){
			if ( 0==$result['user_status'] || (time() - $result['last_login_time']) > LOGIN_FROST_TIME * 86400 ) {
				die('<font color="red">你的帐号已超过'.LOGIN_FROST_TIME.'天未登录被自动冻结或已经被管理员禁用，请联系联系运维人员帮忙解禁。</font>');
			}
			$_SESSION['username'] = $username;
			$_SESSION['uid'] = $result['uid'];
			$_SESSION['last_op_time'] = time();
			$_SESSION['last_login_time'] = $result['last_login_time'];
			$_SESSION['last_change_passwd'] =$result['last_change_passwd'];
			$_SESSION['overlord'] = false;
			$_SESSION['adminver'] = 'default';
			$sql = "update ".T_ADMIN_USER." set last_login_time=".NOW_TIMESTAMP." where `username`='{$username}'";
			IQuery($sql);
			return true;
		}
		return false;
	}

	/**
     * 检查对组件的访问权限
     * 
     * @param int $type 
     * @param int $id 
     * @return boolean 
     */
	public function canAccess($type, $id)
	{
		if($_SESSION['overlord'])
		return true;
		// TODO:性能?
		$groupid = $this -> _getAdminGroupID($_SESSION['uid']);
		$group = new AdminGroupClass($groupid);
		return $group -> check($type, $id);
	}

	/**
     * 检查页面的访问权限
     * 
     * @param string $filename 
     * @param bool $die_on_fail 
     * @return bool , 当die_on_fail为false
     */
	public function assertModuleAccess($filename, $die_on_fail = true)
	{

		global $ADMIN_PAGE_CONFIG, $INTAERFACE;
		try{
			$filename = self :: formatAdminModulePageFilename($filename);
			if(!$filename)
			throw new Exception('权限不足');
			$found = null;
			foreach($ADMIN_PAGE_CONFIG as $id => $page){
				list($url,) = explode('?', $page['url']);
				if($filename == $url){
					$found = $id;
					$INTAERFACE = $page['interface'];
					break;
				}
			}
			if(!$this -> assertModuleIDAccess($found, $die_on_fail)){
				throw new Exception('权限不足4');
			}
		}catch (Exception $e){
			if($die_on_fail)
			die($e -> getMessage() . ":$filename");
			else return false;
		}
	}

	/**
     * 检查页面ID的访问权限
     * 
     * @param string $filename 
     * @param bool $die_on_fail 
     * @return bool , 当die_on_fail为false
     */
	public function assertModuleIDAccess($id, $die_on_fail = true)
	{
		global $ADMIN_PAGE_CONFIG;
		try{
			if($id === null){
				throw new Exception('权限不足2');
			}else{
				$type = ADMIN_ACCESS_PAGE;
				// 先检测SESSION里有没有用户权限数组，再去检测数据库.
				if(!empty($_SESSION['userpower']) && $_SESSION['userpower'] != 'all'){
					if(in_array($id, $_SESSION['userpower'])){
						return true;
					}
				}elseif($_SESSION['userpower'] == 'all'){
					return true;
				}elseif($this -> canAccess($type, $id)){
					$page_config = $ADMIN_PAGE_CONFIG[$id];
					if(isset($page_config['v'])){
						// 该功能，只在 非实际运营服的状态下有效。
						if($page_config['v'] == 'dev'){
							if(SERVER_IS_REAL_RUN === true)
							throw new Exception('只有在内部开发测试服才能使用。');
						}
						// 该功能，只有admin帐号有权限操作
						if($page_config['v'] == 'root'){
							if($this -> username != ROOT_USERNAME){
								throw new Exception('仅root有权限使用。');
							}
						}
						// 该功能，只有debug有开启时才能使用
						if($page_config['v'] == 'debug'){
							if(!defined("ODINXU_DEBUG") || !ODINXU_DEBUG){
								throw new Exception('仅DEBUG状态下有效。');
							}
						}
						// 该功能，暂时屏蔽
						if($page_config['v'] == 'not'){
							throw new Exception('本功能暂未开放。');
						}
					}
					return true;
				}else{
					throw new Exception('权限不足3');
				}
			}
		}catch (Exception $e){
			if($die_on_fail){
				die($e -> getMessage() . ":$filename");
			}else{
				return false;
			}
		}
	}

	/**
     * 检查给出的组的权限是否是本管理员所属组的权限的子集
     * 
     * @param int $groupid 
     * @return bool 
     */
	public function assertAdminGroupAccess($groupid)
	{
		$type = ADMIN_ACCESS_PAGE;
		$group = new AdminGroupClass($groupid);
		$rule_arr = $group -> peek($type);
		return $this -> assertRuleArrayAccess($rule_arr);
	}

	/**
     * 检查给出的权限数组是否是本管理员的权限子集
     * 
     * @param array $rule_arr 
     * @return bool 
     */
	public function assertRuleArrayAccess($rule_arr)
	{
		$can_access = true;
		if( $rule_arr !== null )
		{
			foreach($rule_arr as $id => $access){
				if(!isset($my_access[$id])){
					$my_access[$id] = $this -> assertModuleIDAccess($id, false);
				}
				if(!$my_access[$id] && $access){
					$can_access = false;
					break;
				}
			}
		}
		return $can_access;
	}

	/**
     * 以module为根目录格式化文件名
     * 
     * @param string $filename 
     * @return string | false
     */
	public static function formatAdminModulePageFilename($filename)
	{
		if(!$filename)
		return false;
		$_search = str_replace('\\', '/', SYSDIR_ADMIN_PUBLIC) . '/module/';
		$filename = str_replace('\\', '/', $filename);
		if(strpos($filename, $_search) !== false)
		$filename = str_replace($_search, '', $filename);
		return $filename;
	}

	/**
     * ROOT账号验证, 此账号自动获得后台所有的权限
     * 
     * @param unknown_type $password 
     */
	private function _loginROOT($password)
	{
		if(defined("ROOT_PASSWORD") && ROOT_PASSWORD && ROOT_PASSWORD === $password){
			$_SESSION['username'] = ROOT_USERNAME;
			$_SESSION['uid'] = 0;
			$_SESSION['last_op_time'] = time();
			$_SESSION['last_login_time'] = time();
			$_SESSION['last_change_passwd'] = time();
			$_SESSION['user_status'] = 1;
			$_SESSION['overlord'] = true;
			$_SESSION['adminver'] = 'default';
			// var_dump($_SESSION);
			// die();
			return true;
		}
		return false;
	}

	/**
     * ticket验证方式
     * 
     * @return bool 
     */
	private function _checkTicket()
	{
		// username uid filename ticket time
		return false;
	}

	private function _getAdminGroupID($uid)
	{
		$sql = "SELECT `groupid` FROM `" . T_ADMIN_USER
		. "` where `uid`='$uid'";
		$row = IFetchRowOne($sql);
		return intval($row['groupid']);
	}
	
	
}