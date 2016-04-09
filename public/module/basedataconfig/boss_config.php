<?php
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';
include_once SYSDIR_ADMIN_DICT . '/arrItemsAll.php';
global $lang,$dictBossType;
$action = isset($_GET['action']) ? SS($_GET['action']) : "";
define( "ONLINEDATE", $serverList[$_SESSION ['gameAdminServer']]['onlinedate']);

//$k = "192.168.10.50";  //:10000/api/admin.php


$bossname = SS($_POST['bossname']);
$bossid = SS($_REQUEST['bossid']);

if(!empty($bossname)){
$setapi = "setbossinfo";
$params = array("index"=>$bossid,"valuetype"=>"24","value"=>$bossname);
$seta = interfaceRequest($setapi,$params);
}

foreach($arrItemsAll as $key =>$val)
{
    $wupin[$key] = $val['name'];
    $wup[$val['name']] = $key;
    $wus[]=$val['name'];
}

$bossapi = "getallmonsterid";
$bossdata = interfaceRequest($bossapi);
foreach($bossdata as $key =>$val)
{
    $bossdata[$val['index']] = $val['name'];
    $bossdata2[]=$val['name'];
    unset($bossdata[$key]);
}

$bodyidsapi = "getallbodyids";   //BOSS造型
$bodyida = interfaceRequest($bodyidsapi);

foreach($bodyida as $key =>$val)
{
    $bodyiddata[$val['id']] = $val['name'];
}

$mapapi = "getmapinfo";             //地图数据
$mapdata = interfaceRequest($mapapi);
foreach($mapdata as $key =>$val)
{
    $mapdata[$val['index']] = $val['name'];
    unset($mapdata[$key]);
}

$ac = SS($_REQUEST['ac']);


if($ac == 'create' ){
    $createapi = "createbossindex";   //创建boss设置
    $createa = interfaceRequest($createapi);
//    dump($createa);
}

if($ac == 'copy' ){
    $type = SS($_REQUEST['type']);
    $createapi = "copybossinfo";   //创建boss设置
    $params = array("index"=>$type);
    $createa = interfaceRequest($createapi,$params);
}


if($ac == 'kk' ){
    $type = SS($_REQUEST['type']);
    $api = "getbossinfo";                   //查看BOSS相关
    $params = array("index"=>$type);
    $info = interfaceRequest($api,$params);
//    dump($info);
    
    $beg = $info['bornset']['begin']['year']."-".$info['bornset']['begin']['month']."-".$info['bornset']['begin']['day']." ".$info['bornset']['begin']['hour'].":".$info['bornset']['begin']['min'];
    $en = $info['bornset']['close']['year']."-".$info['bornset']['close']['month']."-".$info['bornset']['close']['day']." ".$info['bornset']['close']['hour'].":".$info['bornset']['close']['min'];
    
    $startd = strtotime($beg);
    $endd = strtotime($en);
    
//    echo $startd.$endd;
    
    if(isset($info['command'])){
        $in = explode(";",$info['command']);
        foreach($in as $key =>$val){
            if(empty($val)){continue;}
            $zhe[$val] = $wupin[$val];
        }
//        dump($zhe);
//        $zhe = implode(";", $zhe);
    }
    $bos = $bossdata[$info['bossID']];
    $smarty->assign('bos',$bos);
    $smarty->assign('lang', $lang);
    $smarty->assign('startd',$startd);
    $smarty->assign('endd',$endd);
    $smarty->assign('info',$info);
    $smarty->assign('mapdata',$mapdata);
    $smarty->assign("bossdata",$bossdata);
    $smarty->assign("wupin",$wupin);
    $smarty->assign("wupinttt",$wupin);
    $smarty->assign("zhaoxing",$bodyiddata);
    $smarty->assign("zhe",$zhe);
    $smarty->assign("bossid",$type);
    $smarty->assign('onlinedate',ONLINEDATE);
    
    $smarty->display('module/basedataconfig/boss_config_load.tpl');
    exit();
}
$bossid = $_REQUEST['bossid'];
if($ac == "del"){
    $delapi = "deletebossinfo";   //删除boss设置
    $params = array("index"=>$bossid);
    $seta = interfaceRequest($delapi,$params);
    $seta = json_encode($seta);
    if($seta['ret']==0){
        header("location:boss_config.php");
    }
    echo $seta;
    exit();
}

