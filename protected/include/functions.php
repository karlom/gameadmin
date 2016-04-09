<?php
//include_once SYSDIR_ADMIN_CLASS."/sql_select_class.php";
//include_once SYSDIR_ADMIN_CLASS."/sql_func_helper_class.php";
//include_once SYSDIR_ADMIN_INCLUDE."/db_functions.php";


/**
 * 
 * 左边的菜单权限检查
 * @param $config
 */
function page_structure($config) {
	global $auth;
	$struct = array ();
	$classes = array ();
	foreach ( $config as $pid => $page ) {
		if($page['ver'] == ''){
			$page['ver'] = 'default';
		}
//		echo($_SESSION['adminver']."<br/>");
		if ($page ['hide'] || ($page['ver'] != $_SESSION['adminver'] && $page['ver'] != 'default')) { //如果是隐藏的菜单（只有权限，没菜单），版本号不对应，直接忽略
			continue;
		}
		$url = $page ['url'];
		if ($auth->assertModuleIDAccess ( $pid, false )) {
			if ($class = $page ['class']) {
				if (! isset ( $classes [$class] )) {
					$classes [$class] = count ( $struct );
					$struct [$classes [$class]] ['name'] = $class;
				}
				$struct [$classes [$class]] ['pages'] [$pid] = $page;
			}
		}
	}
	return $struct;
}
/**
 *ip字符串转为数字类型
 *
 * @param string $ip_str 如：192.168.0.1
 *
 */
function myip2long($ip_str) {
	$ip_str = empty ( $ip_str ) ? 0 : $ip_str;
	$ip_num = ip2long ( $ip_str );
	$ip_num = sprintf ( "%u", $ip_num );
	return $ip_num;
}
/**
 * 渲染smarty模版
 *
 * @param string $templatePath
 * @param array $data
 */
function render($templatePath, $data = array()) {
	global $smarty;
	$smarty->assign ( $data );
	$smarty->display ( $templatePath );
}

function getUrlParam($name = 'pid') {
	$v = intval ( $_POST [$name] );
	$v = ($v < 1) ? 1 : $v;
	return $v;
}

//获得GET方式发送的参数
function getGetUrlParam($name = 'pid') {
	$v = intval ( $_GET [$name] );
	$v = ($v < 1) ? 1 : $v;
	return $v;
}
/**
 * 验证用户名是否合法
 * @param $username
 *
 * @return true | $errorMsg
 */
function validUsername($username) {
	global $lang;
	
	$username = trim ( $username );
	if ($username == '') {
		return $lang->verify->username.$lang->verify->isNotNull;
	}
	if (preg_match ( "/^[\x{4e00}-\x{9fa5}0-9a-zA-Z_]+$/u", $username ) == 0) {
		return $lang->verify->username.$lang->verify->nameOfRule;
	}
	return true;
}

function validChinese($str) {
	$str = trim ( $str );
	if (preg_match ( "/^[\x{4e00}-\x{9fa5}]+$/u", $str ) == 0) {
		return false;
	}
	return true;
}

/**
 * 验证密码是否合法
 * @param $password
 *
 * @return true | $errorMsg
 */
function validPassword($password) {
	global $lang;
	
	$username = trim ( $password );
	if ($username == '') {
		return $lang->verify->password.$lang->verify->isNotNull;
	}
	if (preg_match ( "/^[0-9a-zA-Z_]+$/u", $password ) == 0) {
		return $lang->verify->password.$lang->verify->nameOfRule;
	}
	return true;
}

function validUrlname($url) {
        global $lang;

        $username = trim ( $url );
        if ($url == '') {
                return $lang->verify->urlname.$lang->verify->isNotNull;
        }
        if (preg_match ( "/http:\/\/[0-9a-zA-Z_]+\.[0-9a-zA-Z_]+\.[0-9a-zA-Z_]+/", $url ) == 0) {
                return $lang->verify->urlname.$lang->verify->nameOfRule;
        }
        return true;
}
function validAdminname($adminname) {
        global $lang;

        $adminname = trim ( $adminname );
        if ($adminname == '') {
                return $lang->verify->adminname.$lang->verify->isNotNull;
        }
        if (preg_match ( "/^[\x{4e00}-\x{9fa5}0-9a-zA-Z_-]+$/u", $adminname ) == 0) {
                return $lang->verify->adminname.$lang->verify->nameOfRule;
        }
        return true;
}

//测试某个字符是属于哪一类. 
function charMode($ch) {
	$asii = ord ( $ch );
	if ($asii >= 48 && $asii <= 57) //数字 
		return 1;
	if ($asii >= 65 && $asii <= 90) //大写字母 
		return 2;
	if ($asii >= 97 && $asii <= 122) //小写 
		return 4;
	else
		return 8; //特殊字符 
}

//计算出当前密码当中一共有多少种模式 
function bitTotal($num) {
	$modes = 0;
	for($i = 0; $i < 4; $i ++) {
		if ($num & 1) {
			$modes ++;
		}
		$num >>= 1;
	}
	return $modes;
}

//返回密码的强度级别 0=太短 ,1=弱 , 2=一般, 3=很好,4=极佳
function checkPasswdRate($passwd) {
	$len = strlen ( $passwd );
	if ($len < 8) {
		return 0; //密码太短 
	}
	$modes = 0;
	for($i = 0; $i < $len; $i ++) {
		//测试每一个字符的类别并统计一共有多少种模式. 
		$modes |= charMode ( $passwd {$i} );
	}
	return bitTotal ( $modes );
}

