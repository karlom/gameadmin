<?php
/**
 * 修罗塔副本统计
 */
 
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/arrItemsAll.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';
global $dictPet;
$errorMsg = $successMsg = array();


$roleName 		= (isset( $_GET['role_name'] ) && Validator::stringNotEmpty($_GET['role_name']) )? autoAddPrefix( SS($_GET['role_name']) ) : '';
$accountName 	= (isset( $_GET['account_name'] ) && Validator::stringNotEmpty($_GET['account_name']) )? autoAddPrefix( SS($_GET['account_name']) ) : '';
$startDay		= (isset( $_GET['start_day'] ) && Validator::isDate($_GET['start_day']) )? SS($_GET['start_day']) : date('Y-m-d', strtotime('-6 days'));
$endDay		= (isset( $_GET['end_day'] ) && Validator::isDate($_GET['end_day']) )? SS($_GET['end_day']) : date('Y-m-d');
$selectedDay = date('Y-m-d');
$symbolList = array(
					14141200 => $arrItemsAll['14141200']['name'],
					14142300 => $arrItemsAll['14142300']['name'],
					14143400 => $arrItemsAll['14143400']['name']
					);
$floorList = array( 1, 10, 20);
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
$viewData = getPataStatistics($startTimestamp, $endTimestamp);
$viewData['count_of_days'] = count($viewData['data']);

$smarty->assign( 'lang', $lang );
$smarty->assign( 'symbolList', $symbolList );
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
$smarty->display( 'module/copyscene/pata_statistics.tpl' );


