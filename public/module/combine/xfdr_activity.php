<?php

/**
 * xfdr_activity.php
 * 【合服消费达人】 数据统计
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';

$today = date('Y-m-d');

$onlineDate=ONLINEDATE;

$startDay = strtotime($onlineDate);
$endDay = strtotime($onlineDate) + 86400 * 5;

$viewData = getXfdrData($startDay, $endDay);

$smarty->assign("onlineDate", $onlineDate);
$smarty->assign('viewData', $viewData);
$smarty->assign('today', $today);
$smarty->assign('lang', $lang);
$smarty->display('module/combine/xfdr_activity.tpl');

function getXfdrData($startDay, $endDay) {
    $sql = "select count(distinct(uuid)) as person_count,sum(cnt) as cnt,mtime from t_log_merge_server_consume where mtime>={$startDay} and mtime<={$endDay} group by year,month,day"; //抽奖人数
    $result = GFetchRowSet($sql);
    $i=1;
    foreach ($result as $key => $val) {
        $res['mtime'] = date('Y-m-d', $val['mtime']);
        $data[$i]['mtime'] = $res['mtime'];
        $data[$i]['person_count'] = $val['person_count'];
        $data[$i]['cnt'] = $val['cnt'];
         $i++;
    }
   
    return $data;
}