/**
 * SQL的参数值的安全过滤
 * 所有SQL语句的参数，都必须用这个函数处理一下。目的：防SQL注入攻击!!
 * @param $name
 */
function SS($name) {
	return mysql_real_escape_string ( trim ( $name ) );
}

///日期的常用操作方法
/**
 * 返回当前天0时0分0秒的时间
 * @param $outstring	是否返回字符串类型，默认为false
 * 如果$outstring为true则返回该时间的字符串形式，否则为时间戳
 */
function GetTime_Today0($outstring = false) {
	$str_today0 = strftime ( "%Y-%m-%d", time () );
	$result = strtotime ( $str_today0 );
	if ($outstring)
		return strftime ( "%Y-%m-%d %H:%M:%S", $result );
	else
		return $result;
}

function GetTimeString($srcTimeStamp) {
	return strftime ( "%Y-%m-%d %H:%M:%S", $srcTimeStamp );
}

function GetDayString($srcTimeStamp) {
	return strftime ( "%Y-%m-%d", $srcTimeStamp );
}

function GetTodayString() {
	return strftime ( "%Y-%m-%d" );
}

function GetCurTimeString() {
	return strftime ( "%Y-%m-%d %H:%M:%S" );
}

function GetIP() {
	if (! empty ( $_SERVER ["HTTP_CLIENT_IP"] ))
		$cip = $_SERVER ["HTTP_CLIENT_IP"];
	else if (! empty ( $_SERVER ["HTTP_X_FORWARDED_FOR"] ))
		$cip = $_SERVER ["HTTP_X_FORWARDED_FOR"];
	else if (! empty ( $_SERVER ["REMOTE_ADDR"] ))
		$cip = $_SERVER ["REMOTE_ADDR"];
	else
		$cip = "";
	return $cip;
}

/**
 * curl方式 post数据
 *
 * @param mix $data
 * @param string $url 全路径,如: http://127.0.0.1:8000/test
 */
function curlPost($url, $params) {
	if (! trim ( $params )) {
		return false;
	}
	$ch = curl_init ();
	curl_setopt ( $ch, CURLOPT_URL, $url );
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt ( $ch, CURLOPT_POST, 1 );
	curl_setopt ( $ch, CURLOPT_POSTFIELDS, $params );
	$result = curl_exec ( $ch );
	curl_close ( $ch );
	//	file_put_contents('/tmp/curl.log','params='.$params."\n url=".$url."\n result=".print_r($result,true)."\n",FILE_APPEND);
	return $result;
}

/**
 * 银两单位转换（文->锭、两、文）
 *
 * @param integer $wen
 * @return string
 */
function silverUnitConvert($wen) {
	global $lang;
	
	$ding = intval ( $wen / 10000 ); //10000文 = 1锭
	$wen -= $ding * 10000;
	$liang = intval ( $wen / 100 ); //100文 = 1两
	$wen -= $liang * 100;
	$str = $ding ? $ding . $lang->currency->ding : '';
	$str .= $liang ? $liang . $lang->currency->liang : '';
	$str .= $wen ? $wen . $lang->currency->wen : '';
	return ! $ding && ! $liang && ! $wen ? '0' : $str;
}
/*
 *将总在线时长转为时：分：秒
 */
function TimeUnitConvert($second) {
	global $lang;
	
	$hour = intval ( $second / 3600 ); //3600s  = 1h
	$second -= $hour * 3600;
	$min = intval ( $second / 60 ); //60s = 1min
	$second -= $min * 60;
	$str = $hour ? $hour . $lang->time->hour : '';
	$str .= $min ? $min . $lang->time->minute : '';
	$str .= $second ? $second . $lang->time->seconde : '';
	return ! $hour && ! $min && ! $second ? '0' : $str;
}
/**
 * 银两单位转换（锭、两、文 -> 文）
 *
 * @param integer $ding
 * @param integer $liang
 * @param integer $wen
 * @return integer
 */
function silverUnitConvertToWen($ding, $liang, $wen) {
	return intval ( $ding ) * 10000 + intval ( $liang ) * 100 + intval ( $wen );
}

/*
* 将字符串数据拆分
*
*/
function extractData($str, $level = 1) {
	$extr = ',';
	$extr2 = ':';
	if (empty ( $str ))
		return null;
	
	$arr = explode ( $extr, $str );
	if (sizeof ( $arr ) <= 0)
		return null;
	
	$result = null;
	if ($level == 1) {
		//  "F:1000,W:800"  拆分成数组 F=1000; W=800;
		for($i = 0; $i < count ( $arr ); $i ++) {
			$r = explode ( $extr2, $arr [$i] );
			$result [$r [0]] = $r [1];
		}
	} else if ($level == 2) {
		//  "B:2:1,T:3:3"  拆分成数组
		for($i = 0; $i < count ( $arr ); $i ++) {
			$r = explode ( $extr2, $arr [$i] );
			$result [$i] ['k'] = $r [0];
			$result [$i] ['v1'] = $r [1];
			$result [$i] ['v2'] = $r [2];
		}
	} else if ($level == 3) {
		//  "B:2:1:4,T:3:3:5"  拆分成数组
		for($i = 0; $i < count ( $arr ); $i ++) {
			$r = explode ( $extr2, $arr [$i] );
			$result [$i] ['k'] = $r [0];
			$result [$i] ['v1'] = $r [1];
			$result [$i] ['v2'] = $r [2];
			$result [$i] ['v3'] = $r [3];
		}
	}
	return $result;
}

