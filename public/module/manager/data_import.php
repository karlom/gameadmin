<?php
/**
 * data_restore.php
 * 数据查询与恢复
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';

$server = SS(trim($_POST['server']));
$date = SS(trim($_POST['date']));
$time = SS(trim($_POST['time']));
$minute = SS(trim($_POST['minute']));

$strMsg = array();

//every 1 hour
$timeArr = array();
for($i=0;$i<24;$i++){
	$timeArr[$i] = $i."时";
}

//every 30 minute
$minuteArr = array(
	'0' => '0分',
//	'30' => '30分',
);

if( PROXY == 'tt' ) {
	$minuteArr['30'] = '30分';
}

$now = time();

//last 7 days
$dateArr = array();
for($i=0;$i<7;$i++){
	$dateArr[$i] = date("Y-m-d",$now - $i*86400);
}
$dateArr['7'] = '2014-06-26';

//$serverList = getAvailableServerList();
$serverList = getServerList();
//print_r($serverList);

if(isPost()){
	
	$table = "t_command_list";
	
	if( !isset($server) || !isset($date) || !isset($time) ) {
		$strMsg[] = '请选择服务器、日期和时间'."[$server],[$date],[$time]";
	}
	
	$checkSql = "select * from {$table} where `executed`=0 order by mtime desc ";
	$result = IFetchRowOne($checkSql);
	if(is_array($result) && !empty($result)) {
		$mdate = date("Y-m-d H:i:s",$result['mtime']);
		$cmdArr = explode(" ",$result['cmd']);
		
//		$strMsg[] = '当前有未完成的导入任务：'."server:[{$cmdArr['0']}],ip:[{$cmdArr['1']}],date[{$cmdArr['2']} {$cmdArr['3']}], user: {$result['admin_name']},addTime: {$mdate}";
		$strMsg[] = '当前有未完成的任务，请稍候再试';
	}
	
	//sh get_mongodb_from_server.sh D3_qq_S10305 10.221.172.16 2014-04-23 00
	
//	print_r($_POST);
//	print_r($serverList);
	
	$serName = $serverList['s'.$server]['dbname'];
	$serIp = substr($serverList['s'.$server]['url'],7);
	$serIp = rtrim($serIp,'/');
	$tmpArr = explode(":",$serIp);
	$serIp = $tmpArr[0];
	
	$date = $dateArr[$date];
	$time = $time<10 ? "0".$time : $time;
	$minute = $minute<10 ? "0".$minute : $minute;
	
	if(!$strMsg) {
		$insertArr = array(
			'mtime' => time(),
//			'cmd' => "/bin/bash get_mongodb_from_server.sh {$serName} {$serIp} {$date} {$time}",
			'cmd' => "{$serName} {$serIp} {$date} {$time} {$minute}",
			'executed' => 0,
			'admin_name' => $auth->username(),
		);
		$insertSql = makeInsertSqlFromArray($insertArr, "t_command_list");
		
		try{
			$result = IQuery($insertSql);
			if($result){
				$strMsg[] = "正在导入，请稍等。。。";
			} else {
				$strMsg[] = "导入失败！";
			}
		} catch(Exception $e) {
			$strMsg[] = "something error: ".$e;
		}
		
	}

}
$list = getList();

$attention = "注意，这里是 ".$serverCname." 服，如不清楚些功能作用，请不要随便操作！";

$smarty->assign("attention", $attention);
$smarty->assign("list", $list);
$smarty->assign("serverList", $serverList);
$smarty->assign("timeArr", $timeArr);
$smarty->assign("minuteArr", $minuteArr);
$smarty->assign("dateArr", $dateArr);
$smarty->assign("change", $change);
$smarty->assign("lang", $lang);
$smarty->assign("strMsg", $strMsg);
$smarty->display("module/manager/data_import.tpl");

function getList(){
	$listSql = "select * from t_command_list order by mtime desc ";
	$list = IFetchRowSet($listSql);
//	print_r($list);
	if(!empty($list)){
		foreach ( $list as $k => $v ) {
			$list[$k]['mdate'] = date("Y-m-d H:i:s",$v['mtime']);
			
			$cmdArr = explode(" ",$v['cmd']);
			
			$list[$k]['server'] = $cmdArr[0];
			$list[$k]['ip'] = $cmdArr[1];
			$list[$k]['date'] = $cmdArr[2];
			$list[$k]['hour'] = $cmdArr[3];
			$list[$k]['minute'] = $cmdArr[4] ? $cmdArr[4] : '0';
		}
	}
	
	return $list;
}