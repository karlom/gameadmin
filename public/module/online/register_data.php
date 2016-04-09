<?php
include_once "../../../protected/config/config.php";
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';
global $lang;
$auth->assertModuleAccess(__FILE__);

$nowTime = time();
//获取时间段
if (!isset ($_POST['starttime'])) {
	$startDate = Datatime :: getPreDay(date("Y-m-d"), 1);
} else {
	$startDate = trim($_POST['starttime']);
}
if (!isset ($_POST['endtime'])) {
	$endDate = Datatime :: getTodayString();
} else {
	$endDate = trim($_POST['endtime']);
}
$year = date('Y',strtotime($startDate));
$month= date('m',strtotime($startDate));
$day  = date('d',strtotime($startDate));

//获取用于显示的数据，这个最好不要在本文件的代码写，这样的耦合度是最高的，最好是用接口的形式提供,现在只是模拟数据用来显示
//$viewData = json_decode(, true);
$viewData = getRegisterData($startDate . ' 00:00:00', $endDate . ' 23:59:59');
//对返回数据进行检查,对缺少的数据填充0
$viewPicData = array();
foreach($viewData as $key => $value) {
	if($key == 'data'){
		foreach($value as $k => &$v) {
			if(empty($value[$k]['register_count'])){
				$value[$k] = array(
					'register_count'=> 0,
				);
			}
			$viewPicData[$k] = $v;
		}
	}
}

$minDate = $serverList[$_SESSION ['gameAdminServer']]['onlinedate'];
$maxDate = Datatime :: getTodayString();
$smarty->assign("minDate", $minDate);
$smarty->assign("maxDate", $maxDate);
$smarty->assign("startDate", $startDate);
$smarty->assign("endDate", $endDate);
$smarty->assign("year", $year);
$smarty->assign("month", $month);
$smarty->assign("day", $day);

$smarty->assign('lang', $lang);
$smarty->assign('viewData', $viewData);
$smarty->assign('viewPicData', $viewPicData);
$smarty->assign('allRegisterUser', $viewData['allRegisterUser']);

$smarty->display("module/online/register_data.tpl");

function getRegisterData($start_time_str = '00:00:00', $end_time_str = '23:59:59'){
	$start_time = strtotime($start_time_str);
	$end_time 	= strtotime($end_time_str);
	
	// 结果数组
	$result = array(
				'allRegisterUser' => 0,
				'data'			  => array()
				);
	// 初始化结果数组的日期
	$tmp_date = date( 'Y-n-j' , $start_time );
	$end_date = date( 'Y-n-j' , $end_time );

	while( true )
	{
		$tmp_date = date( 'Y-n-j', strtotime( $tmp_date ) );
		$tmp_date_array = explode('-', $tmp_date);
		$result['data'][$tmp_date] = array(
										'year' 				=> $tmp_date_array[0],
										'month' 			=> $tmp_date_array[1],
										'day'				=> $tmp_date_array[2],
										'register_count'	=> 0
										);
		if( $tmp_date ==  $end_date ) 
		{// 到截止日期
			break;
		}
	
		$tmp_date = $tmp_date . ' +1 day';
	}
				
	
	$cond = " mtime > $start_time AND mtime < $end_time ";
	
	// 获取区间内每日的注册数
	$sql = "SELECT
				year, month, day, count(*) register_count
			FROM
				" . T_LOG_REGISTER . "
			WHERE
				$cond
			GROUP BY year, month, day
			ORDER BY mtime ASC";
	
	$register_data_list = GFetchRowSet( $sql );
	// 计算总注册数
	$sql_count = "SELECT
						count(*) all_register_count
					FROM
						" . T_LOG_REGISTER ;
	$register_count = GFetchRowOne( $sql_count );
	$result['allRegisterUser'] = $register_count['all_register_count'];
	foreach ( $register_data_list as $register_data)
	{
		$date = $register_data['year'] . '-' . $register_data['month'] . '-' . $register_data['day'] ;
		$result['data'][$date] = $register_data;
	}
	return $result;
	/*
	$data = array(
		'allRegisterUser' => $allRegisterUser,
		'data' => array(
			"2011-11-22" => array (
					"year"  => '2011',
					"month" => '11',
					"day"   => '22',
					"regist"=> '300',
			),
			"2011-11-23" => array (
					"year"  => '2011',
					"month" => '11',
					"day"   => '23',
					"regist"=> '210',
			),
			"2011-11-24" => array (
					"year"  => '2011',
					"month" => '11',
					"day"   => '24',
					"regist"=> 400,
			),
			"2011-11-25" => array (
					"year"  => '2011',
					"month" => '11',
					"day"   => '25',
					"regist"=> null,
			),
			"2011-11-26" => array (
					"year"  => '2011',
					"month" => '11',
					"day"   => '26',
					"regist"=> '150',
			),
			"2011-11-27" => array (
					"year"  => '2011',
					"month" => '11',
					"day"   => '27',
					"regist"=> '400',
			),
			"2011-11-28" => array (
					"year"  => '2011',
					"month" => '11',
					"day"   => '28',
					"regist"=> '170',
			),
		),
	);
	return json_encode($data);
	*/
}




