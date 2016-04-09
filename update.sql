SET NAMES 'utf8';

--  2015-02-09

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

