<?php
/**
 * 封禁IP
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
global $lang;

$action = SS($_REQUEST['action']);
$searchIp = SS($_POST['search_ip']);
$record = isset($_POST['record']) ? intval($_POST['record']) : LIST_PER_PAGE_RECORDS;
$method = "banuserip";

if(isset($_POST['banButton'])){
	$params['banIp'] = SS($_POST['ban_ip']);
	$params['banTime'] = (1 == $_POST['ban_time_arr']) ? intval($_POST['ban_time']) : intval($_POST['ban_time_arr']);
    if( empty ( $params['banIp'] ) || empty ( $params['banTime'] ) ){
        $msg = $lang->verify->isNotNull;
    }
    if( empty ( $msg ) ){
        $result = interfaceRequest($method, $params);
        if(1 == $result['result']){
                $data['ban_ip'] = $params['banIp'];
                $data['status'] = 1;//状态0正常,1被禁封,2被手动解封
                $data['reason'] = SS($_POST['ban_reason']);
                //$data['time'] = $params['banTime'];
                $data['op_user'] = $auth->username();
                $data['ban_time'] = NOW_TIMESTAMP;
                $data['end_time'] = $params['banTime'] * 60 + $data['ban_time'];
                $sql = makeInsertSqlFromArray($data, T_BAN_IP);

                GQuery($sql);
                $msg = $lang->verify->opSuc;
                //写日志
                $log = new AdminLogClass();
                $log->Log(AdminLogClass::TYPE_BAN_IP,$lang->log->banIp.":".$data['ban_ip'],'','','','');
        }else{
                $msg = $result['errorMsg'];
        }
    }
}elseif('unban' == $action){
    $ban_ip= SS($_GET['ip']);
    $banTime = SS($_GET['banTime']);
    $id= SS($_GET['id']);
    $params = array(
        'banIp' => $ban_ip,
        'banTime' => $banTime,
    );
    $view = interfaceRequest($method, $params);
    if(1 == $view['result']){
        $sql = " update ".T_BAN_IP." set status = '2' where id = {$id} and ban_ip = '{$ban_ip}' and status = '1' limit 1 ";
        $rs = GQuery($sql);
        $msg = $lang->verify->opSuc;
        //写日志
        $log = new AdminLogClass();
        $log->Log(AdminLogClass::TYPE_UNBAN_IP,$lang->log->unBanIp.":".$ban_ip,'','','','');
    }else{
         $msg = $view['errorMsg'];
    }
}elseif('checkonlinebyip' == $action){// 统计ip在线人数
	$ip = SS($_GET['ip']);
	$ret = array('code' => 0, 'msg' => '', 'data' => 0 );
	if(empty($ip) || !Validator::isIpv4($ip)){
		$ret['msg'] = 'IP格式不正确';
		echo json_encode($ret);
		exit;
	}
	$onlineList = RequestCollection::getOnlineList();

	foreach ( $onlineList['data'] as $item)
	{
		if( strcmp($ip, $item['ip']) == 0 )
		{
			$ret['data']++;
		}
	}
	
	echo json_encode($ret);
	exit;
}
elseif(isset($_POST['remove_expire']))
{
	$sql = 'DELETE FROM ' . T_BAN_IP . ' WHERE end_time < ' . time() .' or status in (1, 3) ';
	$counts = GFetchRowOne($sql);
}
else{
	$banIp = SS($_POST['search_ip']);
}
//$where = $banIp ? " and ban_ip='{$searchIp}'" : "";
$recordCount = 0;//总记录
$pageno = getUrlParam('page');//设置初始页

$startNum = ($pageno - 1) * $record; //每页开始位置
$viewData = getBanIpList($where, $startNum, $record, $recordCount);

$pagelist = getPages($pageno, $recordCount, $record);
$pageCount = ceil($recordCount / $record);
$keyWord['record'] = $record;
$keyWord['page_count'] = $pageCount;
$keyWord['page'] = $pageno;
$keyWord['search_ip'] = $searchIp;
$keyWord['record_count'] = $recordCount;
if(isset ($_POST) && count($viewData)>0) {
    foreach($viewData as $key => &$value){
            if($value['end_time'] <= NOW_TIMESTAMP && 1 == $value['status']){
                $sqlUpdate = "update ".T_BAN_IP." set status = '0' where id = {$value['id']} and status = '1' limit 1";
                GQuery($sqlUpdate);
                $value['status'] = 0;
            }
            $value['end_time'] = date('Y-m-d H:i:s',$value['end_time']);
            $value['ban_time'] = date('Y-m-d H:i:s',$value['ban_time']);
    }
}
$smarty->assign("msg",$msg);
$smarty->assign("lang", $lang);
$smarty->assign("viewData", $viewData);
$smarty->assign("banTime", getBanTime());
$smarty->assign("keyWord", $keyWord);
$smarty->assign("pagelist", $pagelist);
$smarty->assign("record_count", $recordCount);
$smarty->display("module/player/ban_ip.tpl");
exit;
function getBanIpList($where, $startNum, $record, &$counts){
    $sql = "select * from ".T_BAN_IP." where 1 {$where} order by ban_time desc limit {$startNum},{$record}";
    $result = GFetchRowSet($sql);
    
    $sql = "select count(id) counts FROM ".T_BAN_IP." where 1 {$where} ";
    $counts = GFetchRowOne($sql);
    $counts = $counts['counts'];
    return $result;
}