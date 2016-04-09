<?php
/**
 * $arrLogTplConf 游戏服务端 发来的日志 scp方式
 * 
 * 说明:如果要用到exFields设置的字段,则fields里面一定要有mtime这个字段,否则exFields设置的字段将不起作用
 * exFields设置的字段,只限于时间戳可以转换得到的,如年月日时分秒周等等
 */
$allLogSwitch = "on";//总日志开关
$arrLogTplConf = array(
		//玩家升级日志
        "t_log_level_up" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_level_up_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','ip','prev_level','level',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "玩家升级日志",
        ),
        //玩家注册日志
        "t_log_register" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_register_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文log(.[0-9]{5}){0,1}用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','ip','job','sex','level','pf','app_custom','is_miniclient',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "玩家注册日志",
        ),
        //玩家登录日志
        "t_log_login" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_login_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','level','ip','contract_id','pf','xianzun','zhandouli','app_custom','is_miniclient',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "玩家登录日志",
        ),
        //玩家登出日志
        "t_log_logout" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_logout_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','level','ip','reason','map_id','x','y','online_time','pf','is_miniclient',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "玩家登出日志",
        ),
        //玩家死亡日志
        "t_log_die" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_die_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','level','killer_type','killer_name','killer_uuid','map_id',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "玩家死亡日志",
        ),
	    //任务日志
        t_log_task => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_task_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','level','task_id','task_action',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
	        ),
        	"log_type" => "common", //日志分类
	        "desc" => "任务日志",
        ),
        // 道具流通日志
        t_log_item => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_item_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','level','type','item_id','item_num','is_bind','detail',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "道具流通日志",
        ),
        // 仓库储存日志
        t_log_store => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_store_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','type','item_id','item_count',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "仓库储存日志",
        ),
        //职业日志
        t_log_career => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_career_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','career',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "职业日志",
        ),
        //创建流失日志
        t_log_create_loss => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_create_loss_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','account_name','role_name','step','ip',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "创建流失日志",
        ),
        //仙石获得与使用日志
        t_log_gold => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_gold_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','level','gold','type','item_id','num','remain_gold','pf',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "currency", //日志分类
	        "desc" => "仙石获得与使用日志",
        ),
        //绑定仙石获得与使用日志
        t_log_liquan => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_liquan_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','level','liquan','type','item_id','num','remain_liquan','pf',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "currency", //日志分类
	        "desc" => "绑定仙石获得与使用日志",
        ),
        //银两获得与使用日志
        t_log_money => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_money_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','level','money','type','item_id','num','remain_money',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "currency", //日志分类
	        "desc" => "银两获得与使用日志",
        ),
        //灵气获得与使用日志
        t_log_lingqi => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_lingqi_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','level','lingqi','type','item_id','num','remain_lingqi',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "currency", //日志分类
	        "desc" => "灵气获得与使用日志",
        ),
        //天城令获得与使用日志
        t_log_tiancheng => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_tiancheng_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','level','tiancheng','type','remain_tiancheng',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "currency", //日志分类
	        "desc" => "天城令获得与使用日志",
        ),
        //家族贡献日志
        t_log_family_contribute => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_family_contribute_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','level','gold','money','donate','all_donate','family_id','family_name','family_lv',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "家族贡献日志",
        ),
        // 市场寄售日志
        t_log_market_sell => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_market_sell_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','market_id','sell_time','rmb','money','item_id','item_num','is_bind','detail','sell_rmb','sell_money','bill_type',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "市场寄售日志",
        ),
        // 市场取消寄售日志
        t_log_market_cancel_sell => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_market_cancel_sell_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','market_id', 'bill_type',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "市场取消寄售日志",
        ),
        // 市场购买日志
        t_log_market_buy => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_market_buy_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','market_id','use_rmb','use_money', 'bill_type',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "市场购买日志",
        ),

		// 境界提升日志
        t_log_jingjie => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_jingjie_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','jingjieID','jingjielv','lingqi','itemNum','success',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "境界提升日志",
        ),
		// 境界技能提升日志
        t_log_jingjie_skill => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_jingjie_skill_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','skillID','skillName','skillLevel','item_id','item_num',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "境界技能提升日志",
        ),
		// 玩家进退家族日志
        t_log_family_enter_and_exit => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_family_enter_and_exit_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','level','family_id','family_name','family_lv','type',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "玩家进退家族日志",
        ),
		// 家族贡献获得与使用日志
        t_log_family_contribution_get_and_use => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_family_contribution_get_and_use_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','level','family_id','family_name','family_lv','value','itemID','type',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "家族贡献获得与使用日志",
        ),
		// 玩家组队日志
        t_log_team => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_team_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','level','name1','name2','name3','name4','name5','type',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "玩家组队日志",
        ),
		// 好友申请日志
        t_log_friend => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_friend_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','level','targetName','type',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "好友申请日志",
        ),
		// 好友聊天日志
        t_log_friend_chat => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_friend_chat_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','level','targetName','content',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		
        	),
        	"log_type" => "chat", //日志分类
	        "desc" => "好友聊天日志",
        ),
		// 家族聊天日志
        t_log_family_chat => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_family_chat_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','level','familyName','content',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		
        	),
        	"log_type" => "chat", //日志分类
	        "desc" => "家族聊天日志",
        ),
		// 交易日志
        t_log_deal => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_deal_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','level','target_account','target_name','item_get','item_lose','yinliang_get','yinliang_lose',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "交易日志",
        ),
		// 技能升级日志
        t_log_skill_upgrade => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_skill_upgrade_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','level','skillID','skillLevel',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
	        "desc" => "技能升级日志",
        ),
		// 宠物升级日志
        t_log_pet_up => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_pet_up_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','pet_uuid','owner_uuid','config_id','lv',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "pet", //日志分类
	        "desc" => "宠物升级日志",
        ),
		// 宠物获取日志
        t_log_pet_create => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_pet_create_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','pet_uuid','owner_uuid','config_id','sum_zizhi',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "pet", //日志分类
	        "desc" => "宠物获取日志",
        ),
		// 宠物放生日志
        t_log_pet_del => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_pet_del_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','pet_uuid','owner_uuid','config_id','sum_zizhi',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "pet", //日志分类
	        "desc" => "宠物放生日志",
        ),
		// 宠物融合日志
        t_log_pet_ronghe => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_pet_ronghe_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','pet_uuid','owner_uuid','config_id','sum_zizhi','add_zizhi','pet_uuid_ass','config_id_ass',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "pet", //日志分类
	        "desc" => "宠物融合日志",
        ),
		// 宠物喂食日志
        t_log_pet_feed => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_pet_feed_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','pet_uuid','owner_uuid','config_id','food_item_id',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "pet", //日志分类
	        "desc" => "宠物喂食日志",
        ),
		// 宠物境界提升日志
        t_log_pet_jingjie_up => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_pet_jingjie_up_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','pet_uuid','owner_uuid','config_id','jingjie_id_old','jingjie_cnt_old','jingjie_id_new','jingjie_cnt_new',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "pet", //日志分类
	        "desc" => "宠物境界提升日志",
        ),
		// 宠物技能提升日志
        t_log_pet_skill_up => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_pet_skill_up_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','owner_uuid','skill_id','is_fail','skill_lv',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "pet", //日志分类
	        "desc" => "宠物技能提升日志",
        ),
		// 宠物技能遗忘日志
        t_log_pet_skill_forget => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_pet_skill_forget_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','pet_uuid','owner_uuid','config_id','skill_id',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "pet", //日志分类
	        "desc" => "宠物技能遗忘日志",
        ),
		// 宠物化形日志
        t_log_pet_huaxing => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_pet_huaxing_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','pet_uuid','owner_uuid','config_id','step',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "pet", //日志分类
	        "desc" => "宠物化形日志",
        ),
		// 神炉强化日志
        t_log_refine_strengthen => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_refine_strengthen_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','equip_id','is_up','strengthen_lv','use_money','use_item_id','use_item_cnt','use_rmb',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "shenlu", //日志分类
	        "desc" => "神炉强化日志",
        ),
		// 神炉精炼日志
        t_log_refine_purify => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_refine_purify_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','equip_id','purify_cnt','use_money','use_item_id','use_item_cnt','use_rmb',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "shenlu", //日志分类
	        "desc" => "神炉精炼日志",
        ),
		// 神炉精炼重置日志
        t_log_refine_purify_reset => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_refine_purify_reset_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','equip_id',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "shenlu", //日志分类
	        "desc" => "神炉精炼重置日志",
        ),
		// 宝石镶嵌日志
        t_log_refine_inlay => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_refine_inlay_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','is_inlay','equip_id','gem_id','use_money','use_item_id','use_item_cnt','use_rmb',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "shenlu", //日志分类
	        "desc" => "宝石镶嵌日志",
        ),
		// 装备继承日志
        t_log_refine_extend => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_refine_extend_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','equip1_id','equip1_cnt','equip1_bind','equip1_detail',
				'equip2_id','equip2_cnt','equip2_bind','equip2_detail','equip_new_id','equip_new_cnt','equip_new_bind','equip_new_detail',
				'use_money','use_item_id','use_item_cnt','use_rmb',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "shenlu", //日志分类
	        "desc" => "装备继承日志",
        ),
		// 副本日志
        t_log_copy => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_copy_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','copy_id','enter_times','action','status','percent',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "副本日志",
        ),
		// 客户端系统信息日志
        t_log_client_info => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_client_info_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','cpuArchitecture','isDebugger','language','os','playerType',
				'screenDPI','screenResolutionX','screenResolutionY','touchscreenType','version','font',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "client", //日志分类
	        "desc" => "客户端系统信息日志",
        ),
		// 客户端加载和解码报错日志
        "t_log_client_err_load" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_client_err_load_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','is_decode','url',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "client", //日志分类
	        "desc" => "客户端加载和解码报错日志",
        ),
		// 客户端地图加载是内存问题日志
        "t_log_client_err_mem_map" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_client_err_mem_map_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','map_id','privateMemory','totalMemory','freeMemory',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "client", //日志分类
	        "desc" => "客户端地图加载是内存问题日志",
        ),
		// 家园操作日志
        t_log_home_op => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_home_op_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','level','action','o_uuid',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "home", //日志分类
	        "desc" => "家园操作日志",
        ),
		// 家园塔防操作日志
        t_log_home_fang => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_home_fang_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','level','action','exp','satisfy','status',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "home", //日志分类
	        "desc" => "家园塔防操作日志",
        ),
		// 道具赠送记录
        t_log_admin => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_admin_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','applyID','items',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "道具赠送记录",
        ),
		// GM指令操作日志
        t_log_gm_code => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_gm_code_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','cmd','arg',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "GM指令操作日志",
        ),
		// 聊天日志
        t_log_chat => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_chat_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','ip','channel','content',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        	),
        	"log_type" => "chat", //日志分类
	        "desc" => "聊天日志",
        ),
		// 掉落非法ID日志
        t_log_drop_item => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_drop_item_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','role_scene_id','obj_id','obj_type',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "掉落非法ID日志",
        ),
		// 打坐挂机日志
        "t_log_hang" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_hang_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','type','time',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "打坐挂机日志",
        ),
		// 技能快捷栏日志
        "t_log_skill_main_menu" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_skill_main_menu_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','level','job','skills',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "技能快捷栏日志",
        ),
		// 采集复活日志
        "t_log_collect_revive" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_collect_revive_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','help_uuid','help_name','map_id',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
	        	'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "采集复活日志",
        ),
		// 晶幻洞天通关日志
        "t_log_jhdt_info" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_jhdt_info_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','result','copy_time','name1','name2','name3','name4','name5',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
	        	'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "activity", //日志分类
	        "desc" => "晶幻洞天通关日志",
        ),
		// 仙邪问鼎采集日志
        "t_log_xxwd_collect" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_xxwd_collect_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','room_id','type','time',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
	        	'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "activity", //日志分类
	        "desc" => "仙邪问鼎采集日志",
        ),
		// 仙邪问鼎比分日志
        "t_log_xxwd_score" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_xxwd_score_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','room_id','score1','score2',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
	        	'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "activity", //日志分类
	        "desc" => "仙邪问鼎比分日志",
        ),
		// 仙邪问鼎排行榜
        "t_log_xxwd_board" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_xxwd_board_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','room_id','rank','uuid','name','job','kill_cnt','help_cnt','die_cnt','score','camp',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
	        	'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "activity", //日志分类
	        "desc" => "仙邪问鼎排行榜",
        ),
		// 遗迹寻宝技能使用日志
        "t_log_yjxb_skill" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_yjxb_skill_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','scene_id','skill_id',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
	        	'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "activity", //日志分类
	        "desc" => "遗迹寻宝技能使用日志",
        ),
		// 遗迹寻宝宝箱采集日志
        "t_log_yjxb_collect" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_yjxb_collect_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','scene_id','collect_id',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
	        	'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "activity", //日志分类
	        "desc" => "遗迹寻宝宝箱采集日志",
        ),
		// 遗迹寻宝金币拾取掉落日志
        "t_log_yjxb_jb" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_yjxb_jb_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','scene_id','jb','is_from_human',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
	        	'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "activity", //日志分类
	        "desc" => "遗迹寻宝金币拾取掉落日志",
        ),
		// 不灭试炼存活玩家/排行榜
        "t_log_bmsl_live" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_bmsl_live_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','job','scene_id','room_monster_strength','score_all','save_cnt','live_sec','rank',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
	        	'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "activity", //日志分类
	        "desc" => "不灭试炼存活玩家/排行榜",
        ),
		// 不灭试炼记忆之石日志
        "t_log_bmsl_jyzs" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_bmsl_jyzs_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','level','jyzs','type','remain_jyzs',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
	        	'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "activity", //日志分类
	        "desc" => "不灭试炼记忆之石日志",
        ),
		// 魔物暴动活动参加日志
        "t_log_mwbd_join_info" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_mwbd_join_info_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','level',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
	        	'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "activity", //日志分类
	        "desc" => "魔物暴动活动参加日志",
        ),
		// 魔物暴动地图人数日志
        "t_log_mwbd_role_cnt" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_mwbd_role_cnt_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','mapID','cnt',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
	        	'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "activity", //日志分类
	        "desc" => "魔物暴动地图人数日志",
        ),
		// 魔物暴动怪物死亡日志
        "t_log_mwbd_monster_die" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_mwbd_monster_die_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','monsterID','type','mapID','atkUuid','atkName',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
	        	'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "activity", //日志分类
	        "desc" => "魔物暴动怪物死亡日志",
        ),
		// 魔物暴动怪物家族排名
        "t_log_mwbd_family_rank" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_mwbd_family_rank_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','rank','score','familyUuid','familyName',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
	        	'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "activity", //日志分类
	        "desc" => "魔物暴动怪物家族排名",
        ),
		// 玩家提BUG或建议
        "t_log_bug" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_bug_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','level','content',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
	        	'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "玩家提BUG或建议",
        ),
		// 通缉令挑战日志
        "t_log_wanted" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_wanted_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','level','leftCnt','costCnt','monsterID','monsterName','hot','type','op',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
	        	'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "通缉令挑战日志",
        ),
		// 玩家活跃日志
        "t_log_huoyue" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_huoyue_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','level','act_id','leftCnt','huoyuedu',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
	        	'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "玩家活跃日志",
        ),
		// 黄钻开通日志
        "t_log_open_vip" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_open_vip_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','level','yellowDiamond','yellowDiamondYear','yellowDiamondLv','isYear',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
	        	'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "黄钻开通日志",
        ),
		// Q点购买道具日志
        "t_log_buy_goods" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_buy_goods_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','level','item_id','item_cnt','price','total_cost','ts','billno','pubacct','amt','pf',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
	        	'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "Q点购买道具日志",
        ),
		// 神秘商店日志
        "t_log_shop_rand" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_shop_rand_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','yinliang','yuanbao','is_vip','npc_id','item_id','item_sum','price','grid_num','money_type','is_buy',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
	        	'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "神秘商店日志",
        ),
		// 法宝进阶日志
        "t_log_talisman_upgrade" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_talisman_upgrade_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','level','talisman_name','item_id','item_cnt','result',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
	        	'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "法宝进阶日志",
        ),
		// 法宝激活幻化日志
        "t_log_talisman_illusion" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_talisman_illusion_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','level','talisman_name','get_way',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
	        	'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "法宝激活幻化日志",
        ),
		// 战力排行榜
        "t_log_billboard_role_atk" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_billboard_role_atk_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','level','atk','rank',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
	        	'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "战力排行榜",
        ),
		// npc商店购买日志
        "t_log_npc_shop_buy" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_npc_shop_buy_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','shop_npc_id','item_id','item_cnt','money_type','price',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
	        	'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "npc商店购买日志",
        ),
		// 删号日志
        "t_log_delete" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_delete_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','ip','job','sex','level',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
	        	'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "删号日志",
        ),
		// 任务集市日志
        "t_log_task_market" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_task_market_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','contract_id','status',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
	        	'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "任务集市日志",
        ),
		// 跨服切换日志
        "t_log_middle" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_middle_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','status',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
	        	'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "跨服切换日志",
        ),
		// 蓝钻icon日志
        "t_log_blue_icon" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_blue_icon_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
	        	'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "蓝钻icon日志",
        ),
		// 蓝钻礼包日志
        "t_log_blue_libao" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_blue_libao_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
				'mdate','mtime','uuid','account_name','role_name','type','lv',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
	        	'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "蓝钻礼包日志",
        ),
		//绑定银两获得与使用日志
        "t_log_bind_money" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_bind_money_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','level','money','type','item_id','num','remain_money',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "currency", //日志分类
	        "desc" => "绑定银两获得与使用日志",
        ),
		//神炉拆解日志
        "t_log_refine_resolve" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_refine_resolve_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','item_id',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "shenlu", //日志分类
	        "desc" => "神炉拆解日志",
        ),
		//累计充值日志
        "t_log_yuanbao_sum" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_yuanbao_sum_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','yuanbaosum','yuanbao',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "currency", //日志分类
	        "desc" => "累计充值日志",
        ),
		//龙脉升级日志
        "t_log_vein_lv" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_vein_lv_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','veinLv',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "龙脉升级日志",
        ),
		//求婚日志
        "t_log_marry_ask" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_marry_ask_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','targetUuid','target_account_name','target_role_name',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "marry", //日志分类
	        "desc" => "求婚日志",
        ),
		//求婚结果日志
        "t_log_marry_ask_result" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_marry_ask_result_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','targetUuid','target_account_name','target_role_name','result',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "marry", //日志分类
	        "desc" => "求婚结果日志",
        ),
		//婚宴预约日志
        "t_log_marry_book" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_marry_book_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid1','role_name1','uuid2','role_name2','price','book_time',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "marry", //日志分类
	        "desc" => "婚宴预约日志",
        ),
		//仙羽排行榜
        "t_log_billboard_wing" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_billboard_wing_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','level','zhandouli','wingname','rank',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "仙羽排行榜",
        ),
		//离婚日志
        "t_log_marry_divorce" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_marry_divorce_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','level','divorceType','moneyType','money','operator',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "离婚日志",
        ),
		//仙缘值日志
        "t_log_marry_xianyuanzhi" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_marry_xianyuanzhi_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','level','xianyuanzhi','type','remain_xianyuanzhi',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "仙缘值日志",
        ),
		//跨服BOSS活动结果
        "t_log_middle_boss_result" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_middle_boss_result_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','result','succeed','fail','lv','kill_uuid',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "activity", //日志分类
	        "desc" => "跨服BOSS活动结果",
        ),
		//跨服BOSS伤害排行
        "t_log_middle_boss_board" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_middle_boss_board_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','role_name','hurt','job','zhandouli','rank',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "activity", //日志分类
	        "desc" => "跨服BOSS伤害排行",
        ),
		//坐骑排行榜
        "t_log_billboard_horse" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_billboard_horse_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','level','zhandouli','rank','horse_lv',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "坐骑排行榜",
        ),
		//宠物战力排行榜
        "t_log_billboard_pet_zhandouli" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_billboard_pet_zhandouli_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','role_name','petLv','zhandouli','rank',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "宠物战力排行榜",
        ),
		//宠物境界排行榜
        "t_log_billboard_pet_jingjie" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_billboard_pet_jingjie_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','role_name','petLv','name1','name2','rank',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "宠物境界排行榜",
        ),
		//宠物资质排行榜
        "t_log_billboard_pet_zizhi" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_billboard_pet_zizhi_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','role_name','petLv','zizhi','rank',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "宠物资质排行榜",
        ),
		//圣纹镶嵌日志
        "t_log_refine_inlay_gem2" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_refine_inlay_gem2_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','is_inlay','equip_id','gem_id','use_money',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "圣纹镶嵌日志",
        ),
		//等级限购礼包领取日志
        "t_log_shop_djxg_get" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_shop_djxg_get_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','level','get_which_level','mul',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "等级限购礼包领取日志",
        ),
		//等级限购商品购买日志
        "t_log_shop_djxg_buy" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_shop_djxg_buy_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','level','get_which_level','item_id','item_cnt',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "等级限购商品购买日志",
        ),
		//坐骑升级日志
        "t_log_talisman_uplevel" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_talisman_uplevel_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','level','new_level','new_exp','old_level','old_exp',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "坐骑升级日志",
        ),
		//翅膀升级日志
        "t_log_wing_uplevel" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_wing_uplevel_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','level','new_level','new_exp','old_level','old_exp',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "翅膀升级日志",
        ),
		//开通蓝钻日志
        "t_log_open_vip_blue" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_open_vip_blue_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','openid','discountid',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "开通蓝钻日志",
        ),
		//开通黄钻日志
        "t_log_open_vip_yellow" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_open_vip_yellow_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','openid','discountid',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "开通黄钻日志",
        ),
		//神武擂台排行榜
        "t_log_billboard_jingji" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_billboard_jingji_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','role_name','job','score','rank',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "神武擂台排行榜",
        ),
		//鲜花排行榜
        "t_log_billboard_flower_sum" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_billboard_flower_sum_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','role_name','job','cnt','rank',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "鲜花排行榜",
        ),
	 //风蚀地宫捐献日志
        "t_log_fsdg_contribute" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_fsdg_contribute_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','type',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "风蚀地宫捐献日志",
        ),
		//合服活动消费日志
        "t_log_merge_server_consume" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_merge_server_consume_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','cnt',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "合服活动消费日志",
        ),
		//联运充值日志
        "t_log_pay" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_pay_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','level','ts','billno','amt','xianshiCnt','online',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "联运充值日志",
        ),
		//微端礼包日志
        "t_log_weiduan_tip_libao" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_weiduan_tip_libao_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','pf','type','libaoID',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "微端礼包日志",
        ),
         //微端下载日志
        "t_log_weiduan_down_libao" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_weiduan_down_libao_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','pf','libaoID',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "微端下载日志",
        ),
		//聚划算礼包日志
        "t_log_juhuasuan" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_juhuasuan_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','type','itemID','cnt','xianshi',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
        	),
        	"log_type" => "common", //日志分类
	        "desc" => "聚划算礼包日志",
        ),
		//问卷调查日志
        "t_log_question_survey" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_question_survey_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','level','question_id','answers','content',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
           	),
        	"log_type" => "common", //日志分类
	        "desc" => "问卷调查日志",
        ),
		//蓝钻开通日志
        "t_log_open_vip2" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_open_vip2_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','level','blue','blueLv','blueYear','isYear','highBlue',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
           	),
        	"log_type" => "common", //日志分类
	        "desc" => "蓝钻开通日志",
        ),
         //回流礼包日志
        "t_log_player_return" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_player_return_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','platform',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
           	),
        	"log_type" => "common", //日志分类
	        "desc" => "回流礼包日志",
        ),
	    //土豪赠礼日志
        "t_log_paycost_tuhao" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_paycost_tuhao_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','phase','pf',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
           	),
        	"log_type" => "common", //日志分类
	        "desc" => "土豪赠礼日志",
        ),
	    //幸运转盘日志
        "t_log_paycost_lucky" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_paycost_lucky_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','type','pf',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
           	),
        	"log_type" => "common", //日志分类
	        "desc" => "幸运转盘日志",
        ),
	    //加速检测日志
        "t_log_check_frame" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_check_frame_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','speed','serverX','serverY','clientX','clientY',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
           	),
        	"log_type" => "common", //日志分类
	        "desc" => "加速检测日志",
        ),
	    //天元宝库兑换日志
        "t_log_tybk" => array(
			'switch' => 'on', //日志开关 on 或 off
			'logFilePreg' =>'oss_tybk_[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}.log(.[0-9]{5}){0,1}', //日志文件名(可用正则)
			'fields'=>array(//共有的字段列表
                'mdate','mtime','uuid','account_name','role_name','buy_item_id','buy_item_cnt','cost_item_id','cost_item_cnt',
	        ),
	        'exFields' => array(//扩展字段,适用于将时间戳mtime转化为year,month,day,week,hour,min等保存到数据库,其它的字段将不适合转换
        		'year' => 'Y','month' => 'm','day' => 'd','hour' => 'H','min' => 'i',
           	),
        	"log_type" => "common", //日志分类
	        "desc" => "天元宝库兑换日志",
        ),
);
