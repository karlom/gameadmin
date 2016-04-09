#!/bin/bash
#############################################
## 该脚本必须让crontab每分钟运行一次.
#############################################
export LANG="en_US.UTF-8"
INIT_DIR=`dirname $0`
cd ${INIT_DIR}/

usage () {
cat <<EOF
    Usage: $0 [OPTIONS]
    --logdir=PATH           Crontab run result log save path
    --help                     Print this message
EOF
    exit 1
}

parse_arguments() {
    for arg do
        case "$arg" in
            --logdir=*) logdir=`echo "$arg" | sed -e "s;--logdir=;;"` ;;
            --help) usage ;;
            *) echo "Invalid argument $arg" ;;
        esac
    done
}

parse_arguments "$@"

if [ -z $logdir ] ; then
    echo "logdir required "
    exit 1
fi

strMonth=`date "+%Y%m"`
logFile="${logdir}/crontab_load_data_${strMonth}.log"


name=([0]="log_mission_load.php"
      [1]="log_register_load.php"
      )

for i in ${name[*]}
do
/usr/bin/php $i >> ${logFile}
done
