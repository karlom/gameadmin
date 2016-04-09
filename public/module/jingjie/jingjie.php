<?php 
/**
 * 境界统计
 */

include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';

$openTimestamp = strtotime( ONLINEDATE );

// 错误信息
$errorMsg = $successMsg = array();


// 过滤参数
if( !empty( $_REQUEST['starttime'] ) )// 开始日期（从日历）
{
	$start_time = strtotime( SS( $_REQUEST['starttime'] ) );
	$end_time 	= strtotime( SS( $_REQUEST['starttime'] ) . ' 23:59:59' );
}
else
{
	$start_time = strtotime( 'today 00:00:00' );
	$end_time 	= strtotime( 'today 23:59:59' );
}

if($start_time < $openTimestamp)
{
	$start_time = $openTimestamp;
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


// 构造$andCondArray
$andCondArray = array();
$notValid = false;

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
	$data = array();
	
	$item_id = 11223;	//境界丹
	$cond 	= implode( ' AND ' ,$andCondArray ) ;

	//境界提升总次数、境界提升人数
   	$sql_1 	= "SELECT
   			   count(*) as jingjie_count, count(distinct uuid) as role_count  
   			   FROM " . T_LOG_JINGJIE . "
   			   WHERE $cond
   			   ";

	$result1 = GFetchRowOne( $sql_1);
    
    $data['jingjie_count'] = $result1['jingjie_count'] ? $result1['jingjie_count'] : 0 ;
    $data['role_count'] = $result1['role_count'] ? $result1['role_count'] : 0 ;
    
    //境界提升失败次数、境界提升失败消耗灵气
   	$sql_2 	= "SELECT count(*) as `fail_count`, sum(lingqi) as `fail_cost_lingqi` FROM " . T_LOG_JINGJIE . " WHERE $cond AND success=0 ";
           
    $result2 = GFetchRowOne( $sql_2 );
    //// stop here
    $data['fail_count'] = $result2['fail_count'] ? $result2['fail_count'] : 0 ;
    $data['fail_cost_lingqi'] = $result2['fail_cost_lingqi'] ? $result2['fail_cost_lingqi'] : 0 ;
    
    
    //消耗境界丹数量
    $sql_3 	= "SELECT
   	       SUM(itemNum) as item_count  
   		   FROM " . T_LOG_JINGJIE . "
   		   WHERE $cond AND success=0
   		   ";
           
	$result3 = GFetchRowOne( $sql_3 );
    
	$data['item_count'] = $result3['item_count'] ? $result3['item_count'] : 0 ;
    
    //最高境界等级及角色列表
    $sql_4 	= "SELECT
   		   uuid, account_name, role_name, jingjieID
   		   FROM " . T_LOG_JINGJIE . "
   		   WHERE jingjieID=(select max(jingjieID) from t_log_jingjie limit 1)
           GROUP by uuid
   		   ";
           
    $result4 = GFetchRowSet( $sql_4 );
	$maxJingjieLevel = 0;
	$roleNames = "";
    if(!empty($result4)){
		foreach($result4 as $v) {
    		$roleNames .= $v['role_name'].",";
    	}
    	
    	$maxJingjieLevel = $v['jingjieID'];
    }
    $data['max_jingjie_level'] = $maxJingjieLevel;
    $data['max_jingjie_role_count'] = count($result4);
    $data['max_jingjie_rolename_list'] = rtrim($roleNames,',');
    
    //最高神通技能等级 及角色列表
    $sql_5 	= "
    		select 
				t1.skillName, t1.skillID, t1.skillLevel, t1.role_name 
			from
				t_log_jingjie_skill t1, (select skillName, max(skillID) as msID, max(skillLevel) as mslevel from t_log_jingjie_skill group by skillName ) t2
			where 
				t1.skillName=t2.skillName AND t1.skillID=t2.msID AND t1.skillLevel = t2.mslevel
			group by t1.skillName, t1.skillID, t1.skillLevel, t1.role_name 
			order by t1.skillID
   		   ";
    $result5 = GFetchRowSet( $sql_5 );
    $skillData = array();
    if (!empty($result5)) {
//        $smarty->assign( 'jingjie_max', $jingjie_statistics[0][level]);        
		foreach($result5 as $v){
			$skillData[$v['skillID']]['skillID'] = $v['skillID'];
			$skillData[$v['skillID']]['skillName'] = $v['skillName'];
			$skillData[$v['skillID']]['skillLevel'] = $v['skillLevel'];
			$skillData[$v['skillID']]['roleNameList'] .= $v['role_name'].",";
		}
		foreach($skillData as $k=> $v){
			$skillData[$k]['roleNameList'] = rtrim($v['roleNameList'],',');
		}
    }
    $data['skillData'] = $skillData;
    
}


// 设置smarty的变量
$minDate = ONLINEDATE;
$maxDate = Datatime :: getTodayString();

$smarty->assign( 'data', $data);
        
$smarty->assign( 'minDate', $minDate);
$smarty->assign( 'maxDate', $maxDate);
$smarty->assign( 'rowGroup', $rowGroup);
$smarty->assign( 'rowGroupJson', json_encode($rowGroup));
$smarty->assign( 'highlightPercentage', HIGHTLIGHT_PERCENTAGE);
$smarty->assign( 'startTime', 	$start_time );
$smarty->assign( 'lookingDay', $lookingday);
$smarty->assign( 'arrItemsAll' , $arrItemsAll);
$smarty->assign( 'op_type' , $op_type);
$smarty->assign( 'errorMsg', 	implode('<br/>', $errorMsg ) );
$smarty->assign( 'successMsg', 	implode('<br/>', $successMsg ) );
$smarty->assign( 'lang', 	$lang );
$smarty->display( 'module/jingjie/jingjie.tpl' );