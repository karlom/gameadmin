<?php
/**
 * 角色创建页流失率
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
//加载接口配置文件
if(file_exists(SYSDIR_ADMIN_GAME_CONFIG."/".GAME_EN_NAME."/createRoleStep.php")){
	include_once(SYSDIR_ADMIN_GAME_CONFIG."/".GAME_EN_NAME."/createRoleStep.php");
}

global $lang, $createRoleStep;

$action = isset($_GET["action"]) ? SS($_GET["action"]) : "";
if("" == $action){
	//获取时间段
	if (!isset ($_POST['starttime'])) {
		$startDate = Datatime :: getPreDay(date("Y-m-d"), 7);
	} else {
		$startDate = SS($_POST['starttime']);
	}
	if (!isset ($_POST['endtime'])) {
		$endDate = Datatime :: getTodayString();
	} else {
		$endDate = SS($_POST['endtime']);
	}
	
	$dateStartStamp = strtotime($startDate." 0:0:0");
	$dateEndStamp = strtotime($endDate." 23:59:59");
	$openTimestamp = strtotime( ONLINEDATE );
	if($dateStartStamp < $openTimestamp)
	{
		$dateStartStamp = $openTimestamp;
		$startDate = ONLINEDATE;
	}
	$viewData = json_decode(getData($dateStartStamp, $dateEndStamp), true);
	//print_r($viewData);
	
	$minDate = ONLINEDATE;
	$maxdate = date("Y-m-d");
	$smarty->assign("mindate", $mindate);
	$smarty->assign("maxdate", $maxdate);

	$smarty->assign('result', $result);
	$smarty->assign('startDate', $startDate);
	$smarty->assign('endDate', $endDate);
	$smarty->assign('viewData', $viewData);
}else if("set" == $action){
	$smarty->assign('steps', $createRoleStep);
}else if("submit" == $action){//设置具体的步骤
    $ids = $_POST["id"];
    $des = $_POST["des"];
    $sort = $_POST["sort"];
    $result = array();
    foreach ($ids as $key => $value){
        $result[$sort[$key]] = array(
            "id" => $value,
            "des" => $des[$key],
            "sort" => $sort[$key],
        );
    }
    ksort($result);
    if(!empty($result)){
        $str=<<<PHPSTR
<?php
//注意！或不清楚以下各变量的配置规则及用途，请不要随便动。
\$createRoleStep = 
PHPSTR;
        $str .= var_export($result,true).';';
    }
	$putSize = @file_put_contents(SYSDIR_ADMIN_GAME_CONFIG."/".GAME_EN_NAME.'/createRoleStep.php',$str);
	if (!$putSize) {
		echo "<script type=''>alert('".$lang->alert->dataWriteFailure."');location.href='".URL_SELF."?action=set';</script>";
	}else{
		echo "<script type=''>alert('".$lang->verify->opSuc."');location.href='".URL_SELF."?action=set';</script>";
	}
	exit();
}
$minDate = ONLINEDATE;
$maxDate = date ( "Y-m-d" );
$smarty->assign('minDate', $minDate);
$smarty->assign('maxDate', $maxDate);
$smarty->assign('action', $action);
$smarty->assign('lang', $lang);
$smarty->assign("dateToday", date('Y-m-d'));
$smarty->assign("dateOnline", ONLINEDATE);
$smarty->display('module/basedata/create_role_lose_rate.tpl');

function getData($dateStartStamp, $dateEndStamp){
    global $createRoleStep;
    
    $sql = "select step,count(*) as counts, count(distinct account_name) user_num,count(distinct ip) dist_ip_num  from ".T_LOG_CREATE_LOSS." WHERE mtime>={$dateStartStamp} and mtime<={$dateEndStamp} group by step order by step";
    $result = GFetchRowSet($sql, "step");
    //print_r($createRoleStep);
	if($createRoleStep){
    	foreach($createRoleStep as $key => $value){
            $data[] = array(
                "type" => $result[$value['id']]['step'],
                "counts" => intval($result[$value['id']]['counts']),
                "user_num" => intval($result[$value['id']]['user_num']),
                "dist_ip_num" => $result[$value['id']]['dist_ip_num'],
                "des" => $value['des'],
            );
    	}
	}
	return json_encode($data);
}