<?php
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
global $lang;

$nowTime = time();
$type = HOW_LONG_TIME_PER_POINT; //表示n分钟一个点

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
//获取用于显示的数据，这个最好不要在本文件的代码写，这样的耦合度是最高的，最好是用接口的形式提供,现在只是模拟数据用来显示
$viewData = json_decode(getOnlineHistoryData($startDate, $endDate, $type), true);

//对返回数据进行检查,对缺少的数据填充0
if ($viewData['data']) {
	foreach ($viewData['data'] as $key => & $data) {
		$end = ($key == date("Y-m-d")) ? ($nowTime -strtotime($key)) / ($type * 60) : 24 * 3600 / ($type * 60);
		for ($i = 0; $i < $end; $i++) {
			if (!array_key_exists($i, $data)) {
				$data[$i] = array (
					"num" => 0,
					"point" => $i
				);
			}
		}
	}
}

$maxDate = date("Y-m-d");

$smarty->assign("minDate", SERVER_ONLINE_DATE);
$smarty->assign("maxDate", $maxDate);

$smarty->assign('lang', $lang);
$smarty->assign('viewData', $viewData);
$smarty->display('module/online/history_online.tpl');

function getOnlineHistoryData($startDate, $endDate, $type) {
	$data = array (
		'action' => 1,
		'timeType' => $type,
		'dataStart' => $startDate,
		'dataEnd' => $endDate,
		'dataTotle' => Datatime :: getTotleDay($startDate, $endDate),
		'data' => array (
			"2011-11-14" => array (
				array (
					"mtime" => 132332222,
					"num" => 1000,
					"point" => 0
				),
				array (
					"mtime" => 132332222,
					"num" => 1000,
					"point" => 1
				),
				array (
					"mtime" => 132332222,
					"num" => 1000,
					"point" => 2
				),
				array (
					"mtime" => 132332222,
					"num" => 1000,
					"point" => 3
				),
				array (
					"mtime" => 132332222,
					"num" => 1000,
					"point" => 4
				)
			),
			"2011-11-13" => array (
				array (
					"mtime" => 132332222,
					"num" => 1000,
					"point" => 0
				),
				array (
					"mtime" => 132332222,
					"num" => 1000,
					"point" => 1
				),
				array (
					"mtime" => 132332222,
					"num" => 1000,
					"point" => 2
				),
				array (
					"mtime" => 132332222,
					"num" => 1000,
					"point" => 3
				),
				array (
					"mtime" => 132332222,
					"num" => 1000,
					"point" => 4
				)
			),
			"2011-11-12" => array (
				array (
					"mtime" => 132332222,
					"num" => 1000,
					"point" => 0
				),
				array (
					"mtime" => 132332222,
					"num" => 1000,
					"point" => 1
				),
				array (
					"mtime" => 132332222,
					"num" => 1000,
					"point" => 2
				),
				array (
					"mtime" => 132332222,
					"num" => 1000,
					"point" => 3
				),
				array (
					"mtime" => 132332222,
					"num" => 1000,
					"point" => 4
				)
			),

			
		)
	);
	return json_encode($data);
}