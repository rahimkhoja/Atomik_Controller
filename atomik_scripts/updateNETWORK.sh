#!/bin/bash

# Atomik Controller Script - Update Eth0 Network Settings
# Bash
# By Rahim Khoja

# Requires Root, MySQL

function netmask2cidr()
{
  case $1 in
      0x*)
      local hex=${1#0x*} quad=
      while [ -n "${hex}" ]; do
        local lastbut2=${hex#??*}
        quad=${quad}${quad:+.}0x${hex%${lastbut2}*}
        hex=${lastbut2}
      done
      set -- ${quad}
      ;;
  esac

  local i= len=
  local IFS=.
  for i in $1; do
    while [ ${i} != "0" ]; do
      len=$((${len} + ${i} % 2))
      i=$((${i} >> 1))
    done
  done

  echo "${len}"
}


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

wlan0_mask_cidr=$(netmask2cidr $wlan0_mask);
eth0_mask_cidr=$(netmask2cidr $eth0_mask);

echo $wlan0_status
echo $eth0_status
echo $wlan0_type
echo $eth0_type

echo $wlan0_mask_cidr
echo $eth0_mask_cidr

if [ $wlan0_status == "0" ] && [ $eth0_status == "1" ] && [ $wlan0_type == "0" ] && [ $eth0_type == "0" ] # 0 1 0 0 
then
  denyadap='denyinterfaces wlan0'
  static=""
fi

if [ $wlan0_status == "1" ] && [ $eth0_status == "0" ] && [ $wlan0_type == "0" ] && [ $eth0_type == "0" ] # 1 0 0 0
then
  denyadap='denyinterfaces eth0'
  static=""
fi

if [ $wlan0_status == "1" ] && [ $eth0_status == "1" ] && [ $wlan0_type == "0" ] && [ $eth0_type == "0" ] # 1 1 0 0 
then
  denyadap='# denyinterfaces'
  static=""
fi

if [ $wlan0_status == "0" ] && [ $eth0_status == "1" ] && [ $wlan0_type == "0" ] && [ $eth0_type == "1" ] # 0 1 0 1
then
  denyadap='denyinterfaces wlan0'
  static="interface eth0\nstatic ip_address=$eth0_ip/$eth0_mask_cidr\nstatic routers=$eth0_gate\nstatic domain_name_servers=$eth0_dns\nstatic domain_search="
fi

if [ $wlan0_status == "1" ] && [ $eth0_status == "0" ] && [ $wlan0_type == "0" ] && [ $eth0_type == "1" ] # 1 0 0 1
then
  denyadap='denyinterfaces eth0'
  static=""
fi

if [ $wlan0_status == "1" ] && [ $eth0_status == "1" ] && [ $wlan0_type == "0" ] && [ $eth0_type == "1" ];
then
  denyadap='# denyinterfaces'
  static="interface eth0\nstatic ip_address=$eth0_ip/$eth0_mask_cidr\nstatic routers=$eth0_gate\nstatic domain_name_servers=$eth0_dns\nstatic domain_search="
fi

if [ $wlan0_status == "0" ] && [ $eth0_status == "1" ] && [ $wlan0_type == "1" ] && [ $eth0_type == "0" ] # 0 1 1 0
then
  denyadap='denyinterfaces wlan0'
  static=""
fi

if [ $wlan0_status == "1" ] && [ $eth0_status == "0" ] && [ $wlan0_type == "1" ] && [ $eth0_type == "0" ] # 1 0 1 0 
then
  denyadap='denyinterfaces eth0'
  static="interface wlan0\nstatic ip_address=$wlan0_ip/$wlan0_mask_cidr\nstatic routers=$wlan0_gate\nstatic domain_name_servers=$wlan0_dns\nstatic domain_search="
fi

if [ $wlan0_status == "1" ] && [ $eth0_status == "1" ] && [ $wlan0_type == "1" ] && [ $eth0_type == "0" ] # 1 1 1 0
then
  denyadap='# denyinterfaces'
  static="interface wlan0\nstatic ip_address=$wlan0_ip/$wlan0_mask_cidr\nstatic routers=$wlan0_gate\nstatic domain_name_servers=$wlan0_dns\nstatic domain_search="
fi

if [ $wlan0_status == "0" ] && [ $eth0_status == "1" ] && [ $wlan0_type == "1"] && [ $eth0_type == "1" ] # 0 1 1 1
then
  denyadap='denyinterfaces eth0'
  static="interface eth0\nstatic ip_address=$eth0_ip/$eth0_mask_cidr\nstatic routers=$eth0_gate\nstatic domain_name_servers=$eth0_dns\nstatic domain_search="
fi

if [ $wlan0_status == "1" ] && [ $eth0_status == "0" ] && [ $wlan0_type == "1" ] && [ $eth0_type == "1" ] # 1 0 1 1 
then
  denyadap='denyinterfaces eth0'
  static="interface wlan0\nstatic ip_address=$wlan0_ip/$wlan0_mask_cidr\nstatic routers=$wlan0_gate\nstatic domain_name_servers=$wlan0_dns\nstatic domain_search="
fi

if [ $wlan0_status == "1" ] && [ $eth0_status == "1" ] && [ $wlan0_type == "1" ] && [ $eth0_type == "1" ] # 1 1 1 1
then
  denyadap='# denyinterfaces'
  static="interface wlan0\nstatic ip_address=$wlan0_ip/$wlan0_mask_cidr\nstatic routers=$wlan0_gate\nstatic domain_name_servers=$wlan0_dns\nstatic domain_search=\n\n\n\ninterface eth0\nstatic ip_address=$eth0_ip/$eth0_mask_cidr\nstatic routers=$eth0_gate\nstatic domain_name_servers=$eth0_dns\nstatic domain_search="
fi

sudo sed -i '/denyinterfaces/d' /etc/dhcpcd.conf

dhcpcd=$(sudo sed '/^nohook lookup-hostname/q' /etc/dhcpcd.conf)

echo -e "$denyadap" > /tmp/dhcpcd.conf
echo -e "$dhcpcd" >> /tmp/dhcpcd.conf
echo -e "\n\n\n" >> /tmp/dhcpcd.conf
echo -e "$static" >> /tmp/dhcpcd.conf

sudo cp /etc/dhcpcd.conf /etc/dhcpcd.conf.atomik
sudo cp /tmp/dhcpcd.conf /etc/dhcpcd.conf
exit 0