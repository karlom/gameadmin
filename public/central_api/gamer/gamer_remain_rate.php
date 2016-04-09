<?php
/**
 * 中央API接口，用于统计玩家留存率
 */

include dirname(dirname(__FILE__)).'/central_api_auth.php';

$day = intval($_REQUEST['day']);
$day = $day + 1;

$onlineDate = $serverList[$_SESSION ['gameAdminServer']]['onlinedate'];
$tsBeginOfRemainRate = strtotime($onlineDate);
$tsEndOfRemainRate = strtotime($onlineDate . " +$day days") - 1;

echo  getRemainRate($tsBeginOfRemainRate, $tsEndOfRemainRate);
exit;

function getRemainRate( $beginTs, $endTs )
{
	$result = array();
	$endTimeOfStart = $beginTs + 86399;
	$beginTimeOfEnd = $endTs - 86399;

	$sqlCountStart = "SELECT COUNT(DISTINCT role_name) count_start FROM t_log_register WHERE mtime >= $beginTs AND mtime <= $endTimeOfStart";
	$resultCountStart = GFetchRowOne($sqlCountStart);
	$countStart = intval( $resultCountStart['count_start'] );

	$sqlRemain = "SELECT 
					COUNT(DISTINCT t1.role_name) remain, 
					YEAR( FROM_UNIXTIME( t1.mtime ) ) as `year`, 
					MONTH( FROM_UNIXTIME( t1.mtime ) ) as `month`, 
					DAY( FROM_UNIXTIME( t1.mtime ) ) as `day`
				FROM t_log_login t1 
				LEFT JOIN
				(
					SELECT DISTINCT role_name FROM t_log_register WHERE mtime >= $beginTs AND mtime <= $endTimeOfStart 
				)t2 ON t1.role_name = t2.role_name
				WHERE
					t1.mtime >= $beginTimeOfEnd AND t1.mtime <= $endTs AND t2.role_name IS NOT NULL
				GROUP BY `year`,`month`,`day` WITH ROLLUP;";
	//	echo $sqlRemain.'<br/>';
	$resultRemain = GFetchRowOne($sqlRemain);
	return $countStart == 0? 0 : round($resultRemain['remain'] / $countStart, 4) * 100;
}