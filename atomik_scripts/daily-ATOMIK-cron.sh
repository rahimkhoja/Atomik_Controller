#!/bin/bash

# Atomik Controller Script - Daily Cleanup Cron
# Bash
# By Rahim Khoja

# Requires Root Crontab

# Delete Received Commands Older Than 1 Day
TIMEZONE="$(cat /etc/timezone | awk '{print $1}')"
mysql -D atomik_controller -u root -praspberry -e "DELETE FROM atomik_commands_received WHERE command_received_date <= CONVERT_TZ(NOW(), '$TIMEZONE', 'UTC') - INTERVAL 24 HOUR;"

# Clear Ram
sync; echo 3 > /proc/sys/vm/drop_caches

