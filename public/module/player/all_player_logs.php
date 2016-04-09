<?php
/**
 * all_player_logs.php
 * 
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';

$startDay =  $_REQUEST['startDay']?SS($_REQUEST['startDay']):date('Y-m-d');
$endDay =  $_REQUEST['endDay']?SS($_REQUEST['endDay']):date('Y-m-d');
$roleName =  SS(trim($_REQUEST['roleName']));
$accountName =  SS(trim($_REQUEST['accountName']));
$checkbox =  $_REQUEST['checkbox'];
$selectType =  $_REQUEST['selectType'];

if($startDay){
	$startDay = (strtotime($startDay) >= strtotime(ONLINEDATE)) ? $startDay : ONLINEDATE;
}

$startTime = strtotime($startDay);
$endTime = strtotime($endDay);

if($selectType){
	foreach ( $selectType as $key => $value ) {
		$selectType[$value] = $value;
	}
}
/*
global $dictType;
$dictType = array(
	"currency" => array(10,11,12,13,14,),
	"pet" => array(29,30,31,32,33,34,35,36,37,),
	"family" => array(15,21,22,26,),
	"home" => array(45,46,),
	"shenlu" => array(38,39,40,41,42),
//	"other" => array(),
);
*/

global $allTables ;
$checkboxData = array();

//从配置文件获取所有日志表配置
include_once('../../../log/file/config/log_template_config.php');
$i = 0;
foreach ( $arrLogTplConf as $tb => $dt ) {
	
	if($dt['log_type'] == 'activity'){
		continue;
	}
	$allTables[$i]['id'] = $i;
	$allTables[$i]['name'] = $tb;
	$allTables[$i]['desc'] = str_replace(array('日志','获得与使用','玩家'),"",$dt['desc']);
	
	$checkboxData[$i] = $allTables[$i]['desc'];
	$i++;
}

//查询条件
$condition = array(
	"role_name" => $roleName,
	"account_name" => $accountName,
	"startTime" => $startTime,
	"endTime" => $endTime,
	);

$data = array();
if($checkbox){
	foreach ( $checkbox as $key => $value ) {
	
		$table = $allTables[$value]['name'];

		$result = getData($table,$arrLogTplConf[$table]['fields'],$condition);
		
		$colDesc = getColumnDesc($table);
		
		
		if($result){
			$tmpData = handleData($allTables[$value]['desc'], $result, $colDesc, $table);
			$data = array_merge($data,$tmpData);
		}
	}	
}

//按时间对数组排序
$data = sortArrayByKey($data,"mtime");
//重新设置数组下标
$data = changeArrayBase($data,0);

//分页设置
$page = $_REQUEST['page']?$_REQUEST['page']:1;	//第几页
$pageSize = $_REQUEST['pageSize']?$_REQUEST['pageSize']:LIST_PER_PAGE_RECORDS;	//每页显示行数

$counts = count($data);	//总记录数
$pageCount = ceil($counts/$pageSize);	//总页数

$pagelist = getPages($page, $counts, $pageSize);

$viewData =  getPageData($data, $page, $pageSize);

$smarty->assign('checkboxData', $checkboxData );
$smarty->assign('checked', $checkbox );
$smarty->assign('selectType', $selectType );
$smarty->assign('viewData', $viewData );
$smarty->assign('roleName', $roleName );
$smarty->assign('accountName', $accountName );
$smarty->assign('startDay', $startDay );
$smarty->assign('endDay', $endDay );
$smarty->assign( 'minDate', ONLINEDATE);
$smarty->assign( 'maxDate', Datatime :: getTodayString());
$smarty->assign('lang', $lang );

$smarty->assign('pagelist', $pagelist );
$smarty->assign('counts', $counts );
$smarty->assign('page', $page );
$smarty->assign('pageSize', $pageSize );
$smarty->assign('pageCount', $pageCount );
$smarty->display( 'module/player/all_player_logs.tpl' );

/**
 * 获取所有日志表名
 * @param NULL 
 * @return array index=>table
 */
