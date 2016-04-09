<?php 
/**
 * @abstract 查看错误日志
 */

// 导入配置文件
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';
include_once FILE_ETL_CONFIG.'/log_template_config.php';
include FILE_ETL_CLASS.'/LogTemplate.php';

global $lang;
$serverId = isset($_SESSION['gameAdminServer']) ? $_SESSION['gameAdminServer'] : -1;

if(-1 != $serverId){
    $action = isset($_POST['action']) ? SS($_POST['action']) : "";
    //获取时间段
    if (!isset ($_POST['starttime'])) {
    	$startDate = Datatime :: getPreDay(date("Y-m-d"), 0);
    } else {
    	$startDate = SS($_POST['starttime']);
    }
    if (!isset ($_POST['endtime'])) {
    	$endDate = Datatime :: getTodayString();
    } else {
    	$endDate = SS($_POST['endtime']);
    }
    $dateStartStamp = strtotime($startDate." 0:0:0");
    $dateEndStamp = strtotime($endDate." 23:59:59");
    $where = 1;
    $where .= " and mtime>={$dateStartStamp} and mtime<={$dateEndStamp}";
    if("reloadAll" == $action){//全部重拉
        $sql = "select id,table_name,path,try_times from ".T_LOG_ETL_ERROR." where status=0 and {$where}";
        $result = GFetchRowSet($sql);
        if(0 < count($result)){
            foreach($result as $key => $value){
                $obj = new LogTemplate($value['table_name'], $serverId);
    			$obj->getExtractFile($value['path']);
			    $data = array(
			        "id" => $value['id'],
			        "try_times" => $value['try_times'] + 1,
			        "last_try_time" => time(),
			    );
    			if($obj->loadIntoDb()){
    			    $data['status'] = 1;
    			}
    			$sql = makeUpdateSqlFromArray($data, T_LOG_ETL_ERROR);
    			GQuery($sql);
			    $msg = $data['status'] ? $lang->msg->reloadSuccess : $lang->msg->reloadFailure;
            }
        }else{
            $msg = "NO RECORD NEED TO RELOAD";
        }
        echo $msg;
        exit();
    }else if("reloadOne" == $action){//重拉一个
        $id = isset($_POST['id']) ? intval($_POST['id']): 0;
        $sql = "select table_name,path,try_times from ".T_LOG_ETL_ERROR." where id={$id} and status=0 and {$where}";
        $result = GFetchRowOne($sql);
        if(0 < count($result)){
            $obj = new LogTemplate($result['table_name'], $serverId);
			$obj->getExtractFile($result['path']);
		    $data = array(
		        "id" => $id,
		        "try_times" => $result['try_times'] + 1,
		        "last_try_time" => time(),
		    );
			if($obj->loadIntoDb()){
			    $data['status'] = 1;
			}
			$sql = makeUpdateSqlFromArray($data, T_LOG_ETL_ERROR);
			GQuery($sql);
			$msg = $data['status'] ? $lang->msg->reloadSuccess : $lang->msg->reloadFailure;
        }else{
            $msg = "ID NOT EXIST";
        }
        echo $msg;
        exit();
    }
    
    $sql = "select * from ".T_LOG_ETL_ERROR." where status=0 and {$where} order by mtime desc";
    $result = GFetchRowSet($sql);
    foreach($result as $key => &$value){
        $fileName = explode("/", $value['path']);
        $value['desc'] .= ":".$fileName[count($fileName)-1];
        if(!$value['last_try_time']){
            $value['last_try_time'] = $value['mtime'];
        }
    }
    
    $maxDate = date("Y-m-d");

    $smarty->assign("minDate", ONLINEDATE);
    $smarty->assign("maxDate", $maxDate);
    $smarty->assign("startDate", $startDate);
    $smarty->assign("endDate", $endDate);
    $smarty -> assign('lang', $lang);
    $smarty -> assign('result', $result);
    $smarty -> assign('msg', $msg);
    $smarty -> display("module/system/game_log_status_view.tpl");
}else{
	die($lang->msg->getServerIdFailure);
}