/*
* 将数组，组合合并为字符串格式
*/
function combineData($arr, $level = 1, $key = null) {
	if (! is_array ( $arr ))
		return '';
	
	if ($level == 1) {
		$str = '';
		foreach ( $arr as $k => $v )
			$str .= "{$k}:{$v},";
		$str = trim ( $str, ',' );
		return $str;
	}
	
	if ($level == 2) {
		if (empty ( $key ))
			return false;
		
		$str = '';
		foreach ( $arr as $k => $v )
			if ($v > 0 && $k > 0)
				$str .= "{$key}:{$k}:{$v},";
		
		$str = trim ( $str, ',' );
		return $str;
	}
}

function isPost() {
	return (strtolower ( $_SERVER ['REQUEST_METHOD'] ) == 'post');
}

function isGet() {
	return (strtolower ( $_SERVER ['REQUEST_METHOD'] ) == 'get');
}

function validateUserName($str) {
	//首字符为字母, 数字或者汉字, 总长度限制, 汉字最多5个, 其他只能是字母或数字
	$str = trim ( $str );
	
	$re = '/^(?i)(?:[\x{4e00}-\x{9fa5}]?[A-Z0-9]*){2,' . MAX_CN_UNAME_LENGTH . '}$/u';
	
	if (preg_match ( $re, $str ))
		return mb_strlen ( $str, 'UTF-8' ) >= MIN_UNAME_LENGTH && mb_strlen ( $str, 'UTF-8' ) <= MAX_UNAME_LENGTH;
	else {
		return false;
	}
}

/**
 * 用于调式
 *
 * @param mix $mix
 * @param bool $dumpAll 是否打印出变量类型
 */
function _debug($mix) {
	if (LOG_LEVEL <= 1) {
		$header = 'DEBUG';
		_dumpLogMsg ( $header, $mix );
	}
}

/**
 * 用于记录正常运行日志
 *
 * @param mix $mix
 * @param bool $dumpAll 是否打印出变量类型
 */
function _info($mix) {
	if (LOG_LEVEL <= 2) {
		$header = 'INFO';
		_dumpLogMsg ( $header, $mix );
	}
}

/**
 * 用于记录错误日志
 *
 * @param mix $mix
 * @param bool $dumpAll 是否打印出变量类型
 */
function _error($mix) {
	if (LOG_LEVEL <= 3) {
		$header = 'ERROR';
		_dumpLogMsg ( $header, $mix );
	}
}
/**
 * 将日志写入到文件中
 *
 * @param minx $mix
 * @param string $logFile
 * @param bool $dumpAll
 */
function _dumpLogMsg($header, $mix) {
	$log = print_r ( $mix, true );
	$trace = array_pop ( debug_backtrace () );
	//	$file = trim($trace['file'],SYSDIR_ADMIN);
	$file = &$trace ['file'];
	$time = date ( 'Y-m-d H:i:s' );
	$str = "【{$header}】 | {$time} | {$file} | {$trace['line']} :\r\n{$log}\r\n";
	file_put_contents ( SYSFILE_LOG_FILE, $str, FILE_APPEND );
}

/*
* 将秒数，转换成中文表达方法，比如： 2分14秒，  3小时5分56秒
*/
function ConvertSecondToChinese($time) {
	global $lang;
	
	if ($time <= 60)
		return $time . $lang->time->seconde;
	else if ($time <= 3600)
		return floor ( $time / 60 ) . $lang->time->minute . ($time % 60) . $lang->time->seconde;
	else if ($time <= 86400)
		return floor ( $time / 3600 ) . $lang->time->hour . floor ( ($time % 3600) / 60 ) . $lang->time->minute . ($time % 60) . $lang->time->seconde;
	else
		return floor ( $time / 86400 ) . '天' . floor ( ($time % 86400) / 3600 ) . $lang->time->hour . floor ( ($time % 3600) / 60 ) . $lang->time->minute . ($time % 60) . $lang->time->seconde;
}
function sizecount($size) {
	if ($size >= 1073741824) {
		$size = round ( $size / 1073741824 * 100 ) / 100 . ' GB';
	} elseif ($size >= 1048576) {
		$size = round ( $size / 1048576 * 100 ) / 100 . ' MB';
	} elseif ($size >= 1024) {
		$size = round ( $size / 1024 * 100 ) / 100 . ' KB';
	} else {
		$size = $size . ' Bytes';
	}
	return $size;
}
/*
 * 判断是否允许用户的IP访问，如果没有禁止的IP的话就是允许所有IP访问，可以填写完整的IP也可以填写前三个，但是要填三个'.',例如：192.168.1.
 */
function canLoginIp(){
//如果没有填的话就全部IP都可以访问
	$count = IFetchRowOne("select count(*) as record from ".T_IP_ACCESS.";");
	if($count[record] == 0){
		return true;
	}
	$userip = GetIP();
	$likeip = substr($userip,0,strrpos($userip,'.'));
	$sql = "SELECT `ip` FROM `".T_IP_ACCESS."` where `ip` like '%".$likeip."%';";
	if(!IFetchRowOne($sql)){
		return false;
	}
	return true;
}

//禁言禁登录原因
function getReason(){
	global $lang;
	
	return array(
		0 => "",
		1 => $lang->player->reason1,
		2 => $lang->player->reason2,
		3 => $lang->player->reason3,
		4 => $lang->player->reason4,
		5 => $lang->player->reason5,
		6 => $lang->player->reason6,
		7 => $lang->player->reason7,
		8 => $lang->player->reason8,
		9 => $lang->player->reason9,
		10 => $lang->player->reason10,
	);
}

