<?php
/**
 * 玩家充值记录
 * Author: xieying
 * 2011-11-16
 * 17:47
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';

global $lang;

$errorMsg = $successMsg = array();// 消息数组
$defaultDays = 6;//默认显示多少天内的统计数据
$onlineDate = $serverList[$_SESSION ['gameAdminServer']]['onlinedate'];//开服日期
$openTimestamp = strtotime( $onlineDate );//开服日期的时间戳
$startDayString = date('Y-m-d', strtotime(" -$defaultDays days"));//默认起始日期
$endDayString = date('Y-m-d');//默认结束日期
$currentDay = date('Y-m-d');//当前日期
list($page, $pageSize) = getPagesParams();
$field = 'mtime';//排序字段
$order = 'desc';//排序方法
$selectOrder = 'time|1';
$sortTypeArray = array('account|0' => "{$lang->page->accountName}↑",'account|1' => "{$lang->page->accountName}↓",
					   'order|0' => "{$lang->player->order}↑",'order|1' => "{$lang->player->order}↓",
					   'time|0' => "{$lang->player->payTime}↑",'time|1' => "{$lang->player->payTime}↓",
					   'money|0' => "{$lang->page->payCount}↑",'money|1' => "{$lang->page->payCount}↓",
					);
$sortTypeMap = array(
				'field' => array('account' => 'account_name', 'order' => 'order_id', 'time' => 'pay_time', 'money' => 'pay_money'),
				'order' => array(0 => 'ASC', 1 => 'DESC')
			);//避免直接使用参数的数据

$startDayString 	= (isset( $_GET['startDay'] ) && $_GET['startDay'] > $onlineDate )? SS($_GET['startDay']) : Datatime::getFormatStringByString('Y-m-d', $onlineDate);
$endDayString 	= isset( $_GET['endDay'] )? SS($_GET['endDay']) : date('Y-m-d');
$roleName = isset( $_GET['role_name'] )? autoAddPrefix( SS($_GET['role_name']) ) : '';
$accountName = isset( $_GET['account_name'] )? autoAddPrefix (SS($_GET['account_name']) ): '';
$excelParam = isset( $_GET['excel'] )? SS($_GET['excel']) : false;
$excelUri = cleanQueryString( $_SERVER['REQUEST_URI'], array('page', 'startDay', 'endDay') );
$sortType = isset( $_GET['sortType'] ) ? SS( $_GET['sortType'] ) : $selectOrder;
list($selectedField, $selectedOrder) = explode('|', $sortType );
if( array_key_exists($selectedField, $sortTypeMap['field']) && array_key_exists($selectedOrder, $sortTypeMap['order']))
{
	$field = $sortTypeMap['field'][$selectedField];
	$order = $sortTypeMap['order'][$selectedOrder];
	$selectOrder = $sortType;
}
$orderBy = array($field, $order);//排序方法

if(isPost())
{	
	if( isset($_POST['dateToday']) )//显示本日的统计数据
	{
		$startDayString = $endDayString = date('Y-m-d');
		$currentDay = $_SESSION['currentDay'] = date('Y-m-d');
	}
	elseif( isset($_POST['datePrev']) )//显示前一日的统计数据
	{
		$currentDay =  isset($_SESSION['currentDay'])? $_SESSION['currentDay']:date('Y-m-d');
		$currentDayBeginTimestamp = Datatime::getDayBeginTimestamp( $currentDay );
		$startDayString = $endDayString = date('Y-m-d', $currentDayBeginTimestamp - 1);
		$currentDay = $_SESSION['currentDay'] = $startDayString;
	}
	elseif( isset($_POST['dateNext']) )//显示下一日的统计数据
	{
		$currentDay =  isset($_SESSION['currentDay'])? $_SESSION['currentDay']:date('Y-m-d');
		$currentDayEndTimestamp = strtotime($currentDay." 23:59:59");
		$startDayString = $endDayString = date('Y-m-d', $currentDayEndTimestamp + 1);
		$currentDay = $_SESSION['currentDay'] = $startDayString;
	}
	elseif( isset($_POST['dateAll']) )
	{ //保持原值
		$startDayString = $onlineDate;//起始日期
		$endDayString = date('Y-m-d');//结束日期
	}
}

$excelUri .= '&startDay=' . $startDayString . '&endDay=' . $endDayString . '&excel=true';
$startDayTimestamp 	= Datatime::getDayBeginTimestamp( $startDayString ) ;
$endDayTimestamp 	= strtotime( $endDayString." 23:59:59" ) ;

//数据体
if(isset($excelParam) && $excelParam == true){
	$viewData = json_decode ( getPayPlayerData ( $startDayTimestamp, $endDayTimestamp,null,null,$roleName,$accountName, $orderBy),true );
}else{
	$viewData = json_decode ( getPayPlayerData ( $startDayTimestamp, $endDayTimestamp,$page,$pageSize,$roleName,$accountName, $orderBy),true );
}

foreach ( $viewData['data'] as &$value ){
    $value ['payTime'] = date ( 'Y-m-d H:i:s',$value ['payTime'] );
}

//$pageList = getPages ($pageNo, $record, $pageNum);
// 构造页码 
$pager = getPages2( $page, $viewData ['recordCount'], $pageSize );

if(isset($excelParam) && $excelParam == true){
	$excel	= true;
}
//输出Excel文件
if(isset($excelParam) && $excelParam == true ){
	$excel = getExcel($viewData);
	$smarty->assign('title', $excel['title']); // 标题
	$smarty->assign('hd', $excel['hd']);       // 表头
	$smarty->assign('num',$excel['hdnum']);    // 列数
	$smarty->assign('ct', $excel['content']);  // 内容

	// 输出文件头，表明是要输出 excel 文件
	header('Content-type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename='.$excel['title'].date('_Ymd_Gi').'.xls');
	$smarty->display('module/pay/pay_excel.tpl');
	flush();
	exit;
}
$data = array(
    'dateStrPrev' => $dateStrPrev,
	'currentDay' => $currentDay,
    'dateStrToday' => $dateStrToday,
    'dateStrNext' => $dateStrNext,
    'dateOnline' => $dateOnline,
    'type' => $type,
    'arrType' => $arrType,
    'record' => $record,
    'minDate' => $onlineDate,
	'maxDate' => Datatime :: getTodayString() ,
    'role_name' => $roleName,
    'account_name' => $accountName,
    'pager' => $pager,
    'startDay' => $startDayString,
	'endDay'=> $endDayString ,
    'lang' => $lang,
    'viewData' => $viewData,
	'current_uri' => cleanQueryString( $_SERVER['REQUEST_URI'], array('page') ),
	'excelUri' => $excelUri,
	'sortTypeArray' => $sortTypeArray,
	'selectOrder' => $selectOrder,
);
$smarty->assign ($data);
$smarty->display ( 'module/pay/pay_player.tpl' );

function getPayPlayerData($dateStartTimeStamp = null, $dateEndTimeStamp = null, $page, $pageSize , $roleName = '', $accountName = '', $orderBy = array()) {
	$whereCondArray = array();
	if (!empty($dateStartTimeStamp) && $dateEndTimeStamp > 0 )$whereCondArray[] 	= " pay_time > $dateStartTimeStamp";
	if (!empty($dateEndTimeStamp) && $dateEndTimeStamp > 0)$whereCondArray[] 	= " pay_time < $dateEndTimeStamp";
	if (!empty($roleName))$whereCondArray[] 			= " role_name = '$roleName'";
	if (!empty($accountName))$whereCondArray[] 			= " account_name = '$accountName'";
	if (!empty($whereCondArray))$whereCond =  ' WHERE ' . implode(' AND ', $whereCondArray);
	if (!empty($orderBy)) 
		$orderBy = ' ORDER BY ' . implode(' ', $orderBy);
	else
		$orderBy = '';
	
	$limit = '';
	if (!empty($page) && !empty($pageSize)) $limit = ' LIMIT ' . (($page - 1) * $pageSize) . ', ' . $pageSize;
	
	$sql = 'SELECT 
				order_id `order`, role_name roleName, account_name accountName, pay_time payTime, pay_gold goldGet, pay_money moneyLost 
			FROM ' . T_LOG_PAY . $whereCond . $orderBy . $limit;

	$recordSet = GFetchRowSet($sql);	
	
	$sqlCount = 'SELECT 
					count(*) row_count
				 FROM ' . T_LOG_PAY . $whereCond ;
	$recordCount = GFetchRowOne( $sqlCount );

	$data = array (
                    'recordCount' => $recordCount['row_count'],
                    'pageNum' => $pageNum,
                    'page' => $pageNo,
                    'data' => $recordSet
            );
	return json_encode ( $data );
}
function getExcel($viewData){
    global $lang;
	//记录数据
	$excel = array();

	// 标题
	$excel['title'] = $lang->menu->playerPayData;
	// 表头
	$excel['hd'] =  array(
			$lang->player->order,
			$lang->page->roleName,
			$lang->page->accountName,
			$lang->player->payTime,
			$lang->player->goldGet,
			$lang->player->moneyLost,
	);
	// 列数
	$excel['hdnum'] = count($excel['hd']);

	$excel['content'] = array();
	foreach($viewData['data'] as $k=>$v){
		$excel['content'][$k] = array();
		$excel['content'][$k][] = array('StyleID'=>'s28', 'Type'=>'String', 'content'=>$v['order']);
		$excel['content'][$k][] = array('StyleID'=>'s29', 'Type'=>'String', 'content'=>$v['roleName']);
		$excel['content'][$k][] = array('StyleID'=>'s29', 'Type'=>'String', 'content'=>$v['accountName']);
		$excel['content'][$k][] = array('StyleID'=>'s29', 'Type'=>'String', 'content'=>$v['payTime']);
		$excel['content'][$k][] = array('StyleID'=>'s29', 'Type'=>'String', 'content'=>$v['goldGet']);
		$excel['content'][$k][] = array('StyleID'=>'s29', 'Type'=>'String', 'content'=>$v['moneyLost']);
	}
	return $excel;
}