<?php
/**
 * 游戏货币产出/使用/流通
 *
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_LANG . '/zh-cn.php';
global $lang;

//1.怪物掉落，2.道具出售，3.任务奖励，4.其他

$today = date( 'Y-m-d' );
$todayTimestamp = strtotime($today);

$openTimestamp = strtotime(ONLINEDATE);

if(isset($_REQUEST['startDate'])) {
	$startDate = SS($_REQUEST['startDate']);
} else {
	$startDate = date('Y-m-d', $todayTimestamp - 7*86400) ;
}
if(isset($_REQUEST['endDate'])) {
	$endDate = SS($_REQUEST['endDate']);
} else {
	$endDate = $today ;
}
if(isset($_REQUEST['roleName'])){
	$roleName = SS($_REQUEST['roleName']);
}

$startDateTimestamp = strtotime($startDate);
$endDateTimestamp = strtotime($endDate." 23:59:59");

if($startDateTimestamp < $openTimestamp){
	$startDate = ONLINEDATE;
	$startDateTimestamp = strtotime($startDate);
}
if($endDateTimestamp > $todayTimestamp) {
	$endDate = $today ;
	$endDateTimestamp = strtotime($endDate." 23:59:59");
}


$moneyOutput = array();

//$circulate =  array(2,3,16,17,18); //银两流通操作类型
//银两产出

//$moneyOutput = array( 'all' => '',	'monster' => '',	'itemSell' => '',	'task' => '',	'other' => '',);

$moneyPlus = ' money > 0 ';
$moneyMinus = ' money < 0 ';

//所有产出，不包括交易、邮件、市场获得的银两
$condArrAllOut =  array( $moneyPlus, ' type not in (90002,90003,90018,90019,90020) ');
$output_all = getData($startDateTimestamp, $endDateTimestamp, $condArrAllOut);
insertIntoArray($moneyOutput, $output_all, "all");

//怪物掉落
$condArrMonOut = array( $moneyPlus, ' type=90004 ');
$output_monster = getData($startDateTimestamp,$endDateTimestamp,$condArrMonOut);
insertIntoArray($moneyOutput, $output_monster, "monster");

//道具出售
$condArrItemOut = array( $moneyPlus, ' type=90026 ');
$output_item = getData($startDateTimestamp,$endDateTimestamp,$condArrItemOut);
insertIntoArray($moneyOutput, $output_item, "itemSell");

//任务产出
$condArrTaskOut = array( $moneyPlus, ' type in (90021,90022) ');
$output_task = getData($startDateTimestamp,$endDateTimestamp,$condArrTaskOut);
insertIntoArray($moneyOutput, $output_task, "task");

//除了以上所列之外的其他产出
$condArrOtherOut = array(' money > 0 ', ' type not in (90002,90003,90018,90019,90020,90004,90026,90021,90022) ');
$output_other = getData($startDateTimestamp,$endDateTimestamp,$condArrOtherOut);
insertIntoArray($moneyOutput, $output_other, "other");

//print_r($moneyOutput);die();
//填0
foreach($moneyOutput as $k => $v){
	if(!isset($v['monster'])){
		$moneyOutput[$k]['monster'] = 0;
	}
	if(!isset($v['itemSell'])){
		$moneyOutput[$k]['itemSell'] = 0;
	}
	if(!isset($v['task'])){
		$moneyOutput[$k]['task'] = 0;
	}
	if(!isset($v['other'])){
		$moneyOutput[$k]['other'] = 0;
	}
}

//银两消耗
//$moneyExpend = array('all' => '',	'itemBuy' => '',	'other' => '',);

$moneyExpend = array();

//所有消耗，不包括交易、邮件、市场所消耗的银两
$condArrAllExpend =  array( $moneyMinus , ' type not in (90002,90003,90018,90019,90020) ');
$expend_all = getData($startDateTimestamp, $endDateTimestamp, $condArrAllExpend);
insertIntoArray($moneyExpend, $expend_all, "all");

//道具购买
$condArrItemExpend =  array( $moneyMinus , ' type in (90027,90028,90029) ');
$expend_item = getData($startDateTimestamp, $endDateTimestamp, $condArrItemExpend);
insertIntoArray($moneyExpend, $expend_item, "itemBuy");
//装备增强
$condArrEquipmentExpend =  array( $moneyMinus , ' type in (90013,90014,90015,90016,90017) ');
$expend_equipment = getData($startDateTimestamp, $endDateTimestamp, $condArrEquipmentExpend);
insertIntoArray($moneyExpend, $expend_equipment, "equipmentStrengthen");
//境界提升
$condArrJingjieExpend =  array( $moneyMinus , ' type in (90048,90049,90050) ');
$expend_jingjie = getData($startDateTimestamp, $endDateTimestamp, $condArrJingjieExpend);
insertIntoArray($moneyExpend, $expend_jingjie, "jingjieUpgrade");
//家族捐献
$condArrFamilyExpend =  array( $moneyMinus , ' type in (90051) ');
$expend_family = getData($startDateTimestamp, $endDateTimestamp, $condArrFamilyExpend);
insertIntoArray($moneyExpend, $expend_family, "familyContribute");
//命符(猎命)消耗
$condArrHuntlifeExpend =  array( $moneyMinus , ' type in (90159) ');
$expend_huntlife = getData($startDateTimestamp, $endDateTimestamp, $condArrHuntlifeExpend);
insertIntoArray($moneyExpend, $expend_huntlife, "huntLife");
//其他
$condArrOtherExpend =  array( $moneyMinus , ' type not in (90002,90003,90018,90019,90027,90028,90029,90013,90014,90015,90016,90017,90048,90049,90050,90051,90159) ');
$expend_other = getData($startDateTimestamp, $endDateTimestamp, $condArrOtherExpend);
insertIntoArray($moneyExpend, $expend_other, "other");

//填0
foreach($moneyExpend as $k => $v){
	if(!isset($v['itemBuy'])){
		$moneyExpend[$k]['itemBuy'] = 0;
	}
	if(!isset($v['equipmentStrengthen'])){
		$moneyExpend[$k]['equipmentStrengthen'] = 0;
	}
	if(!isset($v['jingjieUpgrade'])){
		$moneyExpend[$k]['jingjieUpgrade'] = 0;
	}
	if(!isset($v['familyContribute'])){
		$moneyExpend[$k]['familyContribute'] = 0;
	}
	if(!isset($v['huntLife'])){
		$moneyExpend[$k]['huntLife'] = 0;
	}
	if(!isset($v['other'])){
		$moneyExpend[$k]['other'] = 0;
	}
}

//银两流通
//$moneyCirculate = array( 'all' => '',	'deal' => '',	'market' => ''	'gold' => '',	'goldRate' => '',);
$moneyCirculate = array();

$condArrAllCirc = array( $moneyMinus , ' type in (90002,90003,90018,90019,90020) ');
$circle_all = getData($startDateTimestamp, $endDateTimestamp, $condArrAllCirc);
insertIntoArray($moneyCirculate,$circle_all, "all");

$condArrDealCirc = array( $moneyMinus , ' type in (90002,90003) ');
$circle_deal = getData($startDateTimestamp, $endDateTimestamp, $condArrDealCirc);
insertIntoArray($moneyCirculate,$circle_deal, "deal");

$condArrMarketCirc = array( $moneyMinus , ' type = 90019 ', ' item_id <> 10005 ', ' item_id <> 10006 ');// 银两id=10005，元宝id=10006
$circle_market = getData($startDateTimestamp, $endDateTimestamp, $condArrMarketCirc);
insertIntoArray($moneyCirculate,$circle_deal, "market");


$need = " FROM_UNIXTIME(mtime,'%Y-%m-%d') AS date, SUM(money) AS money, SUM(num) AS gold ";
$condArrBuyGoldCirc = array( $moneyMinus , ' type = 90019 ', ' item_id = 10006 ');	// 元宝id=10006
$circle_buygold = getData($startDateTimestamp, $endDateTimestamp, $condArrBuyGoldCirc, $need);

foreach($circle_buygold as $k => $v){
	if(is_array($v)){
		if($v['money']){
			$moneyCirculate[$v['date']]['buyGold'] = $v['money'];
			$moneyCirculate[$v['date']]['goleRate'] = $v['money']/$v['gold'];
		} else {
			$moneyCirculate[$v['date']]['buyGold'] = 0;
			$moneyCirculate[$v['date']]['goleRate'] = 'N/A';
		}	
	}
}

//填0
foreach($moneyCirculate as $k => $v){
	if(!isset($v['all'])){
		$moneyCirculate[$k]['all'] = 0;
	}
	if(!isset($v['deal'])){
		$moneyCirculate[$k]['deal'] = 0;
	}
	if(!isset($v['market'])){
		$moneyCirculate[$k]['market'] = 0;
	}
	if(!isset($v['buyGold'])){
		$moneyCirculate[$k]['buyGold'] = 0;
	}
}

//print_r($moneyCirculate);

$data = array();
$data['moneyOutput'] = $moneyOutput;
$data['moneyExpend'] = $moneyExpend;
$data['moneyCirculate'] = $moneyCirculate;

$minDate = ONLINEDATE ;
$maxDate = $today;

$smarty->assign('startDate',$startDate);
$smarty->assign("endDate",$endDate);
$smarty->assign("minDate",$minDate);
$smarty->assign("maxDate",$maxDate);
$smarty->assign("lang",$lang);
$smarty->assign("data",$data);
$smarty->display("module/money/bind_money_output_and_usage.tpl");


function getData($startTime, $endTime, $andArray, $need=""){
	
	if($need == ""){
		$need = "FROM_UNIXTIME(mtime,'%Y-%m-%d') AS date, SUM(money) AS money";
	}
	$andArray[] = " mtime >= $startTime ";
	$andArray[] = " mtime < $endTime ";
	$cond =  implode( ' AND ', $andArray);
	$sql = "SELECT $need " .
			" FROM " . "t_log_bind_money" .
			" WHERE $cond " .
			" GROUP BY year,month,day";
//	echo $sql."<br/>";
	$result = GFetchRowSet($sql);
	return $result;
}

function insertIntoArray(&$array, $data, $key){
	foreach($data as $k => $v){
		if(is_array($v)){
			$array[$v['date']][$key] = ($v['money']?$v['money']:0 );
		}
	}
}