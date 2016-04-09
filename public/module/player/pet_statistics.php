<?php
/**
 * 副本道具掉落统计
 */
 
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/arrItemsAll.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';
global $dictPet;
$errorMsg = $successMsg = array();


$roleName 		= (isset( $_GET['role_name'] ) && Validator::stringNotEmpty($_GET['role_name']) )? autoAddPrefix( SS($_GET['role_name']) ) : '';
$accountName 	= (isset( $_GET['account_name'] ) && Validator::stringNotEmpty($_GET['account_name']) )? autoAddPrefix( SS($_GET['account_name']) ) : '';
$startDay		= (isset( $_GET['start_day'] ) && Validator::isDate($_GET['start_day']) )? SS($_GET['start_day']) : date('Y-m-d');
$endDay		= (isset( $_GET['end_day'] ) && Validator::isDate($_GET['end_day']) )? SS($_GET['end_day']) : date('Y-m-d');
$selectedDay = date('Y-m-d');
if(isPost())
{
	if(isset($_POST['selectedDay']) && Validator::isDate($_POST['selectedDay']))
	{
		$selectedDay = SS($_POST['selectedDay']);
	}
	if(isset($_POST['dateToday']))
	{
		$selectedDay = $startDay = $endDay = date('Y-m-d');
	}
	elseif(isset($_POST['datePrev']))
	{
		$selectedDay = $startDay = $endDay = date('Y-m-d', strtotime($selectedDay) - 86400);
	}
	elseif(isset($_POST['dateNext']))
	{
		$selectedDay = $startDay = $endDay = date('Y-m-d', strtotime($selectedDay) + 86400);
	}
	else
	{
		$startDay = $onlineDate;
		$selectedDay = $endDay = date('Y-m-d');
	}
	
}

$startTimestamp = Datatime::getDayBeginTimestamp($startDay);//
$endTimestamp 	= Datatime::getDayEndTimestamp($endDay);//

$openTimestamp = strtotime( ONLINEDATE );
if($startTimestamp < $openTimestamp)
{
	$startTimestamp = $openTimestamp;
	$startDay = ONLINEDATE;
}
//$typeArray = array(0,1);
$viewData = getPetStatistics($startTimestamp, $endTimestamp);

$smarty->assign( 'lang', $lang );
$smarty->assign( 'highlightPercentage', HIGHTLIGHT_PERCENTAGE);
$smarty->assign( 'viewData', $viewData);
$smarty->assign( 'errorMsg', implode('<br/>', $errorMsg ) );
$smarty->assign( 'successMsg', implode('<br/>', $successMsg ) );
$smarty->assign( 'selectedDay', $selectedDay);
$smarty->assign( 'minDate', ONLINEDATE);
$smarty->assign( 'maxDate', Datatime :: getTodayString());
$smarty->assign( 'startDay', $startDay );
$smarty->assign( 'endDay', $endDay );
$smarty->assign( 'startTime', $startTimestamp );
$smarty->assign( 'endTime', $endTimestamp );
$smarty->assign( 'roleName', $roleName );
$smarty->assign( 'accountName', $accountName );
$smarty->assign( 'dictPet' , $dictPet);
$smarty->assign( 'op_type' , $op_type);
$smarty->display( 'module/player/pet_statistics.tpl' );


function getPetStatistics( $startTimestamp, $endTimestamp)
{
	global $dictPet;
	$andCond = $andCond2 = array();
	$andCond[] = " mtime > $startTimestamp ";
	$andCond2[] = " t1.mtime > $startTimestamp ";
	$andCond[] = " mtime < $endTimestamp ";
	$andCond2[] = " t1.mtime < $endTimestamp ";
	$whereAndCond = implode('AND', $andCond);
	$whereAndCond2 = implode('AND', $andCond2);
	$resultByLevel = array();
	$resultByPet = array();
	$result = array('all_pet_acount' => 0, 'all_men_acount' => 0);
	//初始化灵兽统计结果
	foreach ($dictPet as $pet_id =>$pet)
	{
		$resultByPet[$pet_id] = 0;
	}
	$resultByLevel[0] = 0;
	
	// 统计灵兽符使用数
	$sqlByPet = 'SELECT pet_id, count(*) pet_count FROM ' . T_LOG_PET_GET . ' WHERE '. $whereAndCond . ' GROUP BY pet_id';
	$resultByPetTmp = GFetchRowSet($sqlByPet);
	
	foreach($resultByPetTmp as $petItem)
	{
		$resultByPet[$petItem['pet_id']] = $petItem['pet_count'];
		$result['all_pet_acount'] += $petItem['pet_count'];
	}
	$result['data']['byPet'] = $resultByPet;
	
	
	// 统计首次使用灵兽符的玩家等级分布
	$sqlByLevel = "SELECT count(*) men_count, t.level
		FROM (
			SELECT  
				 t1.account_name, t1.mtime, t1.pet_id, t1.level
			FROM " . T_LOG_PET_GET . " t1 
			RIGHT JOIN (
				SELECT 
					account_name,  min(mtime) min_time 
				FROM " . T_LOG_PET_GET ."
				GROUP BY account_name
			) t2
			ON t1.account_name = t2.account_name AND t1.mtime = t2.min_time 
			WHERE $whereAndCond2
		) t GROUP BY t.level";

	$resultByLevelTmp = GFetchRowSet($sqlByLevel);
	foreach($resultByLevelTmp as $levelItem)
	{
		if($levelItem['level'] == null)
		{
			$resultByLevel[0] += $levelItem['men_count'];
		}
		else 
		{
			if($resultByLevel[$levelItem['level']] == null)
			{
				$resultByLevel[$levelItem['level']] = 0;
			}
			$resultByLevel[$levelItem['level']] += $levelItem['men_count'];
		}
		$result['all_men_acount'] += $levelItem['men_count'];
	}
	$result['data']['byLevel'] = $resultByLevel;
	
	return $result;
}
