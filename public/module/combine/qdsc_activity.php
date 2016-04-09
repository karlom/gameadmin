<?php

/**
 * qdsc_activity.php
 * 【合服庆典商城】 数据统计
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';

$today = date('Y-m-d');
$onlineDate=ONLINEDATE;

$startDay = strtotime($onlineDate);
$endDay = strtotime($onlineDate) + 86400 * 5;

$lzsx=  getLjsxData($startDay, $endDay);
$i=1;
foreach ($lzsx as $k1=>$v1){
    $lzsxData[$v1['mtime']]['mtime']='第'.$i.'天'. date('Y-m-d', $v1['mtime']);
    $lzsxData[$v1['mtime']]['ljsx_count']=$v1['ljsx_count'];
    $i++;
}

$xhxsData=  getXhxsData($startDay, $endDay);
$xhtbData= getXhtbData($startDay, $endDay);

$smarty->assign('onlineDate', $onlineDate);
$smarty->assign('lzsxData',$lzsxData);
$smarty->assign('xhxsData',$xhxsData);
$smarty->assign('xhtbData',$xhtbData);
$smarty->assign('today', $today);
$smarty->assign('lang', $lang);
$smarty->display('module/combine/qdsc_activity.tpl');

function getLjsxData($startDay, $endDay) {
    $type=20245;  //立即刷新type
    $sql = "select sum(gold) as ljsx_count,mtime from t_log_gold where mtime>={$startDay} and mtime<={$endDay} and type={$type} group by year,month,day"; 
    $result = GFetchRowSet($sql);   
    return $result;
}

function getXhxsData($startDay, $endDay) {
    $type=20246;  //消耗仙石type
    $sql = "select sum(gold) as xhxs_count,count(distinct uuid) as person_count,count(uuid) as count,mtime from t_log_gold where mtime>={$startDay} and mtime<={$endDay} and type={$type} group by year,month,day";
    $result = GFetchRowSet($sql);
    $i=1;
    foreach ($result as $key => $val) {
        $res['mtime'] = date('Y-m-d', $val['mtime']);
        $data[$i]['mtime'] = $res['mtime'];
        $data[$i]['person_count'] = $val['person_count'];
        $data[$i]['count'] = $val['count'];
        if ($val['xhxs_count'] < 0) {
           $data[$i]['xhxs_count'] = $val['xhxs_count']*-1;
        }else{
            $data[$i]['xhxs_count'] = $val['xhxs_count'];
        }
        $i++;
    }
    return $data;
}

function getXhtbData($startDay, $endDay) {
    $type=30246;  //消耗铜币type
    $sql = "select sum(money) as xhtb_count,count(distinct uuid) as person_count,count(uuid) as count,mtime from t_log_money where mtime>={$startDay} and mtime<={$endDay} and type={$type} group by year,month,day"; 
    $result = GFetchRowSet($sql);
    $i=1;
    foreach ($result as $key => $val) {
        $res['mtime'] = date('Y-m-d', $val['mtime']);
        $data[$i]['mtime'] = $res['mtime'];
        $data[$i]['person_count'] = $val['person_count'];
        $data[$i]['count'] = $val['count'];
        if($val['xhtb_count'] < 0){
           $data[$i]['xhtb_count'] = $val['xhtb_count']*-1;
        }else{
            $data[$i]['xhtb_count'] = $val['xhtb_count'];
        }
        $i++;
    }
    
    return $data;
}