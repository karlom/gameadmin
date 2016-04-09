<?php
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';
include_once SYSDIR_ADMIN_DICT . '/arrItemsAll.php';
global $lang,$activityType;

$action = isset($_GET['action']) ? SS($_GET['action']) : "";


if("setOnlineCheapShop" == $action ){//设置在线商店促销
 //   $content = SS($_POST['content']);
 /*
    if($content){
        $api = "setloginnotice";
        $params = array(
            "content" => SS($_POST['content']),
        );
        $loginNoticeServerList = $_POST['loginNoticeServerList'];
        if($loginNoticeServerList){
            $log = new AdminLogClass();
            foreach($loginNoticeServerList as $key => $value){
                $httpResult = interfaceRequest($api, $params, 'GET', 60, $value);
                if(1 == $httpResult['result']){
                    $msg[] = $lang->verify->opSuc.":{$value}";
                    //写日志
                    $log->Log(AdminLogClass::SET_NOTICE,$lang->verify->opSuc.":{$value}",'','','','');
                }else{
                    $msg[] = $lang->page->errorReason.":{$value}".$httpResult['errorMsg'];
                }
            }
        }
    }else{
        $msg[] = $lang->page->errorReason.":".$lang->msg->loginNoticeContentIsNull;
    }*/
	$cheapshop = array();
	$itemCount = count($_GET['item']);
	$cheapShopList = array();
	$startTime = strtotime($_GET['start_time']);
	$keepTime = strtotime($_GET['end_time']) - $startTime;
	$existID = 0;
	for($i = 1; $i <= $itemCount; $i++)
	{
		
		$cheapShopList[$i] = array(
								'itemID' => intval( $_GET['itemid'][$i]),
								'priceOld' => intval($_GET['old_price'][$i]),
								'priceNew' => intval($_GET['new_price'][$i]),
								'cnt' => intval($_GET['cnt'][$i]),
								'keepTime' => intval($keepTime),
								'bind' => intval($_GET['isbind'][$i]),
								'startTime' => intval($startTime),
								'limitPerson' => intval($_GET['buy_num'][$i]),
							);
							
	}
//	if ( ( $existID = checkDateValid($startTime, $startTime + $keepTime, 0) ) && $existID == 0)
//	{
		//$inValid = true;
	
		$ret = interfaceRequest('setcheapshop', array('cheapshop' => json_encode( $cheapShopList ), 'type' => 1 ));
		if($ret['result'] == 1)
		{
			$cache = ExtMemcache::instance();
			$cache->delete('shopInfo');
		}
//	}
/*	else
	{
		$msg[] = "日期和其它配置(#$existID)重叠，请重设！";
	}*/
	$cheapShopShow['start_time'] = date('Y-m-d H:i:s', $startTime );
	$cheapShopShow['end_time'] = date('Y-m-d H:i:s', $startTime + $keepTime );
	$cheapShopShow['data'] = $cheapShopList;
	$smarty->assign('cheapShopShow', $cheapShopShow);
	$smarty->assign('existID', $existID);
//	dump($_POST);
}else if("view" == $action){//查看某个促销的设置
    $id = intval($_GET['id']);
    $sql = "select * from ".T_CHEAP_SHOP." where id={$id}";
    $result = GFetchRowOne($sql);
    $cheapShopList = array();
    $result['data'] = json_decode($result['content'], true);
    $result['end_time'] = $result['end_time'] > 0 ? date("Y-m-d H:i:s", $result['end_time']) : 0;
    $result['start_time'] = $result['start_time'] > 0 ? date("Y-m-d H:i:s", $result['start_time']) : 0;
    $cheapShopList['id'] = $result['id'];
    $cheapShopList['data'] = $result['data'];
    $cheapShopList['start_time'] = $result['start_time'];
    $cheapShopList['end_time'] = $result['end_time'];
    $cheapShopList['title'] = $result['title'];
	$cheapShopList['date_type'] = $result['date_type'];
	
	if($result['date_type'] == 1){
		list($cheapShopList['start_open_day'], $cheapShopList['start_open_hour'], $cheapShopList['start_open_minute']) = Datatime::timestampToDayHourMinute($result['start_open_day_time']);
		list($cheapShopList['end_open_day'], $cheapShopList['end_open_hour'], $cheapShopList['end_open_minute']) = Datatime::timestampToDayHourMinute($result['end_open_day_time']);
	}
    $action = "set";
    $smarty->assign('action', $action);
    $smarty->assign('cheapShopShow', $cheapShopList);
}else if("set" == $action){//设置某个促销
    $id = intval($_GET['id']);
    $cheapShopShow['title'] = SS($_GET['title']);
    $cheapShopShow['mtime'] = NOW_TIMESTAMP;
    $itemId = $_GET['itemid'];
    $newPrice = $_GET['new_price'];
    $oldPrice = $_GET['old_price'];
    $cnt = $_GET['cnt'];
    $buyNum = $_GET['buy_num'];
    $isbind = $_GET['isbind'];
	
	$cheapShopShow['date_type'] = intval($_GET['date_type']);
	$cheapShopShow['status'] = 0; //重置状态为未开始
	$inValid = false;
	$existID = 0;
	if($cheapShopShow['date_type'] === 0)
	{// 按确切日期
		$cheapShopShow['start_time'] = strtotime(SS($_GET['start_time']));
		$cheapShopShow['end_time'] = strtotime(SS($_GET['end_time']));
		
		$cheapShopShow['start_open_day_time'] = 0;
		$cheapShopShow['end_open_day_time'] = 0;
		
		if ( ($existID = checkDateValid($cheapShopShow['start_time'], $cheapShopShow['end_time'], 0, $id) ) && $existID > 0){
			$inValid = true;
		}
	}
	if($cheapShopShow['date_type'] === 1)
	{// 按开服日期
		$cheapShopShow['start_time'] = 0;
		$cheapShopShow['end_time'] = 0;
			
		$cheapShopShow['start_open_day_time'] = Datatime::dayHourMinuteToTimestamp( intval(SS($_GET['start_open_day'])), intval(SS($_GET['start_open_hour'])), intval(SS($_GET['start_open_minute'])) );
		$cheapShopShow['end_open_day_time'] = Datatime::dayHourMinuteToTimestamp( intval(SS($_GET['end_open_day'])), intval(SS($_GET['end_open_hour'])), intval(SS($_GET['end_open_minute'])) );
		if ( ( $existID = checkDateValid($cheapShopShow['start_open_day_time'], $cheapShopShow['end_open_day_time'], 1, $id) ) && $existID > 0 ){
			$inValid = true;
		}
	}
	
	$cache = ExtMemcache::instance();
	$itemList = $cache->get("cheapShopList");
	foreach($itemId as $key => $value){
		if($value){
			$itemArr = array();
			$itemArr['itemID'] = intval($value);
			$itemArr['priceOld'] = intval($oldPrice[$key]);
			$itemArr['priceNew'] = intval($newPrice[$key]);
			$itemArr['cnt'] = intval($cnt[$key]);
			$itemArr['limitPerson'] = intval($buyNum[$key]);
			$itemArr['bind'] = intval($isbind[$key]);
			$itemArr['keepTime'] = intval($cheapShopShow['end_time']) - intval($cheapShopShow['start_time']);
			$itemArr['startTime'] = intval($cheapShopShow['start_time']);
			$cheapShopShow['data'][] = $itemArr;
		}
	}

	$cheapShopShow['content'] = json_encode($cheapShopShow['data']);
	$cheapShopShowTmp = $cheapShopShow;
	$cheapShopShowTmp['start_time'] = date('Y-m-d H:i:s', $cheapShopShowTmp['start_time'] );
	$cheapShopShowTmp['end_time'] = date('Y-m-d H:i:s', $cheapShopShowTmp['end_time'] );
	$smarty->assign('cheapShopShow', $cheapShopShowTmp);
	$smarty->assign('existID', $existID);
	unset($cheapShopShow['data']);
	if(!$inValid)
	{
		if($id){
			$cheapShopShow['id'] = $id;
			$sql = makeUpdateSqlFromArray($cheapShopShow, T_CHEAP_SHOP);
		}else{
			$sql = makeInsertSqlFromArray($cheapShopShow, T_CHEAP_SHOP);
		}
		GQuery($sql);
	}else{
		$msg[] = "日期和其它配置(#$existID)重叠，请重设！";
	}
	
}else if("new" == $action){//新增促销
	$cheapShopShow['date_type'] = 0;
    $cheapShopShow['data'][] = array('bind' => 1);
    $action = "set";
    $smarty->assign('action', $action);
    $smarty->assign('cheapShopShow', $cheapShopShow);
}else if("del" == $action){//删除促销
    $id = intval($_GET['id']);
    $sql = "delete from ".T_CHEAP_SHOP." where id={$id}";
    GQuery($sql);
}else if("sendthis" == $action){//发送促销
    $id = intval($_GET['id']);
	
	// 获取所选的配置信息
	$sql = "SELECT * FROM " . T_CHEAP_SHOP . ' WHERE id = ' . $id;
	$profile = GFetchRowOne($sql);
	if(isset($profile['id']) && Validator::stringNotEmpty($profile['content']))
	{
		$params = json_decode($profile['content'], true);
		foreach ($params as &$param)
		{					
			if($profile['date_type'] == 0)
			{// 确切日期
				$param['startTime'] = $profile['start_time'];
				$param['keepTime']	= $profile['end_time'] - $profile['start_time'];
			}
			else
			{// 按开服日期
				$param['startTime'] = $profile['start_open_day_time'] + strtotime(ONLINEDATE);
				$param['keepTime']	= $profile['end_open_day_time'] - $profile['start_open_day_time'];
			}
		}
		
		$ret = interfaceRequest('setcheapshop', array('cheapshop' => json_encode($params), 'type' => 1 ));
		
		if($ret['result'] == 1)
		{
			// 删除旧的缓存
			$cache = ExtMemcache::instance();
			$cache->delete('shopInfo');
			
			// 把当前进行的配置改成已结束
			$sql = "UPDATE ".T_CHEAP_SHOP." SET status = 2 WHERE status = 1";
			GQuery($sql);
			
			// 更新当前配置状态为进行中
			$sql = "UPDATE ".T_CHEAP_SHOP." SET status = 1 WHERE id = " . $id;
			GQuery($sql);
			
		}
	}
	
}else if("getItemPrice" == $action){//获取商城物品的原价
    $cache = ExtMemcache::instance();
    $itemList = $cache->get("shopList");
    $itemId = intval($_GET['item_id']);
    $oldPrice = $itemList[$itemId]['oldPrice'];
    if($oldPrice){
        $return = array("result" => 1, "oldPrice" => $oldPrice);
    }else{
        $return = array("result" => 0);
    }
    echo json_encode($return);
    exit();
}

