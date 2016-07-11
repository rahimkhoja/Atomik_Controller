#!/bin/bash

# Atomik Controller Script - Update Available WiFi's
# Bash
# By Rahim Khoja

# Requires Root

sudo iwlist wlan0 scan | grep SSID: | cut -d: -f2 | tr '\"' ' ' | awk {'print $1'} > /var/atomik/www/ssid.txt
sudo chown www-data:www-data /var/atomik/www/ssid.txt
