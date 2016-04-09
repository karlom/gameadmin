<?php
/**
 * gold_double.php
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';

$today = date( 'Y-m-d' );
$todayTimestamp = strtotime($today);

$openTimestamp = strtotime(ONLINEDATE);

if(isset($_REQUEST['startDate'])) {
	$startDate = SS($_REQUEST['startDate']);
} else {
	$startDate = date('Y-m-d', $todayTimestamp - 6*86400) ;
}
if(isset($_REQUEST['endDate'])) {
	$endDate = SS($_REQUEST['endDate']);
} else {
	$endDate = $today ;
}

$viewData = getGoldDoubleData($startDate, $endDate);

$smarty->assign("minDate", ONLINEDATE);
$smarty->assign("maxDate", $today);
$smarty->assign("startDate", $startDate);
$smarty->assign("endDate", $endDate);
$smarty->assign("lang", $lang);
$smarty->assign("viewData", $viewData);
$smarty->display("module/item/gold_double.tpl");
function getGoldDoubleData($startDate, $endDate){
    $startTime = strtotime($startDate." 00:00:00 ");
	$endTime = strtotime($endDate." 23:59:59 ");
    
    $goldType="20259";//不绑定
    $liquanType="50259";//绑定

    $gold=50;
    
    $goldSql="select account_name,role_name,gold,type,mtime from t_log_gold where mtime>={$startTime} and mtime<={$endTime} and type={$goldType}"; //仙石翻倍数据
    $goldResult=GFetchRowSet($goldSql);
    
    $liqunSql="select account_name,role_name,liquan,type,mtime from t_log_liquan where mtime>={$startTime} and mtime<={$endTime} and type={$liquanType}";  //绑定仙石翻倍数据
    $liquanResult = GFetchRowSet($liqunSql);

    $arr = array('goldTotal' => 0, 'liquanTotal' => 0, 'five' => 0, 'ten' => 0, 'twenty' => 0, 'thirty' => 0, 'five_person' => 0, 'ten_person' => 0, 'twenty_person' => 0, 'thirty_person' => 0);
    foreach ($goldResult as $gk => $gv) {
        foreach ($liquanResult as $lk => $lv) {
            if ($gv['mtime'] == $lv['mtime'] && $gv['account_name'] == $lv['account_name']) {
                $result[$gk]['beishu'] = $lv['liquan'] / $gv['gold'] * -1;
            }
        }
    }

    if ($result) {
        foreach ($result as $k => $v) {
            if ($v['beishu'] == 5) {
                $arr['five_person']+=1;
                $arr['five'] = $arr['five_person'] * $gold * 5;
            } else if ($v['beishu'] == 10) {
                $arr['ten_person']+=1;
                $arr['ten'] = $arr['ten_person'] * $gold * 10;
            } else if ($v['beishu'] == 20) {
                $arr['twenty_person']+=1;
                $arr['twenty'] = $arr['twenty_person'] * $gold * 20;
            } else if ($v['beishu'] == 30) {
                $arr['thirty_person']+=1;
                $arr['thirty'] = $arr['thirty_person'] * $gold * 30;
            }
        }
        $arr['goldTotal'] = $arr['five_person'] + $arr['ten_person'] + $arr['twenty_person'] + $arr['thirty_person'];
        $arr['liquanTotal'] = $arr['five'] + $arr['ten'] + $arr['twenty'] + $arr['thirty'];
    }
    return $arr;
}