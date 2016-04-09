<?php
//仙石消费类型配置
//格式 id=>内容
include_once("opTypeConfig.php");
global $dictOperation,$dictCurrency;

$goldType = array();

foreach($dictOperation as $k => $v){
	$key = intval($k);
	$goldType[$key+$dictCurrency['gold']] = $v ;
}

