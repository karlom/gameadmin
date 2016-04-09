<?php
/**
 * Name: wealth_statistics.ph
 * Description: 用于进行生成玩家目前的财富值（元宝，绑定元宝，铜币，绑定铜币）
 * Usage: php wealth_statistics.php --serverID=s1(不提供则对所有服进行) --action=import|clear --days=3(用于指定清除多少天前的数据，不提供则清空所有。)
 */

include_once '../config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global_not_auth.php';
include_once 'cli.php';
global $server_db;
$loadServerList = getAvailableServerList();

$cli = new CLI();

if(!$server_db){
	$server_db =  new DBMysqlClass();
}

$serverID = $cli->getOption('serverID');
if($serverID)
{
	if(array_key_exists($serverID, $loadServerList))
	{
		$tmp = $loadServerList[$serverID];
		$loadServerList = array();
		$loadServerList[$serverID] = $tmp;
	}
	else
	{
		echo "服务器代号不存在,请输入正确的服号!\n";
		exit;
	}
}
$action = $cli->getOption('action');
if($action)
{
	if($action == 'clear')
	{
		$days = intval( $cli->getOption('days') );
	}
}
else 
{
	echo "请指定操作类型（import or clear）!\n";
	exit;
}


foreach($loadServerList as $key =>$server)
{
	$config = getLogDb($loadServerList[$key]);
	$server_db->connect($config);

	if($action == 'import')
	{
	$typeList = array('gold', 'bind_gold', 'money', 'bind_money');
	
	foreach($typeList as $typeKey => $type)
	{
		echo "正在为[$key]的[$type]执行统计...\n";
		$rawResult = getWealthStatistics($type);
		
		$insertList = array();
		$totalValue = 0;
		$totalMen = 0;
		foreach($rawResult['data'] as $raw)
		{
			
			list($i, $range) = explode('/', $raw['ranges']);
			list($begin, $end) = explode('-', $range);
			$begin = $begin == null? -1 : $begin;
			$end = $end == null? -1 : $end;
			$result = array(
				'mtime' 		=> $cli->getStartTime(),
				'type'			=> $typeKey,
				'begin' 		=> $begin,
				'end'			=> $end,
				'men_count'		=> $raw['men_count'],
				'total_value'	=> $raw['remain_value_by_range'],
				'avg_value'		=> round($raw['remain_value_by_range'] / $raw['men_count'], 2)
			);
			$insertList[] = $result;
			$totalValue += $raw['remain_value_by_range'];
			$totalMen += $raw['men_count'];
		}
		
		foreach( $insertList as &$result )
		{
		
			$result['men_count_percentage'] = round(($result['men_count'] / $totalMen), 4) * 100;
			$result['total_value_percentage'] = round(($result['total_value'] / $totalValue), 4) * 100;
		}
		
		echo "总量：$totalValue, 总人数：$totalMen\n";
		echo "[$key]的[$type]统计完成\n----------------------------------------------\n";
		echo "正在为[$key]的[$type]统计结果执行入库...\n";
	//	print_r($insertList);
		foreach ( $insertList as $r )
		{
		//	print_r($result);
			$sql = makeInsertSqlFromArray($r, T_LOG_WEALTH);
			GQuery($sql);
			echo $sql . "\n";
		}
		echo "[$key]的[$type]入库完成\n==============================================\n";
	}
	}
	elseif($action == 'clear')
	{
		clearHistory($days);
	}
}
$timeUsed = time() - $cli->getStartTime();
echo "总耗时：$timeUsed s\n";



function getWealthStatistics($type = 'gold')
{
	switch ($type)
	{
		case 'gold':
				$table = T_LOG_GOLD;
				$valueField = 'remain_gold';
				$fieldString = '0, 1, 11, 101, 501, 1001, 5001';
				$valueString = "'0/0-0', '1/1-10', '2/11-100', '3/101-500', '4/501-1000', '5/1001-5000', '6/5001'";
			break;
		case 'bind_gold':
				$table = T_LOG_GOLD;
				$valueField = 'remain_bind_gold';
				$fieldString = '0, 1, 11, 101, 501, 1001, 5001';
				$valueString = "'0/0-0', '1/1-10', '2/11-100', '3/101-500', '4/501-1000', '5/1001-5000', '6/5001'";
			break;
		case 'money':
				$table = T_LOG_MONEY;
				$valueField = 'remain_money';
				$fieldString = '0, 1, 10001, 100001, 1000001, 5000001';
				$valueString = "'0/0-0', '1/1-10000', '2/10001-100000', '3/100001-1000000', '4/1000001-5000000', '5/5000001'";
			break;
		case 'bind_money':
				$table = T_LOG_MONEY;
				$valueField = 'remain_bind_money';
				$fieldString = '0, 1, 10001, 100001, 1000001, 5000001';
				$valueString = "'0/0-0', '1/1-10000', '2/10001-100000', '3/100001-1000000', '4/1000001-5000000', '5/5000001'";
			break;
		default:
			break;
	}
	
	$sqlWealthStatistics = "SELECT 
								SUM($valueField) remain_value_by_range, COUNT(*) men_count, elt(interval($valueField, $fieldString), $valueString) ranges 
							FROM (
								SELECT * 
								FROM (
									SELECT  
										t1.id, t1.account_name, t1.mtime, t1.$valueField
									FROM $table t1 
									RIGHT JOIN (
										SELECT 
											account_name, $valueField, max(mtime) max_time 
										FROM $table
										WHERE true  
										GROUP BY account_name
									) t2
						  			ON t1.account_name = t2.account_name and t1.mtime = t2.max_time
						 			ORDER BY t1.id DESC
								) tgroup
								GROUP BY tgroup.account_name
							) t
							GROUP BY elt(interval($valueField, $fieldString), $valueString)";
//	dump( $sqlWealthStatistics) ;
	$wealthStatistics = GFetchRowSet($sqlWealthStatistics);
	
	$data = array ( 
                    'data' => $wealthStatistics
            );
	return $data;
	
}


function clearHistory($days = 30)
{
	global $cli;
	if( $days === false)
	{//清空数据表
		$sql = 'TRUNCATE ' . T_LOG_WEALTH;
	}
	else
	{//删除days天以前的数据
		$ts = $cli->getStartTime() - 86400 * $days;
		$sql = 'DELETE FROM ' . T_LOG_WEALTH . ' WHERE mtime < ' . $ts;
	}
	GQuery($sql);
}