if($ac == "status"){    // status 1 出生，2 死亡
    $delapi = "setbossstate";   //删除boss设置
    $stat = $_REQUEST['stat'];
    $params = array("index"=>$bossid,"status"=>$stat);
    $seta = interfaceRequest($delapi,$params);
//    dump($seta);
    $seta = json_encode($seta);
    echo $seta;
    exit();
}

if($ac =="setbirth")        //出生日期
{
    $begin = $end = 0;
    $birthtime = SS($_POST['birthtime']);
    
    if($birthtime == 0)
    {
        $birtime = SS($_POST['birtime']);
        $birtime2 = SS($_POST['birtime2']);
//        $aa = explode("-",$birtime);
//        $bb = explode("-",$birtime2);
//        $str = array("datetype"=>(int)$birthtime,"date"=>array("begin"=>$aa,"close"=>$bb));
//        $str = json_encode($str);
//        echo $birtime;
        $begin = strtotime($birtime);
        $end = strtotime($birtime2);
    }elseif($birthtime == 1)
    {
//        $str = array("datetype"=>(int)$birthtime,"fewdays"=>array("begin"=>$birtime,"close"=>$birtime2));
//        $str = json_encode($str);
        $birtime = SS($_POST['birtimet']);
        $birtime2 = SS($_POST['birtime2t']);
        $starttime = SS($_POST['starttime']);
        $endtime = SS($_POST['endtime']);
        $starttime = explode(":",$starttime);
        $endtime = explode(":",$endtime);
        $start = Datatime::dayHourMinuteToTimestamp($birtime, $starttime[0], $starttime[1]);
        $ends = Datatime::dayHourMinuteToTimestamp($birtime2, $endtime[0], $endtime[1]);
        $oltime = strtotime(ONLINEDATE);
        $begin = $oltime+$start;
        $end =$oltime+$ends;
    }
    $str = array("begin"=>$begin,"close"=>$end);
    $str = json_encode($str);
    
//    $odapi = "setgameopenday";
//    $params = array("value"=>ONLINEDATE);
//    $od = interfaceRequest($odapi,$params);
//    dump($od);
    
    $setapi = "setbossinfo";
//    dump($str);
    $params = array("index"=>$bossid,"valuetype"=>"20","value"=>$str);
//    dump($params);
    $seta = interfaceRequest($setapi,$params);
    $seta = json_encode($seta);
    echo $seta;
    exit();
}

if($ac == "csdate")
{
    $cs = SS($_POST['cs']);
    $cs2 = SS($_POST['cs2']);
    if(!empty($cs) || !empty($cs2))
    {
        $aa = explode(":",$cs);
        if(!isset($aa[1])){$aa[1]=0;}
        $bb = explode(":",$cs2);
        if(!isset($bb[1])){$bb[1]=0;}
        
        if(!empty($cs) && !empty($cs2)){
            $str = array("respawn"=>array($aa,$bb));
        }elseif(!empty($cs)){
            $str = array("respawn"=>array($aa));
        }elseif(!empty($cs2)){
            $str = array("respawn"=>array($bb));
        }else{
            exit();
        }
        $str = json_encode($str);
//        dump($str);
        $setapi = "setbossinfo";
        $params = array("index"=>$bossid,"valuetype"=>"21","value"=>$str);
        $seta = interfaceRequest($setapi,$params);
        $seta = json_encode($seta);
        echo $seta;
    }
    
    exit();
}

if($ac == "setzx")
{
    $zx = SS($_POST['zx']);
    $setapi = "setbossinfo";
    $params = array("index"=>$bossid,"valuetype"=>"15","value"=>$zx);
//    dump($params);
    $seta = interfaceRequest($setapi,$params);
    $seta = json_encode($seta);
    echo $seta;
//    dump($seta);
    exit();
}