//禁言禁登录时间
function getBanTime(){
	global $lang;
	
    return array(
        1 => $lang->player->banTime1,
        1440 => $lang->player->banTime2,
        2880 => $lang->player->banTime3,
        4320 => $lang->player->banTime4,
        10080 => $lang->player->banTime5,
        9999999 => $lang->player->banTime6
    );
}
//为了安全，过滤掉字符串的某些特殊符号。///
function protectTrim($val , $trim_string=""){
    if (empty($trim_string)){
        $trim_string = "'\",.- <>\\/;:[]{}=+`~!#$%^*()?|";
    }
        $tok = strtok($val, $trim_string);
    while ($tok) {
        $str .= $tok;
        $tok = strtok($trim_string);
    }
        return $str;
}
function getLogDb($serverCFG){
	$conf = array();
	$conf['host'] = $serverCFG['ip'];
	$conf['user'] = $serverCFG['dbuser'];
	$conf['passwd'] = $serverCFG['dbpwd'];
	$conf['dbname'] = $serverCFG['dbname'];
	return $conf;
}

function getInfoDb($serverCFG){
	$conf = array();
	$conf['host'] = '127.0.0.1:3307';
	$conf['user'] = $serverCFG['dbuser'];
	$conf['passwd'] = $serverCFG['dbpwd'];
	$conf['dbname'] = $serverCFG['dbname'];
	return $conf;
}

/**
 * 输入参数，获取Http请求的结果
 * @param string $api 接口名称 
 * @param array $params 接口参数
 * @param string $method 通过POST OR GET访问,默认GET
 * @param array $timeout 超时时间,默认60秒
 * @return 
 */
function httpRequest($api, $params="", $method='GET', $timeout='60'){
    global $serverList;
	
	$server = $_SESSION['gameAdminServer'];
	if("" == $server || !isset($serverList[$server])){
	    echo 'Unkown server';
		return false;
	}
	
	return httpRequestResult($server, $api, $params, $method, $timeout);
}

/**
 * 封装http头的,用post或get方式发送参数获取远程结果
 *
 * @param unknown_type $get_url
 * @param unknown_type $method
 *  @param unknown_type $method
 * @return unknown
 */

function getUrlFileContents($get_url,$method='GET',$timeout='60') {
	$opts = array(
		'http'=>array(
			'method'=>$method,
			'timeout'=>$timeout,
		)
	);
	$context = stream_context_create($opts);
//	$content = @file_get_contents($get_url, false, $context);
	$ch = curl_init();//	curl方式发起http请求
	curl_setopt($ch, CURLOPT_URL, $get_url);
	curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	curl_setopt($ch, CURLOPT_USERAGENT, _USERAGENT_);
	curl_setopt($ch, CURLOPT_REFERER,_REFERER_);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$content = curl_exec($ch);
	curl_close($ch);
	if( !$content )
	{
		return json_encode( array("result" => 0, "errorMsg" => "$get_url not reachable") );
	}
	return $content;
}

/*
 * 生成这样子的SQL字符串
 *    `aaa` = '1' OR `aaa` = '2' OR ....
 */
function makeOrSqlFromArray($filed, $arr) {
	$str = '';
	if (is_array($arr))
		foreach ($arr as $k => $v) {
			if (empty ($str))
				$str = "( `{$filed}`='{$k}'";
			else
				$str .= " OR `{$filed}`='{$k}'";
		}
	return $str . ') ';
}

/*
 * 由数组构造出SQL语句，用于更新数据回数据库，即UPDATE
 */
function makeUpdateSqlFromArray($arr, $table, $key = 'id') {
	$str = '';
	foreach ($arr as $k => $v) {
		if ($k != $key)
			$str .= "`{$k}`='{$v}',";
		else
			$where = " WHERE `{$key}`='{$v}' LIMIT 1";
	}

	$str = "UPDATE `{$table}` SET " . trim($str, ', ') . $where;

	//if (ODINXU_DEBUG) echo $str ."\r\n";
	return $str;
}

/*
 * 由数组构造出SQL语句，用于添加数据到数据库，即INSERT
 */
function makeInsertSqlFromArray($arr, $table, $option="insert") {
	if("INSERT" == strtoupper($option) || "REPLACE" == strtoupper($option)){
		$str1 = '';
		$str2 = '';
		foreach ($arr as $k => $v) {
			$str1 .= "`{$k}`,";
			$str2 .= "'{$v}',";
		}
	
		$str = "{$option} INTO {$table} (" . trim($str1, ', ') . ") VALUES (" . trim($str2, ', ') . ")";
		return $str;
	}else{
		return "";
	}
}

/*
 * 由数组构造出SQL语句，用于条件查询，用来检查刚刚INSERT的数据。
 */
function makeSelectIdWhereSqlFromArray($arr, $table, $key = 'id') {
	$where = '';
	foreach ($arr as $k => $v) {
		if ($k != $key)
			$where .= "`{$k}`='{$v}' AND ";
	}

	$str = "SELECT `{$key}` FROM `{$table}` WHERE " . substr($where, 0, strlen($where) - 4);
	return $str;
}

function makeDuplicateInsertSqlFromArray($arr, $table) {
	$str1 = '';
	$str2 = '';
	$update = '';
	foreach ( $arr as $k => $v ) {
		$str1 .= "`{$k}`,";
		$str2 .= "'{$v}',";
		$update .= "`$k` = '$v',";
	}
	$sql = "INSERT INTO `{$table}` (" . trim ( $str1, ', ' ) . ") VALUES (" . trim ( $str2, ', ' ) . ") ON DUPLICATE KEY UPDATE " . trim ( $update, "," );
	return $sql;
}

