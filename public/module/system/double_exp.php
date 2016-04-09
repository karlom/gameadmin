<?php

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';
include_once SYSDIR_ADMIN_DICT.'/doubleExp.php';
include_once SYSDIR_ADMIN_API_CLASS.'/server_api.php';

$arrWeek = array(
    2=>'周一',
    4=>'周二',
    8=>'周三',
    16=>'周四',
    32=>'周五',
    64=>'周六',
    1=>'周日',
);

$arrKeys = array_keys($arrWeek);
$action = intval($_GET['action']);
$arrTypeKeys = array_keys($dictDoubleExp);
$doubleExp = array(
    130=>'1.3倍',
    150=>'1.5倍',
    200=>'2倍',
    300=>'3倍',
    400=>'4倍',
);
$doubleIndex = array_keys($doubleExp);


$msg = array();
if(isPost()){
    $type = intval($_POST['type']);
    $dateStart = SS($_POST['dateStart']);
    $dateEnd = SS($_POST['dateEnd']);
    $chx = $_POST['chx'];
    $doubleSel = intval($_POST['doubleSel']);
    $time1 = SS($_POST['time1']);
    $time2 = SS($_POST['time2']);
    $levelMin = intval($_POST['levelMin']);
    $levelMax = intval($_POST['levelMax']);
    $dateStartStamp = strtotime($dateStart.'0:0:0');
    $dateEndStamp   = strtotime($dateEnd.'23:59:59');
     if(empty($chx)){
        $msg[] = '所选星期不能为空';
    }
    if(1!=$action){
        $msg[] = '操作类型错误';
    }
    if(!$dateStartStamp || !$dateEndStamp){
        $msg[] = '日期格式错误';
    }
    $startMin = minTotime($time1);
    $endMin = minTotime($time2);
    $chxSum = array_sum($chx);
    if (empty ($msg)){
        $apiData = array(
            'action'=>$action,
            'type'=>$type,
            'startDay'=>$dateStartStamp,
            'endDay'=>$dateEndStamp,
            'weekFlag'=>$chxSum,
            'startMinute'=>$startMin,
            'endMinute'=>$endMin,
            'expTimes'=>$doubleSel,
            'levelMin'=>$levelMin,
            'levelMax'=>$levelMax,
        );
        $api = new ServerApi();
        $result =  $api->setDoubleExp($apiData);
        if(1!=$result['result']){
            $msg[] = "操作失败,原因:" . $result['errorMsg'];
        }else{
            $msg[]='操作成功';
            //记录管理日志
            $loger = new AdminLogClass();
            $loger -> log(AdminLogClass::SET_DOUBLE_EXP_ADD,'多倍经验活动设置成功!','','','','');
        }
    }
}else{
    $dateStart =date('Y-m-d');
    $dateEnd =date('Y-m-d');
    $chx = $arrKeys;
    $time2 = date('H'.':59');
    $time1 = date('H'.':00');
    $levelMin = 1;
    $levelMax = 120;
}
$id = intval($_GET['id']);
if(2==$action){
    $sqlDel = " select * from  ".T_ACTIVITY." where id = {$id}";
    $rs = GWFetchRowOne($sqlDel);
    if($rs){
        $apiDataDelete = array(
                'action'=>$action,
                'type'=>intval($rs['type']),
                'startDay'=>intval($rs['startDay']),
                'endDay'=>intval($rs['endDay']),
                'weekFlag'=>intval($rs['weekFlag']),
                'startMinute'=>intval($rs['startMinute']),
                'endMinute'=>intval($rs['endMinute']),
                'expTimes'=>intval($rs['expTimes']),
                'levelMin'=>intval($rs['minLevel']),
                'levelMax'=>intval($rs['maxLevel']),
            );
            $api = new ServerApi();
            $result =  $api->setDoubleExp($apiDataDelete);
            if(1!=$result['result']){
                $msg[] = "操作失败,原因:" . $result['errorMsg'];
            }else{
                $msg[]='操作成功';
                //记录管理日志
                $loger = new AdminLogClass();
                $loger -> Log(AdminLogClass::SET_DOUBLE_EXP_DELETE, '多倍经验活动删除成功!', '', '', '', '');
            }
    }else{
         $msg[] = "操作失败,原因:" . $result['errorMsg'];
    }
}

$sql = " select * from ".T_ACTIVITY;
$result = GWFetchRowSet($sql);

foreach($result as $key => &$row){
    $arrWeeks = array();
    $row['type'] = $dictDoubleExp[$row['type']];
    $row['expTimes'] = $row['expTimes']/100;
    $weekFlag = $row['weekFlag'];
    if($weekFlag >= 64){
        $weekFlag -= 64;
        array_push($arrWeeks, '周六');
    }
    if($weekFlag >=32){
        $weekFlag -= 32;
        array_push($arrWeeks, '周五');
    }
    if($weekFlag >=16){
        $weekFlag -= 16;
        array_push($arrWeeks, '周四');
    }
    if($weekFlag >=8){
        $weekFlag -= 8;
        array_push($arrWeeks, '周三');
    }
    if($weekFlag >=4){
        $weekFlag -= 4;
        array_push($arrWeeks, '周二');
    }
    if($weekFlag >= 2){
        $weekFlag -=2;
        array_push($arrWeeks, '周一');}
    if($weekFlag){
        array_push($arrWeeks, '周日');
    }
    $row['weekFlag'] = implode(',', $arrWeeks);
    $nowTime = time();
    $activeEndTime = strtotime(date('Y-m-d',$row['endDay']))+($row['endMinute']*60);
    if($nowTime>$activeEndTime){
        $row['status'] = 2;
    }else{
        $row['status'] = 1;
    }
    $row['startMinute'] = timeTomin($row['startMinute']);
    $row['endMinute'] = timeTomin($row['endMinute']);
}
$strMsg = implode('<br />', $msg);
$data = array(
    'type'=>$type,
    'arrTypeKeys'=>$arrTypeKeys,
    'dictDoubleExp'=>$dictDoubleExp,
    'result'=>$result,
    'arrKeys'=>$arrKeys,
    'doubleSel'=>$doubleSel,
    'doubleExp'=>$doubleExp,
    'arrWeek'=>$arrWeek,
    'dateStart'=>$dateStart,
    'dateEnd'=>$dateEnd,
    'levelMin'=>$levelMin,
    'levelMax'=>$levelMax,
    'time1'=>$time1,
    'time2'=>$time2,
    'chx'=>$chx,
    'doubleIndex'=>$doubleIndex,
    'URL_SELF'=>$_SERVER['PHP_SELF'],
    'strMsg'=>$strMsg,
    'agent_name'=>AGENT_NAME,
	'server_id'=>SERVER_ID,
);
$smarty->assign($data);
$smarty->display("module/system/double_exp.tpl");

//分钟转为int型
function minTotime($min){
    $min = explode(':', $min);
    $minInt = $min[0]*60+$min[1];
    return $minInt;
}
//int型转为分钟
function timeTomin($minInt){
    $min = (($minInt-$minInt%60)/60).":".($minInt%60);
    return $min;
}