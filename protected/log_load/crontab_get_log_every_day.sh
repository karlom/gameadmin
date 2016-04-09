#!/bin/bash

#############################################
## 该脚本必须让crontab每分运行一次.
#############################################
export LANG="en_US.UTF-8"
INIT_DIR=`dirname $0`
cd ${INIT_DIR}/

if [ ! -z "$1" ];then
mdate=$1
else
mdate=""
fi

LOG_DIR=/data/logs/d3_crontab_load_data/
mkdir -p ${LOG_DIR}

strMonth=`date "+%Y%m%d"`
logFile=${LOG_DIR}d3_crontab_load_data_$strMonth.log
echo "======start【" `date "+%Y-%m-%d %H:%M:%S"` "】========" >> $logFile

name3=([0]="active_loyalty_user.php"	#活跃忠诚用户
	[1]="gold_money_warning.php"	#元宝铜币异常统计表
	[2]="gold_consume_and_save_statistics.php"	#元宝消耗与存量统计表
    [3]="count_player_track.php"    #开服数据统计表
	)
num=${#name3[@]}
for((i=0;i<num;i++)){
echo =====================${name3[$i]}==================
STARTTIME=`date "+%s"`
/usr/bin/php ${name3[$i]} $mdate >> $logFile
ENDTIME=`date "+%s"`
echo ${name3[$i]} "（ $[ $ENDTIME-$STARTTIME ] s）" >> $logFile
}

echo "==================end=======================" >> $logFile
