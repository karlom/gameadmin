-- 
-- 
-- 管理后台数据库建表语句
--
-- 
-- 建库语句如：
-- CREATE DATABASE IF NOT EXISTS game_admin DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
-- GRANT ALL ON game_admin.* TO game_admin@localhost identified by "game_admin";
-- 

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `game_admin`
--

-- --------------------------------------------------------

--
-- 表的结构 `t_admin_group`
--

CREATE TABLE IF NOT EXISTS `t_admin_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `rule` varchar(1024) NOT NULL,
  `comment` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;


-- --------------------------------------------------------

--
-- 表的结构 `t_admin_user`
--

CREATE TABLE IF NOT EXISTS `t_admin_user` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `passwd` varchar(50) NOT NULL,
  `user_power` text NOT NULL,
  `last_login_time` int(11) NOT NULL,
  `groupid` int(10) unsigned NOT NULL,
  `comment` varchar(100) NOT NULL,
  `last_change_passwd` int(11) NOT NULL,
  `user_status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;



-- --------------------------------------------------------

--
-- 表的结构 `t_ip_access`
--

CREATE TABLE IF NOT EXISTS `t_ip_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

--
-- 转存表中的数据 `t_ip_access`
--


-- --------------------------------------------------------

--
-- 表的结构 `t_log_admin`
--

CREATE TABLE IF NOT EXISTS `t_log_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL DEFAULT '0' COMMENT '管理员ID',
  `admin_name` varchar(50) NOT NULL DEFAULT '' COMMENT '管理员帐号名',
  `admin_ip` varchar(15) NOT NULL DEFAULT '',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '操作的角色ID',
  `user_name` varchar(50) NOT NULL DEFAULT '',
  `mtime` int(11) NOT NULL DEFAULT '0',
  `mtype` int(11) NOT NULL DEFAULT '0' COMMENT '操作类型',
  `mdetail` text NOT NULL COMMENT '操作内容',
  `number` int(11) NOT NULL DEFAULT '0' COMMENT '数量',
  `desc` varchar(5000) NOT NULL DEFAULT '' COMMENT '详细使用说明',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='管理后台的日志表' AUTO_INCREMENT=0 ;


--
-- 表的结构 `t_log_menu`
--

CREATE TABLE IF NOT EXISTS `t_log_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL COMMENT '管理员ID',
  `admin_name` varchar(20) NOT NULL COMMENT '管理员名字',
  `admin_ip` varchar(15) NOT NULL COMMENT '管理员登录的IP',
  `click_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '点击菜单的时间',
  `version` varchar(10) NOT NULL COMMENT '后台版本',
  `menu_id` int(3) NOT NULL,
  `menu_name` varchar(50) NOT NULL COMMENT '菜单名称',
  `menu_url` varchar(100) NOT NULL COMMENT '菜单RUL',
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='记录管理员对左边菜单的点击详细情况' AUTO_INCREMENT=0 ;



-- --------------------------------------------------------

--
-- 表的结构 `t_server_config`
--

CREATE TABLE IF NOT EXISTS `t_server_config` (
  `id` int(10) NOT NULL,
  `ver` varchar(50) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `port` int(11) NOT NULL DEFAULT '80',
  `dbuser` varchar(50) DEFAULT NULL,
  `dbpwd` varchar(100) DEFAULT NULL,
  `dbname` varchar(50) DEFAULT NULL,
  `md5` varchar(50) DEFAULT NULL,
  `onlinedate` date DEFAULT NULL,
  `available` tinyint(1) NOT NULL COMMENT '后台日志导入是否可用',
  `entranceUrl` varchar(200) DEFAULT NULL COMMENT '游戏入口URL',
  `name` varchar(20) DEFAULT NULL COMMENT '别名',
  `iscombine` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已经合服',
  `combinedate` date DEFAULT NULL  COMMENT '合服日期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;



-- --------------------------------------------------------

--
-- 表的结构 `t_game_entrance_config`
--

CREATE TABLE IF NOT EXISTS `t_game_entrance_config` (
  `server_id` mediumint(6) NOT NULL COMMENT '服务器ID',
  `entranceUrl` varchar(100) DEFAULT NULL COMMENT '戏游入口地址',
  `websiteTitle` varchar(50) DEFAULT '' COMMENT '标题',
  `officialWebsite` varchar(100) DEFAULT '' COMMENT '官网地址',
  `serviceHost` varchar(100) DEFAULT NULL COMMENT '服务器地址',
  `resourceHost` varchar(100) DEFAULT NULL COMMENT '静态资源地址',
  `ip` char(15) DEFAULT NULL COMMENT '游戏服务端所在机ip或域名',
  `port` int(11) DEFAULT '80' COMMENT '游戏服务端所在机连接端口',
  `version` varchar(50) DEFAULT NULL COMMENT '游戏版本号',
  UNIQUE KEY `server_id` (`server_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_menu_config`
--

CREATE TABLE IF NOT EXISTS `t_menu_config` (
  `id` smallint(4) NOT NULL COMMENT '菜单ID',
  `interface` enum('socket','http') DEFAULT NULL COMMENT '口接',
  `ver` varchar(15) DEFAULT NULL,
  `isshow` enum('0','1') DEFAULT '1' COMMENT '是否显示(0隐藏,1显示)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_admin_list`
--

CREATE TABLE IF NOT EXISTS `t_admin_list` (
  `id` smallint(4) NOT NULL AUTO_INCREMENT,
  `url` varchar(100) NOT NULL COMMENT '地址',
  `name` varchar(20) NOT NULL COMMENT '名称',
  `available` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否可用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='管理后台地址';

-- --------------------------------------------------------

--
-- 表的结构 `t_command_list`
--

CREATE TABLE IF NOT EXISTS `t_command_list` (
  `id` smallint(4) NOT NULL AUTO_INCREMENT,
  `mtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间',
  `cmd` varchar(128) NOT NULL COMMENT '命令',
  `executed` tinyint(1) NOT NULL COMMENT '是否已执行',
  `result` varchar(1024) NOT NULL COMMENT '执行结果',
  `admin_name` varchar(50) NOT NULL DEFAULT '' COMMENT '管理员帐号名',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='命令列表';