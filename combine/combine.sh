#!/bin/bash

if [ "$2" == "" ]
then
	echo "Use: sh $0 NewDB DB1 DB2 ..."
	exit 1
fi

DATE=`date +"%Y-%m-%d"`

DBS=$@
#echo $#
NEWDB=$1
echo "后台数据开始合并：${@}"

AGENT=`echo ${NEWDB} | awk -F\_ '{print $2}'`

/usr/bin/php combine.php ${@}

LOGDIR="/data/logs/${AGENT}/logFile"

cd ${LOGDIR}

NEWDB_SID=`echo ${NEWDB} |awk -FS '{print $2}'`
if [ -L ${NEWDB_SID} ] ; then
	rm -f ${NEWDB_SID}
	mkdir -p ${NEWDB_SID}
fi

DBUSER='root'
DBPWD=`cat /data/save/mysql_root`
if [[ ${NEWDB_SID} -ge 60001  ]] && [[ ${NEWDB_SID} -lt 70000 ]] ; then
	DBNAME="union_game_admin"
elif [[ ${NEWDB_SID} -ge 20001  ]] && [[ ${NEWDB_SID} -lt 30000 ]] ; then
	DBNAME="union_game_admin"
elif [[ ${NEWDB_SID} -ge 70001  ]] && [[ ${NEWDB_SID} -lt 80000 ]] ; then
	DBNAME="tt_game_admin"
else 
	DBNAME="qq_game_admin"
fi

shift

for i in $@
do
	SID=`echo $i | awk -FS '{print $2}' | sed 's/_old//'`
	if [ "${SID}" == "${NEWDB_SID}" ]; then
		continue
	fi
	SQL="update ${DBNAME}.t_server_config set available=0,iscombine=1,combinedate='${DATE}' where id=${SID};"
	#echo ${SQL}
	mysql -u${DBUSER} -p${DBPWD} ${DBNAME} -e "${SQL}"
	if [ -d "${SID}_old" ]; then
		mv ${SID}_old ${SID}_old_old
	fi
	mv ${SID} ${SID}_old && ln -s ${NEWDB_SID} ${SID}
done
