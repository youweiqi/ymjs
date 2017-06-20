#!/usr/bin/env bash
YII=$(pwd)  #创建Yii 变量  将他的目录保存到一个变量
PHP=/usr/local/bin/php  # php 可执行的路径 赋给了PHP
LOGDIR=$YII/log   #  报错的日志的目录
IFS=$'\n' #IFS 换行输出

start() {
for i in $(php yii | grep "export-task/" | awk '{print $0}' ); do
    task_name=$(echo $i | awk '{print $1}')
    task_type=$(echo $i | awk -F '|' '{print $2}')
    log_file=$LOGDIR/$task_type$(echo $task_name | awk -F '/' '{print $2}')".log"
    command="nohup $PHP $YII/yii $task_name >> $log_file 2>&1 &"
    eval   $command
    if [ $? -eq 0 ]
    then
        echo "$command succ"
    else
        echo "$command fail"
    fi
done
}

stop() {
echo $(ps aux | grep 'export-task' | grep -v grep | awk '{print $2}' ) | tr ' ' '\n' | xargs -I {} kill {}
}

case "$1" in
    start)
       start
       ;;
    stop)
       stop
       ;;
    restart)
       stop
       start
       ;;
    status)
       # code to check status of app comes here
       # example: status program_name
       ;;
    *)
       echo "Usage: $0 {start|stop|status|restart}"
esac

exit 0
