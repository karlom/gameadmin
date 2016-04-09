<?php
/**
 * 等级流失
 * 
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
global $lang;

$nowTime = time();

$minLevel = isset($_POST['minlevel']) ? intval($_POST['minlevel']) : 1;
$maxLevel = isset($_POST['maxlevel']) ? intval($_POST['maxlevel']) : GAME_MAXLEVEL;

//获取时间段
if (!isset ($_POST['starttime'])) {
	$startDate = Datatime :: getPreDay(date("Y-m-d"), 11);
} else {
	$startDate = SS($_POST['starttime']);
}
if (!isset ($_POST['endtime'])) {
	$endDate = Datatime :: getPreDay(date("Y-m-d"), 0);
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
$viewData = getData($dateStartStamp, $dateEndStamp, $minLevel, $maxLevel);

$totalNum = $viewData['totalNum'];
$totalLossNum = $viewData['totalLossNum'];
$level = array();
if(!empty($viewData['data'])) {
	foreach($viewData['data'] as $key => &$value){
	    if(-1 != $key && 0 != $key){
	    	$value['levelRate'] = $totalNum ? number_format($value['levelNum'] / $totalNum * 100, 2)."%" : "N/A";
	    	$value['levelLossRate'] = $totalLossNum ? number_format($value['levelLossNum'] / $totalLossNum * 100, 2)."%" : "N/A";
	    }else{
	        $viewData['totalNum'] += $value['levelNum'];
	        $value['levelRate'] = "N/A";
	        $value['levelLossRate'] = "N/A";
	    }
		$level[] = $key;
	}	
}

asort($level);

$minDate = ONLINEDATE;
//$maxDate = Datatime :: getPreDay(date("Y-m-d"), 4);
$maxDate = date('Y-m-d');

$smarty->assign("minDate", $minDate);
$smarty->assign("maxDate", $maxDate);
$smarty->assign("startDate", $startDate);
$smarty->assign("endDate", $endDate);

$smarty->assign("lang", $lang);
$smarty->assign("viewData", $viewData);
$smarty->assign("level", $level);
$smarty->assign("minLevel", $minLevel);
$smarty->assign("maxLevel", $maxLevel);
$smarty->display("module/basedata/level_lose_rate.tpl");

function getData($dateStartStamp, $dateEndStamp, $minLevel, $maxLevel) {
	
	/*
    //-1级 ，0级
    $sql = "select count(distinct account_name) num from ".T_LOG_CREATE_LOSS." where mtime>={$dateStartStamp} and mtime<={$dateEndStamp} and step=0 union all 
    select count(distinct account_name) num from ".T_LOG_CREATE_LOSS." where mtime>={$dateStartStamp} and mtime<={$dateEndStamp} and step=1 union all 
    select count(distinct account_name) num from ".T_LOG_CREATE_LOSS." where mtime>={$dateStartStamp} and mtime<={$dateEndStamp} and step=2";
	$num = GFetchRowSet($sql);
	*/
	
    //查总人数（时间段内有注册有升级记录的人）
    $sql = "select level, count(distinct uuid) levelNum from (select U20.uuid, max(U20.level) level from ".T_LOG_LEVEL_UP.
    	" U20,(select * from ".T_LOG_REGISTER." where mtime>={$dateStartStamp} and mtime<={$dateEndStamp}) U30 where U20.mtime>={$dateStartStamp} and U20.mtime<={$dateEndStamp}  
    	and U20.uuid=U30.uuid group by  U20.uuid having level >={$minLevel} and level<={$maxLevel}) U10 group by level";
	$totalNumResult = GFetchRowSet($sql, "level");
	
	//等级是1的总人数（时间段内有注册但无升级记录的人）
	$sqlFirstLevel = "SELECT R.level as `level`, COUNT(distinct R.uuid) as `levelNum` FROM t_log_register R LEFT JOIN t_log_level_up L ON R.uuid=L.uuid WHERE L.uuid IS NULL AND R.mtime>={$dateStartStamp} AND R.mtime<={$dateEndStamp} GROUP BY R.level;";
	$firstLevel = GFetchRowOne($sqlFirstLevel);
	
	$totalNumResult[1] = $firstLevel;
	
	//$dateStartStamp至$dateEndStamp注册的人的等级分布
//	$sql = "select level, count(account_name) totalNum from (select max(U20.level) level,U20.account_name from ".T_LOG_LOGOUT.
//	" U20 left join ".T_LOG_REGISTER." U30 on U20.account_name=U30.account_name " .
//	"where U30.mtime>={$dateStartStamp} and U30.mtime<={$dateEndStamp} group by U20.account_name)" .
//	" U10 where level>={$minLevel} and level<={$maxLevel} group by level";
//	$totalNum = GFetchRowSet($sql, "level");
	
	//$dateStartStamp至$dateEndStamp注册,最后登录时间距离现在超过三天
	$sql = "select level, count(distinct uuid) levelLossNum from (select max(U20.level) level,U20.uuid, max(U20.mtime) mtime from ".T_LOG_LOGOUT.
	" U20 left join ".T_LOG_REGISTER." U30 on U20.uuid=U30.uuid " .
	"where U30.mtime>={$dateStartStamp} and U30.mtime<={$dateEndStamp} group by U20.uuid) " .
	"U10 where level>={$minLevel} and level<={$maxLevel} and UNIX_TIMESTAMP()-mtime>259200 group by level";
	$lossNumResult = GFetchRowSet($sql, "level");
	
	
//	$result['data'] = $totalNumResult;
	$result = array();
	$totalNum = 0;
    $totalLossNum = 0;
//	$totalNumResult[-1]['levelNum'] = 0;
//	$totalNumResult[0]['levelNum'] = 0;
//	$totalNumResult[1]['levelNum'] = 0;
//	$result['data'][1]['levelLossNum'] = 0;
//	$result['data'][0]['levelLossNum'] = "N/A";
//	$result['data'][-1]['levelLossNum'] = "N/A";
	if(!empty($totalNumResult)){
		foreach($totalNumResult as $key => &$value){
		    $result['data'][$key]['levelNum'] = $value['levelNum'];
		    if(-1 != $key && 0 != $key){
			    $result['data'][$key]['levelLossNum'] =  array_key_exists($key, $lossNumResult) ? $lossNumResult[$key]['levelLossNum'] : 0;
		    }
			$totalNum += $result['data'][$key]['levelNum'];
			$totalLossNum += $result['data'][$key]['levelLossNum'];
		}		
	}

//	$result['data'][1]['levelNum'] = $num[2]['num'] - $totalNum;
//	$result['data'][0]['levelNum'] = $num[1]['num'] - $num[2]['num'];
//	$result['data'][-1]['levelNum'] = $num[0]['num'] - $num[1]['num'];
//	$result['totalNum'] = $totalNum + $result['data'][1]['levelNum'];

	$result['totalNum'] = $totalNum;
	$result['totalLossNum'] = $totalLossNum;
	return $result;
}