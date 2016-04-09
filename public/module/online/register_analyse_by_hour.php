<?php
include_once "../../../protected/config/config.php";
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';
global $lang;
if ( !isset($_POST['starttime'])){
	$dateStart = date('Y-m-d',strtotime('-6day'));
}else{
	$dateStart  = trim(SS($_POST['starttime']));
}

if ( !isset($_POST['endtime'])){
	$dateEnd = strftime ("%Y-%m-%d");
}else{
	$dateEnd = trim(SS($_POST['endtime']));
	if(0 <= strtotime($dateEnd.' 23:59:59') - time()){
		$dateEnd = date("Y-m-d");
	}
}

if ( !isset($_POST['dateType'])){
	$dateType = 1;
}else{
	$dateType = SS($_POST['dateType']);
}
$dateStart = (strtotime($dateStart) >= strtotime(ONLINEDATE)) ? $dateStart : ONLINEDATE;

$dateStartStamp = strtotime($dateStart . ' 0:0:0') or $dateStartStamp = GetTime_Today0();
$dateEndStamp   = strtotime($dateEnd . ' 23:59:59') or $dateEndStamp = time();

$dateStartStr = strftime ("%Y-%m-%d", $dateStartStamp);
$dateEndStr   = strftime ("%Y-%m-%d", $dateEndStamp);

$data = getSqlData($dateStartStamp, $dateEndStamp, $dateType);

$grap_data = array();
// 获取图表数据 默认只显示7天数据
foreach ($data as $k => $v) {
   
	if (strtotime($v['year'] . '-' . $v['month'] . '-' . $v['day']) > ($dateEndStamp - 8 * 24 * 60*60)) {
		$grap_data[$v['year'] . "-" . $v['month'] . "-" . $v['day']][] = $v;
	}
}

//去除无用的总count
if($grap_data){
	foreach($grap_data as $key => $row){
	    unset($grap_data[$key][count($grap_data[$key]) - 1]);
	}
}
if(0 < count($grap_data)){
	krsort($grap_data);
}

//处理今天时间，填充0值
if(!empty($grap_data[date ("Y-n-j", time() )])){

    $tempArr = array();
    if( 1 ==  $dateType){
        $count = strftime ("%H", time() ) + 1;
        //当数量相当，则无需填充
        if(count($grap_data[date ("Y-n-j", time() )]) != $count){

            for($i=0; $i<$count; $i++){
                $flag = false;
                foreach($grap_data[date ("Y-n-j", time() )] as $row){
                        if($row['hour'] == $i && !empty($row['hour'])){
                            $flag = true;
                            $tempArr[] = $row;
                            break;
                        }
                }
                if(!$flag){
                        $tempArr[] = array(
                            'year' => $grap_data[date ("Y-n-j", time() )][0]['year'],
                            'month' => $grap_data[date ("Y-n-j", time() )][0]['month'],
                            'day' => $grap_data[date ("Y-n-j", time() )][0]['day'],
                            'hour' => $i,
                            'c' => 0
                            );
                }
            }
            $grap_data[date ("Y-n-j", time() )] = $tempArr;
        }
    }
    //按分统计
    /**
     * elseif(4 ==  $dateType){
        $min = floor((time() - strtotime(date('Y-m-d',time())))/60);
        for($i=0;$i<$min;$i++){
            $flag = false;
            foreach($grap_data[date ("Y-m-d", time() )] as $key=>$row){
                if(!empty($row['min'])){
                    $point = $row['hour']*60+$row['min'];
                }else{
                    $row['min'] = "时总计";
                }
                $key = $point;
                $row['point'] = $point;
                if($i == $key ){
                    $flag = true;
                    $tempArr[] = $row;
                    break;
                }
            }
            if(!$flag){
                $tempArr[] = array(
                    'year' => $grap_data[date ("Y-m-d", time() )][0]['year'],
                    'month' => $grap_data[date ("Y-m-d", time() )][0]['month'],
                    'day' => $grap_data[date ("Y-m-d", time() )][0]['day'],
                    'hour' => floor($i/60),
                    'min'=>($i-floor($i/60)*60),
                    'point'=>$i,
                    'c' => 0,
                );
            }
        }

        $grap_data[date ("Y-m-d", time() )] = $tempArr;
    }
    */
    $temp = $grap_data[date ("Y-n-j", time() )];

}

