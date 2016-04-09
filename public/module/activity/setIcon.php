<?php
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
global $lang;

//$type= isset($_POST['type']) ? SS(trim($_POST['type'])) : ' ';
$type= isset($_POST['browser']) ? SS(trim($_POST['browser'])) : ' ';
$postStartA = isset($_POST['a_kaifu_start']) ? SS(strtotime($_POST['a_kaifu_start'])) : '';
$postEndA   = isset($_POST['a_kaifu_end']) ? SS(strtotime($_POST['a_kaifu_end'])) : '';
$postStartDateR = isset($_POST['r_kaifu_start_date']) ? SS($_POST['r_kaifu_start_date']) * 3600 * 24 : '';
$postStartTimeR = isset($_POST['r_kaifu_start_time']) ? SS(splitTime($_POST['r_kaifu_start_time'])) : '';
$postEndRDateR  = isset($_POST['r_kaifu_end_date']) ? SS($_POST['r_kaifu_end_date']) * 3600 * 24 : '';
$postEndRTimeR  = isset($_POST['r_kaifu_end_time']) ? SS(splitTime($_POST['r_kaifu_end_time'])) : '';
$roleName = $_SESSION ['username'];
// ONLINEDATE --开服日期

if( isset($_GET['action']) && $_GET['action'] == 'del' )
{
	$table = T_LOG_ICON;
	$canDel = false;
	$id = isset( $_GET['id'] )? intval( $_GET['id'] ) : false;
	if( $id )
	{
		$iconConfig = GFetchRowOne("SELECT * FROM $table WHERE id = $id LIMIT 1");
		$curTime = time();
		if( !empty($iconConfig) )
		{
			$canDel = true;
		}
		if( $canDel && $iconConfig['start_time'] < $curTime && $iconConfig['end_time'] > $curTime )
		{
			$method = 'seticon';
		    $params = array(
		    	'type'      => $iconConfig['type'],
		    	'startTime' => $curTime,
		    	'endTime'   => $curTime,
		    );
		    $rs = interfaceRequest($method, $params);
		    if( $rs['result'] != 1 )
		    {
		    	$canDel = false;
		    }
		}
		if( $canDel )
		{
			GQuery("DELETE FROM $table WHERE id = $id LIMIT 1");
		}
	}
}

if (!empty($_POST)){
    if ( $_POST['kaifu_time_state'] == 0 ){
    	$startTime = $postStartA;
    	$endTime   = $postEndA;
		$postStart = $startTime - strtotime(ONLINEDATE);
		$postEnd   = $endTime - strtotime(ONLINEDATE);
    } else {
    	$startTime = $postStartDateR + $postStartTimeR + strtotime(ONLINEDATE);
    	$endTime   = $postEndRDateR + $postEndRTimeR + strtotime(ONLINEDATE);
		$postStart = $postStartDateR + $postStartTimeR;
		$postEnd   = $postEndRDateR + $postEndRTimeR;
    }
    
    $method = 'seticon';
    $params = array(
    	'type'      => $type,
    	'startTime' => $startTime,
    	'endTime'   => $endTime,
    );
	$rs = interfaceRequest($method, $params);
};

//接口请求成功入库作记录并写日志
if ($rs['result'] == 1){
	$insert = array();
	$insert = array(
    	'role_name'             => $roleName,
    	'type'					=> $type,
    	'start_time'			=> $startTime,
    	'end_time'				=> $endTime,
    	'start_open_day_time'   => $postStart,
    	'end_open_day_time'		=> $postEnd,
	);
	$insertData = makeInsertSqlFromArray($insert, T_LOG_ICON);
	GQuery($insertData);
	
	$log = new AdminLogClass();
	$log->Log(AdminLogClass::TYPE_SET_ICON,'','','','','');
}

$type = array( 
	'1' => '开服图标',
	'2' => '炫购图标',
);

//查询记录列表
$list = selectData();
foreach ($list as $key => &$value) {
		$value['start_time'] = date('Y-m-d H:i:s',$value['start_time']);
		$value['end_time']   = date('Y-m-d H:i:s',$value['end_time']);
		$value['start_open_day_time']   = splitTime($value['start_open_day_time'],2);
		$value['end_open_day_time']     = splitTime($value['end_open_day_time'],2);
}

$data = array(
    'type' => $type,
    'lang' => $lang,
    'result' => $rs['result'],
    'list' => $list,
);

$smarty -> assign($data);
$smarty -> display('module/activity/setIcon.html');

//开服时间,时间戮互转
function splitTime($time,$w='1'){
	if ($w == 1) {
		list($hour, $minute, $second) = explode(':', $time);	
		$hour    = $hour * 3600;
		$minute  = $minute * 60;
		$strTime = $hour + $minute + $second;	
	} else {
		$date    = floor($time / 86400);
		$hour    = floor(($time - $date * 24 * 3600) / 3600) ;
		$minute  = floor(($time - $date * 24 * 3600 - $hour * 3600) / 60) ; 
		$second  = $time - $date * 24 * 3600 - $hour * 3600 - $minute * 60 ; 
		$strTime = $date." 天 ".$hour." 小时 ".$minute." 分 ".$second.' 秒 ' ;
	}
	return $strTime;
}

//查记录
function selectData() {
	$sql = 'SELECT * FROM ' . T_LOG_ICON . ' ORDER BY id DESC';
	$result = GFetchRowSet($sql);
	return $result;
}

