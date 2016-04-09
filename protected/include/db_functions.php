<?php
////////////////////////////////////////////////////////////
/**
 * 获取数据库配置
 * @param string $dbName 数据库连接名称
 * @return mix 返回配置数组或False
 */
function getDBConfig($dbName){
	global $dbConfig, $serverList;

	if("db_admin" == $dbName){
		$config = $dbConfig ['game_admin'];
	}else if("server_db" == $dbName){
		$serverid = $_SESSION['gameAdminServer'];
		if(isset($serverList[$serverid])){
			$config = getLogDb($serverList[$serverid]);
		}else{
			return false;
		}
	}else{
		return false;
	}
	return $config;
}

/**
 * 获取数据仓库配置
 * @param string $dbName 数据库连接名称
 * @return mix 返回配置数组或False
 */
function getIBConfig(){
	global $serverList;
	$config[host] = '127.0.0.1:3307';
	$config[user] = $serverList[$_SESSION[gameAdminServer]][dbuser];
	$config[passwd] = $serverList[$_SESSION[gameAdminServer]][dbpwd];
	$config[dbname] = $serverList[$_SESSION[gameAdminServer]][dbname];
	return $config;
}
/**
 * 连接数据库
 * @param string $dbName 连接名称
 * @return NULL
 */
function connectDB($dbName){
	global $$dbName;
	
	if($config = getDBConfig($dbName)){
		$$dbName = new DBMysqlClass();
		$$dbName->connect($config);
		//print_r($config);die();
	}else{
		die("connectDB:获取数据库".$dbName."配置失败");
	}
}

/**
 * 连接数仓库
 * @param string $dbName 连接名称
 * @return NULL
 */
function connectIB(){
	global $inforbright;
	
	if($config = getIBConfig()){
		$inforbright = new DBInfobrightClass();
		$inforbright->connect($config);
	}else{
		die("connectIB:获取数据仓库配置失败");
	}
}

/**
 * 重新连接数仓库
 * @param string $dbName 连接名称
 * @return NULL
 */
function reConnectIB(){
	global $inforbright,$ibconfig;
	
	if($ibconfig){
		$inforbright = new DBInfobrightClass();
		$inforbright->connect($ibconfig);
	}else{
		die("获取全局数据仓库配置失败");
	}
}

/**
 * 管理后台数据库 执行SQL查询
 * @param $sql
 */
function IQuery ($sql, $returnId=false){
	global $db_admin;
	
	if(!$db_admin){
		connectDB("db_admin");
	}
	return $db_admin->query($sql, $returnId);
}

/**
 * 数据仓库 执行SQL查询
 * @param $sql
 */
function IBQuery ($sql, $returnId=false){
	global $inforbright;
	
	if(!$inforbright){
		connectIB();
	}
	return $inforbright->query($sql, $returnId);
}
/**
 * 管理后台数据库 执行SQL查询，获取结果集的第一行
 * @param $sql
 */
function IFetchRowOne ($sql){
	global $db_admin;
	
	if(!$db_admin){
		connectDB("db_admin");
	}
	return $db_admin->fetchOne($sql);
}

/**
 * 管理后台数据仓库 执行SQL查询，获取结果集的第一行
 * @param $sql
 */
function IBFetchRowOne ($sql){
	global $inforbright;
	
	if(!$inforbright){
		connectIB();
	}
	return $inforbright->fetchOne($sql);
}

/**
 * 加载数据
 * @param $sql
 */
function IBLoadData ($sql){
	global $inforbright;
	echo("IBLoadData 1.................................................\n");
	if(!$inforbright){
		echo("IBLoadData .......................connectIB..........................\n");
		connectIB();
	}
	echo("IBLoadData 2.................................................\n");
	return $inforbright->query($sql);
}
/**
 * 管理后台数据库 执行SQL查询，获取结果集的全部
 * @param $sql
 */
function IFetchRowSet($sql, $file=""){
	global $db_admin;
	
	if(!$db_admin){
		connectDB("db_admin");
	}
	return $db_admin->fetchAll($sql, $file);
}

/**
 * 管理后台数据仓库 执行SQL查询，获取结果集的全部
 * @param $sql
 */
