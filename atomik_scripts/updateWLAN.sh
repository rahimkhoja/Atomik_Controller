#!/bin/bash

wlan0_ssid=$(mysql -uroot -praspberry -se "SELECT wlan0_ssid FROM atomik_controller.atomik_settings");
wlan0_method=$(mysql -uroot -praspberry -se "SELECT wlan0_method FROM atomik_controller.atomik_settings");
wlan0_algorithm=$(mysql -uroot -praspberry -se "SELECT wlan0_algorithm FROM atomik_controller.atomik_settings");
wlan0_password=$(mysql -uroot -praspberry -se "SELECT wlan0_password FROM atomik_controller.atomik_settings");

wpa_sup_file=$(sudo cat /etc/wpa_supplicant/wpa_supplicant.conf | sed -e '/network={/,/}/c\network={\n')

sudo echo -e "$wpa_sup_file"
printf "\tssid=\"%s\"\n" "$wlan0_ssid"
if [ $wlan0_method -eq 0 ] 
then 
echo -e 'proto=RSN'
echo -e 'key_mgmt=NONE'
fi

if [ $wlan0_method -eq 1: ]
then
echo -e 'proto=RSN'
echo -e 'key_mgmt=NONE'
fi


printf "\tSurname: %s\nName: %s\n" "$SURNAME" "$FIRSTNAME"
printf "Surname: %s\nName: %s\n" "$SURNAME" "$FIRSTNAME"
printf "Surname: %s\nName: %s\n" "$SURNAME" "$FIRSTNAME"


sudo echo -e "\n}"
exit 0
