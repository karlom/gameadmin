<?php
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
global $lang;

$action = $_GET['action'];
$id = $_GET['id'];
//dump($_POST);exit();
if ( $action == 'add' || $action == 'update' ) {
	$data['type'] = 'collect';
	$data['name'] = SS($_POST['activity_title']);
	$data['desc'] = SS($_POST['activity_text']);
	
	if ( $_POST['v_time_state'] == '0' ){
		$data['showTimeBegin'] = SS($_POST['v_start_time']);
		$data['showTimeEnd'] = SS($_POST['v_end_time']);
		$data['fromOnlineDate'] = 0;
	} else {
		$data['showTimeBegin'] = $_POST['v_start_open_day'] . '-' . $_POST['v_start_open_time'];
		$data['showTimeEnd'] = $_POST['v_end_open_day'] . '-' . $_POST['v_end_open_time'];
		$data['fromOnlineDate'] = 1;
	}
	
	if ( $_POST['a_time_state'] == '0' ){
		$data['actBegin'] = SS($_POST['a_start_time']);
		$data['actEnd'] = SS($_POST['a_end_time']);
		$data['fromOnlineDate'] = 0;
	} else {
		$data['actBegin'] = $_POST['a_start_open_day'] . '-' . $_POST['a_start_open_time'];
		$data['actEnd'] = $_POST['a_end_open_day'] . '-' . $_POST['a_end_open_time'];
		$data['fromOnlineDate'] = 1;
	}
	
	if ( $_POST['r_time_state'] == '0' ){
		$data['timeAwardBegin'] = SS($_POST['r_start_time']);
		$data['timeAwardEnd'] = SS($_POST['r_end_time']);
		$data['fromOnlineDate'] = 0;
	} else {
		$data['timeAwardBegin'] = $_POST['r_start_open_day'] . '-' . $_POST['r_start_open_time'];
		$data['timeAwardEnd'] = $_POST['r_end_open_day'] . '-' . $_POST['r_end_open_time'];
		$data['fromOnlineDate'] = 1;
	}
	
	$data['awardType'] = SS(intval($_POST['awardType']));
	$data['cmd'] =  SS($_POST['subActivity']);
	$data['arg'] = '';
	$data['conditionAward'] = json_encode($_POST['prizes']);
	 
	if ( $action == 'add' ){
		$sql = getInsertSQL($data, T_ACTIVITY);
	} elseif ( $action == 'update' ) {
		$data['id'] = SS($_GET['id']);
		$sql = makeUpdateSqlFromArray($data, T_ACTIVITY);
	};
	
	GQuery($sql);
	updateAct();
} elseif ( $action == 'cancel' ) {
	$id = SS($_GET['id']);
	$arr = array(
		'id' => $id,
		'state' => '1',
	);
	$sql = makeUpdateSqlFromArray($arr, T_ACTIVITY);
	GQuery($sql);
	$updateMsg = $lang->activity->canceled;
	updateAct();
} else {
	$check = array();
	$checkSQL = "SELECT * FROM t_activity WHERE state=0 AND type='collect'";
	$check = GFetchRowSet($checkSQL);
	foreach ($check as $value){
		if ( $value['fromOnlineDate'] == '1' ){
			if ( strtotime(transDateForm($value['showTimeEnd'])) < time() ){
				$arr = array(
					'id' => $value['id'],
					'state' => '1',
				);
				$sql = makeUpdateSqlFromArray($arr, T_ACTIVITY);
				GQuery($sql);
			}
		} else {
			if ( strtotime($value['showTimeEnd']) < time() ){
				$arr = array(
					'id' => $value['id'],
					'state' => '1',
				);
				$sql = makeUpdateSqlFromArray($arr, T_ACTIVITY);
				GQuery($sql);
			}
			
		};
	}
}

// activity on live;
$live = array();
$liveSQL = "SELECT * FROM t_activity WHERE state=0 AND type='collect'";
$live = GFetchRowSet($liveSQL);

// activity history;
$history = array();
$historySQL = "SELECT * FROM t_activity WHERE state=1 AND type='collect'";
$history = GFetchRowSet($historySQL);


$rs = array(
	'lang' => $lang, 
	'live' => $live,
	'history' => $history,
	'updateMsg' => $updateMsg,
);

