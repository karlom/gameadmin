<?php
/**
 * 调用方式:
 * /usr/local/php/bin/php XXX.php 表名(此文件名)
 * /usr/local/php/bin/php XXX.php 表名 /XXX/XXX.log(必须用绝对路径)
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global_for_shell.php';
include_once FILE_ETL_CONFIG.'/log_template_config.php';
include FILE_ETL_CLASS.'/LogTemplate.php';

if('on' == $allLogSwitch){
    $tableName = trim($argv[1]);
    $serverName = trim($argv[2]);
    if($tableName && isset($arrLogTplConf[$tableName])){
    	$loadServerList = getAvailableServerList();
    	if($serverName && $loadServerList[$serverName]){
    		$sid = $loadServerList[$serverName]['id'];
		    $sid = (10 > $sid) ? '0'.$sid : $sid;//设置服务器ID格式为01,02...10,11...
    		$obj = new LogTemplate($tableName, $sid);
    		
    		global $inforbright;
    		//动态建立游戏日志库的连接
    		if(!$inforbright){
    			$inforbright =  new DBInfobrightClass();
    		}
    		$config = getInfoDb($loadServerList[$serverName]);
    		$inforbright->connect($config);
    		
    		if (3==$argc) { //默认处理今天的数据
    			$obj->getExtractFile();
    			$obj->extractAndTransform();
    			$obj->loadIntoIB();
    		}elseif (4==$argc) { //指定日志文件名
    			$fileName = trim($argv[3]);
    			$obj->getExtractFile($fileName);
    			$obj->extractAndTransform();
    			$obj->loadIntoIB();
    		}else {
    			echo "params error!\n";
    		}
    	} else {
	    	foreach ($loadServerList as $k => $v){
	    	    $v['serverid'] = (10 > $v['id']) ? '0'.$v['id'] : $v['id'];//设置服务器ID格式为01,02...10,11...
	    		$obj = new LogTemplate($tableName, $v['serverid']);
	    		
	    		global $inforbright;
	    		//动态建立游戏日志库的连接
	    		if(!$inforbright){
	    			$inforbright =  new DBInfobrightClass();
	    		}
	//    		$loadServerList = getAvailableServerList();
	    		$config = getInfoDb($loadServerList[$k]);
                
                if($config['dbname'] == 'D3_qq_S40023'){
                    global $ibconfig;
                    $ibconfig = $config;
                    $inforbright->connect($config);
                    
                    if (2==$argc) { //默认处理今天的数据
                        $obj->getExtractFile();
                        $obj->extractAndTransform();
                        $obj->loadIntoIB();
                    }elseif (3==$argc) { //指定日志文件名
                        $fileName = trim($argv[2]);
                        $obj->getExtractFile($fileName);
                        $obj->extractAndTransform();
                        $obj->loadIntoIB();
                    }else {
                        echo "params error!\n";
                    }
                }
	    		
	    		
	    	}//for
    	}//if
    }else{
    	echo "Table name is null or not exist!";
    }
}else{
    echo "All log switch is {$allLogSwitch}";
}
//echo("done the file -> etl -> db\n");