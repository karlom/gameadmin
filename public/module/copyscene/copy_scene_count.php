<?php
/*
 * 副本数据统计
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT.'/dict.php';
global $lang;

$fb_type=SS($_POST['fb_sel']);
$start = SS($_POST['start']);
$end = SS($_POST['end']);

$fb_list  = array();
$levelArr = array(); 
foreach ($dictMapType as $key => &$value) {
		if($value['isCopyScene'] == true){
				if($value['id'] == 200){
						$value['name'] = $lang->copyscene->ChooseCopy ;	
				}
				if($value['id'] >= 200){
						$fb_list[$value['id']] = $value['name'];
						if($value['id'] == $fb_type){
							$level = $value['level'];
						}
				}
		}
}



if(empty($start)) $start = date('Y-m-d');
if(empty($end)) $end = date('Y-m-d');

$startstamp = strtotime($start);
$endstamp = strtotime($end) + 24*60*60-1;

$where="WHERE TRUE ";

$where.= " AND `mtime` > $startstamp AND `mtime` < $endstamp ";

if(!empty($fb_type))
{
//		if($fb_type == 200) {
//			$mapId =" ";
//		} else {
			$mapId =" AND `map_id`=$fb_type ";
//		}

		//进入次数的人数分布
		$PeopleTimesSql = " SELECT `enter_times`, count(`account_name`) as `num` FROM ".T_LOG_COPY_SCENE." $where $mapId and `status`=0 GROUP BY `enter_times` ";
		$PeopleTimes = GFetchRowSet($PeopleTimesSql);

		for($i=0;$i<count($PeopleTimes);$i++)
		{
			$thisdata = $PeopleTimes[$i];
			$nextdata = $PeopleTimes[$i+1];
			if($nextdata)
			{
				$thisdata['num'] -= $nextdata['num'];
			}
			$PeopleTimes[$i]=$thisdata;
		}

		//队伍人数的次数分布
		//$TeamTimesSql = "SELECT a.out_number,count(a.out_number) as num FROM (SELECT out_number,team_id FROM ".T_LOG_COPY_SCENE." $where $mapId AND team_id>0 GROUP BY team_id) as a GROUP BY a.out_number ";
		//$TeamTimes = GFetchRowSet($TeamTimesSql);

		//$SingleTimesSql = "SELECT count(`account_name`) as num FROM ".T_LOG_COPY_SCENE." $where $mapId AND `is_team`=0";
		//$SingleTimesList = GFetchRowSet($SingleTimesSql);
		//$SingleTimes = array();
		//$SingleTimes['out_number']="1(非组队)";
		//$SingleTimes['num']=$SingleTimesList[0]['num'];

		////玩家(当时)等级的人次分布
		$GamerLevelSql = "SELECT `level`,count(`account_name`) as `num` FROM ".T_LOG_COPY_SCENE." $where $mapId and `status`=0 GROUP BY `level` ";
		$GamerLevel = GFetchRowSet($GamerLevelSql);

		//按持续时间的人次分布
		$ContinueTimeSql="SELECT count(`account_name`) as `num`, `time_used` DIV 60 as `contime` FROM ".T_LOG_COPY_SCENE." $where $mapId AND `time_used`>0 GROUP BY contime ";
		$ContinueTime = GFetchRowSet($ContinueTimeSql);
		foreach($ContinueTime as $ct)
		{
			$ct['contime']+=1;
		}
		//进入时间的分布
		$StartTimeSql = "SELECT count(`account_name`) as `num`, (`mtime` DIV 3600) as `start_hour` FROM ".T_LOG_COPY_SCENE." $where $mapId AND `status`=0 GROUP BY start_hour ";
		$StartTime = GFetchRowSet($StartTimeSql);

		foreach($StartTime as $k=>$st)
		{
			$st['start_hour'] *=3600;
			$StartTime[$k]['start_from']=date("Y-m-d H", $st['start_hour']);
		}

		//参与人数统计 
		//T_LOG_ACTIVE_LOYALTY_USER
		//echo $where;
		$joinSql = " SELECT COUNT(distinct `account_name`) `total`,`mtime`, `day`,`level` FROM ".T_LOG_COPY_SCENE." $where $mapId and `status`= 0 GROUP BY `day` "; 
//		$joinResult = GFetchRowSet($joinSql);
		$activeLevelSql = " SELECT * FROM ".T_LOG_ACTIVE_LOYALTY_USER." $where $mapId GROUP BY `day` ";
//		$activeLevelResult = GFetchRowSet($activeLevelSql);
		$joinActiveSql =  " SELECT A.`total`,A.`mtime`,B.`map_id`,B.`active_level`,B.`day` FROM ($joinSql) A, ($activeLevelSql) B WHERE A.`day` = B.`day` ";
		$joinActiveResult = GFetchRowSet($joinActiveSql); 
//print_r($joinActiveResult);
		$joinList = array();
		foreach ($joinActiveResult as $k => $v) {
				if($v['map_id'] == $fb_type) { 
						$joinList[$v['day']] = array( 
							'date'            => date('Y-m-d',$v['mtime']), 
							'total'           => $v['total'], 
							'active_level'    => $v['active_level'], 
							'rate'            => round( $v['total']/$v['active_level']*100, 2 ), 
						);
				}
		}
//print_r($joinList);

		//盗墓迷城
		if($fb_type==210){
			//类型 
			$tombSql = "SELECT `type`,`times`,COUNT(distinct `role_name`) `total` FROM `".T_LOG_TOMB."` {$where} and `status`=0 Group By `type`,`times`";
			$tombRs  = GFetchRowSet($tombSql);
			//层数
			$floorSql = "SELECT `cur_floor`,COUNT(distinct `role_name`) `total` FROM `".T_LOG_TOMB."` {$where} and `status`=0 Group By `cur_floor` ORDER By `cur_floor`";
			$floorRs  = GFetchRowSet($floorSql);
	
			$tombRsArr1 = array();
			$tombRsArr2 = array();
			foreach($tombRs as $key=>$value){
					if($value['type']==0){
						$tombRsArr1[$key]['type'] = $value['type'];
						$tombRsArr1[$key]['times'] = $value['times'];
						$tombRsArr1[$key]['ordinary'] = $value['total'];
					}
					if($value['type']==1){
						$tombRsArr2[$key]['type'] = $value['type'];
						$tombRsArr2[$key]['times'] = $value['times'];
						$tombRsArr2[$key]['elite'] = $value['total'];
					}
			}
	
			foreach($tombRsArr1 as $Kt=>&$vt){
				foreach($tombRsArr2 as $kt2=>$vt2){
						if($vt['times']==$vt2['times']){
							$vt['elite'] = $vt2['elite'];
						} else {
							$vt['elite'] = 0;
						}
				}
			}
		}

		//闯天门
		if($fb_type==206){
			$gmSql = " SELECT `floor`,COUNT(`role_name`) `total` FROM (select max(`cur_floor`) `floor`,`role_name` from `".T_LOG_MG."` {$where} and `status`=1 group by `role_name`) A  GROUP By `floor` ORDER By `floor` ";
			$mgRs  = GFetchRowSet($gmSql);
		}
}

//-------------------------------------------------------

$dateStrPrev = strftime("%Y-%m-%d", strtotime($start) - 86400);
$dateStrToday = strftime("%Y-%m-%d");
$dateStrNext = strftime("%Y-%m-%d", strtotime($start) + 86400);
$dateOnline = ONLINEDATE;
	
$smarty->assign('lang',$lang);
$smarty->assign('start',$start);
$smarty->assign('end',$end);
$smarty->assign("minDate", ONLINEDATE);
$smarty->assign("maxDate", Datatime :: getTodayString());
$smarty->assign("dateStrPrev", $dateStrPrev);
$smarty->assign("dateStrToday", $dateStrToday);
$smarty->assign("dateStrNext", $dateStrNext);
$smarty->assign("dateOnline", $dateOnline);
$smarty->assign("startDate", $startDate);
$smarty->assign("endDate", $endDate);

$smarty->assign('tombRsArr1',$tombRsArr1);
$smarty->assign('floorRs',$floorRs);
$smarty->assign('mgRs',$mgRs);

$smarty->assign('fb_list',$fb_list);
$smarty->assign('joinList',$joinList);
$smarty->assign('fb_type',$fb_type);
$smarty->assign('level',str_replace("###","$level",$lang->copyscene->activePlayerMen));
$smarty->assign('SingleTimes',$SingleTimes);
$smarty->assign('PeopleTimes',$PeopleTimes);
$smarty->assign('TeamTimes',$TeamTimes);
$smarty->assign('GamerLevel',$GamerLevel);
$smarty->assign('ContinueTime',$ContinueTime);
$smarty->assign('StartTime',$StartTime);
$smarty->assign('minDate', ONLINEDATE);
$smarty->assign('maxDate', Datatime :: getTodayString());

$smarty->display('module/copyscene/copy_scene_count.tpl');
exit;