function IBFetchRowSet($sql, $file=""){
	global $inforbright;
	
	if(!$inforbright){
		connectIB();
	}
	return $inforbright->fetchAll($sql, $file);
}

/**
 * 游戏数据库 执行SQL查询
 * @param $sql
 * @param $id 如果是新增记录,是否要返回新增ID
 */
function GQuery ($sql, $returnId=false){
	global $server_db;
	
	if(!$server_db){
		connectDB("server_db");
	}
	return $server_db->query($sql, $returnId);
}
/**
 * 游戏数据库  执行SQL查询，获取结果集的第一行
 * @param $sql
 */
function GFetchRowOne ($sql, $expire = -1){
	/*
	global $server_db;
	
	if(!$server_db){
		connectDB("server_db");
	}
	return $server_db->fetchOne($sql);*/
	return fetchBySql($sql, $expire, 'fetchOne', array());
}

/**
 * 游戏数据库 执行SQL查询，获取结果集的全部
 * @param $sql
 */
function GFetchRowSet($sql, $file="", $expire = -1){
/*	global $server_db;

	if(!$server_db){
		connectDB("server_db");
	}
	
	return $server_db->fetchAll($sql, $file);*/
	return fetchBySql($sql, $expire, 'fetchAll', array($file));
}

function fetchBySql( $sql, $expire = -1, $callback, $args = array() )
{
	if ( $expire >= 0 )
	{//缓存化
		$cache = ExtMemcache::instance();
		$result = $cache->get( $sql );
	}
	if ( !$result || empty($result))
	{// 缓存不存在
		global $server_db;
		
		if(!$server_db){
			connectDB("server_db");
		}
		/*	*/
		//print_r($server_db);die();
		array_unshift($args, $sql);
		$result = call_user_func_array(array($server_db, $callback), $args);
//		$result = $server_db->fetchAll($sql, $file);
		$cache = ExtMemcache::instance();
		$cache->set($sql, $result, true, MEMCACHE_COMPRESSED, $expire);
	}
	return $result;
}
/**
 * 游戏数据库 执行SQL查询
 * @param $sql
 */
function GWQuery ($sql){
	global $db_game_world;
	return $db_game_world->query($sql);
}
/**
 * 游戏数据库  执行SQL查询，获取结果集的第一行
 * @param $sql
 */
function GWFetchRowOne ($sql){
	global $db_game_world;
	return $db_game_world->fetchOne($sql);
}

/**
 * 游戏数据库 执行SQL查询，获取结果集的全部
 * @param $sql
 */
function GWFetchRowSet($sql){
	global $db_game_world;
	return $db_game_world->fetchAll($sql);
}

////////////////////////////////////////////////////////////
///分页显示的常用操作方法
/**
 * 查询结果的分页列表
 * 参数： 当前第几页， 总共多少条记录， 每页显示多少条记录
 */
function getPages($pageno, $record_count, $per_page_record = LIST_PER_PAGE_RECORDS) {
	global $lang;
	$record_count = intval($record_count);
	$total_page = ceil($record_count / $per_page_record);
	if ($total_page < 2){
		return array();
	}
    $start=max(1, $pageno-(int)(LIST_SHOW_PREV_NEXT_PAGES/2));
    if(($end=$start+LIST_SHOW_PREV_NEXT_PAGES-1)>=$total_page)
    {
        $end=$total_page;
        $start=max(1,$end-LIST_SHOW_PREV_NEXT_PAGES+1);
    }

	$arr[$lang->page->first] = 1;
	$arr[$lang->page->pre] = ($pageno > 1) ? ($pageno -1) : 1;
	for ($i = $start; $i <= $end; $i++) {
		if ($i == $pageno)
			$arr["<font color=red>{$i}</font>"] = $i;
		else
			$arr[$i] = $i;
	}
	$arr[$lang->page->next] = ($pageno < $total_page) ? ($pageno +1) : $total_page;
	$arr[$lang->page->end] = $total_page;
	return $arr;
	
}

/**
 * 查询结果的分页列表
 * 参数： 当前第几页， 总共多少条记录， 每页显示多少条记录
 * 
 * 使用此方法
 * $pages = getPages2($pageno, $record_count, $per_page_record)
 * 在模板中，只需要
 * <{include file='file:pager.tpl' pages=$pages curren_uri=$current_uri }>
 */
