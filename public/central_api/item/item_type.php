<?php
/**
*	Description:返回所有的道具ID配置数组
*/

// include dirname(dirname(__FILE__)).'/central_api_auth.php';

include dirname(dirname(dirname(dirname(__FILE__)))).'/protected/dict/opTypeConfig.php';
$item_type = array();
foreach ($dictOperation as $key => $value) {
	if(intval($key)<10){
		$itemid = '00'.$key;
	}elseif (intval($key)<100 and intval($key)>=10) {
		$itemid = '0'.$key;
	}else{
		$itemid = $key;
	}
	$types = array(
		'item_id' => '20'.$itemid,
		'item_name' => $value 
		);
	array_push($item_type, $types);
}

echo(json_encode($item_type));
