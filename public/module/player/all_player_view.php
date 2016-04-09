<?php
/**
 * 所有注册玩家
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';

global $lang;

$role = $_POST['role'];
$roleName = $role['role_name'] ; 
$accountName = $role['account_name'] ; 
$pageNum = $_POST['record'] ? SS($_POST['record']) : LIST_PER_PAGE_RECORDS;

//获取时间段
if (! isset ( $_POST ['starttime'] )){
    $dateStart = Datatime::getPrevWeekString ();
}else{
    $dateStart = SS ( $_POST ['starttime'] );
}
$dateStart = (strtotime($dateStart) >= strtotime(ONLINEDATE)) ? $dateStart : ONLINEDATE;
$dateEnd = ! isset ($_POST['endtime']) ? Datatime::getTodayString() :  SS ($_POST['endtime']);
$dateStartTamp = strtotime($dateStart." 0:0:0");
$dateEndTamp = strtotime($dateEnd." 23:59:59");
//if($roleName || $accountName){
$record = intval($_POST['record']);
if(empty ($record)){
    $record = LIST_PER_PAGE_RECORDS;
}
$where = " and mtime >= {$dateStartTamp} and mtime <= {$dateEndTamp} ";
$where .= $roleName ? " and role_name = '{$roleName}' " :"";
$where .= $accountName ? " and account_name = '{$accountName}' " : "";
$counts = 0;//总记录
$pageno = getUrlParam('page');//设置初始页
$startNum = ($pageno - 1) * $record; //每页开始位置
$viewData = getAllPlayerData($where,$startNum,$record,$counts);
//print_r($viewData);
if($viewData){
    foreach($viewData as &$row){
        $row['regist_time'] = date('Y-m-d H:i:s',$row['registe_time']);
        $row['last_login_time'] = $row['last_login_time'] ? date('Y-m-d H:i:s',$row['last_login_time']) : "";
        $row['career'] = $row['career'] ? $dictOccupationType[$row['career']] : "";
    }
}

$pageCount = ceil ( $counts/$record );
$pagelist = getPages($pageno, $counts,$record);
//}
$maxDate = date ( "Y-m-d" );
$data = array(
    'counts' => $counts,
    'record' => $record,
    'minDate' => ONLINEDATE,
    'maxDate' => $maxDate,
    'role' => $role,
    'pagelist' => $pagelist,
    'pageCount' => $pageCount,
    'pageNum' => $pageNum,
    'pageno' => $pageno,
    'dateStart' => $dateStart,
    'dateEnd' => $dateEnd,
    'lang' => $lang,
    'viewData' => $viewData,
);
$smarty->assign ($data);
$smarty->display ( 'module/player/all_player_view.tpl' );

function getAllPlayerData($where,$startNum,$record,& $counts) {
//    $sql = "select U30.*, U40.career from (select U10.*, U20.camp from (select account_name, role_name, mtime registe_time from ".T_LOG_REGISTER." 
//    	WHERE 1 {$where} order by registe_time desc limit {$startNum},{$record}) U10 left join  
//    	".T_LOG_CAMP." U20 on U10.account_name=U20.account_name) U30 left join ".T_LOG_CAREER." U40 on U30.account_name=U40.account_name";
    $sql = "select U10.*, U20.career from (select uuid, account_name, role_name, mtime registe_time, pf from ".T_LOG_REGISTER." 
    	WHERE 1 {$where} order by registe_time desc limit {$startNum},{$record}) U10 left join ".T_LOG_CAREER." U20 on U10.uuid=U20.uuid";

    $rs = GFetchRowSet($sql);

    $loginSql = "";
    $levelSql = "";
    $data = array();
    if($rs){
        foreach($rs as $key => $value){
        	$acname = SS($value['account_name']);
            //最后登录时间
            $loginSql .= "select U10.*, U20.ip from (select uuid,account_name, max(mtime) last_login_time from ".T_LOG_LOGIN." where account_name='{$acname}' group by uuid) U10, ".T_LOG_LOGIN." U20 
            where U10.uuid=U20.uuid and U10.last_login_time=U20.mtime union all ";
            //最大等级
            $levelSql .= "select uuid, account_name, max(level) level from ".T_LOG_LEVEL_UP." where account_name='{$acname}' group by uuid union all ";
            $data[$value['account_name']] = $value;
        }
        $loginSql = rtrim($loginSql, " union all ");
        $levelSql = rtrim($levelSql, " union all ");
        $loginRs = GFetchRowSet($loginSql);

        if($loginRs){
            foreach($loginRs as $key => $value){
                if(key_exists($value['account_name'], $data)){
                    $data[$value['account_name']]['last_login_time'] = $value['last_login_time'];
                    $data[$value['account_name']]['last_login_ip'] = $value['ip'];
                }
            }
        }
        $levelRs = GFetchRowSet($levelSql);

        if($levelRs){
            foreach($levelRs as $key => $value){
                if(key_exists($value['account_name'], $data)){
                    $data[$value['account_name']]['level'] = $value['level'];
                }else{
                    $data[$value['account_name']]['level'] = 1;
                }
            }
        }
    }

    $sqlCount = "select count(*) as cnt from ".T_LOG_REGISTER." where 1 {$where} ";
    $rsCount = GFetchRowOne($sqlCount);
    $counts = $rsCount['cnt'];
    
    return $data;
}