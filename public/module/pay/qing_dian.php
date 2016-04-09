<?php

/**
 * sale_day.php
 * Author: HuangHaiQing
 * Create on 2014-09-23 
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/arrItemsAll.php';
include_once SYSDIR_ADMIN_DICT . '/SaleDay.php';

if (!isset($_REQUEST['dateStart'])) {
    $dateStart = date('Y-m-d');
    $dateEnd = date('Y-m-d');
} else {
    $dateStart = $_REQUEST['dateStart'];
    $dateEnd = $_REQUEST['dateEnd'];
}

$startTime = strtotime($dateStart);
$endTime = strtotime($dateEnd . "23:59:59");

$tuhao_data = getTuhaoData($startTime, $endTime);
$lucky_data = getLuckyData($startTime, $endTime);

$smarty->assign('dateEnd', $dateEnd);
$smarty->assign('dateStart', $dateStart);
$smarty->assign('tuhao_data', $tuhao_data);
$smarty->assign('lucky_data', $lucky_data);
$smarty->assign('lang', $lang);
$smarty->display("module/pay/qing_dian.tpl");

function getTuhaoData($startTime, $endTime) {
    $sql01 = "select count(*) as tuhao_person ,phase,pf,mtime from t_log_paycost_tuhao where mtime between {$startTime} and {$endTime} group by phase";
    $result01 = GFetchRowSet($sql01);
    foreach ($result01 as $k => $v) { 
            $res[$v['phase']]['tuhao_person']=$v['tuhao_person'];
            $res[$v['phase']]['phase'] = $v['phase'];
            $res[$v['phase']]['pf'] = $v['pf']; 
    }
    return $res;
}
function getLuckyData($startTime, $endTime) {
    $sql02="select b.account_name,b.liquan,a.account_name,a.role_name,a.type,a.pf,a.mtime,b.mtime from(
            select account_name ,role_name,type,pf,mtime from t_log_paycost_lucky where mtime between {$startTime} and {$endTime} and type in(1,2))a ,
            t_log_liquan b where b.mtime between {$startTime} and {$endTime} and b.account_name=a.account_name and a.mtime=b.mtime";
    $result02 = GFetchRowSet($sql02);

    foreach ($result02 as $k => $v) {
        if($v['liquan']<0){
            $v['liquan'] = $v['liquan']* -1;
        }
        $res[$v['type']][$k]['role_name'] = $v['role_name'];
        $res[$v['type']][$k]['total'] = $v['liquan'];
        $res[$v['type']][$k]['type'] = $v['type'];
        $res[$v['type']][$k]['pf'] = $v['pf'];
    }
    return $res;
}
