<?php
include_once SYSDIR_ADMIN_CONFIG . '/config.db.php';
include_once SYSDIR_ADMIN_INCLUDE."/db_defines.php";
include_once SYSDIR_ADMIN_CLASS."/mysql.class.php";
include_once SYSDIR_ADMIN_CLASS."/infobright.class.php";
include_once SYSDIR_ADMIN_INCLUDE."/functions.php";
include_once SYSDIR_ADMIN_INCLUDE."/db_functions.php";

global  $db_infobright, $db_mysql;
// global  $db_mysql;
//时间设置
date_default_timezone_set('PRC');

//初始化管理后台数据库连接(mysql)
//if(!$db_admin) {
//	$db_admin =  new DBMysqlClass();
//	$db_admin->connect($dbConfig['game_admin']);
//}

//初始化游戏数据库连接(mysql)
//if(!$db_game) {
//	$db_game =  new DBMysqlClass();
//	$db_game->connect($dbConfig['game']);
//}

//初始化游戏数据2库连接(mysql)
//if(!$db_game_world) {
//	$db_game_world =  new DBMysqlClass();
//	$db_game_world->connect($dbConfig['gameWorld']);
//}