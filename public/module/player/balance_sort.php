<?php
/**
 * 玩家元宝余额排行榜
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';

global $lang;
//获取时间
if (!isset ($_GET['date'])) {
    $date = Datatime::getTodayString();
} else {
    $date = SS($_GET['date']);
}

$dateStamp = Datatime::getDayEndTimestamp( $date );
$openTimestamp = Datatime::getDayBeginTimestamp( ONLINEDATE );
if($dateStamp < $openTimestamp)
{
    $dateStamp = $openTimestamp;
    $date = ONLINEDATE;
}
if($dateStamp > Datatime::getDayBeginTimestamp(Datatime::getTodayString()) )
{
    $dateStamp = Datatime::getDayEndTimestamp(Datatime::getTodayString());
    $date = Datatime::getTodayString();
}

$pageNum = LIST_PER_PAGE_RECORDS;
$pageNo = getGetUrlParam('page');//设置初始页
$sort_type = isset($_REQUEST['sort_type']) ? SS($_REQUEST['sort_type']) : "total_gold desc";
$filter = isset($_GET['filter']) ? true : false;//是否去掉内部赠送元宝
$viewData = getGoldBalanceData($dateStamp, $pageNo, $pageNum, $sort_type, $filter);


$result = array();
if($viewData){
	$pageCount = $viewData['pageCount'];
	$record = $viewData["recordCount"];
	$data = $viewData["data"];
//	$i = 0;
//	if($data){
//		foreach($data as $key => $val){
//			$result[$key]["rank"] = $val["rank"];
//			$result[$key]["roleName"] = $val["roleName"];
//			$result[$key]["accountName"] = $val["accountName"];
//			$result[$key]["goldBalance"] = $val["goldBalance"];
//			$result[$key]["bindGoldBalance"] = $val["bindGoldBalance"];
//			$result[$key]["balanceTotal"] = $val["goldBalance"] + $val["bindGoldBalance"];
//			$i++;
//			if($i == $pageNum){
//				break;
//			}
//		}
//	}
}
$pages = getPages2 ($pageNo, $record, $pageNum);

$minDate = $serverList[$_SESSION ['gameAdminServer']]['onlinedate'];
$maxDate = date("Y-m-d");

$smarty->assign('filter', $filter);
$smarty->assign("minDate", $minDate);
$smarty->assign("maxDate", $maxDate);
$smarty->assign("date", $date);
$smarty->assign('pageNum', $pageNum);
$smarty->assign('pageCount', $pageCount);
$smarty->assign('pageNo', $pageNo);
$smarty->assign('record', $record);
$smarty->assign('pages', $pages);
$smarty->assign('result', $data);
$smarty->assign('current_uri', cleanQueryString(URL_SELF, $pages)."sort_type={$sort_type}");
$smarty->assign('lang', $lang);
$smarty->assign('sort_type', $sort_type);
$smarty->display ( 'module/player/balance_sort.tpl' );

function getGoldBalanceData($dateStamp, $page, $pageNum, $sort_type, $filter = false) {
    $join = '';
    $whereCond = " where t1.mtime < $dateStamp ";
    if( $filter )
    {
        $join = ' LEFT JOIN
                            (
                                SELECT DISTINCT role_name t_role_name
                                FROM '.T_LOG_SEND_YUANBAO.'  
                                WHERE `type`=2
                            ) ts ON t1.role_name = ts.t_role_name ';
        $whereCond .= ' AND ts.t_role_name is null ';
    }

    $sql = "select count(account_name) record_count 
            from 
            (
                SELECT U40.role_name, U40.account_name, U40.remain_gold, U40.remain_bind_gold,(U40.remain_gold + U40.remain_bind_gold) total_gold 
                FROM 
                (
                    select U20.* 
                    from 
                    (
                        select t1.role_name, t1.account_name,max(t1.mtime) mtime 
                        from t_log_gold t1 $join $whereCond 
                        group by t1.account_name
                    ) U10 
                    left join t_log_gold U20 on U10.account_name=U20.account_name and U10.mtime=U20.mtime
              
                ) U40 group by account_name
            ) U30 where U30.total_gold>100";
    $result = GFetchRowOne($sql);
    $recordCount = $result['record_count'];
    $pageCount = ceil($recordCount/$pageNum);
    $limit = " limit ".(($page - 1) * $pageNum).",".$pageNum;
    $sql = "select * from (
                SELECT U40.role_name, U40.account_name, U40.remain_gold, U40.remain_bind_gold,(U40.remain_gold + U40.remain_bind_gold) total_gold 
                FROM 
    	       (
                    select U20.* 
                    from 
                    (
                        select t1.role_name, t1.account_name,max(t1.mtime) mtime 
                        from t_log_gold t1 $join $whereCond
                        group by account_name
                    ) U10 
                    left join t_log_gold U20 on U10.account_name=U20.account_name and U10.mtime=U20.mtime 
      
                    order by U20.id desc
                ) U40 group by account_name
            ) U30 where U30.total_gold>100 order by {$sort_type} {$limit}";
    $dataResult = GFetchRowSet($sql);
    $data['recordCount'] = $recordCount;
    $data['pageCount'] = $pageCount;
    $data['page'] = $page;
    $rank = ($page - 1) * $pageNum + 1;
    foreach($dataResult as $key => $value){
        $data['data'][$rank]['rank'] = $rank;
        $data['data'][$rank]['roleName'] = $value['role_name'];
        $data['data'][$rank]['accountName'] = $value['account_name'];
        $data['data'][$rank]['balanceTotal'] = $value['total_gold'];
        $data['data'][$rank]['goldBalance'] = $value['remain_gold'];
        $data['data'][$rank]['bindGoldBalance'] = $value['remain_bind_gold'];
        $rank++;
    }
	return $data;
}