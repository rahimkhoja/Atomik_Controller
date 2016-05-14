#!/bin/bash

eth0_status=$(mysql -uroot -praspberry -se "SELECT eth0_status FROM atomik_controller.atomik_settings");

wlan0_status=$(mysql -uroot -praspberry -se "SELECT wlan0_status FROM atomik_controller.atomik_settings");

if [ $eth0_status -eq 1 ] && [ $wlan0_status -eq 1 ]
then
  denyadap = '#denyinterfaces'
fi

if [ $eth0_status -eq 0 ]
then
  denyadap = 'denyinterfaces eth0'
fi

if [ $wlan0_status -eq 0 ]
then
  denyadap = 'denyinterfaces wlan0'
fi
 
sudo sed -i '/denyinterfaces/d' /etc/dhcpcd.conf 

sudo echo "$denyadap" >> /etc/dhcpcd.conf 

eth0_type=$(mysql -uroot -praspberry -se "SELECT eth0_type FROM atomik_controller.atomik_settings");

wlan0_type=$(mysql -uroot -praspberry -se "SELECT wlan0_type FROM atomik_controller.atomik_settings");


if [ $eth0_type -eq 1 ]
then
  denyadap = 'denyinterfaces wlan0'
fi


sudo echo "server $ntp2 iburst" >> /etc/ntp.conf
sudo echo "server $ntp3 iburst" >> /etc/ntp.conf

sudo /etc/init.d/ntp restart

