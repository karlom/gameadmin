--
-- 游戏日志库建表SQL语句
-- 2013-01-17 by libiao 整理
-- 
-- 建库语句如：
-- CREATE DATABASE IF NOT EXISTS D3_qq_S0 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
-- GRANT ALL ON D3_qq_S0.* TO D3_qq_S0@localhost identified by "rKNDge58plPPvjJN";
-- GRANT FILE ON *.* TO D3_qq_S0@localhost identified by "rKNDge58plPPvjJN";
-- 

SET NAMES 'utf8';

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


-- --------------------------------------------------------

-- 游戏日志表 --

--
-- 表的结构 `t_log_register`
--

CREATE TABLE IF NOT EXISTS `t_log_register` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `ip` varchar(16) DEFAULT NULL COMMENT 'IP',
  `job` tinyint(2) DEFAULT NULL COMMENT '职业',
  `sex` tinyint(2) DEFAULT NULL COMMENT '性别',
  `pf` varchar(40) DEFAULT NULL COMMENT '平台',
  `app_custom` varchar(40) DEFAULT NULL COMMENT '自定义标记',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `is_miniclient` int(5) NOT NULL COMMENT '是否微端',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `mtime` (`mtime`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='玩家注册日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_login`
--

CREATE TABLE IF NOT EXISTS `t_log_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '帐号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `ip` char(15) NOT NULL COMMENT '登录IP',
  `contract_id` varchar(40) DEFAULT NULL COMMENT '任务集市ID',
  `pf` varchar(40) DEFAULT NULL COMMENT '平台',
  `xianzun` smallint(4) NOT NULL DEFAULT '0' COMMENT 'vip等级',
  `zhandouli` int(11) NOT NULL DEFAULT '0' COMMENT '战斗力',
  `app_custom` varchar(40) DEFAULT NULL COMMENT '自定义标记',
  `is_miniclient` int(5) NOT NULL COMMENT '是否微端',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `mtime` (`mtime`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`),
  KEY `level` (`level`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='玩家登录日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_logout`
--

CREATE TABLE IF NOT EXISTS `t_log_logout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '帐号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `online_time` int(11) NOT NULL DEFAULT '0' COMMENT '在线时长',
  `ip` char(15) NOT NULL COMMENT '登出IP',
  `reason` int(11) NOT NULL COMMENT '下线原因',
  `map_id` int(11) NOT NULL DEFAULT '0' COMMENT '地图ID',
  `x` int(11) NOT NULL DEFAULT '0' COMMENT '下线时X轴坐标',
  `y` int(11) NOT NULL DEFAULT '0' COMMENT '下线时Y轴坐标',
  `pf` varchar(40) DEFAULT NULL COMMENT '平台',
  `is_miniclient` int(5) NOT NULL COMMENT '是否微端',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`account_name`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='玩家登出日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_die`
--

CREATE TABLE IF NOT EXISTS `t_log_die` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '帐号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `killer_type` tinyint(3) NOT NULL COMMENT '杀手类型',
  `killer_name` varchar(30) NOT NULL COMMENT '杀手名称',
  `killer_uuid` varchar(40) NOT NULL COMMENT '杀手uuid',
  `map_id` int(11) NOT NULL DEFAULT '0' COMMENT '地图ID',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`),
  KEY `killer_name` (`killer_name`),
  KEY `killer_uuid` (`killer_uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='玩家死亡日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_task`
--

CREATE TABLE IF NOT EXISTS `t_log_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '帐号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `task_id` int(11) DEFAULT NULL COMMENT '任务ID',
  `task_action` tinyint(3) DEFAULT NULL COMMENT '任务动作',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='玩家任务日志';

-- --------------------------------------------------------
--
-- 表的结构 `t_log_item`
--

CREATE TABLE IF NOT EXISTS `t_log_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '帐号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `type` int(5) NOT NULL DEFAULT '0' COMMENT '道具类型',
  `item_id` int(11) NOT NULL COMMENT '道具ID',
  `item_num` int(11) NOT NULL COMMENT '道具数量',
  `is_bind` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否绑定',
  `detail` text COMMENT '道具详情',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`),
  KEY `type` (`type`),
  KEY `item_id` (`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='道具流通日志';

-- --------------------------------------------------------
--
-- 表的结构 `t_log_store`
--

CREATE TABLE IF NOT EXISTS `t_log_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '帐号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `type` int(5) NOT NULL DEFAULT '0' COMMENT '消费类型',
  `item_id` int(11) NOT NULL COMMENT '道具ID',
  `item_count` int(11) NOT NULL COMMENT '道具数量',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`),
  KEY `type` (`type`),
  KEY `item_id` (`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='仓库储存日志';

-- --------------------------------------------------------
--
-- 表的结构 `t_log_career`
--

CREATE TABLE IF NOT EXISTS `t_log_career` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '帐号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `career` tinyint(3) NOT NULL COMMENT '职业ID',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='玩家职业日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_create_loss`
--

CREATE TABLE IF NOT EXISTS `t_log_create_loss` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `step` tinyint(3) NOT NULL DEFAULT '0' COMMENT '步骤',
  `ip` char(15) DEFAULT NULL COMMENT 'IP',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `mtime` (`mtime`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='创建流失日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_gold`
--

CREATE TABLE IF NOT EXISTS `t_log_gold` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `gold` int(11) DEFAULT NULL COMMENT '元宝',
  `type` int(5) DEFAULT NULL COMMENT '消费类型',
  `item_id` int(11) DEFAULT NULL COMMENT '获得物品ID',
  `num` int(11) DEFAULT NULL COMMENT '物品数量',
  `remain_gold` int(11) DEFAULT NULL COMMENT '元宝余额',
  `pf` varchar(40) DEFAULT NULL COMMENT '平台',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `mtime` (`mtime`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='元宝使用日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_money`
--

CREATE TABLE IF NOT EXISTS `t_log_money` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `money` int(11) DEFAULT NULL COMMENT '银两',
  `type` int(5) DEFAULT NULL COMMENT '消费类型',
  `item_id` int(11) DEFAULT NULL COMMENT '获得物品ID',
  `num` int(11) DEFAULT NULL COMMENT '物品数量',
  `remain_money` int(11) DEFAULT NULL COMMENT '剩余银两',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='银子获得使用日志';

-- --------------------------------------------------------


--
-- 表的结构 `t_log_liquan`
--

CREATE TABLE IF NOT EXISTS `t_log_liquan` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `liquan` int(11) DEFAULT NULL COMMENT '礼券',
  `type` int(5) DEFAULT NULL COMMENT '消费类型',
  `item_id` int(11) DEFAULT NULL COMMENT '获得物品ID',
  `num` int(11) DEFAULT NULL COMMENT '物品数量',
  `remain_liquan` int(11) DEFAULT NULL COMMENT '剩余礼券',
  `pf` varchar(40) DEFAULT NULL COMMENT '平台',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `mtime` (`mtime`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='礼券获得使用日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_linqgi`
--

CREATE TABLE IF NOT EXISTS `t_log_lingqi` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `lingqi` int(11) DEFAULT NULL COMMENT '灵气',
  `type` int(5) DEFAULT NULL COMMENT '消费类型',
  `item_id` int(11) DEFAULT NULL COMMENT '获得物品ID',
  `num` int(11) DEFAULT NULL COMMENT '物品数量',
  `remain_lingqi` int(11) DEFAULT NULL COMMENT '剩余灵气值',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='灵气获得使用日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_tiancheng`
--

CREATE TABLE IF NOT EXISTS `t_log_tiancheng` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `tiancheng` int(11) DEFAULT NULL COMMENT '天城令',
  `type` int(5) DEFAULT NULL COMMENT '消费类型',
  `remain_tiancheng` int(11) DEFAULT NULL COMMENT '剩余天城令',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='天城令获得使用日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_family_contribute`
--

CREATE TABLE IF NOT EXISTS `t_log_family_contribute` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `gold` int(11) DEFAULT '0' COMMENT '捐献元宝',
  `money` int(11) DEFAULT '0' COMMENT '捐献银两',
  `donate` int(11) DEFAULT '0' COMMENT '获得的捐献值',
  `all_donate` int(11) DEFAULT '0' COMMENT '家族累计捐献值',
  `family_id` varchar(30) DEFAULT NULL COMMENT '家族ID',
  `family_name` varchar(30) DEFAULT NULL COMMENT '家族名称',
  `family_lv` smallint(4) DEFAULT '0' COMMENT '家族等级',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`),
  KEY `family_id` (`family_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='家族捐献日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_family_contribution_get_and_use`
--

CREATE TABLE IF NOT EXISTS `t_log_family_contribution_get_and_use` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `family_id` varchar(30) DEFAULT NULL COMMENT '家族ID',
  `family_name` varchar(30) DEFAULT NULL COMMENT '家族名称',
  `family_lv` smallint(4) DEFAULT '0' COMMENT '家族等级',
  `value` int(11) DEFAULT '0' COMMENT '捐献值',
  `itemID` int(11) DEFAULT '0' COMMENT '道具ID',
  `type` tinyint(2) DEFAULT '0' COMMENT '类型',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`),
  KEY `family_id` (`family_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='家族贡献获得与使用日志';


-- --------------------------------------------------------

--
-- 表的结构 `t_log_level_up`
--

CREATE TABLE IF NOT EXISTS `t_log_level_up` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(20) NOT NULL COMMENT '角色名',
  `ip` varchar(16) NOT NULL COMMENT 'IP',
  `prev_level` smallint(5) NOT NULL DEFAULT '0' COMMENT '前一等级',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '当前等级',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='玩家升级日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_market_sell`
--

CREATE TABLE IF NOT EXISTS `t_log_market_sell` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '帐号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `market_id` varchar(30) NOT NULL COMMENT '市场挂单ID',
  `sell_time` tinyint(3) NOT NULL COMMENT '销售时长(单位小时)',
  `rmb` int(3) NOT NULL COMMENT '寄售元宝数',
  `money` int(3) NOT NULL COMMENT '寄售银两数',
  `item_id` int(11) NOT NULL DEFAULT '0' COMMENT '出售物品ID',
  `item_num` tinyint(3) NOT NULL DEFAULT '0' COMMENT '出售物品数量',
  `is_bind` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否绑定',
  `detail` varchar(40) NOT NULL DEFAULT '0' COMMENT '详情',
  `sell_rmb` int(11) NOT NULL DEFAULT '0' COMMENT '价格(元宝)',
  `sell_money` int(11) NOT NULL DEFAULT '0' COMMENT '价格(银两)',
  `bill_type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '挂单类型(0商品,1卖银两,2卖元宝)',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='市场寄售日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_market_cancel_sell`
--

CREATE TABLE IF NOT EXISTS `t_log_market_cancel_sell` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '帐号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `market_id` varchar(30) NOT NULL COMMENT '市场挂单ID',
  `bill_type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '挂单类型(0商品,1卖银两,2卖元宝)',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='市场取消寄售日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_market_buy`
--

CREATE TABLE IF NOT EXISTS `t_log_market_buy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '帐号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `market_id` varchar(30) NOT NULL COMMENT '市场单挂ID',
  `use_rmb` int(11) NOT NULL COMMENT '使用元宝',
  `use_money` int(11) NOT NULL COMMENT '使用银两',
  `bill_type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '挂单类型(0商品,1卖银两,2卖元宝)',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='市场购买日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_jingjie`
--

CREATE TABLE IF NOT EXISTS `t_log_jingjie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `jingjieID` smallint(4) NOT NULL DEFAULT '0' COMMENT '境界ID',
  `jingjielv` smallint(4) NOT NULL DEFAULT '0' COMMENT '境界等级',
  `lingqi` smallint(4) DEFAULT NULL COMMENT '灵气',
  `itemNum` smallint(4) DEFAULT NULL COMMENT '道具数',
  `success` tinyint(3) DEFAULT NULL COMMENT '是否成功',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='境界提升日志';


-- --------------------------------------------------------

--
-- 表的结构 `t_log_jingjie_skill`
--

CREATE TABLE IF NOT EXISTS `t_log_jingjie_skill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `skillID` int(11) DEFAULT NULL COMMENT '技能ID',
  `skillName` varchar(30) DEFAULT NULL COMMENT '技能名',
  `skillLevel` smallint(4) DEFAULT NULL COMMENT '技能等级',
  `item_id` int(11) NOT NULL COMMENT '道具ID',
  `item_num` int(11) NOT NULL COMMENT '道具数量',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='境界技能升级日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_family_enter_and_exit`
--

CREATE TABLE IF NOT EXISTS `t_log_family_enter_and_exit` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `family_id` varchar(30) DEFAULT NULL COMMENT '家族ID',
  `family_name` varchar(30) DEFAULT NULL COMMENT '家族名称',
  `family_lv` smallint(4) DEFAULT '0' COMMENT '家族等级',
  `type` tinyint(2) DEFAULT NULL COMMENT '动作类型(1加入,2退出)',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='玩家进退家族日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_team`
--

CREATE TABLE IF NOT EXISTS `t_log_team` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `name1` varchar(30) DEFAULT NULL COMMENT '队员1',
  `name2` varchar(30) DEFAULT NULL COMMENT '队员2',
  `name3` varchar(30) DEFAULT NULL COMMENT '队员3',
  `name4` varchar(30) DEFAULT NULL COMMENT '队员4',
  `name5` varchar(30) DEFAULT NULL COMMENT '队员5',
  `type` tinyint(2) DEFAULT NULL COMMENT '动作类型(1加入,2退出)',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='玩家组队日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_friend`
--

CREATE TABLE IF NOT EXISTS `t_log_friend` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `targetName` varchar(30) DEFAULT NULL COMMENT '目标角色名',
  `type` tinyint(2) DEFAULT NULL COMMENT '动作类型(1加,2删)',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='好友申请日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_friend_chat`
--

CREATE TABLE IF NOT EXISTS `t_log_friend_chat` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `targetName` varchar(30) DEFAULT NULL COMMENT '目标角色名',
  `content` varchar(600) DEFAULT NULL COMMENT '内容',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='好友聊天日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_family_chat`
--

CREATE TABLE IF NOT EXISTS `t_log_family_chat` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `familyName` varchar(30) DEFAULT NULL COMMENT '家族名称',
  `content` varchar(600) DEFAULT NULL COMMENT '内容',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='家族聊天日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_deal`
--

CREATE TABLE IF NOT EXISTS `t_log_deal` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `item_get` varchar(1024) DEFAULT NULL COMMENT '获得的道具',
  `item_lose` varchar(1024) DEFAULT NULL COMMENT '失去的道具',
  `yinliang_get` int(11) DEFAULT NULL COMMENT '获得银两',
  `yinliang_lose` int(11) DEFAULT NULL COMMENT '失去银两',
  `target_account` varchar(40) NOT NULL COMMENT '目标账号名',
  `target_name` varchar(30) NOT NULL COMMENT '目标角色名',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='交易日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_skill_upgrade`
--

CREATE TABLE IF NOT EXISTS `t_log_skill_upgrade` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `skillID` int(11) DEFAULT NULL COMMENT '技能ID',
  `skillLevel` smallint(4) DEFAULT NULL COMMENT '技能等级',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='技能升级日志';

-- --------------------------------------------------------
-- ------ 宠物相关 start ------

--
-- 表的结构 `t_log_pet_up`
--

CREATE TABLE IF NOT EXISTS `t_log_pet_up` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `pet_uuid` varchar(40) NOT NULL COMMENT '宠物uuid',
  `owner_uuid` varchar(40) NOT NULL COMMENT '主人uuid',
  `config_id` smallint(4) DEFAULT NULL COMMENT '宠物类型ID',
  `lv` smallint(4) NOT NULL DEFAULT '0' COMMENT '宠物等级',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `pet_uuid` (`pet_uuid`),
  KEY `owner_uuid` (`owner_uuid`),
  KEY `config_id` (`config_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='宠物升级日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_pet_create`
--

CREATE TABLE IF NOT EXISTS `t_log_pet_create` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `pet_uuid` varchar(40) NOT NULL COMMENT '宠物uuid',
  `owner_uuid` varchar(40) NOT NULL COMMENT '主人uuid',
  `config_id` smallint(4) DEFAULT NULL COMMENT '宠物类型ID',
  `sum_zizhi` smallint(4) NOT NULL DEFAULT '0' COMMENT '资质',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `pet_uuid` (`pet_uuid`),
  KEY `owner_uuid` (`owner_uuid`),
  KEY `config_id` (`config_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='宠物获取日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_pet_del`
--

CREATE TABLE IF NOT EXISTS `t_log_pet_del` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `pet_uuid` varchar(40) NOT NULL COMMENT '宠物uuid',
  `owner_uuid` varchar(40) NOT NULL COMMENT '主人uuid',
  `config_id` smallint(4) DEFAULT NULL COMMENT '宠物类型ID',
  `sum_zizhi` smallint(4) NOT NULL DEFAULT '0' COMMENT '资质',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `pet_uuid` (`pet_uuid`),
  KEY `owner_uuid` (`owner_uuid`),
  KEY `config_id` (`config_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='宠物放生日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_pet_ronghe`
--

CREATE TABLE IF NOT EXISTS `t_log_pet_ronghe` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `pet_uuid` varchar(40) NOT NULL COMMENT '宠物uuid',
  `owner_uuid` varchar(40) NOT NULL COMMENT '主人uuid',
  `config_id` smallint(4) DEFAULT NULL COMMENT '宠物类型ID',
  `sum_zizhi` smallint(4) NOT NULL DEFAULT '0' COMMENT '资质',
  `add_zizhi` smallint(4) NOT NULL DEFAULT '0' COMMENT '资质增加',
  `pet_uuid_ass` varchar(40) NOT NULL COMMENT '被融合宠物uuid',
  `config_id_ass` smallint(4) DEFAULT NULL COMMENT '被融合宠物类型ID',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `pet_uuid` (`pet_uuid`),
  KEY `owner_uuid` (`owner_uuid`),
  KEY `config_id` (`config_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='宠物融合日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_pet_feed`
--

CREATE TABLE IF NOT EXISTS `t_log_pet_feed` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `pet_uuid` varchar(40) NOT NULL COMMENT '宠物uuid',
  `owner_uuid` varchar(40) NOT NULL COMMENT '主人uuid',
  `config_id` smallint(4) DEFAULT NULL COMMENT '宠物类型ID',
  `food_item_id` smallint(4) NOT NULL DEFAULT '0' COMMENT '食物道具ID',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `pet_uuid` (`pet_uuid`),
  KEY `owner_uuid` (`owner_uuid`),
  KEY `config_id` (`config_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='宠物喂食日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_pet_jingjie_up`
--

CREATE TABLE IF NOT EXISTS `t_log_pet_jingjie_up` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `pet_uuid` varchar(40) NOT NULL COMMENT '宠物uuid',
  `owner_uuid` varchar(40) NOT NULL COMMENT '主人uuid',
  `config_id` smallint(4) DEFAULT NULL COMMENT '宠物类型ID',
  `jingjie_id_old` smallint(4) DEFAULT '0' COMMENT '旧境界层次',
  `jingjie_cnt_old` int(1) DEFAULT '0' COMMENT '旧境界次数',
  `jingjie_id_new` smallint(4) DEFAULT '0' COMMENT '新境界层次',
  `jingjie_cnt_new` int(11) DEFAULT '0' COMMENT '新境界次数',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `pet_uuid` (`pet_uuid`),
  KEY `owner_uuid` (`owner_uuid`),
  KEY `config_id` (`config_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='宠物境界提升日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_pet_skill_up`
--

CREATE TABLE IF NOT EXISTS `t_log_pet_skill_up` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `owner_uuid` varchar(40) NOT NULL COMMENT '主人uuid',
  `skill_id` smallint(4) DEFAULT NULL COMMENT '技能ID',
  `is_fail` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否失败(0成功,1失败)',
  `skill_lv` smallint(4) NOT NULL DEFAULT '0' COMMENT '技能等级',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `owner_uuid` (`owner_uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='宠物技能提升日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_pet_skill_forget`
--

CREATE TABLE IF NOT EXISTS `t_log_pet_skill_forget` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `pet_uuid` varchar(40) NOT NULL COMMENT '宠物uuid',
  `owner_uuid` varchar(40) NOT NULL COMMENT '主人uuid',
  `config_id` smallint(4) DEFAULT NULL COMMENT '宠物类型ID',
  `skill_id` smallint(4) DEFAULT NULL COMMENT '技能ID',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `pet_uuid` (`pet_uuid`),
  KEY `owner_uuid` (`owner_uuid`),
  KEY `config_id` (`config_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='宠物技能遗忘日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_pet_huaxing`
--

CREATE TABLE IF NOT EXISTS `t_log_pet_huaxing` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `pet_uuid` varchar(40) NOT NULL COMMENT '宠物uuid',
  `owner_uuid` varchar(40) NOT NULL COMMENT '主人uuid',
  `config_id` smallint(4) DEFAULT NULL COMMENT '宠物类型ID',
  `step` smallint(4) DEFAULT NULL COMMENT '步骤',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `pet_uuid` (`pet_uuid`),
  KEY `owner_uuid` (`owner_uuid`),
  KEY `config_id` (`config_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='宠物换形日志';

-- --------------------------------------------------------
-- ------ 宠物相关 end ------

--
-- 表的结构 `t_log_refine_strengthen`
--

CREATE TABLE IF NOT EXISTS `t_log_refine_strengthen` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `equip_id` int(11) NOT NULL DEFAULT '0' COMMENT '装备ID',
  `is_up` smallint(4) DEFAULT NULL COMMENT '是否成功',
  `strengthen_lv` smallint(4) DEFAULT NULL COMMENT '强化等级',
  `use_money` int(11) DEFAULT '0' COMMENT '消耗银两',
  `use_item_id` int(11) DEFAULT '0' COMMENT '消耗道具ID',
  `use_item_cnt` int(11) DEFAULT '0' COMMENT '消耗道具数量',
  `use_rmb` int(11) DEFAULT '0' COMMENT '消耗金钱',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='神炉强化日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_refine_purify`
--

CREATE TABLE IF NOT EXISTS `t_log_refine_purify` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `equip_id` int(11) NOT NULL DEFAULT '0' COMMENT '装备ID',
  `purify_cnt` int(11) NOT NULL DEFAULT '0' COMMENT '精炼次数',
  `use_money` int(11) DEFAULT '0' COMMENT '消耗银两',
  `use_item_id` int(11) DEFAULT '0' COMMENT '消耗道具ID',
  `use_item_cnt` int(11) DEFAULT '0' COMMENT '消耗道具数量',
  `use_rmb` int(11) DEFAULT '0' COMMENT '消耗金钱',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='神炉精炼日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_refine_purify_reset`
--

CREATE TABLE IF NOT EXISTS `t_log_refine_purify_reset` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `equip_id` int(11) NOT NULL DEFAULT '0' COMMENT '装备ID',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='神炉精炼重置日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_refine_inlay`
--

CREATE TABLE IF NOT EXISTS `t_log_refine_inlay` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `is_inlay` smallint(4) NOT NULL DEFAULT '0' COMMENT '是否成功',
  `equip_id` int(11) NOT NULL DEFAULT '0' COMMENT '装备ID',
  `gem_id` int(11) NOT NULL DEFAULT '0' COMMENT '宝石ID',
  `use_money` int(11) DEFAULT '0' COMMENT '消耗银两',
  `use_item_id` int(11) DEFAULT '0' COMMENT '消耗道具ID',
  `use_item_cnt` int(11) DEFAULT '0' COMMENT '消耗道具数量',
  `use_rmb` int(11) DEFAULT '0' COMMENT '消耗金钱',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='宝石镶嵌日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_refine_extend`
--

CREATE TABLE IF NOT EXISTS `t_log_refine_extend` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `equip1_id` int(11) NOT NULL DEFAULT '0' COMMENT '装备1 ID',
  `equip1_cnt` int(11) DEFAULT '0' COMMENT '装备1数量',
  `equip1_bind` int(11) DEFAULT NULL COMMENT '装备1是否绑定',
  `equip1_detail` int(11) DEFAULT NULL COMMENT '装备1详情',
  `equip2_id` int(11) NOT NULL DEFAULT '0' COMMENT '装备2 ID',
  `equip2_cnt` int(11) DEFAULT '0' COMMENT '装备2数量',
  `equip2_bind` int(11) DEFAULT NULL COMMENT '装备2是否绑定',
  `equip2_detail` int(11) DEFAULT NULL COMMENT '装备2详情',
  `equip_new_id` int(11) NOT NULL DEFAULT '0' COMMENT '新装备ID',
  `equip_new_cnt` int(11) DEFAULT '0' COMMENT '新装备数量',
  `equip_new_bind` int(11) DEFAULT NULL COMMENT '新装备是否绑定',
  `equip_new_detail` int(11) DEFAULT NULL COMMENT '新装备详情',
  `use_money` int(11) DEFAULT '0' COMMENT '消耗银两',
  `use_item_id` int(11) DEFAULT '0' COMMENT '消耗道具ID',
  `use_item_cnt` int(11) DEFAULT '0' COMMENT '消耗道具数量',
  `use_rmb` int(11) DEFAULT '0' COMMENT '消耗金钱',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='装备继承日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_copy`
--

CREATE TABLE IF NOT EXISTS `t_log_copy` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `copy_id` smallint(4) NOT NULL DEFAULT '0' COMMENT '副本ID',
  `enter_times` int(11) DEFAULT '0' COMMENT '进入次数',
  `action` tinyint(2) DEFAULT '0' COMMENT '动作(1开始,2退出)',
  `status` smallint(4) DEFAULT '0' COMMENT '副本状态',
  `percent` smallint(4) DEFAULT '0' COMMENT '副本进度',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='副本日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_client_info`
--

CREATE TABLE IF NOT EXISTS `t_log_client_info` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `cpuArchitecture` varchar(40) DEFAULT NULL COMMENT 'CPU 体系结构',
  `isDebugger` tinyint(2) DEFAULT '0' COMMENT '是否调试版本',
  `language` varchar(40) DEFAULT NULL COMMENT '语言',
  `os` varchar(40) DEFAULT NULL COMMENT '操作系统',
  `playerType` varchar(40) DEFAULT NULL COMMENT '运行时环境的类型',
  `screenDPI` int(11) DEFAULT '0' COMMENT '屏幕dpi',
  `screenResolutionX` int(11) DEFAULT '0' COMMENT '屏幕的最大水平分辨率',
  `screenResolutionY` int(11) DEFAULT '0' COMMENT '屏幕的最大垂直分辨率',
  `touchscreenType` varchar(40) DEFAULT NULL COMMENT '触摸屏类型',
  `version` varchar(40) DEFAULT NULL COMMENT 'Flash Player版本',
  `font` int(11) DEFAULT NULL COMMENT '字体类型:0宋体,1黑体,2幼圆,3楷体',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='客户端系统信息日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_client_err_load`
--

CREATE TABLE IF NOT EXISTS `t_log_client_err_load` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `is_decode` varchar(30) DEFAULT NULL COMMENT '是否解码错误',
  `url` varchar(1024) DEFAULT NULL COMMENT 'URL',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='客户端加载和解码报错日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_client_err_mem_map`
--

CREATE TABLE IF NOT EXISTS `t_log_client_err_mem_map` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `map_id` int(11) NOT NULL DEFAULT '0' COMMENT '所在地图ID',
  `privateMemory` int(11) NOT NULL DEFAULT '0' COMMENT '进程所有内存',
  `totalMemory` int(11) NOT NULL DEFAULT '0' COMMENT '用户所有内存',
  `freeMemory` int(11) NOT NULL DEFAULT '0' COMMENT '用户空闲内存',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='客户端地图加载内存问题日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_home_op`
--

CREATE TABLE IF NOT EXISTS `t_log_home_op` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `action` tinyint(2) DEFAULT '0' COMMENT '操作类型',
  `o_uuid` varchar(40) NOT NULL COMMENT '操作对象的uuid',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='家园操作日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_home_fang`
--

CREATE TABLE IF NOT EXISTS `t_log_home_fang` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `action` tinyint(2) DEFAULT '0' COMMENT '操作类型',
  `exp` int(11) DEFAULT '0' COMMENT '获得经验',
  `satisfy` int(11) DEFAULT '0' COMMENT '满意度',
  `status` int(11) DEFAULT '0' COMMENT '退出状态',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='家园塔防操作日志';
-- --------------------------------------------------------

--
-- 表的结构 `t_log_admin`
--
CREATE TABLE IF NOT EXISTS `t_log_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `applyID` int(11) DEFAULT NULL COMMENT '申请ID',
  `items` varchar(1024) DEFAULT NULL COMMENT '道具详情',
  `visible` tinyint(1) DEFAULT '1' COMMENT '是否可见',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `applyID` (`applyID`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='道具赠送日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_gm_code`
--
CREATE TABLE IF NOT EXISTS `t_log_gm_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `cmd` varchar(30) DEFAULT NULL COMMENT '命令',
  `arg` varchar(30) DEFAULT NULL COMMENT '参数',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='GM指令操作日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_chat`
--

CREATE TABLE IF NOT EXISTS `t_log_chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `ip` varchar(16) DEFAULT NULL COMMENT 'IP',
  `channel` tinyint(2) DEFAULT NULL COMMENT '聊天频道',
  `content` varchar(600) DEFAULT NULL COMMENT '内容',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='聊天日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_drop_item`
--

CREATE TABLE IF NOT EXISTS `t_log_drop_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `role_scene_id` int(11) NOT NULL DEFAULT '0' COMMENT '场景ID',
  `obj_id` int(11) NOT NULL DEFAULT '0' COMMENT '物品ID',
  `obj_type` int(11) NOT NULL DEFAULT '0' COMMENT '物品类型',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='掉落非法ID日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_hang`
-- 

CREATE TABLE IF NOT EXISTS `t_log_hang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `type` tinyint(2) NOT NULL COMMENT '类型:0打坐 1钓鱼 2挖矿',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '时长',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='打坐挂机日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_skill_main_menu`
-- 

CREATE TABLE IF NOT EXISTS `t_log_skill_main_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL COMMENT '等级',
  `job` tinyint(2) NOT NULL COMMENT '职业',
  `skills` varchar(255) DEFAULT NULL COMMENT '技能列表:ID*等级*仙符',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='技能快捷栏日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_collect_revive`
-- 

CREATE TABLE IF NOT EXISTS `t_log_collect_revive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `help_uuid` varchar(40) NOT NULL COMMENT '被救者uuid',
  `help_name` varchar(30) NOT NULL COMMENT '被救角色名',
  `map_id` int(11) NOT NULL DEFAULT '0' COMMENT '所在地图ID',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='采集复活日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_jhdt_info`
-- 

CREATE TABLE IF NOT EXISTS `t_log_jhdt_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `result` tinyint(2) NOT NULL COMMENT '副本结果',
  `copy_time` int(11) NOT NULL COMMENT '副本耗时(ms)',
  `name1` varchar(30) DEFAULT NULL COMMENT '队员1',
  `name2` varchar(30) DEFAULT NULL COMMENT '队员2',
  `name3` varchar(30) DEFAULT NULL COMMENT '队员3',
  `name4` varchar(30) DEFAULT NULL COMMENT '队员4',
  `name5` varchar(30) DEFAULT NULL COMMENT '队员5',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='晶幻洞天通关日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_xxwd_collect`
-- 

CREATE TABLE IF NOT EXISTS `t_log_xxwd_collect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `room_id` int(11) NOT NULL COMMENT '房间ID',
  `type` tinyint(2) NOT NULL COMMENT '采集物,1鼎2青龙3朱雀4白虎5玄武',
  `time` int(11) NOT NULL COMMENT '持续时间',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='仙邪问鼎采集日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_xxwd_score`
-- 

CREATE TABLE IF NOT EXISTS `t_log_xxwd_score` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `room_id` int(11) NOT NULL COMMENT '房间ID',
  `score1` int(11) NOT NULL DEFAULT '0' COMMENT '仙宗得分',
  `score2` int(11) NOT NULL DEFAULT '0' COMMENT '邪宗得分',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='仙邪问鼎比分日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_xxwd_board`
-- 

CREATE TABLE IF NOT EXISTS `t_log_xxwd_board` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `room_id` int(11) NOT NULL COMMENT '房间ID',
  `rank` int(11) NOT NULL COMMENT '排名',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `name` varchar(30) NOT NULL COMMENT '角色名',
  `job` tinyint(2) DEFAULT NULL COMMENT '职业',
  `kill_cnt` int(11) NOT NULL DEFAULT '0' COMMENT '击杀数',
  `help_cnt` int(11) NOT NULL DEFAULT '0' COMMENT '助攻',
  `die_cnt` int(11) NOT NULL DEFAULT '0' COMMENT '死亡次数',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '个人得分',
  `camp` int(11) NOT NULL DEFAULT '0' COMMENT '阵营:1仙宗2邪宗',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='仙邪问鼎排行榜';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_yjxb_skill`
-- 

CREATE TABLE IF NOT EXISTS `t_log_yjxb_skill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `scene_id` int(11) NOT NULL COMMENT '房间ID',
  `skill_id` int(11) NOT NULL COMMENT '技能ID',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='遗迹寻宝技能使用日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_yjxb_collect`
-- 

CREATE TABLE IF NOT EXISTS `t_log_yjxb_collect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `scene_id` int(11) NOT NULL COMMENT '房间ID',
  `collect_id` int(11) NOT NULL COMMENT '采集物ID',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='遗迹寻宝宝箱采集日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_yjxb_jb`
-- 

CREATE TABLE IF NOT EXISTS `t_log_yjxb_jb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `scene_id` int(11) NOT NULL COMMENT '房间ID',
  `jb` int(11) NOT NULL COMMENT '金币数',
  `is_from_human` tinyint(2) NOT NULL COMMENT '是否人死亡掉落',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='遗迹寻宝金币拾取掉落日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_bmsl_live`
-- 

CREATE TABLE IF NOT EXISTS `t_log_bmsl_live` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `job` tinyint(2) DEFAULT NULL COMMENT '职业',
  `scene_id` int(11) NOT NULL COMMENT '房间ID',
  `room_monster_strength` int(11) NOT NULL DEFAULT '0' COMMENT '怪物强度',
  `score_all` int(11) NOT NULL DEFAULT '0' COMMENT '个人得分',
  `save_cnt` int(11) NOT NULL DEFAULT '0' COMMENT '拯救队友次数',
  `live_sec` int(11) NOT NULL COMMENT '生存时间(s)',
  `rank` int(11) NOT NULL COMMENT '排名',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='不灭试炼存活玩家/排行榜';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_bmsl_jyzs`
-- 

CREATE TABLE IF NOT EXISTS `t_log_bmsl_jyzs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `jyzs` int(5) NOT NULL DEFAULT '0' COMMENT '数量',
  `type` int(5) NOT NULL DEFAULT '0' COMMENT '消费类型',
  `remain_jyzs` int(5) NOT NULL DEFAULT '0' COMMENT '剩余数量',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='不灭试炼记忆之石日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_mwbd_join_info`
-- 

CREATE TABLE IF NOT EXISTS `t_log_mwbd_join_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='魔物暴动活动参加日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_mwbd_role_cnt`
-- 

CREATE TABLE IF NOT EXISTS `t_log_mwbd_role_cnt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `mapID` int(11) NOT NULL DEFAULT '0' COMMENT '地图ID',
  `cnt` int(5) NOT NULL DEFAULT '0' COMMENT '人数',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='魔物暴动地图人数日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_mwbd_monster_die`
-- 

CREATE TABLE IF NOT EXISTS `t_log_mwbd_monster_die` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `monsterID` int(11) NOT NULL DEFAULT '0' COMMENT '怪物ID',
  `type` int(5) NOT NULL DEFAULT '0' COMMENT '怪物类型',
  `mapID` int(11) NOT NULL DEFAULT '0' COMMENT '地图ID',
  `atkUuid` varchar(40) NOT NULL COMMENT 'uuid',
  `atkName` varchar(30) NOT NULL COMMENT '角色名',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='魔物暴动怪物死亡日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_mwbd_family_rank`
-- 

CREATE TABLE IF NOT EXISTS `t_log_mwbd_family_rank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `rank` int(11) NOT NULL COMMENT '排名',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '得分',
  `familyUuid` varchar(40) NOT NULL COMMENT '家族uuid',
  `familyName` varchar(30) DEFAULT NULL COMMENT '家族名称',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='魔物暴动怪物死亡统计';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_bug`
-- 

CREATE TABLE IF NOT EXISTS `t_log_bug` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `content` varchar(1024) DEFAULT NULL COMMENT '内容',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='玩家提BUG或建议';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_wanted`
-- 

CREATE TABLE IF NOT EXISTS `t_log_wanted` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `leftCnt` tinyint(2) DEFAULT '0' COMMENT '剩余通缉令',
  `costCnt` tinyint(2) DEFAULT '0' COMMENT '消耗通缉令',
  `monsterID` int(11) NOT NULL DEFAULT '0' COMMENT '怪物ID',
  `monsterName` varchar(30) NOT NULL COMMENT '怪物名称',
  `hot` smallint(2) DEFAULT '0' COMMENT '热度',
  `type` tinyint(2) NOT NULL COMMENT '操作类型:1挑战2放弃',
  `op` tinyint(2) DEFAULT '0' COMMENT '结果:1成功0失败',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='通缉令挑战日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_huoyue`
-- 

CREATE TABLE IF NOT EXISTS `t_log_huoyue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `act_id` smallint(4) DEFAULT '0' COMMENT '活动id',
  `leftCnt` smallint(2) DEFAULT '0' COMMENT '剩余次数',
  `huoyuedu` int(11) NOT NULL DEFAULT '0' COMMENT '获得活跃度',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='玩家活跃日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_open_vip`
-- 

CREATE TABLE IF NOT EXISTS `t_log_open_vip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `yellowDiamond` tinyint(2) DEFAULT '0' COMMENT '普通黄钻',
  `yellowDiamondYear` tinyint(2) DEFAULT '0' COMMENT '年费黄钻',
  `yellowDiamondLv` smallint(2) DEFAULT '0' COMMENT '黄钻等级',
  `isYear` smallint(2) DEFAULT '0' COMMENT '开通年费黄钻',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='黄钻开通日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_buy_goods`
-- 

CREATE TABLE IF NOT EXISTS `t_log_buy_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `item_id` int(11) NOT NULL COMMENT '道具ID',
  `item_cnt` int(11) NOT NULL COMMENT '道具数量',
  `price` int(11) NOT NULL COMMENT '单价',
  `total_cost` int(11) NOT NULL COMMENT '总价',
  `ts` int(11) NOT NULL DEFAULT '0' COMMENT '时间',
  `billno` varchar(70) NOT NULL COMMENT '流水号',
  `pubacct` int(11) NOT NULL DEFAULT '0' COMMENT '抵扣券',
  `amt` int(11) NOT NULL DEFAULT '0' COMMENT 'Q币Q点*0.1',
  `pf` varchar(40) DEFAULT NULL COMMENT '平台',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='Q点购买道具日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_shop_rand`
-- 

CREATE TABLE IF NOT EXISTS `t_log_shop_rand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `yinliang` int(11) NOT NULL DEFAULT '0' COMMENT '铜币',
  `yuanbao` int(11) NOT NULL DEFAULT '0' COMMENT '仙石',
  `is_vip` tinyint(2) NOT NULL COMMENT '是否Vip',
  `npc_id` int(11) NOT NULL DEFAULT '0' COMMENT 'NpcID',
  `item_id` int(11) NOT NULL COMMENT '道具ID',
  `item_sum` int(11) NOT NULL COMMENT '道具数量',
  `price` int(11) NOT NULL COMMENT '单价',
  `grid_num` smallint(4) NOT NULL COMMENT '位置',
  `money_type` int(5) NOT NULL COMMENT '货币类型',
  `is_buy` tinyint(2) NOT NULL COMMENT '是否购买',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`),
  KEY `item_id` (`item_id`),
  KEY `npc_id` (`npc_id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='神秘商店日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_talisman_upgrade`
-- 

CREATE TABLE IF NOT EXISTS `t_log_talisman_upgrade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `talisman_name` varchar(30) NOT NULL COMMENT '法宝名称',
  `item_id` int(11) NOT NULL COMMENT '道具ID',
  `item_cnt` int(11) NOT NULL COMMENT '道具数量',
  `result` tinyint(2) NOT NULL COMMENT '进阶结果',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='法宝进阶日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_talisman_illusion`
-- 

CREATE TABLE IF NOT EXISTS `t_log_talisman_illusion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `talisman_name` varchar(30) NOT NULL COMMENT '法宝名称',
  `get_way` tinyint(2) NOT NULL COMMENT '激活方式:1进阶2道具使用0GM指令',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='法宝激活幻化日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_billboard_role_atk`
-- 

CREATE TABLE IF NOT EXISTS `t_log_billboard_role_atk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `atk` int(5) NOT NULL DEFAULT '0' COMMENT '战斗力',
  `rank` int(11) NOT NULL COMMENT '排名',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='战力排行榜';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_npc_shop_buy`
-- 

CREATE TABLE IF NOT EXISTS `t_log_npc_shop_buy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `shop_npc_id` int(11) NOT NULL DEFAULT '0' COMMENT 'npc商人ID',
  `item_id` int(11) NOT NULL COMMENT '道具ID',
  `item_cnt` int(11) NOT NULL DEFAULT '0' COMMENT '道具数量',
  `money_type` int(5) NOT NULL COMMENT '货币类型',
  `price` int(11) NOT NULL COMMENT '单价',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`),
  KEY `shop_npc_id` (`shop_npc_id`),
  KEY `item_id` (`item_id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='npc商店购买日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_delete`
--

CREATE TABLE IF NOT EXISTS `t_log_delete` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `ip` varchar(16) DEFAULT NULL COMMENT 'IP',
  `job` tinyint(2) DEFAULT NULL COMMENT '职业',
  `sex` tinyint(2) DEFAULT NULL COMMENT '性别',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `mtime` (`mtime`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='删号日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_task_market`
--

CREATE TABLE IF NOT EXISTS `t_log_task_market` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `contract_id` varchar(40) DEFAULT NULL COMMENT '任务ID',
  `status` tinyint(2) DEFAULT NULL COMMENT '状态',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `mtime` (`mtime`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='任务集市日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_middle`
--

CREATE TABLE IF NOT EXISTS `t_log_middle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `status` tinyint(2) DEFAULT NULL COMMENT '状态',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `mtime` (`mtime`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='跨服切换日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_blue_icon`
--

CREATE TABLE IF NOT EXISTS `t_log_blue_icon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `mtime` (`mtime`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='蓝钻icon日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_blue_libao`
--

CREATE TABLE IF NOT EXISTS `t_log_blue_libao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `type` smallint(4) NOT NULL DEFAULT '0' COMMENT '类型',
  `lv` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `mtime` (`mtime`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='蓝钻礼包日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_bind_money`
--

CREATE TABLE IF NOT EXISTS `t_log_bind_money` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `money` int(11) DEFAULT NULL COMMENT '银两',
  `type` int(5) DEFAULT NULL COMMENT '消费类型',
  `item_id` int(11) DEFAULT NULL COMMENT '获得物品ID',
  `num` int(11) DEFAULT NULL COMMENT '物品数量',
  `remain_money` int(11) DEFAULT NULL COMMENT '剩余银两',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `mtime` (`mtime`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='绑定银两获得使用日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_refine_resolve`
--

CREATE TABLE IF NOT EXISTS `t_log_refine_resolve` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `item_id` int(11) DEFAULT NULL COMMENT '物品ID',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `mtime` (`mtime`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='神炉拆解日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_yuanbao_sum`
--

CREATE TABLE IF NOT EXISTS `t_log_yuanbao_sum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `yuanbaosum` int(11) DEFAULT NULL COMMENT '累计充值元宝',
  `yuanbao` int(11) DEFAULT NULL COMMENT '本次充值元宝',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `mtime` (`mtime`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='累计充值日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_vein_lv`
--

CREATE TABLE IF NOT EXISTS `t_log_vein_lv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `veinLv` smallint(4) NOT NULL COMMENT '龙脉等级',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `mtime` (`mtime`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='龙脉升级日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_marry_ask`
--

CREATE TABLE IF NOT EXISTS `t_log_marry_ask` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `targetUuid` varchar(40) NOT NULL COMMENT '目标uuid',
  `target_account_name` varchar(40) NOT NULL COMMENT '目标账号名',
  `target_role_name` varchar(30) NOT NULL COMMENT '目标角色名',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `mtime` (`mtime`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`),
  KEY `targetUuid` (`targetUuid`),
  KEY `target_account_name` (`target_account_name`),
  KEY `target_role_name` (`target_role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='求婚日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_marry_ask_result`
--

CREATE TABLE IF NOT EXISTS `t_log_marry_ask_result` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `targetUuid` varchar(40) NOT NULL COMMENT '求婚者uuid',
  `target_account_name` varchar(40) NOT NULL COMMENT '求婚者账号名',
  `target_role_name` varchar(30) NOT NULL COMMENT '求婚者角色名',
  `result` tinyint(2) NOT NULL DEFAULT '0' COMMENT '求婚结果:1成功0失败',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `mtime` (`mtime`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`),
  KEY `targetUuid` (`targetUuid`),
  KEY `target_account_name` (`target_account_name`),
  KEY `target_role_name` (`target_role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='求婚结果日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_marry_book`
--

CREATE TABLE IF NOT EXISTS `t_log_marry_book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid1` varchar(40) NOT NULL COMMENT 'uuid1',
  `role_name1` varchar(30) NOT NULL COMMENT '角色名1',
  `uuid2` varchar(40) NOT NULL COMMENT 'uuid2',
  `role_name2` varchar(30) NOT NULL COMMENT '角色名2',
  `price` int(11) NOT NULL DEFAULT '0' COMMENT '婚宴价格',
  `book_time` int(11) NOT NULL DEFAULT '0' COMMENT '婚宴场次时间',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `mtime` (`mtime`),
  KEY `uuid1` (`uuid1`),
  KEY `role_name1` (`role_name1`),
  KEY `uuid2` (`uuid2`),
  KEY `role_name2` (`role_name2`),
  KEY `book_time` (`book_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='婚宴预约日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_billboard_wing`
--

CREATE TABLE IF NOT EXISTS `t_log_billboard_wing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '仙羽等级',
  `zhandouli` int(5) NOT NULL DEFAULT '0' COMMENT '仙羽战斗力',
  `wingname` varchar(30) NOT NULL COMMENT '仙羽名',
  `rank` int(11) NOT NULL COMMENT '排名',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='仙羽排行榜';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_marry_divorce`
--

CREATE TABLE IF NOT EXISTS `t_log_marry_divorce` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `divorceType` tinyint(2) NOT NULL DEFAULT '0' COMMENT '离婚类型：0非强制1强制',
  `moneyType` tinyint(2) NOT NULL DEFAULT '0' COMMENT '货币类型：0绑定仙石1仙石',
  `money` int(4) NOT NULL DEFAULT '0' COMMENT '消耗仙石',
  `operator` tinyint(2) NOT NULL DEFAULT '0' COMMENT '操作者：1提出0同意',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='离婚日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_marry_xianyuanzhi`
--

CREATE TABLE IF NOT EXISTS `t_log_marry_xianyuanzhi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `xianyuanzhi` int(11) NOT NULL DEFAULT '0' COMMENT '仙缘值',
  `type` int(5) NOT NULL DEFAULT '0' COMMENT '类型',
  `remain_xianyuanzhi` int(11) NOT NULL DEFAULT '0' COMMENT '剩余仙缘值',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='仙缘值日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_middle_boss_result`
-- 

CREATE TABLE IF NOT EXISTS `t_log_middle_boss_result` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `result` tinyint(2) NOT NULL DEFAULT '0' COMMENT '结果:0失败1成功',
  `succeed` int(5) NOT NULL DEFAULT '0' COMMENT '连续成功次数',
  `fail` int(5) NOT NULL DEFAULT '0' COMMENT '连续失败次数',
  `lv` int(5) NOT NULL DEFAULT '0' COMMENT 'boss等级',
  `kill_uuid` varchar(40) NOT NULL COMMENT '杀死boss的人',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `mtime` (`mtime`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='跨服BOSS活动结果';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_middle_boss_board`
-- 

CREATE TABLE IF NOT EXISTS `t_log_middle_boss_board` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `hurt` int(11) NOT NULL DEFAULT '0' COMMENT '伤害',
  `job` tinyint(2) DEFAULT NULL COMMENT '职业',
  `zhandouli` int(11) NOT NULL DEFAULT '0' COMMENT '战斗力',
  `rank` int(5) NOT NULL DEFAULT '0' COMMENT '排名',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `mtime` (`mtime`),
  KEY `uuid` (`uuid`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='跨服BOSS伤害排行';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_billboard_horse`
--

CREATE TABLE IF NOT EXISTS `t_log_billboard_horse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `zhandouli` int(5) NOT NULL DEFAULT '0' COMMENT '坐骑战斗力',
  `rank` int(11) NOT NULL COMMENT '排名',
  `horse_lv` smallint(4) NOT NULL DEFAULT '0' COMMENT '坐骑等级',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='坐骑排行榜';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_billboard_pet_zhandouli`
--

CREATE TABLE IF NOT EXISTS `t_log_billboard_pet_zhandouli` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `petLv` smallint(4) NOT NULL DEFAULT '0' COMMENT '宠物等级',
  `zhandouli` int(5) NOT NULL DEFAULT '0' COMMENT '宠物战斗力',
  `rank` int(11) NOT NULL COMMENT '排名',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='宠物战力排行榜';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_billboard_pet_jingjie`
--

CREATE TABLE IF NOT EXISTS `t_log_billboard_pet_jingjie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `petLv` smallint(4) NOT NULL DEFAULT '0' COMMENT '宠物等级',
  `name1` varchar(30) NOT NULL COMMENT '境界层次',
  `name2` varchar(30) NOT NULL COMMENT '细分段',
  `rank` int(11) NOT NULL COMMENT '排名',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='宠物境界排行榜';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_billboard_pet_zizhi`
--

CREATE TABLE IF NOT EXISTS `t_log_billboard_pet_zizhi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `petLv` smallint(4) NOT NULL DEFAULT '0' COMMENT '宠物等级',
  `zizhi` int(4) NOT NULL DEFAULT '0' COMMENT '宠物资质',
  `rank` int(11) NOT NULL COMMENT '排名',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='宠物资质排行榜';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_refine_inlay_gem2`
--

CREATE TABLE IF NOT EXISTS `t_log_refine_inlay_gem2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `is_inlay` int(11) NOT NULL DEFAULT '0' COMMENT '值',
  `equip_id` int(5) NOT NULL DEFAULT '0' COMMENT '装备ID',
  `gem_id` int(11) NOT NULL DEFAULT '0' COMMENT '灵石ID',
  `use_money` int(11) NOT NULL DEFAULT '0' COMMENT '消耗铜币',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='圣纹镶嵌日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_shop_djxg_get`
--

CREATE TABLE IF NOT EXISTS `t_log_shop_djxg_get` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `get_which_level` smallint(4) NOT NULL DEFAULT '0' COMMENT '领取礼包的等级',
  `mul` int(5) NOT NULL DEFAULT '0' COMMENT '领取倍数',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='等级限购礼包领取日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_shop_djxg_buy`
--

CREATE TABLE IF NOT EXISTS `t_log_shop_djxg_buy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `get_which_level` smallint(4) NOT NULL DEFAULT '0' COMMENT '购买礼包的等级',
  `item_id` int(11) NOT NULL COMMENT '道具ID',
  `item_cnt` int(11) NOT NULL COMMENT '道具数量',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`),
  KEY `item_id` (`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='等级限购商品购买日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_talisman_uplevel`
--

CREATE TABLE IF NOT EXISTS `t_log_talisman_uplevel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `new_level` smallint(4) NOT NULL COMMENT '升级后坐骑等级',
  `new_exp` int(11) NOT NULL COMMENT '升级后坐骑经验',
  `old_level` smallint(4) NOT NULL COMMENT '升级前坐骑等级',
  `old_exp` int(11) NOT NULL COMMENT '升级前坐骑经验',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='坐骑升级日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_wing_uplevel`
--

CREATE TABLE IF NOT EXISTS `t_log_wing_uplevel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `new_level` smallint(4) NOT NULL COMMENT '升级后翅膀等级',
  `new_exp` int(11) NOT NULL COMMENT '升级后翅膀经验',
  `old_level` smallint(4) NOT NULL COMMENT '升级前翅膀等级',
  `old_exp` int(11) NOT NULL COMMENT '升级前翅膀经验',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='翅膀升级日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_open_vip_blue`
--

CREATE TABLE IF NOT EXISTS `t_log_open_vip_blue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `openid` varchar(40) NOT NULL COMMENT 'openid',
  `discountid` varchar(40) NOT NULL COMMENT '活动id',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `openid` (`openid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='开通蓝钻日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_open_vip_yellow`
--

CREATE TABLE IF NOT EXISTS `t_log_open_vip_yellow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `openid` varchar(40) NOT NULL COMMENT 'openid',
  `discountid` varchar(40) NOT NULL COMMENT '活动id',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `openid` (`openid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='开通黄钻日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_billboard_jingji`
--

CREATE TABLE IF NOT EXISTS `t_log_billboard_jingji` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `job` tinyint(2) DEFAULT NULL COMMENT '职业',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '得分',
  `rank` int(11) NOT NULL COMMENT '排名',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='神武擂台排行榜';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_billboard_flower_sum`
--

CREATE TABLE IF NOT EXISTS `t_log_billboard_flower_sum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `job` tinyint(2) DEFAULT NULL COMMENT '职业',
  `cnt` int(11) NOT NULL DEFAULT '0' COMMENT '鲜花',
  `rank` int(11) NOT NULL COMMENT '排名',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='鲜花排行榜';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_pay`
-- 

CREATE TABLE IF NOT EXISTS `t_log_pay` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `ts` int(11) NOT NULL DEFAULT '0' COMMENT '时间',
  `billno` varchar(70) NOT NULL COMMENT '充值订单',
  `amt` int(11) NOT NULL DEFAULT '0' COMMENT '充值金额',
  `xianshiCnt` int(11) NOT NULL DEFAULT '0' COMMENT '充值仙石数',
  `online` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否在线',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='联运充值日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_check_frame`
-- 

CREATE TABLE IF NOT EXISTS `t_log_check_frame` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `speed` int(5) NOT NULL DEFAULT '0' COMMENT '速度',
  `serverX` int(11) NOT NULL DEFAULT '0' COMMENT '服务端X轴坐标',
  `serverY` int(11) NOT NULL DEFAULT '0' COMMENT '服务端Y轴坐标',
  `clientX` int(11) NOT NULL DEFAULT '0' COMMENT '客户端X轴坐标',
  `clientY` int(11) NOT NULL DEFAULT '0' COMMENT '客户端Y轴坐标',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='加速检测日志';

-- --------------------------------------------------------
--
-- 表的结构 `t_log_tybk`
--

CREATE TABLE IF NOT EXISTS `t_log_tybk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '帐号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `buy_item_id` int(11) NOT NULL COMMENT '获得道具ID',
  `buy_item_cnt` int(11) NOT NULL COMMENT '获得道具数量',
  `cost_item_id` int(11) NOT NULL COMMENT '失去道具ID',
  `cost_item_cnt` int(11) NOT NULL COMMENT '失去道具数量',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`),
  KEY `buy_item_id` (`buy_item_id`),
  KEY `cost_item_id` (`cost_item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='天元宝库兑换日志';

-- --------------------------------------------------------

-- 统计表 & 其他表 --

--
-- 表的结构 `t_log_online`
--

CREATE TABLE IF NOT EXISTS `t_log_online` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `online` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '在线人数',
  `onlineVip` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'vip在线人数',
  `year` smallint(4) unsigned NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '日',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='历史在线记录';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_etl_error`
--

CREATE TABLE IF NOT EXISTS `t_log_etl_error` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态(0失败,1成功)',
  `desc` varchar(50) NOT NULL COMMENT '错出说明',
  `table_name` varchar(50) NOT NULL COMMENT '表名',
  `path` varchar(150) NOT NULL COMMENT '志日路径',
  `try_times` tinyint(3) NOT NULL DEFAULT '0' COMMENT '重拉的次数',
  `reason` varchar(2000) NOT NULL COMMENT '原因',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `last_try_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后尝试时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='导入错误日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_apply_goods`
--

CREATE TABLE IF NOT EXISTS `t_apply_goods` (
  `applyID` int(11) NOT NULL AUTO_INCREMENT,
  `apply_person` varchar(50) NOT NULL COMMENT '申请人',
  `apply_time` int(11) NOT NULL COMMENT '申请时间',
  `yuanbao` int(11) DEFAULT '0' COMMENT '申请元宝',
  `liquan` int(11) DEFAULT '0' COMMENT '申请礼券',
  `yinliang` int(11) DEFAULT '0' COMMENT '申请银两',
  `apply_reason` varchar(255) DEFAULT NULL COMMENT '申请原因',
  `mailTitle` varchar(64) DEFAULT NULL COMMENT '信件标题',
  `mailContent` text DEFAULT NULL COMMENT '信件内容',
  `roleNameList` varchar(4096) DEFAULT NULL COMMENT '赠送玩家列表或者赠送条件',
  `item` varchar(2048) DEFAULT NULL COMMENT '赠送物品',
  `verify_result` tinyint(1) DEFAULT '1' COMMENT '审核结果',
  `verify_person` varchar(16) DEFAULT NULL COMMENT '审核人',
  `sendType` tinyint(1) DEFAULT NULL COMMENT '赠送类型,按玩家名赠送为0,按条件赠送为1',
  `visible` tinyint(1) DEFAULT '1' COMMENT '是否可见',
  PRIMARY KEY (`applyID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='道具赠送申请';

-- --------------------------------------------------------

--
-- 表的结构 `t_sendmail`
-- 

CREATE TABLE IF NOT EXISTS `t_sendmail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mtime` int(10) NOT NULL COMMENT '发送时间',
  `title` varchar(30) NOT NULL DEFAULT '' COMMENT '邮件标题',
  `content` text NOT NULL COMMENT '邮件内容',
  `receiver` text NOT NULL COMMENT '收件人',
  `result` tinyint(2) NOT NULL DEFAULT '0' COMMENT '发送结果',
  `success` int(11) NOT NULL DEFAULT '0' COMMENT '成功人数',
  `fail` int(11) NOT NULL DEFAULT '0' COMMENT '失败人数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='邮件发送记录';

-- -------------------------------------------------------

--
-- 表的结构 `t_message_broadcast`
--
CREATE TABLE IF NOT EXISTS `t_message_broadcast` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `content` varchar(1000) NOT NULL COMMENT '内容',
  `begindate` int(11) NOT NULL COMMENT '开始日期',
  `enddate` int(11) NOT NULL COMMENT '结束日期',
  `begintime` varchar(10) NOT NULL COMMENT '开始时间',
  `endtime` varchar(10) NOT NULL COMMENT '结束时间',
  `type` int(11) NOT NULL COMMENT '消息位置',
  `send_type` tinyint(2) NOT NULL COMMENT '广播类型',
  `interval` int(11) NOT NULL COMMENT '时间间隔',
  `admin_name` varchar(50) NOT NULL DEFAULT '' COMMENT '管理员帐号名',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='消息广播表';

-- --------------------------------------------------------

--
-- 表的结构 `c_role_label`
--

CREATE TABLE IF NOT EXISTS `c_role_label` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '更新时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间戳',
  `last_update_word` varchar(150) NOT NULL DEFAULT '0' COMMENT '最后更新字段',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `active` tinyint(2) DEFAULT '0' COMMENT '活跃标签',
  `online` tinyint(2) DEFAULT '0' COMMENT '在线时间标签',
  `level` tinyint(2) DEFAULT '0' COMMENT '等级标签',
  `vip` tinyint(2) DEFAULT '0' COMMENT 'VIP标签',
  `consume` tinyint(2) DEFAULT '0' COMMENT '消费标签',
  `interactive` tinyint(2) DEFAULT '0' COMMENT '注重社交',
  `deal` tinyint(2) DEFAULT '0' COMMENT '注重交易',
  `activity` tinyint(2) DEFAULT '0' COMMENT '喜好活动',
  `boss` tinyint(2) DEFAULT '0' COMMENT '喜好野外BOSS',
  `copy` tinyint(2) DEFAULT '0' COMMENT '喜好副本',
  `task` tinyint(2) DEFAULT '0' COMMENT '喜好日常任务',
  `home_manage` tinyint(2) DEFAULT '0' COMMENT '喜好家园管理',
  `plant` tinyint(2) DEFAULT '0' COMMENT '喜好种植',
  `pk` tinyint(2) DEFAULT '0' COMMENT '喜好PK',
  `sit` tinyint(2) DEFAULT '0' COMMENT '喜好打坐',
  `pet_mix` tinyint(2) DEFAULT '0' COMMENT '喜好宠物融合',
  PRIMARY KEY (`id`),
  UNIQUE KEY (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='角色数据标签';

-- --------------------------------------------------------

--
-- 表的结构 `t_ban_chat`
--

CREATE TABLE IF NOT EXISTS `t_ban_chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `ip` varchar(16) DEFAULT NULL COMMENT 'IP',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `ban_time` int(11) NOT NULL DEFAULT '0' COMMENT '禁言时间戳',
  `free_time` int(11) NOT NULL DEFAULT '0' COMMENT '解禁言时间戳',
  `ban_reason` varchar(128) NOT NULL DEFAULT '0' COMMENT '禁言原因',
  `op_user` varchar(30) NOT NULL DEFAULT '0' COMMENT '操作用户',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='设置玩家禁言';

-- --------------------------------------------------------

--
-- 表的结构 `t_ban_account`
--

CREATE TABLE IF NOT EXISTS `t_ban_account` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `ip` varchar(16) DEFAULT NULL COMMENT 'IP',
  `level` smallint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `ban_time` int(11) NOT NULL DEFAULT '0' COMMENT '禁止时间戳',
  `free_time` int(11) NOT NULL DEFAULT '0' COMMENT '解禁时间戳',
  `ban_reason` varchar(256) NOT NULL DEFAULT '0' COMMENT '禁止原因',
  `op_user` varchar(30) NOT NULL DEFAULT '0' COMMENT '操作用户',
  PRIMARY KEY (`id`),
  UNIQUE KEY (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8 COMMENT='禁封账号';

-- --------------------------------------------------------

--
-- 表的结构 `t_ban_ip`
--

CREATE TABLE IF NOT EXISTS `t_ban_ip` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(16) DEFAULT NULL COMMENT 'IP',
  `role_name_list` varchar(512) DEFAULT NULL COMMENT '角色列表',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态:0正常,1禁封,2手动解封',
  `ban_time` int(11) NOT NULL DEFAULT '0' COMMENT '禁止时间戳',
  `free_time` int(11) NOT NULL DEFAULT '0' COMMENT '解禁时间戳',
  `ban_reason` varchar(256) NOT NULL DEFAULT '0' COMMENT '禁止原因',
  `op_user` varchar(30) NOT NULL DEFAULT '0' COMMENT '操作用户',
  PRIMARY KEY (`id`),
  UNIQUE KEY (`ip`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8 COMMENT='禁封IP';

-- --------------------------------------------------------

--
-- 表的结构 `c_activity_join`
--

CREATE TABLE IF NOT EXISTS `c_activity_join` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` varchar(12) NOT NULL COMMENT '日期',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间戳',
  `activity` varchar(40) NOT NULL COMMENT '活动',
  `act_no` tinyint(2) NOT NULL DEFAULT '0' COMMENT '活动ID',
  `join_count` int(11) NOT NULL DEFAULT '0' COMMENT '参与人数',
  `act_count` int(4) NOT NULL DEFAULT '0' COMMENT '可参加人数',
  `room_count` tinyint(4) NOT NULL DEFAULT '0' COMMENT '开启房间数',
  `year` smallint(4) unsigned NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '日',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='活动参与数据';

-- --------------------------------------------------------

--
-- 表的结构 `t_regular_send_item`
--

CREATE TABLE IF NOT EXISTS `t_regular_send_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `add_person` varchar(50) NOT NULL COMMENT '操作人',
  `add_time` int(11) NOT NULL COMMENT '操作时间',
  `reason` varchar(255) DEFAULT NULL COMMENT '发放原因',
  `begin_time` int(11) NOT NULL COMMENT '开始时间',
  `end_time` int(11) NOT NULL COMMENT '结束时间',
  `send_time` int(11) NOT NULL COMMENT '发放时间',
  `mailTitle` varchar(64) DEFAULT NULL COMMENT '信件标题',
  `mailContent` text DEFAULT NULL COMMENT '信件内容',
  `roleNameList` varchar(4096) DEFAULT NULL COMMENT '玩家列表或者条件',
  `item` varchar(2048) DEFAULT NULL COMMENT '物品',
  `sendType` tinyint(1) DEFAULT NULL COMMENT '赠送类型,0按玩家名赠送,1按条件赠送',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态,0未启动,1正常,2结束,3手动停止',
  `last_send_time` int(11) NOT NULL COMMENT '最近发放时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='定时发送道具';

-- --------------------------------------------------------

--
-- 表的结构 `t_create_gm_role`
--

CREATE TABLE IF NOT EXISTS `t_create_gm_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mtime` int(11) NOT NULL COMMENT '创建时间',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `sex` tinyint(2) DEFAULT NULL COMMENT '性别',
  `job` tinyint(2) DEFAULT NULL COMMENT '职业',
  `ip` varchar(16) DEFAULT NULL COMMENT 'IP',
  `gm` tinyint(2) DEFAULT NULL COMMENT '权限',
  `add_person` varchar(50) NOT NULL COMMENT '操作人',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='创建GM角色日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_restore_player_data`
--

CREATE TABLE IF NOT EXISTS `t_restore_player_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mtime` int(11) NOT NULL COMMENT '时间',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `old_data` varchar(30720) DEFAULT NULL COMMENT '恢复前的数据',
  `new_data` varchar(30720) DEFAULT NULL COMMENT '恢复后的数据',
  `add_person` varchar(50) NOT NULL COMMENT '操作人',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='恢复玩家数据记录';

-- --------------------------------------------------------

--
-- 表的结构 `t_restore_family_data`
--

CREATE TABLE IF NOT EXISTS `t_restore_family_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mtime` int(11) NOT NULL COMMENT '时间',
  `family_name` varchar(40) NOT NULL COMMENT '恢复前家族名',
  `new_family_name` varchar(40) NOT NULL COMMENT '恢复后家族名',
  `account_name` varchar(40) NOT NULL COMMENT '族长账号',
  `old_data` varchar(4096) DEFAULT NULL COMMENT '恢复前的数据',
  `new_data` varchar(4096) DEFAULT NULL COMMENT '恢复后的数据',
  `add_person` varchar(50) NOT NULL COMMENT '操作人',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='恢复家族数据记录';


-- --------------------------------------------------------

--
-- 表的结构 `t_log_fsdg_contribute`
-- 

CREATE TABLE IF NOT EXISTS `t_log_fsdg_contribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `type` tinyint(2) NOT NULL COMMENT '捐献类型(1普通，2快速完成)',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='风蚀地宫捐献日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_merge_server_consume`
-- 

CREATE TABLE IF NOT EXISTS `t_log_merge_server_consume` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `cnt` int(11)  NOT NULL COMMENT '一次抽奖次数',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='合服活动消费日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_weiduan_tip_libao`
-- 

CREATE TABLE IF NOT EXISTS `t_log_weiduan_tip_libao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `pf` int(11)  NOT NULL COMMENT '平台',
  `type` int(11)  NOT NULL COMMENT '类型',
  `libaoID` int(11)  NOT NULL COMMENT '礼包ID',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='微端礼包日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_weiduan_down_libao`
-- 

CREATE TABLE IF NOT EXISTS `t_log_weiduan_down_libao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `pf` int(11)  NOT NULL COMMENT '平台',
  `libaoID` int(11)  NOT NULL COMMENT '礼包ID',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='微端下载日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_juhuasuan`
-- 

CREATE TABLE IF NOT EXISTS `t_log_juhuasuan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `type` int(11)  NOT NULL COMMENT '类型',
  `itemID` int(11)  NOT NULL COMMENT '礼包ID',
  `cnt` int(11)  NOT NULL COMMENT '领取的道具数量',
  `xianshi` int(11)  NOT NULL COMMENT '消耗仙石',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='聚划算礼包日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_question_survey`
-- 

CREATE TABLE IF NOT EXISTS `t_log_question_survey` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4)  NOT NULL COMMENT '等级',
  `question_id` int(11)  NOT NULL COMMENT '问题ID',
  `type` int(5)  NOT NULL COMMENT '问题类型',
  `answers` text  NOT NULL COMMENT '问题答案',
  `content` text NOT NULL  COMMENT '填空内容',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='问卷调查日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_open_vip2`
-- 

CREATE TABLE IF NOT EXISTS `t_log_open_vip2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `level` smallint(4)  DEFAULT '0' COMMENT '等级',
  `blue` tinyint(2) DEFAULT '0'   COMMENT '普通蓝钻',
  `blueLv` smallint(2) DEFAULT '0'   COMMENT '蓝钻等级',
  `blueYear`  tinyint(2) DEFAULT '0'   COMMENT '年费蓝钻',
  `isYear` smallint(2) DEFAULT '0' COMMENT '开通年费蓝钻',
  `highBlue` smallint(2) DEFAULT '0' COMMENT '是否豪华版蓝钻',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='蓝钻开通日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_player_return`
-- 

CREATE TABLE IF NOT EXISTS `t_log_player_return` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `platform`int(11)  NOT NULL COMMENT '平台',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='回流礼包日志';

-- --------------------------------------------------------

--
-- 表的结构 `t_log_paycost_tuhao`
-- 

CREATE TABLE IF NOT EXISTS `t_log_paycost_tuhao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `phase`int(11)  NOT NULL COMMENT '阶段',
  `pf` varchar(40) DEFAULT NULL COMMENT '平台',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='土豪赠礼日志';


-- --------------------------------------------------------

--
-- 表的结构 `t_log_paycost_lucky`
-- 
--
CREATE TABLE IF NOT EXISTS `t_log_paycost_lucky` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` datetime NOT NULL COMMENT '日期时间',
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uuid` varchar(40) NOT NULL COMMENT 'uuid',
  `account_name` varchar(40) NOT NULL COMMENT '账号名',
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `type`int(11)  NOT NULL COMMENT '类型',
  `pf` varchar(40) DEFAULT NULL COMMENT '平台',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '时',
  `min` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  KEY `account_name` (`account_name`),
  KEY `role_name` (`role_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='幸运转盘日志';