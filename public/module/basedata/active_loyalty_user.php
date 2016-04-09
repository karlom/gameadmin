<?php 
/*
 * 活跃与忠诚用户统计
 * 
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
global $lang;

$page    = getUrlParam('page');           //设置初始页
$pageLine  = $_POST['pageLine'] ? SS($_POST['pageLine']) : LIST_PER_PAGE_RECORDS;

//获取时间段
if (!isset ($_POST['starttime'])) {
    $startDate = Datatime :: getPreDay(date("Y-m-d"), 7);
} else {
    $startDate = trim($_POST['starttime']);
}
if (!isset ($_POST['endtime'])) {
    $endDate   = Datatime :: getTodayString();
} else {
    $endDate   = trim($_POST['endtime']);
}

$startDate = (strtotime($startDate) >= strtotime(ONLINEDATE)) ? $startDate : ONLINEDATE;

$startDateStamp = strtotime($startDate . ' 0:0:0');
$endDateStamp  = strtotime($endDate . ' 23:59:59');

$dateStrPrev = strftime("%Y-%m-%d", strtotime($startDate) - 86400);
$dateStrToday = strftime("%Y-%m-%d");
$dateStrNext = strftime("%Y-%m-%d", strtotime($startDate) + 86400);
$dateOnline = ONLINEDATE;

$select = " `mtime`,`active`,`loyal`,`max_online`,`avg_online`,`new_user`,`total_user` "; 
$order  = " order by `mtime` desc ";
$where  = 1;
$where .= " and `mtime`>=$startDateStamp and `mtime`<=($endDateStamp+1) ";


//页数
$recordCount = 0;                          //总记录
$startNum  = ($page - 1) * $pageLine;      //每页开始位置
$result    = getActiveLoyalty ($select,T_LOG_ACTIVE_LOYALTY_USER,$where,$order,$startNum,$pageLine,&$recordCount);
$pageCount = ceil($recordCount/$pageLine ); //总页数
$pageList  = getPages($page, $recordCount, $pageLine);

$indexAry = array('active','loyal','max_online','avg_online','new_user','total_user');
$max = array();
foreach ($result as &$item){
	$item['date'] = date('Y-m-d',($item['mtime']-10));
        $item['weekend'] = date('w',$item['mtime']);    
        $item['server'] = checkServerday($item['mtime']-10);

        foreach ($indexAry as $idx){
                if (!isset($max[$idx])){
                        $max[$idx] = 0;
                }
                $max[$idx] = max($max[$idx],$item[$idx]);
        }
}

//height = 120px*t/max
foreach ($max as &$item){
        $item = $item/120;
} 

$smarty->assign("minDate", ONLINEDATE);
$smarty->assign("maxDate", Datatime :: getTodayString());
$smarty->assign("dateStrPrev", $dateStrPrev);
$smarty->assign("dateStrToday", $dateStrToday);
$smarty->assign("dateStrNext", $dateStrNext);
$smarty->assign("dateOnline", $dateOnline);
$smarty->assign("startDate", $startDate);
$smarty->assign("endDate", $endDate);

$smarty->assign('lang', $lang);
$smarty->assign('result', $result);
$smarty->assign('max', $max);
$smarty->assign('page', $page);
$smarty->assign('pageList', $pageList);
$smarty->assign('pageLine', $pageLine);
$smarty->assign('pageCount', $pageCount);
$smarty->assign('recordCount', $recordCount);

$smarty->display('module/basedata/active_loyalty_user.tpl');

function getActiveLoyalty ($select,$table,$where,$order,$startNum,$record,& $recordCount) { 
		$sql = "select {$select} from `{$table}` where {$where} group by `mtime` {$order} LIMIT {$startNum}, {$record} ";
		$result = GFetchRowSet($sql);
		//$countSql = " select count(`active`) `total` from {$table} where {$where} group by `mtime`";
		//$count = GFetchRowOne($countSql);
		//$recordCount = $count['total'];
		$recordCount = count($result);
		return $result;
}

function checkServerday($mtime){
        $diff = intval(($mtime -  strtotime(ONLINEDATE))/(60*60*24));
        if( $diff >= 0){
                $diff++;
        }
        return $diff;
}

