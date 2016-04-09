<?php

/**
 * zlwz_activity.php
 * 【合服战力王者】 数据统计
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';

$today = date('Y-m-d');
$onlineDate=ONLINEDATE;

$startDay = strtotime($onlineDate);
$endDay = strtotime($onlineDate) + 86400 * 5;


$viewData = getZlwzData($startDay, $endDay);

$viewInfo=getZlwzInfo($startDay, $endDay);

$smarty->assign('onlineDate', $onlineDate);
$smarty->assign('viewData', $viewData);
$smarty->assign('viewInfo', $viewInfo);
$smarty->assign('today', $today);
$smarty->assign('lang', $lang);
$smarty->display('module/combine/zlwz_activity.tpl');

function getZlwzData($startDay, $endDay) {
    $item_id=17861;
    $sql = "select count(*) as count,mtime from t_log_item where mtime>={$startDay} and mtime<={$endDay} and item_id={$item_id} group by year,month,day"; 
    $result = GFetchRowSet($sql);
    $i=1;
    foreach ($result as $key => $val) {
        $res['mtime'] = date('Y-m-d', $val['mtime']);
        $data[$i]['mtime'] = $res['mtime'];
        $data[$i]['count'] = $val['count'];
        $i++;
    }
    
    return $data;
}

function getZlwzInfo($startDay, $endDay) {
    $item_id=17860;
    $sql = "select i.uuid,i.role_name,l.zhandouli,l.account_name from t_log_item i left join t_log_login l on i.uuid=l.uuid  where i.mtime>={$startDay} and i.mtime<={$endDay} and i.item_id={$item_id}"; 
    $result = GFetchRowSet($sql);
    foreach ($result as $k =>$v){
        $arr=explode("-",$v['account_name']);
        $data[$k]['uuid']=$v['uuid'];
        $data[$k]['role_name']=$v['role_name'];
        $data[$k]['server_id']=$arr[0];
        $data[$k]['zhandouli']=$v['zhandouli'];
    }
    return $data;
}