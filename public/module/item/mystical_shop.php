<?php
/**
 * mystical_shop.php
 * 神秘商店统计
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/arrItemsAll.php';
include_once SYSDIR_ADMIN_DICT . '/npc.php';

//$roleName = $_POST['role_name'] ; 
//$accountName = $_POST['account_name'] ; 

$lookingday = $_POST['lookingday'];

$today = date("Y-m-d");

/*
//获取时间段
if (! isset ( $_POST ['starttime'] )){
    $dateStart = Datatime::getPrevWeekString ();
}else{
    $dateStart = SS ( $_POST ['starttime'] );
}

$dateStart = (strtotime($dateStart) >= strtotime(ONLINEDATE)) ? $dateStart : ONLINEDATE;
$dateEnd = ! isset ($_POST['endtime']) ? Datatime::getTodayString() :  SS ($_POST['endtime']);
*/

$dateEnd = $dateStart = isset($_POST['starttime']) ? SS ( $_POST ['starttime'] ) : Datatime::getTodayString();

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
/*
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

*/

$viewData = getNpcSellData($where);

//print_r($viewData);

$lookingday = $dateEnd;
$maxDate = date ( "Y-m-d" );
$data = array(
    'dateStart' => $dateStart,
    'dateEnd' => $dateEnd,
    'minDate' => ONLINEDATE,
    'maxDate' => $maxDate,
//    'role_name' => $roleName,
//    'account_name' => $accountName,
    'lookingday' => $lookingday,
    
//    'counts' => $counts,
//    'record' => $record,
//    'pagelist' => $pagelist,
//    'pageCount' => $pageCount,
//    'pageno' => $pageno,
    
    'lang' => $lang,
//    'arrItemsAll' => $arrItemsAll,
//    'dictNpc' => $dictNpc,
    'viewData' => $viewData,
);


$smarty->assign ($data);

$smarty->display("module/item/mystical_shop.tpl");

