<?php
define(ADMIN_ACCESS_PAGE, 0);
define(ADMIN_ACCESS_ITEM, 1);
define(ADMIN_ACCESS_MISC, 2);

//对于所有已登录用户都有权访问的页面:
global $ADMIN_LOGIN_USER_ACCESS;
$ADMIN_LOGIN_USER_ACCESS = array(
	SYSDIR_ADMIN_PUBLIC.'/module/index.php',
	SYSDIR_ADMIN_PUBLIC.'/module/top.php',
	SYSDIR_ADMIN_PUBLIC.'/module/left.php',
	SYSDIR_ADMIN_PUBLIC.'/module/proxy.php',
	SYSDIR_ADMIN_PUBLIC.'/module/main.php',
	SYSDIR_ADMIN_PUBLIC.'/module/getMenuUrl.php',
	SYSDIR_ADMIN_PUBLIC.'/module/tabs.php',
);
/**
 * 注意！
 * 这个数组的各项的index，有非常严格的规定，不清楚的人，绝对不允许修改这个数组$ADMIN_PAGE_CONFIG
 * name:菜单名
 * class:所属类别
 * url:所对应的地址（system类的地址属于公共版本）
 * ver:功能所对应的版本（不针对特定版本可以不填）
 * interface:接口模式，目前可选值为：file,http,socket,mq
 * hide:如果值为真就说明这个菜单项不显示，可用于ajax之类的功能，如果没有这个需要的话可发不填
 * DEMO:
 * 19   => array('name'=>$lang->menu->onlineHitory,            'class'=>$lang->menu->class->onlineAndReg,			'url'=>'online/history_online.php',	 'interface'=>'file'), //表示此菜单项正常显示
 * 19   => array('name'=>$lang->menu->onlineHitory,            'class'=>$lang->menu->class->onlineAndReg,			'url'=>'online/history_online.php',	'interface'=>'file',	'hide'=>true), //表示此项不需要显示在左侧菜单中，但需要作为权限项配置，如一些ajax服务
 */
