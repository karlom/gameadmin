<?php
$dictColor = array(
	1 => '白色',
	2 => '绿色',
	3 => '蓝色',
	4 => '紫色',
	5 => '橙色',
	6 => '金色'
);
$dictColorValue = array(
	0=>'gray',
	1=>'green',
	2=>'blue',
	3=>'purple',
	4=>'#ff9000',
	5=>'#ffff00',
);
$dictQuality = array(
//	0 => '无',
	1 => '低阶',
	2 => '中阶',
	3 => '高阶',
	4 => '顶阶',
//	5 => '洪荒',
//	6 => '上古',
);
$dictGoodsPos = array(
	1 => '普通背包',
    2 => '仓库',
	3 => '在身上',
	4 => '宝典仓库',
);

$dictMissionStatus = array(
	1 => '已接受',
	2 => '已可交',
	3 => '已领奖',
    4 => '已取消',
);

$dictMissionType = array(
	1 => '主',
	2 => '支',
	3 => '循环',
);

$dictBossType = array(
	1 => '被动boss',
	2 => '禁止类boss',
	3 => '主动boss',
	8 => 'TD boss',
);

$dictJobs=array(
	1 => '武尊',
	2 => '灵修',
	3 => '剑仙',
);

$dictOccupationType = array(
	0 => '还没有职业',
	1 => '武尊',
	2 => '灵修',
	3 => '剑仙',
);


$dictMoneyType = array(
	1 	=> "铜币",
	2 	=> "仙石",
	3 	=> "绑定仙石",
	4 	=> "元宝",
//	5 	=> "道具ID",  //>5,道具ID
);


$activityType = array(
	0	=> '等待中',
	1	=> '正在进行',
	2	=> '已结束'
);

