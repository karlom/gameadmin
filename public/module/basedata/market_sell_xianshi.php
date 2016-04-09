<?php
/**
 * 市场挂单记录
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT.'/dict.php';
include_once SYSDIR_ADMIN_DICT.'/arrItemsAll.php';
global $lang;

$dateOnline = ONLINEDATE;

list($page, $pageSize) = getPagesParams();// 从请求中获取分页参数

// 时间处理
if (! isset($_REQUEST['dateStart'])){
	$dateStart = date('Y-m-d',strtotime('-6day'));
	if ((strtotime($dateStart) - strtotime(ONLINEDATE)) < 0) {
		$dateStart = ONLINEDATE;
	}
}elseif ($_REQUEST['dateStart'] == 'ALL'){
	$dateStart = ONLINEDATE;
}else{
	$dateStart = trim(SS($_REQUEST['dateStart']));
}

if (! isset($_REQUEST['dateEnd'])){
	$dateEnd = strftime("%Y-%m-%d", time());
}elseif ($_REQUEST['dateStart'] == 'ALL'){
	$dateEnd = strftime("%Y-%m-%d", time());
}else{
	$dateEnd = trim(SS($_REQUEST['dateEnd']));
}
$dateStartStamp = strtotime($dateStart . ' 0:0:0');
$dateEndStamp = strtotime($dateEnd . ' 23:59:59');

$dateStartStamp = intval($dateStartStamp) > 0 ? intval($dateStartStamp) : intval(strtotime(ONLINEDATE));
$dateEndStamp = intval($dateEndStamp) > 0 ? intval($dateEndStamp) : time();

$dateStartStr = strftime("%Y-%m-%d", $dateStartStamp);
$dateEndStr = strftime("%Y-%m-%d", $dateEndStamp);

$item_id = SS($_REQUEST['itemid']);
if(!empty($item_id)) {
	$item_name = $arrItemsAll[$item_id]['name'];
}

$rs = getData($dateStartStamp, $dateEndStamp, $item_id);

if(!empty($rs)){
	foreach($rs as $k => $v){
		$rs[$k]['item_name'] = $arrItemsAll[$v['item_id']]['name'];
		$rs[$k]['price'] = $v['item_num'] ? round($v['sell_rmb']/$v['item_num'], 2) : 0;
	}
}


//$smarty->assign("billType", $billType);
//$smarty->assign("billState", $billState);
//$smarty->assign("type", $type);
//$smarty->assign("state", $state);
//$smarty->assign("roleName", $roleName);
$smarty->assign("item_id", $item_id);
$smarty->assign("item_name", $item_name);
$smarty->assign("rs", $rs);
$smarty->assign("dateStart", $dateStartStr);
$smarty->assign("dateEnd", $dateEndStr);
$smarty->assign("lang", $lang);
$smarty->assign("dateOnline", $dateOnline);
$smarty->assign("pager", $pager);


$smarty->display("module/basedata/market_sell_xianshi.tpl");


function getData($dateStartStamp, $dateEndStamp, $item_id){
	if(!empty($item_id)){
		$sql = "select s.item_id, s.item_num , s.sell_rmb, s.role_name as s_role_name, s.account_name as s_account_name, b.account_name, b.role_name , b.mdate from t_log_market_buy b, t_log_market_sell s " .
				" where s.market_id = b.market_id and b.mtime>={$dateStartStamp} and b.mtime<={$dateEndStamp} and b.use_rmb > 0 and s.item_id={$item_id}" .
				" order by sell_rmb desc ";	
	} else {
		$sql = "select s.item_id, sum(s.item_num) as item_num, sum(s.sell_rmb) as sell_rmb from t_log_market_buy b, t_log_market_sell s " .
				" where s.market_id = b.market_id and b.mtime>={$dateStartStamp} and b.mtime<={$dateEndStamp} and b.use_rmb > 0 " .
				" group by item_id order by sell_rmb desc ";		
	}

	$rs = GFetchRowSet($sql);
	return $rs;
}