/**
 * Mysql抛出异常处理方法,如果是正常运行模式则不抛出SQL错误,如果是开发模式则抛出SQL错误
 * @param String $description 出错的描述
 * @param String $sql 执行的SQL
 */
function mysqlException($description, $sql=""){
	if(2 == SERVER_RUN_MODE){
		throw new Exception("{$description}:" . $sql . "   " . mysql_error());
		return false;
	}else{
		die( $description );
	}
}

/**
 * 根据功能设置的接口方法自动调用相应类型的接口(http,socket)
 * @param string $api 接口API,只有http和socket两种方式
 * @param array $data 参数
 * @param String $method 这个参数只用在HTTP请求,默认是GET
 * @param int $timeout 这个参数只用在HTTP请求,默认是60
 * @return array 返回执行结果数组
 */
function interfaceRequest($api, $params=array(), $method='GET', $timeout='60', $server=''){
	//new dBug($params);
	global $INTAERFACE, $lang, $serverList;
	if("" == $server){
	    $server = $_SESSION['gameAdminServer'];
	}
	if("" == $server || !isset($serverList[$server])){
		$result = array("result" => 0, "errorMsg" => "serverid is null");
	}else{
		$result = socketRequestResult($server, $api, $params);
		/*if("socket" == $INTAERFACE){//socket请求方式
	    	$result = socketRequestResult($server, $api, $params);
	    }else if("http" == $INTAERFACE){//http请求方式
	    	$result = httpRequestResult($server, $api, $params, $method, $timeout);
	    }else{
	    	$result = array("result" => 0, "errorMsg" => $lang->msg->interfaceError);
	    }*/
	}
    return $result;
}

/**
 * 输入参数，获取Http请求的结果,写这个方法的原因是有可以让Crontab或者其它地方所调用必须转入severid
 * @param string $server 服务器ID 
 * @param string $api 接口名称 
 * @param array $params 接口参数
 * @param string $method 通过POST OR GET访问,默认GET
 * @param array $timeout 超时时间,默认60秒
 * @return array
 */
function httpRequestResult($server, $api, $params="", $method='GET', $timeout='60'){
    global $serverList;
    
    includeInterfaceConfig();
	if(!isset($GAME_HTTP_API[$api])){
		$result = array("result" => 0, "errorMsg" => "HTTP API {$api} not exists");
		return $result;
	}
	if(!isset($GAME_HTTP_API[$api]['api_path']) || "" == $GAME_HTTP_API[$api]['api_path']){
		$result = array("result" => 0, "errorMsg" => "HTTP API {$api} path not exists");
		return $result;
	}
	
	if (empty($api)) {
		$result = array("result" => 0, "errorMsg" => "Empty api");
		return $result;
	}

	$serverUrl = $serverList[$server]['url'].":".$serverList[$server]['port'].$GAME_HTTP_API[$api]['api_path'];
	//$serverUrl = "http://192.168.22.11".":".$serverList[$server]['port'].$GAME_HTTP_API[$api]['api_path'];
	//MD5(KEY + ServerID + API + TimeStamp)
	$sign = md5($serverList[$server]['md5'].getServerId($server).$api.NOW_TIMESTAMP);
	
	$paramStr = "?sign={$sign}&method={$api}&unixTime=".NOW_TIMESTAMP;
	if(is_array($params) && 0 < count($params)){
		foreach($params as $key => $value){
//			if(function_exists("addPrefix")){
//				$value = addPrefix($server, $key, $value);
//			}
			$paramStr .= "&".$key."=".urlencode($value);
			//$paramStr .= "&".$key."=".$value; //调试用
		}
	}
//echo $serverUrl.$paramStr;die(); //测试用于打印http请求地址
	$result = json_decode(getUrlFileContents($serverUrl.$paramStr, $method, $timeout), true);
	
//	if($result['data']){
//		if(function_exists("delPrefix")){
//			foreach($result['data'] as $key => &$value){
//				$value = delPrefix($server, $key, $value);
//			}
//		}
//	}
    return $result;
}

/**
 * 输入参数，获取Socket请求的结果,写这个方法的原因是有可以让Crontab或者其它地方所调用必须转入severid
 * @param string $server 服务器ID 
 * @param string $api 接口名称 
 * @param array $params 接口参数
 * @return array
 */
function socketRequestResult($server, $api, $params=array()){
    global $serverList;

    //new dBug($params);
//	includeInterfaceConfig();
	
	
	$params['method'] = $api;
	
	//去掉转义，json_encode会自动添加转义。如不去掉，则会双重转义，游戏显示会有问题。
	//注意转换后的数据类型
	foreach($params as $k => &$v) {
		if(is_string($v)){
			$v = stripslashes($v);
		}
	}
//	var_dump($params);
	$serverIP = substr($serverList[$server]['url'],7);	//删除前面
	$serverIP = rtrim($serverIP, "/");
	$n = strpos($serverIP,':');
	if($n) {
		$serverIP=substr($serverIP,0,$n);	//删除后面
	}
	
	$serverPort = $serverList[$server]['port'];

	include_once(SYSDIR_ADMIN_CLASS.'/SocketClient.php');
	//new dBug("ip:".$serverIP."     port:".$serverPort);
	$socket = new SocketClient($serverIP,$serverPort);
	//new dBug($params);
	$result = $socket->rpc($params);
	
	return $result;
}

/**
 * 获取socket api对应的ID
 */
