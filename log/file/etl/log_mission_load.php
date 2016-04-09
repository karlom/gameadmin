<?php
/**
 * 调用方式:
 * /usr/local/php/bin/php XXX.php(此文件名)
 * /usr/local/php/bin/php XXX.php /XXX/XXX.log(必须用绝对路径)
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global_for_shell.php';
include_once FILE_ETL_CONFIG.'/log_template_config.php';
include FILE_ETL_CLASS.'/LogMission.php';

$loadServerList = getAvailableServerList();
foreach ($loadServerList as $k => $v){
	$obj = new LogMission($k);
	if (1==$argc) { //默认处理今天的数据
		$obj->getExtractFile();
		$obj->extractAndTransform();
		$obj->loadIntoDb();
	}elseif (2==$argc) { //指定日志文件名
		$fileName = trim($argv[1]);
		$obj->getExtractFile($fileName);
		$obj->extractAndTransform();
		$obj->loadIntoDb();
	}else {
		echo "params error!\n";
	}
	
}
//echo("done the file -> etl -> db\n");
