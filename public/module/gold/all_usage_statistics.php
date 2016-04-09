<?php 
/**
 * 元宝使用统计
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/arrItemsAll.php';
include_once SYSDIR_ADMIN_DICT . '/goldConfig.php';

//include_once '../../../protected/game_config/webgame/game_function.php';
global $lang, $arrItemsAll, $goldType, $rowGroup;

$openTimestamp = strtotime( ONLINEDATE );
//元宝操作类型
$op_type = $dictOperation;

// 错误信息
$errorMsg = $successMsg = array();

// 获取参数
$role 	= isset( $_REQUEST['role'] )? $_REQUEST['role'] : array();
$page	= isset( $_REQUEST['page'] )? $_REQUEST['page'] : 1;//当前页码
$page_size = isset( $_REQUEST['pagesize'] )? $_REQUEST['pagesize'] : 1;//当前页码;//一页显示记录数
$dec_send_gold = isset($_GET['dec_send_gold']) ? 1 : 0;//是否去掉内部赠送元宝

// 过滤参数
if( !empty( $role['account_name'] ) )// 账户名
{
	$role['account_name'] = $account_name = SS( $role['account_name'] );
	$smarty->assign('showName', $account_name);
}

if( !empty( $role['role_name'] ) )// 角色名
{
	$role['role_name'] = $role_name = SS( $role['role_name'] );
	$smarty->assign('showName', $role_name);
}

if( !empty( $_REQUEST['starttime'] ) )// 开始日期（从日历）
{
	$start_time 	= strtotime( SS( $_REQUEST['starttime'] ) );
}
else
{
	$start_time 	= strtotime( '-1 days 00:00:00' );	
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
	$andCondArray[] = " account_name = '$account_name' ";	
}
if ( !empty( $role_name ) )
{	
	$andCondArray[] = " role_name = '$role_name' ";
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
$sort = '';
// 当提供了查询条件则执行查询
if( !$notValid && !empty( $andCondArray ) )
{  
	$cond = ' AND ' . implode( ' AND ' ,$andCondArray );
	$gold_liquan_of_item_statistics = array();
	$totalGold2 = $totalLiquan2 = 0;
		
	$sqlList = "select name, dbname from t_server_config where available=1 order by id desc";
	$dbList = IFetchRowSet($sqlList);
	
	if(!empty($dbList)){
	foreach($dbList as $dbKey => $dbItem){
		$dbname=$dbItem['dbname'];

    	$sql2_gold = "SELECT 
    				item_id, SUM(gold) all_gold, SUM(num) item_count, count(*) gold_op_count, type
    			FROM {$dbname}." . T_LOG_GOLD . "
    			WHERE item_id > 1 AND gold < 0 {$cond} AND `type` in (20028,20029,20076,20105,20106) 
    			GROUP BY item_id {$sort} ";
    			
    	$sql2_liquan = "SELECT 
    				item_id, SUM(liquan) all_liquan, SUM(num) item_count, count(*) liquan_op_count, type
    			FROM {$dbname}." . T_LOG_LIQUAN . "
    			WHERE item_id > 1 AND liquan < 0 {$cond} AND `type` in (50028,50029,50076,50105,50106) 
    			GROUP BY item_id {$sort} ";

//	echo "sg=$sql2_gold,\n<br>\n sl=$sql2_liquan";
	$gold_of_item_statistics = GFetchRowSet( $sql2_gold );
	$liquan_of_item_statistics = GFetchRowSet( $sql2_liquan );

	if($gold_of_item_statistics) {
		foreach($gold_of_item_statistics as $k => $gs) {
			
			$gs['all_gold'] = -$gs['all_gold'];	//转正数
			$gold_of_item_statistics[$k]['all_gold'] = $gs['all_gold'];
			
			$totalGold2 += $gs['all_gold'];
			
			$item_id = $gs['item_id'];
			$gold_liquan_of_item_statistics[$item_id]['item_id'] = $gs['item_id'];
//			$gold_liquan_of_item_statistics[$item_id]['type'] = $gs['type']%10000;
			$gold_liquan_of_item_statistics[$item_id]['all_gold'] += $gs['all_gold'];
			$gold_liquan_of_item_statistics[$item_id]['item_count'] += $gs['item_count'];
			//echo $dbname."-".$arrItemsAll[$gs['item_id']]['name'].":".$gs['item_count']."<br>";
		}
	}
	if($liquan_of_item_statistics) {
		foreach($liquan_of_item_statistics as $K => $ls) {
			
			$ls['all_liquan'] = -$ls['all_liquan'];	//转正数
			$liquan_of_item_statistics[$k]['all_liquan'] = $ls['all_liquan'];
			
			$totalLiquan2 += $ls['all_liquan'];
//			echo "total_liquan=".$totalLiquan2;
			$item_id = $ls['item_id'];
			$gold_liquan_of_item_statistics[$item_id]['item_id'] = $ls['item_id'];
//			$gold_liquan_of_item_statistics[$item_id]['type'] = $ls['type']%10000;
			$gold_liquan_of_item_statistics[$item_id]['all_liquan'] += $ls['all_liquan'];
			$gold_liquan_of_item_statistics[$item_id]['item_count'] += $ls['item_count'];
		}
	}
	
	foreach ($gold_liquan_of_item_statistics as &$record2)
	{

		if( $record2['all_gold'] == 0 )
		{
			$record2['gold_pecentage'] = 0;
		}
		else 
		{
			if( $totalGold2 > 0 )
			{
				$record2['gold_pecentage'] = 100 * (round( $record2['all_gold'] / $totalGold2, 4));
			}
			else
			{
				$record2['gold_pecentage'] = 0;
			}
			if( $totalLiquan2 > 0 )
			{
				$record2['liquan_pecentage'] = 100 * (round( $record2['all_liquan'] / $totalLiquan2, 4));
			}
			else
			{
				$record2['liquan_pecentage'] = 0;
			}/**/
		}
	}
	}
	}
//	print_r($gold_liquan_of_item_statistics);
	$gold_liquan_of_item_statistics = sortArrayByKey($gold_liquan_of_item_statistics,'all_gold','desc');
	$smarty->assign( 'gold_of_item_statistics', $gold_liquan_of_item_statistics );

}

// 设置smarty的变量
$maxDate = Datatime :: getTodayString();
$smarty->assign( 'minDate', 0);
$smarty->assign( 'maxDate', $maxDate);
$smarty->assign( 'rowGroup', $rowGroup);
$smarty->assign( 'rowGroupJson', json_encode($rowGroup));
$smarty->assign( 'highlightPercentage', HIGHTLIGHT_PERCENTAGE);
$smarty->assign( 'startTime', 	$start_time );
$smarty->assign( 'endTime', 	$end_time);
$smarty->assign( 'lookingDay', $lookingday);
$smarty->assign( 'role', $role);
$smarty->assign( 'arrItemsAll' , $arrItemsAll);
$smarty->assign( 'op_type' , $op_type);
$smarty->assign( 'dec_send_gold' , $dec_send_gold);
$smarty->assign( 'errorMsg', 	implode('<br/>', $errorMsg ) );
$smarty->assign( 'successMsg', 	implode('<br/>', $successMsg ) );
$smarty->assign( 'lang', 	$lang );
$smarty->display( 'module/gold/all_usage_statistics.tpl' );
