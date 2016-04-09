<?php
/**
 * orange_equip_drop.php
 * 橙装掉落、合成信息
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';
include_once SYSDIR_ADMIN_DICT . '/equipConfig.php';


$roleName = $_POST['role_name'] ; 
$accountName = $_POST['account_name'] ; 

//获取时间段
if (! isset ( $_POST ['starttime'] )){
    $dateStart = Datatime::getPrevWeekString ();
}else{
    $dateStart = SS ( $_POST ['starttime'] );
}

$dateStart = (strtotime($dateStart) >= strtotime(ONLINEDATE)) ? $dateStart : ONLINEDATE;
$dateEnd = ! isset ($_POST['endtime']) ? Datatime::getTodayString() :  SS ($_POST['endtime']);
$dateStartTamp = strtotime($dateStart." 0:0:0");
$dateEndTamp = strtotime($dateEnd." 23:59:59");

$where = " mtime>={$dateStartTamp} AND mtime<={$dateEndTamp} ";

if($roleName) {
	$where .= " AND role_name='{$roleName}' ";
}
if($accountName) {
	$where .= " AND account_name='{$accountName}' ";
}

$record = $_POST['record'] ? SS($_POST['record']) : LIST_PER_PAGE_RECORDS;

$counts = 0;//总记录
$pageno = getUrlParam('page');//设置初始页
$startNum = ($pageno - 1) * $record; //每页开始位置
$viewData = getOrangeEquipDropData($where, $startNum, $record, $counts);

$pageCount = ceil ( $counts/$record );
$pagelist = getPages($pageno, $counts,$record);

$maxDate = date ( "Y-m-d" );
$data = array(
    'counts' => $counts,
    'record' => $record,
    'minDate' => ONLINEDATE,
    'maxDate' => $maxDate,
    'role_name' => $roleName,
    'account_name' => $accountName,
    'pagelist' => $pagelist,
    'pageCount' => $pageCount,
    'pageno' => $pageno,
    'dateStart' => $dateStart,
    'dateEnd' => $dateEnd,
    'lang' => $lang,
    'equipConfig' => $equipConfig,
    'dictColor' => $dictColor,
    'viewData' => $viewData,
);


$smarty->assign ($data);
$smarty->display("module/item/orange_equip_drop.tpl");


function getOrangeEquipDropData($where,$startNum,$record,&$counts) {
	
	//拾取或打造
	$where .= " AND (type=10004 or type=10010) AND item_id>=20000 AND item_id<30000 AND item_num>0 "; 
//	$sql = "select item_id,substring(SUBSTRING_INDEX(`detail`,'|',-5),1,1 ) as color from t_log_item where type=10004 AND item_id>=20000 and item_id<30000 having color>=5 ";
	$sqlAllCount = " select count(*) as cnt from ( select mtime, substring(SUBSTRING_INDEX(`detail`,'|',-5),1,1 ) as color " .
			" from " . T_LOG_ITEM . " where {$where} having color>=5 ) t1 ";
	$result = IBFetchRowOne($sqlAllCount);
	$counts = $result['cnt'];
//	echo "sql1= ",$sqlAllCount,"\n\r<br>";
	
	$sqlDropData = "select mtime, account_name, role_name, level, type, item_id, item_num, is_bind, detail, substring(SUBSTRING_INDEX(`detail`,'|',-5),1,1 ) as color " .
			" from " . T_LOG_ITEM . " where {$where} having color>=5 order by mtime desc limit {$startNum},{$record} ";
//	echo "sql2= ",$sqlDropData,"\n\r<br>";
	$result = IBFetchRowSet($sqlDropData);
	if(!empty($result)) {
		foreach($result as $k => &$v){
			$v['mtime'] = date("Y-m-d H:i:s",$v['mtime']);
			$v['detail'] = getItemDetailArray($v['detail']);
		}
	}
//	print_r($result);
	return $result;
}
