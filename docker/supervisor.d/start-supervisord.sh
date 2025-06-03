#!/bin/bash


#echo "Starting apache..."
apachectl -D FOREGROUND &
#sleep 2
echo "Starting crontab ..."
cron -f &

sleep 2
echo "Starting supervisord..."
/usr/bin/supervisord -c /etc/supervisor/supervisord.conf

exit 0