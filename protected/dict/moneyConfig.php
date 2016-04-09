<?php
//银两消费类型配置
//格式 id=>内容
include_once("opTypeConfig.php");
global $dictOperation,$dictCurrency;

$moneyType = array();

foreach($dictOperation as $k => $v){
	$key = intval($k);
	$moneyType[$key+$dictCurrency['money']] = $v ;
}
