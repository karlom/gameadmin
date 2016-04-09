<?php
/**
 * 首次元宝消费统计
 */
 
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/arrItemsAll.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';
include_once SYSDIR_ADMIN_DICT . '/goldConfig.php';
global $dictWealthType, $goldType, $arrItemsAll;
$errorMsg = $successMsg = array();

//元宝操作类型
$op_type = $goldType;


$startDay = ONLINEDATE ;
$endDay = date('Y-m-d');


$startTimestamp = Datatime::getDayBeginTimestamp($startDay);//
$endTimestamp = time();


$viewData = getFirstUseStatistics(array('gold'), $startTimestamp, $endTimestamp, $roleName, $accountName);

//dump($viewData);
$smarty->assign( 'lang', $lang );
$smarty->assign( 'highlightPercentage', HIGHTLIGHT_PERCENTAGE);
$smarty->assign( 'viewData', $viewData);
$smarty->assign( 'errorMsg', implode('<br/>', $errorMsg ) );
$smarty->assign( 'successMsg', implode('<br/>', $successMsg ) );
$smarty->assign( 'selectedDay', $selectedDay);
//$smarty->assign( 'minDate', ONLINEDATE);
//$smarty->assign( 'maxDate', Datatime :: getTodayString());
$smarty->assign( 'startDay', $startDay );
$smarty->assign( 'endDay', $endDay );
$smarty->assign( 'startTime', $startTimestamp );
$smarty->assign( 'endTime', $endTimestamp );
$smarty->assign( 'arrItemsAll' , $arrItemsAll);
$smarty->assign( 'op_type' , $op_type);
$smarty->display( 'module/gold/first_use_statistics.tpl' );


function getFirstUseStatistics($typeList = array('gold'), $startTimestamp, $endTimestamp, $roleName = '', $accountName = '')
{
	if(!is_array($typeList))
	{// 不符合条件的类型
		return false;
	}
	$andCond = array();
	$andCond[] = " t1.mtime > $startTimestamp ";
	$andCond[] = " t1.mtime < $endTimestamp ";
	if( Validator::stringNotEmpty($roleName) ) $andCond[] = " t1.role_name = '$roleName' ";
	if( Validator::stringNotEmpty($accountName) ) $andCond[] = " t1.account_name = '$accountName' ";
	$whereAndCond = implode('AND', $andCond);
	
	$resultByType = array();
	$resultByItem = array();
	$resultByLevel = array();
	
	foreach($typeList as $type)
	{
		$sqlByType = "  SELECT SUM(tout.$type) all_gold, SUM(tout.num) item_count, COUNT(*) op_count, tout.type
						FROM (
							SELECT *
							FROM (
								SELECT  
									t1.id, t1.uuid, t1.account_name, t1.mtime, t1.$type, t1.item_id, t1.num, t1.type
								FROM " . T_LOG_GOLD . " t1 
								RIGHT JOIN (
									SELECT 
										uuid, account_name, $type, min(mtime) min_time 
									FROM " . T_LOG_GOLD . "
									WHERE $type < 0 
									GROUP BY uuid
								) t2
								ON t1.uuid = t2.uuid AND t1.mtime = t2.min_time 
								WHERE $whereAndCond AND t1.gold < 0 
								ORDER BY t1.id ASC
							) tgroup
							GROUP BY tgroup.uuid
						)tout GROUP BY tout.type";
//		dump($sqlByType);
//		echo "$sqlByType";
		$resultByType[$type] = GFetchRowSet($sqlByType);
		if(!empty($resultByType[$type])){
			foreach ($resultByType[$type] as $k => $v ) {
				$resultByType[$type][$k]['all_gold'] = -$v['all_gold'];	//转正数
			}
		}
		
		$sqlByItem = "  SELECT tout.item_id, SUM(tout.$type) all_gold, SUM(tout.num) item_count, COUNT(*) op_count
						FROM (
							SELECT *
							FROM (
								SELECT  
									t1.id, t1.uuid, t1.account_name, t1.mtime, t1.$type, t1.item_id, t1.num, t1.type
								FROM " . T_LOG_GOLD . " t1 
								RIGHT JOIN (
									SELECT 
										uuid, account_name, $type, min(mtime) min_time 
									FROM " . T_LOG_GOLD . "
									WHERE $type < 0  
									GROUP BY uuid
								) t2
								ON t1.uuid = t2.uuid AND t1.mtime = t2.min_time 
								WHERE $whereAndCond AND t1.item_id > 0
								ORDER BY t1.id ASC
							) tgroup
							GROUP BY tgroup.uuid
						)tout GROUP BY tout.item_id";

		$resultByItem[$type] = GFetchRowSet($sqlByItem);
		if(!empty($resultByItem[$type])){
			foreach ($resultByItem[$type] as $k => $v ) {
				$resultByItem[$type][$k]['all_gold'] = -$v['all_gold'];	//转正数
			}
		}
		
		$sqlByLevel = " SELECT count(*) men_count, tout.level, sum(tout.$type) as all_gold
						FROM (
							SELECT *
							FROM (
								SELECT  
									t1.id, t1.uuid, t1.account_name, t1.mtime, t1.$type, t1.item_id, t1.num, t1.type, t1.level
								FROM " . T_LOG_GOLD . " t1 
								RIGHT JOIN (
									SELECT 
										uuid, account_name, $type, min(mtime) min_time 
									FROM " . T_LOG_GOLD . "
									WHERE $type < 0 
									GROUP BY uuid
								) t2
								ON t1.uuid = t2.uuid AND t1.mtime = t2.min_time 
								WHERE $whereAndCond 
								ORDER BY t1.id ASC
							) tgroup
							GROUP BY tgroup.uuid
						)tout GROUP BY tout.level";
		
		$resultByLevel[$type]['data'] = GFetchRowSet($sqlByLevel);
		$resultByLevel[$type]['total_men_count'] = 0;
		$resultByLevel[$type]['total_gold_count'] = 0;
		$maxMenCount = 0;
		foreach($resultByLevel[$type]['data'] as $k => $record)
		{
			$resultByLevel[$type]['data'][$k]['all_gold'] = -$record['all_gold'];	//转正数
			
			$resultByLevel[$type]['total_men_count'] += $record['men_count'];
			$maxMenCount = $maxMenCount < $record['men_count'] ? $record['men_count'] : $maxMenCount;
			
			$resultByLevel[$type]['total_gold_count'] += -$record['all_gold'];
		}
		$resultByLevel[$type]['max_men_count'] = $maxMenCount;
	}
	return array('data' => array('byType' => $resultByType, 'byItem' => $resultByItem, 'byLevel' => $resultByLevel));
}
