<?php

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';

$admin_name = trim($_POST['admin_name']);
$dateStart = SS($_POST['dateStart']);
$dateEnd = SS($_POST['dateEnd']);
if(isPost()){
     $dateStartStamp = strtotime($dateStart);
     $dateEndStamp   = strtotime($dateEnd);
    if(!$dateStartStamp){
       $dateStart= date('Y-m-d',strtotime('-6day'));
    }
    if(!$dateEndStamp){
        $dateEnd = date('Y-m-d');
    }
}

$dateStart = $dateStart ? $dateStart : date('Y-m-d',strtotime(date('Y-m-d',strtotime('-6day'))));
$dateEnd = $dateEnd ? $dateEnd : strftime("%Y-%m-%d",time());
$dateStartTamp = strtotime($dateStart.' 0:0:0');
$dateEndTamp = strtotime($dateEnd.' 23:59:59');

//过滤条件
$gulvxt = isPost() ? trim(SS($_POST['gulvxt'])) : '9001' ;

$op_type = trim(SS($_POST['op_type']));
if(empty($op_type))$op_type = '0';

$op_id = $_POST['op_id'];
if(empty($op_id))$op_id = '0';

$log = new AdminLogClass();
$op_name = $ADMIN_LOG_TYPE;

//$data = $log->getGlvLogs($dateStartStamp, $dateEndStamp, $admin_name);
$data = $log->getGlvLogs($dateStartTamp, $dateEndTamp, $admin_name, $gulvxt, $op_id);

//new dBug($data);
$smarty->assign("gulvxt",$gulvxt);
$smarty->assign("op_name",$op_name);
$smarty->assign("op_id",$op_id);
$smarty->assign("dateStart", $dateStart);
$smarty->assign("dateEnd", $dateEnd);
$smarty->assign("admin_name", $admin_name);

$smarty->assign("keywordlist", $data);

$smarty->display("module/system/admin_log_view.tpl");
exit;
