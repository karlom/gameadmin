#!/bin/bash

export LANG="en_US.UTF-8"
INIT_DIR=`dirname $0`
cd ${INIT_DIR}/

G_AGENT=`grep "'PROXY'" ../config/config.php | awk -F\' '{print $4}'`

if [ "${G_AGENT}" == "tt" ]
then

name=(	
	[1]="upload_register.php"	#新增角色日志 log_character
	[2]="upload_shop_consume.php"	#商城消费分析日志 log_consumption	仙石
	[3]="upload_shop_consume_bind.php"	#商城消费分析日志 log_consumption	绑定仙石
	[4]="upload_login.php"	#玩家登陆日志 log_login
	[5]="upload_logout.php"	#玩家登出日志 log_logout
	[6]="upload_level_up.php"	#角色升级日志 log_uplevel
	[7]="upload_pay_tt.php"	#充值日志 log_recharge
	[8]="upload_online.php"	#玩家在线日志（10分钟输出一次）log_online
)

else 
name=(	
	[1]="upload_register.php"	#新增角色日志 log_character
	[2]="upload_shop_consume.php"	#商城消费分析日志 log_consumption	仙石
	[3]="upload_shop_consume_bind.php"	#商城消费分析日志 log_consumption	绑定仙石
	[4]="upload_login.php"	#玩家登陆日志 log_login
	[5]="upload_logout.php"	#玩家登出日志 log_logout
	[6]="upload_level_up.php"	#角色升级日志 log_uplevel
	[7]="upload_pay.php"	#充值日志 log_recharge
	[8]="upload_online.php"	#玩家在线日志（10分钟输出一次）log_online
)
fi

num=${#name[@]}
for((i=1;i<=num;i++)){

	PROC_CNT1=`ps aux | grep "php ${name[$i]}" | grep -v grep | wc -l`
	#echo ${PROC_CNT1}
	if [ "${PROC_CNT1}" -gt 0 ]
	then
		echo "[ php ${name[$i]} ] more than one process runing, exits."
	else
		echo =============== php ${name[$i]} ==================
		#STARTTIME=`date "+%s"`
		/usr/bin/php  ${name[$i]}  &
		#ENDTIME=`date "+%s"`
	fi
	
}
