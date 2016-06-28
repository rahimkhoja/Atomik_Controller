# Atomik Controller README #

# Version 0.8 Alpha

The Atomik Controller manages automated and smart lights. Initially The Atomik Controller will manage Mi-Light brand lights and Remotes, but it will expand to other Atomik and third party smart devices. The Atomik controller will boast a Web GUI for system management, a radio transceiver for listening and transmitting with a Nrf24l01+ 2.4 GHz radio, Mi-Light RGB remote compatibility, a Mi-Light Smartphone server emulator that allows use of the Mi-Light Smartphone app as a remote, and a task scheduling system to control light zones. 

Hopefully in the future the Atomik Controller will add blue tooth connectivity, additional devices from a variety of manufacturers, Zigbee compatibility, Z-Wave compatibility, OpenHAB compatibility, a simple light io scripting interface, a fully documented API for 3rd party compatibility, and other types of devices and sensors. 

* Maximum of 65,280 Uniquely Addressable Mi-Light RGB Devices ( But an unlimited amount of devices can be Sync to an address) 
* Maximum of 65,280 Uniquely Addressable Mi-Light CCT Devices ( But an unlimited amount of devices can be Sync to an address) 
* Unlimited Amount of Mi-Light Smartphone Remotes ( Assigned Based on MAC Address )
* Maximum of 256 Mi-Light RGB RF Remotes
* Unlimited amount of Zones
* Zones can include ANY Mix of Devices and Remotes

### How do I get set up? ###


 **Required Hardware:**

 
 * Raspberry Pi [All Models]
 * A Nrf24l01+ Radio Module
 * A USB Wifi Adapter
 * (Optional) A USB Bluetooth Adapter

 
 **Operating System Requirements:**

 
 * Raspbian (jessie)


 **Software Dependencies:**


 * RF24 Driver ( https://tmrh20.github.io/RF24/RPi.html )
 * Node.js 4.0+ ( https://nodejs.org/en/download/ )
 * Nginx
 * PHP
 * LibCurl
 * MariaDB (MySQL Fork) - Cuz we all love Microseconds
 * G++


 **Install Instructions:**

 
```
#!bash

sudo apt-get update && sudo apt-get upgrade
sudo apt-get install wget git libcurl4-openssl-dev g++ nginx php5-fpm


sudo mkdir /var/log/atomik
sudo chown atomik:atomik /var/log/atomik
sudo mkdir /var/working
sudo chown atomik:atomik /var/working

```


### Who do I talk to? ###

* Managed by Rahim Khoja (rahimk@khojacorp.com)
* Other community or team contact