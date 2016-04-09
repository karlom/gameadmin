<?php

//====以下配置主要是用于游戏管理后台与游戏服之间的即时交互，请按照以下格式配置:===//
//10玩家相关接口
//20消息、广播模块相关接口
//define('ADMIN_SET_XXX',10XX);//XXX

define('ADMIN_GET_PLAYER_INFO',1001); //实时获取玩家信息
define('ADMIN_SET_PLAYER_OFF_LINE',1002); //把玩家踢下线
define('ADMIN_SEND_PLAYER_TO_PEACE_VILLAGE',1003); //把玩家送回新手村
define('ADMIN_SET_PLAYER_SHOP_OFF_LINE',1004); //把玩家的摊位撤掉
define('ADMIN_GET_PLAYER_GOODS',1005); //实时获取玩家道具列表
define('ADMIN_GET_PLAYER_BUFFERS',1006); //实时获取玩家buffer列表
define('ADMIN_CREATE_GM_PLAYER',1007); //创建GM游戏帐号
define('ADMIN_SET_PLAYER_TITLE',1008); //给玩家加自定义称号
define('ADMIN_SEND_GOLD_TO_PLAYER',1009); //给玩家发仙石
define('ADMIN_SEND_SILVER_TO_PLAYER',1010); //给玩家发银两
define('ADMIN_REWRITE_IP_BAN_LIST',1011); //重写IP封禁列表缓存
define('ADMIN_REWRITE_ACCOUNT_BAN_LIST',1012); //重写帐号封禁列表缓存
define('ADMIN_GET_PLAYER_ONLINE_STATUS',1013); //查看用户在线状态：在线或离线
//define('ADMIN_GET_ONLINE_LIST',1014); //实时获取在线玩家列表信息
//define('ADMIN_GET_ONLINE_COUNT',1015); //实时当前在线人数
//define('ADMIN_GET_USER_STATUS',1016); //实时获取玩家状态信息

define('ADMIN_SEND_INSTANT_MSG',1014); //发送即时广播消息
define('ADMIN_UPDATE_LOOP_MSG',1015); //同步循环广播消息列表
define('ADMIN_BAN_CHAT',1016); //设置玩家 禁言
define('ADMIN_UNBAN_CHAT',1017); //解除玩家 禁言
define('ADMIN_SEND_LETTER',1018); //管理后台发送信件接口
define('ADMIN_DEL_LOOP_MSG',1019); //删除循环广播消息列表
define('ADMIN_SET_ALL_PLAYER_OFF_LINE',1021); //把所有玩家踢下线接口
define('ADMIN_DEL_CONDITION_EMAIL',1022); //删除批量信件接口
define('ADMIN_GET_PLAYER_PARAMS',1023); //获取用户相关参数(封铁塔次数\幸运值\连续登录天数\精力值等等..)
define('ADMIN_SET_PLAYER_PARAMS',1024); //设置用户相关参数(封铁塔次数\幸运值\连续登录天数\精力值等等..)
define('ADMIN_SET_FAMILY_LEADER',1025); //设为族长
define('ADMIN_SET_TD_SWITCH', 1026);//设置TD开关

define('GAME_SERVER_PAY_INTERFACE_ID',1033); //玩家充值
define('ADMIN_GET_FCMSTATUS', 1040);//获取防沉迷状态
define('ADMIN_SET_FCMSTATUS', 1041);//设置防沉迷状态
define('ADMIN_SET_DOUBLE_EXP', 1042);//设置多倍经验时间
define('ADMIN_SET_LOGIN_REWARD_NOTE', 1044);//设置连续登录公告
define('ADMIN_GET_LOGIN_REWARD_NOTE', 1043);//获取连续登录公告
define('ADMIN_GET_TITLE', 1045);//获取称号
define('ADMIN_SET_TITLE', 1046);//设置称号
define('ADMIN_SET_BOSS_GROUP', 1047);//设置boss群
define('ADMIN_GET_PLAYER_INFOMATION', 1048);//获取玩家信息
define('ADMIN_GET_RACE_SWITCH', 1049);//获取赛马活动开关
define('ADMIN_SET_RACE_SWITCH', 1050);//设置赛马活动开关
define('ADMIN_GET_TOWER_SWITCH', 1051);//获取铁塔活动开关
define('ADMIN_SET_TOWER_SWITCH', 1052);//设置铁塔活动开关

