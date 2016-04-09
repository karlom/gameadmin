<?php
/*
* 用户存留
*/
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';
include_once SYSDIR_ADMIN_CLASS."/admin_group.class.php";
global $lang;

define( "ONLINEDATE", $serverList[$_SESSION ['gameAdminServer']]['onlinedate']);
$onday = ONLINEDATE;
$onedaystamp = strtotime($onday . ' 0:0:0');
$starttime = strtotime(ONLINEDATE);
$endtime = $starttime + ($day * 86399);
$onetime = $starttime + 86399;
$this_day_time = GetTime_Today0();
$cur_day_time = $this_day_time - 86400 ;
$now = time();

if (! isset($_REQUEST['dateStart'])) {
//     $dateStart = $onday;
    $dateStart = strftime("%Y-%m-%d", time());
}else {
     $dateStart = strtotime($_REQUEST['dateEnd']) > time() ? strftime("%Y-%m-%d", time()) : $_REQUEST['dateStart'];
}
if($dateStart<ONLINEDATE){$dateStart=ONLINEDATE;}

$dateStartStamp = strtotime($dateStart . ' 0:0:0');
$dateStartStamp = intval($dateStartStamp) > 0 ? intval($dateStartStamp) : strtotime(ONLINEDATE);


if (! isset($_REQUEST['dateEnd'])) {
     $dateEnd = strftime("%Y-%m-%d", time());
}else {
     $dateEnd = strtotime($_REQUEST['dateEnd']) > time() ? strftime("%Y-%m-%d", time()) : $_REQUEST['dateEnd'];
}
$dateEndStamp = strtotime($dateEnd . ' 23:59:59');
$dateEndStamp = intval($dateEndStamp) > 0 ? intval($dateEndStamp) : strtotime(ONLINEDATE);
$dateEndStr = strftime("%Y-%m-%d", $dateEndStamp);

//=================================
$chunsql ="select count(distinct p.role_name) as count,from_unixtime(p.mtime,'%Y-%m-%d') as days,datediff(from_unixtime(p.mtime,'%Y-%m-%d'),'{$onday}') as diff,p.mtime as mtime from t_log_register r right join t_log_login p on p.role_name=r.role_name 
where r.mtime>={$starttime} and r.mtime<={$onetime}  group by days having mtime>={$dateStartStamp} and mtime<={$dateEndStamp}  order by days";

$zongsql = "select count(distinct p.role_name) as count,from_unixtime(p.mtime,'%Y-%m-%d') as days,sum(p.pay_money) as pay_money,p.mtime as mtime from t_log_register r right join t_log_pay p on p.role_name=r.role_name 
where r.mtime>={$starttime} and r.mtime<={$onetime}  group by days having mtime>={$dateStartStamp} and mtime<={$dateEndStamp}  order by days";

$chun = GFetchRowSet($chunsql);
if(isset($chun)){
foreach($chun as $key=>$val)
{
    $results[$val['days']]['chun'] = $val['count'];
    $results[$val['days']]['diff'] = $val['diff']+1;
    $date[$val['days']] = strtotime($val['days'] . ' 23:59:59');
}
}
if(isset($date)){
foreach($date as $key =>$val)
{
$start = strtotime($key . ' 0:0:0');
 $sql="
select count(distinct w.role_name) as count ,sum(w.pay_money) money from t_log_pay w right join (
select r.role_name from t_log_register r left join t_log_pay p on r.role_name = p.role_name where r.mtime>={$starttime} and r.mtime<={$onetime} 
 and p.mtime>={$starttime} and p.mtime<={$val} group by role_name having count(p.role_name)>1
) two on w.role_name = two.role_name where w.mtime>={$start} and w.mtime<={$val} 
";
$lao[$key] = GFetchRowOne($sql);
}
}
if(is_array($date)){
foreach($date as $key =>$val)
{
$start = strtotime($key . ' 0:0:0');
 $sql="
select count(distinct w.role_name) as count ,sum(w.pay_money) money from t_log_pay w right join (
select r.role_name from t_log_register r left join t_log_pay p on r.role_name = p.role_name where r.mtime>={$starttime} and r.mtime<={$onetime} 
 and p.mtime>={$starttime} and p.mtime<={$val} group by role_name having count(p.role_name)=1
) two on w.role_name = two.role_name where w.mtime>={$start} and w.mtime<={$val} 
";
$xin[$key] = GFetchRowOne($sql);
}
}

$zongc = GFetchRowSet($zongsql);
if(isset($zongc)){
foreach($zongc as $key=>$val)
{
    $results[$val['days']]['money'] = $val['pay_money'];
    $results[$val['days']]['count'] = $val['count'];
}
}
//$lao = GFetchRowSet($laosql);
if(isset($lao))
{
foreach($lao as $key=>$val){
    $results[$key]['laomoney'] = $val['money'];
    $results[$key]['laocount'] = $val['count'];
}
}
//$xin = GFetchRowSet($xinsql);
if(isset($xin)){
foreach($xin as $key=>$val){
    $results[$key]['xinmoney'] = $val['pay_money'];
    $results[$key]['xincount'] = $val['count'];
}
}
if(is_array($results)){
foreach($results as $key =>$val)
{
    foreach($val as $k =>$v)
    {
        $hzong[$k] +=$v;
    }
}
}
$smarty->assign('onlinedate',ONLINEDATE);
$smarty->assign('results',$results);
$smarty->assign('hzong',$hzong);
//$smarty->assign('oned',$oned);
$smarty->assign('lang',$lang);
$smarty->assign('dateStart',$dateStart);
$smarty->assign('dateEnd',$dateEnd);
$smarty->display("module/basedata/userKeep.tpl");
exit;
