<?php

//===================管理后台数据库表====================
define('T_ADMIN_USER', 't_admin_user'); //管理后台用户表
define('T_ADMIN_GROUP', 't_admin_group'); //管理后台用户组
define('T_ADMIN_LIST', 't_admin_list'); //管理后台
define('T_LOG_ADMIN', 't_log_admin'); //管理后台日志表
define('T_LOG_MENU', 't_log_menu'); //菜单点击日志
define('T_IP_ACCESS', 't_ip_access'); //允许登录IP表
define('T_SERVER_CONFIG', 't_server_config'); //服务器配置表
define('T_MENU_CONFIG', 't_menu_config'); //菜单参数配置
define('T_APPLY_GOODS', 't_apply_goods'); //赠送物品表
define('T_JULINGZHEN', 't_juLingZhen'); //活动编辑器聚灵阵
define('T_ACTIVITY','t_activity'); //活动编辑器排行类

//===================游戏日志数据库表====================
define('T_LOG_REGISTER', 't_log_register'); //玩家注册日志表
define('T_LOG_LOGIN', 't_log_login'); //用户登录日志
define('T_LOG_LOGOUT', 't_log_logout'); //登出日志
define('T_LOG_DIE', 't_log_die'); //登出日志
define('T_LOG_TASK', 't_log_task'); //任务日志
define('T_LOG_ITEM', 't_log_item'); //道具使用日志
define('T_LOG_STORE', 't_log_store'); //仓库储存日志
define('T_LOG_CAREER', 't_log_career'); //职业日志
define('T_LOG_CREATE_LOSS', 't_log_create_loss'); //创建流失日志
define('T_LOG_GOLD', 't_log_gold'); //元宝记录日志
define('T_LOG_MONEY', 't_log_money'); //银两记录日志
define('T_LOG_LIQUAN', 't_log_liquan'); //礼券记录日志
define('T_LOG_LINGQI', 't_log_lingqi'); //灵气记录日志
define('T_LOG_FAMILY_CONTRIBUTE', 't_log_family_contribute');//家族捐献日志
define('T_LOG_FAMILY_CONTRIBUTION_GET_AND_USE', 't_log_family_contribution_get_and_use');//家族贡献获得与使用日志
define('T_LOG_LEVEL_UP', 't_log_level_up'); //等级日志
define('T_LOG_MARKET_SELL', 't_log_market_sell'); //市场寄售日志
define('T_LOG_MARKET_CANCEL_SELL', 't_log_market_cancel_sell'); //市场取消寄售日志
define('T_LOG_MARKET_BUY', 't_log_market_buy'); //市场购买日志
define('T_LOG_JINGJIE', 't_log_jingjie'); //境界提升日志
define('T_LOG_JINGJIE_SKILL', 't_log_jingjie_skill'); //境界技能提升日志
define('T_LOG_TEAM', 't_log_team'); //玩家组队日志
define('T_LOG_FRIEND', 't_log_friend'); //好友申请日志
define('T_LOG_FRIEND_CHAT', 't_log_friend_chat'); //好友聊天日志
define('T_LOG_FAMILY_CHAT', 't_log_family_chat'); //家族聊天日志
define('t_log_skill_upgrade', 't_log_skill_upgrade'); //玩家交易日志
define('T_LOG_DEAL', 't_log_deal'); //玩家交易日志
define('T_LOG_SKILL_UPGRADE', 't_log_skill_upgrade'); //技能升级日志
define('T_LOG_PET_UP', 't_log_pet_up'); //宠物升级日志
define('T_LOG_PET_CREATE', 't_log_pet_create'); // 宠物获取日志
define('T_LOG_PET_DEL', 't_log_pet_del'); // 宠物放生日志
define('T_LOG_PET_RONGHE', 't_log_pet_ronghe'); // 宠物融合日志
define('T_LOG_PET_FEED', 't_log_pet_feed'); // 宠物喂食日志
define('T_LOG_PET_JINGJIE_UP', 't_log_pet_jingjie_up'); // 宠物境界提升日志
define('T_LOG_PET_SKILL_UP', 't_log_pet_skill_up'); // 宠物技能提升日志
define('T_LOG_PET_SKILL_FORGET', 't_log_pet_skill_forget'); // 宠物技能遗忘日志
define('T_LOG_PET_HUAXING', 't_log_pet_huaxing'); // 宠物化形日志
define('T_LOG_REFINE_STRENGTHEN', 't_log_refine_strengthen'); // 神炉强化日志
define('T_LOG_REFINE_PURIFY', 't_log_refine_purify'); // 神炉精炼日志
define('T_LOG_REFINE_PURIFY_RESET', 't_log_refine_purify_reset'); // 神炉精炼重置日志
define('T_LOG_REFINE_INLAY', 't_log_refine_inlay'); // 宝石镶嵌日志
define('T_LOG_REFINE_EXTEND', 't_log_refine_extend'); // 装备继承日志
define('T_LOG_COPY', 't_log_copy'); //副本日志
define('T_LOG_CLIENT_INFO', 't_log_client_info'); // 客户端系统信息日志
define('T_LOG_HOME_OP', 't_log_home_op'); // 家园操作日志
define('T_LOG_HOME_FANG', 't_log_home_fang'); // 家园塔防操作日志
define('T_LOG_ONLINE', 't_log_online');//在线日志
define('T_APPLY_GOODS', 't_apply_goods'); //道具赠送申请日志
define('T_LOG_ADMIN', 'T_LOG_ADMIN'); //管理后台赠送道具记录日志
define('T_LOG_ETL_ERROR', 't_log_etl_error'); //拉取日志出错日志
define('T_SENDMAIL', 't_sendmail'); //信件历史
define('T_LOG_GM_CODE', 't_log_gm_code'); //GM指令日志
define('T_MESSAGE_BROADCAST', 't_message_broadcast'); //消息广播列表
define('T_LOG_CHAT', 't_log_chat'); //聊天日志
define('T_LOG_HANG', 't_log_hang'); //打坐挂机日志
define('T_LOG_SKILL_MAIN_MENU', 't_log_skill_main_menu'); //技能快捷栏日志
define('T_LOG_COLLECT_REVIVE', 't_log_collect_revive'); //采集复活日志
define('T_LOG_JHDT_INFO', 't_log_jhdt_info'); //晶幻洞天通关日志
define('T_LOG_XXWD_COLLECT', 't_log_xxwd_collect'); //仙邪问鼎采集日志
define('T_LOG_XXWD_SCORE', 't_log_xxwd_score'); //仙邪问鼎比分日志
define('T_LOG_XXWD_BOARD', 't_log_xxwd_board'); //仙邪问鼎排行榜
define('T_LOG_YJXB_SKILL', 't_log_yjxb_skill'); //遗迹寻宝技能使用日志
define('T_LOG_YJXB_COLLECT', 't_log_yjxb_collect'); //遗迹寻宝宝箱采集日志
define('T_LOG_YJXB_JB', 't_log_yjxb_jb'); //遗迹寻宝金币拾取掉落日志
define('T_LOG_BMSL_LIVE', 't_log_bmsl_live'); //不灭试炼存活玩家/排行榜
define('T_LOG_BMSL_JYZS', 't_log_bmsl_jyzs'); //不灭试炼记忆之石日志
define('T_LOG_MWBD_JOIN_INFO', 't_log_mwbd_join_info'); //魔物暴动活动参加日志
define('T_LOG_MWBD_ROLE_CNT', 't_log_mwbd_role_cnt'); //魔物暴动地图人数日志
define('T_LOG_MWBD_MONSTER_DIE', 't_log_mwbd_monster_die'); //魔物暴动怪物死亡日志
define('T_LOG_MWBD_FAMILY_RANK', 't_log_mwbd_family_rank'); //魔物暴动怪物家族排名
define('T_LOG_CLIENT_ERR_LOAD', 't_log_client_err_load'); //客户端加载和解码报错日志
define('T_LOG_CLIENT_ERR_MEM_MAP', 't_log_client_err_mem_map'); //客户端地图加载内存问题日志
define('T_LOG_BUG', 't_log_bug'); //玩家提BUG或建议
define('T_LOG_WANTED', 't_log_wanted'); //通缉令挑战日志
define('T_LOG_HUOYUE', 't_log_huoyue'); //玩家活跃日志
define('T_LOG_OPEN_VIP', 't_log_open_vip'); //黄钻开通日志
define('T_LOG_BUY_GOODS', 't_log_buy_goods'); //Q点购买道具日志
define('T_LOG_SHOP_RAND', 't_log_shop_rand'); //神秘商店日志
define('T_LOG_TALISMAN_UPGRADE', 't_log_talisman_upgrade'); //法宝进阶日志
define('T_LOG_TALISMAN_ILLUSION', 't_log_talisman_illusion'); //法宝激活幻化日志
define('T_LOG_BILLBOARD_ROLE_ATK', 't_log_billboard_role_atk'); //战力排行榜
define('T_LOG_NPC_SHOP_BUY', 't_log_npc_shop_buy'); //npc商店购买日志
define('T_LOG_DELETE', 't_log_delete'); //删号日志
define('T_LOG_VEIN_LV', 't_log_vein_lv'); //龙脉升级日志
define('T_LOG_MARRY_ASK', 't_log_marry_ask'); //求婚日志
define('T_LOG_MARRY_ASK_RESULT', 't_log_marry_ask_result'); //求婚结果日志
define('T_LOG_MARRY_BOOK', 't_log_marry_book'); //婚宴预约日志
define('T_LOG_BILLBOARD_WING', 't_log_billboard_wing'); //仙羽排行榜
define('T_LOG_MARRY_DIVORCE', 't_log_marry_divorce'); //离婚日志
define('T_LOG_MIDDLE_BOSS_RESULT', 't_log_middle_boss_result'); //跨服BOSS活动结果
define('T_LOG_MIDDLE_BOSS_BOARD', 't_log_middle_boss_board'); //跨服BOSS伤害排行

define('T_BAN_CHAT', 't_ban_chat'); //玩家禁言日志
define('T_BAN_ACCOUNT', 't_ban_account'); //玩家禁登录日志
define('T_BAN_IP', 't_ban_ip'); //禁IP登录日志
define('T_REGULAR_SEND_ITEM', 't_regular_send_item'); //定时发送道具
define('T_CREATE_GM_ROLE', 't_create_gm_role'); //创建GM角色

define('C_ROLE_LABEL', 'c_role_label'); //角色数据标签
define('C_ACTIVITY_JOIN', 'c_activity_join'); //活动参与数据统计表

//define('T_LOG_PAY', 't_log_pay'); //充值日志
