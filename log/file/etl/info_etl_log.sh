#!/bin/bash

###################################################
## 该脚本必须让每X分运行一次,分析游戏各种日志到数据库.
###################################################
export LANG="en_US.UTF-8"
INIT_DIR=`dirname $0`
cd ${INIT_DIR}/

if [ ! -z "$1" ];then
mdate=$1
else
mdate=""
fi

LOG_DIR=/data/logs/etl_crontab_load_data/
mkdir -p ${LOG_DIR}

strMonth=`date "+%Y%m%d"`
logFile=${LOG_DIR}etl_crontab_load_data_$strMonth.log
echo "======start【" `date "+%Y-%m-%d %H:%M:%S"` "】========" >> $logFile

name=(	[0]="t_log_item"	#道具获得使用日志
	)

num=${#name[@]}
for((i=0;i<num;i++)){

	PROC_CNT1=`ps aux | grep "log_load_infobright.php ${name[$i]}" | grep -v grep | wc -l`
	#echo ${PROC_CNT1}
	if [ "${PROC_CNT1}" -gt 0 ]
	then
		echo "[log_load_infobright.php ${name[$i]}] more than one process runing, exits."
	else
		echo =====================log_load_infobright.php ${name[$i]}==================
		STARTTIME=`date "+%s"`
		/usr/bin/php log_load_infobright.php ${name[$i]} >> $logFile &
		ENDTIME=`date "+%s"`
		echo ${name[$i]} "（ $[ $ENDTIME-$STARTTIME ] s）" >> $logFile
	fi
	
	PROC_CNT2=`ps aux | grep "load_log_from_csv_infobright.php ${name[$i]}" | grep -v grep | wc -l`
	#echo ${PROC_CNT2}
	if [ "${PROC_CNT2}" -gt 0 ]
	then
		echo "[load_log_from_csv.php ${name[$i]}] more than one process runing, exits."
	else
		echo =====================load_log_from_csv_infobright.php ${name[$i]}==================
		STARTTIME=`date "+%s"`
		/usr/bin/php load_log_from_csv_infobright.php ${name[$i]} >> $logFile &
		ENDTIME=`date "+%s"`
		echo ${name[$i]} "（ $[ $ENDTIME-$STARTTIME ] s）" >> $logFile
	fi

}

echo "==================end=======================" >> $logFile