function getPages2($pageno, $record_count, $per_page_record = LIST_PER_PAGE_RECORDS) {
	global $lang;
	$record_count = intval($record_count);
	$total_page = ceil($record_count / $per_page_record);
	if ($total_page < 2){
		return array();
	}
    $start=max(1, $pageno-(int)(LIST_SHOW_PREV_NEXT_PAGES/2));
    if(($end=$start+LIST_SHOW_PREV_NEXT_PAGES-1)>=$total_page)
    {
        $end=$total_page;
        $start=max(1,$end-LIST_SHOW_PREV_NEXT_PAGES+1);
    }

    $arr = array();
    $arr['first'] = array('label' => $lang->page->first, 'num' => 1);
    $arr['prev'] = array('label' => $lang->page->pre, 'num' => ($pageno > 1) ? ($pageno -1) : 1);
    $arr['next'] = array('label' => $lang->page->next, 'num' => ($pageno < $total_page) ? ($pageno +1) : $total_page);
    $arr['last'] = array('label' => $lang->page->end, 'num' => $total_page);
    $arr['recordCount'] = array('label' => $lang->page->record, 'num' => $record_count);
    $arr['pageCount'] = array('label' => $lang->page->totalPage, 'num' => $total_page);
    $arr['pageSize'] = array('label' => $lang->page->everyPage, 'num' => $per_page_record);
	for ($i = $start; $i <= $end; $i++) 
	{
		if ($i == $pageno)
			$arr['items'][] = array( 'current' => true, 'num' => $i );
		else
			$arr['items'][] = array( 'current' => false, 'num' => $i );
	}

	return $arr;
	/* Alva End*/
}

/**
 * 
 * 获取分页参数
 * 调用方法
 * list($page, $pageSize) = getPagesParams();
 */
function getPagesParams()
{
	$page = isset( $_GET['page'] )? SS($_GET['page']) : 1;//当前页码
	$pageSize = isset( $_GET['pageSize'] )? SS($_GET['pageSize']) : LIST_PER_PAGE_RECORDS;//显示记录数
	
	return array($page, $pageSize);
}
	
////////////////////////////////////////////////////////////
/**
 * 查询服务器配置列表，并把数组中的 ‘id’ 付值给当前数组的 key。
 */
function getServerList(){
	//global $serverList;
	
	$sql = "select * from t_server_config order by id";
	$tmp = IFetchRowSet($sql);
	
	for($i=0; $i<count($tmp); $i++){
		$serverList['s'.$tmp[$i]['id']] = $tmp[$i];
	}
	return $serverList;
}
////////////////////////////////////////////////////////////
/**
 * 查询管理后台服务器，并把数组中的 ‘id’ 付值给当前数组的 key。
 */
function getAdminList(){
	//global $serverList;
	
	$sql = "select * from t_admin_list order by id";
	$tmp = IFetchRowSet($sql);
	
	for($i=0; $i<count($tmp); $i++){
		$adminList[$tmp[$i]['id']] = $tmp[$i];
	}
	return $adminList;
}


/**
 * 
 * 获得道具，并把JSON格式转换为数组。
 */
function getApplyList($where=null, $fetchOne=false){
	if($where){
		$where .= ' and visible=1 ';	//部分可见
	} else {
		$where = ' where visible=1 ';
	}
	
	$sql = "select * from t_apply_goods " . $where . " order by apply_time desc";
	if($fetchOne){
		$applyList = GFetchRowOne($sql);
	}else{
		$applyList = GFetchRowSet($sql);
		for($i=0; $i<count($applyList); $i++){
			$applyList[$i]['item'] = json_decode($applyList[$i]['item']);
		}
	}
	return $applyList;
}
////////////////////////////////////////////////////////////
/**
 * 查询服务器配置列表，把当前可用的后台日志数据同步的列表列出来，条件是开服时间比当前早，而且是可用的
 * 增加一个字段是表示可用性的
 */
function getAvailableServerList(){
	$today = strftime ( "%Y-%m-%d" );
	$sql = "select * from t_server_config where available=1 order by id";
//	$sql = "select * from t_server_config where onlinedate <= '".$today."' and available=1 order by id";
	$tmp = IFetchRowSet($sql);
	
	for($i=0; $i<count($tmp); $i++){
		$serverList['s'.$tmp[$i]['id']] = $tmp[$i];
	}
	return $serverList;
}
////////////////////////////////////////////////////////////
/**
 * 传入数组及表名，构造 SQL
 */
