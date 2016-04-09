<?php
include_once "../../../protected/config/config.php";
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';
global $lang;

$today = date('Y-m-d'); 
$todayTime = strtotime($today." 00:00:00 "); 
$todayEndTime = strtotime($today." 23:59:59 "); 

$NewStartDate= $_REQUEST['starttime'] ? strtotime($_REQUEST['starttime']) :$todayTime - 6*86400; //新用户转化率时间
$NewEndDate = $_REQUEST['endtime'] ? strtotime($_REQUEST['endtime']." 23:59:59") : strtotime($today);

$weekRange= getWeekRange($today);
$weekStart=$weekRange['sdate'];
$weekEnd=$weekRange['edate'];

$newRegisterData=getNewPlayerRateData($NewStartDate, $NewEndDate);

$OldPlayerData=  getOldPlayerRateData($NewStartDate, $NewEndDate);

$oldWeekData = getWeekOldPlayerRate($weekStart, $weekEnd);
if(is_array($newRegisterData)) {
    foreach ($newRegisterData as $newk => $newv) {
        foreach ($OldPlayerData as $oldk => $oldv) {
            if ($newv['mtime'] == $oldv['mtime']) {
                $oldData[$oldk]['oldRate'] =@ number_format(($oldv['itemTodayCount'] - $newv['newWeiduan']) / ($oldv['TodayDau'] - $newv['newRegister']) * 100, 2);
                $oldData[$oldk]['mtime'] = $oldv['mtime'];
                $oldData[$oldk]['TodayDau'] = $oldv['TodayDau'];
                $oldData[$oldk]['itemTodayCount'] = $oldv['itemTodayCount'];
                $oldData[$oldk]['newRegister'] = $newv['newRegister'];
                $oldData[$oldk]['newWeiduan'] = $newv['newWeiduan'];
            }
        }
    }
}

$smarty->assign("NewStartDate", date('Y-m-d',$NewStartDate ));
$smarty->assign("NewEndDate", date('Y-m-d',$NewEndDate ));
$smarty->assign('lang',$lang);
$smarty->assign("newRegisterData", $newRegisterData);
$smarty->assign("oldData", $oldData);
$smarty->assign("oldWeekData", $oldWeekData);
$smarty->display("module/basedata/weiduan_player_rate.tpl");
exit;

 function getWeekRange($today){
     $ret=array();
     $timestamp=strtotime($today);
     $w=strftime('%u',$timestamp);
     $ret['sdate']=$timestamp-($w-1)*86400;
     $ret['edate']=$timestamp+(7-$w)*86400;
     return $ret;
 }


