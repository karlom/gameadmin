<?php

/**
 * czhk_activity.php
 * 【合服充值回馈】 数据统计
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';

$today = date('Y-m-d');

$onlineDate=ONLINEDATE;

$startDay = strtotime($onlineDate);
$endDay = strtotime($onlineDate) + 86400 * 5;

$viewData = getCzhkData($startDay, $endDay);

$smarty->assign('viewData', $viewData);
$smarty->assign("onlineDate", $onlineDate);
$smarty->assign('today', $today);
$smarty->assign('lang', $lang);
$smarty->display('module/combine/czhk_activity.tpl');

function getCzhkData($startDay, $endDay) {
    $itemId = array(
        '17852' => 17852,
        '17853' => 17853,
        '17854' => 17854,
        '17855' => 17855,
        '17856' => 17856,
        '17857' => 17857,       
    );

    foreach ($itemId as $v) {
        $sql = "select count(*) as count,mtime from t_log_item where mtime>={$startDay} and mtime<={$endDay} and item_id={$v} group by year,month,day";
        $result[$v] = GFetchRowSet($sql);
    }
    
    foreach ($result as $key=>$val){
        foreach ($val as $v){
            $res['mtime']=date('Y-m-d',$v['mtime']);
            $data[ $res['mtime']][$key]['count']=$v['count'];
        }
    }
    return $data;
}