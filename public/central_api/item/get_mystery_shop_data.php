<?php
/**
*	Description:神秘商店数据
*/

include dirname(dirname(__FILE__)).'/central_api_auth.php';
//include SYSDIR_ADMIN.'/class/central.log.php';
session_start ();
session_regenerate_id();

$beginTime = intval($_REQUEST['begin']);
$endTime = intval($_REQUEST['end']);

// 默认发送昨天的充值数据
if ($beginTime == 0) {
	$beginTime = strtotime('today -1 day');
}
if ($endTime == 0) {
	$endTime = strtotime('today');
}

//$centralLog = new CentralLogClass();
$ip = GetIP();
//$centralLog->start($ip, getCurPageURL(), 24, $beginTime, $endTime);
if ($endTime - $beginTime < 0) {
//	$centralLog->failed(CENTRAL_LOG_TIME_PARAM_ERROR);
	exit();
}

// 不允许一次拉去超过一年的数据
if ($endTime - $beginTime > 86400 * 365) {
//	$centralLog->failed(CENTRAL_LOG_TIME_TOO_LONG);
	exit();
}

// 搜索指定时间内的领取日志, [$beginTime,$endTime) 防止数据丢失和重复！！
try {
    $item_sql = "select mtime,uuid,mdate,role_name,account_name,type,item_id,year,month,day  from t_log_item where mtime >={$beginTime} and mtime<={$endTime} and type=10261";
    $item_result = GFetchRowSet($item_sql);

    $gold_sql = "select mtime,uuid,mdate,role_name,account_name,gold,type,item_id,year,month,day   from t_log_gold where mtime >={$beginTime} and mtime<={$endTime} and type=20261";
    $gold_result = GFetchRowSet($gold_sql);

    $liquan_sql = "select mtime,uuid,mdate,role_name,account_name,liquan,type,item_id,year,month,day   from t_log_liquan where mtime >={$beginTime} and mtime<={$endTime} and type=50261";
    $liquan_result = GFetchRowSet($liquan_sql);

    $money_sql = "select mtime,uuid,mdate,role_name,account_name,money,type,item_id,year,month,day   from t_log_money where mtime >={$beginTime} and mtime<={$endTime} and type=30261";
    $money_result = GFetchRowSet($money_sql);

    $bind_money_sql = "select mtime,uuid,mdate,role_name,account_name,money as bind_money,type,item_id,year,month,day   from t_log_bind_money where mtime >={$beginTime} and mtime<={$endTime} and type=90261";
    $bind_money_result = GFetchRowSet($bind_money_sql);

    $exchange_sql = "select mtime,uuid,mdate,role_name,account_name,type,item_id,year,month,day  from t_log_item where mtime >={$beginTime} and mtime<={$endTime} and type=10266";
    $exchange_result = GFetchRowSet($exchange_sql);

    $refresh_sql = "select mtime,uuid,mdate,role_name,account_name,gold,type,item_id,year,month,day   from t_log_gold where mtime >={$beginTime} and mtime<={$endTime} and type=20262";
    $refresh_result = GFetchRowSet($refresh_sql);

    foreach ($item_result as $item_k => $item_v) {
        foreach ($gold_result as $gold_k => $gold_v) {
            if ($item_v['mtime'] == $gold_v['mtime'] && $item_v['role_name'] == $gold_v['role_name']) {
                $arr[$item_k]['uuid'] = $item_v['uuid'];
                $arr[$item_k]['mdate'] = $item_v['mdate'];
                $arr[$item_k]['mtime'] = $item_v['mtime'];
                $arr[$item_k]['role_name'] = $item_v['role_name'];
                $arr[$item_k]['account_name'] = $item_v['account_name'];
                $arr[$item_k]['type'] = $gold_v['type'];
                $arr[$item_k]['item_id'] = $item_v['item_id'];
                $arr[$item_k]['gold'] = $gold_v['gold'];
                $arr[$item_k]['liquan'] = 0;
                $arr[$item_k]['money'] = 0;
                $arr[$item_k]['bind_money'] = 0;
                $arr[$item_k]['year'] = $item_v['year'];
                $arr[$item_k]['month'] = $item_v['month'];
                $arr[$item_k]['day'] = $item_v['day'];
            }
        }
        foreach ($liquan_result as $liquan_k => $liquan_v) {
            if ($item_v['mtime'] == $liquan_v['mtime'] && $item_v['role_name'] == $liquan_v['role_name']) {
                $arr[$item_k]['uuid'] = $item_v['uuid'];
                $arr[$item_k]['mdate'] = $item_v['mdate'];
                $arr[$item_k]['mtime'] = $item_v['mtime'];
                $arr[$item_k]['role_name'] = $item_v['role_name'];
                $arr[$item_k]['account_name'] = $item_v['account_name'];
                $arr[$item_k]['type'] = $liquan_v['type'];
                $arr[$item_k]['item_id'] = $item_v['item_id'];
                $arr[$item_k]['gold'] = 0;
                $arr[$item_k]['liquan'] = $liquan_v['liquan'];
                $arr[$item_k]['money'] = 0;
                $arr[$item_k]['bind_money'] = 0;
                $arr[$item_k]['year'] = $item_v['year'];
                $arr[$item_k]['month'] = $item_v['month'];
                $arr[$item_k]['day'] = $item_v['day'];
            }
        }
        foreach ($money_result as $money_k => $money_v) {
            if ($item_v['mtime'] == $money_v['mtime'] && $item_v['role_name'] == $money_v['role_name']) {
                $arr[$item_k]['uuid'] = $item_v['uuid'];
                $arr[$item_k]['mdate'] = $item_v['mdate'];
                $arr[$item_k]['mtime'] = $item_v['mtime'];
                $arr[$item_k]['role_name'] = $item_v['role_name'];
                $arr[$item_k]['account_name'] = $item_v['account_name'];
                $arr[$item_k]['type'] = $money_v['type'];
                $arr[$item_k]['item_id'] = $item_v['item_id'];
                $arr[$item_k]['gold'] = 0;
                $arr[$item_k]['liquan'] = 0;
                $arr[$item_k]['money'] = $money_v['money'];
                $arr[$item_k]['bind_money'] = 0;
                $arr[$item_k]['year'] = $item_v['year'];
                $arr[$item_k]['month'] = $item_v['month'];
                $arr[$item_k]['day'] = $item_v['day'];
            }
        }
        foreach ($bind_money_result as $bind_money_k => $bind_money_v) {
            if ($item_v['mtime'] == $bind_money_v['mtime'] && $item_v['role_name'] == $bind_money_v['role_name']) {
                $arr[$item_k]['uuid'] = $item_v['uuid'];
                $arr[$item_k]['mdate'] = $item_v['mdate'];
                $arr[$item_k]['mtime'] = $item_v['mtime'];
                $arr[$item_k]['role_name'] = $item_v['role_name'];
                $arr[$item_k]['account_name'] = $item_v['account_name'];
                $arr[$item_k]['type'] = $bind_money_v['type'];
                $arr[$item_k]['item_id'] = $item_v['item_id'];
                $arr[$item_k]['gold'] = 0;
                $arr[$item_k]['liquan'] = 0;
                $arr[$item_k]['money'] = 0;
                $arr[$item_k]['bind_money'] = $bind_money_v['bind_money'];
                $arr[$item_k]['year'] = $item_v['year'];
                $arr[$item_k]['month'] = $item_v['month'];
                $arr[$item_k]['day'] = $item_v['day'];
            }
        }
    }
    foreach ($exchange_result as $exchange_k => $exchange_v) {
        $res[$exchange_k]['uuid'] = $exchange_v['uuid'];
        $res[$exchange_k]['mdate'] = $exchange_v['mdate'];
        $res[$exchange_k]['mtime'] = $exchange_v['mtime'];
        $res[$exchange_k]['role_name'] = $exchange_v['role_name'];
        $res[$exchange_k]['account_name'] = $exchange_v['account_name'];
        $res[$exchange_k]['type'] = $exchange_v['type'];
        $res[$exchange_k]['item_id'] = $exchange_v['item_id'];
        $res[$exchange_k]['gold'] = 0;
        $res[$exchange_k]['liquan'] = 0;
        $res[$exchange_k]['money'] = 0;
        $res[$exchange_k]['bind_money'] = 0;
        $res[$exchange_k]['year'] = $exchange_v['year'];
        $res[$exchange_k]['month'] = $exchange_v['month'];
        $res[$exchange_k]['day'] = $exchange_v['day'];
    }
    foreach ($refresh_result as $refresh_k => $refresh_v) {
        $tem[$refresh_k]['uuid'] = $refresh_v['uuid'];
        $tem[$refresh_k]['mdate'] = $refresh_v['mdate'];
        $tem[$refresh_k]['mtime'] = $refresh_v['mtime'];
        $tem[$refresh_k]['role_name'] = $refresh_v['role_name'];
        $tem[$refresh_k]['account_name'] = $refresh_v['account_name'];
        $tem[$refresh_k]['type'] = $refresh_v['type'];
        $tem[$refresh_k]['item_id'] = $refresh_v['item_id'];
        $tem[$refresh_k]['gold'] = $refresh_v['gold'];
        $tem[$refresh_k]['liquan'] = 0;
        $tem[$refresh_k]['money'] = 0;
        $tem[$refresh_k]['bind_money'] = 0;
        $tem[$refresh_k]['year'] = $refresh_v['year'];
        $tem[$refresh_k]['month'] = $refresh_v['month'];
        $tem[$refresh_k]['day'] = $refresh_v['day'];
    }
    if (is_array($res) && is_array($tem)) {
        $temp = array_merge($arr, $res, $tem);
    } else if (is_array($res)&& !is_array($tem)) {
        $temp = array_merge($arr, $res);
    } else if (!is_array($res)&&is_array($tem)) {
        $temp = array_merge($arr, $tem);
    } else {
        $temp = $arr;
    }
    $result = serialize($temp);
    echo $result;
//	$centralLog->end();
} catch (Exception $e) {
	// 数据库中不记录具体失败原因，失败日志放在log文件中
//	$centralLog->failed(CENTRAL_LOG_QUERY_SQL_ERROR, $e->getMessage());
} 

exit();
