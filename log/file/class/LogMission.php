<?php
include FILE_ETL_CLASS.'/LogTemplate.php';
class LogMission extends LogTemplate {
	
	function __construct($serverid)
	{
		parent::__construct(t_log_mission,$serverid);
	}
	
	public function fomateData(&$data){
		foreach ($this->fields as &$fieldsName) {
			$lineData[$fieldsName] = $data[$fieldsName];
		}
//		$lineData['mtime'] = strtotime($data['record_log_time']);
//		$lineData['mdate'] = strtotime(date('Y-m-d H:i:s',$lineData['mdate']));
//		$lineData['mdate'] = $lineData['mtime'];
		//以下各数组元素的顺序必须严格按对应的表的字段顺序,否则入库时数据会错乱
		return array(
			$lineData['mdate'],
			$lineData['mtime'],
			$lineData['role_name'],
			$lineData['account_name'],
			$lineData['mission_id'],
			$lineData['mission_name'],
			$lineData['group_id'],
			$lineData['mission_type'],
			$lineData['min_level'],
			$lineData['max_level'],
			$lineData['status'],
			$lineData['step'],
			$lineData['loop'],
            $lineData['role_level'],
			$lineData['act']
		);
	}
}