function getNewPlayerRateData($NewStartDate, $NewEndDate){
    $item_id='12168';
    $newRegisterSql="select count(*)  as newRegister,mtime from t_log_register where mtime>={$NewStartDate} and mtime<={$NewEndDate} and is_miniclient>0 group by year,month,day";
    $newRegisterResult=GFetchRowSet($newRegisterSql);
    
    $newWeiduanSql="SELECT count(*) as newWeiduan, r.mtime FROM t_log_register r LEFT JOIN  t_log_weiduan_down_libao i ON r.role_name = i.role_name
                    WHERE i.libaoID={$item_id} and r.mtime >={$NewStartDate} and r.mtime <={$NewEndDate} and i.mtime>={$NewStartDate} and i.mtime <={$NewEndDate} and r.is_miniclient>0  GROUP BY r.year, r.month, r.day";
   // $newWeiduanSql="select count(*)as newWeiduan,mtime from t_log_weiduan_tip_libao where mtime >={$NewStartDate} and mtime <={$NewEndDate} and type=1 group by year,month,day";      
    $newWeiduanResult = GFetchRowSet($newWeiduanSql);
   
    foreach ($newRegisterResult as $rk=>$rv){
        $rarr[$rk]['mtime']=date('Y-m-d',$rv['mtime']);
        $rarr[$rk]['newRegister']=$rv['newRegister'];
        foreach ($newWeiduanResult as $wk=>$wv){
            $warr[$wk]['mtime']=date('Y-m-d',$wv['mtime']);
            $warr[$wk]['newWeiduan']=$wv['newWeiduan'];
        }
    }

    if(is_array($warr)) {
        foreach ($rarr as $r) {
            foreach ($warr as $k => $w) {
                if ($r['mtime'] == $w['mtime']) {
                    $newPlayerRateData[$k]['newPlayerRateData'] = @ number_format($w['newWeiduan'] / $r['newRegister'] * 100, 2);
                    $newPlayerRateData[$k]['newWeiduan'] = $w['newWeiduan'];
                    $newPlayerRateData[$k]['newRegister'] = $r['newRegister'];
                    $newPlayerRateData[$k]['mtime'] = $w['mtime'];
                }
            }
        }
    }
    return $newPlayerRateData;
}
function getOldPlayerRateData($NewStartDate, $NewEndDate){
    $item_id='12168';
    $getItemTodaySql="select count(*) as itemTodayCount,mtime from  t_log_weiduan_down_libao where mtime>={$NewStartDate} and mtime<={$NewEndDate} and libaoID={$item_id} group by year,month,day";
   // $getItemTodaySql="select count(*) as itemTodayCount,mtime from  t_log_weiduan_tip_libao where mtime>={$NewStartDate} and mtime<={$NewEndDate} and type=1 group by year,month,day";
    $getItemTodayResult=GFetchRowSet($getItemTodaySql);//老用户当日领取
    
    $getTodayDauSql="SELECT COUNT(DISTINCT role_name) TodayDau,mtime from t_log_login where  mtime>={$NewStartDate} and mtime<={$NewEndDate} and is_miniclient>0 group by year,month,day";
    $getTodayDauResult=GFetchRowSet($getTodayDauSql);//老用户当日DAU
    
    foreach ($getItemTodayResult as $ik=>$iv){
       $iarr[$ik]['mtime']=date('Y-m-d',$iv['mtime']);
        $iarr[$ik]['itemTodayCount']=$iv['itemTodayCount'];
        foreach ($getTodayDauResult as $dk=>$dv){
            $darr[$dk]['mtime']=date('Y-m-d',$dv['mtime']);
            $darr[$dk]['TodayDau']=$dv['TodayDau'];
        }
    }
    if(is_array($darr)) {
        foreach ($iarr as $i) {
            foreach ($darr as $k => $d) {
                if ($i['mtime'] == $d['mtime']) {
                    $oldPlayerRateData[$k]['TodayDau'] = $d['TodayDau'];
                    $oldPlayerRateData[$k]['itemTodayCount'] = $i['itemTodayCount'];
                    $oldPlayerRateData[$k]['mtime'] = $d['mtime'];
                }
            }
        }
    }

    return $oldPlayerRateData;
}

function getWeekOldPlayerRate($weekStart, $weekEnd){
    $item_id='12168';
    $newRegisterWeekSql="select count(*)  as newRegisterWeek from t_log_register where mtime>={$weekStart} and mtime<={$weekEnd} and is_miniclient>0"; //当周新注册
    $newRegisterWeekResult=GFetchRowOne($newRegisterWeekSql);
    
    $newWeiduanWeekSql="SELECT count(*) as newWeiduanWeek FROM t_log_register r LEFT JOIN  t_log_weiduan_down_libao i ON r.role_name = i.role_name
                    WHERE i.libaoID={$item_id} and r.mtime >={$weekStart} and r.mtime <={$weekEnd} and i.mtime>={$weekStart} and i.mtime <={$weekEnd} and r.is_miniclient>0";
   // $newWeiduanWeekSql="select count(*) as newWeiduanWeek FROM t_log_weiduan_tip_libao where mtime >={$weekStart} and mtime <={$weekEnd} and type=1";
    $newWeiduanWeekResult=GFetchRowOne($newWeiduanWeekSql);//当周注册并领取
    
    $getItemWeekSql="select count(*) as itemWeekCount  from  t_log_weiduan_down_libao where mtime>={$weekStart} and mtime<={$weekEnd} and libaoID={$item_id}";
    //$getItemWeekSql="select count(*) as itemWeekCount  from  t_log_weiduan_tip_libao where mtime>={$weekStart} and mtime<={$weekEnd} and type=1";
    $getItemWeekResult=GFetchRowOne($getItemWeekSql);//当周领取
    
    $getWeekDauSql="SELECT COUNT(DISTINCT role_name) weekDau from t_log_login where  mtime>={$weekStart} and mtime<={$weekEnd}  and is_miniclient>0";//当周活跃用户
    $getWeekDauResult = GFetchRowOne($getWeekDauSql);
    
    $result['mtime']=date('Y-m-d',$weekStart).'/'.date('Y-m-d',$weekEnd);
    $result['newRegisterWeek'] = $newRegisterWeekResult['newRegisterWeek'];
    $result['newWeiduanWeek']  =  $newWeiduanWeekResult['newWeiduanWeek'];
    $result['itemWeekCount']  =  $getItemWeekResult['itemWeekCount'];
    $result['weekDau']  =  $getWeekDauResult['weekDau'];
    $result['weekRate']  = @ number_format(($result['itemWeekCount']-$result['newWeiduanWeek'])/($result['weekDau']-$result['newRegisterWeek'])*100,2); 
    return $result;
}