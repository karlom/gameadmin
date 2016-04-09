<?php
/**
 * 地图流失率
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';

global $lang;
set_time_limit(0);

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

$dateStartStamp = strtotime($startDate." 0:0:0");
$dateEndStamp = strtotime($endDate." 23:59:59");

$openTimestamp = strtotime( ONLINEDATE );
if($dateStartStamp < $openTimestamp)
{
	$dateStartStamp = $openTimestamp;
	$startDate = ONLINEDATE;
}
if($_POST['submit']){
    $mapIDs = $_POST['map_id'];
    $levelMin = intval($_POST['level_min']);
    $levelMax = intval($_POST['level_max']);
    $levelMin = (0 < $levelMin) ? $levelMin : 1;
    $levelMax = (0 < $levelMax) ? $levelMax : 1;
    if($levelMin > $levelMax){
        $temp = $levelMin;
        $levelMin = $levelMax;
        $levelMax = $temp;
    }
    $levelPerMap = intval($_POST['level_per_map']);
    if($mapIDs){
        $result = getData($dateStartStamp, $dateEndStamp, $mapIDs, array("min" => $levelMin, "max" => $levelMax), $levelPerMap);
//        $fileName = "/tmp/".GAME_EN_NAME."/".PROXY."/".PROXY."_{$_SESSION['gameAdminServer']}_".date("YmdHis").".php";
        $fileName = "/tmp/".PROXY."_{$_SESSION['gameAdminServer']}_".date("YmdHis").".php";
        fmkdir(dirname($fileName));
        if(!empty($result)){
            $str=<<<PHPSTR
<?php
\$lossData = 
PHPSTR;
            $str .= var_export($result,true).';';
        }
    	$putSize = @file_put_contents($fileName, $str);
    	$msg = $putSize ? $lang->alert->dataWriteFailure : $lang->verify->opSuc;
    	
    	$smarty->assign('fileName', $fileName);
    }else{
        $msg = $lang->msg->mustSelectAMap;
    }
}
$minDate = ONLINEDATE;
$maxDate = date ( "Y-m-d" );
$smarty->assign('minDate', $minDate);
$smarty->assign('maxDate', $maxDate);
$smarty->assign('startDate', $startDate);
$smarty->assign('endDate', $endDate);
$smarty->assign('action', $action);
$smarty->assign('maxLevel', GAME_MAXLEVEL);
$smarty->assign('lang', $lang);
$smarty->assign('mapArray', $mapArray);
$smarty->display('module/basedata/map_loss_rate.tpl');

function getData($dateStartStamp, $dateEndStamp, $map_ids, $level, $levelPerMap){
    global $lang;
    
    $data = array();
    if($map_ids){
        foreach ($map_ids as $map_id){
            $result = array();
            $total = array();
            $where = 1;
            if($level['min']){
                $where .= " and level>={$level['min']}";
            }
            if($level['max']){
                $where .= " and level<={$level['max']}";
            }
//            $where .= " and mtime>={$dateStartStamp} and mtime<={$dateEndStamp} ";
            $where .= " and map_id={$map_id} ";
//            $sql = "
//            	select * from (
//            	select * from (select U10.account_name, U20.account_name account_name2 from (select account_name from ".T_LOG_REGISTER." where mtime>={$dateStartStamp} and mtime<={$dateEndStamp}) U10 
//            	left join (select distinct account_name from ".T_LOG_LOGIN." where mtime>{$dateEndStamp} and mtime<=".($dateEndStamp + 2 * 3600).") U20 on U10.account_name=U20.account_name) where account_name2 is null) U30,
//            	(select account_name,max(mtime) mtime from ".T_LOG_LOGOUT." where mtime>={$dateStartStamp} and mtime<=".($dateEndStamp).")";
            if($levelPerMap){
                $result = array();
//                for($i = $level['min']; $i <= $level['max']; $i++){
                    //如：15号注册的人，16 17号没登录（没有登出记录）就算流失
                    $sql = "select level,axis,count(axis) num,x_axis x,y_axis y from (SELECT level,concat(floor(x_axis/".MAP_LOSS_PIXELS."), ',',floor(y_axis/".MAP_LOSS_PIXELS.")) axis,floor(x_axis/".MAP_LOSS_PIXELS.") x_axis, floor(y_axis/".MAP_LOSS_PIXELS.") y_axis 
                        		FROM (select U50.* from (select account_name from ".T_LOG_REGISTER." where mtime>={$dateStartStamp} and mtime<={$dateEndStamp}) U10, 
                    (select U40.* from (select account_name,mtime from (select * from (select account_name, max(mtime) mtime from ".T_LOG_LOGOUT." 
                group by account_name) U20)U80 where UNIX_TIMESTAMP()-mtime>259200) U30,".T_LOG_LOGOUT." U40 where {$where} and U30.account_name=U40.account_name and U30.mtime=U40.mtime) U50 where U10.account_name=U50.account_name) U60) U70 group by level,axis order by level,num desc";
//                    $sql = "select level,axis,count(axis) num,x_axis x,y_axis y from (SELECT level,concat(floor(x_axis/".MAP_LOSS_PIXELS."), ',',floor(y_axis/".MAP_LOSS_PIXELS.")) axis,floor(x_axis/".MAP_LOSS_PIXELS.") x_axis, floor(y_axis/".MAP_LOSS_PIXELS.") y_axis 
//                		FROM ".T_LOG_LOGOUT." where {$where}) U10 group by level,axis order by level,num desc";
                    $resultData = GFetchRowSet($sql);
                    foreach($resultData as $value){
                        $levelTmp = $value['level'];
                        $data[$map_id][$levelTmp]['data'][] = array(
                            'x' => $value['x'],
                            'y' => $value['y'],
                            'num' => $value['num'],
                        );
                        $data[$map_id][$levelTmp]['map_id'] = $map_id;
                        $data[$map_id][$levelTmp]['level'] = $levelTmp.$lang->career->level;
                        $data[$map_id][$levelTmp]['max'] = ($value['num'] > $data[$map_id][$levelTmp]['max']) ? $value['num'] : $data[$map_id][$levelTmp]['max'];
                    }
                    $sql = "select count(axis) num,x_axis x,y_axis y from (SELECT level,concat(floor(x_axis/".MAP_LOSS_PIXELS."), ',',floor(y_axis/".MAP_LOSS_PIXELS.")) axis,floor(x_axis/".MAP_LOSS_PIXELS.") x_axis, floor(y_axis/".MAP_LOSS_PIXELS.") y_axis 
                        		FROM (select U50.* from (select account_name from ".T_LOG_REGISTER." where mtime>={$dateStartStamp} and mtime<={$dateEndStamp}) U10, 
                    (select U40.* from (select account_name,mtime from (select * from (select account_name, max(mtime) mtime from ".T_LOG_LOGOUT." 
                group by account_name) U20)U80 where UNIX_TIMESTAMP()-mtime>259200) U30,".T_LOG_LOGOUT." U40 where {$where} and U30.account_name=U40.account_name and U30.mtime=U40.mtime) U50 where U10.account_name=U50.account_name) U60) U70 group by axis order by num desc";
//                    $sql = "select count(axis) num,x_axis x,y_axis y from (SELECT concat(floor(x_axis/".MAP_LOSS_PIXELS."), ',',floor(y_axis/".MAP_LOSS_PIXELS.")) axis,floor(x_axis/".MAP_LOSS_PIXELS.") x_axis, floor(y_axis/".MAP_LOSS_PIXELS.") y_axis 
//                		FROM ".T_LOG_LOGOUT." where {$where}) U10 group by axis order by num desc";
                    $total['data'] = GFetchRowSet($sql);
                    $total['max'] = isset($total['data'][0]['num']) ? $total['data'][0]['num'] : 0;
                    $total['map_id'] = $map_id;
                    $total['level'] = $level['min']."~".$level['max'].$lang->career->level;
                    $data[$map_id][] = $total;
//                        $result['data'] = GFetchRowSet($sql);
//                        if(isset($result['data'][0]['num']) && 0 < $result['data'][0]['num']){
//                            $result['map_id'] = $map_id;
//                            $result['level'] = $i;
//                            $result['max'] = isset($result['data'][0]['num']) ? $result['data'][0]['num'] : 0;
//                            $data[] = $result;
//                        }
//                }
            }else{
                if($level['min']){
                    $where .= " and level>={$level['min']}";
                }
                if($level['max']){
                    $where .= " and level<={$level['max']}";
                }
                $sql = "select count(axis) num,x_axis x,y_axis y from (SELECT level,concat(floor(x_axis/".MAP_LOSS_PIXELS."), ',',floor(y_axis/".MAP_LOSS_PIXELS.")) axis,floor(x_axis/".MAP_LOSS_PIXELS.") x_axis, floor(y_axis/".MAP_LOSS_PIXELS.") y_axis 
                    		FROM (select U50.* from (select account_name from ".T_LOG_REGISTER." where mtime>={$dateStartStamp} and mtime<={$dateEndStamp}) U10, 
                (select U40.* from (select account_name,mtime from (select * from (select account_name, max(mtime) mtime from ".T_LOG_LOGOUT." 
                group by account_name) U20)U80 where UNIX_TIMESTAMP()-mtime>259200) U30,".T_LOG_LOGOUT." U40 where {$where} and U30.account_name=U40.account_name and U30.mtime=U40.mtime) U50 where U10.account_name=U50.account_name) U60) U70 group by axis order by num desc";
//                $sql = "select count(axis) num,x_axis x,y_axis y from (SELECT concat(floor(x_axis/".MAP_LOSS_PIXELS."), ',',floor(y_axis/".MAP_LOSS_PIXELS.")) axis,floor(x_axis/".MAP_LOSS_PIXELS.") x_axis, floor(y_axis/".MAP_LOSS_PIXELS.") y_axis 
//            		FROM ".T_LOG_LOGOUT." where {$where}) U10 group by axis order by num desc";
                $result['data'] = GFetchRowSet($sql);
                $result['map_id'] = $map_id;
                $result['max'] = isset($result['data'][0]['num']) ? $result['data'][0]['num'] : 0;
                $data[][] = $result;
            }
        }
    }
    return $data;
}