//地图配置
$dictMapType = array(
	1000 => array('id' => '1000', 'name' => '天下城', 'level' => 0, 'isCopyScene' => false, ),
	1001 => array('id' => '1001', 'name' => '龙溪台', 'level' => 0, 'isCopyScene' => false, ),
	1002 => array('id' => '1002', 'name' => '云风崖', 'level' => 0, 'isCopyScene' => false, ),
	1003 => array('id' => '1003', 'name' => '清风林', 'level' => 0, 'isCopyScene' => false, ),
	1004 => array('id' => '1004', 'name' => '幽月谷', 'level' => 0, 'isCopyScene' => false, ),
	1009 => array('id' => '1009', 'name' => '不夜坊', 'level' => 40, 'isCopyScene' => false, ),
	1014 => array('id' => '1014', 'name' => '灵源洞', 'level' => 0, 'isCopyScene' => false, ),
	1015 => array('id' => '1015', 'name' => '灵源洞二层', 'level' => 0, 'isCopyScene' => false, ),
	1016 => array('id' => '1016', 'name' => '灵源洞三层', 'level' => 40, 'isCopyScene' => false, ),
	1017 => array('id' => '1017', 'name' => '风蚀之地', 'level' => 0, 'isCopyScene' => false, ),
	1018 => array('id' => '1018', 'name' => '邪风窟', 'level' => 40, 'isCopyScene' => false, ),
	
	2000 => array('id' => '2000', 'name' => '离风界', 'level' => 0, 'isCopyScene' => true, ),
	2002 => array('id' => '2002', 'name' => '天火界', 'level' => 0, 'isCopyScene' => false, ),
	2004 => array('id' => '2004', 'name' => '魂归界', 'level' => 0, 'isCopyScene' => false, ),
	2005 => array('id' => '2005', 'name' => '隆冬界', 'level' => 0, 'isCopyScene' => true, ),
	2011 => array('id' => '2011', 'name' => '老虎机1', 'level' => 0, 'isCopyScene' => true, ),
	2012 => array('id' => '2012', 'name' => '老虎机2', 'level' => 0, 'isCopyScene' => true, ),
	
	3000 => array('id' => '3000', 'name' => '家族战', 'level' => 0, 'isCopyScene' => true, ),
	3001 => array('id' => '3001', 'name' => '仙邪问鼎', 'level' => 0, 'isCopyScene' => true, ),
	3002 => array('id' => '3002', 'name' => '问鼎预备间', 'level' => 0, 'isCopyScene' => true, ),
	3003 => array('id' => '3003', 'name' => '寻宝遗迹', 'level' => 0, 'isCopyScene' => true, ),
	3004 => array('id' => '3004', 'name' => '不灭试练场', 'level' => 0, 'isCopyScene' => false, ),
	3005 => array('id' => '3005', 'name' => '风林密境', 'level' => 40, 'isCopyScene' => false, ),
	
	4000 => array('id' => '4000', 'name' => '圣石殿堂', 'level' => 0, 'isCopyScene' => true, ),
	4001 => array('id' => '4001', 'name' => '迷雾林', 'level' => 0, 'isCopyScene' => true, ),
	4002 => array('id' => '4002', 'name' => '灵芝山', 'level' => 0, 'isCopyScene' => true, ),
	4003 => array('id' => '4003', 'name' => '晶幻洞天', 'level' => 0, 'isCopyScene' => true, ),
	4004 => array('id' => '4004', 'name' => '幽都古墓一层', 'level' => 0, 'isCopyScene' => true, ),
	4005 => array('id' => '4005', 'name' => '幽都古墓二层', 'level' => 0, 'isCopyScene' => true, ),
	4006 => array('id' => '4006', 'name' => '幽都古墓三层', 'level' => 0, 'isCopyScene' => true, ),
	
	5000 => array('id' => '5000', 'name' => '心魔之境', 'level' => 0, 'isCopyScene' => true, ),
	5010 => array('id' => '5010', 'name' => '酒馆内部', 'level' => 0, 'isCopyScene' => false, ),
	5011 => array('id' => '5011', 'name' => '酒馆客房', 'level' => 0, 'isCopyScene' => true, ),
	5100 => array('id' => '5100', 'name' => '寻宝秘窟(30级)', 'level' => 0, 'isCopyScene' => true, ),
	5101 => array('id' => '5101', 'name' => '寻宝秘窟(40级)', 'level' => 0, 'isCopyScene' => true, ),
	5102 => array('id' => '5102', 'name' => '寻宝秘窟(50级)', 'level' => 0, 'isCopyScene' => true, ),
	5103 => array('id' => '5103', 'name' => '寻宝秘窟(60级)', 'level' => 0, 'isCopyScene' => true, ),
	5200 => array('id' => '5200', 'name' => '诡秘丛林(30级)', 'level' => 0, 'isCopyScene' => true, ),
	5201 => array('id' => '5201', 'name' => '诡秘丛林(40级)', 'level' => 0, 'isCopyScene' => true, ),
	5202 => array('id' => '5202', 'name' => '诡秘丛林(50级)', 'level' => 0, 'isCopyScene' => true, ),
	5203 => array('id' => '5203', 'name' => '诡秘丛林(60级)', 'level' => 0, 'isCopyScene' => true, ),
	5204 => array('id' => '5204', 'name' => '诡秘丛林(70级)', 'level' => 0, 'isCopyScene' => true, ),
	5205 => array('id' => '5205', 'name' => '诡秘丛林(80级)', 'level' => 0, 'isCopyScene' => true, ),
	
	6000 => array('id' => '6000', 'name' => '画意之境', 'level' => 0, 'isCopyScene' => true, ),
	6001 => array('id' => '6001', 'name' => '御剑逃生', 'level' => 0, 'isCopyScene' => true, ),
	6002 => array('id' => '6002', 'name' => '龙溪台', 'level' => 0, 'isCopyScene' => true, ),
	6003 => array('id' => '6003', 'name' => '虫穴', 'level' => 0, 'isCopyScene' => true, ),
	6004 => array('id' => '6004', 'name' => '迷雾林', 'level' => 0, 'isCopyScene' => true, ),
	6005 => array('id' => '6005', 'name' => '圣石殿堂', 'level' => 0, 'isCopyScene' => true, ),
	6006 => array('id' => '6006', 'name' => '迷之幻境', 'level' => 0, 'isCopyScene' => true, ),
	
	510 => array('id' => '510', 'name' => '风蚀之地', 'level' => 0, 'isCopyScene' => true, ),
	511 => array('id' => '511', 'name' => '灵源洞', 'level' => 0, 'isCopyScene' => true, ),
	512 => array('id' => '512', 'name' => '清风林', 'level' => 0, 'isCopyScene' => true, ),
	513 => array('id' => '513', 'name' => '灵源洞', 'level' => 0, 'isCopyScene' => true, ),
	514 => array('id' => '514', 'name' => '天火界', 'level' => 0, 'isCopyScene' => true, ),
	515 => array('id' => '515', 'name' => '寻宝秘窟', 'level' => 0, 'isCopyScene' => true, ),
	516 => array('id' => '516', 'name' => '迷雾林', 'level' => 0, 'isCopyScene' => true, ),
	517 => array('id' => '517', 'name' => '隆冬界', 'level' => 0, 'isCopyScene' => true, ),
	518 => array('id' => '518', 'name' => '风林密境', 'level' => 0, 'isCopyScene' => true, ),
	519 => array('id' => '519', 'name' => '幽都古墓', 'level' => 0, 'isCopyScene' => true, ),
);

$dictPayStatisticsType = array(
	0 => $lang->page->showType1,
	1 => $lang->page->showType2,
	2 => $lang->page->showType3,
	3 => $lang->page->showType4,
	4 => $lang->page->showType5
);

