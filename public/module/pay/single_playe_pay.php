<?php

/**
 * single_playe_pay.php
 * Author: HuangHaiQing
 * Create on 2014-04-08 
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';

if (!isset($_REQUEST['dateStart'])) {
    $dateStart = date('Y-m-d');
    $dateEnd = date('Y-m-d');
} else {
    $dateStart = $_REQUEST['dateStart'];
    $dateEnd = $_REQUEST['dateEnd'];
}

$roleName = $_POST['role_name'];
$accountName = $_POST['account_name'];

$startTime = strtotime($dateStart);
$endTime = strtotime($dateEnd . "23:59:59");

$where = " mtime>={$startTime} AND mtime<={$endTime} ";
$data=array();
if ($roleName) {
    $where .= " AND role_name='{$roleName}' ";
   $data=getBuyGoodsData($where);
}
if ($accountName) {
    $where .= " AND account_name='{$accountName}' ";
    $data=getBuyGoodsData($where);
}

function getBuyGoodsData($where){
     $sql = "select account_name, role_name,pf,sum(`total_cost` + `pubacct` + `amt`/10) AS total_pay from t_log_buy_goods 
         where  {$where} group by pf";
    $TotalList = GFetchRowSet($sql);
   return $TotalList;
}
$smarty->assign('data', $data);
$smarty->assign('dateEnd', $dateEnd);
$smarty->assign('dateStart', $dateStart);
$smarty->assign('roleName', $roleName);
$smarty->assign('accountName', $accountName);
$smarty->assign('lang', $lang);
$smarty->display("module/pay/single_playe_pay.tpl");
