<?php 
/**
 * 铜币使用统计
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/arrItemsAll.php';
include_once SYSDIR_ADMIN_DICT . '/moneyConfig.php';

//include_once '../../../protected/game_config/webgame/game_function.php';
global $lang, $arrItemsAll, $moneyType;

$openTimestamp = strtotime( ONLINEDATE );

// 转换操作类型的格式为id => 内容
$op_type = array();
foreach ( $moneyType as $moneyTypeItem )
{
	$op_type += $moneyTypeItem;
} 

// 错误信息
$errorMsg = $successMsg = array();

// 获取参数
$role 	= isset( $_REQUEST['role'] )? $_REQUEST['role'] : array();
$page	= isset( $_REQUEST['page'] )? $_REQUEST['page'] : 1;//当前页码
$page_size = isset( $_REQUEST['pagesize'] )? $_REQUEST['pagesize'] : 1;//当前页码;//一页显示记录数

// 过滤参数
if( !empty( $role['account_name'] ) )// 账户名
{
	$role['account_name'] = $account_name 	= autoAddPrefix( SS( $role['account_name'] ));
	$smarty->assign('showName', $account_name);
}

if( !empty( $role['role_name'] ) )// 角色名
{
	$role['role_name'] = $role_name = autoAddPrefix( SS( $role['role_name'] ));
	$smarty->assign('showName', $role_name);
}

if( !empty( $_REQUEST['starttime'] ) )// 开始日期（从日历）
{
	$start_time 	= strtotime( SS( $_REQUEST['starttime'] ) );
}
else
{
	$start_time 	= strtotime( '-7 days 00:00:00' );	
}
if($start_time < $openTimestamp)
{
	$start_time = $openTimestamp;
}

if( !empty( $_REQUEST['endtime'] ) )// 结束日期（从日历）
{
	$end_time 		= strtotime( SS( $_REQUEST['endtime'] ) . ' 23:59:59' );
}
else
{ 
	$end_time 		= strtotime( 'today 23:59:59' );
}

if( !empty( $_REQUEST['lookingday'] ))// 当前查看的日期
{
	$lookingday = SS( $_REQUEST['lookingday'] );
}
else // 设置当前查看的日期为当日
{
	$lookingday = date( 'Y-m-d' );
}
if( !empty( $_REQUEST['preday'] ) )// 查看前一天
{
	$start_time = strtotime( $lookingday . ' 00:00:00 -1 day' );
	$end_time	= strtotime( $lookingday . ' 23:59:59 -1 day' );
	$lookingday = date('Y-m-d', $start_time);
}
elseif( !empty( $_REQUEST['nextday'] ) )// 查看后一天
{
	$start_time = strtotime( $lookingday . ' 00:00:00 +1 day' );
	$end_time	= strtotime( $lookingday . ' 23:59:59 +1 day' );
	$lookingday = date('Y-m-d', $start_time);
}
elseif( !empty( $_REQUEST['today'] ) )// 查看当天
{
	$today 		= date( 'Y-m-d' );
	$start_time = strtotime( $today . ' 00:00:00' );
	$end_time	= strtotime( $today . ' 23:59:59' );
	$lookingday = $today;
}
elseif( !empty( $_REQUEST['showAll'] ) )// 查看全部
{
	$today 		= date( 'Y-m-d' );
	$start_time = strtotime( $serverList[$_SESSION ['gameAdminServer']]['onlinedate'] . ' 00:00:00' );
	$end_time	= strtotime( $today . ' 23:59:59' );
	$lookingday = $today;
}


// 构造$andCondArray
$andCondArray = array();
$notValid = false;

if ( !empty( $account_name ) )
{
	// 添加前缀，因为日志中获得的账户名，格式为 "[服ID]账户名"
	$account_name_db =  $account_name;

	$andCondArray[] = " account_name = '$account_name_db' ";
	
}
if ( !empty( $role_name ) )
{
	// 添加前缀，因为日志中获得的角色名，格式为 "[服ID]角色名"
	$role_name_db =   $role_name;
	
	$andCondArray[] = " role_name = '$role_name_db' ";
}
if ( !empty( $start_time ) && !empty( $end_time ) && $start_time > $end_time )
{// 提供了开始和结束时间，但是开始时间大于结束时间
	$errorMsg[] = $lang->page->startTimeGtEndTime;
	$notValid = true;
}
if ( !empty( $start_time ) )
{
	$andCondArray[] = " mtime > $start_time ";
}
if ( !empty( $end_time ) )
{ 
	$andCondArray[] = " mtime < $end_time ";
}

$cond = '';
$sort = ' ORDER BY total_money desc ';
// 当提供了查询条件则执行查询
if( !$notValid && !empty( $andCondArray ) )
{  
	$cond 	= implode( ' AND ' ,$andCondArray ) ;
	$start 	= ( $page - 1 ) * $pageSize;
	$sql 	= "SELECT
					(SUM(money)+SUM(bind_money)) total_money, SUM(money) all_money, SUM(bind_money) all_bind_money , type, COUNT(*) op_count 
			   FROM " . T_LOG_MONEY . "
			   WHERE $cond
			   GROUP BY type
			   $sort
			   ";
	
	//	$smarty->assign( 'unfinish_task_list', $unfinish_task_list );
	//	print_r($viewData);
	
	$money_statistics = GFetchRowSet( $sql );
	
	$money_decrease_statistics = $money_increase_statistics = array();

	$totalDecreaseAllMoney = $totalDecreaseBindMoney = $totalDecreaseMoney = 0;
	$totalIncreaseAllMoney = $totalIncreaseBindMoney = $totalIncreaseMoney = 0;
	

	
	foreach ($money_statistics as $record)
	{
		if ( $record['type'] < 20000)
		{
			$money_decrease_statistics[] = $record;
			$totalDecreaseAllMoney += $record['total_money'];
			$totalDecreaseMoney += $record['all_money'];
			$totalDecreaseBindMoney += $record['all_bind_money'];
		} 
		else
		{
			$money_increase_statistics[] = $record;
			$totalIncreaseAllMoney += $record['total_money'];
			$totalIncreaseMoney += $record['all_money'];
			$totalIncreaseBindMoney += $record['all_bind_money'];
		}
	}
	foreach( $money_decrease_statistics as &$moneyDecrease )
	{
		$moneyDecrease['all_pecentage'] = $totalDecreaseAllMoney == 0? 0 : 100 * (round( $moneyDecrease['total_money'] / $totalDecreaseAllMoney, 4));
		$moneyDecrease['money_pecentage'] = $totalDecreaseMoney == 0? 0 : 100 * (round( $moneyDecrease['all_money'] / $totalDecreaseMoney, 4));
		$moneyDecrease['bind_money_pecentage'] = $totalDecreaseBindMoney == 0? 0 : 100 * (round( $moneyDecrease['all_bind_money'] / $totalDecreaseBindMoney, 4));
	}

	foreach( $money_increase_statistics as &$moneyIncrease )
	{
		$moneyIncrease['all_pecentage'] = $totalIncreaseAllMoney == 0? 0 : 100 * (round( $moneyIncrease['total_money'] / $totalIncreaseAllMoney, 4));
		$moneyIncrease['money_pecentage'] = $totalIncreaseMoney == 0? 0 : 100 * (round( $moneyIncrease['all_money'] / $totalIncreaseMoney, 4));
		$moneyIncrease['bind_money_pecentage'] = $totalIncreaseBindMoney == 0? 0 : 100 * (round( $moneyIncrease['all_bind_money'] / $totalIncreaseBindMoney, 4));
	}
		
	// 获取满足条件的记录数
	$smarty->assign( 'money_decrease_statistics', $money_decrease_statistics );
	$smarty->assign( 'money_increase_statistics', $money_increase_statistics );	
	
	$cond = ' AND ' . $cond;
	$sort = ' ORDER BY total_money desc ';
	$sql2 = "SELECT 
				item_id, (SUM(money)+SUM(bind_money)) total_money, SUM(money) all_money, SUM(bind_money) all_bind_money, SUM(num) item_count, count(*) op_count
			FROM " . T_LOG_MONEY . "
			WHERE
				item_id > 0 $cond
			GROUP BY item_id
			$sort
			";

	$money_of_item_statistics = GFetchRowSet( $sql2 );
	$totalAllMoney = $totalBindMoney = $totalMoney = 0;
	foreach( $money_of_item_statistics as $money )
	{
		$totalAllMoney += $money['total_money'];
		$totalMoney += $money['all_money'];
		$totalBindMoney += $money['all_bind_money'];
	}
	
	foreach( $money_of_item_statistics as &$money )
	{
		$money['all_pecentage'] = $totalAllMoney == 0? 0 : 100 * (round( $money['total_money'] / $totalAllMoney, 4));
		$money['money_pecentage'] = $totalMoney == 0? 0 : 100 * (round( $money['all_money'] / $totalMoney, 4));
		$money['bind_money_pecentage'] = $totalBindMoney == 0? 0 : 100 * (round( $money['all_bind_money'] / $totalBindMoney, 4));
	}
//	echo "<pre>".print_r($money_of_item_statistics, true).'</pre>';
	
	$smarty->assign( 'money_of_item_statistics', $money_of_item_statistics );

}


// 设置smarty的变量
$minDate = $serverList[$_SESSION ['gameAdminServer']]['onlinedate'];
$maxDate = Datatime :: getTodayString();
$smarty->assign( 'minDate', $minDate);
$smarty->assign( 'maxDate', $maxDate);
$smarty->assign( 'highlightPercentage', HIGHTLIGHT_PERCENTAGE);
$smarty->assign( 'startTime', 	$start_time );
$smarty->assign( 'endTime', 	$end_time);
$smarty->assign( 'lookingDay', $lookingday);
$smarty->assign( 'role', $role);
$smarty->assign( 'arrItemsAll' , $arrItemsAll);
$smarty->assign( 'op_type' , $op_type);
$smarty->assign( 'errorMsg', 	implode('<br/>', $errorMsg ) );
$smarty->assign( 'successMsg', 	implode('<br/>', $successMsg ) );
$smarty->assign( 'lang', 	$lang );
$smarty->display( 'module/money/usage_statistics.tpl' );
