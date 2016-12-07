<?php
class AdminUserClass
{
	/**
	 * 
	 * 枚举所有的管理员
	 * @return array [uid=>['uid','username','comment','groupid','groupname','last_login_time'],...]
	 */
	public static function enum()
	{
		$sql = "SELECT * FROM `".T_ADMIN_USER."`";
		$rows = IFetchRowSet($sql);
		$groups = AdminGroupClass::enum();
		$enum = array();
		foreach($rows as $row) {
			if($gname = $groups[intval($row['groupid'])]['name'])
				$row['groupname'] = $gname;
			$enum[intval($row['uid'])] = $row;
		}
		return $enum;
	}
	
	/**
	 * 
	 * 新管理员
	 * @param string $name
	 * @param string $comment
	 */
	public static function create($name, $password, $comment)
	{
		$data = array();
		$data['username'] = $name;
		$data['passwd'] = strtolower(md5($password));
		$data['comment'] = $comment;
		$data['last_login_time'] = time();
		$data['user_power'] = '0';
		$data['last_change_passwd'] = time();
		$data['groupid'] = 0;
		$sql = DBMysqlClass::makeInsertSqlFromArray($data, T_ADMIN_USER);
		IQuery($sql);
		$uid = DBMysqlClass::fetchLatestIDWithData($data, T_ADMIN_USER, 'uid');
		return $uid;
	}
	
	/**
	 * 
	 * 改变组
	 * @param int $userid
	 * @param int $groupid
	 */
	public static function changeGroup($userid, $groupid)
	{
		$data = array();
		$data['uid'] = intval($userid);
		$data['groupid'] = intval($groupid);
		$sql = DBMysqlClass::makeUpdateSqlFromArray($data, T_ADMIN_USER, 'uid');
		return IQuery($sql);
	}
	
	/**
	 * 
	 * 修改
	 * @param string $password
	 * @param int $groupid
	 * @param string $comment
	 */
	public static function update($userid, $password, $groupid, $comment)
	{
		$data = array();
		$data['uid'] = intval($userid);
		if($password !== null) $data['passwd'] = strtolower($password);
		if($groupid !== null) $data['groupid'] = intval($groupid);
		if($comment !== null) $data['comment'] = $comment;
		if(count($data) <= 1)
			return true;
		$sql = DBMysqlClass::makeUpdateSqlFromArray($data, T_ADMIN_USER, 'uid');
		return IQuery($sql);
	}
}