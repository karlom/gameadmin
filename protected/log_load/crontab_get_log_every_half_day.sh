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

strMonth=`date "+%Y%m%d"`
logFile=${LOG_DIR}d3_crontab_load_data_$strMonth.log
echo "======start【" `date "+%Y-%m-%d %H:%M:%S"` "】========" >> $logFile

name3=([0]="wealth_statistics.php --action=import"	#财富统计
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
