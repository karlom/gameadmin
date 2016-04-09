#!/bin/bash

###################################################
## 该脚本必须让每X分运行一次,分析游戏各种日志到数据库.
###################################################
export LANG="en_US.UTF-8"
INIT_DIR=`dirname $0`
cd ${INIT_DIR}/

if [ ! -z "$1" ];then
mdate=$1
else
mdate=""
fi

LOG_DIR=/data/logs/etl_crontab_load_data/
mkdir -p ${LOG_DIR}

strMonth=`date "+%Y%m%d"`
logFile=${LOG_DIR}etl_crontab_load_data_$strMonth.log
echo "======start【" `date "+%Y-%m-%d %H:%M:%S"` "】========" >> $logFile

name=(	[0]="t_log_item"	#道具获得使用日志
		[1]="t_log_login"	#玩家登录日志
		[2]="t_log_logout"	#玩家登出日志
		[3]="t_log_die"	#玩家死亡日志
		[4]="t_log_task"	#玩家任务日志
		[5]="t_log_register"	#玩家注册日志
		[6]="t_log_store"	#仓库储存日志表
		[7]="t_log_career"	#玩家职业日志
		[8]="t_log_create_loss"	#玩家创建流失日志
		[9]="t_log_gold"	#元宝使用日志
		[10]="t_log_money"	#银子获得使用日志
		[11]="t_log_liquan"	#礼券获得使用日志
		[12]="t_log_lingqi"	#灵气获得使用日志
		[13]="t_log_family_contribute"	#家族捐献日志
		[14]="t_log_level_up"	#玩家升级日志
		[15]="t_log_market_sell"	#市场寄售日志
		[16]="t_log_market_cancel_sell"	#市场取消寄售日志
		[17]="t_log_market_buy"	#市场购买日志
		[18]="t_log_jingjie"	#境界提升日志
		[19]="t_log_jingjie_skill"	#境界技能提升日志
		[20]="t_log_family_enter_and_exit"	#玩家进退家族日志
		[21]="t_log_team"	#玩家组队日志
		[22]="t_log_friend"	#好友申请日志
		[23]="t_log_friend_chat"	#好友聊天日志
		[24]="t_log_family_chat"	#家族聊天日志
		[25]="t_log_deal"	#玩家交易日志
		[26]="t_log_skill_upgrade"	#技能升级日志
		[27]="t_log_pet_up"	#宠物升级日志
		[28]="t_log_pet_create"	#宠物获得日志
		[29]="t_log_pet_del"	#宠物放生日志
		[30]="t_log_pet_ronghe"	#宠物融合日志
		[31]="t_log_pet_feed"	#宠物喂食日志
		[32]="t_log_pet_jingjie_up"	#宠物境界提升日志
		[33]="t_log_pet_skill_up"	#宠物技能提升日志
		[34]="t_log_pet_skill_forget"	#宠物技能遗忘日志
		[35]="t_log_pet_huaxing"	#宠物换形日志
		[36]="t_log_refine_strengthen"	#神炉强化日志
		[37]="t_log_refine_purify"	#神炉精炼日志
		[38]="t_log_refine_purify_reset"	#神炉精炼重置日志
		[39]="t_log_refine_inlay"	#宝石镶嵌日志
		[40]="t_log_refine_extend"	#装备继承日志
		[41]="t_log_copy"	#副本日志
		[42]="t_log_family_contribution_get_and_use"	#家族贡献获得与使用日志
		[43]="t_log_client_info"	#客户端系统信息日志
		[44]="t_log_home_op"	#家园操作日志
		[45]="t_log_home_fang"	#家园塔防操作日志
		[46]="t_log_tiancheng"	#天城令获得使用日志
		[47]="t_log_admin"	#管理后台赠送道具日志
		[48]="t_log_gm_code"	#GM指令操作日志
		[49]="t_log_chat"	#聊天日志
		[50]="t_log_drop_item"	#掉落非法ID日志
		[51]="t_log_bug"	#玩家提BUG或建议
		[52]="t_log_hang"	#打坐挂机日志
		[53]="t_log_skill_main_menu"	#技能快捷栏日志
		[54]="t_log_collect_revive"	#采集复活日志
		[55]="t_log_jhdt_info"	#晶幻洞天通关日志
		[56]="t_log_xxwd_collect"	#仙邪问鼎采集日志
		[57]="t_log_xxwd_score"	#仙邪问鼎比分日志
		[58]="t_log_xxwd_board"	#仙邪问鼎排行榜
		[59]="t_log_yjxb_skill"	#遗迹寻宝技能使用日志
		[60]="t_log_yjxb_collect"	#遗迹寻宝宝箱采集日志
		[61]="t_log_yjxb_jb"	#遗迹寻宝金币拾取掉落日志
		[62]="t_log_bmsl_live"	#不灭试炼存活玩家/排行榜
		[63]="t_log_bmsl_jyzs"	#不灭试炼记忆之石日志
		[64]="t_log_mwbd_join_info"	#魔物暴动活动参加日志
		[65]="t_log_mwbd_role_cnt"	#魔物暴动地图人数日志
		[66]="t_log_mwbd_monster_die"	#魔物暴动怪物死亡日志
		[67]="t_log_mwbd_family_rank"	#魔物暴动怪物家族排名
		[68]="t_log_client_err_load"	#客户端加载和解码报错日志
		[69]="t_log_client_err_mem_map"	#客户端地图加载内存问题日志
		[70]="t_log_wanted"	#通缉令挑战日志
		[71]="t_log_huoyue"	#玩家活跃日志
		[72]="t_log_open_vip"	#黄钻开通日志
		[73]="t_log_buy_goods"	#Q点购买道具日志
		[74]="t_log_shop_rand"	#神秘商店日志
		[75]="t_log_talisman_upgrade"	#法宝进阶日志
		[76]="t_log_talisman_illusion"	#法宝激活幻化日志
		[77]="t_log_billboard_role_atk"	#战力排行榜
		[78]="t_log_npc_shop_buy"	#npc商店购买日志
		[79]="t_log_delete"	#删号日志
		[80]="t_log_task_market"	#任务集市日志
		[81]="t_log_middle"	#跨服切换日志
		[82]="t_log_blue_icon"	#蓝钻icon日志
		[83]="t_log_blue_libao"	#蓝钻礼包日志
		[84]="t_log_bind_money"	#绑定银两获得使用日志
		[85]="t_log_refine_resolve"	#神炉拆解日志
		[86]="t_log_yuanbao_sum"	#累计充值日志
		[87]="t_log_vein_lv"	#龙脉升级日志
		[88]="t_log_marry_ask"	#求婚日志
		[89]="t_log_marry_ask_result"	#求婚结果日志
		[90]="t_log_marry_book"	#婚宴预约日志
		[91]="t_log_billboard_wing"	#仙羽排行榜
		[92]="t_log_marry_divorce"	#离婚日志
		[93]="t_log_middle_boss_result"	#跨服BOSS活动结果
		[94]="t_log_middle_boss_board"	#跨服BOSS伤害排行
		[95]="t_log_marry_xianyuanzhi"	#仙缘值日志
		[96]="t_log_billboard_horse"	#坐骑排行榜
		[97]="t_log_billboard_pet_zhandouli"	#宠物战力排行榜
		[98]="t_log_billboard_pet_jingjie"	#宠物境界排行榜
		[99]="t_log_billboard_pet_zizhi"	#宠物资质排行榜
		[100]="t_log_refine_inlay_gem2"	#圣纹镶嵌日志		
		[101]="t_log_shop_djxg_get"	#等级限购礼包领取日志
		[102]="t_log_shop_djxg_buy"	#等级限购商品购买日志
		[103]="t_log_talisman_uplevel"	#坐骑升级日志
		[104]="t_log_wing_uplevel"	#翅膀升级日志
		[105]="t_log_open_vip_blue"	#开通蓝钻日志
		[106]="t_log_open_vip_yellow"	#开通黄钻日志
		[107]="t_log_billboard_jingji"	#神武擂台排行榜
		[108]="t_log_billboard_flower_sum"	#鲜花排行榜
        [109]="t_log_fsdg_contribute"	 #风蚀地宫捐献日志
        [110]="t_log_merge_server_consume"	 #合服活动消费日志
		[111]="t_log_pay"	 #联运充值日志
        [112]="t_log_weiduan_tip_libao"	 #微端礼包日志
        [113]="t_log_weiduan_down_libao"	 #微端下载日志
        [114]="t_log_juhuasuan"	 #聚划算礼包日志
        [115]="t_log_question_survey"	 #问卷调查日志
        [116]="t_log_open_vip2"	 #蓝钻开通日志
        [117]="t_log_player_return"	 #回流礼包日志
        [118]="t_log_paycost_tuhao"	 #土豪赠礼日志
        [119]="t_log_paycost_lucky"	 #幸运转盘日志
		[120]="t_log_check_frame"	 #加速检测日志
        [121]="t_log_tybk"	 #天元宝库兑换日志
	)