$smarty -> assign($rs);
$smarty -> display('module/activity/collectEdit.tpl');

function updateAct_deceprated(){
	$method = 'setactivity';
	$liveSQL = 'SELECT * FROM t_activity WHERE state=0';
	$live = GFetchRowSet($liveSQL);

	if (!empty($live)){
		for ( $i=0; $i<count($live); $i++) {
			$arr[$i]['id'] = intval($live[$i]['id']);
			$arr[$i]['name'] = urlencode($live[$i]['name']);
			$arr[$i]['desc'] = urlencode($live[$i]['desc']);
			$arr[$i]['awardType'] = intval($live[$i]['awardType']);
			$arr[$i]['cmd'] = $live[$i]['cmd'];
			
			if ( $live[$i]['fromOnlineDate'] == '1' ){
				$live[$i]['showTimeBegin'] = transDateForm($live[$i]['showTimeBegin']);
				$live[$i]['showTimeEnd'] = transDateForm($live[$i]['showTimeEnd']);
				$live[$i]['actBegin'] = transDateForm($live[$i]['actBegin']);
				$live[$i]['actEnd'] = transDateForm($live[$i]['actEnd']);
				$live[$i]['timeAwardBegin'] = transDateForm($live[$i]['timeAwardBegin']);
				$live[$i]['timeAwardEnd'] = transDateForm($live[$i]['timeAwardEnd']);
			}
			
			$showB = explode(' ', $live[$i]['showTimeBegin']);
			list($arr[$i]['actShowTimeBegin']['year'], $arr[$i]['actShowTimeBegin']['month'], $arr[$i]['actShowTimeBegin']['day']) = explode('-', $showB[0]);
			list($arr[$i]['actShowTimeBegin']['hour'], $arr[$i]['actShowTimeBegin']['min'], $arr[$i]['actShowTimeBegin']['sec']) = explode(':', $showB[1]);
			$showE = explode(' ', $live[$i]['showTimeEnd']);
			list($arr[$i]['actShowTimeEnd']['year'], $arr[$i]['actShowTimeEnd']['month'], $arr[$i]['actShowTimeEnd']['day']) = explode('-', $showE[0]);
			list($arr[$i]['actShowTimeEnd']['hour'], $arr[$i]['actShowTimeEnd']['min'], $arr[$i]['actShowTimeEnd']['sec']) = explode(':', $showE[1]);
			
			$actB = explode(' ', $live[$i]['actBegin']);
			list($arr[$i]['actBegin']['year'], $arr[$i]['actBegin']['month'], $arr[$i]['actBegin']['day']) = explode('-', $actB[0]);
			list($arr[$i]['actBegin']['hour'], $arr[$i]['actBegin']['min'], $arr[$i]['actBegin']['sec']) = explode(':', $actB[1]);
			$actE = explode(' ', $live[$i]['actEnd']);
			list($arr[$i]['actEnd']['year'], $arr[$i]['actEnd']['month'], $arr[$i]['actEnd']['day']) = explode('-', $actE[0]);
			list($arr[$i]['actEnd']['hour'], $arr[$i]['actEnd']['min'], $arr[$i]['actEnd']['sec']) = explode(':', $actE[1]);
			
			$awardB = explode(' ', $live[$i]['timeAwardBegin']);
			list($arr[$i]['timeAwardBegin']['year'], $arr[$i]['timeAwardBegin']['month'], $arr[$i]['timeAwardBegin']['day']) = explode('-', $awardB[0]);
			list($arr[$i]['timeAwardBegin']['hour'], $arr[$i]['timeAwardBegin']['min'], $arr[$i]['timeAwardBegin']['sec']) = explode(':', $awardB[1]);
			$awardE = explode(' ', $live[$i]['timeAwardEnd']);
			list($arr[$i]['timeAwardEnd']['year'], $arr[$i]['timeAwardEnd']['month'], $arr[$i]['timeAwardEnd']['day']) = explode('-', $awardE[0]);
			list($arr[$i]['timeAwardEnd']['hour'], $arr[$i]['timeAwardEnd']['min'], $arr[$i]['timeAwardEnd']['sec']) = explode(':', $awardE[1]);
			
			$arr[$i]['actBegin'] = array_map('intval', $arr[$i]['actBegin']);
			$arr[$i]['actEnd'] = array_map('intval', $arr[$i]['actEnd']);
			$arr[$i]['actShowTimeBegin'] = array_map('intval', $arr[$i]['actShowTimeBegin']);
			$arr[$i]['actShowTimeEnd'] = array_map('intval', $arr[$i]['actShowTimeEnd']);
			$arr[$i]['timeAwardBegin'] = array_map('intval', $arr[$i]['timeAwardBegin']);
			$arr[$i]['timeAwardEnd'] = array_map('intval', $arr[$i]['timeAwardEnd']);
			
			$arr[$i]['arg'] = array();
	
			$prizes = json_decode($live[$i]['conditionAward'],true);
		//	dump($prizes);
			$cup = array();
			for($j=0; $j<count($prizes); $j++){
				$prizes[$j]['items'] = changeArrayBase($prizes[$j]['items'], 1);
				if ($live[$i]['type'] == 'rank'){
					$prizes[$j]['items'][0]= array($prizes[$j]['startLevel'],$prizes[$j]['endLevel']);
				} elseif ($live[$i]['type'] == 'collect'){
					
					if($live[$i]['cmd'] == 'collect_item')
					{
						$itemList = array();
						foreach( $prizes[$j]['items'] as $item )
						{
							$itemList[] = array_values($item);
						}

						$conditionList = array();
						foreach($prizes[$j]['collectEquip'] as $equipKey => $equip)
						{
							$condition = array();
							$condition[1] = $equip;
							$condition[2] = $prizes[$j]['collectNum'][$equipKey ];
							$condition[3] = $prizes[$j]['collectRecycle'][$equipKey ];
							$conditionList[] = $condition;
						}
					//	$prizes[$j]['items'][0]= array($prizes[$j]['collectEquip'],$prizes[$j]['collectNum'], $prizes[$j]['collectRecycle']);
						$prizes[$j]['items'] = array();
						$prizes[$j]['items'][1] = $conditionList;
						$prizes[$j]['items'][2] = $itemList;
					}
					else
					{
						$prizes[$j]['items'][0]= array($prizes[$j]['collectEquip'][0],$prizes[$j]['collectNum'][0]);
					}
					

					
				} elseif ($live[$i]['type'] == 'charge'){
					$prizes[$j]['items'][0]= array($prizes[$j]['startLevel'], $prizes[$j]['endLevel']);
				};

				array_push($cup, $prizes[$j]['items']);

			};

			$arr[$i]['conditionAward'] = $cup;
			for($k=0; $k<count($cup); $k++){
				ksort($cup[$k]);
			};
			$cup = array_values($cup);

			for($m=0; $m<count($cup); $m++){
				$cup[$m] = array_values($cup[$m]);
				for($n=0; $n<count($cup[$m]); $n++){
					$cup[$m][$n] = array_values($cup[$m][$n]);	
				}
			};
	//		
			$arr[$i]['conditionAward'] = $cup;
		}
		for($i=0; $i<count($arr); $i++){
			for($j=0; $j<count($arr[$i]['conditionAward']); $j++){
				for($k=0; $k<count($arr[$i]['conditionAward'][$j]); $k++){
					for($m=0; $m<count($arr[$i]['conditionAward'][$j][$k]); $m++){
						convertToInt($arr[$i]['conditionAward'][$j][$k]);
					};
				};
			};
		};
		for ($i=0; $i<count($arr); $i++){
			$key = $arr[$i]['id'];
			$rs[$key] = $arr[$i];
			unset($rs[$key]['id']);
		}
		$rs = json_encode($rs);
		$rs = urldecode($rs);
		$param['ActsConfig'] = $rs;
	} else {
		$param['ActsConfig'] = '';
	};
//	dump($param['ActsConfig'][97]);
//	dump($param['ActsConfig'][98]);
	$result = interfaceRequest($method, $param);
}

function transDateForm_deceprated($a){
	$tmp = explode('-', $a);
	$tmp[0] = date('Y-m-d', strtotime("+$tmp[0] day", strtotime(ONLINEDATE)));
	$result = implode(' ', $tmp);
	return $result;
}

function convertToInt_deceprated( &$array )
{
	foreach( $array as &$item )
	{
		if( is_array( $item ) )
		{
			convertToInt( $item );
		}
		else
		{
			$item = intval( $item );
		}
	}
}