$api = "getcheapshop";
//$httpResult = interfaceRequest($api, array());
//dump($httpResult);
$cheapShopInfo = getCheapShopInfo();

if(1 == $cheapShopInfo['result']){
    $cheapShopList = $cheapShopInfo['config'];
  
    $cache = ExtMemcache::instance();
    $cache->set("shopList", $cheapShopList, true, MEMCACHE_COMPRESS, 3600);
    /*不需要CheapShopConfig的物品
    foreach($cheapShopList as $k => $v){
        $itemList[$v['itemID']] = $arrItemsAll[$v['itemID']]['name'];
    }*/
    if("now" == $action){
    	$cheapShopInfo = getCheapShopInfo(true);
        $cheapShopNow = $cheapShopInfo['mem'];
        $cheapShopList = array();
	//	dump($cheapShopInfo);
        foreach($cheapShopNow as $key => $value){
			if(is_array($value)){
				$value['endTime'] = date("Y-m-d H:i:s", $value['startTime'] + $value['keepTime']);
				$value['startTime'] = date("Y-m-d H:i:s", $value['startTime']);
				$value['startTime'] = $value['startTime'];
				$cheapShopList['data'][] = $value;
			}
        }
        $cheapShopList['start_time'] = $value['startTime'];
        $cheapShopList['end_time'] = $value['endTime'];
        $action = "setOnlineCheapShop";
        $smarty->assign('action', $action);
        $smarty->assign('cheapShopShow', $cheapShopList);
    }
}else{
    $msg[] = $lang->page->errorReason.":".$cheapShopInfo['errorMsg'];
}

