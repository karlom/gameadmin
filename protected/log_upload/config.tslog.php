<?php
/**
 * ts_log_config.php
 * 天神日志上报相关配置
 */
 
include_once '../config/config.php';

if(PROXYID == 1){
	//腾讯
	define("TS_LOG_PORT","29999");
	define("CENTER_IP","10.207.152.128");	//中央机
} else {
	define("TS_LOG_PORT","8008");
	define("CENTER_IP","s0.app100724642.twsapp.com");	//中央机
}

define("TS_GAME_ID","18");
define("TS_LOG_SCRIPT","transfer.php");
define("TS_LOG_URL","http://".CENTER_IP.":".TS_LOG_PORT."/".TS_LOG_SCRIPT);
define("TS_LOG_DIR","/data/logs/ts_log");
define("TS_LOG_START_DATE","2014-01-01 00:00:00");	//数据开始上传日期
 
$dictTsPlatform = array(
	'tx' => "1201",	//tencent
	'pengyou' => "1202",
	'qzone' => "1203",
	'qqgame' => "1204",
	'3366' => "1205",
	'qplus' => "1206",
	'website' => "1207",
	'union' => "1208",
	'union-10029-2' => "1209",	//iwan
//	'tapp' => 3,
//	'qzone_m' => 8,
//	'pengyou_m' => 9,
//	'box' => 23,
);

//充值面板 仙石购买
$dictXianshi = array(
	10030 => array (
		'id' => '10030',
		'name' => '50颗仙石',
		'count' => '50',
		),
	10033 => array (
		'id' => '10033',
		'name' => '10颗仙石',
		'count' => '10',
		),
	10034 => array (
		'id' => '10034',
		'name' => '1000颗仙石',
		'count' => '1000',
		),
	11039 => array (
		'id' => '11039',
		'name' => '500颗仙石',
		'count' => '500',
		),
	11040 => array (
		'id' => '11040',
		'name' => '5000颗仙石',
		'count' => '5000',
		),
	11041 => array (
		'id' => '11041',
		'name' => '20000颗仙石',
		'count' => '20000',
		),
	11042 => array (
		'id' => '11042',
		'name' => '5颗仙石',
		'count' => '5',
		),
);