if($ac == "setlv")
{
    $lv = SS($_POST['lv']);
    $setapi = "setbossinfo";
    $params = array("index"=>$bossid,"valuetype"=>"7","value"=>$lv);
    $seta = interfaceRequest($setapi,$params);
    $seta = json_encode($seta);
    echo $seta;
    exit();
}

if($ac == "setxl")
{
    $xl = SS($_POST['xl']);
    $setapi = "setbossinfo";
    $params = array("index"=>$bossid,"valuetype"=>"16","value"=>$xl);
    $seta = interfaceRequest($setapi,$params);
    $seta = json_encode($seta);
    echo $seta;
    exit();
}

if($ac == "setfy")
{
    $fy = SS($_POST['fy']);
    $setapi = "setbossinfo";
    $params = array("index"=>$bossid,"valuetype"=>"19","value"=>$fy);
    $seta = interfaceRequest($setapi,$params);
    $seta = json_encode($seta);
    echo $seta;
    exit();
}

if($ac == "setgj")
{
    $gj = SS($_POST['gj']);
    $setapi = "setbossinfo";
    $params = array("index"=>$bossid,"valuetype"=>"18","value"=>$gj);
    $seta = interfaceRequest($setapi,$params);
    $seta = json_encode($seta);
    echo $seta;
    exit();
}

if($ac == "setbo")
{
    $bossi = SS($_POST['bossi']);
    $bossdata3 = array_flip($bossdata);
    $bossi = $bossdata3[$bossi];
    
    $setapi = "setbossinfo";
    $params = array("index"=>$bossid,"valuetype"=>"2","value"=>$bossi);
    $seta = interfaceRequest($setapi,$params);
    $seta = json_encode($seta);
    echo $seta;
    exit();
}


if($ac == "setwhere")
{
    $mapdata = SS($_POST['mapdata']);
    $x = SS($_POST['x']);
    $y = SS($_POST['y']);
    $setapi = "setbossinfo";
    $params = array("index"=>$bossid,"valuetype"=>"12","value"=>$mapdata);
    $seta = interfaceRequest($setapi,$params);
    $params = array("index"=>$bossid,"valuetype"=>"13","value"=>$x);
    $seta = interfaceRequest($setapi,$params);
    $params = array("index"=>$bossid,"valuetype"=>"14","value"=>$y);
    $seta = interfaceRequest($setapi,$params);
    $seta = json_encode($seta);
    echo $seta;
    exit();
}

if($ac == "setzdsh")
{
    $zdsh = SS($_POST['zdsh']);
    $bossid = SS($_POST['bossid']);
    $setapi = "setbossinfo";
    $params = array("index"=>$bossid,"valuetype"=>"8","value"=>$zdsh);
    $data = interfaceRequest($setapi,$params);
    $data = json_encode($data);
    echo $data;
//    echo "<script language='javascript'>alert('ok')</script";
    exit();
}

if($ac == "setyz")
{
    $power = SS($_POST['power']);
    $phy = SS($_POST['phy']);
    $energy = SS($_POST['energy']);
    $steps = SS($_POST['steps']);
    
    $setapi = "setbossinfo";
    $params = array("index"=>$bossid,"valuetype"=>"3","value"=>$power);
    $seta = interfaceRequest($setapi,$params);
    $params = array("index"=>$bossid,"valuetype"=>"4","value"=>$phy);
    $seta = interfaceRequest($setapi,$params);
    $params = array("index"=>$bossid,"valuetype"=>"6","value"=>$energy);
    $seta = interfaceRequest($setapi,$params);
    $params = array("index"=>$bossid,"valuetype"=>"5","value"=>$steps);
    $seta = interfaceRequest($setapi,$params);
    $seta = json_encode($seta);
    echo $seta;
    exit();
}

