<?php
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
global $lang;
$openTimestamp = strtotime( ONLINEDATE );
$nowTime = time();
//获取时间段
if (!isset ($_POST['starttime'])) {
	$startDate = Datatime :: getPreDay(date("Y-m-d"), 7);
} else {
	$startDate = trim($_POST['starttime']);
}
if (!isset ($_POST['endtime'])) {
	$endDate = Datatime :: getTodayString();
} else {
	$endDate = trim($_POST['endtime']);
}
$dateStartStamp = strtotime($startDate." 0:0:0");
if($dateStartStamp < $openTimestamp)
{
	$dateStartStamp = $openTimestamp;
	$startDate = ONLINEDATE;
}
$dateEndStamp = strtotime($endDate." 23:59:59");

$arrArea = array(
	array( "min"=>1 , "max"=>2  ,    "desc"=>"[1,2)", "num"=>0 ), 
	array( "min"=>2 , "max"=>3  ,    "desc"=>"[2,3)",     "num"=>0 ), 
	array( "min"=>3 , "max"=>4  ,    "desc"=>"[3,4)",     "num"=>0 ), 
	array( "min"=>4 , "max"=>5  ,    "desc"=>"[4,5)",     "num"=>0 ), 
	array( "min"=>5 , "max"=>6  ,    "desc"=>"[5,6)",     "num"=>0 ), 
	array( "min"=>6 , "max"=>8  ,    "desc"=>"[6,8)",     "num"=>0 ), 
	array( "min"=>8 , "max"=>10  ,    "desc"=>"[8,10)",     "num"=>0 ), 
	array( "min"=>10 , "max"=>15  ,    "desc"=>"[10,15)",     "num"=>0 ), 
	array( "min"=>15 , "max"=>20  ,    "desc"=>"[15,20)",     "num"=>0 ), 
	array( "min"=>20 , "max"=>25 ,    "desc"=>"[20,25)",     "num"=>0 ), 
	array( "min"=>25, "max"=>30 ,    "desc"=>"[25,30)",    "num"=>0 ), 
	array( "min"=>30, "max"=>50 ,    "desc"=>"[30,50)",    "num"=>0 ), 
	array( "min"=>50, "max"=>100 ,    "desc"=>"[50,100)",    "num"=>0 ), 
	array( "min"=>100, "max"=>'∞' ,    "desc"=>"[100,MAX)",    "num"=>0 ), 
);

//获取用于显示的数据，这个最好不要在本文件的代码写，这样的耦合度是最高的，最好是用接口的形式提供,现在只是模拟数据用来显示
$viewData = getLoginDataAnalyseData($dateStartStamp, $dateEndStamp);

if (count($viewData)) {
	foreach ($viewData as $key => $value) {
    	foreach ($arrArea as &$day) {
    		if ($value['login_times'] >= $day['min'] && ($value['login_times'] < $day['max'] || "∞" == $day['max'])) {
    			$day['num'] += $value['user_num'];
    			$totalCount += $value['user_num'];
    			break;
    		}
    	}
	}
}

$minDate = $serverList[$_SESSION ['gameAdminServer']]['onlinedate'];
$maxDate = Datatime :: getTodayString();
$smarty->assign("minDate", $minDate);
$smarty->assign("maxDate", $maxDate);
$smarty->assign("startDate", $startDate);
$smarty->assign("endDate", $endDate);
$smarty->assign("dateToday", date('Y-m-d'));
$smarty->assign("dateOnline", ONLINEDATE);
$smarty->assign("totalCount", $totalCount);

$smarty->assign('lang', $lang);
$smarty->assign('viewData', $arrArea);
$smarty->display('module/online/login_data_analyse.tpl');

function getLoginDataAnalyseData($dateStartStamp, $dateEndStamp) {
    $sql = "select count(account_name) user_num, login_times from (SELECT count(role_name) login_times, account_name FROM ".T_LOG_LOGIN." where mtime>={$dateStartStamp} and mtime<={$dateEndStamp} group by account_name) U10 group by login_times";
    $result = GFetchRowSet($sql);
    $data = array();
    if(count($result)){
        foreach ($result as $key => $value){
            $data[] = array(
                "login_times" => $value['login_times'],
                "user_num" => $value['user_num'],
            );
        }
    }
	return $data;
}








