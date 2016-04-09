<?php
/**
 * 玩家元宝消费排行榜
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_CLASS.'/user_class.php';

global $lang;

/*******配置******************************************************************/
$key = 1;	//双方约定的KEY
$method = 'consumerank';
$unixTime = time();
$sign = md5($key.$method.$unixTime);
$pageNum = LIST_PER_PAGE_RECORDS;
/*******配置******************************************************************/

$dateStart = SS($_REQUEST['dateStart']);
$dateEnd = SS($_REQUEST['dateEnd']);

if(empty($dateStart)){
   	 $dateStart = strftime ("%Y-%m-%d", strtotime('-6day',time()));
}
if(empty($dateEnd)){
   	 $dateEnd = date('Y-m-d');
}
$dateStartStamp = strtotime($dateStart.' 0:0:0');
$dateEndStamp = strtotime($dateEnd.' 23:59:59');

$sort_type = isset($_POST['sort_type']) ? SS($_POST['sort_type']) : "total ";

$dateStartStamp = $dateStartStamp < strtotime(ONLINEDATE) ? strtotime(ONLINEDATE) : $dateStartStamp;
$dateStartStamp = $dateStartStamp > $unixTime ? $unixTime:$dateStartStamp;
$dateEndStamp = $dateEndStamp < strtotime(ONLINEDATE) ? strtotime(ONLINEDATE) : $dateEndStamp;
$dateEndStamp = $dateEndStamp > $unixTime ? $unixTime:$dateEndStamp;

$dateStart = $dateStartStamp ? date('Y-m-d',$dateStartStamp): date('Y-m-d');
$dateEnd = $dateEndStamp ? date('Y-m-d',$dateEndStamp): date('Y-m-d');

$dateStartStamp = strtotime($dateStart.' 0:0:0');
$dateEndStamp = strtotime($dateEnd.' 23:59:59');


$dateStrToday = date('Y-m-d');
$dateStrPrev = date('Y-m-d',strtotime('-1day',$dateEndStamp));
$dateStrNext = date('Y-m-d',strtotime('+1day',$dateEndStamp));
$dateStrOnline = date('Y-m-d',strtotime(ONLINEDATE));

$startTime = $dateStartStamp;
$endTime = $dateEndStamp;

$pageNo = getUrlParam('page');//设置初始页
$viewData = getGoldConsumeData($pageNo,$pageNum,$sort_type,$dateStartStamp,$dateEndStamp);

$result = array();
if($viewData){
	$pageCount = $viewData["pageCount"];
	$record = $viewData["recordCount"];
	$data = $viewData["data"];	
}
$pageList = getPages ($pageNo, $record, $pageNum);
$minDate = ONLINEDATE;
$maxDate = date('Y-m-d');

$smarty->assign("dateStart", $dateStart);
$smarty->assign("dateEnd", $dateEnd);
$smarty->assign("dateStrPrev", $dateStrPrev);
$smarty->assign("dateStrNext", $dateStrNext);
$smarty->assign("dateStrToday", $dateStrToday);
$smarty->assign("dateStrOnline", $dateStrOnline);
$smarty->assign('pageNum', $pageNum);
$smarty->assign('pageCount', $pageCount);
$smarty->assign('pageNo', $pageNo);
$smarty->assign('record', $record);
$smarty->assign('pageList', $pageList);
$smarty->assign('result', $data);
$smarty->assign('lang', $lang);
$smarty->assign('sort_type', $sort_type);
$smarty->assign('minDate', $minDate);
$smarty->assign('maxDate', $maxDate);
$smarty->display ( 'module/player/gold_consume_sort.tpl' );

function getGoldConsumeData($page, $pageNum, $sort_type, $dateStartStamp, $dateEndStamp) {
    global $lang;
    
    $where = 1;
    $where .= " and gold<0 ";	//<0为消费,>0为获得
    $where .= " and mtime>={$dateStartStamp} and mtime<={$dateEndStamp} ";

    $sql = "select count(uuid) counts from (select uuid, account_name, sum(gold) total from ".T_LOG_GOLD." where {$where} group by uuid) U10";
    $result = GFetchRowOne($sql);
    $data['recordCount'] = $result['counts'];
    $data['pageCount'] = ceil($data['recordCount']/$pageNum);
    $data['page'] = $page;
    
    $limit = " limit ".($page - 1) * $pageNum.",".$pageNum;

    $sql = "select uuid, account_name, role_name, sum(gold) total from ".T_LOG_GOLD." 
    	where {$where} group by uuid order by {$sort_type} {$limit}";
    $result = GFetchRowSet($sql);
    
    $rank = ($page - 1) * $pageNum + 1;
    foreach ($result as $key => $value) {
        $data['data'][$rank]['rank'] = $rank;
        $data['data'][$rank]['roleName'] = $value['role_name'];
        $data['data'][$rank]['accountName'] = $value['account_name'];
        $data['data'][$rank]['consumeTotal'] = -$value['total'];
        
        if("" == $value['role_name']){
            $user = UserClass::getUser($value['role_name'], $value['account_name']);
            $data['data'][$rank]['roleName'] = $user['role_name'];
        }
        //查找最后登录时间
        $sql = "select max(mtime) mtime from ".T_LOG_LOGIN." where account_name='{$value['account_name']}'";
        $result = GFetchRowOne($sql);
        if($result['mtime']){
            $lastLoginTimeFromNow = floor((NOW_TIMESTAMP - $result['mtime']) / 86400);
            $data['data'][$rank]['lastLoginTime'] = (3 <= $lastLoginTimeFromNow) ? $lastLoginTimeFromNow.$lang->page->dayNotLogin : "";
        }
        //查找最后充值时间
//        $sql = "select max(mtime) mtime from ".T_LOG_PAY." where account_name='{$value['account_name']}'";
//        $result = GFetchRowOne($sql);
//        if($result['mtime']){
//            $lastPayTimeFromNow = floor((NOW_TIMESTAMP - $result['mtime']) / 86400);
//            $data['data'][$rank]['lastPayTime'] = (3 <= $lastPayTimeFromNow) ? $lastPayTimeFromNow.$lang->page->dayNotLogin : "";
//        }
        $rank++;
    }
	return $data;
}