function getPataStatistics( $startTimestamp, $endTimestamp)
{
	global $dictPet, $arrItemsAll, $symbolList, $floorList;
	$andCond = $andCond2 = array();
	$andCond[] = " mtime > $startTimestamp ";
	$andCond[] = " mtime < $endTimestamp ";
	$whereAndCond = implode('AND', $andCond);
	$resultByDay = array();
	$result = array( 'sum_men_acount' => 0, 'sum_symbol_count' => 0);
	// 初始化结果数组，保证数据的连续性
	$tmpDate = date('Y-n-j', $startTimestamp );
	$endDate = date( 'Y-n-j' , $endTimestamp );
	$openTimestamp = strtotime(ONLINEDATE);
	$maxTimes = 0;
	
	
	while( true )
	{
		$tmp_timestampe = strtotime( $tmpDate );
	//	$since_open_days = ceil(( $tmp_timestampe - $openTimestamp ) / 86400) + 1;
	//	echo $tmp_timestampe - $openTimestamp ;
		$tmpDate = date( 'Y-n-j',  $tmp_timestampe);
		$resultByDay[$tmpDate] = array(
										'men_count' => 0,
										'men_count_over_forty'		=> 0,
										'symbol_count'		=> array(),
										'men_count_by_times'	=> array(),
										'all_symbol_count'	=> 0,
										);
										
		foreach($resultByDay as &$drecord)
		{
			foreach($symbolList as $key => $symbol)
			{
				$drecord['symbol_count'][$key] = array(
													'count' => 0,
													'floors' => array()
													);
			}
		}
		if( $tmpDate ==  $endDate ) 
		{// 到截止日期
			break;
		}
		
		$tmpDate = $tmpDate . ' +1 day';
	}
//	dump($resultByDay);
	// 统计每天闯关人数
	$sqlMencountByDay = "SELECT COUNT(DISTINCT role_name) men_count, `year`,`month`, `day` FROM " . T_LOG_PATA . ' WHERE '. $whereAndCond . ' GROUP BY  `year`, `month`, `day`';
	$resultMencountByDayTmp = GFetchRowSet($sqlMencountByDay);
	foreach($resultMencountByDayTmp as $mencount)
	{
		$date = $mencount['year'] . '-' . $mencount['month'] . '-' . $mencount['day'];
		$resultByDay[ $date ]['men_count'] = $mencount['men_count'];
		$result['sum_men_acount'] += $mencount['men_count'];
	}
	
	// 统计等级大于40人数
	foreach($resultByDay as $date => &$record)
	{
		$record['men_count_over_forty'] = getMenCountOverLevelByDay($date, 40);
	}
	
	// 统计符令的消耗量
	$sqlSymbolCountByDay = "SELECT COUNT(*) symbol_count, `symbol_id`, `floor`, `year`,`month`, `day` FROM " . T_LOG_PATA . ' WHERE '. $whereAndCond . ' AND symbol_id > 0 GROUP BY  `symbol_id`,`floor`, `year`, `month`, `day`';
	$resultSymbolountByDayTmp = GFetchRowSet($sqlSymbolCountByDay);
	foreach($resultSymbolountByDayTmp as &$symbolCount)
	{
		$date = $symbolCount['year'] . '-' . $symbolCount['month'] . '-' . $symbolCount['day'];
		
		$resultByDay[ $date ]['symbol_count'][ $symbolCount['symbol_id'] ]['floors'][ $symbolCount['floor'] ] = $symbolCount['symbol_count'];
		$resultByDay[ $date ]['all_symbol_count'] += $symbolCount['symbol_count'];
		$resultByDay[ $date ]['symbol_count'][ $symbolCount['symbol_id'] ]['count'] += $symbolCount['symbol_count'];
		$result['sum_symbol_count'] += $symbolCount['symbol_count'];
	}
	
	
	// 统计每天爬塔人数 
	$sqlMenCountByTimesDay = "SELECT COUNT(*) men_count, t.times, t.year, t.day, t.month FROM(
								SELECT role_name, COUNT(*) times, year, day, month FROM " . T_LOG_PATA . " WHERE $whereAndCond AND symbol_id > 0 GROUP BY role_name, year, day, month
								)t
								GROUP BY t.times, t.year, t.day, t.month";
	$resultMenCountByTimesDayTmp = GFetchRowSet($sqlMenCountByTimesDay);
	foreach($resultMenCountByTimesDayTmp as &$menCountByTimes)
	{
		$date = $menCountByTimes['year'] . '-' . $menCountByTimes['month'] . '-' . $menCountByTimes['day'];
		$resultByDay[ $date ]['men_count_by_times'][ $menCountByTimes['times'] ] = $menCountByTimes['men_count'];
		$maxTimes = $maxTimes > $menCountByTimes['times']?$maxTimes:$menCountByTimes['times'];
	}
	
	// 填充进入修罗塔次数的空值和符令类型的空值
	foreach($resultByDay as &$dayRecord)
	{
		
		foreach ($symbolList as $key => $symbol)
		{
			if($dayRecord['symbol_count'][$key]['floors'] === null )
			{
				$dayRecord['symbol_count'][$key]['floors'] = array();
			}
			foreach ($floorList as $floor)
			{
				if ($dayRecord['symbol_count'][$key]['floors'][$floor] === null)
				{
					$dayRecord['symbol_count'][$key]['floors'][$floor] = 0;
				}
			}
		}
		
		for($i = 1; $i <= $maxTimes; $i++)
		{
			if ($dayRecord['men_count_by_times'][$i] === null)
			{
				$dayRecord['men_count_by_times'][$i] = 0;
			}
		}
	}
	$result['data'] = $resultByDay;
	$result['max_times'] = $maxTimes;
	$result['men_count_by_times_list'] = array();
	for( $i = 0; $i <= $maxTimes; $i++ )
	{
		foreach($resultByDay as $r)
		{
			if ( $r['men_count_by_times'][$i] > 0 )
			{
				$result['men_count_by_times_list'][] = $i;
				break;
			}
		}
	}

	return $result;
}

function getMenCountOverLevelByDay($date, $level)
{
	$cacheKey = 'men_count_over_' . $date . $level;
	$cache = ExtMemcache::instance();

	if( strtotime($date) < strtotime(date('Y-n-j')) )
	{
		$menCount = $cache->get($cacheKey);
		if ( $menCount )
		{	
			return $menCount;
		}
	}
	$timestamp = Datatime::getDayEndTimestamp($date);
	$sql = "SELECT count(*) men_count_over_twenty FROM (SELECT role_name, max(level) cur_level FROM t_log_level_up WHERE mtime < $timestamp AND level > $level GROUP BY role_name) t";
	$result = GFetchRowOne($sql);
	$cache->set($cacheKey, $result['men_count_over_twenty'], true, MEMCACHE_COMPRESSED, 0);//永不过期，因为指定时间的等级人数是不会发生变化的，属于历史数据
//	$cache->delete($cacheKey);
	return $result['men_count_over_twenty'];
}
