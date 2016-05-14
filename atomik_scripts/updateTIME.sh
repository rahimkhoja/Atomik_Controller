#!/bin/bash

ntp1=$(mysql -uroot -praspberry -se "SELECT ntp_server_1 FROM atomik_controller.atomik_settings");

ntp2=$(mysql -uroot -praspberry -se "SELECT ntp_server_2 FROM atomik_controller.atomik_settings");

ntp3=$(mysql -uroot -praspberry -se "SELECT ntp_server_3 FROM atomik_controller.atomik_settings");

sudo sed -i '/^server/d' /etc/ntp.conf

sudo echo "server $ntp1 iburst" >> /etc/ntp.conf
sudo echo "server $ntp2 iburst" >> /etc/ntp.conf
sudo echo "server $ntp3 iburst" >> /etc/ntp.conf

sudo /etc/init.d/ntp restart