//function getSocketApiId($api){	
//	return $SOCKET_API_CONFIG[$api][id];
//}

/**
 * 检查引入游戏配置文件
 */
function includeInterfaceConfig(){
	global $GAME_HTTP_API, $GAME_SOCKET_API;
	
	//加载接口配置文件
	if(file_exists(SYSDIR_ADMIN_GAME_CONFIG."/".GAME_EN_NAME."/api_config.php")){
		include_once(SYSDIR_ADMIN_GAME_CONFIG."/".GAME_EN_NAME."/api_config.php");
	}else{
	    echo "File ".SYSDIR_ADMIN_GAME_CONFIG."/".GAME_EN_NAME."/api_config.php not exists";
		return false;
	}
	//加载特殊处理方法文件
//	if(file_exists(SYSDIR_ADMIN_GAME_CONFIG."/".GAME_EN_NAME."/game_function.php")){
//		include_once(SYSDIR_ADMIN_GAME_CONFIG."/".GAME_EN_NAME."/game_function.php");
//	}
}

/**
 * 更改数组的key
 * @param array $array 目标数组
 * @param array $key_map 键映射
 * 
 * @return 
 * 
 */
function array_change_key_to(&$array, $key_map)
{
	foreach ($array as $key => $item)
	{
		if ( array_key_exists( $key, $key_map ) )
		{
			$array[ $key_map[ $key ] ] = $item;
			unset($array[ $key ]);
		}
	}
}

function cleanQueryString($ref, $params = NULL)
{
	$newparams = array();
	preg_match_all('|([^?&#=]+)=([^?&#=]+)(#{0,}[^?&#=]*)|', $ref, $out, PREG_SET_ORDER);
	$url_path = parse_url( $ref, PHP_URL_PATH );
        
	foreach($out as $elem)
	{
 		if(!in_array($elem[1], $params))
 		{
 			$newparams[] = "{$elem[1]}={$elem[2]}";
 		}  
	}
	return $url_path . '?' . implode('&',$newparams) . $out[count($out)-1][3];        
}

function groupByIndexValue( $list, $index )
{
	$groupBy = array();
	if(is_array( $list ))
	{
		foreach ( $list as $key => $item )
		{
			$value = $item[ $index ];
			if( !is_array( $groupBy[$value] ) )
			{
				$groupBy[$value] = array();
			}
			$groupBy[$value][] = $item;
		}
	}
	return $groupBy;
}


function dieJsonMsg($resultCode, $errorMsg)
{
	$result = array(
		'result' => $resultCode,
		'errorMsg' => $errorMsg,
	);
	echo decodeUnicode(json_encode($result));
	die();
}

function getPrefix(){
    $file = SYSDIR_ADMIN_GAME_CONFIG.'/'.GAME_EN_NAME.'/game_function.php';
    if(file_exists($file)){
    	include_once($file);
        if(function_exists('addPrefixStr')){
            return addPrefixStr($_SESSION['gameAdminServer']);
        }else{
            return "";
        }
    }
    return "";
}

function removePrefix($str){
    $file = SYSDIR_ADMIN_GAME_CONFIG.'/'.GAME_EN_NAME.'/game_function.php';
    if(file_exists($file)){
        include_once $file;
        if(function_exists('delPrefix2')){
            return delPrefix2($_SESSION['gameAdminServer'], $str);
        }else{
            return $str;
        }
    }else{
        return $str;
    }
}

//获得服务器ID
function getServerId($server = ''){
    $file = SYSDIR_ADMIN_GAME_CONFIG.'/'.GAME_EN_NAME.'/game_function.php';
    if('' == $server){
        $server = $_SESSION['gameAdminServer'];
    }
    $server = ltrim($server, "s");
    if(file_exists($file)){
        include_once $file;
        if(function_exists('addPrefixStr')){
            return addPrefixStr($server);
        }else{
            return $server;
        }
    }
    return $server;
}

function dump( )
{
	echo '<pre>';
	foreach (func_get_args() as $arg)print_r($arg);
	echo '</pre>';
}

//把json_encode后的中文转换成中文
function decodeUnicode($str)
{
    return preg_replace_callback('/\\\\u([0-9a-f]{4})/i',
        create_function(
            '$matches',
            'return mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UCS-2BE");'
        ),
        $str);
}

/**
 * 创建文件夹
 * @param 需要建的文件夹路径 $dirPath
 * @return boolean true:创建成功,false:不需要创建或者创建失败
 */
function fmkdir($dirPath){
	if(!is_dir($dirPath)){
		if(!mkdir($dirPath, 0777, 1)){
			die("创建目录 {$dirPath} 失败! \n");
		}
	}
}
/*
function autoAddPrefix( $name )
{
	if (Validator::stringNotEmpty( $name ))
	{
		$prefix = getPrefix();
		if(strpos($name, $prefix) === 0)
		{
			return $name;
		}
		else
		{
			return $prefix . $name;
		}
	}
	else
	{
		return null;
	}
}
*/
function changeArrayBase( $array , $start )
{
	$result = array();
	foreach( $array as $item )
	{
		$result[$start] = $item;
		$start++;
	}
	return $result;
}