if($ac == "setfirstconf")
{
    $wupinget = SS($_POST['wupin']);
    $diaoluo = SS($_POST['diaoluo']);
    $gailu = SS($_POST['gailu']);
    $shuliang = SS($_POST['shuliang']);
    $broadcast = SS($_POST['broadcast']);
    $color = SS($_POST['color']);
    $color = explode(",", $color);
    $str = array("itemId"=>$wup[trim($wupinget)],"rate"=>$diaoluo,"bindRate"=>$gailu,"count"=>$shuliang,"color"=>$color,"broadcast"=>$broadcast);
    $str = json_encode($str);
    $setapi = "setbossinfo";
    $params = array("index"=>$bossid,"valuetype"=>"9","value"=>$str);
    $seta = interfaceRequest($setapi,$params);
    $seta = json_encode($seta);
    echo $seta;
//    dump($seta);
    exit();
}

if($ac == "setlastconf")
{
    $wupinget = SS($_POST['wupin']);
    $diaoluo = SS($_POST['diaoluo']);
    $gailu = SS($_POST['gailu']);
    $shuliang = SS($_POST['shuliang']);
    $broadcast = SS($_POST['broadcast']);
    $color = SS($_POST['color']);
    $color = explode(",", $color);
    $str = array("itemId"=>$wup[trim($wupinget)],"rate"=>$diaoluo,"bindRate"=>$gailu,"count"=>$shuliang,"color"=>$color,"broadcast"=>$broadcast);
    $str = json_encode($str);
    $setapi = "setbossinfo";
    $params = array("index"=>$bossid,"valuetype"=>"11","value"=>$str);
    $seta = interfaceRequest($setapi,$params);
    $seta = json_encode($seta);
    echo $seta;
    exit();
//    dump($seta);
}

if($ac == "setmconf")   //多个刀
{
    $wupinget = $_POST['wupin'];
//    dump($wupinget);
    $diaoluo = $_POST['diaoluo'];
    $gailu = $_POST['gailu'];
    $shuliang = $_POST['shuliang'];
    $color = $_POST['color'];
    $broadcast = $_POST['broadcast'];
    $count = count($wupinget);
    for($i=0;$i<$count;$i++)
    {
        $color[$i] = explode(",",$color[$i]);
        $str[] = array("itemId"=>$wup[trim($wupinget[$i])],"rate"=>$diaoluo[$i],"bindRate"=>$gailu[$i],"count"=>$shuliang[$i],"color"=>$color[$i],"broadcast"=>$broadcast[$i]);
    }
    $str = json_encode($str);
//    dump($str);
    $setapi = "setbossinfo";
    $params = array("index"=>$bossid,"valuetype"=>"10","value"=>$str);
    $seta = interfaceRequest($setapi,$params);
    $seta = json_encode($seta);
    echo $seta;
//    dump($seta);
    exit();
}

if($ac == "setwu")
{
    $wu = SS($_POST['wu']);
//    $wu = explode(",",$wu);
//    foreach($wu as $key =>$val){
//        $val = trim($val);
//        $ee[] = $wup[$val];
//    }
//    $ee = implode(";", $ee);
    $setapi = "setbossinfo";
    $params = array("index"=>$bossid,"valuetype"=>"23","value"=>$wu);
    $seta = interfaceRequest($setapi,$params);
    $seta = json_encode($seta);
    echo $seta;
    exit();
}

if($ac == "setmiao")
{
    $miao = SS($_POST['miao']);
    $setapi = "setbossinfo";
    $params = array("index"=>$bossid,"valuetype"=>"22","value"=>$miao);
    $seta = interfaceRequest($setapi,$params);
    $seta = json_encode($seta);
    echo $seta;
    exit();
}


$getindexapi = "getbossindex";            //查看多少个配置
$index = interfaceRequest($getindexapi);
//dump($index);

$smarty->assign('lang', $lang);
$smarty->assign('index',$index);
$smarty->assign("wupin",$wus);
$smarty->assign("bossdata2",$bossdata2);

$smarty->display('module/basedataconfig/boss_config.tpl');

