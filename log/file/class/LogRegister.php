<?php
include FILE_ETL_CLASS.'/LogTemplate.php';
class LogRegister extends LogTemplate {
	
	function __construct($serverid)
	{
		parent::__construct(t_log_register,$serverid);
	}
	
	public function fomateData(&$data){
		foreach ($this->fields as &$fieldsName) {
			$lineData[$fieldsName] = $data[$fieldsName];
		}
		$lineData['year'] = date('Y',$lineData['mtime']);
		$lineData['month'] = date('m',$lineData['mtime']);
		$lineData['day'] = date('d',$lineData['mtime']);
		$lineData['hour'] = date('H',$lineData['mtime']);
		$lineData['min'] = date('i',$lineData['mtime']);
//		$lineData['mdate'] = $lineData['mtime'];
		//以下各数组元素的顺序必须严格按对应的表的字段顺序,否则入库时数据会错乱
		return array(
			$lineData['mdate'],
			$lineData['mtime'],
			$lineData['account_name'],
			$lineData['role_name'],
			$lineData['ip'],
			$lineData['job'],
			$lineData['sex'],
			$lineData['level'],
			$lineData['year'],
			$lineData['month'],
			$lineData['day'],
			$lineData['hour'],
			$lineData['min'],
            $lineData['role_id'],
            $lineData['account_id'],
		);
	}
}