global $ADMIN_PAGE_CONFIG;
$ADMIN_PAGE_CONFIG = array(
	
	//数据警报 
	1 => array('name'=>$lang->menu->currencyAlert,               'class'=>$lang->menu->class->dataAlert,        'url'=>'monitor/currency_alert.php'),
	2 => array('name'=>$lang->menu->gmCode,                      'class'=>$lang->menu->class->dataAlert,        'url'=>'monitor/gm_code_log.php'),
	//在线与注册 
	3 => array('name'=>$lang->menu->onlineUser,                  'class'=>$lang->menu->class->onlineAndReg,     'url'=>'player/online_user.php'),
	4 => array('name'=>$lang->menu->onlineCharts,                'class'=>$lang->menu->class->onlineAndReg,     'url'=>'online/online_charts.php'),
	5 => array('name'=>$lang->menu->checkOnline,                 'class'=>$lang->menu->class->onlineAndReg,     'url'=>'online/online.php'),
	6 => array('name'=>$lang->menu->playerStay,                  'class'=>$lang->menu->class->onlineAndReg,     'url'=>'player/player_stay_rate.php', ),
	7 => array('name'=>$lang->menu->allPlayer,                   'class'=>$lang->menu->class->onlineAndReg,     'url'=>'player/all_player_view.php'),
	8 => array('name'=>$lang->menu->registerAnalyseByHour,       'class'=>$lang->menu->class->onlineAndReg,     'url'=>'online/register_analyse_by_hour.php'),
	9 => array('name'=>$lang->menu->createRoleLoseRate,          'class'=>$lang->menu->class->onlineAndReg,     'url'=>'basedata/create_role_lose_rate.php'),
	10 => array('name'=>$lang->menu->levelLoseRate,              'class'=>$lang->menu->class->onlineAndReg,     'url'=>'basedata/level_lose_rate.php'),
	11 => array('name'=>$lang->menu->taskLoseRate,               'class'=>$lang->menu->class->onlineAndReg,     'url'=>'basedata/task_lose_rate.php'),
	124 => array('name'=>$lang->menu->registerFrom,              'class'=>$lang->menu->class->onlineAndReg,     'url'=>'basedata/register_from.php'),
    139 => array('name'=>$lang->menu->weiduanPlayerRate,         'class'=>$lang->menu->class->onlineAndReg,     'url'=>'basedata/weiduan_player_rate.php'),
    141 => array('name'=>$lang->menu->unionRegisterWays,         'class'=>$lang->menu->class->onlineAndReg,     'url'=>'basedata/union_register_ways.php'),
	//充值与消费 
	12 => array('name'=>$lang->menu->survey,                     'class'=>$lang->menu->class->payAndSpand,       'url'=>'pay/survey.php'),
	13 => array('name'=>$lang->menu->goldUserAnalyse,            'class'=>$lang->menu->class->payAndSpand,       'url'=>'gold/usage_statistics.php'),
	14 => array('name'=>$lang->menu->goldConsumeSort,            'class'=>$lang->menu->class->payAndSpand,       'url'=>'player/gold_consume_sort.php'),
	15 => array('name'=>$lang->menu->firstGoldUseStatistics,     'class'=>$lang->menu->class->payAndSpand,       'url'=>'gold/first_use_statistics.php'),
	16 => array('name'=>$lang->menu->goldUseRecord,      		 'class'=>$lang->menu->class->payAndSpand,       'url'=>'gold/gold_use_record.php'),
	72 => array('name'=>$lang->menu->yellowDiamondOpen,      	 'class'=>$lang->menu->class->payAndSpand,       'url'=>'pay/yellow_diamond.php'),
    142 => array('name'=>$lang->menu->blueDiamondOpen,      	 'class'=>$lang->menu->class->payAndSpand,       'url'=>'pay/blue_diamond.php'),
	73 => array('name'=>$lang->menu->qdBuyGoods,      		 	 'class'=>$lang->menu->class->payAndSpand,       'url'=>'pay/qb_buy_goods.php'),
	74 => array('name'=>$lang->menu->qdUseRank,      		 	 'class'=>$lang->menu->class->payAndSpand,       'url'=>'pay/qd_use_rank.php'),
	75 => array('name'=>$lang->menu->qdUseAnalyse,      		 'class'=>$lang->menu->class->payAndSpand,       'url'=>'pay/qd_use_analyse.php'),
	91 => array('name'=>$lang->menu->allServerPayData,      	 'class'=>$lang->menu->class->payAndSpand,       'url'=>'pay/all_server_pay.php'),
	92 => array('name'=>$lang->menu->qxian,     			 	 'class'=>$lang->menu->class->payAndSpand,       'url'=>'pay/qxian.php'),
	94 => array('name'=>$lang->menu->allServerItem,     		 'class'=>$lang->menu->class->payAndSpand,       'url'=>'gold/all_usage_statistics.php'),
	95 => array('name'=>$lang->menu->allServerItem2,     		 'class'=>$lang->menu->class->payAndSpand,       'url'=>'gold/all_usage2.php'),
	96 => array('name'=>$lang->menu->AllIncomeByHour,     		 'class'=>$lang->menu->class->payAndSpand,       'url'=>'gold/all_income_by_hour.php'),
	97 => array('name'=>$lang->menu->goldGetAnalyse,     		 'class'=>$lang->menu->class->payAndSpand,       'url'=>'gold/gold_get_statistics.php'),
	99 => array('name'=>$lang->menu->firstConsumptCount,     	 'class'=>$lang->menu->class->payAndSpand,       'url'=>'pay/first_consumpt_count.php'),
	107 => array('name'=>$lang->menu->qqgameSurvey,     	 'class'=>$lang->menu->class->payAndSpand,       'url'=>'pay/qqgame_survey.php'),
	109 => array('name'=>$lang->menu->payUserOpenid,     	 'class'=>$lang->menu->class->payAndSpand,       'url'=>'pay/pay_userid.php'),
    112=>array('name'=>$lang->menu-> singlePlayePay,              	'class'=>$lang->menu->class->payAndSpand,      'url'=>'pay/single_playe_pay.php'),
    134=>array('name'=>$lang->menu-> saleDay,              	'class'=>$lang->menu->class->payAndSpand,      'url'=>'pay/sale_day.php'),
    137=>array('name'=>$lang->menu->payLogs,              	'class'=>$lang->menu->class->payAndSpand,      'url'=>'pay/pay_log.php'),
    143=>array('name'=>$lang->menu->qingDian,              	'class'=>$lang->menu->class->payAndSpand,      'url'=>'pay/qing_dian.php'),
	//玩家信息管理 
	17 => array('name'=>$lang->menu->playerStatus,                'class'=>$lang->menu->class->userInfo,          'url'=>'player/player_status.php'),
	18 => array('name'=>$lang->menu->levelupHitory,               'class'=>$lang->menu->class->userInfo,          'url'=>'player/level_up.php'),
	19 => array('name'=>$lang->menu->playerDeal,                  'class'=>$lang->menu->class->userInfo,          'url'=>'player/player_deal.php'),
	20 => array('name'=>$lang->menu->loginManagement,             'class'=>$lang->menu->class->userInfo,          'url'=>'tabs.php?pid=20',  'menus' => array(21, 22, 23)),
	21 => array('name'=>$lang->menu->loginHistory,                'class'=>$lang->menu->class->userInfo,          'url'=>'player/login_history.php', 'hide'=>true),
	22 => array('name'=>$lang->menu->logoutHistory,               'class'=>$lang->menu->class->userInfo,          'url'=>'player/logout_history.php', 'hide'=>true),
	23 => array('name'=>$lang->menu->ipAnalyse,                   'class'=>$lang->menu->class->userInfo,          'url'=>'player/ip_analysis.php', 'hide'=>true),
	24 => array('name'=>$lang->menu->allRoleLog,                  'class'=>$lang->menu->class->userInfo,          'url'=>'player/all_player_logs.php'),
	25 => array('name'=>$lang->menu->roleLabel,                   'class'=>$lang->menu->class->userInfo,          'url'=>'basedata/role_label.php',  'hide'=>false),
	26 => array('name'=>$lang->menu->metierStat,                  'class'=>$lang->menu->class->userInfo,          'url'=>'player/player_career.php'),
	27 => array('name'=>$lang->menu->skillData,                   'class'=>$lang->menu->class->userInfo,          'url'=>'skill/skill_bar_data.php',  'hide'=>false),
	28 => array('name'=>$lang->menu->jingjie,                     'class'=>$lang->menu->class->userInfo,          'url'=>'jingjie/jingjie.php'),
	29 => array('name'=>$lang->menu->petData,                     'class'=>$lang->menu->class->userInfo,          'url'=>'pet/pet_data.php'),
	69 => array('name'=>$lang->menu->huoyuedu,                    'class'=>$lang->menu->class->userInfo,            'url'=>'basedata/huoyuedu.php'),
	81 => array('name'=>$lang->menu->talismanData,                'class'=>$lang->menu->class->userInfo,          'url'=>'basedata/talisman_data.php'),
	88 => array('name'=>$lang->menu->createGmRole,                'class'=>$lang->menu->class->userInfo,          'url'=>'player/create_gm_role.php'),
	90 => array('name'=>$lang->menu->userData,                'class'=>$lang->menu->class->userInfo,          'url'=>'player/user_data.php'),
	105 => array('name'=>$lang->menu->createGuideRole,                'class'=>$lang->menu->class->userInfo,          'url'=>'player/create_guide_role.php'),
	106 => array('name'=>$lang->menu->marry,                  'class'=>$lang->menu->class->userInfo,          'url'=>'player/marry.php'),
    121 => array('name'=>$lang->menu->userPvp,                      'class'=>$lang->menu->class->userInfo ,                 'url'=>'player/user_pvp.php'     ),
    138 => array('name'=>$lang->menu->roleName,                      'class'=>$lang->menu->class->userInfo ,                 'url'=>'player/role_name.php'     ),
	//经济系统 
	30 => array('name'=>$lang->menu->moneySaveAndConsume,         'class'=>$lang->menu->class->economySystem,         'url'=>'gold/save_and_consume.php'),
	31 => array('name'=>$lang->menu->moneyOutputAndUsage,         'class'=>$lang->menu->class->economySystem,         'url'=>'money/money_output_and_usage.php'),
	102 => array('name'=>$lang->menu->bindMoneyOutputAndUsage,        'class'=>$lang->menu->class->economySystem,         'url'=>'money/bind_money_output_and_usage.php'),
	32 => array('name'=>$lang->menu->lingqiOutputAndExpend,       'class'=>$lang->menu->class->economySystem,         'url'=>'lingqi/lingqi_output_and_expend.php'),
	33 => array('name'=>$lang->menu->marketBill,                  'class'=>$lang->menu->class->economySystem,         'url'=>'basedata/market_bill.php'),
	34 => array('name'=>$lang->menu->itemConsumeStatistics,       'class'=>$lang->menu->class->economySystem,         'url'=>'item/item_consume_statistics.php'),
	35 => array('name'=>$lang->menu->itemUseRecord,               'class'=>$lang->menu->class->economySystem,         'url'=>'item/item_use_record.php'),
	36 => array('name'=>$lang->menu->itemFollow,                  'class'=>$lang->menu->class->economySystem,         'url'=>'item/item_follow.php'),
	82 => array('name'=>$lang->menu->orangeEquipDropData,         'class'=>$lang->menu->class->economySystem,         'url'=>'item/orange_equip_drop.php'),
	89 => array('name'=>$lang->menu->npcSellItems,                'class'=>$lang->menu->class->economySystem,         'url'=>'item/npc_sell_items.php'),
	93 => array('name'=>$lang->menu->marketSellXianshi,           'class'=>$lang->menu->class->economySystem,         'url'=>'basedata/market_sell_xianshi.php'),
	104 => array('name'=>$lang->menu->mysticalShop,        		  'class'=>$lang->menu->class->economySystem,         'url'=>'item/mystical_shop.php'),
    140 => array('name'=>$lang->menu->goldDouble,        		  'class'=>$lang->menu->class->economySystem,         'url'=>'item/gold_double.php'),
    //合服活动
    128 => array('name' =>$lang->menu->qmkhActivity,              'class'=>$lang->menu->class->combineActivity,          'url'=>'combine/qmkh_activity.php'),
    129 => array('name' =>$lang->menu->czhkActivity,              'class'=>$lang->menu->class->combineActivity,          'url'=>'combine/czhk_activity.php'),
    130 => array('name' =>$lang->menu->xfdrActivity,              'class'=>$lang->menu->class->combineActivity,          'url'=>'combine/xfdr_activity.php'),
    131 => array('name' =>$lang->menu->zlwzActivity,              'class'=>$lang->menu->class->combineActivity,          'url'=>'combine/zlwz_activity.php'),
    132 => array('name' =>$lang->menu->qdscActivity,              'class'=>$lang->menu->class->combineActivity,          'url'=>'combine/qdsc_activity.php'),
	//活动管理 
	37 => array('name'=>$lang->menu->activitySwitch,              'class'=>$lang->menu->class->activityManage,    'url'=>'activity/activity_switch.php',  'hide'=>false),
	38 => array('name'=>$lang->menu->xianxiewending,              'class'=>$lang->menu->class->activityManage,    'url'=>'activity/xxwd_statistics.php',  'hide'=>false),
	39 => array('name'=>$lang->menu->bumieshilian,                'class'=>$lang->menu->class->activityManage,    'url'=>'activity/bmsl_statistics.php',  'hide'=>false),
	40 => array('name'=>$lang->menu->yijixunbao,                  'class'=>$lang->menu->class->activityManage,    'url'=>'activity/yjxb_statistics.php',  'hide'=>false),
	41 => array('name'=>$lang->menu->jinghuandongtian,            'class'=>$lang->menu->class->activityManage,    'url'=>'activity/jhdt_statistics.php',  'hide'=>false),
	42 => array('name'=>$lang->menu->mowubaodong,                 'class'=>$lang->menu->class->activityManage,    'url'=>'activity/mwbd_statistics.php',  'hide'=>false),
	43 => array('name'=>$lang->menu->tongjiling,                  'class'=>$lang->menu->class->activityManage,    'url'=>'activity/tjl_statistics.php',  'hide'=>false),
	110 => array('name'=>$lang->menu->zhumoweidao,                'class'=>$lang->menu->class->activityManage,    'url'=>'activity/zmwd_statistics.php',  'hide'=>false),
    122 => array('name'=>$lang->menu->fengshidigong,                'class'=>$lang->menu->class->activityManage,    'url'=>'activity/fsdg_statistics.php',  'hide'=>false),
    123 => array('name'=>$lang->menu->dengyuntai,                'class'=>$lang->menu->class->activityManage,    'url'=>'activity/dyt_statistics.php',  'hide'=>false),
		//基础数据、排行榜
	70 => array('name'=>$lang->menu->roleLevelRank,             'class'=>$lang->menu->class->rankData,      'url'=>'rank/role_level_rank.php'),
	71 => array('name'=>$lang->menu->roleJingjieRank,           'class'=>$lang->menu->class->rankData,      'url'=>'rank/jingjie_rank.php'),
	77 => array('name'=>$lang->menu->monsterKillRoleRank,       'class'=>$lang->menu->class->rankData,      'url'=>'rank/monster_kill_rank.php'),
	78 => array('name'=>$lang->menu->marketSellRank,            'class'=>$lang->menu->class->rankData,      'url'=>'tabs.php?pid=78',	'menus' => array( 79, 80,), ),
	79 => array('name'=>$lang->menu->marketSellXianshiRank,     'class'=>$lang->menu->class->rankData,      'url'=>'rank/market_sell_xianshi_rank.php',  'hide'=>true),
	80 => array('name'=>$lang->menu->marketSellMoneyRank,       'class'=>$lang->menu->class->rankData,      'url'=>'rank/market_sell_money_rank.php',  'hide'=>true),
	83 => array('name'=>$lang->menu->attackRank,                'class'=>$lang->menu->class->rankData,      'url'=>'rank/attack_rank.php',  ),
	84 => array('name'=>$lang->menu->currencyRank,              'class'=>$lang->menu->class->rankData,      'url'=>'tabs.php?pid=84',	'menus' => array( 85, 86, 87,98,), ),
	85 => array('name'=>$lang->menu->xianshiRank,               'class'=>$lang->menu->class->rankData,      'url'=>'rank/xianshi_remain_rank.php',  'hide'=>true, ),
	86 => array('name'=>$lang->menu->moneyRank,                 'class'=>$lang->menu->class->rankData,      'url'=>'rank/money_remain_rank.php',    'hide'=>true, ),
	87 => array('name'=>$lang->menu->liquanRank,                'class'=>$lang->menu->class->rankData,      'url'=>'rank/liquan_remain_rank.php',   'hide'=>true, ),
	98 => array('name'=>$lang->menu->bindMoneyRank,             'class'=>$lang->menu->class->rankData,      'url'=>'rank/bind_money_remain_rank.php',   'hide'=>true, ),
	100 => array('name'=>$lang->menu->veinLevelRank,            'class'=>$lang->menu->class->rankData,      'url'=>'rank/vein_level_rank.php',   'hide'=>false, ),
	103 => array('name'=>$lang->menu->xianzunRank,              'class'=>$lang->menu->class->rankData,      'url'=>'rank/xianshi_charge_rank.php',   'hide'=>false, ),
	108 => array('name'=>$lang->menu->wingRank,              	'class'=>$lang->menu->class->rankData,      'url'=>'rank/wing_rank.php',   'hide'=>false, ),
	113 => array('name'=>$lang->menu->horseRank,              	'class'=>$lang->menu->class->rankData,      'url'=>'rank/horse_rank.php',   'hide'=>false, ),
	114 => array('name'=>$lang->menu->petAttackRank,            'class'=>$lang->menu->class->rankData,      'url'=>'rank/pet_attack_rank.php',   'hide'=>false, ),
	115 => array('name'=>$lang->menu->petJingjieRank,           'class'=>$lang->menu->class->rankData,      'url'=>'rank/pet_jingjie_rank.php',   'hide'=>false, ),
	116 => array('name'=>$lang->menu->petZizhiRank,             'class'=>$lang->menu->class->rankData,      'url'=>'rank/pet_zizhi_rank.php',   'hide'=>false, ),
    125=> array('name'=>$lang->menu->shenwuRank,             'class'=>$lang->menu->class->rankData,      'url'=>'rank/shenwu_rank.php',   'hide'=>false, ),
    126=> array('name'=>$lang->menu->flowerRank,             'class'=>$lang->menu->class->rankData,      'url'=>'rank/flower_rank.php',   'hide'=>false, ),
    
	//消息管理 
	44 => array('name'=>$lang->menu->kictPlayer,                  'class'=>$lang->menu->class->msgManage,         'url'=>'player/kill_all_player.php'),
	45 => array('name'=>$lang->menu->loginPlayer,                 'class'=>$lang->menu->class->msgManage,         'url'=>'player/login_player.php'),
	46 => array('name'=>$lang->menu->backendApplyManagement,      'class'=>$lang->menu->class->msgManage,         'url'=>'tabs.php?pid=46',  'menus' => array(47, 48, 49)),
	47 => array('name'=>$lang->menu->giveGoldRecord,              'class'=>$lang->menu->class->msgManage,         'url'=>'pay/give_goods_record.php', 'hide'=>true),
//	48 => array('name'=>$lang->menu->giveGold,                    'class'=>$lang->menu->class->msgManage,         'url'=>'pay/apply_goods_by_rolenames.php', 'hide'=>true),
//	49 => array('name'=>$lang->menu->applyGoldList,               'class'=>$lang->menu->class->msgManage,         'url'=>'pay/apply_goods_list.php',  'hide' =>true),
	50 => array('name'=>$lang->menu->chatLog,                     'class'=>$lang->menu->class->msgManage,         'url'=>'tabs.php?pid=50',       'menus' => array( 51, 52, 53, 54, )),
	51 => array('name'=>$lang->menu->channelChat,                 'class'=>$lang->menu->class->msgManage,         'url'=>'msg/chat_log.php',      'hide'=>true),
	52 => array('name'=>$lang->menu->friendChat,                  'class'=>$lang->menu->class->msgManage,         'url'=>'msg/friend_chat_log.php',  'hide'=>true),
	53 => array('name'=>$lang->menu->familyChat,                  'class'=>$lang->menu->class->msgManage,         'url'=>'msg/family_chat_log.php',  'hide'=>true),
	54 => array('name'=>$lang->menu->personalChatStatistic,       'class'=>$lang->menu->class->msgManage,         'url'=>'msg/personal_chat_statistic.php',  'hide'=>true),
	55 => array('name'=>$lang->menu->messageBroadcast,            'class'=>$lang->menu->class->msgManage,         'url'=>'msg/broadcast_message_list.php'),
	56 => array('name'=>$lang->menu->sendMail,                    'class'=>$lang->menu->class->msgManage,         'url'=>'msg/send_mail.php'),
	57 => array('name'=>$lang->menu->playerOpinion,               'class'=>$lang->menu->class->msgManage,         'url'=>'msg/player_opinion.php',  'hide'=>false),
	58 => array('name'=>$lang->menu->setSilence,               'class'=>$lang->menu->class->msgManage,         'url'=>'msg/ban_chat.php',  'hide'=>false),
	59 => array('name'=>$lang->menu->banAccount,               'class'=>$lang->menu->class->msgManage,         'url'=>'msg/ban_account.php',  'hide'=>false),
	60 => array('name'=>$lang->menu->banIp,               	   'class'=>$lang->menu->class->msgManage,         'url'=>'msg/ban_ip.php',  'hide'=>false),
	76 => array('name'=>$lang->menu->regularSendItem,          'class'=>$lang->menu->class->msgManage,         'url'=>'pay/regular_send_item.php',  'hide'=>false),
        
	//后台权限管理 
	61 => array('name'=>$lang->menu->manageLog,                   'class'=>$lang->menu->class->authManage,        'url'=>'system/admin_log_view.php'),
	62 => array('name'=>$lang->menu->userManage,                  'class'=>$lang->menu->class->authManage,        'url'=>'system/admin_user_management.php'),
	63 => array('name'=>$lang->menu->userGroupManage,             'class'=>$lang->menu->class->authManage,        'url'=>'system/admin_group_management.php'),
	//后台系统管理  
	64 => array('name'=>$lang->menu->alterPassword,               'class'=>$lang->menu->class->systemManage,      'url'=>'system/password.php'),
	65 => array('name'=>$lang->menu->serverConfig,                'class'=>$lang->menu->class->systemManage,      'url'=>'system/server_config.php'),
	66 => array('name'=>$lang->menu->gameEntranceConfig,          'class'=>$lang->menu->class->systemManage,      'url'=>'system/game_entrance_config.php'),
	67 => array('name'=>$lang->menu->checkErrorLog,               'class'=>$lang->menu->class->systemManage,      'url'=>'system/game_log_status_view.php'),
	68 => array('name'=>$lang->menu->changeOnlineTime,            'class'=>$lang->menu->class->systemManage,      'url'=>'system/change_online_time.php'),
	127 => array('name'=>$lang->menu->changeCombineTime,          'class'=>$lang->menu->class->systemManage,      'url'=>'system/change_combine_time.php'),
	144 => array('name'=>$lang->menu->adminConfig,          'class'=>$lang->menu->class->systemManage,      'url'=>'system/admin_config.php'),
	//数据管理
	101 => array('name'=>$lang->menu->destoryFamily,           'class'=>$lang->menu->class->dataManager,         'url'=>'msg/destory_family.php',  'hide'=>false),
	111 => array('name'=>$lang->menu->updatePlayerGold,        'class'=>$lang->menu->class->dataManager,         'url'=>'player/update_player_gold.php',  'hide'=>false),
	117 => array('name'=>$lang->menu->adminGmCode,             'class'=>$lang->menu->class->dataManager,         'url'=>'msg/gm_code.php',  'hide'=>false),
	118 => array('name'=>$lang->menu->dataRestore,             'class'=>$lang->menu->class->dataManager,         'url'=>'tabs.php?pid=118',       'menus' => array( 119, 120,135,136,),  'hide'=>false),
	119 => array('name'=>$lang->menu->dataImport,              'class'=>$lang->menu->class->dataManager,         'url'=>'manager/data_import.php',  'hide'=>true),
	120 => array('name'=>$lang->menu->checkAndRestore,         'class'=>$lang->menu->class->dataManager,         'url'=>'manager/check_and_restore.php',  'hide'=>true),
	135 => array('name'=>$lang->menu->familyRestore,           'class'=>$lang->menu->class->dataManager,         'url'=>'manager/restore_family.php',  'hide'=>true),
	136 => array('name'=>$lang->menu->familyStatus,           'class'=>$lang->menu->class->dataManager,         'url'=>'manager/family_status.php',  'hide'=>true),

	//最后ID：144, 下一个ID：145
);

foreach ( $ADMIN_PAGE_CONFIG as $key => $value ) {
//	$ADMIN_PAGE_CONFIG[$id]['interface'] = $value['interface'];
	$ADMIN_PAGE_CONFIG[$key]['interface'] = "socket";
//	$ADMIN_PAGE_CONFIG[$key]['ver'] = $value['ver'];
	$ADMIN_PAGE_CONFIG[$key]['isshow'] = 1;
}
