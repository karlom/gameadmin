<?php
class DBMysqlClass
{
	private $conn = null;
	private $query_result;
	private $rows;
	public $str ='';
	
	/**
	 * 连接数据库
	 * @param array $config
	 * @throws Exception
	 */
	public function connect($config)
	{
		$this->str = $config['dbname'];
		
		$this->conn = @mysql_connect($config['host'], $config['user'], $config['passwd'], false);
		//die($config['host'].'->'. $config['user'].'->'. $config['passwd']);
		if (!$this->conn){
			return mysqlException("数据连接失败,请检查服务器数据库配置是否正确");
//			throw new Exception("数据连接失败:" . mysql_error());
		}
		if (!@mysql_select_db($config['dbname'], $this->conn)) {
			return mysqlException("选择数据库:[".$config['dbname']."]错误,请检查服务器数据库配置是否正确");
//			throw new Exception("选择数据库表错误:" . mysql_error());
		}
		@mysql_query("set names utf8", $this->conn);
	}

	/**
	 * 执行sql语句，并返回Resource
	 * @param string $sql
	 * @throws Exception
	 * @return resource
	 */
	public function query($sql, $returnId="")
	{
		$this->query_result = @mysql_query($sql, $this->conn);
		if ($this->query_result === false) {
			return mysqlException("sql执行出错". $sql, $sql);
//			throw new Exception("sql执行出错:" . $sql . "   " . mysql_error());
		}
		if($returnId){
		    return mysql_insert_id();
		}else{
		    return $this->query_result;
		}
	}

	/**
	 * 执行select语句并返回结果
	 * @param string $sql
	 * @return array
	 */
	public function fetchAll($sql, $file="")
	{
		$this->query($sql, false);
		return $this->getAll($this->query_result, $file);
	}

	public function fetchOne($sql)
	{
		$this->query($sql, false);
		return $this->getOne($this->query_result);
	}

	public function getOne($result)
	{
		if ($this->query_result) {
			$result = @mysql_fetch_assoc($this->query_result);
			if (!$result) {
				return array();
			}
			return $result;
		}
		return mysqlException("获取sql执行结果出错，可能尚未执行sql");
//		throw new Exception("获取sql执行结果出错，可能尚未执行sql");
	}

	public function getAll($result, $file="")
	{
		if ($this->query_result) {
			$this->rows = array();
			while (($row = @mysql_fetch_assoc($this->query_result)) !== false) {
				if($file && $row[$file]){
					$this->rows[$row[$file]] = $row;
				}else{
					array_push($this->rows, $row);
				}
			}
			return $this->rows;
		}
		return mysqlException("获取sql执行结果出错，可能尚未执行sql");
//		throw new Exception("获取sql执行结果出错，可能尚未执行sql");
	}
	


	/**
	 * 由数组构造出SQL语句，用于添加数据到数据库，即INSERT
	 */
	public static function makeInsertSqlFromArray($arr, $table){
		$str1 = ''; $str2 = '';
		foreach($arr as $k=>$v)
		{
			$str1 .= "`{$k}`,";
			$str2 .= "'{$v}',";
		}
		
		$str = "INSERT INTO `{$table}` (" . trim($str1, ', ') . ") VALUES (" . trim($str2, ', ') . ")";
		return $str;
	}

    /*  
     * 由二维数组构造SQL语句,用于添加数据到数据库,即INSERT,只进行一次I/o操作,提高入库性能,默认对超过五百条记录分割,并避免重复写入记录,之前的记录会更新
     * @ param $arr: 二维数组
     * @ param $table: 表名
     * @ param $countNum: 按默认条数进行数组分割
     * @ return array
     */
    public static function makeDuplicateInsertSqlFromArrayTwo($arr, $table, $countNum=500) {
        $str1 = ''; 
        $str2 = ''; 
        $update = ''; 
        $count = count($arr);
        $arrChunk   = array_chunk($arr,$countNum);
        $chunkCount = count($arrChunk);
        for($i=0; $i<$chunkCount; $i++) {
            $str[$i] = array();
            foreach ( $arrChunk[$i] as $key => $value ) { 
                $arrKey = array_keys($value);
                $arrValue = array();
                $arrValue = array_values($value);
                $strTest  = ''; 
                foreach($arrValue as $k => $v){
                    $strTest .= "'{$v}',";
                }   
                $str2 .= "(".trim($strTest, ',')."),";
            }   
            $str2 = trim($str2, ',');
            foreach ($arrKey as $k2 => $v2) {
                $str1 .= "`{$v2}`,";
                $update .= "`$v2` =VALUES(`$v2`),";
            }   
            $str[$i] = "INSERT INTO `{$table}` (" . trim ( $str1, ', ' ) . ") VALUES ".$str2." ON DUPLICATE KEY UPDATE " . trim ( $update, "," ).";";
            $str1 = ''; 
            $str2 = ''; 
            $update = ''; 
        }   
        return $str;    
    }   
	
	public static function fetchLatestIDWithData($column_data, $table, $key = 'id')
	{
		$sql = self::makeSelectIdWhereSqlFromArray($column_data, $table, $key) . " ORDER BY `$key` DESC LIMIT 1";
		$row = IFetchRowOne($sql);
		return $row[$key];
	}
	
	/**
	 * 由数组构造出SQL语句，用于条件查询，用来检查刚刚INSERT的数据。
	 */
	public static function makeSelectIdWhereSqlFromArray($arr, $table, $key = 'id'){
		$where = '';
		foreach($arr as $k=>$v)
		{
			if ($k != $key)
				$where .= "`{$k}`='{$v}' AND ";
		}
		
		$str = "SELECT `{$key}` FROM `{$table}` WHERE " . substr($where, 0, strlen($where) - 4 );
		return $str;
	}
	
	/**
	 * 由数组构造出SQL语句，用于更新数据回数据库，即UPDATE
	 */
	function makeUpdateSqlFromArray($arr, $table, $key = 'id')
	{
		$str = '';
		foreach($arr as $k=>$v)
		{
			if ($k != $key)
				$str .=  "`{$k}`='{$v}',";
			else
				$where = " WHERE `{$key}`='{$v}' LIMIT 1";
		}
	
		$str = "UPDATE `{$table}` SET " . trim($str, ', ') . $where;
	
		//if (ODINXU_DEBUG) echo $str ."\r\n";
		return $str;
	}
	
	/**
	 * 释放数据库连接
	 * @throws Exception
	 */
	public function close()
	{
		return mysql_close($this->conn);
	}
}