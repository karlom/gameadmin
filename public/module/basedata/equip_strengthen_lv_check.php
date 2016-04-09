<?php
/*
 * 等级强化查询
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
$where .=  $roleName ? " and `t1.role_name` = '{$roleName}' ":'';

$group = " group by t1.`pre_strengthen` "; 
$order = " order by t1.`mtime` desc,t1.`equip_uid`,t1.`after_equip_id`,t1.`role_name`,t1.`level`,t1.`strengthen` desc ";

//页数
//查询结果
$recordCount = 0;                          //总记录
$startNum  = ($page - 1) * $pageLine;      //每页开始位置
$viewData  = getDataRecord(1,$where,$order,$startNum,$pageLine,&$recordCount, $filter);
$pageCount = ceil($recordCount/$pageLine ); //总页数
$pageList  = getPages($page, $recordCount, $pageLine);

//统计结果
$countResult = getDataCount($where,$group,&$data,&$data2,&$data3, $filter);
$totalArr    = array();
foreach($countResult as $key => &$value){
	foreach($data as $k=>$v){
		if($value['pre_strengthen']==$v['pre_strengthen']) {
				if($v['result']==1){
					$value['success'] = $v['results'];
					$totalArr['totalSuccess'] += $v['results'];
				}	
				if($v['result']==2){
					$value['failure'] = $v['results'];
					$totalArr['totalFailure'] += $v['results'];
				}	
		}
	}
	$value['pre_strengthen'] = "(".$value['pre_strengthen'].",".($value['pre_strengthen']+1).")";
	$totalArr['totalOperates'] += $value['results'];
	$totalArr['totalEquips'] += $value['equips'];
	$totalArr['totalProtects'] += $value['protects'];
	$totalArr['totalLuckys'] += $value['luckys'];
}

foreach ($countResult as $c=>&$t){
	$t['successRate'] = round( $t['success'] / $t['results'] , 2) * 100;
	$t['failureRate'] = round( $t['failure'] / $t['results'] , 2) * 100;
}

$dateStrPrev = strftime("%Y-%m-%d", strtotime($startDate) - 86400);
$dateStrToday = strftime("%Y-%m-%d");
$dateStrNext = strftime("%Y-%m-%d", strtotime($startDate) + 86400);
$dateOnline = ONLINEDATE;

$minDate = ONLINEDATE;
$maxDate = Datatime :: getTodayString();
$smarty->assign( "filter", $filter);
$smarty->assign("countResult", $countResult);
$smarty->assign("totalArr", $totalArr);
$smarty->assign("data2", $data2);
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
$smarty->assign('data3', $data3);
$smarty->assign('page', $page);
$smarty->assign('arrItemsAll', $arrItemsAll);
$smarty->assign('pageList', $pageList);
$smarty->assign('pageLine', $pageLine);
$smarty->assign('pageCount', $pageCount);
$smarty->assign('role', $role);
$smarty->assign('recordCount', $recordCount);
$smarty->display("module/basedata/equip_strengthen_lv_check.tpl");
exit;

/**
 * @param $tmp 是否使用LIMIT
 * 等级查询
 */
function getDataRecord($tmp,$where='',$order='',$startNum='',$record='',&$counts='',$filter = false){
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
		$sql = " select t1.`mtime`,t1.`equip_uid`,t1.`account_name`,t1.`role_name`,t1.`level`,t1.`protect_id`,t1.`stone_id`,t1.`lucky_id`,t1.`lucky_num`,t1.`success_rate`,t1.`rate`,t1.`cost`,t1.`pre_equip_id`,t1.`pre_strengthen`,t1.`result`,t1.`after_equip_id`,t1.`strengthen` from `".T_LOG_STRENGTHEN."` t1 $join where {$where} $whereCond"; 
		if(!empty($order)) {
			$sql .= " {$order} ";
		}
		if($tmp==1) {
			$sql.= " LIMIT {$startNum}, {$record} ";
		} 
		$result = GFetchRowSet($sql);
		$counts = GFetchRowOne("SELECT COUNT(t1.`account_name`) as counts FROM `".T_LOG_STRENGTHEN."` t1 $join  where {$where} $whereCond");
		$counts = $counts['counts'];
		return $result;
}

/**
 * @param $tmp 是否使用LIMIT
 * 等级统计
 */
function getDataCount($where='',$group='',&$result2, &$result3, &$result4){
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
		//强化前等级角色数,总结果（成功+失败）
		$sql = " select t1.`pre_strengthen`,count(distinct t1.`role_name`) `roleNames`,count(t1.`after_equip_id`) `equips`,count(t1.`protect_id`) `protects`,sum(t1.`lucky_num`) `luckys`,count(t1.`result`) `results` from `".T_LOG_STRENGTHEN."` t1 $join where {$where} $whereCond"; 
		if(!empty($group)) {
			$sql .= " {$group} ";
		}
		$sql .= " order by t1.`pre_strengthen`,t1.`result` ";
		$result = GFetchRowSet($sql);

		//成功,失败分类
		$sql = " select t1.`pre_strengthen`,count(distinct t1.`role_name`) `roleNames`,count(t1.`after_equip_id`) `equips`,count(t1.`protect_id`) `protects`,sum(t1.`lucky_num`) `luckys`,count(t1.`result`) `results` from `".T_LOG_STRENGTHEN."` t1 $join where {$where} $whereCond "; 
		$sql2 = " select t1.`pre_strengthen`,count(t1.`result`) `results`,t1.`result` from `".T_LOG_STRENGTHEN."` t1 $join where {$where} $whereCond group by t1.`pre_strengthen`,t1.`result` order by t1.`pre_strengthen`,t1.`result` ";
		$result2 = GFetchRowSet($sql2);

		//汇总角色数统计
		$sql3 = " select count(distinct t1.`role_name`) `totalRoles` from `".T_LOG_STRENGTHEN."` t1 $join where {$where} $whereCond ";
		$result3 = GFetchRowOne($sql3);

		//汇总强化前+3角色数统计,过滤系统引导前3级的玩家数
		$sql4 = " SELECT COUNT(DISTINCT A.`role_name`) `totalRoles` FROM (select t1.`role_name`,max(t1.`pre_strengthen`) `max_strengthen` from `".T_LOG_STRENGTHEN."` t1 $join where {$where} $whereCond and `pre_strengthen`>=3 group by `role_name`) A ";
		$result4 = GFetchRowOne($sql4);

		return $result;
}


