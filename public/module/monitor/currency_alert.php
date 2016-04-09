<?php
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';

$moneyAlertValue = 100000000;	// 银两警报值：1亿
$goldAlertValue = 100000;	// 元宝警报值：10万
$liquanAlertValue = 100000;	// 礼券警报值：10万
$contributeAlertValue = 100000;	// 家族贡献警报值：10万

$data = array();

//money
$remainMoney = getRemain("money",$moneyAlertValue);
insertIntoArray($data,$remainMoney,"money");
getAndInsertOtherData($data,$remainMoney,"gold");
getAndInsertOtherData($data,$remainMoney,"liquan");
getAndInsertOtherData($data,$remainMoney,"contribute");
//gold
$remainGold = getRemain("gold",$goldAlertValue);
insertIntoArray($data,$remainGold,"gold");
getAndInsertOtherData($data,$remainGold,"money");
getAndInsertOtherData($data,$remainGold,"liquan");
getAndInsertOtherData($data,$remainGold,"contribute");

//liquan
$remainLiquan = getRemain("liquan",$liquanAlertValue);
insertIntoArray($data,$remainLiquan,"liquan");
getAndInsertOtherData($data,$remainLiquan,"money");
getAndInsertOtherData($data,$remainLiquan,"gold");
getAndInsertOtherData($data,$remainLiquan,"contribute");
//family contribute
$familyContribute = getRemain("contribute",$contributeAlertValue);
insertIntoArray($data,$familyContribute,"contribute");
getAndInsertOtherData($data,$familyContribute,"money");
getAndInsertOtherData($data,$familyContribute,"gold");
getAndInsertOtherData($data,$familyContribute,"liquan");


$smarty->assign("data",$data);
$smarty->assign("moneyAlertValue",$moneyAlertValue);
$smarty->assign("goldAlertValue",$goldAlertValue);
$smarty->assign("liquanAlertValue",$liquanAlertValue);
$smarty->assign("contributeAlertValue",$contributeAlertValue);
$smarty->assign("lang",$lang);
$smarty->display("module/monitor/currency_alert.tpl");

function getRemain($type, $alertValue){
	global $alert;
	if($type == "contribute"){
		$table = T_LOG_FAMILY_CONTRIBUTE;
		$field = "donate";
		$sql = "SELECT uuid, account_name, role_name, level, SUM(donate) AS contribute FROM $table GROUP BY family_id HAVING contribute > $alertValue";

	} else {
		$sql = "SELECT 
					t1.max_id,t2.uuid, t2.account_name,t2.role_name,t2.level,t2.remain_{$type} AS $type,t2.mtime 
				FROM 
					(SELECT MAX(id) max_id, uuid, account_name FROM t_log_{$type} GROUP BY uuid) t1, t_log_{$type} t2 
				WHERE 
					t1.uuid=t2.uuid AND t2.id=t1.max_id AND remain_{$type} >= $alertValue
				ORDER BY remain_{$type} DESC ";
	}
	$result  = GFetchRowSet($sql);
	return $result;
}

function getAndInsertOtherData(&$data, $hasArray, $type){
	$accountNameArr = array ();
	foreach($hasArray as $k => $v){
		$name = "'" . $v['account_name'] . "'";
		$accountNameArr[] =  $name;
	}
	if(!$accountNameArr){
		return ;
	}
	$accountNames = implode(',' , $accountNameArr);
	
	$sqlMoney = "SELECT 
			t1.max_id,t2.uuid, t2.account_name,t2.role_name,t2.level,t2.remain_money AS money 
		FROM 
			(SELECT MAX(id) max_id, uuid, account_name FROM t_log_money GROUP BY uuid) t1, t_log_money t2 
		WHERE 
			t1.uuid=t2.uuid AND t2.id=t1.max_id
			AND t2.account_name in ($accountNames)
	";	
	$sqlGold = "SELECT 
			t1.max_id, t2.uuid, t2.account_name,t2.role_name,t2.level,t2.remain_gold AS gold
		FROM 
			(SELECT MAX(id) max_id, uuid, account_name FROM t_log_gold GROUP BY uuid) t1, t_log_gold t2 
		WHERE 
			t1.uuid=t2.uuid AND t2.id=t1.max_id
			AND t2.account_name in ($accountNames)
	";	
	$sqlLiquan = "SELECT 
			t1.max_id, t2.uuid, t2.account_name,t2.role_name,t2.level,t2.remain_liquan AS liquan
		FROM 
			(SELECT MAX(id) max_id, uuid, account_name FROM t_log_liquan GROUP BY uuid) t1, t_log_liquan t2 
		WHERE 
			t1.uuid=t2.uuid AND t2.id=t1.max_id
			AND t2.account_name in ($accountNames)
	";	
	$sqlContribute = "SELECT uuid, account_name, role_name, level, SUM(donate) AS contribute FROM t_log_family_contribute WHERE account_name in ($accountNames) GROUP BY family_id";
	
	switch($type){
		case 'money':
			$resultMoney = GFetchRowSet($sqlMoney);
			insertIntoArray($data,$resultMoney,"money");
			break;
		case 'gold':
			$resultGold = GFetchRowSet($sqlGold);
			insertIntoArray($data,$resultGold,"gold");
			break;
		case 'liquan':
			$resultLiquan = GFetchRowSet($sqlLiquan);
			insertIntoArray($data,$resultLiquan,"liquan");
			break;
		case 'contribute':
			$resultContribute = GFetchRowSet($sqlContribute);
			insertIntoArray($data,$resultContribute,"contribute");
			break;
		default: 
			echo "No Such Type!!";
	}
	
}

function insertIntoArray(&$data,$insertArray,$type){

	foreach($insertArray as $k => $v){
		$data[$v['account_name']]['account_name'] = $v['account_name'];
		$data[$v['account_name']]['role_name'] = $v['role_name'];
		$data[$v['account_name']]['level'] = $v['level'];
		$data[$v['account_name']][$type] = $v[$type]?$v[$type]:0 ;
	}
	foreach($data  as $name => $arr){
		if(!isset($data[$name][$type])) {
			$data[$name][$type] = 0;
		}
	}
}