function getItemDetailArray( $itemDetailStr )
{
	$itemDtArr = array();
	$res = explode('|', $itemDetailStr);
	array_pop($res);//踢掉最后一个元素
	$config = array('uid', 'strengthen', 'quality', 'jinglian','showColor', 'gems',
		'craftLv','randAttrStar','vipAttrStar','xilianRandCnt','xilianVipCnt','refineCaiCnt','refineJingCnt','refineCnt','refineTongCnt','gem2ID',);
	foreach($config as $key => $attr)
	{
		$itemDtArr[$attr] = $res[$key];
	}
	$gems = $itemDtArr['gems'] ? explode(':', $itemDtArr['gems']) : array();
	$itemDtArr['gems'] = $gems;
	return $itemDtArr;
}
/**
 * 道具解析：id1*num*bind[*detail] $ id2*num*bind[*detail] $ ...
 * @author Libiao
 * 2013-4-27
 */
function decodeItems($itemsString) {
	$items = explode('$',$itemsString);
	array_pop($items);//踢掉最后一个元素
	$config = array('id', 'num', 'isBind','detail');
	foreach ( $items as $key => $itemStr ) {
       $dt = explode('*',$itemStr);
		foreach ( $config as $k => $a ) {
			$item[$a] = $dt[$k];
		}
		if (!empty($item['detail'])) {
			$item['detail'] = getItemDetailArray($item['detail']);
		}
		$items[$key] = $item;
	}
	return $items;
}

/**
 * 道具数组转字符串 
 * items_array(0=>item_arr1,1=>item_arr2,...) => 0：id:11,数量:22,绑定:是,uid:xxxx,强化:5,...
 * or
 * detail_array("uid"=>1,"strengthen"=>2,...) => uid:xxxx,强化:10,...
 * @author libiao
 * 2013-4-28
 */
function itemsArrayToString($dataArray, $type="", $all="") {
	global $arrItemsAll,$dictColor;
	
	if($type == "detail" && is_array($dataArray)){
		//装备详情
		$uid = "uid:".$dataArray['uid'].",";
		$strengthen = "强化:".$dataArray['strengthen'].",";
		$quality = "品质:".$dataArray['quality'].",";
		$jinglian = "精炼:".$dataArray['jinglian'].",";
		$showColor = "颜色:".$dictColor[$dataArray['showColor']];
		if($dataArray['gems'][0] || $dataArray['gems'][1]) {
			$gems = ",孔1:".$arrItemsAll[$dataArray['gems'][0]]['name'].",孔2:".$arrItemsAll[$dataArray['gems'][1]]['name'];
		}
		if($all == "all"){
			$otherAttr = ",打造工匠等级:".$dataArray['craftLv']."";
			$otherAttr .= "附加属性星级:".$dataArray['randAttrStar'].",";
			$otherAttr .= "vip属性星级:".$dataArray['vipAttrStar'].",";
			$otherAttr .= "随机属性洗炼次数:".$dataArray['xilianRandCnt'].",";
			$otherAttr .= "vip属性洗炼次数:".$dataArray['xilianVipCnt'].",";
			$otherAttr .= "精炼彩星个数:".$dataArray['refineCaiCnt'].",";
			$otherAttr .= "精炼金星个数:".$dataArray['refineJingCnt'].",";
			$otherAttr .= "精炼银星个数:".$dataArray['refineCnt'].",";
			$otherAttr .= "精炼铜星个数:".$dataArray['refineTongCnt'].",";
			$otherAttr .= "镶嵌圣纹ID:".$dataArray['gem2ID'];
		}
		$detailStr = "[".$uid.$strengthen.$quality.$jinglian.$showColor.$gems.$otherAttr."]";
		
		return $detailStr;
	}
	
	$itemsStr = "";
	foreach($dataArray as $key => $value) {
		$index = "<font size='2' color='blue'>".($key+1)."</font>";
		$id = "道具:".$arrItemsAll[$value['id']]['name'].", ";
		$num = "数量:".$value['num'].", ";
		$isBind = $value['isBind']?"绑定:是,":"绑定:否, ";
		$dt = $value['detail'];
		$detailStr = "";

		if(is_array($dt)) {
			//装备详情
			$uid = "uid:".$dt['uid'].",";
			$strengthen = "强化:".$dt['strengthen'].",";
			$quality = "品质:".$dt['quality'].",";
			$jinglian = "精炼:".$dt['jinglian'].",";;
			$showColor = "颜色:".$dictColor[$dt['showColor']];
			if($dt['gems'][0] || $dt['gems'][1]) {
				$gems = ",孔1:".$arrItemsAll[$dt['gems'][0]]['name'].",孔2:".$arrItemsAll[$dt['gems'][1]]['name'];
			}
			
			if($all == "all"){
				$otherAttr = ",打造工匠等级:".$dataArray['craftLv']."";
				$otherAttr .= "附加属性星级:".$dataArray['randAttrStar'].",";
				$otherAttr .= "vip属性星级:".$dataArray['vipAttrStar'].",";
				$otherAttr .= "随机属性洗炼次数:".$dataArray['xilianRandCnt'].",";
				$otherAttr .= "vip属性洗炼次数:".$dataArray['xilianVipCnt'].",";
				$otherAttr .= "精炼彩星个数:".$dataArray['refineCaiCnt'].",";
				$otherAttr .= "精炼金星个数:".$dataArray['refineJingCnt'].",";
				$otherAttr .= "精炼银星个数:".$dataArray['refineCnt'].",";
				$otherAttr .= "精炼铜星个数:".$dataArray['refineTongCnt'].",";
				$otherAttr .= "镶嵌圣纹ID:".$dataArray['gem2ID'];
			}
			$detailStr = "[".$uid.$strengthen.$quality.$jinglian.$showColor.$gems.$otherAttr."]";
		}
		
		if($value['id'] == 10006) {
			//元宝记红色
			$itemsStr .= $index . "：<font color='red'>" . $id . $num . $isBind . $detailStr . "</font><br />";
		}else {
			$itemsStr .= $index . "：" . $id . $num . $isBind . $detailStr . "<br />";
		}
	}
	
	return $itemsStr;
}

