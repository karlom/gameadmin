<?php

/**
 * 查看在线数据
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
global $lang;

$nowTime = time();

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

//获取用于显示的数据，这个最好不要在本文件的代码写，这样的耦合度是最高的，最好是用接口的形式提供,现在只是模拟数据用来显示
$viewData = getData($dateStartStamp, $dateEndStamp);

$arrDays = array(
//	array( "min"=>0 , "max"=>1  ,    "desc"=>"{$lang->page->notEnough}1{$lang->time->day2}", "num"=>0 ), 
	array( "min"=>1 , "max"=>2  ,    "desc"=>"1{$lang->time->day2}",     "num"=>0 ), 
	array( "min"=>2 , "max"=>3  ,    "desc"=>"2{$lang->time->day2}",     "num"=>0 ), 
	array( "min"=>3 , "max"=>4  ,    "desc"=>"3{$lang->time->day2}",     "num"=>0 ), 
	array( "min"=>4 , "max"=>5  ,    "desc"=>"4{$lang->time->day2}",     "num"=>0 ), 
	array( "min"=>5 , "max"=>6  ,    "desc"=>"5{$lang->time->day2}",     "num"=>0 ), 
	array( "min"=>6 , "max"=>7  ,    "desc"=>"6{$lang->time->day2}",     "num"=>0 ), 
	array( "min"=>7 , "max"=>8  ,    "desc"=>"7{$lang->time->day2}",     "num"=>0 ), 
	array( "min"=>8 , "max"=>9  ,    "desc"=>"8{$lang->time->day2}",     "num"=>0 ), 
	array( "min"=>9 , "max"=>10 ,    "desc"=>"9{$lang->time->day2}",     "num"=>0 ), 
	array( "min"=>10, "max"=>11 ,    "desc"=>"10{$lang->time->day2}",    "num"=>0 ), 
	array( "min"=>11, "max"=>12 ,    "desc"=>"11{$lang->time->day2}",    "num"=>0 ), 
	array( "min"=>12, "max"=>13 ,    "desc"=>"12{$lang->time->day2}",    "num"=>0 ), 
	array( "min"=>13, "max"=>14 ,    "desc"=>"13{$lang->time->day2}",    "num"=>0 ), 
	array( "min"=>14, "max"=>15 ,    "desc"=>"14{$lang->time->day2}",    "num"=>0 ), 
	array( "min"=>15, "max"=>16 ,    "desc"=>"15{$lang->time->day2}",    "num"=>0 ), 
	array( "min"=>16, "max"=>17 ,    "desc"=>"16{$lang->time->day2}",    "num"=>0 ), 
	array( "min"=>17, "max"=>18 ,    "desc"=>"17{$lang->time->day2}",    "num"=>0 ), 
	array( "min"=>18, "max"=>19 ,    "desc"=>"18{$lang->time->day2}",    "num"=>0 ), 
	array( "min"=>19, "max"=>20 ,    "desc"=>"19{$lang->time->day2}",    "num"=>0 ), 
	array( "min"=>20, "max"=>21 ,    "desc"=>"20{$lang->time->day2}",    "num"=>0 ), 
	array( "min"=>21, "max"=>22 ,    "desc"=>"21{$lang->time->day2}",    "num"=>0 ), 
	array( "min"=>22, "max"=>23 ,    "desc"=>"22{$lang->time->day2}",    "num"=>0 ), 
	array( "min"=>23, "max"=>24 ,    "desc"=>"23{$lang->time->day2}",    "num"=>0 ), 
	array( "min"=>24, "max"=>25 ,    "desc"=>"24{$lang->time->day2}",    "num"=>0 ), 
	array( "min"=>25, "max"=>26 ,    "desc"=>"25{$lang->time->day2}",    "num"=>0 ), 
	array( "min"=>26, "max"=>27 ,    "desc"=>"26{$lang->time->day2}",    "num"=>00 ), 
	array( "min"=>27, "max"=>28 ,    "desc"=>"27{$lang->time->day2}",    "num"=>0 ), 
	array( "min"=>28, "max"=>29 ,    "desc"=>"28{$lang->time->day2}",    "num"=>0 ), 
	array( "min"=>29, "max"=>30 ,    "desc"=>"29{$lang->time->day2}",    "num"=>0 ), 
	array( "min"=>30, "max"=>31 ,    "desc"=>"30{$lang->time->day2}",    "num"=>0 ), 
	array( "min"=>31, "max"=>"∞", "desc"=>"30{$lang->time->day2}{$lang->page->above}", "num"=>0 ),
);

$arrMinutes = array(
	array( "min"=>0   , "max"=>1   , "desc"=>"{$lang->page->notEnough}1{$lang->time->min}", "num"=>0 ),
	array( "min"=>1   , "max"=>2   , "desc"=>"1-2{$lang->time->min}",   "num"=>0 ),
	array( "min"=>2   , "max"=>3   , "desc"=>"2-3{$lang->time->min}",   "num"=>0 ),
	array( "min"=>3   , "max"=>4   , "desc"=>"3-4{$lang->time->min}",   "num"=>0 ),
	array( "min"=>4   , "max"=>5   , "desc"=>"4-5{$lang->time->min}",   "num"=>0 ),
	array( "min"=>5   , "max"=>6   , "desc"=>"5-6{$lang->time->min}",   "num"=>0 ),
	array( "min"=>6   , "max"=>7   , "desc"=>"6-7{$lang->time->min}",   "num"=>0 ),
	array( "min"=>7   , "max"=>8   , "desc"=>"7-8{$lang->time->min}",   "num"=>0 ),
	array( "min"=>8   , "max"=>9   , "desc"=>"8-9{$lang->time->min}",   "num"=>0 ),
	array( "min"=>9   , "max"=>10  , "desc"=>"9-10{$lang->time->min}",  "num"=>0 ),
	array( "min"=>10  , "max"=>11  , "desc"=>"10-11{$lang->time->min}", "num"=>0 ),
	array( "min"=>11  , "max"=>12  , "desc"=>"11-12{$lang->time->min}", "num"=>0 ),
	array( "min"=>12  , "max"=>13  , "desc"=>"12-13{$lang->time->min}", "num"=>0 ),
	array( "min"=>13  , "max"=>14  , "desc"=>"13-14{$lang->time->min}", "num"=>0 ),
	array( "min"=>14  , "max"=>15  , "desc"=>"14-15{$lang->time->min}", "num"=>0 ),
	array( "min"=>15  , "max"=>16  , "desc"=>"15-16{$lang->time->min}", "num"=>0 ),
	array( "min"=>16  , "max"=>17  , "desc"=>"16-17{$lang->time->min}", "num"=>0 ),
	array( "min"=>17  , "max"=>18  , "desc"=>"17-18{$lang->time->min}", "num"=>0 ),
	array( "min"=>18  , "max"=>19  , "desc"=>"18-19{$lang->time->min}", "num"=>0 ),
	array( "min"=>19  , "max"=>20  , "desc"=>"19-20{$lang->time->min}", "num"=>0 ),
	array( "min"=>20  , "max"=>25  , "desc"=>"20-25{$lang->time->min}", "num"=>0 ),
	array( "min"=>25  , "max"=>30  , "desc"=>"25-30{$lang->time->min}", "num"=>0 ),
	array( "min"=>30  , "max"=>35  , "desc"=>"30-35{$lang->time->min}", "num"=>0 ),
	array( "min"=>35  , "max"=>40  , "desc"=>"35-40{$lang->time->min}", "num"=>0 ),
	array( "min"=>40  , "max"=>45  , "desc"=>"40-45{$lang->time->min}", "num"=>0 ),
	array( "min"=>45  , "max"=>50  , "desc"=>"45-50{$lang->time->min}", "num"=>0 ),
	array( "min"=>50  , "max"=>55  , "desc"=>"50-55{$lang->time->min}", "num"=>0 ),
	array( "min"=>55  , "max"=>60  , "desc"=>"55-60{$lang->time->min}", "num"=>0 ),
	array( "min"=>60  , "max"=>120 , "desc"=>"1-2{$lang->time->hour2}",   "num"=>0 ),
	array( "min"=>120 , "max"=>180 , "desc"=>"2-3{$lang->time->hour2}",   "num"=>0 ),
	array( "min"=>180 , "max"=>240 , "desc"=>"3-4{$lang->time->hour2}",   "num"=>0 ),
	array( "min"=>240 , "max"=>300 , "desc"=>"4-5{$lang->time->hour2}",   "num"=>0 ),
	array( "min"=>300 , "max"=>360 , "desc"=>"5-6{$lang->time->hour2}",   "num"=>0 ),
	array( "min"=>360 , "max"=>420 , "desc"=>"6-7{$lang->time->hour2}",   "num"=>0 ),
	array( "min"=>420 , "max"=>480 , "desc"=>"7-8{$lang->time->hour2}",   "num"=>0 ),
	array( "min"=>480 , "max"=>540 , "desc"=>"8-9{$lang->time->hour2}",   "num"=>0 ),
	array( "min"=>540 , "max"=>600 , "desc"=>"9-10{$lang->time->hour2}",  "num"=>0 ),
	array( "min"=>600 , "max"=>900 , "desc"=>"10-15{$lang->time->hour2}", "num"=>0 ),
	array( "min"=>900 , "max"=>1200, "desc"=>"15-20{$lang->time->hour2}", "num"=>0 ),
	array( "min"=>1200, "max"=>1440, "desc"=>"20-24{$lang->time->hour2}", "num"=>0 ),
);

$totalDayNum = 0;
foreach ($viewData['dataList2'] as $row) {
	foreach ($arrDays as &$day) {
		if ($row['days'] >= $day['min'] && ($row['days'] < $day['max'] || "∞" == $day['max'])) {
			$day['num'] += $row['num'];
			$totalDayNum += $row['num'];
			break;
		}
	}
}

$totalMinuteNum = 0;
foreach ($viewData['dataList1'] as $row) {
	foreach ($arrMinutes as &$minute) {
		if ($row['minutes'] >= $minute['min'] && $row['minutes'] < $minute['max'] ) {
			$minute['num'] += $row['num'];
			$totalMinuteNum += $row['num'];
			break;
		}
	}
}


$minDate = ONLINEDATE;
$maxDate = date("Y-m-d");

$smarty->assign("minDate", $minDate);
$smarty->assign("maxDate", $maxDate);
$smarty->assign("startDate", $startDate);
$smarty->assign("endDate", $endDate);

$smarty->assign("lang", $lang);
$smarty->assign("totalDayNum", $totalDayNum);
$smarty->assign("totalMinuteNum", $totalMinuteNum);
$smarty->assign("viewData", array("arrMinutes" => $arrMinutes, "arrDays" => $arrDays));
$smarty->display("module/basedata/time_lose_rate.tpl");

function getData($dateStartStamp, $dateEndStamp) {
	$sql = "SELECT round((max(U10.mtime)-U20.mtime)/60) min,U10.account_name FROM ".T_LOG_LOGOUT.
	" U10 left join ".T_LOG_REGISTER." U20 on U10.account_name=U20.account_name where U20.mtime>={$dateStartStamp} and U20.mtime<={$dateEndStamp} group by U10.account_name";
	$result = GFetchRowSet($sql);
	$data = array("dataList1" => array(), "dataList2" => array());
	foreach($result as $key => $value){
		if(0 <= $value['min']){
			if(1440 >= $value['min']){
				if(array_key_exists("$value[min]", $data['dataList1'])){
					$data['dataList1'][$value['min']]['num'] += 1;
				}else{
					$data['dataList1'][$value['min']]['minutes'] = $value['min'];
					$data['dataList1'][$value['min']]['num'] = 1;
				}
			}else{
				$days = floor($value['min'] / 1440);
				if(array_key_exists("{$days}", $data['dataList2'])){
					$data['dataList2'][$days]['num'] += 1;
				}else{
					$data['dataList2'][$days]['days'] = $days;
					$data['dataList2'][$days]['num'] = 1;
				}
			}
		}
	}
	return $data;
}