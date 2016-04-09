<?php
/**
 * 个人护送灵兽查询
 */
 
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';

global $dictColor, $dictEscortStatus, $dictFlushType;
unset($dictColor[count($dictColor) - 1]);//去掉金色
unset($dictColor[0]);//去掉灰色

$errorMsg = $successMsg = array();// 消息数组
$onlineDate = $serverList[$_SESSION ['gameAdminServer']]['onlinedate'];//开服日期

//请求参数获取
$roleName 		= (isset( $_GET['role_name'] ) && Validator::stringNotEmpty($_GET['role_name']) )? autoAddPrefix( SS($_GET['role_name']) ) : '';
$accountName 	= (isset( $_GET['account_name'] ) && Validator::stringNotEmpty($_GET['account_name']) )? autoAddPrefix( SS($_GET['account_name']) ) : '';
$startDay		= (isset( $_GET['start_day'] ) && Validator::isDate($_GET['start_day']) )? SS($_GET['start_day']) : date('Y-m-d');
$endDay		= (isset( $_GET['end_day'] ) && Validator::isDate($_GET['end_day']) )? SS($_GET['end_day']) : date('Y-m-d');
//list($page, $pageSize) = getPagesParams();// 
$selectedDay = date('Y-m-d');
if(isPost()){
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
	elseif(isset($_POST['dateAll']))
	{
		$startDay = $onlineDate;
		$selectedDay = $endDay = date('Y-m-d');
	}
	else
	{
		$startDay = date('Y-m-d');
		$selectedDay = $endDay = date('Y-m-d');
	}
}

/* 不查是否存在
//
if( Validator::stringNotEmpty($roleName) || Validator::stringNotEmpty($accountName) )
{// 
	$user = UserClass::getUser($roleName, $accountName);
	if( !$user )
	{
		$errorMsg[] = $lang->msg->userNotExists;
	}
	$roleName 		= $user['role_name'];
	$accountName 	= $user['account_name'];
}
*/

$startTimestamp = Datatime::getDayBeginTimestamp($startDay);//
$endTimestamp 	= Datatime::getDayEndTimestamp($endDay);//

if( empty($errorMsg) )// 
{
	$viewData = getEscortRecords($roleName, $accountName, $startTimestamp, $endTimestamp /*, $page, $pageSize*/ );
//	$pager = getPages2( $page, $viewData ['recordCount'], $pageSize );
	$newData = array();
	foreach($viewData['data'] as $d)
	{
		$date = date('Y-m-d', $d['mtime']);
		$key = $d['account_name'] . '_' . $date;
		if(!array_key_exists($key, $newData))
		{
			$newData[$key] = array( 'meta' => array( 
														'role_name' => $d['role_name'],
														'account_name' => $d['account_name'],
														'times' => 0,
														'date' => $date,
														),
												   'data' => array()
											);
		}
		
		$newData[$key]['meta']['times']++;
		$newData[$key]['data'][] = $d;
	}
	$viewData['data'] = $newData;
	$smarty->assign( 'viewData', $viewData );
	$smarty->assign( 'pager', $pager );
}

$smarty->assign( 'lang', $lang );
$smarty->assign( 'dictColor', $dictColor);
$smarty->assign( 'selectedDay', $selectedDay);
$smarty->assign( 'dictEscortStatus', $dictEscortStatus);
$smarty->assign( 'errorMsg', implode('<br/>', $errorMsg ) );
$smarty->assign( 'successMsg', implode('<br/>', $successMsg ) );
$smarty->assign( 'minDate', $onlineDate);
$smarty->assign( 'maxDate', Datatime :: getTodayString());
$smarty->assign( 'startDay', $startDay );
$smarty->assign( 'endDay', $endDay );
$smarty->assign( 'roleName', $roleName );
$smarty->assign( 'accountName', $accountName );
$smarty->display( 'module/player/escort.tpl' );


