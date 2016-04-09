<?php
/**
 * 在PVP地图中玩家被杀与流失关系的统计
 */
 
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/arrItemsAll.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';
include_once SYSDIR_ADMIN_DICT . '/map.php';

$time= date('Y-m-d',time());  //当前时间
$beginTime 	= strtotime($time . ' 00:00:00');   //开始时间0点时间戳
$endTime 	= strtotime($time . ' 23:59:59');     //结束时间末点时间戳
$tempTime=time()-86400*3;    //当前时间-3天

$startDay		= (isset( $_GET['start_day'] ) && Validator::isDate($_GET['start_day']) )? SS($_GET['start_day']) : date('Y-m-d', strtotime('-6 days'));
$endDay		= (isset( $_GET['end_day'] ) && Validator::isDate($_GET['end_day']) )? SS($_GET['end_day']) : date('Y-m-d');

$startTime=  strtotime($_GET['start_day']); //开始时间戳
$overTime=  strtotime($_GET['end_day']);    //结束时间戳

$data=getConditionData($startTime,$overTime); //按时间查询
$res = array();
foreach ($data as $da_k => $da_v) {
    foreach ($dictMap as $dm_k => $dm_v) {
        if ($da_v['map_id'] == $dm_v['id'] && $dm_v['isPVP'] == 1) {
            $res[$da_v['mtime']]['name'] = $dm_v['name'];
            $res[$da_v['mtime']]['map_id'] = $dm_v['id'];
            $res[$da_v['mtime']]['die_count'] = $da_v['die_count'];
            $res[$da_v['mtime']]['mtime'] = date('Y-m-d',$da_v['mtime']);
        }
    }
}

$dataList=array();
foreach ($res as $k3=>$v3){
   if($v3['mtime']==$v3['mtime']){
       $dataList[$v3['mtime']][$v3['map_id']]['name']=$v3['name'];
       $dataList[$v3['mtime']][$v3['map_id']]['die_count']=$v3['die_count'];
   }
}
krsort($dataList);

$dieCount=getUserPvpData($beginTime,$endTime);  //查询野外PVP地图累积死亡数量的统计       
$mapList = array();
foreach ($dieCount as $dc_k => $dc_v) {
    foreach ($dictMap as $dm_k => $dm_v) {
        if ($dc_v['map_id'] == $dm_v['id'] && $dm_v['isPVP'] == 1) {
            if($dc_v['map_id']==$dc_v['map_id']){
                $mapList[$dc_v['map_id']]['name'] = $dm_v['name'];
                $mapList[$dc_v['map_id']]['die_count']=$dc_v['die_count'];
            }
        }
    }
}

$liushiCount = getLiushi($tempTime);    //流失玩家最后登陆日在野外PVP地图被击杀的统计

$res = array();
$i=0;
foreach ($liushiCount as $l_k => $l_v) {
    foreach ($l_v as $k=>$v) {
        foreach ($dictMap as $dm_k => $dm_v) {
            if ($v['map_id'] == $dm_v['id'] && $dm_v['isPVP'] == 1) {
                $res[$i]['role_name'] = $v['role_name'];
                $res[$i]['map_id'] = $v['map_id'];
                $res[$i]['name'] = $dm_v['name'];
            }
             $i++;
        }      
    }  
}

$liushiList = array();
foreach ($res as $list_k => $list_v) {
    foreach ($dictMap as $dm_k => $dm_v) {
        if ($list_v['map_id'] == $dm_v['id'] && $dm_v['isPVP'] == 1) {
            if ($list_v['map_id'] == $list_v['map_id']) {
                $liushiList[$list_v['map_id']]['map_id'] = $list_v['map_id'];
                $liushiList[$list_v['map_id']]['name'] = $list_v['name'];
                $liushiList[$list_v['map_id']]['count']++;
            }
        }
    }
}

foreach ($liushiList as $key => $val) {
    $count [] = $val['count'];
    $max_count=max($count);
}
if ($liushiList) {
    foreach ($liushiList as $k2 => $v2) {
        $v2['count'] = $v2['count'];
        $v2['height'] = $v2['count'] / $max_count * 120;
        $v2['img_name'] = (84 < $v2 ['height']) ? "red" : "green";
        $v2 ['alert'] = "流失人数：{$v2['count']}";
        $arr[] = $v2;
    }
}

$smarty->assign( 'lang', $lang );
$smarty->assign( 'time', $time );
$smarty->assign( 'pvp', $pvp );
$smarty->assign( 'startDay', $startDay );
$smarty->assign( 'endDay', $endDay );
$smarty->assign( 'arr', $arr );
$smarty->assign( 'mapList',$mapList );
$smarty->assign( 'liushiList',$liushiList );
$smarty->assign( 'dataList',$dataList );
$smarty->display( 'module/player/user_pvp.tpl' );

function getUserPvpData($beginTime,$endTime){
    $sql="select count(distinct(role_name)) as die_count, map_id  from t_log_die group by map_id";
    $result=  GFetchRowSet($sql);
    return $result;
}

function getLiushi($tempTime){
    $result=array();
    $step = 100;
	$sqlCount = "SELECT count(distinct(role_name)) c FROM  t_log_die ";
	$count = GFetchRowOne($sqlCount);

	$count = intval( $count['c'] );
	$times = ceil( $count / $step ) ;
	$index = 1;
    while( $times-- )
	{
    $start = ($index - 1) * $step;
    $sql="select distinct(a1.role_name),a2.map_id from(
                select logout.account_name,logout.role_name,max(logout.mtime) from t_log_logout logout where logout.mtime< {$tempTime}  group by account_name)
          a1,t_log_die a2 where a1.role_name=a2.role_name  limit {$start}, {$step} ";
    $result[$times] = GFetchRowSet($sql);
    $index++;
    }   
     return $result;  
}

function getConditionData($startTime,$overTime){
    $sql="select count(distinct(role_name)) as die_count, map_id,mtime  from t_log_die  where mtime>='{$startTime}' AND mtime<='{$overTime}' group by  map_id ,year,month,day";
    $result=  GFetchRowSet($sql);
    return $result;
}