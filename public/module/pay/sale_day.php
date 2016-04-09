<?php

/**
 * sale_day.php
 * Author: HuangHaiQing
 * Create on 2014-06-26 
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

$arrItems = $arrItemsAll;
$arrSale = $dictSaleDay;

foreach ($arrSale as $a_k => $a_v) {
    $values[$a_k] = $a_v['itemID'];
}
$item_id = implode(',', $values);

foreach ($arrItems as $key => $val) {
    foreach ($values as $v_k => $v_v) {
        if ($val['id'] == $v_v) {
            $arr[$key]['item_name'] = $val['name'];
            $arr[$key]['item_id'] = $val['id'];
        }
    }
}


$where = " item_id in({$item_id}) and mtime>={$startTime} AND mtime<={$endTime} ";

$data = getSaleDayData($where);
foreach ($data as $d_k => $d_v) {
    foreach ($arr as $arr_k => $arr_v) {
        if ($arr_v['item_id'] == $d_v['item_id']) {
            $viewData[date('Y-m-d', $d_v['mtime'])][$d_k]['item_id'] = $d_v['item_id'];
            $viewData[date('Y-m-d', $d_v['mtime'])][$d_k]['item_name'] = $arr_v['item_name'];
            $viewData[date('Y-m-d', $d_v['mtime'])][$d_k]['total_person'] = $d_v['total_person'];
        }
    }
}

$smarty->assign('viewData', $viewData);
$smarty->assign('dateEnd', $dateEnd);
$smarty->assign('dateStart', $dateStart);
$smarty->assign('lang', $lang);
$smarty->display("module/pay/sale_day.tpl");

function getSaleDayData($where) {
    $sql = "select count(distinct(uuid))  as total_person ,item_id,mtime from t_log_item  where  {$where} group by item_id,year,month,day";
    $totalList = GFetchRowSet($sql);
    return $totalList;
}