<?php
/**
 * fsdg_statistics.php
 * 风蚀地宫 数据统计
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';
include_once SYSDIR_ADMIN_DICT.'/dict.php';

//副本开启时间：由玩家决定

$today = date('Y-m-d'); 
$todayTime = strtotime($today." 00:00:00 "); 
$todayEndTime = strtotime($today." 23:59:59 "); 

$startDay = $_REQUEST['startDay'] ? strtotime($_REQUEST['startDay']) :$todayTime - 6*86400; //地宫参与度时间
$endDay = $_REQUEST['endDay'] ? strtotime($_REQUEST['endDay']." 23:59:59") : strtotime($today);

$startTime = $_REQUEST['start_day'] ? strtotime($_REQUEST['start_day']) : $todayTime - 6*86400;  //捐献百分比时间
$endTime   = $_REQUEST['end_day'] ? strtotime($_REQUEST['end_day']." 23:59:59") : strtotime($today);

$beginDay=  $_REQUEST['beginDay'] ? strtotime($_REQUEST['beginDay']) :$todayTime - 6*86400;   //每日捐献数据时间
$overDay= $_REQUEST['overDay'] ? strtotime($_REQUEST['overDay']." 23:59:59") : strtotime($today);

$Data=getpersonCountData($beginDay,$overDay);
$res=array();
foreach ($Data as $d_k => $d_v){
  $res[$d_v['mtime']]['mtime']=date('Y-m-d',$d_v['mtime']);
  $res[$d_v['mtime']]['personCount']=$d_v['personCount'];
}

$juanxianData=getBaiFenBiData($startTime,$endTime) ;

$arr=array();
foreach ($juanxianData as $j_k => $j_v){
    if($j_v['count']==$j_v['count']){
        $arr[$j_v['count']]['count']+=$j_v['count'];    
    }
}

$total = array();
foreach ($arr as $a_k => $a_v) {
    $total['sum']+=$a_v['count'];   
}

$result= array();
foreach ($arr as $k => $v){
    $result[$v['count']]['bfbRate'] = $v['count'] ? round($v['count'] / $total['sum'], 4) * 100 : 0;
    $result[$v['count']]['height'] = $v['count'] / $total['sum'] * 120;
    $result[$v['count']]['img_name'] = (84 < $result[$v['count']]['height']) ? "red" : "green";
    $result[$v['count']]['alert'] = "捐献人数：{$v['count']}";
}
ksort($arr);

$viewData=getCanyuData($startDay,$endDay);

$smarty->assign('res', $res );
$smarty->assign('arr', $arr );
$smarty->assign('result', $result );
$smarty->assign('viewData', $viewData );

$smarty->assign('lang', $lang );
$smarty->assign('minDate', ONLINEDATE );
$smarty->assign('maxDate', $today );
$smarty->assign('startDay', date('Y-m-d',$startDay) );
$smarty->assign('endDay', date('Y-m-d',$endDay) );
$smarty->assign('beginDay', date('Y-m-d',$beginDay)  );
$smarty->assign('overDay', date('Y-m-d',$overDay) );
$smarty->assign('startTime', date('Y-m-d',$startTime)  );
$smarty->assign('endTime',date('Y-m-d',$endTime) );
$smarty->display('module/activity/fsdg_statistics.tpl');

function getpersonCountData($beginDay,$overDay) {  //每日捐献人数
    $sql="select count(distinct uuid) as personCount ,mtime from t_log_fsdg_contribute where mtime>='{$beginDay}' and mtime<='{$overDay}' group by year,month,day" ;
    $result = GFetchRowSet($sql);
    return $result;
}

function getBaiFenBiData($startTime,$endTime) {  //1~10次玩家的百分比分布
    $sql="select count(uuid) as count,mdate,role_name  from t_log_fsdg_contribute where mtime>={$startTime} and mtime <={$endTime} and uuid=uuid group by uuid,year,month,day";
    $result= GFetchRowSet($sql);
    return $result;
   
}

function getCanyuData($startDay,$endDay){ //地宫每日平均参与度
    $sql="select count(a1.uuid) as act_count,a1.mtime,a1.year,a1.month,a1.day from (select distinct(uuid),mtime, year,month,day from t_log_login where mtime>={$startDay} and mtime <={$endDay}  and level>35 and zhandouli >300000 ) a1   group by year,month,day ";
    $act_result=GFetchRowSet($sql);

    $sql="select  count(distinct(uuid)) as join_count,mtime,year,month,day FROM `t_log_copy` where mtime>={$startDay} and mtime <={$endDay} and copy_id=320 group by year,month,day";
    $join_result=GFetchRowSet($sql);
    
    foreach ($join_result as $jk =>$jv){  
        $res['jmtime']=date('Y-m-d',$jv['mtime']); 
        foreach ($act_result as $ak=>$av){
            $res['amtime']=date('Y-m-d',$av['mtime']);
            if($res['jmtime']==$res['amtime']){
                $data[$jv['mtime']]['mdate']=$res['jmtime'];
                $data[$jv['mtime']]['act_count']=$av['act_count'];
                $data[$jv['mtime']]['join_count']=$jv['join_count'];
                $data[$jv['mtime']]['joinRate'] = $av['act_count'] ? round($jv['join_count'] / $av['act_count'], 4) * 100 : 0;
            }
        }
    }
    return $data;
}
