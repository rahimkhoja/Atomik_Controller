# Atomik Controller README #

# Version 0.8 Alpha
By Rahim Khoja

The Atomik Controller manages automated and smart lights. Initially The Atomik Controller will manage Mi-Light brand lights and Remotes, but it will expand to other Atomik and third party smart devices. The goal is to create a drop in replacement for the Mi-Light wifi bridge, that expands the zone and device limitations, while providing a more robust home lighting controller. The Atomik controller will boast a Web GUI for system management, a Nrf24l01+ 2.4 GHz transceiver for listening and transmitting, Mi-Light RF RGB remote compatibility, a Mi-Light Smartphone server emulator that allows use of the Mi-Light Smartphone app as a remote, an API for 3rd party integration, and a task scheduling system to control light zones. 

Hopefully in the future the Atomik Controller will add blue tooth connectivity, additional devices from a variety of manufacturers, Zigbee compatibility, Z-Wave compatibility, OpenHAB compatibility, a simple light io scripting interface, a fully documented API for 3rd party compatibility, and other types of devices and sensors. 



 **Features:**

 * Full featured web administration GUI
 * Maximum of 65,280 uniquely addressable Mi-Light RGB Devices ( But an unlimited amount of Devices can be Synced to a single address ) 
 * Maximum of 65,280 uniquely addressable Mi-Light CCT Devices ( But an unlimited amount of Devices can be Synced to a single address ) 
 * Unlimited amount of Mi-Light Smartphone Remotes ( Secured by MAC Address )
 * Maximum of 256 Mi-Light RGB RF Remotes
 * Unlimited amount of Atomik API Remotes ( for 3rd party integration )
 * Unlimited amount of Device Zones
 * Zones can include ANY mix of Devices and Remotes
 * Unlimited amount of scheduled Zone Tasks
 * WiFi and Ethernet connectivity
 * Drop-in replacement for the Mi-Light WiFi Bridge 

### How do I get set up? ###


 **Required Hardware:**

 
 * Raspberry Pi [All Models]
 * A Nrf24l01+ Radio Module
 * A USB Wifi Adapter
 * (Optional) A USB Bluetooth Adapter
 * (Optional) Apple or Android Smartphone with Mi-Light Software
 * 8GB or Greater SD Card
 * Mi-Light or Compatible RGB or CCT Bulbs
 * Local Area Network Access
 * A Web Browser



 **Hardware Setup:**


![raspberry_pi_nrf24l01_small.jpg](https://bitbucket.org/repo/z4EyAd/images/989963794-raspberry_pi_nrf24l01_small.jpg)


 **Install Instructions:**
 
 1. Download the ISO of the Atomik Controller (link)
 2. Write the ISO to an SD Card (Must fit in your Raspberry Pi)
 3. Put the SD Card into the Raspberry Pi that has been modified
 3. Set your systems Ethernet adapter's IP to 192.168.1.1 
 4. Plug the Atomik Controller into your lan and power it up
 6. After 2 Minutes go to http://192.168.1.100 in your web browser
 7. Login to the Atomik Controller with (Username: admin, Password: admin) 
 

### Atomik Controller Technical Details ###


 **Operating System:**

 
 * Raspbian (jessie)


 **Software Dependencies:**


 * RF24 Driver ( https://tmrh20.github.io/RF24/RPi.html )
 * Node.js 4.0+ ( https://nodejs.org/en/download/ )
 * Nginx
 * PHP
 * LibCurl
 * MariaDB (MySQL Fork) - Cuz we all love Microseconds
 * G++
 * MySQL C++ Connector


### References & Thanks ###

 * https://github.com/pmoscetta/authometion-milight  - Pietro Moscetta
 * https://github.com/henryk/openmili  - henryk
 * http://torsten-traenkner.de/wissen/smarthome/ (In German, Can't Actually Read Anything But The Code) - ?
 * https://github.com/bakkerr/openmilight_pi  - Roy Bakker
 * https://hackaday.io/project/5888-reverse-engineering-the-milight-on-air-protocol  - Henryk Plötz
 * https://gist.github.com/jpawlowski/5359556  - Julian Pawlowski

 * http://stackexchange.com/ 


### Screenshots of Web GUI ###

 * [Zone List Screen](https://i.imgsafe.org/6f1bf11c52.png)
 * [Zone Details Screen](https://i.imgsafe.org/6f1c079e18.png) 
 * [Device List Screen](https://i.imgsafe.org/6f1b373281.png)
 * [Device Details (White) Screen](https://i.imgsafe.org/6f1ad91fc0.png)
 * [Device Details (RGBW) Screen](https://i.imgsafe.org/6f1ae13f74.png)
 * [Login Screen](https://i.imgsafe.org/6f1bc9b8b6.png)
 * [Logout Screen](https://i.imgsafe.org/6f1b87a10d.png)
 * [Dashboard Screen](https://i.imgsafe.org/6f1ac5725d.png)
 * [Settings Screen](https://i.imgsafe.org/6f1bce3dd7.png)
 * [Remote List Screen](https://i.imgsafe.org/6f1be38077.png)
 * [Remote Details (Smartphone) Screen](https://i.imgsafe.org/6f1b349821.png)
 * [Remote Details (RGB RF) Screen](https://i.imgsafe.org/6f1bcc02db.png)
 * [Scheduled Task Details Screen](https://i.imgsafe.org/6f1b93bb37.png)



### Who do I talk to? ###

* Managed by Rahim Khoja (rahimk@khojacorp.com)
* Other community or team contact