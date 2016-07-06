#!/bin/bash

wlan0_ssid=$(mysql -uroot -praspberry -se "SELECT wlan0_ssid FROM atomik_controller.atomik_settings");
wlan0_method=$(mysql -uroot -praspberry -se "SELECT wlan0_method FROM atomik_controller.atomik_settings"); # 0 = Disable, 1 = Open WEP, 2 = Shared Wep, 3 = WPAPSK, 4 = WPA2PSK
wlan0_algorithm=$(mysql -uroot -praspberry -se "SELECT wlan0_algorithm FROM atomik_controller.atomik_settings"); # 0 = ASCII, 1 = HEX, 2 = TKIP, 3 = AES
wlan0_password=$(mysql -uroot -praspberry -se "SELECT wlan0_password FROM atomik_controller.atomik_settings");

wpa_sup_file=$(sudo cat /etc/wpa_supplicant/wpa_supplicant.conf | sed -e '/network={/,/}/c\network={\n')

sudo echo -e "$wpa_sup_file" > /tmp/testwlan.out
if [ $wlan0_method == "0" ] 
then 
printf "\tssid=\"%s\"\n" "$wlan0_ssid" >> /tmp/testwlan.out
echo -e "\tkey_mgmt=NONE" >> /tmp/testwlan.out
fi

if [ $wlan0_method == "1" ]
then
printf "\tssid=\"%s\"\n" "$wlan0_ssid" >> /tmp/testwlan.out
echo -e "\tkey_mgmt=NONE" >> /tmp/testwlan.out
if [ $wlan0_algorithm == "0" ]
then
printf "\twep_key0=\"%s\"\n" "$wlan0_password" >> /tmp/testwlan.out
fi
if [ $wlan0_algorithm == "1" ]
then
printf "\twep_key0=%s\n" "$wlan0_password" >> /tmp/testwlan.out
fi

echo -e "\twep_tx_keyidx=0" >> /tmp/testwlan.out
fi

if [ $wlan0_method == "2" ]
then
printf "\tssid=\"%s\"\n" "$wlan0_ssid" >> /tmp/testwlan.out
echo -e "\tkey_mgmt=NONE" >> /tmp/testwlan.out
if [ $wlan0_algorithm == "0" ]
then
printf "\twep_key0=\"%s\"\n" "$wlan0_password" >> /tmp/testwlan.out
fi
if [ $wlan0_algorithm == "1" ]
then
printf "\twep_key0=%s\n" "$wlan0_password" >> /tmp/testwlan.out
fi

echo -e "\twep_tx_keyidx=0" >> /tmp/testwlan.out
echo -e "\tauth_alg=SHARED" >> /tmp/testwlan.out
fi

if [ $wlan0_method == "3" ]
then
printf "\tssid=\"%s\"\n" "$wlan0_ssid" >> /tmp/testwlan.out
echo -e "\tproto=WPA" >> /tmp/testwlan.out
echo -e "\tkey_mgmt=WPA-PSK" >> /tmp/testwlan.out
echo -e "\tpairwise=CCMP TKIP" >> /tmp/testwlan.out
echo -e "\tgroup=CCMP TKIP WEP104 WEP40" >> /tmp/testwlan.out
printf "\tpsk=\"%s\"\n" "$wlan0_password" >> /tmp/testwlan.out
fi

if [ $wlan0_method == "4" ]
then
printf "\tssid=\"%s\"\n" "$wlan0_ssid" >> /tmp/testwlan.out
printf "\tpsk=\"%s\"\n" "$wlan0_password" >> /tmp/testwlan.out
echo -e "\tproto=RSN" >> /tmp/testwlan.out
echo -e "\tkey_mgmt=WPA-PSK" >> /tmp/testwlan.out
if [ $wlan0_algorithm == "2" ]
then
echo -e "\tpairwise=TKIP" >> /tmp/testwlan.out
fi
if [ $wlan0_algorithm == "3" ]
then
echo -e "\tpairwise=CCMP" >> /tmp/testwlan.out
fi

fi

sudo echo -e "}"  >> /tmp/testwlan.out
exit 0