foreach ($arrItemsAll as $key => $value){
    $itemList[$key] = $value['name'];
}

$smarty->assign('itemList', $itemList);

$sql = "select * from ".T_CHEAP_SHOP." order by end_time desc,id desc";
$cheapShopList = GFetchRowSet($sql);

foreach($cheapShopList as $key => &$value){
    $value['content'] = json_decode($value['content'], true);
 
	
	if($value['date_type'] == 1){
		list($value['start_open_day'], $value['start_open_hour'], $value['start_open_minute']) = Datatime::timestampToDayHourMinute($value['start_open_day_time']);
		list($value['end_open_day'], $value['end_open_hour'], $value['end_open_minute']) = Datatime::timestampToDayHourMinute($value['end_open_day_time']);
		$endTime = $value['end_open_day_time'] + strtotime(ONLINEDATE);
		$value['start_date'] = date('Y-m-d, H:i:s', $value['start_open_day_time'] + strtotime(ONLINEDATE));
		$value['end_date'] = date('Y-m-d, H:i:s', $value['end_open_day_time'] + strtotime(ONLINEDATE));
	}else{
		$value['start_date'] = date('Y-m-d, H:i:s', $value['start_time']);
		$value['end_date'] = date('Y-m-d, H:i:s', $value['end_time']);
		$endTime = $value['end_time'];
	}
	$value['actualEndtime'] = $endTime;
	$value['isTimeOut'] = $endTime < NOW_TIMESTAMP ? 1 : 0;
}

