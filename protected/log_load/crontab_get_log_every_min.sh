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

name3=([0]="get_online_data.php"	#获取在线数据脚本
	    [1]="activity_statistics.php"	#活动数据统计
	    [2]="send_items.php"	#定时发送道具
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
