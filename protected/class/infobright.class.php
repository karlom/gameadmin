<?php
class DBInfobrightClass
{
	private static $conn = null;
	private $query_result;
	private $rows;

	/**
	 *
	 * 连接数据库
	 * @param array $config
	 * @throws Exception
	 */
	public function connect($config)
	{
		if (!is_resource($this->conn)) {
			$link = mysql_connect($config['host'], $config['user'], $config['passwd'], false);
			if (!$link){
				throw new Exception("数据仓库连接失败:" . mysql_error());
			}
			$this->conn = $link;
			if (!mysql_select_db($config['dbname'], $link)) {
				throw new Exception("选择数据仓库表错误:host:".$config['host']." user:".$config['user']." password:".$config['passwd']." dbname:". $config['dbname'] . mysql_error());
			}
			mysql_query("set names utf8", $link);
		}
	}

	/**
	 * 执行sql语句，并返回Resource
	 * @param string $sql
	 * @throws Exception
	 * @return resource
	 */
	public function query($sql)
	{	
		$this->query_result = mysql_query($sql, $this->conn);
		if ($this->query_result === false) {
			return mysqlException("sql执行出错". $sql, $sql);
			//throw new Exception("sql执行出错:" . $sql . "   " . mysql_error());
		}
		return $this->query_result;
	}

	/**
	 * 执行select语句并返回结果
	 * @param string $sql
	 * @return array
	 */
	public function fetchAll($sql, $file='')
	{
		$this->query($sql);
		return $this->getAll($this->query_result, $file);
	}

	public function fetchOne($sql)
	{
		$this->query($sql);
		return $this->getOne($this->query_result);
	}

	public function getOne($result)
	{
		if ($this->query_result) {
			$result =  mysql_fetch_assoc($this->query_result);
			if (!$result) {
				return array();
			}
			return $result;
		}
		throw new Exception("获取sql执行结果出错，可能尚未执行sql");
	}

	public function getAll($result, $file='')
	{
		if ($this->query_result) {
			$this->rows = array();
			while (($row = mysql_fetch_assoc($this->query_result)) !== false) {
                            if($file && $row[$file]){
                                $this->rows[$row[$file]] = $row;
                            }else{
                                array_push($this->rows, $row);
                            }
			}
			return $this->rows;
		}
		throw new Exception("获取sql执行结果出错，可能尚未执行sql");
	}
}