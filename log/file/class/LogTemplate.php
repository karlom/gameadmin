<?php

//include FILE_ETL_CLASS.'/EtlLog.php';
class LogTemplate{

	public $tableName;  //对应的表名
	public $serverid;	//要入库的区服
	public $swicth;  // 日志开关 on 或 off
	public $gameLog; //日志文件全路径
	public $logFilePreg; //匹配日志文件的正则
	public $etlCsvPath;  //临时的csv文件存放路径
	public $fields; //要从日志文件中抽取的字段
	public $exFields; //要从日志文件中抽取的字段
	public $desc; //说明
	public $ok = true; //处理结果状态
	public $csvFile; //直接传过来的csv文件

	/**
	 * 
	 * @param string $tableName 对应日志表名
	 */
	public function __construct($tableName,$serverid)
	{
		global  $arrLogTplConf;
		
		$this->tableName = $tableName;
		$this->serverid = $serverid;
		$this->swicth = $arrLogTplConf[$tableName]['switch'];
		$this->gameLog = '';
		$this->logFilePreg = $arrLogTplConf[$tableName]['logFilePreg'];
		$this->etlCsvPath = SYSDIR_GAME_ETL_CSV.DIRECTORY_SEPARATOR.$this->serverid.DIRECTORY_SEPARATOR.$tableName.'.csv';
		$this->fields = $arrLogTplConf[$tableName]['fields'];
		$this->exFields = $arrLogTplConf[$tableName]['exFields'];
		$this->desc = $arrLogTplConf[$tableName]['desc'];
	}

	/**
	 * 获取今天要转换的日志的路径
	 * @param string $logFile 指定日志文件
	 */
	public function getExtractFile($logFile='')
	{
		if ('on' != $this->swicth) {
			_debug(" 表 {$this->tableName} 对应的日志入库开关已被关闭! ");
			$this->ok = false;
			return false;
		}
		if (!$logFile) {
			$arrAllLogFile = @scandir(SYSDIR_GAME_LOG.DIRECTORY_SEPARATOR.$this->serverid);
			if (is_array($arrAllLogFile)) {
				foreach ($arrAllLogFile as &$filename) {
					preg_match("/{$this->logFilePreg}/",$filename,$match);
					if ($match[0]) {
						$logFile =  SYSDIR_GAME_LOG.DIRECTORY_SEPARATOR.$this->serverid.DIRECTORY_SEPARATOR.$match[0];
						break;
					}
				}
			}
		}
		if (!$logFile) { //若没有需要处理的日志,则直接退出
			return false;
		}else {
			if (!file_exists($logFile) || !is_file($logFile) ) {
				$this->ok = false;
				_error(" 文件 {$logFile} 不存在! ");
				echo "【ERROR】 文件 {$logFile} 不存在! \n";
				return false;
			}
		}
		$this->gameLog = &$logFile;
	}

	/**
	 * 获取CSV日志的路径
	 * @param string $logFile 指定日志文件
	 */
	public function getCsvFile($csvFile='')
	{
		if ('on' != $this->swicth) {
			_debug(" 表 {$this->tableName} 对应的日志入库开关已被关闭! ");
			$this->ok = false;
			return false;
		}
		if (!$csvFile) {
			$arrAllLogFile = @scandir(SYSDIR_LOG.DIRECTORY_SEPARATOR.'csvFile'.DIRECTORY_SEPARATOR.$this->serverid);
			if (is_array($arrAllLogFile)) {
				foreach ($arrAllLogFile as &$filename) {
					preg_match("/{$this->tableName}.[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.csv$/",$filename,$match);
					if ($match[0]) {
						$csvFile =  SYSDIR_LOG.DIRECTORY_SEPARATOR.'csvFile'.DIRECTORY_SEPARATOR.$this->serverid.DIRECTORY_SEPARATOR.$match[0];
						break;
					}
				}
			}
		}
		if (!$csvFile) { //若没有需要处理的日志,则直接退出
			return false;
		}else {
			if (!file_exists($csvFile) || !is_file($csvFile) ) {
				$this->ok = false;
				_error(" 文件 {$csvFile} 不存在! ");
				echo "【ERROR】 文件 {$csvFile} 不存在! \n";
				return false;
			}
		}
		$this->csvFile = &$csvFile;
//		return $csvFile;
	}

