#!/bin/sh
(sleep 10 && /var/atomik/scripts/checkrebootsignal.sh) &
(sleep 20 && /var/atomik/scripts/checkrebootsignal.sh) &
(sleep 30 && /var/atomik/scripts/checkrebootsignal.sh) &
(sleep 40 && /var/atomik/scripts/checkrebootsignal.sh) & 
(sleep 50 && /var/atomik/scripts/checkrebootsignal.sh) & 
(sleep 60 && /var/atomik/scripts/checkrebootsignal.sh) & 
