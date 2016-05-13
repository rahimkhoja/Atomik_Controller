#!/bin/bash

sudo iwlist wlan0 scan | grep SSID: | cut -d: -f2 | tr '\"' ' ' | awk {'print $1'} > /var/atomik/www/ssid.txt
sudo chown www-data:www-data /var/atomik/www/ssid.txt