	/**
	 * 抽取并转换日志
	 *
	 */
	public function extractAndTransform ()
	{
		$logFile = &$this->gameLog;
		//如果没有需要处理的文件,直接退出
		if (!$logFile) {
			return false;
		}
		
		$this->fmkdir(dirname($this->etlCsvPath), $logFile);
		
//		if (file_exists($this->etlCsvPath)) {
//			$fpcsv = fopen($this->etlCsvPath,'w');
//			if (FALSE===$fpcsv || FALSE === fwrite($fpcsv,'')) {
//				$this->ok = false;
//				$this->etlLog($logFile,"无法清除临时文件 {$this->etlCsvPath} 的内容");
//				return false;
//			}
//			fclose($fpcsv);
//		}else {
//			$isNewCsv = true;
//		}
//		$fpcsv = fopen($this->etlCsvPath,'a+');
//		if ($isNewCsv) {
//			chmod($this->etlCsvPath,0777);
//		}
		$fpcsv = fopen($this->etlCsvPath,'w');
		$fplog = fopen($logFile,'r');
		$headerFields = fgets($fplog); //读取第一行,表头定义
		if (1==count($headerFields) && "" === str_replace(array("\r\n", "\n", "\r"), "", $headerFields[0])){
			$this->ok = false;
			$error = "未定义表头";
			$this->mvLog($logFile, SYSDIR_GAME_LOG_ERROR.DIRECTORY_SEPARATOR.$this->serverid, $error);
			$this->etlLog($logFile, $error);
			return false;
		}
		$headerFields = $this->csv_string_to_array($headerFields);
		//去掉表头字段中的空格
		foreach ($headerFields as $key => &$fieldName) {
			$headerFields[$key] = trim($fieldName);
		}
		$line = 2; //从第二行开始算
		while ($data = fgets($fplog)) {
			if (1==count($data) && "" === str_replace(array("\r\n", "\n", "\r"), "", $data[0])) {
				$line++;
				continue;//忽略空行
			}else {
		        $data = $this->csv_string_to_array($data);
				if (count($headerFields) != count($data) ) {
					$this->ok = false;
					$error = "第{$line}行 数据列数与表头列数不相等";
					$this->mvLog($logFile, SYSDIR_GAME_LOG_ERROR.DIRECTORY_SEPARATOR.$this->serverid, $error);
					$this->etlLog($logFile, $error);
					return false;
				}
				//转换数据
				$lineData = $this->fomateData(array_combine($headerFields, $data));
				if(FALSE === fputcsv($fpcsv,$lineData)){
					$this->ok = false;
					$error = "第{$line}行的数据无法写入到临时文件 {$this->etlCsvPath}中";
					$this->mvLog($logFile, SYSDIR_GAME_LOG_ERROR.DIRECTORY_SEPARATOR.$this->serverid, $error);
					$this->etlLog($logFile, $error);
					return false;
				}
			}
			$line++;
		}
		fclose($fplog);
		fclose($fpcsv);
	}

	/**
	 * 转换数据
	 *
	 */
	public function fomateData(&$data){
		foreach ($this->fields as &$fieldsName) {
			$lineData[$fieldsName] = &$data[$fieldsName];
		}
		if($lineData['mtime'] && !empty($this->exFields)){
			foreach($this->exFields as $key => $value){
				$lineData[$key] = date($value, $lineData['mtime']);
			}
		}
		return $lineData;
	}
	