$dictRoleAttribute = array(
//角色属性
	1 => '力量',
	2 => '智慧',
	3 => '灵敏',
	4 => '攻击',
	5 => '防御',
	6 => '体力值',
	7 => '气力值',
	8 => '每秒气力恢复',
	9 => '命中',
	10 => '闪避',
	11 => '暴击',
	12 => '韧性',
	13 => '格挡几率%',
	14 => '格挡值',
	15 => '暴击伤害提升%',
	16 => '暴击伤害减免%',
	17 => '攻击压制',
	18 => '防御压制',
	19 => '护甲穿透%',
	20 => '抵抗穿透%',
	21 => '怪物抗性',
	22 => '武尊抗性',
	23 => '剑仙抗性',
	24 => '灵修抗性',
	25 => '移动速度%',
	26 => '治疗效果%',
	
	27 => '基础属性',
	28 => '攻击率',
	29 => '防御率',
	30 => '体力率',
	31 => '风灵石属性',
	32 => '火灵石属性',
	33 => '水灵石属性',
	34 => '土灵石属性',
	35 => '杀怪经验',
	36 => '穿戴等级降低',
	37 => '技能等级',
	38 => '技能冷却降低',
	39 => '技能伤害',
	40 => '移动速度',
	41 => '杀怪经验比率',
	
	502 => '体力值(最大值)',
	503 => '气力值(最大值)',
	504 => '经验值',
	505 => '经验最大值',
	
	1001 => '伤害加深率',
	1002 => '攻击方命中几率',
	1003 => '攻击方暴击几率',
	1004 => '暴击百分比加成',
	1005 => '伤害减免率',
	1006 => '防守方闪避几率',
	1007 => '防守方韧性几率',
	1008 => '怪物抗性减伤率',
	1009 => '武尊抗性减伤率',
	1010 => '剑仙抗性减伤率',
	1011 => '灵修抗性减伤率',
);

$dictRoleAttrPerc = array(
	13 => true,
	15 => true,
	16 => true,
	19 => true,
	20 => true,
	25 => true,
	26 => true,
	27 => true,
	28 => true,
	29 => true,
	30 => true,
	31 => true,
	32 => true,
	33 => true,
	34 => true,
	39 => true,
);

$dictHole = array(
	1 => $lang->item->hole1,
	2 => $lang->item->hole2,
);

//技能表
$dictSkill = array (
//wuzun
	'10' => '破海',
	'15' => '旋风',
	'26' => '突进',
	'32' => '噬魂',
	'37' => '天戟',
	'42' => '战吼',
	'48' => '断空',
	'53' => '战意复苏',
//lingxiu
	'210' => '燎原星火',
	'220' => '玄冰刃',
	'240' => '血月银丝',
	'250' => '神行术',
	'260' => '真元护盾',
	'270' => '魔龙焰',
	'290' => '心神合一',
	'300' => '隆冬雪雨',
//jianxian
	'410' => '新月剑芒',
	'420' => '灵剑闪华',
	'430' => '御风步',
	'440' => '星辰隐现',
	'450' => '天门剑阵',
	'460' => '聚意凝神',
	'470' => '苍穹虚劫',
	'480' => '剑影分光',
);

//技能符文
$dictSkillElement = array(
	'0' => '无符文',
	'1' => '离风',
	'2' => '天火',
	'3' => '隆冬',
	'4' => '云山',
);

$dictCamp = array(
	'1' => '仙宗',
	'2' => '邪宗',
);

//聊天频道的配置
$channelArray = array(
	1 => '综合',
	2 => '家族',
	3 => '组队',
//	4 => '私聊',
	5 => '系统',
	6 => '喇叭',
	7 => '附近',
	8 => '活动',
);
//绑定配置
$isBindArray = array(
	-1 => '全部',
	0 => '不绑定',
	1 => '绑定',
);

//下线原因
$offLineReason = array(
    1 => "正常断开连接",
    2 => "管理后台踢人（单独）",
    3 => "管理后台踢人（全服）",
    4 => "重复帐号登录",
    5 => "登录认证失败",
    6 => "防沉迷",
    7 => "正常断开后几秒后销毁",
);

//活跃礼包
$dictHuoyueReward = array(
	1 => array( 'id'=>1, 'huoyuedu' => 100,'item_id' => 13000, 'vip_level' => 0, ),
	2 => array( 'id'=>1, 'huoyuedu' => 250,'item_id' => 13001, 'vip_level' => 0, ),
	3 => array( 'id'=>1, 'huoyuedu' => 400,'item_id' => 13002, 'vip_level' => 0, ),
	4 => array( 'id'=>1, 'huoyuedu' => 450,'item_id' => 13003, 'vip_level' => 1, ),
	5 => array( 'id'=>1, 'huoyuedu' => 500,'item_id' => 13004, 'vip_level' => 1, ),
	6 => array( 'id'=>1, 'huoyuedu' => 550,'item_id' => 13005, 'vip_level' => 1, ),
);