/**
 * 
 * 返回第一个存在的值
 * $a = first_set($var1, $var2, $var3, ...);
 * 从左到右，返回第一个不为null的变量的值
 */
function first_set()
{
	foreach(func_get_args() as $arg)
	{
		if( $arg !== null)
		{
			return $arg;
		}
	}
}

function cond()
{
	$args = func_get_args();
	
}

/**
 * 对二维数组按提供的键值进行排序
 * @param array $array 目标数组
 * @param array $key 指定的键名
 * @param array $order 排序
 * 
 * @return 
 * 
 */
function sortArrayByKey($array, $sortKey, $order = 'asc')
{
	$mapping = array();
	foreach($array as $key => $item)
	{
		$mapping[$key] = $item[$sortKey];
	}
	if($order == 'asc')
		asort($mapping);
	else
		arsort($mapping);
	$result = array();
	foreach($mapping as $key => $sort)
	{
		$result[$key] = $array[$key];
	}
	return $result;
}


/**
 * 过滤空格，制表符，回车
 *
 */

function deleteSpaceTabEnter($str){
	$str = trim($str);
	$str = str_replace("\t", "", $str);
	$str = str_replace("\r\n", "", $str);
	$str = str_replace("\r", "", $str);
	$str = str_replace("\n", "", $str);
	$str = str_replace(" ", "", $str);
	return $str;
}

/**
 * 获取指定日期所在星期的所有日期。
 * 如果指定日期所在星期未过完，则返回已经过去的日期
 * @param string date 格式："YYYY-MM-DD"
 * @return array array("2013-06-23","2013-06-24","2013-06-25","2013-06-26",)
 * @author Libiao
 */
function getWeekDays($date){
	$days = array();
	
	$today = date('Y-m-d');
	$todayStartTime = strtotime($today." 00:00:00 ");
	$todayEndTime = strtotime($today." 23:59:59 ");
	
	$dateTime = strtotime($date);
	
	$week = date("w",$dateTime); //星期几 0-6
	
	$firstDayTime = $dateTime - $week*86400;
	
	for($i=0;$i<7;$i++) {
		$dayTime = $firstDayTime + $i*86400;
		if( $dayTime > $todayEndTime){
			break;
		}
		$days[$i] = date('Y-m-d',$dayTime);
	}
	
	return $days;
}

/**
 * 从字符串中删除html标签
 * $str = '<div><a>abcde</a></div>';
 * removeHtmlLable($str, "a") -> '<div>abcde</div>'
 * @author Libiao
 */
function removeHtmlLable($str, $label){
	return preg_replace("/<(\/?$label.*?)>/si","",$str);
}

/**
 * 从字符串中去除最外层html标签
 * 普通字符串按原样返回
 * removeOuterHtmlLable('<div><a>abcde</a></div>') -> '<a>abcde</a>'
 * @author Libiao
 */
function removeOuterHtmlLable($str){
	//找第一个'>' 的位置
	$offset1 = strpos($str,'>',1);
	$offset1 ++;
	
	if($offset1) {
		$str = substr($str,$offset1);
	} else {
		//格式不正确，返回原字符串
		return $str;
	}
		
	//找最后一个'<' 的位置
	$offset2 = strrpos($str,'<');
	
	if($offset2) {
		$str = substr($str,0,$offset2);
	} else {
		//格式不正确，返回原字符串
		return $str;
	}
	
	return $str;
}


function getOnlineCount(){
	
    $method = 'getonlinecount';
    $result = interfaceRequest($method);
    
    $result["date"] = !empty($result['time']) ? date("Y-m-d H:i:s") : -1 ;
    
    if( $result && 1 == $result['result'] ){
    	return $result;
    } else {
    	$result['online'] = -1;
    	return $result;
    }
}

function getPayUserOnlineCount($count=true){
	
    //$result = interfaceRequest('getonlinecount');
    $result = RequestCollection::getOnlineList();
    $onlineAccount = array();
	if( is_array($result['data']) && !empty($result['data'])){
		foreach($result['data'] as $k=>$v) {
			$onlineAccount[] = $v['accountName'];
		}
	}
    unset($result);
    
    if(PROXY == 'qq'){
		$payTable = "t_log_buy_goods";
	} else {
		$payTable = "t_log_pay";
	}
    
    $sql = "select distinct account_name from  " . $payTable;
    $ret = GFetchRowSet($sql); 
    $payUserAccount = array();
    if(!empty($ret)) {
    	foreach($ret as $k=>$v){
    		$payUserAccount[] = $v['account_name'];
    	}
    }
    unset($ret);
    
    $data = array_intersect($onlineAccount,$payUserAccount);
    
    if($count) {
    	return count($data);
    } else {
    	return $data;
    }
    
}

function tsLogs($filename, $str, $mode="w") {
	$dirPath = TS_LOG_DIR.DIRECTORY_SEPARATOR;
	if(!file_exists(TS_LOG_DIR)) {
		mkdir(TS_LOG_DIR);
	}
//	if(!file_exists($dirPath)) {
//		mkdir($dirPath);
//	}
	$filepath = $dirPath.$filename;
	
	$fp = fopen($filepath, $mode);
	if($fp ) {
		if( fwrite($fp, $str) ) {
			return false;
		}
	}
	fclose($fp);
	return true;
}