	/**
	 * 把解析的日志数据load到相对应的日志库里
	 */
	public function loadIntoDb()
	{
		$logFile = &$this->gameLog;
		if ( !$this->ok || !$logFile || !file_exists($this->etlCsvPath) || 0==filesize($this->etlCsvPath)) {//如果没有需要处理的文件,直接退出
			return false;
		}
		
		$files = "";
		foreach($this->fields as $value){
			$files .= "`".$value."`,";
		}
		foreach($this->exFields as $key => $value){
			$files .= $key.",";
		}
		if($files){
			$files = rtrim($files, ",");
		}else{
			$this->etlLog($logFile,"日志定义的入库字段为空!");
		}
//		print_r($files);exit();
		
		$sql = " LOAD DATA INFILE '{$this->etlCsvPath}' INTO TABLE `{$this->tableName}`  FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\n' ({$files})";
		try {
			$result = logQuery($sql);
			$this->mvLog($logFile, SYSDIR_GAME_LOG_OK.DIRECTORY_SEPARATOR.$this->serverid);
		}catch (Exception $ex){
		    $this->ok = false;
		    $error = "无法载入数据到表{$this->tableName},".$ex->getMessage();
			$this->mvLog($logFile, SYSDIR_GAME_LOG_ERROR.DIRECTORY_SEPARATOR.$this->serverid, $error);
			$this->etlLog($logFile, $error);
			return false;
		}

		return true;
	}
	
	/**
	 * 把接收到的csv日志数据文件直接load到相对应的日志库里
	 */
	public function loadCsvIntoDb()
	{
		$csvFile = &$this->csvFile;
		if ( !$csvFile || !file_exists($csvFile) || 0==filesize($csvFile)) {//如果没有需要处理的文件,直接退出
			return false;
		}
		
		$files = "";
		foreach($this->fields as $value){
			$files .= "`".$value."`,";
		}
		foreach($this->exFields as $key => $value){
			$files .= $key.",";
		}
		if($files){
			$files = rtrim($files, ",");
		}else{
			$this->etlLog($csvFile,"日志定义的入库字段为空!");
		}
//		print_r($files);exit();
		
		$sql = " LOAD DATA INFILE '{$this->csvFile}' INTO TABLE `{$this->tableName}`  FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\n' ({$files})";
		try {
			$result = logQuery($sql);
			$this->mvLog($csvFile, SYSDIR_GAME_LOG_OK.DIRECTORY_SEPARATOR.$this->serverid);
		}catch (Exception $ex){
		    $this->ok = false;
		    $error = "无法载入数据到表{$this->tableName},".$ex->getMessage();
			$this->mvLog($csvFile, SYSDIR_GAME_LOG_ERROR.DIRECTORY_SEPARATOR.$this->serverid, $error);
			$this->etlLog($csvFile, $error);
			return false;
		}

		return true;
	}





	//这里是加入infobright的加载
	/**
	 * 把解析的日志数据load到相对应的日志库里
	 */
	public function loadIntoIB()
	{
		$logFile = &$this->gameLog;
		if ( !$this->ok || !$logFile || !file_exists($this->etlCsvPath) || 0==filesize($this->etlCsvPath)) {//如果没有需要处理的文件,直接退出
			return false;
		}
		
		$files = "";
		foreach($this->fields as $value){
			$files .= "`".$value."`,";
		}
		foreach($this->exFields as $key => $value){
			$files .= $key.",";
		}
		if($files){
			$files = rtrim($files, ",");
		}else{
			$this->etlLog($logFile,"日志定义的入库字段为空!");
		}
//		print_r($files);exit();
		
		$sql = "load data local infile '{$this->etlCsvPath}' into table `{$this->tableName}` fields terminated by ',' optionally enclosed by '\"' lines terminated by '\n' ";
		
		try {
			// $result = logIBQuery($sql);
			global $inforbright;
			if($inforbright){
				$result = logIBQuery($sql);
				$this->mvLog($logFile, SYSDIR_GAME_LOG_OK.DIRECTORY_SEPARATOR.$this->serverid);
			}
			
		}catch (Exception $ex){
		    $this->ok = false;
		    $error = "无法载入数据到表{$this->tableName},".$ex->getMessage();
			$this->mvLog($logFile, SYSDIR_GAME_LOG_ERROR.DIRECTORY_SEPARATOR.$this->serverid, $error);
			$this->etlLog($logFile, $error);
			return false;
		}

		return true;
	}
	