$dictPetTrend = array(
	1 => "力",
	2 => "智",
	3 => "敏",
);

//仙羽神通
$dictWingShentong = array(
    0 => "仙羽振翅",
    1 => "翼展天翔",
    2 => "翼转轮回",
    3 => "羽聚金身",
    4 => "凌云傲啸",
    5 => "羽化千刃",
    6 => "凤舞涅槃",
);

//
$dictGmCode = array(
    'gmsetexp' => array( 'code' => 'gmsetexp', 'desc' => '设置指定角色当前经验值', 'input' => '经验值', ),
//    'gmpull' => array( 'code' => 'gmpull', 'desc' => '将指定角色传送到身边', 'input' => '角色名', ),
    'gmclcopy' => array( 'code' => 'gmclcopy', 'desc' => '重置指定角色副本进入次数', 'input' => '副本id', ),
    'gmtaska' => array( 'code' => 'gmtaska', 'desc' => '让指定角色接受某个ID的任务', 'input' => '任务id', ),
    'gmtaskf' => array( 'code' => 'gmtaskf', 'desc' => '让指定角色提交完成某个ID的任务', 'input' => '任务id', ),
    'gmpermit' => array( 'code' => 'gmpermit', 'desc' => '修改指定角色的gm权限', 'input' => 'gm权限', ),
    'gmfabaolucky' => array( 'code' => 'gmfabaolucky', 'desc' => '修改某个玩家坐骑幸运值', 'input' => '幸运值', ),
    'gmnobindyinliang' => array( 'code' => 'gmnobindyinliang', 'desc' => '调整玩家不绑定铜币', 'input' => '不绑定铜币值', ),
    'gmjingjiscore' => array( 'code' => 'gmjingjiscore', 'desc' => '调整玩家擂台积分', 'input' => '积分值', ),
    'gmhorselv' => array( 'code' => 'gmhorselv', 'desc' => '调整玩家坐骑等级', 'input' => '坐骑等级', ),
    'gmwinglv' => array( 'code' => 'gmwinglv', 'desc' => '调整玩家翅膀等级', 'input' => '翅膀等级', ),
    'gmjingjieid' => array( 'code' => 'gmjingjieid', 'desc' => '调整玩家境界等级', 'input' => '境界等级', ),
    'gmhorsedel' => array( 'code' => 'gmhorsedel', 'desc' => '删除玩家坐骑', 'input' => '坐骑ID', ),
    'gmpaycost' => array( 'code' => 'gmpaycost', 'desc' => '增加仙石消费数量', 'input' => '数量', ),
    'gmxsstore' => array( 'code' => 'gmxsstore', 'desc' => '增加（减少）仙石库数量', 'input' => '数量', ),
);

$dictSex = array(
	0 => "不限",
	1 => "男",
	2 => "女",
);

$dictPlatform = array(
	'iwan' => '爱玩',
	'3366' => '3366',
	'qqgame' => '游戏大厅',
	'qzone' => '空间',
	'pengyou' => '朋友网',
	'weiduan3366' => '3366微端',
	'weiduanunion' => '联盟微端',
	'guanjia' => 'QQ官家',
);

$dictFamilyOffical = array (
	1 => '族长',
	2 => '副族长',
	3 => '长老',
	4 => '精英',
	5 => '普通族员',
);

$dictAppCustom = array(
	'LLsu7re' => '暴风影音',
	'LLsng65' => '人人网',
	'LLs9r87' => '华数TV',
	'LLsvg4l' => '捧腹网',
	'LLs84fa' => '泡泡',
	'LLmu6f3' => '斑马',
	'LLmkk8f' => '电信',
	'LLms9pc' => 'cngba',
	'LLmu11s' => '17coco',
	'LLmf00g' => '方格子网吧',
	'LLmsd51' => 'ceo玩',
	
	'LLgd04h' => '暴风影音',
	'LLg9fsr' => '人人网',
	'LLgi64n' => '华数TV',
	'LLg6we3' => '捧腹网',
	'LLgf7s6' => '泡泡',
	'LLg9ke6' => 'cntv',
	'LLef4y2' => '斑马',
	'LLe88gh' => '电信',
	'LLeqsi5' => '游戏狗',
	'LLen66b' => '17coco',
	'LLel97z' => '方格子网吧',
	'LLe0ou4' => 'ceo玩',
	'LLew6f5' => '彩云浏览器',
	'LLsp007' => '北京道驰科技',
	'LLk8s3g' => '起点文学',
	'LLkf6d3' => '起点文学',
	'LLkcg75' => '起点文学',
	'LLk6fxf' => '起点文学',
	'LLk4a5f' => '起点文学',
	'LLkrt33' => '起点文学',
);