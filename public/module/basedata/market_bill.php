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
$roleName = SS($_REQUEST['roleName']);
if ( !empty($roleName) ) {
	if ( intval($_REQUEST['type']) == 4 ) {
		$ifRoleName = " AND b.role_name='$roleName' ";
	} else {
		$ifRoleName = " AND a.role_name='$roleName' ";
	}
} else {
	$ifRoleName = "";
}
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

//$dateStrPrev = strftime("%Y-%m-%d", $dateStartStamp - 86400);
//$dateStrToday = strftime("%Y-%m-%d");
//$dateStrNext = strftime("%Y-%m-%d", $dateStartStamp + 86400);

$type = empty($_REQUEST['type']) ? 3 : intval($_REQUEST['type']);
$state = empty($_REQUEST['state']) ? 0 : intval($_REQUEST['state']);

$countTmp = getSQLResult($state, $limit=null, $need = 'count', $type, $dateStartStamp, $dateEndStamp, $ifRoleName);
$count = $countTmp[0]['count'];
$pager = getPages2( $page, $count, $pageSize );
$limit = $page > 1 && empty($roleName) ? " limit " . (($page-1) * $pageSize) . ", $pageSize " : " limit 0, " . $pageSize;
$rs = getSQLResult($state, $limit, $need = 'result', $type, $dateStartStamp, $dateEndStamp, $ifRoleName);


for ( $i=0; $i<count($rs); $i++) {
	$rs[$i]['item_name'] = $arrItemsAll[$rs[$i]['item_id']]['name'];
	
	$tmp = getItemDetailArray($rs[$i]['detail']);
	if ( !empty($rs[$i]['detail']) ){
		$a['strengthen'] = $tmp['strengthen'];
		$a['quality'] = $tmp['quality'];
		$a['jinglian'] = $tmp['jinglian'];
//		$a['hole'] = "孔数：" . $tmp['hole'];
		if ( !empty($tmp['gems']) ){
			for ( $j=0; $j<count($tmp['gems']); $j++){
				$id = $tmp['gems'][$j];
				$gem[$j] = $arrItemsAll[$id];
			};
			$a['gem'] = "宝石：" . implode(",", $gem);
		};
		
//		$rs[$i]['item_detail'] = "详情：【 " . implode(" | ", $a) . " 】"; 
		$rs[$i]['item_detail'] = $a; 
	};
	if($rs[$i]['sell_rmb'] >0) {
		$rs[$i]['sell_type'] = '仙石';
	} else {
		$rs[$i]['sell_type'] = '铜币';
	}
	
};

$billType = array(1=>'求购仙石',2=>'仙石出售',3=>'道具出售',4=>'购买道具',5=>'铜币出售');
$billState = array(0=>'挂单中', 1=>'完成', 2=>'取消');


$smarty->assign("billType", $billType);
$smarty->assign("billState", $billState);
$smarty->assign("type", $type);
$smarty->assign("state", $state);
$smarty->assign("roleName", $roleName);
$smarty->assign("rs", $rs);
$smarty->assign("dateStart", $dateStartStr);
$smarty->assign("dateEnd", $dateEndStr);
$smarty->assign("lang", $lang);
$smarty->assign("dateOnline", $dateOnline);
$smarty->assign("pager", $pager);


$smarty->display("module/basedata/market_bill.tpl");

function getSQLResult($state, $limit, $need, $type, $dateStartStamp, $dateEndStamp, $ifRoleName){
	
	if( $need == 'count' ){
		$need = 'count(*) as count';
		if ( $type == 3 || $type == 4 ){
			$type = 0;
		};
	}else{
		switch ($type){
			case 3:
				$need = " a.market_id as market_id, a.uuid AS uuid, a.role_name as role_name, a.item_id as item_id, a.detail as detail, a.item_num as item_num, a.sell_rmb as sell_rmb, a.rmb as rmb, a.money as money, a.sell_money as sell_money, a.mdate as onSaleDate, b.mdate as dealDate ";
				$type = 0;
				break;
			case 4:
				$need = " b.market_id as market_id, b.uuid AS uuid,  b.role_name as role_name, a.item_id as item_id, a.detail as detail, a.item_num as item_num, b.use_rmb as sell_rmb, b.use_money as sell_money, b.mdate as mdate ";
				$type = 0;
				break;
			case 5:
				//出售银两
				$need = " a.market_id as market_id, a.uuid AS uuid, a.role_name as role_name, a.sell_money as sell_money, a.rmb as rmb, a.mdate as mdate ";
				$type = 1;
				break;
			default:
				$need = " a.market_id as market_id, a.uuid AS uuid, a.role_name as role_name, a.sell_rmb as sell_rmb, a.sell_money as sell_money, a.rmb as rmb, a.money as money, a.mdate as mdate ";
		}
	};
	
	if ( $state == 0){
		$sql = " SELECT {$need} FROM t_log_market_sell AS a LEFT JOIN (select market_id, mdate from t_log_market_buy) AS b ON a.market_id=b.market_id LEFT JOIN (select market_id from t_log_market_cancel_sell) AS c ON a.market_id = c.market_id WHERE b.market_id IS NULL AND c.market_id IS NULL AND a.`bill_type`={$type} AND a.`mtime` BETWEEN {$dateStartStamp} AND {$dateEndStamp} {$ifRoleName} ORDER BY a.mtime desc " ;
	} elseif ( $state == 1 ){
		$sql = "SELECT {$need} ,b.role_name as b_role_name FROM t_log_market_sell AS a INNER JOIN t_log_market_buy AS b on a.market_id=b.market_id WHERE a.bill_type={$type} and a.mtime BETWEEN {$dateStartStamp} AND {$dateEndStamp} {$ifRoleName} ORDER BY a.mtime desc ";
	} else {
		$sql = "SELECT {$need} FROM t_log_market_sell AS a INNER JOIN t_log_market_cancel_sell AS b on a.market_id=b.market_id WHERE a.bill_type={$type} and a.mtime BETWEEN {$dateStartStamp} AND {$dateEndStamp} {$ifRoleName} ORDER BY a.mtime desc ";
	}
	if ( !empty($limit) ){
		$rs = GFetchRowSet($sql.$limit);
	} else {
		$rs = GFetchRowSet($sql);
	}
	return $rs;
}