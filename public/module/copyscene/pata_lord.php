<?php
/**
 * 修罗塔霸主查询
 */
 
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/arrItemsAll.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';
global $dictPataChallengeWay;
$errorMsg = $successMsg = array();


//$roleName 		= (isset( $_GET['role_name'] ) && Validator::stringNotEmpty($_GET['role_name']) )? autoAddPrefix( SS($_GET['role_name']) ) : '';
//$accountName 	= (isset( $_GET['account_name'] ) && Validator::stringNotEmpty($_GET['account_name']) )? autoAddPrefix( SS($_GET['account_name']) ) : '';
$floor 			= (isset( $_GET['floor'] ) && Validator::isInt($_GET['floor']) )?  intval( SS($_GET['floor']) ) : 0;
$startDay		= (isset( $_GET['start_day'] ) && Validator::isDate($_GET['start_day']) )? SS($_GET['start_day']) : date('Y-m-d', strtotime('-6 days'));
$endDay		= (isset( $_GET['end_day'] ) && Validator::isDate($_GET['end_day']) )? SS($_GET['end_day']) : date('Y-m-d');
$selectedDay = date('Y-m-d');
$floorList = range(0, 30);
$floorList[0] = '不限';
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
$viewData = getPataLordRecords($startTimestamp, $endTimestamp, $floor);

$smarty->assign( 'lang', $lang );
$smarty->assign( 'viewData', $viewData);
$smarty->assign( 'floor', $floor );
$smarty->assign( 'floorList', $floorList );
$smarty->assign( 'errorMsg', implode('<br/>', $errorMsg ) );
$smarty->assign( 'successMsg', implode('<br/>', $successMsg ) );
$smarty->assign( 'selectedDay', $selectedDay);
$smarty->assign( 'minDate', ONLINEDATE);
$smarty->assign( 'maxDate', Datatime :: getTodayString());
$smarty->assign( 'startDay', $startDay );
$smarty->assign( 'dictPataChallengeWay', $dictPataChallengeWay );
$smarty->assign( 'endDay', $endDay );
$smarty->assign( 'startTime', $startTimestamp );
$smarty->assign( 'endTime', $endTimestamp );
$smarty->assign( 'roleName', $roleName );
$smarty->assign( 'accountName', $accountName );
$smarty->display( 'module/copyscene/pata_lord.tpl' );


function getPataLordRecords( $startTimestamp, $endTimestamp, $floor = 0 )
{
	$andCond = array();
	if( Validator::isInt($floor) && intval( $floor )  > 0)
	{
		$andCond[] = ' floor = ' . intval( $floor );
	}
	if( Validator::isInt($startTimestamp) && intval( $startTimestamp )  > 0 )
	{
		$andCond[] = ' mtime >= ' . intval( $startTimestamp );
	}
	if( Validator::isInt($endTimestamp) && intval( $endTimestamp )  > 0 )
	{
		$andCond[] = ' mtime < ' . intval( $endTimestamp );
	}
	
	$where = '';
	if( !empty($andCond) )
	{
		$where = ' WHERE ' . implode(' AND ', $andCond);
	}
	$sql = 'SELECT * FROM ' . T_LOG_PATA_LORD . $where . ' ORDER BY mtime ASC;';
	$result = GFetchRowSet($sql);
	return array('data' => $result);
}

