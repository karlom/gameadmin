<?php
/**
 * Q仙基金数据概览
 * Author: liangchuang                      
 * 2013-11-21 
 *
 */
include_once "../../../protected/config/config.php";
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';
global $lang;

$sql = "select role_name,sum(item_cnt) as item_cnt from " . T_LOG_BUY_GOODS . " where item_id = 88 group by role_name";
$viewData = GFetchRowSet($sql);

$smarty->assign("viewData", $viewData);
$smarty->assign("totalData", $totalData);
$smarty->assign("dateStart", $dateStart);
$smarty->assign("lang", $lang);
$smarty->display("module/pay/qxian.tpl");
?>