function getDbTables(){
	$sql = "show tables";
	$result = GFetchRowSet($sql);
	
	$tables = array();
	
	foreach ( $result as $key => $value ) {
		foreach($value as $k=>$v){
			$tables[$key] = $v;
		}
	}
	return $tables;
}
/*
function getSelectTable($selectType) {
	$tableList = array();
	foreach ( $selectType as $type => $values ) {
		foreach ( $values as $k => $v ) {
			$tableList[$allTables[$v]['name']] = $allTables[$v]['name'];
		}
	}
	return $tableList;
}
*/
function getData($table,$fields,$cond=array()){
	$petTables = array(
				"t_log_pet_up" => "t_log_pet_up",
				"t_log_pet_create" => "t_log_pet_create",
				"t_log_pet_del" => "t_log_pet_del",
				"t_log_pet_ronghe" => "t_log_pet_ronghe",
				"t_log_pet_feed" => "t_log_pet_feed",
				"t_log_pet_jingjie_up" => "t_log_pet_jingjie_up",
				"t_log_pet_skill_up" => "t_log_pet_skill_up",
				"t_log_pet_skill_forget" => "t_log_pet_skill_forget",
				"t_log_pet_huaxing" => "t_log_pet_huaxing",
				"t_log_client_info" => "t_log_client_info",
				);
	$where = $where2 = 1;
	
	if($cond['role_name']) {
		$where .= " AND role_name='{$cond['role_name']}' ";
	}
	if($cond['account_name']) {
		$where .= " AND account_name='{$cond['account_name']}' ";
	}
	
	if($cond['startTime']) {
		$where .= " AND mtime>={$cond['startTime']} ";
	}
	if($cond['endTime']) {
		$cond['endTime'] += 86400;
		$where .= " AND mtime<{$cond['endTime']} ";
	}
	
	$need = implode(", ",$fields);
	$sql = "SELECT {$need} FROM {$table} WHERE {$where} ";
	
	if( in_array($table,$petTables) ) {
		//处理查询字段，增加account_name和role_name
		foreach($fields as $k => &$v){
			$v = "P.".$v;
		}
		$fields[] = "R.account_name as account_name";
		$fields[] = "R.role_name as role_name";
		
		if(!empty($cond['role_name'])) {
			$where2 .= " AND R.role_name='{$cond['role_name']}' ";
		}
		if($cond['account_name']) {
			$where2 .= " AND R.account_name='{$cond['account_name']}' ";
		}
		if($cond['startTime']) {
			$where2 .= " AND P.mtime>={$cond['startTime']} ";
		}
		if($cond['endTime']) {
			$cond['endTime'] += 86400;
			$where2 .= " AND P.mtime<{$cond['endTime']} ";
		}
		
		if($table == "t_log_client_info") {
			$where2 .= " AND R.uuid = P.uuid ";
		} else {
			$where2 .= " AND R.uuid = P.owner_uuid ";
		}
		
		
		if (!empty($cond)) {
			foreach($cond as $k => &$v) {
				$v .= "R.";
			}
		}
		
		$need = implode(", ",$fields);
		$sql = "SELECT {$need} FROM {$table} P, ".T_LOG_REGISTER." R WHERE {$where2} ";
	}
	
//	echo "sql=".$sql;
	$result = GFetchRowSet($sql);
	return $result;
	
}


function handleData($tableKey, $data, $desc, $table="") {
	$currency = array(T_LOG_GOLD,T_LOG_MONEY,T_LOG_LIQUAN,T_LOG_LINQGI,T_LOG_TIANCHENG,T_LOG_ITEM);
	$result = array();
	$i = 0;
	foreach ( $data as $key => $value ) {
		$result[$i]['key'] = $tableKey;
		foreach ( $value as $k => $v ) {
			if($k == "mdate" || $k == "mtime" || $k == "uuid" || $k == "account_name" || $k == "role_name" || $k == "level") {
				$result[$i][$k] = $v;
			} else {
				if(in_array($table, $currency) && $k == "type") {
					$result[$i]['desc'] .= $desc[$k].":<a href='operation_dict.php' target='_blank' title='点击查看对照表'><font color='#2200FF'>".$v."</font></a>, ";
				} else {
					$result[$i]['desc'] .= $desc[$k].":<font color='#2200FF'>".$v."</font>, ";
				}
				
			}
		}
		$i ++;
	}
	return $result;
}

function getPageData($data, $page, $pageSize){
	$pageData = array();
	$start = $pageSize*($page-1) ;
	for($i = $start; $i<$start+$pageSize; $i++) {
		if($data[$i]) {
			$pageData[$i] = $data[$i];
		}
	}
	return $pageData;
}