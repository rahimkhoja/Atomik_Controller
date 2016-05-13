#!/bin/bash

hname=$(mysql -uroot -praspberry -se "SELECT hostname FROM atomik_controller.atomik_settings");
echo $hname > /etc/hostname;

sudo sed -i "/127.0.1.1/c\127.0.1.1\t$hname" /etc/hosts


sudo -S hostname $hname
sudo /etc/init.d/hostname.sh start




