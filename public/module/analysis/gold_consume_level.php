<?php
/**
 * 元宝分类等级消耗图
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/goldConfig.php';

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
$filter = isset($_POST['filter']) ? true : false;//是否去掉内部赠送元宝

$dateStartStamp = strtotime($startDate." 0:0:0");
$openTimestamp = strtotime( ONLINEDATE );
if($dateStartStamp < $openTimestamp)
{
	$dateStartStamp = $openTimestamp;
	$startDate = ONLINEDATE;
}
$dateEndStamp = strtotime($endDate." 23:59:59");

$viewType = isset($_POST['view_type']) ? SS($_POST['view_type']) : "all";
$isBind = isset($_POST['is_bind']) ? SS($_POST['is_bind']) : 0;//-1全部，0不绑定，1绑定
$where = 1;
if("all" != $viewType){
    if(key_exists($viewType, $goldType[1])){
        $where .= " and type={$viewType}";
    }
}else{
    $where .= " and `type`>10000 and `type`<20000";//type>10000 and type<20000的为消耗,type>20000 and type<30000的为获得
}
if(0 == $isBind){
    $where .= " and gold>0";
}else if(1 == $isBind){
    $where .= " and bind_gold>0";
}

$viewData = getConsumeByLevel($dateStartStamp, $dateEndStamp, $where, $filter);
$result = array();
for($i = 1; $i <= GAME_MAXLEVEL; $i++){
    if(key_exists($i, $viewData)){
        $result['all_gold'][$i] = $viewData[$i]['gold'] + $viewData[$i]['bind_gold'];
        $result['gold'][$i] = $viewData[$i]['gold'];
        $result['bind_gold'][$i] = $viewData[$i]['bind_gold'];
        $result['level'][$i] = $viewData[$i]['level'];
        $result['num'][$i] = $viewData[$i]['num'];
        $result['times'][$i] = $viewData[$i]['times'];
    }else{
        $result['all_gold'][$i] = 0;
        $result['gold'][$i] = 0;
        $result['bind_gold'][$i] = 0;
        $result['level'][$i] = $i;
        $result['num'][$i] = 0;
        $result['times'][$i] = 0;
    }
}
$result['max_gold'] = max($result['all_gold']);//最大元宝数
$result['max_num'] = max($result['num']);//最大数量
$result['max_times'] = max($result['times']);//最大操作次数
//print_r($result);

$minDate = $serverList[$_SESSION ['gameAdminServer']]['onlinedate'];
$maxDate = date("Y-m-d");
$smarty->assign("lang", $lang);
$smarty->assign("filter", $filter);
$smarty->assign("minDate", $minDate);
$smarty->assign("maxDate", $maxDate);
$smarty->assign("startDate", $startDate);
$smarty->assign("endDate", $endDate);
$smarty->assign("viewType", $viewType);
$smarty->assign('goldType', $goldType[1]);
$smarty->assign('isBindArray', $isBindArray);
$smarty->assign('isBind', $isBind);
$smarty->assign('viewData', $result);
$smarty->display("module/analysis/gold_consume_level.tpl");

function getConsumeByLevel($dateStartStamp, $dateEndStamp, $where, $filter = false){
    $join = '';
    $filterWhere = '';
    if( $filter )
    {
        $join = ' LEFT JOIN
                            (
                                SELECT DISTINCT role_name t_role_name
                                FROM '.T_LOG_SEND_YUANBAO.'  
                                WHERE `type`=2
                            ) ts ON t1.role_name = ts.t_role_name';
        $filterWhere = ' AND ts.t_role_name is null';
    }
    $sql = "select t1.level,sum(t1.gold) gold, sum(t1.bind_gold) bind_gold, sum(t1.num) num, count(t1.role_name) times from ".T_LOG_GOLD." t1 $join where {$where} and t1.mtime>={$dateStartStamp} and t1.mtime<={$dateEndStamp} $filterWhere group by t1.level order by t1.level";
    $result = GFetchRowSet($sql, level);
    return $result;
}