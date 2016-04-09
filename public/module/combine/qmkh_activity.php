<?php

/**
 * qmkh_activity.php
 * 【合服全民狂欢】 数据统计
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';

$today = date('Y-m-d');

$onlineDate=ONLINEDATE;

$startDay = strtotime($onlineDate);
$endDay = strtotime($onlineDate) + 86400 * 5;

$view = getQmkhData($startDay, $endDay);
$i=1;
foreach ($view as $k => $val) {
    foreach ($val as $v) {
        $viewData[$v['mtime']]['mtime'] ='第'.$i.'天'. date('Y-m-d', $v['mtime']);
        $viewData[$v['mtime']]['count'] = $v['count'];
    }
    $i++;
}

$smarty->assign('onlineDate', $onlineDate);
$smarty->assign('viewData', $viewData);
$smarty->assign('today', $today);
$smarty->assign('lang', $lang);
$smarty->display('module/combine/qmkh_activity.tpl');

function getQmkhData($startDay, $endDay) {
    $itemId = array(
        '17847' => 17847,
        '17848' => 17848,
        '17849' => 17849,
        '17850' => 17850,
        '17851' => 17851,
    );

    foreach ($itemId as $v) {
        $sql = "select count(*) as count,mtime from t_log_item where mtime>={$startDay} and mtime<={$endDay} and item_id={$v} group by year,month,day";
        $result[$v] = GFetchRowSet($sql);
    }
    return $result;
}