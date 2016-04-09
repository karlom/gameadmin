<?php
/**
 * vip信息查询统计
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT.'/dict.php';
global $lang;

$startDay = strtotime($_POST['startDay']);
$endDay = strtotime($_POST['endDay']);
$startDay = $startDay ? $startDay : strtotime(date('Y-m-d',strtotime('-1day')));
$endDay = $endDay ? $endDay : strtotime(date('Y-m-d'));

$dateStart = date('Y-m-d',$startDay);
$dateEnd =  date('Y-m-d',$endDay);
$startStamp = strtotime($dateStart);
$endStamp = strtotime($dateEnd.' 23:59:59');
$nowTime = time();

$action  = SS($_POST['action']);
$role    = $_POST['role'];
$role['roleName'] = $roleName    = $role['roleName'] ? autoAddPrefix( SS($role['roleName']) ): '';
$role['accountName'] = $accountName = $role['accountName'] ? autoAddPrefix( SS($role['accountName'])) : '';

if($action == 'start'){
		if(isPost()) {
				$accountName2 = SS($_POST['id']);
				if(isset($accountName2)) {
						$sql = " select *,(`etime`-`stime`) `ttime` from ".T_LOG_VIP." where `account_name`='$accountName2' ";
						$rs  = GFetchRowSet($sql);
						if(empty($rs)){
								$stat = 0;
								$msg  = $lang->vip->userNotExists;
								$result = json_encode(array('stat'=>$stat,'msg'=>$msg,));
								echo $result;
								exit();
						} else {
								if(count($rs) == 1){
										$stat = 0;
										$msg = $lang->vip->firstVipNoData;
								} else {
										foreach($rs as $r=>&$s){
												$s['item_name'] = $dictVipPayType[$s['vip_itemid']]['name'];	
												$s['pay'] = $dictVipPayType[$s['vip_itemid']]['pay'];	
												$s['stime'] = date('Y-m-d H:i:s',$s['stime']);	
												$s['etime'] = date('Y-m-d H:i:s',$s['etime']);	
												$s['ttime'] = round($s['ttime']/3600,2);	
												if($s['vip_itemid'] == 10604200){
													$s['add_time'] = $dictVipPayType[$s['vip_itemid']]['pay']." | ".$s['stime'].":". $lang->vip->isFirst ;	
												} else {
													$s['add_time'] = $dictVipPayType[$s['vip_itemid']]['pay']." | ".$s['stime'].":". $lang->vip->isSecond ;	
												}
										}
										$stat = $rs;
										$msg = 0;	
								}
								$result = json_encode(array('stat'=>$stat,'msg'=>$msg,));
								echo $result;
								exit();
						}	
				}
		}
}

$where = " `mtime`>=$startStamp and `mtime`<=$endStamp ";
$where .=  $accountName ? " and `account_name` = '{$accountName}' ":'';
$where .=  $roleName ? " and `role_name` = '{$roleName}' ":'';

$viewData  = groupByRole($where,&$viewData2,&$effectiveCount,&$exTotal);

$idCount = count($viewData);
$lastEf  = array();
foreach ($viewData as $k => &$v){
		$i += 1;
		if($i<=$idCount){	
			$v['id'] = $i;
		}
		$v['item_name'] = $dictVipPayType[$v['vip_itemid']]['name'];	
		$v['pay'] = $dictVipPayType[$v['vip_itemid']]['pay'];	
		if($v['vip_itemid'] == 10604200){
			$v['add_time'] = $dictVipPayType[$v['vip_itemid']]['pay']." | ".date("Y-m-d H:i:s",$v['stime']).":". $lang->vip->isFirst ;	
		} else {
			$v['add_time'] = $dictVipPayType[$v['vip_itemid']]['pay']." | ".date("Y-m-d H:i:s",$v['stime']).":". $lang->vip->isSecond ;	
		}
}

foreach ($viewData2 as $k2 => $v2){
		//体验卡人数
		if($v2['vip_itemid'] == 10604200){
			$lastEf['ex']['num'] += 1;
			if($v2['open_type'] == 1){
				$lastEf['ex']['itemNum'] += 1;
			}  
			if($v2['open_type'] == 2){
				$lastEf['ex']['moneyNum'] += 1;
			}
		}
		//三天卡人数
		if($v2['vip_itemid'] == 10601200){
			$lastEf['three']['num'] += 1;
			if($v2['open_type'] == 1){
				$lastEf['three']['itemNum'] += 1;
			} 
			if($v2['open_type'] == 2){
				$lastEf['three']['moneyNum'] += 1;
			}
		}
		//月卡人数
		if($v2['vip_itemid'] == 10602300){
			$lastEf['month']['num'] += 1;
			if($v2['open_type'] == 1){
				$lastEf['month']['itemNum'] += 1;
			} 
			if($v2['open_type'] == 2){
				$lastEf['month']['moneyNum'] += 1;
			}
		}
		//半年卡人数
		if($v2['vip_itemid'] == 10603400){
			$lastEf['year']['num'] += 1;
			if($v2['open_type'] == 1){
				$lastEf['year']['itemNum'] += 1;
			}
			if($v2['open_type'] == 2){
				$lastEf['year']['moneyNum'] += 1;
			}
		}
}

$smarty->assign("URL_SELF", $_SERVER['PHP_SELF']);
$smarty->assign('startDay',$dateStart);
$smarty->assign('endDay',$dateEnd);
$smarty->assign('dateToday', date('Y-m-d'));
$smarty->assign('datePrev', date('Y-m-d',strtotime('-1day',$startDay)));
$smarty->assign('dateNext', date('Y-m-d',strtotime('+1day',$startDay)));
$smarty->assign('minDate', ONLINEDATE);
$smarty->assign('maxDate', Datatime :: getTodayString() );
$smarty->assign('recordCount', $recordCount);
$smarty->assign('effectiveCount', $effectiveCount);
$smarty->assign('lang',$lang);
$smarty->assign('role',$role);
$smarty->assign('nowTime',$nowTime);

$smarty->assign('lastEf',$lastEf);

$smarty->assign('viewData',$viewData);
$smarty->assign('exTotal',$exTotal);
$smarty->display('module/player/vip_info_stat.tpl');

//-------------------local function ------------------------

function groupByRole($where,&$dataList2,&$effectiveCount='',&$exTotalCount='')
{
	$sqlVip = " SELECT `account_name`, `role_name`, `mtime`, `vip_itemid`, `cost`, `vip_level`, `etime`, `stime`, `open_type`, (`etime`-`stime`) `ttime` from ".T_LOG_VIP." WHERE {$where} ";
//echo $sqlVip;
	$dataList = GFetchRowSet($sqlVip,'account_name');
	$dataList2 = GFetchRowSet($sqlVip);
	//vip总人数
	$effectiveSql = " SELECT COUNT(T.`account_name`) `e` FROM (select `account_name`, max(`etime`) `etime` from ".T_LOG_VIP." where `vip_itemid`< 10604200 group by `account_name`) T WHERE T.`etime`> UNIX_TIMESTAMP() ";
	$effectiveRs = GFetchRowOne($effectiveSql);
	$effectiveCount = $effectiveRs['e'];
	//vip过期人数
	$sqlExTotal = " SELECT COUNT(C.`account_name`) `c` FROM (select `account_name`, max(`etime`) `etime` from ".T_LOG_VIP." where `vip_itemid`< 10604200 group by `account_name`) C WHERE C.`etime`< UNIX_TIMESTAMP() ";
	$exTotal = GFetchRowOne($sqlExTotal);
	$exTotalCount = $exTotal['c'];
	return $dataList ;
}