num=${#name[@]}
for((i=0;i<num;i++)){

	PROC_CNT1=`ps aux | grep "log_load.php ${name[$i]}" | grep -v grep | wc -l`
	#echo ${PROC_CNT1}
	if [ "${PROC_CNT1}" -gt 0 ]
	then
		echo "[log_load.php ${name[$i]}] more than one process runing, exits."
	else
		echo =====================log_load.php ${name[$i]}==================
		STARTTIME=`date "+%s"`
		/usr/bin/php log_load.php ${name[$i]} >> $logFile &
		ENDTIME=`date "+%s"`
		echo ${name[$i]} "（ $[ $ENDTIME-$STARTTIME ] s）" >> $logFile
	fi
	
	PROC_CNT2=`ps aux | grep "load_log_from_csv.php ${name[$i]}" | grep -v grep | wc -l`
	#echo ${PROC_CNT2}
	if [ "${PROC_CNT2}" -gt 0 ]
	then
		echo "[load_log_from_csv.php ${name[$i]}] more than one process runing, exits."
	else
		echo =====================load_log_from_csv.php ${name[$i]}==================
		STARTTIME=`date "+%s"`
		/usr/bin/php load_log_from_csv.php ${name[$i]} >> $logFile &
		ENDTIME=`date "+%s"`
		echo ${name[$i]} "（ $[ $ENDTIME-$STARTTIME ] s）" >> $logFile
	fi

}

echo "==================end=======================" >> $logFile
