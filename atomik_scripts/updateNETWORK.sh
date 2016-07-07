#!/bin/bash

eth0_status=$(mysql -uroot -praspberry -se "SELECT eth0_status FROM atomik_controller.atomik_settings");

wlan0_status=$(mysql -uroot -praspberry -se "SELECT wlan0_status FROM atomik_controller.atomik_settings");

eth0_type=$(mysql -uroot -praspberry -se "SELECT eth0_type FROM atomik_controller.atomik_settings");  # DHCP = 0 , Static = 1 

wlan0_type=$(mysql -uroot -praspberry -se "SELECT wlan0_type FROM atomik_controller.atomik_settings");

eth0_ip=$(mysql -uroot -praspberry -se "SELECT eth0_ip FROM atomik_controller.atomik_settings");

eth0_mask=$(mysql -uroot -praspberry -se "SELECT eth0_mask FROM atomik_controller.atomik_settings");

eth0_gate=$(mysql -uroot -praspberry -se "SELECT eth0_gateway FROM atomik_controller.atomik_settings");

eth0_dns=$(mysql -uroot -praspberry -se "SELECT eth0_dns FROM atomik_controller.atomik_settings");

wlan0_ip=$(mysql -uroot -praspberry -se "SELECT wlan0_ip FROM atomik_controller.atomik_settings");

wlan0_mask=$(mysql -uroot -praspberry -se "SELECT wlan0_mask FROM atomik_controller.atomik_settings");

wlan0_gate=$(mysql -uroot -praspberry -se "SELECT wlan0_gateway FROM atomik_controller.atomik_settings");

wlan0_dns=$(mysql -uroot -praspberry -se "SELECT wlan0_dns FROM atomik_controller.atomik_settings");

echo $eth0_status
echo $wlan0_status
echo $eth0_type
echo $wlan0_type


if [ $wlan0_status -eq 0 ] && [ $eth0_status -eq 1 ] && [ $wlan0_type -eq 0 ] && [ $eth0_type -eq 0 ] # 0 1 0 0 
then
  denyadap = 'denyinterfaces wlan0'
  static = ""
fi

if [ $wlan0_status -eq 1 ] && [ $eth0_status -eq 0 ] && [ $wlan0_type -eq 0 ] && [ $eth0_type -eq 0 ] # 1 0 0 0
then
  denyadap = 'denyinterfaces eth0'
  static = ""
fi

if [ $wlan0_status -eq 1 ] && [ $eth0_status -eq 1 ] && [ $wlan0_type -eq 0 ] && [ $eth0_type -eq 0 ] # 1 1 0 0 
then
  denyadap = '#denyinterfaces'
  static = ""
fi

if [ $wlan0_status -eq 0 ] && [ $eth0_status -eq 1 ] && [ $wlan0_type -eq 0 ] && [ $eth0_type -eq 1 ] # 0 1 0 1
then
  denyadap = 'denyinterfaces eth0 wlan0'
  static = "interface eth0\nstatic ip_address=$eth0_ip\nstatic routers=$eth0_gate\nstatic domain_name_servers=$eth0_dns\nstatic domain_search="
fi

if [ $wlan0_status -eq 1 ] && [ $eth0_status -eq 0 ] && [ $wlan0_type -eq 0 ] && [ $eth0_type -eq 1 ] # 1 0 0 1
then
  denyadap = 'denyinterfaces eth0'
  static = ""
fi

if [ $wlan0_status -eq 1 ] && [ $eth0_status -eq 1 ] && [ $wlan0_type -eq 0 ] && [ $eth0_type -eq 1 ] # 1 1 0 1
then
  echo Here
  denyadap = 'denyinterfaces eth0'
  static = "interface eth0\nstatic ip_address=$eth0_ip\nstatic routers=$eth0_gate\nstatic domain_name_servers=$eth0_dns\nstatic domain_search="
fi

if [ $wlan0_status -eq 0 ] && [ $eth0_status -eq 1 ] && [ $wlan0_type -eq 1 ] && [ $eth0_type -eq 0 ] # 0 1 1 0
then
  denyadap = 'denyinterfaces wlan0'
  static = ""
fi

if [ $wlan0_status -eq 1 ] && [ $eth0_status -eq 0 ] && [ $wlan0_type -eq 1 ] && [ $eth0_type -eq 0 ] # 1 0 1 0 
then
  denyadap = 'denyinterfaces eth0 wlan0'
  static = "interface wlan0\nstatic ip_address=$wlan0_ip\nstatic routers=$wlan0_gate\nstatic domain_name_servers=$wlan0_dns\nstatic domain_search="
fi

if [ $wlan0_status -eq 1 ] && [ $eth0_status -eq 1 ] && [ $wlan0_type -eq 1 ] && [ $eth0_type -eq 0 ] # 1 1 1 0
then
  denyadap = 'denyinterfaces wlan0'
  static = "interface wlan0\nstatic ip_address=$wlan0_ip\nstatic routers=$wlan0_gate\nstatic domain_name_servers=$wlan0_dns\nstatic domain_search="
fi

if [ $wlan0_status -eq 0 ] && [ $eth0_status -eq 1 ] && [ $wlan0_type -eq 1 ] && [ $eth0_type -eq 1 ] # 0 1 1 1
then
  denyadap = 'denyinterfaces eth0 wlan0'
  static = "interface eth0\nstatic ip_address=$eth0_ip\nstatic routers=$eth0_gate\nstatic domain_name_servers=$eth0_dns\nstatic domain_search="
fi

if [ $wlan0_status -eq 1 ] && [ $eth0_status -eq 0 ] && [ $wlan0_type -eq 1 ] && [ $eth0_type -eq 1 ] # 1 0 1 1 
then
  denyadap = 'denyinterfaces eth0 wlan0'
  static = "interface wlan0\nstatic ip_address=$wlan0_ip\nstatic routers=$wlan0_gate\nstatic domain_name_servers=$wlan0_dns\nstatic domain_search="
fi

if [ $wlan0_status -eq 1 ] && [ $eth0_status -eq 1 ] && [ $wlan0_type -eq 1 ] && [ $eth0_type -eq 1 ] # 1 1 1 1
then
  denyadap = 'denyinterfaces eth0 wlan0'
  static = "interface wlan0\nstatic ip_address=$wlan0_ip\nstatic routers=$wlan0_gate\nstatic domain_name_servers=$wlan0_dns\nstatic domain_search=\n\ninterface eth0\nstatic ip_address=$eth0_ip\nstatic routers=$eth0_gate\nstatic domain_name_servers=$eth0_dns\nstatic domain_search="
fi


echo $denyadap >> /tmp/t.out
echo $static >> /tmp/t1.out


 
#sudo sed -i '/denyinterfaces/d' /etc/dhcpcd.conf 

#sudo echo "$denyadap" >> /tmp/dhcpcd.conf 

