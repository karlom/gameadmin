<?php
//TODO: 将组数据放入cache, 以便修改组数据时能够及时反映出效果
include_once('admin_access_rule.class.php');
class AdminGroupClass
{
	private $groupid;
	private $data;
	private $rules;
	private $rule_objs;
	
	function AdminGroupClass($groupid)
	{
		$this->groupid = intval($groupid);
		$this->data = $this->_readGroupData();
		if($rules = $this->data['rule']) {
			$rules = explode(',', $rules);
		} else {
			$rules = array();
		}
		$this->rules = $rules;
		$this->rule_objs = array();
	}
	
	/**
	 * 
	 * @return array ['id', 'name', 'rule', 'comment']
	 */
	public function groupdata()
	{
		return $this->data;
	}
	
	public function setComment($comment)
	{
		$this->data['comment'] = trim($comment);
		$this->_updateGroupData();
	}
	
	/**
	 * 
	 * 检查访问权限
	 * @param int $class
	 * @param int $id
	 * @return boolean
	 */
	public function check($class, $id)
	{
		if(!$this->rules[$class])
			return false;
		if(!$rule_obj = $this->rule_objs[$class]) {
			$this->rule_objs[$class] = $rule_obj = new AdminAccessRuleClass($this->rules[$class]);
		}
		return $rule_obj->check($id);
	}
	
	/**
	 * 
	 * 返回访问权限数组
	 * @param int $class
	 * @return array [id=>bool, ...]
	 */
	public function peek($class)
	{
		if(!$this->rules[$class]) {
			return array();
		}
		if(!$rule_obj = $this->rule_objs[$class]) {
			$this->rule_objs[$class] = $rule_obj = new AdminAccessRuleClass($this->rules[$class]);
		}
		return $rule_obj->getArray();
	}
	
	/**
	 * 
	 * 设置访问权限
	 * @param int $class
	 * @param int $id
	 * @param bool $access
	 */
	public function set($class, $id, $access)
	{
		if(!$rule_obj = $this->rule_objs[$class])
			$this->rule_objs[$class] = $rule_obj = new AdminAccessRuleClass($this->rules[$class]);
		$rule_obj->set($id, $access);
		if(!isset($this->rules[$class])){
			for($i = 0; $i <= $class; $i++)
				if(!isset($this->rules[$i]))
					$this->rules[$i] = '';
		}
		$this->rules[$class] = $rule_obj->getString();
		$this->data['rule'] = implode(',', $this->rules);
		$this->_updateGroupData();
	}
	
	/**
	 * 
	 * 一次性设置一批权限
	 * @param array $access_arr [id=>access,...]
	 */
	public function import($class, $access_arr)
	{
		if(!$rule_obj = $this->rule_objs[$class])
			$this->rule_objs[$class] = $rule_obj = new AdminAccessRuleClass($this->rules[$class]);
		$rule_obj->import($access_arr);
		if(!isset($this->rules[$class])){
			for($i = 0; $i <= $class; $i++)
				if(!isset($this->rules[$i]))
					$this->rules[$i] = '';
		}
		$this->rules[$class] = $rule_obj->getString();
		$this->data['rule'] = implode(',', $this->rules);
		$this->_updateGroupData();
	}
	
	/**
	 * 复制本组配置
	 * @return int $new_group_id
	 */
	public function duplicate()
	{
		$data = $this->data;
		unset($data['id']);
		$sql = DBMysqlClass::makeInsertSqlFromArray($data, T_ADMIN_GROUP);
		IQuery($sql);
		$id = DBMysqlClass::fetchLatestIDWithData($data, T_ADMIN_GROUP);
		return intval($id);
	}
	
	public static function create($name, $comment)
	{
		$data = array();
		$data['name'] = $name;
		$data['rule'] = '';
		$data['comment'] = $comment;
		$sql = DBMysqlClass::makeInsertSqlFromArray($data, T_ADMIN_GROUP);
		IQuery($sql);
		$id = DBMysqlClass::fetchLatestIDWithData($data, T_ADMIN_GROUP);
		return intval($id);
	}
	
	public static function delete($groupid)
	{
		$groupid = intval($groupid);
		$sql = "DELETE FROM `".T_ADMIN_GROUP."` WHERE `id`='$groupid'";
		IQuery($sql);
	}
	
	/**
	 * 
	 * 枚举所有的组
	 * @return array [id=>['id','name','rule','comment','rule_arr'],...] | false
	 */
	public static function enum()
	{
		$sql = "SELECT `id`,`name`,`rule`,`comment` FROM `".T_ADMIN_GROUP."` ORDER BY `id` DESC";
		$rows = IFetchRowSet($sql);
		if(!is_array($rows)||!$rows)
			return false;
		$enum = array();
		foreach($rows as $i => $row) {
			if($rules = $row['rule']) {
				$rules = explode(',', $rules);
			} else {
				$rules = array();
			}
			$row['rule_arr'] = array();
			foreach($rules as $class => $rule) {
				$row['rule_arr'][$class] = AdminAccessRuleClass::string2array($rule);
			}
			$enum[intval($row['id'])] = $row;
		}
		return $enum;
	}
	
	/**
	 * 
	 * 返回组成员数据
	 * @param int $groupid
	 * @return array [['uid','username','comment'],...] | false
	 */
	public static function members($groupid)
	{
		$sql = "SELECT `uid`,`username`,`comment` FROM `".T_ADMIN_USER."` WHERE `groupid`='$groupid'";
		$rows = IFetchRowSet($sql);
		if(!is_array($rows)||!$rows)
			return false;
		return $rows;
	}
	
	private function _readGroupData()
	{
		$sql = "SELECT `id`,`name`,`rule`,`comment` FROM `".T_ADMIN_GROUP."` WHERE `id`='$this->groupid'";
		$row = IFetchRowOne($sql);
		if(!is_array($row))
			return false;
		return $row;
	}
	
	private function _updateGroupData()
	{
		if($data = $this->data)
		{
			$sql = DBMysqlClass::makeUpdateSqlFromArray($data, T_ADMIN_GROUP);
			IQuery($sql);
			$this->data = $this->_readGroupData();
		}
	}
	
	public function getGroupData()
	{
		$sql = "SELECT `id`,`name`,`rule`,`comment` FROM `".T_ADMIN_GROUP."` ORDER BY `id` DESC";
		$row = IFetchRowSet($sql);
		if(!is_array($row)) {
			return false;
		} else {
			foreach($row as $k => $v){
				$data[$v['id']] = $v;
			}
			$row = $data;
		}
			
		return $row;
	}
}