<?php
//=============设定游戏、代理和游戏服代号和名称=========//
define ( 'GAME_EN_NAME', 'gameName' );
define ( 'GAME_ZH_NAME', '游戏名' ); //管理后台菜单标题
define ( 'GAME_TICKET_SUBFIX', '793f6acbc08c2dceccebb2446e2e' ); //选服页跳转链接加密的KEY(从选服页或从管理后台直接登录玩家帐号时需要带上此key)
define ( 'ADMIN_GAME_AUTH_KEY', 'b97c4G9hXsQMvjd12aa135f7270e5c' ); //与前端游戏入口接口的加密KEY
//=============设定后台登录超级管理员的用户名密码=========//
define ( 'ROOT_USERNAME', 'root' ); //管理后台的ROOT用户名
define ( 'ROOT_PASSWORD', 'xFSJc9QRzCR' ); //管理后台的ROOT用户密码
define ( 'LOGIN_FROST_TIME', 30 ); //登录冻结时间，单位：天，超过这个时间没有登录的帐号将被冻结
//================================//
//==============常用菜单项数目设置==============//
define ( 'COMMON_MENU', 10 ); //一般来说常用菜单10项就够了，这个数字参考了神魔遮天的后台
//================================//
//=============定义各目录常量=========//
define ( 'SYSDIR_ADMIN', realpath ( dirname ( __FILE__ ) . '/../../' ) ); //根目录
define ( 'SYSDIR_ADMIN_PROTECTED', SYSDIR_ADMIN . '/protected' ); //受保护(拒绝WEB访问)目录
define ( 'SYSDIR_ADMIN_PUBLIC', SYSDIR_ADMIN . '/public' ); //公共(允许WEB访问)目录
define ( 'SYSDIR_ADMIN_LOG', SYSDIR_ADMIN . '/log' ); //日志转换目录
define ( 'SYSDIR_ADMIN_CONFIG', SYSDIR_ADMIN_PROTECTED . '/config' ); //类目录
define ( 'SYSDIR_ADMIN_CLASS', SYSDIR_ADMIN_PROTECTED . '/class' ); //类目录
define ( 'SYSDIR_ADMIN_LANG', SYSDIR_ADMIN_PROTECTED . '/lang' ); //语言包目录
define ( 'SYSDIR_ADMIN_API_CLASS', SYSDIR_ADMIN_CLASS . '/api' ); //api类目录
define ( 'SYSDIR_ADMIN_GAME_LOG_CLASS', SYSDIR_ADMIN_CLASS . '/game_log' ); //游戏相关日志类目录
define ( 'SYSDIR_ADMIN_INCLUDE', SYSDIR_ADMIN_PROTECTED . '/include' ); //引用
define ( 'SYSDIR_ADMIN_LIBRARY', SYSDIR_ADMIN_PROTECTED . '/library' ); //第三方库
define ( 'SYSDIR_ADMIN_DICT', SYSDIR_ADMIN_PROTECTED . '/dict' ); //数据字典
define ( 'SYSDIR_ADMIN_LOG_FILE', SYSDIR_ADMIN_LOG . '/file' ); //文件日志转换根目录
define ( 'FILE_ETL_CONFIG', SYSDIR_ADMIN_LOG_FILE . '/config' ); //文件日志转换配置目录
define ( 'FILE_ETL_INCLUDE', SYSDIR_ADMIN_LOG_FILE . '/include' ); //文件日志转换包含目录
define ( 'FILE_ETL_CLASS', SYSDIR_ADMIN_LOG_FILE . '/class' ); //文件日志转换包含目录
define ( 'SYSDIR_ADMIN_GAME_CONFIG', SYSDIR_ADMIN_PROTECTED . '/game_config' ); //游戏特殊配置目录
define ( 'FILE_CRONTAB_LOAD', SYSDIR_ADMIN_LOG_FILE . '/load' ); //文件日志转换包含目录

//==============验证码开关================//
define ( 'CHECK_CODE_SWITCH', false ); //true=开，false=关
//==========end 验证码开关================//

//=========smarty相关配置==============//
define ( 'SYSDIR_ADMIN_SMARTY_TEMPLATE', SYSDIR_ADMIN_PROTECTED . '/template' ); //smarty模版目录
define ( 'SYSDIR_ADMIN_SMARTY_TEMPLATE_C', SYSDIR_ADMIN_PROTECTED . '/template_c' ); //smarty编译目录
define ( 'SMARTY_COMPILE_CHECK', true );
define ( 'SMARTY_FORCE_COMPILE', true );
define ( 'SMARTY_LEFT_DELIMITER', '<{' );
define ( 'SMARTY_RIGHT_DELIMITER', '}>' );
//===================================//

//=========服务器运行常量配置============//
define ( 'SERVER_RUN_MODE', 2 );//运行模式 1=正常模式  2=开发模式,部署到外服必须用正常模式
define ( 'URL_SELF', $_SERVER['PHP_SELF'] );
define ( 'NOW_TIMESTAMP', time() );//当前时间戳

//==========页面显示的定义=========//
define ( 'LIST_PER_PAGE_RECORDS', 20 ); //Search page show ... records per page
define ( 'LIST_SHOW_PREV_NEXT_PAGES', 10 ); //First Prev 1 2 3 4 5 6 7 8 9 10... Next Last
define ( 'HIGHTLIGHT_PERCENTAGE', 0.8 ); //First Prev 1 2 3 4 5 6 7 8 9 10... Next Last
//===============================//
define ( 'CFG_POWERBY', 'ywkf@aaaa.com' );
//包含配置文件

//===============================//
define( 'IS_LUA', 1 );//当前游戏服务器端为LUA
//===============================//

//===============游戏基础数值配置===================//
define ( 'HOW_LONG_TIME_PER_POINT', 1 ); //在线图表多长时间一个点,单位:分钟
define ( 'GAME_MAXLEVEL', 120 ); //游戏最大等级
define ( 'MAP_LOSS_PIXELS', 50 );//地图流失率上设置地图格子像素大小

//================游戏日志相关配置=================//
define('PROXYID', 1);//代理ID
define('PROXY', 'my');//代理
define('SYSDIR_LOG','/data/logs/'.PROXY); //管理后台日志存放目录
define('SYSDIR_GAME_LOG',SYSDIR_LOG.'/logFile'); //原始日志文件
define('SYSDIR_GAME_LOG_OK',SYSDIR_LOG.'/game_log_ok'); //已经成功入库的日志文件存放目录
define('SYSDIR_GAME_LOG_ERROR',SYSDIR_LOG.'/game_log_error'); //入库失败的日志文件存放目录
define('SYSDIR_GAME_LOG_CHAT', SYSDIR_LOG.'/chat');//聊天日志文件目录
define('SYSDIR_GAME_ETL_CSV','/tmp/'.PROXY.'/etl_csv_file'); //从日志文件转换后的csv文件的存放目录