function getInsertSQL($arr, $table){
	global $db_admin;
	return $db_admin->makeInsertSqlFromArray($arr, $table);
}

function getUpdateSQL($arr, $table){
	global $db_admin;
	return $db_admin->makeUpdateSqlFromArray($arr, $table, $key = 'id');
}
/*
 * 在游戏日志库中执行SQL语句
 */
function logQuery($sql){
	global $server_db;
//	echo "sql=".$sql;
	return $server_db->query($sql);
}

/*
 * 在游戏日志仓库中执行SQL语句
 */
function logIBQuery($sql){
	global $inforbright;

	return $inforbright->query($sql);
}
/**
 * 生成排序的下拉列表数组
 * Enter description here ...
 * @param array $allowed_fields
 * @param array $selected
 */
function generateSortArray($allowed_fields, $selected)
{
	$sortArray = array();
	foreach ($allowed_fields as $field => $label)
	{
		$sortArray[ $field . '|0'] = $label . '↑';
		$sortArray[ $field . '|1'] = $label . '↓';
	}
	list($field, $order) = $selected;
	$order = $order == 'asc'? 0:1;
	
	return array($sortArray, $field . '|' . $order);
}

/**
 * 获取选中的排序
 * Enter description here ...
 * @param string $name
 * @param array $allowed_fields
 * @param string $method
 */
function getSortOrder($name, $allowed_fields, $method = 'get')
{
	if($method == 'get' && isset( $_GET[$name] ) )
	{
		$selectedOrder = $_GET[$name];
	}
	elseif(isset( $_POST[$name] ))
	{
		$selectedOrder = $_POST[$name];
	}
	else
	{// 未选中
		return false;
	}
	
	list($field, $order) = explode('|', $selectedOrder);
	if( array_key_exists($field, $allowed_fields))
	{
		$order = $order == '0' ? 'asc' : 'desc';
		return array($field, $order);
	}
	else
	{// 未选中
		return false;
	}
}

/**
 * 
 * 切换游戏日志数据库
 * @param string $serverID
 */
function switchGameDB($serverID = null)
{
	if ($serverID === null) return false;//
	global $server_db;
	$serverList = getAvailableServerList();
	
	if(!$server_db){
		$server_db =  new DBMysqlClass();
	}
	$config = getLogDb($serverList[$serverID]);
	
	$server_db->connect($config);
	return true;
}

function getDBInfo($host, $user, $pass, $db)
{
	$conf = array();
	$dbInfoResult = array();
	$dbInfoResult['tables'] = array();
	$dbInfoResult['host'] = $conf['host'] = $host;
	$conf['user'] = $user;
	$conf['passwd'] = $pass;
	$dbInfoResult['dbname'] = $conf['dbname'] = $db;
	
	$hd = new DBMysqlClass();
	$hd->connect($conf);
	$dbInfoResult['dbsize'] = 0;
	$dbInfo = $hd->fetchAll("SHOW TABLE STATUS LIKE 't_%'");
	foreach($dbInfo as $table) {
			$dbInfoResult['tables'][] = $table;
            $dbInfoResult['dbsize'] += $table['Data_length'] + $table['Index_length'];
    }
	$dbInfoResult['dbsize'] = $dbInfoResult['dbsize'] ? sizecount($dbInfoResult['dbsize']):"unknow";
	$hd->close();
	return $dbInfoResult;
}


/**
 * 获取日志表各字段的文字说明
 * @author Libiao
 * @param string $table
 * @return array colName=>comment 
 */
function getColumnDesc($table) {
//	$dbName = "";
//	$sql0 = "select column_name,column_comment  FROM `Information_schema`.`columns` WHERE `TABLE_SCHEMA`='{$dbname}' AND `table_Name`='{$table}'";
			
	$sql = "show full fields from {$table}";
	$result = GFetchRowSet($sql);
	
	$arr = array();
	
	foreach ( $result as $key => $value ) {
		$arr[$value['Field']] = $value['Comment'];
	}
	
	return $arr;
}