//处理非今天的数据，填充0值
if($grap_data){
	foreach($grap_data as $key => $row){
	    if(count($row) == 24){
	        continue;
	    }
	    if($key != strftime ("%Y-%m-%d", time() )){
	        $tempArr = array();
                if(1 == $dateType){
                    for($i=0; $i<24; $i++){
                        $flag = false;
                        foreach($grap_data[$key] as $r){
                            if($r['hour'] == $i && !empty($r['hour'])){
                                $flag = true;
                                $tempArr[] = $r;
                                break;
                            }
                        }
                        if(!$flag){
                            $tempArr[] = array(
                            'year' => $grap_data[$key][0]['year'],
                            'month' => $grap_data[$key][0]['month'],
                            'day' => $grap_data[$key][0]['day'],
                            'hour' => $i,
                            'c' => 0
                            );
                        }
                    }
                }
                //按分统计
                /**
                 * elseif(4 == $dateType){
                    for($i=0;$i<1440;$i++){
                        $flag= FALSE;
                        foreach($grap_data[$key] as $k => $r){
                            if(!empty($r['min'])){
                                $point = $r['hour']*60+$r['min'];
                            }else{
                                $r['min'] = "时总计";
                            }
                            $k = $point;
                            $r['point'] = $point;
                            if($i == $k ){
                                $flag = true;
                                $tempArr[] = $r;
                                break;
                            }
                        }
                        if(!$flag){
                            $tempArr[] = array(
                            'year' => $grap_data[$key][0]['year'],
                            'month' => $grap_data[$key][0]['month'],
                            'day' => $grap_data[$key][0]['day'],
                            'hour' => floor($i/60),
                            'min'=>($i-floor($i/60)*60),
                            'point'=>$i,
                            'c' => 0,
                            );
                        }
                    }
                }
                */

	        $grap_data[$key] = $tempArr;
	    }
	}
}
if(!empty($grap_data[date ("Y-n-j", time() )])){
    $grap_data[date ("Y-n-j", time() )] = $temp;
}
$reg_count = 0;
foreach($data as $key=>$value){
	$reg_count += $value['c'];
}
$reg_count = getAllRegCount();
$types = getDateType();

$mindate = ONLINEDATE;
$maxdate = date("Y-m-d", strtotime('-1day'));

$smarty->assign("mindate", $mindate);
$smarty->assign("maxdate", $maxdate);

$smarty->assign("startDate", $dateStartStr);
$smarty->assign("endDate", $dateEndStr);
$smarty->assign("dateType", $dateType);
$smarty->assign("types", $types);
$smarty->assign("maxdate", $maxdate);
$smarty->assign("lang",$lang);
$smarty->assign("keywordlist", $data);
$smarty->assign("reg_count", $reg_count);
$smarty->assign("grap_data", $grap_data);

$smarty->display("module/online/register_analyse_by_hour.tpl");
exit;
//////////////////////////////////////////////////////////////

function getAllRegCount()
{
	$sql = "SELECT COUNT(uuid) as c FROM `".T_LOG_REGISTER."`";
	$arr = GFetchRowOne($sql);
	return intval($arr['c']);
}


function getSqlData($startTime, $endTime, $dateType){
    //月、日、时类型选择
    if($dateType == 1){
    	$select = "`year`,  `month`,`day`,  `hour`, ";
		$groupby = "`year`,`month`,`day`,`hour`";
    }elseif($dateType == 2 ){//日
    	$select = " `year`,  `month`,`day`, ";
		$groupby = "`year`,`month`,`day`";
    }elseif($dateType == 3){//月
    	$select = " `year`, `month`, ";
		$groupby = "`year`,`month`";
    }
/**
 *     elseif($dateType == 4){//分
 
    	$select = "`year`,`month`, `day`,  `hour`, `min`, ";
		$groupby = "`year`,`month`,`day`,`hour`,`min`";
    }
 */
	$sql = "SELECT {$select}"
		 . " COUNT(`uuid`) as c FROM `".T_LOG_REGISTER."` "
		 . " WHERE `mtime`>={$startTime} AND `mtime`<={$endTime} "
		 . " GROUP BY {$groupby} WITH ROLLUP" ;
	$result = GFetchRowSet($sql);
	return $result;
}

function getDateType(){
    return array(
//    4 => '每分',
    1 => '每时',
    2 => '每日',
    3 => '每月',
    );
}