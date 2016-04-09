<?php
/**
 * fsdg_statistics.php
 * 【副本竞速-登云台】 数据统计
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';
include_once SYSDIR_ADMIN_DICT.'/dict.php';

//副本开启时间： 每天22:00-22:30

$today = date('Y-m-d'); 
$todayTime = strtotime($today." 00:00:00 "); 
$todayEndTime = strtotime($today." 23:59:59 "); 

$startDay = $_REQUEST['startDay'] ? $_REQUEST['startDay'] : date("Y-m-d", ($todayTime - 6*86400) );
$endDay = $_REQUEST['endDay'] ? $_REQUEST['endDay'] : $today;

if( strtotime($startDay) < strtotime(ONLINEDATE) ) {
	$startDay = ONLINEDATE;
}

$days = array();
for($i = strtotime($startDay); $i<=  strtotime($endDay) ; $i+= 86400){
	$days[] = date("Y-m-d", $i);
}
foreach( $days as $d ){
	$viewData[$d] = getDytData($d);
	if(empty($viewData[$d])){
		$viewData[$d] = array(
			'mdate' => $d,
			'act_count' => '<font color="blue">(-2)</font>',
			'join_count' => 0,
			'joinRate' => 0,
		);
	}
}

$smarty->assign('viewData', $viewData );

$smarty->assign('lang', $lang );
$smarty->assign('minDate', ONLINEDATE );
$smarty->assign('maxDate', $today );
$smarty->assign('startDay', $startDay );
$smarty->assign('endDay', $endDay );
$smarty->assign('selectDay', $selectDay );
$smarty->display( 'module/activity/dyt_statistics.tpl' );


function getDytData($date) {
    $act_no = 15;
    $sql = "select * from c_activity_join where act_no={$act_no} AND mdate='{$date}'";
    $result = GFetchRowOne($sql);
    if (!empty($result)) {
        $data['mdate'] = $result['mdate'];
        $data['act_count'] = $result['act_count'];
        $data['join_count'] = $result['join_count'];
        $data['joinRate'] = $result['act_count'] ? round($result['join_count'] / $result['act_count'], 4) * 100 : 0;
    } else {
        $data['mdate'] = $date;
        $data['act_count'] = '<font color="blue">(-1)</font>';
        $data['join_count'] = 0;
        $data['joinRate'] = 0;
    }
    return $data;
}