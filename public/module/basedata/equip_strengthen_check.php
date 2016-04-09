<?php
/*
 * 装备强化查询
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT.'/dict.php';
include_once SYSDIR_ADMIN_DICT.'/arrItemsAll.php';
global $lang;

$nowTime = time();
$action  = isset($_POST['action']) ? SS($_POST['action']) : '';
$role    = $_REQUEST['role'];
$role['roleName'] = $roleName    = $role['roleName'] ? autoAddPrefix( SS($role['roleName']) ): '';
$role['accountName'] = $accountName = $role['accountName'] ? autoAddPrefix( SS($role['accountName'])) : '';
$page    = getUrlParam('page');           //设置初始页
$pageLine  = $_POST['pageLine'] ? SS($_POST['pageLine']) : LIST_PER_PAGE_RECORDS;
$filter = isset($_POST['filter']) ? true : false;//是否去掉内部赠送元宝
//获取时间段
if (!isset ($_POST['starttime'])) {
	$startDate = Datatime :: getPreDay(date("Y-m-d"), 1);
} else {
	$startDate = trim($_POST['starttime']);
}
if (!isset ($_POST['endtime'])) {
	$endDate   = Datatime :: getTodayString();
} else {
	$endDate   = trim($_POST['endtime']);
}

$startDateStamp = strtotime($startDate . ' 0:0:0');
$endDateStamp  = strtotime($endDate . ' 23:59:59');
$openTimestamp = strtotime( ONLINEDATE );
if($startDateStamp < $openTimestamp)
{
	$startDateStamp = $openTimestamp;
	$startDate = ONLINEDATE;
}

$where = 1;
$where .= " and t1.`mtime`>=$startDateStamp and t1.`mtime`<=$endDateStamp ";

$where .=  $accountName ? " and t1.`account_name` = '{$accountName}' ":'';
$where .=  $roleName ? " and t1.`role_name` = '{$roleName}' ":'';

//页数
$recordCount = 0;                          //总记录
$startNum  = ($page - 1) * $pageLine;      //每页开始位置
$viewData  = getDataRecord(1,$where,$order,$startNum,$pageLine,&$recordCount, $filter);
$pageCount = ceil($recordCount/$pageLine ); //总页数
$pageList  = getPages($page, $recordCount, $pageLine);

$dateStrPrev = strftime("%Y-%m-%d", strtotime($startDate) - 86400);
$dateStrToday = strftime("%Y-%m-%d");
$dateStrNext = strftime("%Y-%m-%d", strtotime($startDate) + 86400);
$dateOnline = ONLINEDATE;

$minDate = ONLINEDATE;
$maxDate = Datatime :: getTodayString();
$smarty->assign( "filter", $filter);
$smarty->assign("minDate", $minDate);
$smarty->assign("maxDate", $maxDate);
$smarty->assign("dateStrPrev", $dateStrPrev);
$smarty->assign("dateStrToday", $dateStrToday);
$smarty->assign("dateStrNext", $dateStrNext);
$smarty->assign("dateOnline", $dateOnline);
$smarty->assign("startDate", $startDate);
$smarty->assign("endDate", $endDate);

$smarty->assign('lang', $lang);
$smarty->assign('viewData', $viewData);
$smarty->assign('page', $page);
$smarty->assign('arrItemsAll', $arrItemsAll);
$smarty->assign('pageList', $pageList);
$smarty->assign('pageLine', $pageLine);
$smarty->assign('pageCount', $pageCount);
$smarty->assign('role', $role);
$smarty->assign('recordCount', $recordCount);
$smarty->display("module/basedata/equip_strengthen_check.tpl");
exit;

/**
 * @param $tmp 是否使用LIMIT
 */
function getDataRecord($tmp,$where='',$order='',$startNum='',$record='',&$counts='', $filter = false){
	$join = '';
    $filterWhere = '';
    if( $filter )
    {
        $join = ' LEFT JOIN
                            (
                                SELECT DISTINCT role_name t_role_name
                                FROM '.T_LOG_SEND_YUANBAO.'  
                                WHERE `type`=2
                            ) ts ON t1.role_name = ts.t_role_name ';
        $whereCond .= ' AND ts.t_role_name is null';
    }
		$sql = " select t1.`mtime`,t1.`account_name`,t1.`role_name`,t1.`level`,t1.`protect_id`,t1.`stone_id`,t1.`lucky_id`,t1.`lucky_num`,t1.`success_rate`,t1.`rate`,t1.`cost`,t1.`pre_equip_id`,t1.`result`,t1.`after_equip_id`,t1.`strengthen` from `".T_LOG_STRENGTHEN."` t1 $join where {$where} $whereCond"; 
		if(!empty($order)) {
			$sql .= " {$order} ";
		}
		if($tmp==1) {
			$sql.= " LIMIT {$startNum}, {$record} ";
		} 
		$result = GFetchRowSet($sql);
		$counts = GFetchRowOne("SELECT COUNT(t1.`account_name`) as counts FROM `".T_LOG_STRENGTHEN."` t1 $join where {$where} $whereCond");
		$counts = $counts['counts'];
		return $result;
}