	/**
	 * 把接收到的csv日志数据文件直接load到相对应的日志库里
	 */
	public function loadCsvIntoIB()
	{
		$csvFile = &$this->csvFile;
		if ( !$csvFile || !file_exists($csvFile) || 0==filesize($csvFile)) {//如果没有需要处理的文件,直接退出
			return false;
		}
		
		$files = "";
		foreach($this->fields as $value){
			$files .= "`".$value."`,";
		}
		foreach($this->exFields as $key => $value){
			$files .= $key.",";
		}
		if($files){
			$files = rtrim($files, ",");
		}else{
			$this->etlLog($csvFile,"日志定义的入库字段为空!");
		}
//		print_r($files);exit();
		
		$sql = " LOAD DATA LOCAL INFILE '{$this->csvFile}' INTO TABLE `{$this->tableName}`  FIELDS TERMINATED BY ',' optionally ENCLOSED BY '\"' LINES TERMINATED BY '\n' ";
		try {
			$result = logIBQuery($sql);
			$this->mvLog($csvFile, SYSDIR_GAME_LOG_OK.DIRECTORY_SEPARATOR.$this->serverid);
		}catch (Exception $ex){
		    $this->ok = false;
		    $error = "无法载入数据到表{$this->tableName},".$ex->getMessage();
			$this->mvLog($csvFile, SYSDIR_GAME_LOG_ERROR.DIRECTORY_SEPARATOR.$this->serverid, $error);
			$this->etlLog($csvFile, $error);
			return false;
		}

		return true;
	}
//这里结束
	
	/**
	 * 
	 * 把日志文件移动到目的路径
	 * @param 日志文件 $logFile
	 * @param 成功或失败的日志目录 $destDir
	 */
	function mvLog($logFile, $destDir, $errorMsg = "")
	{
		$this->fmkdir($destDir, $logFile);
		$baseFileName = basename($logFile);
		$destFileName = $destDir.DIRECTORY_SEPARATOR.$baseFileName;
		if ($logFile != $destFileName) { //若路径一样就无须再移动了.
			$mv = rename($logFile,$destFileName); //先移动到历史日志目录
			if (!$mv) {
				_error("{$logFile} :: 移入目录 {$destDir} 失败!");
				echo "【ERROR】{$logFile} :: 移入目录 {$destDir} 失败! \n";
				return false;
			}
			if(!$this->ok){
			    $data['table_name'] = SS($this->tableName);
			    $data['desc'] = SS($this->desc);
			    $data['reason'] = SS($errorMsg);
			    $data['path'] = $destFileName;
			    $data['mtime'] = time();
			    $sql = makeInsertSqlFromArray($data, T_LOG_ETL_ERROR);
			    GQuery($sql);
			}
		}
	}
	
	/**
	 * 
	 * 日志入库错误
	 * @param 日志文件路径 $logFile
	 * @param 出错信息 $errMsg
	 * @param 转换的状态，默认为0 $seccess
	 */
	function etlLog($logFile,$errMsg,$seccess=0)
	{
		if (!$seccess) {
			_error("{$logFile} :: 入库出错:".$errMsg);
			echo "【ERROR】{$logFile} :: 入库出错:{$errMsg}\n";
		}
		$baseFileName = basename($logFile);
		//EtlLog::replaceEtlLog($baseFileName,$seccess,SS($errMsg));
	}
	
	/**
	 * 创建文件夹
	 * @param 需要建的文件夹路径 $dirPath
	 * @param 日志文件路径 $logFile
	 * @return boolean true:创建成功,false:不需要创建或者创建失败
	 */
	function fmkdir($dirPath, $logFile){
		if(!is_dir($dirPath)){
			if(!mkdir($dirPath, 0777, 1)){
				_error("{$logFile} :: 创建目录 {$destDir} 失败!");
				die("【ERROR】{$logFile} :: 创建目录 {$destDir} 失败! \n");
			}
		}
	}
	
    function csv_string_to_array($str){
    
       $expr="/,(?=(?:[^\"]*\"[^\"]*\")*(?![^\"]*\"))/";
    
       $results=preg_split($expr,trim($str));
    
       return preg_replace("/^\"(.*)\"$/","$1",$results);
    
    }
	
}
