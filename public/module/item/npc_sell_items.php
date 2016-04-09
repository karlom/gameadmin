<?php
/**
 * npc_sell_items.php
 * NPC出售物品统计
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/arrItemsAll.php';
include_once SYSDIR_ADMIN_DICT . '/npc.php';

$roleName = $_POST['role_name'] ; 
$accountName = $_POST['account_name'] ; 

$lookingday = $_POST['lookingday'];

$today = date("Y-m-d");

//获取时间段
if (! isset ( $_POST ['starttime'] )){
    $dateStart = Datatime::getPrevWeekString ();
}else{
    $dateStart = SS ( $_POST ['starttime'] );
}

$dateStart = (strtotime($dateStart) >= strtotime(ONLINEDATE)) ? $dateStart : ONLINEDATE;
$dateEnd = ! isset ($_POST['endtime']) ? Datatime::getTodayString() :  SS ($_POST['endtime']);

$lookingday = $_POST['lookingday'];

if( !empty($_POST['today']) ) {
	$dateStart = $dateEnd = $today;
}
if( !empty($_POST['all']) ) {
	$dateStart = ONLINEDATE;
	$dateEnd = $today;
}

if(!empty($_POST['preday'])){
	$dateStart = $dateEnd = date("Y-m-d", strtotime($dateStart)-86400 );
}
if(!empty($_POST['nextday'])){
	$dateStart = $dateEnd = date("Y-m-d", strtotime($dateEnd)+86400 );
}

$dateStartTamp = strtotime($dateStart." 0:0:0");
$dateEndTamp = strtotime($dateEnd." 23:59:59");

if($dateStartTamp < strtotime(ONLINEDATE)){
	$dateStart = ONLINEDATE;
}
if( $dateStartTamp > strtotime($today) ){
	$dateStart = $today;
}

if($dateEndTamp > strtotime($today) ){
	$dateEnd = $today;
}
if($dateEndTamp < strtotime(ONLINEDATE)){
	$dateEnd = ONLINEDATE;
}

$dateStartTamp = strtotime($dateStart." 0:0:0");
$dateEndTamp = strtotime($dateEnd." 23:59:59");

$where = " mtime>={$dateStartTamp} AND mtime<={$dateEndTamp} ";
//$where2 = $where;
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
$viewData = getNpcSellData($where, $startNum, $record, $counts);

$pageCount = ceil ( $counts/$record );
$pagelist = getPages($pageno, $counts,$record);

//$statisticsData = getStatisticsData($where2);

$lookingday = $dateEnd;
$maxDate = date ( "Y-m-d" );
$data = array(
    'dateStart' => $dateStart,
    'dateEnd' => $dateEnd,
    'minDate' => ONLINEDATE,
    'maxDate' => $maxDate,
    'role_name' => $roleName,
    'account_name' => $accountName,
    'lookingday' => $lookingday,
    
    'counts' => $counts,
    'record' => $record,
    'pagelist' => $pagelist,
    'pageCount' => $pageCount,
    'pageno' => $pageno,
    
    'lang' => $lang,
    'arrItemsAll' => $arrItemsAll,
    'dictNpc' => $dictNpc,
    'viewData' => $viewData,
);


$smarty->assign ($data);

$smarty->display("module/item/npc_sell_items.tpl");

function getNpcSellData($where,$startNum,$record,&$counts) {

	// npc商店
	$sql1 = "select 
		shop_npc_id, item_id, 
		sum(if(money_type=1, price*item_cnt, 0)) as all_cost_m, sum(if(money_type=1, item_cnt, 0)) as item_cnt_m, sum(if(money_type=1, 1, 0)) as buy_cnt_m, 
		sum(if(money_type=2, price*item_cnt, 0)) as all_cost_g, sum(if(money_type=2, item_cnt, 0)) as item_cnt_g, sum(if(money_type=2, 1, 0)) as buy_cnt_g, 
		sum(if(money_type=3, price*item_cnt, 0)) as all_cost_b, sum(if(money_type=3, item_cnt, 0)) as item_cnt_b, sum(if(money_type=3, 1, 0)) as buy_cnt_b, 
		sum(if(money_type>3, price*item_cnt, 0)) as all_cost_i, sum(if(money_type>3, item_cnt, 0)) as item_cnt_i, sum(if(money_type>3, 1, 0)) as buy_cnt_i 
		from t_log_npc_shop_buy 
		where {$where}
		group by shop_npc_id, item_id ";

	
	//神秘商店
	$sql2 = "select 
		npc_id as shop_npc_id, item_id, 
		sum(if(money_type=1, price*item_sum, 0)) as all_cost_m, sum(if(money_type=1, item_sum, 0)) as item_cnt_m, sum(if(money_type=1, 1, 0)) as buy_cnt_m, 
		sum(if(money_type=2, price*item_sum, 0)) as all_cost_g, sum(if(money_type=2, item_sum, 0)) as item_cnt_g, sum(if(money_type=2, 1, 0)) as buy_cnt_g, 
		sum(if(money_type=3, price*item_sum, 0)) as all_cost_b, sum(if(money_type=3, item_sum, 0)) as item_cnt_b, sum(if(money_type=3, 1, 0)) as buy_cnt_b, 
		sum(if(money_type>3, price*item_sum, 0)) as all_cost_i, sum(if(money_type>3, item_sum, 0)) as item_cnt_i, sum(if(money_type>3, 1, 0)) as buy_cnt_i 
		from t_log_shop_rand 
		where {$where} AND is_buy=1
		group by item_id ";


	$sql = "{$sql1} union all {$sql2} order by shop_npc_id, item_id limit {$startNum},{$record} ";
	
	$data = GFetchRowSet($sql);
		
	$sqlCount = "select count(*) as cnt from ({$sql1} union all {$sql2} ) t1 ";
	$ret = GFetchRowOne($sqlCount);
	$counts = $ret['cnt'];
	
	return $data;
}