function getEscortRecords($roleName, $accountName, $startTimestamp, $endTimestamp)
{
	global $dictFlushType;
	$andCond = $andCond2 = array();
	$andCond[] = " t1.mtime > $startTimestamp";
	$andCond[] = " t1.mtime < $endTimestamp";
	$andCond2[] = " mtime > $startTimestamp";
	$andCond2[] = " mtime < $endTimestamp";
	if( Validator::stringNotEmpty($roleName) ) 
	{
		$andCond[] = " t1.role_name = '$roleName' ";
		$andCond2[] = " role_name = '$roleName' ";
	}
	if( Validator::stringNotEmpty($accountName) ) 
	{
		$andCond[] = " t1.account_name = '$accountName' ";
		$andCond2[] = " account_name = '$accountName' ";
	}
//	$andCond[] = " result > 1 ";
	
	$limit = '';
	/*
	if ( Validator::isInt($page) && $page > 0 &&
		 Validator::isInt($pageSize) && $pageSize > 0) 
	{
		$limit = ' LIMIT ' . (($page - 1) * $pageSize) . ', ' . $pageSize;
	}
	*/
	
	$whereCond = ' WHERE ' . implode(' AND ', $andCond);
	$whereCond2 = ' WHERE ' . implode(' AND ', $andCond2);

//	$sql = 'SELECT * FROM ' . T_LOG_ESCORT  . $whereCond . ' ORDER BY mtime DESC ' . $limit;
	$sql = 'SELECT 
				t1.insurance, t1.mtime, t1.role_name, t1.account_name, t1.time_used, t2.refresh_times, t1.escort_type, t1.escort_times, t1.escort_status, t1.result 
			FROM ' . T_LOG_ESCORT . ' t1 
			LEFT JOIN (
				SELECT SUM(refresh_times) refresh_times, role_name, escort_times, year, day, month FROM ' . T_LOG_ESCORT_REFRESH . ' ' . $whereCond2 . ' GROUP BY role_name, escort_times, year, month, day
				) t2 
			ON 
				t1.role_name = t2.role_name AND t1.escort_times = t2.escort_times AND t1.`year` = t2.`year` AND t1.`month` = t2.`month` AND t1.`day` = t2.`day` 
			' . $whereCond . ' AND t1.result > 1 AND t1.escort_status > 0 ORDER BY mtime DESC ' . $limit;

	$recordSet = GFetchRowSet($sql);
	
	/*
	// 查询刷新类型及次数
	$sqlDetail = 'SELECT 
					t1.mtime, t1.role_name, t1.account_name, t1.time_used, t2.refresh_times, t1.escort_type, t2.flush_type, t1.escort_times, t1.escort_status, t1.result 
				FROM ' . T_LOG_ESCORT . ' t1 
				LEFT JOIN (
					SELECT count(*)refresh_times, role_name, escort_times, flush_type, year, day, month FROM ' . T_LOG_ESCORT_REFRESH . ' ' . $whereCond2 . ' GROUP BY role_name, escort_times, flush_type, year, month, day
					) t2 
				ON 
					t1.role_name = t2.role_name AND t1.escort_times = t2.escort_times AND t1.`year` = t2.`year` AND t1.`month` = t2.`month` AND t1.`day` = t2.`day` 
				' . $whereCond . ' AND t1.result > 1 ORDER BY mtime DESC ' . $limit;
	$recordSetDetail = GFetchRowSet($sqlDetail);
//dump($recordSetDetail);
	foreach($recordSetDetail as $record)
	{
		if( !isset( $record['flush_type'] ) ) continue;
		foreach($recordSet as &$recordInner)
		{
			if(
				$record['mtime'] == $recordInner['mtime'] &&
				$record['role_name'] == $recordInner['role_name'] &&
				$record['escort_times'] == $recordInner['escort_times'] 
			)
			{
				$recordInner['detail'] .= $dictFlushType[$record['flush_type']] . ': <font color="red">' .  $record['refresh_times'] . '</font><br/>';
			}
		}
	}
	*/
	
	foreach ($recordSet as &$record)
	{
		$recordDetail = getEscortDetail($record['role_name'], $record['escort_times'], $record['mtime'] - $record['time_used']);
		foreach($recordDetail as $detail)
		{
			$record['detail'] .= $dictFlushType[$detail['flush_type']] . ': <font color="red">' .  $detail['refresh_times'] . '</font><br/>';
		}
	}
	$sqlCount = 'SELECT COUNT(*) row_count FROM ' . T_LOG_ESCORT . $whereCond2 . ' AND result > 1' ;
	$recordCount = GFetchRowOne( $sqlCount );

	$data = array (
                    'recordCount' => $recordCount['row_count'],
                    'data' => $recordSet
            );
	return $data;
	
}

function getEscortDetail($roleName, $escortTimes, $timestamp )
{
	list($year, $month, $day) = explode('-', date('Y-n-j', $timestamp));
	$sql = 'SELECT SUM(refresh_times) refresh_times, escort_times,flush_type FROM ' . T_LOG_ESCORT_REFRESH . " WHERE year = $year AND month = $month AND day = $day AND escort_times = $escortTimes AND role_name = '$roleName' GROUP BY flush_type";
	
	return GFetchRowSet($sql);
}