$cheapShopList = sortArrayByKey($cheapShopList, 'actualEndtime', 'asc');

$smarty->assign('lang', $lang);
$smarty->assign('msg', $msg);
$smarty->assign('activityType', $activityType);
$smarty->assign('onlineDateTimestamp', strtotime(ONLINEDATE));
$smarty->assign('arrItemsAll', $arrItemsAll);
$smarty->assign('cheapShopList', $cheapShopList);
$smarty->display('module/basedataconfig/cheap_shop.tpl');

function getCheapShopInfo( $forceRemote = false )
{
	$api = 'getcheapshop';
	$cacheKey = 'shopInfo';
	$cache = ExtMemcache::instance();
		
	if( $forceRemote )
	{
		$cache->delete($cacheKey);
	}
	
	$cheapShopInfo = $cache->get($cacheKey);

	if ( !$cheapShopInfo )
	{// 缓存不存在，从远程获取
		
		$ret = interfaceRequest($api, array('type' => 1));
		$cheapShopInfo = array();
		if( $ret['result'] == 1 )
		{
			$cheapShopInfo = $ret;
		}
		$cache->set($cacheKey, $cheapShopInfo, true, MEMCACHE_COMPRESSED, 300);
			
	}
		
	return $cheapShopInfo;
}

function checkDateValid($startTime, $endTime, $type = 0, $id = null)
{
	$excludeCondition = '';
	$return = 0;
	$onlineDateTimestamp = strtotime(ONLINEDATE);
	if ($id != null)
	{
		$excludeCondition = ' AND id <> ' . $id;
	}
	if($type == 0)
	{
		$startOpenDayTime = $startTime - $onlineDateTimestamp;
		$endOpenDayTime = $endTime - $onlineDateTimestamp;
	}else{
		$startOpenDayTime = $startTime;
		$endOpenDayTime = $endTime;
		
		$startTime = $startTime + $onlineDateTimestamp;
		$endTime = $endTime + $onlineDateTimestamp;
	}
	
	$sql = 'SELECT id FROM ' . T_CHEAP_SHOP . " WHERE date_type = 0 AND ( (start_time > $startTime AND start_time < $endTime) OR (end_time > $startTime AND end_time < $endTime ) OR (start_time < $startTime AND end_time > $endTime ) )" . $excludeCondition . ' LIMIT 1';
	$result = GFetchRowOne($sql);
	if($result['id'] > 0){// 与确切时间类型重叠
		$return = $result['id'];
	}else{// 与开服时间类型重叠
		$sql = 'SELECT id FROM ' . T_CHEAP_SHOP . " WHERE date_type = 1 AND ( (start_open_day_time > $startOpenDayTime AND start_open_day_time < $endOpenDayTime) OR (end_open_day_time > $startOpenDayTime AND end_open_day_time < $endOpenDayTime ) OR (start_open_day_time < $startOpenDayTime AND end_open_day_time > $endOpenDayTime ) )" . $excludeCondition . ' LIMIT 1';
		$result = GFetchRowOne($sql);
		if($result['id'] > 0){
			$return = $result['id'];
		}
	}
	return $return;
}