function getNpcSellData($where) {

	global $arrItemsAll;
	
	$data = array();
	
	//神秘商店

	//查看次数、购买次数，计算欢迎度
	$sqlLook = "select item_id, item_sum, " .
			" sum(if(grid_num<=4 and is_buy=0, 1, 0)) as look_cnt, sum(if(grid_num>=5 and is_buy=0 and is_vip=1, 1, 0)) as vip_look_cnt, " .
			" sum(if(grid_num<=4 and is_buy=1, 1, 0)) as buy_cnt, sum(if(grid_num>=5 and is_buy=1 and is_vip=1, 1, 0)) as vip_buy_cnt " .
			" from t_log_shop_rand " .
			" where {$where} " .
			" and (( money_type=1 and yinliang>=price ) or ( money_type=2 and yuanbao>=price ))" .
			" group by item_id";
//	echo $sqlLook;
	$sqlLookResult = GFetchRowSet($sqlLook);
//	print_r($sqlLookResult);
	$buyRate = array();
	$vipBuyRate = array();
	
	if(!empty($sqlLookResult)){
		$i = 1;
		foreach($sqlLookResult as $k => $v){

//			$buyRate[]['item_id'] = $v['item_id'];
//			$buyRate[]['item_name'] = $arrItemsAll[$v['item_id']]['name'].'x'.$v['item_sum'];
//			$buyRate[]['rate'] = $v['buy_cnt'] ? round($v['buy_cnt']/$v['look_cnt']*100, 2) : 0 ;
			
			if($v['look_cnt'] > 0){
				$buyRate[] = array(
					'item_id' => $v['item_id'],
					'item_name' => $arrItemsAll[$v['item_id']]['name'].'x'.$v['item_sum'],
					'rate' => $v['buy_cnt'] ? round($v['buy_cnt']/$v['look_cnt'], 4) : 0 ,
				);
			}
			
//			$vipBuyRate[]['item_id'] = $v['item_id'];
//			$vipBuyRate[]['item_name'] = $arrItemsAll[$v['item_id']]['name'].'x'.$v['item_sum'];
//			$vipBuyRate[]['rate'] = $v['vip_buy_cnt'] ? round($v['vip_buy_cnt']/$v['vip_look_cnt']*100, 2) : 0 ;
			
			if($v['vip_look_cnt'] > 0){
				$vipBuyRate[] = array(
					'item_id' => $v['item_id'],
					'item_name' => $arrItemsAll[$v['item_id']]['name'].'x'.$v['item_sum'],
					'rate' => $v['vip_buy_cnt'] ? round($v['vip_buy_cnt']/$v['vip_look_cnt'], 4) : 0 ,
				);				
			}
			
		}
		$buyRate = sortArrayByKey($buyRate,'rate');
		$vipBuyRate = sortArrayByKey($vipBuyRate,'rate');
		
		$i = 1;
		foreach($buyRate as $k => $v){
			$buyRate[$k]['no'] = $i;
			$i ++;
		}
		$i = 1;
		foreach($vipBuyRate as $k => $v){
			$vipBuyRate[$k]['no'] = $i;
			$i ++;
		}
	}
	
	
	//铜币、仙石消耗排行、总量，非vip商品
	$sqlMoneyBuy = "select item_id, item_sum, sum(price) as buy_sum " .
			" from t_log_shop_rand " .
			" where {$where} " .
			" and is_buy=1 and money_type=1 and grid_num<=4" .
			" group by item_id order by buy_sum desc ";
//	echo $sqlMoneyBuy;
	$moneyBuy = GFetchRowSet($sqlMoneyBuy);
	$moneyBuySum = 0;
	if(!empty($moneyBuy)){
		$i = 1;
		foreach($moneyBuy as $k => $v){
			$moneyBuy[$k]['no'] = $i;
			$moneyBuy[$k]['item_name'] = $arrItemsAll[$v['item_id']]['name'].'x'.$v['item_sum'];
			$i ++;
			$moneyBuySum += $v['buy_sum'];
		}
	}
	
	$sqlXianshiBuy = "select item_id, item_sum, sum(price) as buy_sum " .
			" from t_log_shop_rand " .
			" where {$where} " .
			" and is_buy=1 and money_type=2 and grid_num<=4" .
			" group by item_id order by buy_sum desc ";
	$xianshiBuy = GFetchRowSet($sqlXianshiBuy);
	$xianshiBuySum = 0;
	if(!empty($xianshiBuy)){
		$i = 1;
		foreach($xianshiBuy as $k => $v){
			$xianshiBuy[$k]['no'] = $i;
			$xianshiBuy[$k]['item_name'] = $arrItemsAll[$v['item_id']]['name'].'x'.$v['item_sum'];;
			$i ++;
			$xianshiBuySum += $v['buy_sum'];
		}
	}

	//铜币、仙石消耗排行、总量，vip商品
	$sqlVipMoneyBuy = "select item_id, item_sum, sum(price) as buy_sum " .
			" from t_log_shop_rand " .
			" where {$where} " .
			" and is_buy=1 and money_type=1 and grid_num>=5" .
			" group by item_id order by buy_sum desc ";
	$vipMoneyBuy = GFetchRowSet($sqlVipMoneyBuy);
	$vipMoneyBuySum = 0;
	if(!empty($vipMoneyBuy)){
		$i = 1;
		foreach($vipMoneyBuy as $k => $v){
			$vipMoneyBuy[$k]['no'] = $i;
			$vipMoneyBuy[$k]['item_name'] = $arrItemsAll[$v['item_id']]['name'].'x'.$v['item_sum'];
			$i ++;
			$vipMoneyBuySum += $v['buy_sum'];
		}
	}
	
	$sqlVipXianshiBuy = "select item_id, item_sum, sum(price) as buy_sum " .
			" from t_log_shop_rand " .
			" where {$where} " .
			" and is_buy=1 and money_type=2 and grid_num>=5" .
			" group by item_id order by buy_sum desc ";
	$vipXianshiBuy = GFetchRowSet($sqlVipXianshiBuy);
	$vipXianshiBuySum = 0;
	if(!empty($vipXianshiBuy)){
		$i = 1;
		foreach($vipXianshiBuy as $k => $v){
			$vipXianshiBuy[$k]['no'] = $i;
			$vipXianshiBuy[$k]['item_name'] = $arrItemsAll[$v['item_id']]['name'].'x'.$v['item_sum'];
			$i ++;
			$vipXianshiBuySum += $v['buy_sum'];
		}
	}
	
	
	//手动刷新次数
	$sql = "select count(*) as cnt from t_log_gold where {$where} and type=20064 ";
	$result = GFetchRowOne($sql);
	$refreshCount = $result['cnt'] ? $result['cnt'] : 0 ;
	
	$data = array(
	
		'buyRate' => $buyRate,
		'moneyBuy' => $moneyBuy,
		'xianshiBuy' => $xianshiBuy,
		'buySum' => array(
			'moneyBuySum' => $moneyBuySum,
			'xianshiBuySum' => $xianshiBuySum,
		),
		
		'vipBuyRate' => $vipBuyRate,
		'vipMoneyBuy' => $vipMoneyBuy,
		'vipXianshiBuy' => $vipXianshiBuy,
		'vipBuySum' => array(
			'vipMoneyBuySum' => $vipMoneyBuySum,
			'vipXianshiBuySum' => $vipXianshiBuySum,
		),
		
		'refreshCount' => $refreshCount,
	);
	
	return $data;
}