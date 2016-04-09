<?php
/**
 * Description:给中央后台提供接口，从c_player_track_update表中读取数据
 */

define ( 'IN_ADMIN_SYSTEM', true );
//include_once "../../../config/config.php";
//include_once SYSDIR_INCLUDE . "/global.php";
//include_once SYSDIR_ROOT . '/class/db.class.php';
include '../central_api_auth.php';
//include SYSDIR_ADMIN . '/class/central.log.php';

//include_once '../../../protected/class/central.log.php';

define ( "DAY", 24 * 60 * 60 );

$beginTime = intval ( $_REQUEST ['begin'] );
$endTime = intval ( $_REQUEST ['end'] );

// 默认发送昨天的数据
if ($beginTime == 0) {
    $beginTime = strtotime ( 'today -1 day' );
}
if ($endTime == 0) {
    $endTime = strtotime ( 'today' ) - 1;
}

$centralLog = new CentralLogClass ();
$ip = GetIP ();
//$centralLog->start ( $ip, getCurPageURL (), 20, $beginTime, $endTime );
if ($endTime - $beginTime < 0) {
//    $centralLog->failed ( CENTRAL_LOG_TIME_PARAM_ERROR );
    exit ();
}

// 不允许一次拉去超过一年的数据
if ($endTime - $beginTime > 86400 * 365) {
 //   $centralLog->failed ( CENTRAL_LOG_TIME_TOO_LONG );
    exit ();
}

//$agentId = AGENT_ID;
//$serverId = SERVER_ID;
$agentId = PROXYID;
$serverId = substr($serverID,1);
//$tableName = 'old_gamer_count';

//增加可以按天取数据的参数
$timeday = $endTime - DAY;
$time2day = $endTime - 2 * DAY;
$time3day = $endTime - 3 * DAY;
$todayZero = strtotime ( date ( "Y-m-d 00:00:00", time () ) );
// 昨天零点
$startday = strtotime ( date ( "Y-m-d 00:00:00", $timeday ) );
// 前天零点
$start2day = strtotime ( date ( "Y-m-d 00:00:00", $time2day ) );
$start3day = strtotime ( date ( "Y-m-d 00:00:00", $time3day ) );
$endday = strtotime ( date ( "Y-m-d 23:59:59", $timeday ) );
$count_date = date ( "Ymd", $timeday );

try {
    
    /**
     * 老玩家定义：非统计日期前一天注册，统计日期有与前一天都有登陆
     * 例如：8.4统计8.3的数据，则统计8.2前注册，在8.2，8.3都有登陆的用户数据
     */
    
//    $sqlYestoday = "select distinct(base.role_id) from db_role_base_p base, t_log_login login " . " where base.create_time < {$start2day} and login.role_id = base.role_id " . " and login.log_time > {$startday} and login.log_time < $todayZero";
//    $resultYestoday = GFetchRowSet ( $sqlYestoday );
//    
//    $sqlBeforeYestoday = "select distinct(base.role_id) from db_role_base_p base, t_log_login login " . " where base.create_time < {$start2day} and login.role_id = base.role_id " . "and login.log_time > {$start2day} and login.log_time < $startday";
//    $resultBeforeYestory = GFetchRowSet ( $sqlBeforeYestoday );
    
    $sqlYestoday = "select distinct(base.role_name) from t_log_register base, t_log_login login " . " where base.mtime < {$start2day} and login.role_name = base.role_name " . " and login.mtime > {$startday} and login.mtime < $todayZero";
    $resultYestoday = GFetchRowSet ( $sqlYestoday );
    
    $sqlBeforeYestoday = "select distinct(base.role_name) from t_log_register base, t_log_login login " . " where base.mtime < {$start2day} and login.role_name = base.role_name " . "and login.mtime > {$start2day} and login.mtime < $startday";
    $resultBeforeYestory = GFetchRowSet ( $sqlBeforeYestoday );
    
    $num = 0;
    foreach ( $resultYestoday as $v ) {
        if (in_array ( $v, $resultBeforeYestory )) {
            $num ++;
        }
    }
    
    $result [] = array (
        "agent_id" => $agentId, "server_id" => $serverId, "gamers" => $num, "adate" => $count_date 
    );
    $result = serialize ( $result );
    echo $result;
//    $centralLog->end ();
} catch ( Exception $e ) {
    // 数据库中不记录具体失败原因，失败日志放在log文件中
//    $centralLog->failed ( CENTRAL_LOG_QUERY_SQL_ERROR, $e->getMessage () );
}

exit ();




