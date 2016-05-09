#!/bin/bash
arg=$(head -n 1 /tmp/atomikreboot)   
if [ "$arg" == "doreboot" ]; then
  >/tmp/atomikreboot
  echo "Rebooting"
  echo 'atomik' | sudo -u atomik -S reboot
fi
