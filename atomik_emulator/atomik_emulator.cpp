// sudo g++ -std=c++11 -lcurl -ljsoncpp -L/usr/lib -lmysqlcppconn -I/usr/include/cppconn atomik_cypher/atomikCypher.cpp atomik_emulator/atomik_emulator.cpp -o emulator


#include <arpa/inet.h>
#include <chrono>
#include <cstring>
#include <cstdlib>
#include <errno.h>
#include <fstream>
#include <iostream>
#include <linux/sockios.h>
#include <net/if_arp.h>
#include <netinet/in.h>
#include <sstream>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/ioctl.h>
#include <sys/select.h>
#include <sys/socket.h>
#include <sys/time.h>
#include <unistd.h>
#include <utility>
#include <fstream>
#include <curl/curl.h>

#include <mutex>

#include "mysql_connection.h"

#include <cppconn/driver.h>
#include <cppconn/exception.h>
#include <cppconn/resultset.h>
#include <cppconn/statement.h>
#include <jsoncpp/json/json.h>
#include <jsoncpp/json/reader.h>
#include <jsoncpp/json/writer.h>
#include <jsoncpp/json/value.h>

#include "../atomik_cypher/atomikCypher.h"

using namespace std;

float ver = 0.8;
static int debug = 0;
static int dupesPrinted = 0;
static atomikCypher MiLightCypher;

std::mutex JSONfileMutex;


sql::Driver *driver;
sql::Connection *con;


std::string int2hex(int x)
{
    char out[2];
    sprintf(out, "%02X", x);
    return std::string(out);
}

std::string int2int(int x)
{
    std::stringstream ss;
    ss << x;
    return ss.str();
}

int hex2int(std::string hexnum) {

        int x = std::strtol(hexnum.c_str(), NULL, 16);
        return x;
}


void runCommand(std::string command) {

    FILE *in;
	char buff[512];

	if(!(in = popen(command.c_str(), "r"))){
		return;
	}
    
	pclose(in);
}


int getAtomikJSONValue(std::string name, std::string atomikJSON) {

        Json::Value root;
        Json::Value conf;
        std::stringstream buffer;
        Json::Reader reader;

        bool parsingSuccessful = reader.parse( atomikJSON.c_str(), root );     //parse process
        if ( !parsingSuccessful )
        {
                std::cout  << "Failed to parse"
                << reader.getFormattedErrorMessages();
                return -1;
        }

        buffer << root.get("Configuration", "error" ) << std::endl;

        parsingSuccessful = reader.parse( buffer, conf );     //parse process
        if ( !parsingSuccessful )
        {
                std::cout  << "Failed to parse"
               << reader.getFormattedErrorMessages();
                return -1;
        }

        if (name == "Address1") {
                std::string output = root.get("Address1", "error" ).asString();

                if (  output == "error" ) {
                        return -1;
                } else {
                        return hex2int(output);
                }
        } else if (name == "Address2") {
                std::string output = root.get("Address2", "error" ).asString();

                if (  output == "error" ) {
                        return -1;
                } else {
                        return hex2int(output);
                }
        } else if (name == "ColorMode") {
                std::string output = conf.get("ColorMode", "error" ).asString();

                if (  output == "error" ) {
                        return -1;
                } else if (output == "RGB256") {
                        return 0;
                } else if (output == "White") {
                        return 1;
                }
        } else if (name == "Color") {
                std::string output = conf.get("Color", "error" ).asString();

                if (  output == "error" ) {
                        return -1;
                } else {
                        return std::stoi(output);
                }
        } else if (name == "Brightness") {
                std::string output = conf.get("Brightness", "error" ).asString();

                if (  output == "error" ) {
                        return -1;
                } else if ( output == "Max" ) {
                        return 100;
                } else if ( output == "Nightlight" ) {
                        return 4;
                } else {
                        return std::stoi(output);
                }
        } else if ( name == "Status") {
                std::string output = conf.get("Status", "error" ).asString();

                if (  output == "error" ) {
                        return -1;
                } else if (output == "On") {
                        return 1;
                } else if (output == "Off") {
                        return 0;
                }
        } else if ( name == "Channel") {
                std::string output = conf.get("Channel", "error" ).asString();

                if (  output == "error" ) {
                        return -1;
                } else {
                        return std::stoi(output);
                }
        } 

}

std::string getAtomikJSONMAC(std::string json) {

        Json::Value root;
        std::stringstream buffer;
        Json::Reader reader;

        bool parsingSuccessful = reader.parse( json.c_str(), root );     //parse process
        
        if ( !parsingSuccessful )
        {
                std::cout  << "Failed to parse"
                << reader.getFormattedErrorMessages();
                return "error";
        }

        std::string output = root.get("MAC", "error" ).asString();
        return output;
}

std::string getLocalTimezone() {

    FILE *in;
	char buff[512];

	if(!(in = popen("cat /etc/timezone", "r"))){
		return "";
	}

	while(fgets(buff, sizeof(buff), in)!=NULL){
		std::cout << buff << std::endl;
	}
	pclose(in);
    std::string str(buff);
    str.erase(str.find_last_not_of(" \n\r\t")+1);
    return str;
}

void updateZoneDevicesProperties(sql::Connection *con, int zone, std::string timezone) {

    std::string sql_update;
	
	sql_update = "UPDATE atomik_zone_devices SET zone_device_last_update=CONVERT_TZ(NOW(), '"+timezone+"', 'UTC') WHERE zone_device_zone_id="+int2int(zone)+";";
    try {
        
        sql::Statement *stmt;
        int recordsUpdated;

        stmt = con->createStatement();
        recordsUpdated = stmt->executeUpdate(sql_update);
  
        std::cout << " updateZoneDevicesProperties: ( Zone: " << zone << " ) " << recordsUpdated << " Records Updated!" << std::endl;
    
        delete stmt;

    } catch (sql::SQLException &e) {
        std::cout << "# ERR: SQLException in " << __FILE__;
        std::cout << "# ERR: " << e.what();
        std::cout << " (MySQL error code: " << e.getErrorCode();
        std::cout << ", SQLState: " << e.getSQLState() << " )" << std::endl;
    }
}

void updateCurrentChannel(sql::Connection *con, int channel, std::string mac) {

    std::string sql_update;
	
	sql_update = "UPDATE atomik_remotes SET remote_current_channel="+int2int(channel)+" WHERE remote_mac='"+mac+"';"; 
    
    try {
        
        sql::Statement *stmt;
        int recordsUpdated;

        stmt = con->createStatement();
        recordsUpdated = stmt->executeUpdate(sql_update);
      
        delete stmt;

    } catch (sql::SQLException &e) {
        std::cout << "# ERR: SQLException in " << __FILE__;
        std::cout << "# ERR: " << e.what();
        std::cout << " (MySQL error code: " << e.getErrorCode();
        std::cout << ", SQLState: " << e.getSQLState() << " )" << std::endl;
    }
}



bool validRFAddressCheck(sql::Connection *con, int add1, int add2 ) {
    
    bool success;
    
	std::string sql_select;
	
	sql_select = "SELECT atomik_zones.zone_id, atomik_zone_remotes.zone_remote_remote_id FROM atomik_zones, atomik_remotes, atomik_zone_remotes WHERE atomik_zones.zone_id=atomik_zone_remotes.zone_remote_zone_id && atomik_zone_remotes.zone_remote_remote_id=atomik_remotes.remote_id && atomik_remotes.remote_address1="+int2int(add1)+" && atomik_remotes.remote_address2="+int2int(add2)+";"; 
    
    try {
        
        sql::Statement *stmt;
        int records;
        sql::ResultSet *res;

        stmt = con->createStatement();
        res = stmt->executeQuery(sql_select);
        
        records = res -> rowsCount();
        
        std::cout << " validRFAddressCheck: ( RF: " << add1 << " , " << add2 << " ) "; 
        
        if ( records > 0 ) {
            success = true;
            std::cout << " VALID" << std::endl;
        } else {
            success = false;
            std::cout << " NOT VALID" << std::endl;
        }
        
        delete res;
        delete stmt;

    } catch (sql::SQLException &e) {
        success = false;
        std::cout << "# ERR: SQLException in " << __FILE__;
        std::cout << "# ERR: " << e.what();
        std::cout << " (MySQL error code: " << e.getErrorCode();
        std::cout << ", SQLState: " << e.getSQLState() << " )" << std::endl;
    }
    return success;
}
	

void updateDeviceProperties(sql::Connection *con, int status, int colormode, int brightness, int rgb256, int whitetemp, int transnum, int device) {

    std::string sql_update;
	
	sql_update = "UPDATE atomik_devices SET device_status="+int2int(status)+", device_colormode="+int2int(colormode)+", device_brightness="+int2int(brightness)+", device_rgb256="+int2int(rgb256)+", device_white_temprature="+int2int(whitetemp)+", device_transmission="+int2int(transnum)+" WHERE device_id="+int2int(device)+";";
	
    try {
        
        sql::Statement *stmt;
        int recordsUpdated;

        stmt = con->createStatement();
        recordsUpdated = stmt->executeUpdate(sql_update);
  
        std::cout << " updateDeviceProperties: ( Device: " << device << " ) " << std::endl;
    
        delete stmt;

    } catch (sql::SQLException &e) {
        std::cout << "# ERR: SQLException in " << __FILE__;
        std::cout << "# ERR: " << e.what();
        std::cout << " (MySQL error code: " << e.getErrorCode();
        std::cout << ", SQLState: " << e.getSQLState() << " )" << std::endl;
    }
}

void updateZoneProperties(sql::Connection *con, int zone, int bright, int status, int color, int whitetemp, int colormode, std::string timezone) {
	
	std::string sql_update;
	
	sql_update = "UPDATE atomik_zones SET zone_status="+int2int(status)+", zone_colormode="+int2int(colormode)+", zone_brightness="+int2int(bright)+", zone_rgb256="+int2int(color)+", zone_white_temprature="+int2int(whitetemp)+",zone_last_update = CONVERT_TZ(NOW(), '"+timezone+"', 'UTC') WHERE zone_id="+int2int(zone)+";";
	
    try {
        
        sql::Statement *stmt;
        int recordsUpdated;

        stmt = con->createStatement();
        recordsUpdated = stmt->executeUpdate(sql_update);
  
        std::cout << " Updated " << recordsUpdated << " Records in Zone Table" << std::endl;
    
        delete stmt;

    } catch (sql::SQLException &e) {
        std::cout << "# ERR: SQLException in " << __FILE__;
        std::cout << "# ERR: " << e.what();
        std::cout << " (MySQL error code: " << e.getErrorCode();
        std::cout << ", SQLState: " << e.getSQLState() << " )" << std::endl;
    }
}

// Set Color Brightness to Valid Value
int colorBright ( int bri ) {
	int bright = bri;
	
  	if (bright <= 4) {
    	bright = 4;
	} else if (bright <= 8) {
    	bright = 8;
	} else if (bright <= 12) {
    	bright = 12;
	} else if (bright <= 15) {
    	bright = 15;
	} else if (bright <= 19) {
    	bright = 19;
	} else if (bright <= 23) {
    	bright = 23;
	} else if (bright <= 27) {
    	bright = 27;
	} else if (bright <= 31) {
    	bright = 31;
	} else if (bright <= 35) {
    	bright = 35;
	} else if (bright <= 39) {
    	bright = 39;
	} else if (bright <= 42) {
    	bright = 42;
	} else if (bright <= 46) {
    	bright = 46;
	} else if (bright <= 50) {
    	bright = 50;
	} else if (bright <= 54) {
    	bright = 54;
	} else if (bright <= 58) {
    	bright = 58;
	} else if (bright <= 62) {
    	bright = 62;
	} else if (bright <= 65) {
    	bright = 65;
	} else if (bright <= 69) {
    	bright = 69;
	} else if (bright <= 73) {
    	bright = 73;
	} else if (bright <= 77) {
    	bright = 77;
	} else if (bright <= 81) {
    	bright = 81;
	} else if (bright <= 85) {
    	bright = 85;
	} else if (bright <= 88) {
    	bright = 88;
	} else if (bright <= 92) {
    	bright = 92;
	} else if (bright <= 96) {
    	bright = 96;
	} else if (bright <= 100) {
	    bright = 100;
	} else {
		bright = 100;
	}
  
	return bright;
}

// Set White Brightness To Valid Value
int whiteBright( int bri ) {
	int bright = bri;
	if (bright <= 9) {
	    bright = 9;
	} else if (bright <= 18) {
    	bright = 18;
  	} else if (bright <= 27) {
   	 	bright = 27;
  	} else if (bright <= 36) {
    	bright = 36;
  	} else if (bright <= 45) {
    	bright = 45;
  	} else if (bright <= 54) {
    	bright = 54;
  	} else if (bright <= 63) {
    	bright = 63;
  	} else if (bright <= 72) {
    	bright = 72;
  	} else if (bright <= 81) {
    	bright = 81;
  	} else if (bright <= 90) {
    	bright = 90;
  	} else if (bright <= 100) {
    	bright = 100;
  	} else {
		bright = 100;
  	}
	return bright;
}

// Increment Transmission Number Between 0 and 255
int IncrementTransmissionNum( int number ){
	int trans = number + 1;

	if (trans >= 256) {
		trans = trans - 256;
	}
	return trans;
}

// Transmits Commands To Bulbs
int transmit(int new_b, int old_b, int new_s, int old_s, int new_c, int old_c, int new_wt, int old_wt, int new_cm, int old_cm, int add1, int add2, int tra, int rgb, int cw, int ww) {

    std::string sendcommandbase;
	std::string sendcom;
    std::string initcom;
	int trans = tra;
    int move;
	
	if (cw == 1 && ww == 1 && rgb != 1) {
    sendcommandbase = "/usr/bin/transceiver -t 2 -q " + int2hex(add1) + " -r " + int2hex(add2) + " -c 01";

    // White Bulb Details

	int Brightness[] = {9, 18, 27, 36, 45, 54, 63, 72, 81, 90, 100};  // 11 Elements
    int WhiteTemp[] = {2700, 3080, 3460, 3840, 4220, 4600, 4980, 5360, 5740, 6120, 6500}; // 11 Elements 
	
    if (new_s != old_s) {
      // Status Changed

      trans = IncrementTransmissionNum(trans);

      if (new_s == 1) {
        sendcom = sendcommandbase + " -k " + int2hex((255 - trans)) + " -v " + int2hex(trans) + " -b 08";
		old_b = 9;
      } else {
        sendcom = sendcommandbase + " -k " + int2hex((255 - trans)) + " -v " + int2hex(trans) + " -b 0B";
      }

      runCommand(sendcom);
    } // End Status Change
    
	if (new_s == 1) {
      // Status On

      if (old_cm != new_cm) {
        trans = IncrementTransmissionNum(trans);
	  
        // Color Mode Change
		old_b = 9;
        if (new_cm == 1) {
          sendcom = sendcommandbase + " -k " + int2hex((255 - trans)) + " -v " + int2hex(trans) + " -b 18";
		  
        } else {
          sendcom = sendcommandbase + " -k " + int2hex((255 - trans)) + " -v " + int2hex(trans) + " -b 08";
        }

        runCommand(sendcom);
	  }

	if (new_b != old_b) {
		// Brightness Change
		new_b = whiteBright( new_b );
		int old_pos = std::distance(Brightness, std::find(Brightness, Brightness + 11, old_b));    //   array_search(old_b, Brightness);
		int new_pos = std::distance(Brightness, std::find(Brightness, Brightness + 11, new_b));    //   array_search(new_b, Brightness);
		
		if (new_pos > old_pos) {
			if (new_pos == std::distance(Brightness, std::find(Brightness, Brightness + 11, 100)) ) {
				trans = IncrementTransmissionNum(trans);
				sendcom = sendcommandbase + " -k " + int2hex((255 - trans)) + " -v " + int2hex(trans) + " -b 18";
                runCommand(sendcom);
            } else {
				move = new_pos - old_pos;
				for (int x = 0; x <= move; x++) {
					trans = IncrementTransmissionNum(trans);
					sendcom = sendcommandbase + " -k " + int2hex((255 - trans)) + " -v " + int2hex(trans) + " -b 0C";
                    runCommand(sendcom);
				}
			}
		} else {
			move = old_pos - new_pos;
			for (int x = 0; x <= move; x++) {
				trans = IncrementTransmissionNum(trans);
				sendcom = sendcommandbase + " -k " + int2hex((255 - trans)) + " -v " + int2hex(trans) + " -b 04";
                runCommand(sendcom);
			}
		}
	}

	if (new_wt != old_wt) {
		// White Temp Change

		int old_pos = std::distance(WhiteTemp, std::find(WhiteTemp, WhiteTemp + 11, old_wt));    //   array_search(old_wt, WhiteTemp);
        
		int new_pos = std::distance(WhiteTemp, std::find(WhiteTemp, WhiteTemp + 11, new_wt));    //   array_search(new_wt, WhiteTemp);
		
		if (new_pos > old_pos) {
			move = new_pos - old_pos;
			
			for (int x = 0; x <= move; x++) {
				trans = IncrementTransmissionNum(trans);
				sendcom = sendcommandbase + " -k " + int2hex((255 - trans)) + " -v " + int2hex(trans) + " -b 0f";
                runCommand(sendcom);
			}
		} else {
			move = old_pos - new_pos;
            for (int x = 0; x <= move; x++) {
              trans = IncrementTransmissionNum(trans);
              sendcom = sendcommandbase + " -k " + int2hex((255 - trans)) + " -v " + int2hex(trans) + " -b 0e";
              runCommand(sendcom);
            }
          }
        }
      }
	  
  } else if (cw == 1 && rgb == 1 || ww == 1 && rgb == 1) {
      sendcommandbase = "/usr/bin/transceiver -t 1 -q " + int2hex(add1) + " -r " + int2hex(add2);
      // RGBWW and RGBCW

      if (new_s != old_s) {

        // Status Changed
        trans = IncrementTransmissionNum(trans);

        if (new_s == 1) {
          sendcom = sendcommandbase + " -k 03 -v " + int2hex(trans);
		  old_cm = -1;
		  old_b = 0;
		  
        }        else {
          sendcom = sendcommandbase + " -k 04 -v " + int2hex(trans);
        }
        runCommand(sendcom);
      }
      // End Status Change

      if (new_s == 1) {

        // Status On

        if (old_cm != new_cm) {

          // Color Mode Change

          trans = IncrementTransmissionNum(trans);

          if (new_cm == 1) {
            sendcom = sendcommandbase + " -k 13 -v " + int2hex(trans) + " -c " + int2hex(old_c);
			
          }          else {
            sendcom = sendcommandbase + " -k 03 -v " + int2hex(trans) + " -c " + int2hex(old_c);
			old_b = 0;
          }
          runCommand(sendcom);
        }

        // End Color Mode Change > /dev/null &

        if (new_cm == 0) {
          // Color Mode Color

          if (new_c != old_c ) {
            // Color Change
            trans = IncrementTransmissionNum(trans);

            initcom = sendcommandbase + " -c " + int2hex(new_c) + " -k 03 -v " + int2hex(trans);
            runCommand(initcom);
            trans = IncrementTransmissionNum(trans);

            sendcom = sendcommandbase + " -c " + int2hex(new_c) + " -k 0f -v " + int2hex(trans);
            runCommand(sendcom);
          }
          // End Color Change

        }
        // End Color Mode Color

        if (new_b != old_b) {
          // Brightness Change

          trans = IncrementTransmissionNum(trans);

          if (new_b == 4) {
            sendcom = sendcommandbase + " -c " + int2hex(new_c) + " -b " + int2hex(129) + " -k 0e -v " + int2hex(trans);
           } else if ( new_b == 8) {
            sendcom = sendcommandbase + " -c " + int2hex(new_c) + " -b " + int2hex(121) + " -k 0e -v " + int2hex(trans);
           } else if ( new_b == 12) {
            sendcom = sendcommandbase + " -c " + int2hex(new_c) + " -b " + int2hex(113) + " -k 0e -v " + int2hex(trans);
           } else if ( new_b == 15) {
            sendcom = sendcommandbase + " -c " + int2hex(new_c) + " -b " + int2hex(105) + " -k 0e -v " + int2hex(trans);
           } else if ( new_b == 19) {
            sendcom = sendcommandbase + " -c " + int2hex(new_c) + " -b " + int2hex(97) + " -k 0e -v " + int2hex(trans);
           } else if ( new_b == 23) {
            sendcom = sendcommandbase + " -c " + int2hex(new_c) + " -b " + int2hex(89) + " -k 0e -v " + int2hex(trans);
           } else if ( new_b == 27) {
            sendcom = sendcommandbase + " -c " + int2hex(new_c) + " -b " + int2hex(81) + " -k 0e -v " + int2hex(trans);
           } else if ( new_b == 31) {
            sendcom = sendcommandbase + " -c " + int2hex(new_c) + " -b " + int2hex(73) + " -k 0e -v " + int2hex(trans);
           } else if ( new_b == 35) {
            sendcom = sendcommandbase + " -c " + int2hex(new_c) + " -b " + int2hex(65) + " -k 0e -v " + int2hex(trans);
           } else if ( new_b == 39) { //10
            sendcom = sendcommandbase + " -c " + int2hex(new_c) + " -b " + int2hex(57) + " -k 0e -v " + int2hex(trans);
           } else if ( new_b == 42) { //11
            sendcom = sendcommandbase + " -c " + int2hex(new_c) + " -b " + int2hex(49) + " -k 0e -v " + int2hex(trans);
           } else if ( new_b == 46) { //12
            sendcom = sendcommandbase + " -c " + int2hex(new_c) + " -b " + int2hex(41) + " -k 0e -v " + int2hex(trans);
           } else if ( new_b == 50) { //13
            sendcom = sendcommandbase + " -c " + int2hex(new_c) + " -b " + int2hex(33) + " -k 0e -v " + int2hex(trans);
           } else if ( new_b == 54) { //14
            sendcom = sendcommandbase + " -c " + int2hex(new_c) + " -b " + int2hex(25) + " -k 0e -v " + int2hex(trans);
           } else if ( new_b == 58) { //15
            sendcom = sendcommandbase + " -c " + int2hex(new_c) + " -b " + int2hex(17) + " -k 0e -v " + int2hex(trans);
           } else if ( new_b == 62) { //16
            sendcom = sendcommandbase + " -c " + int2hex(new_c) + " -b " + int2hex(9) + " -k 0e -v " + int2hex(trans);
           } else if ( new_b == 65) { //17
            sendcom = sendcommandbase + " -c " + int2hex(new_c) + " -b " + int2hex(1) + " -k 0e -v " + int2hex(trans);
           } else if ( new_b == 69) { //18
            sendcom = sendcommandbase + " -c " + int2hex(new_c) + " -b " + int2hex(249) + " -k 0e -v " + int2hex(trans);
           } else if ( new_b == 73) { //19
            sendcom = sendcommandbase + " -c " + int2hex(new_c) + " -b " + int2hex(241) + " -k 0e -v " + int2hex(trans);
           } else if ( new_b == 77) { // 20
            sendcom = sendcommandbase + " -c " + int2hex(new_c) + " -b " + int2hex(233) + " -k 0e -v " + int2hex(trans);
           } else if ( new_b == 81) { // 21
            sendcom = sendcommandbase + " -c " + int2hex(new_c) + " -b " + int2hex(225) + " -k 0e -v " + int2hex(trans);
           } else if ( new_b == 85) { // 22
            sendcom = sendcommandbase + " -c " + int2hex(new_c) + " -b " + int2hex(217) + " -k 0e -v " + int2hex(trans);
           } else if ( new_b == 88) { // 23
            sendcom = sendcommandbase + " -c " + int2hex(new_c) + " -b " + int2hex(209) + " -k 0e -v " + int2hex(trans);
           } else if ( new_b == 92) { // 24
            sendcom = sendcommandbase + " -c " + int2hex(new_c) + " -b " + int2hex(201) + " -k 0e -v " + int2hex(trans);
           } else if ( new_b == 96) { // 25
            sendcom = sendcommandbase + " -c " + int2hex(new_c) + " -b " + int2hex(193) + " -k 0e -v " + int2hex(trans);
           } else if ( new_b == 100) { // 26
            sendcom = sendcommandbase + " -c " + int2hex(new_c) + " -b " + int2hex(185) + " -k 0e -v " + int2hex(trans);
          }
          runCommand(sendcom);
        }

        // End Brightness Change
      }

      // End Status On
    }
    return trans;
  }



bool updateZone(sql::Connection *con, int status, int colormode, int brightness, int rgb256, int whitetemp, int zone, std::string timezone) {
    
    bool success = true;
    int new_s = status;
    int new_cm = colormode;
    int new_c = rgb256;
    int new_b = brightness;
    int new_wt = whitetemp;
    
    std::string sql_select;
    
    sql_select = "SELECT atomik_zones.zone_status, atomik_zones.zone_colormode, atomik_zones.zone_brightness, atomik_zones.zone_rgb256, atomik_zones.zone_white_temprature FROM atomik_zones WHERE atomik_zones.zone_id="+int2int(zone)+";";
    
    try {
        
        sql::Statement *stmt;
        sql::ResultSet *res;

        stmt = con->createStatement();
        res = stmt->executeQuery(sql_select);
        res->next();
        
            std::cout << "Loading Current Zone Data ... " << std::endl;
            /* Access column data by alias or column name */
            
            if (new_s == -1 ) {
                    new_s        = res->getInt("zone_status");
            }
            if (new_cm == -1 ) {
                    new_cm     = res->getInt("zone_colormode");
            }
            if (new_b == -1 ) {
                    new_b    = res->getInt("zone_brightness");
            }
            if (new_c == -1 ) {
                    new_c        = res->getInt("zone_rgb256"); 
            }
            if (new_wt == -1 ) {
                    new_wt     = res->getInt("zone_white_temprature"); 
            }
        
        std::cout << "Status: " << new_s << " - ColorMode: " << new_cm << " - Brightness: " << new_b << " - Color: " << new_c << " - WhiteTemp: " << new_wt << std::endl;
        delete stmt;
        delete res;

    } catch (sql::SQLException &e) {
        success = false;
        std::cout << "# ERR: SQLException in " << __FILE__;
        std::cout << "# ERR: " << e.what();
        std::cout << " (MySQL error code: " << e.getErrorCode();
        std::cout << ", SQLState: " << e.getSQLState() << " )" << std::endl;
    }
    
    
    sql_select = "SELECT atomik_devices.device_id, atomik_devices.device_status, atomik_devices.device_colormode, atomik_devices.device_brightness, atomik_devices.device_rgb256, atomik_devices.device_white_temprature, atomik_devices.device_address1, atomik_devices.device_address2, atomik_device_types.device_type_rgb256, atomik_device_types.device_type_warm_white, atomik_device_types.device_type_cold_white, atomik_devices.device_transmission FROM atomik_zone_devices, atomik_device_types, atomik_devices WHERE atomik_zone_devices.zone_device_zone_id="+int2int(zone)+" && atomik_zone_devices.zone_device_device_id=atomik_devices.device_id && atomik_devices.device_type=atomik_device_types.device_type_id && atomik_device_types.device_type_brightness=1 ORDER BY atomik_devices.device_type ASC;";
       
    try {
        
        sql::Statement *stmt;
        sql::ResultSet *res;

        stmt = con->createStatement();
        res = stmt->executeQuery(sql_select);
          
        while (res->next()) {
            std::cout << "\tUpdating Devices... " << std::endl;
            /* Access column data by alias or column name */
            std::cout << "Device ID: " << res->getInt("device_id") << std::endl;
            
            int old_status        = res->getInt("device_status");
            int old_colormode     = res->getInt("device_colormode");
            int old_brightness    = res->getInt("device_brightness");
            int old_color         = res->getInt("device_rgb256"); 
            int old_whitetemp     = res->getInt("device_white_temprature"); 
            int old_trans_id      = res->getInt("device_transmission");
            int address1          = res->getInt("device_address1");
            int address2          = res->getInt("device_address2"); 
            int type_rgb          = res->getInt("device_type_rgb256");
            int type_ww           = res->getInt("device_type_warm_white");
            int type_cw           = res->getInt("device_type_cold_white");
            int dev_id            = res->getInt("device_id"); 
            
            if ( type_cw == 1 & type_ww == 1 ) {
                new_b = whiteBright(new_b);
            } else {
                    new_b = colorBright(new_b);
            }
            
            int trans_id = transmit(new_b, old_brightness, new_s, old_status, new_c, old_color, new_wt, old_whitetemp, new_cm, old_colormode, address1, address2, old_trans_id, type_rgb, type_cw, type_ww);
            updateDeviceProperties(con, new_s, new_cm, new_b, new_c, new_wt, trans_id, dev_id);
        }
        
        updateZoneProperties(con, zone, new_b, new_s, new_c, new_wt, new_cm, timezone);
        updateZoneDevicesProperties(con, zone, timezone);
        
        std::cout << " updateZone: ( Zone: " << zone << " ) " << std::endl;
    
        delete stmt;
        delete res;

    } catch (sql::SQLException &e) {
        success = false;
        std::cout << "# ERR: SQLException in " << __FILE__;
        std::cout << "# ERR: " << e.what();
        std::cout << " (MySQL error code: " << e.getErrorCode();
        std::cout << ", SQLState: " << e.getSQLState() << " )" << std::endl;
    }
    
    return success;
    
}

int validateRFChannel(sql::Connection *con, std::string mac, int chan) {
    int success = -1;
    std::string sql_select;
    int records;
	
    if ( chan == -1 ) {
	    sql_select = "SELECT atomik_zones.zone_id FROM atomik_zones, atomik_remotes, atomik_zone_remotes WHERE atomik_zones.zone_id = atomik_zone_remotes.zone_remote_zone_id && atomik_zone_remotes.zone_remote_remote_id = atomik_remotes.remote_id && atomik_remotes.remote_mac='"+mac+"' && atomik_remotes.remote_current_channel=atomik_zone_remotes.zone_remote_channel_number;";
    } else {
        sql_select = "SELECT atomik_zones.zone_id, atomik_zone_remotes.zone_remote_remote_id FROM atomik_zones, atomik_remotes, atomik_zone_remotes WHERE atomik_zones.zone_id=atomik_zone_remotes.zone_remote_zone_id && atomik_zone_remotes.zone_remote_remote_id=atomik_remotes.remote_id && atomik_remotes.remote_mac='"+mac+"' && atomik_zone_remotes.zone_remote_channel_number="+int2int(chan)+";"; 
    }
    
    try {
    
        sql::Statement *stmt;
        sql::ResultSet *res;
        stmt = con->createStatement();
        res = stmt->executeQuery(sql_select);
        
        records = res -> rowsCount();
        res -> next();
                        
        std::cout << " validateSMARTPHONEChannel: "; 
        
        if ( records > 0 ) {
            std::cout << " VALID" << std::endl;
            success = res->getInt("zone_id");
        } else {
            std::cout << " NOT VALID" << std::endl;
        }
        
        if ( chan != -1 ) {
            updateCurrentChannel(con, chan, mac); 
        }
        
        delete res;
        delete stmt;
        return success;
    } catch (sql::SQLException &e) {
        return -1;
        std::cout << "# ERR: SQLException in " << __FILE__;
        std::cout << "# ERR: " << e.what();
        std::cout << " (MySQL error code: " << e.getErrorCode();
        std::cout << ", SQLState: " << e.getSQLState() << " )" << std::endl;
    }
    
}
    
int validateJSON (std::string JSONstr) {
    
    int channel = getAtomikJSONValue("Channel", JSONstr);
    std::string mac = getAtomikJSONMAC(JSONstr);
    int valid = validateRFChannel(con, mac, channel );
    
    return valid;
}


// this is new arp + mac
static char *ethernet_mactoa(struct sockaddr *addr)
{
    static char buff[256];

    unsigned char *ptr = (unsigned char *) addr->sa_data;

    sprintf(buff, "%02X:%02X:%02X:%02X:%02X:%02X",
            (ptr[0] & 0xff), (ptr[1] & 0xff), (ptr[2] & 0xff),
            (ptr[3] & 0xff), (ptr[4] & 0xff), (ptr[5] & 0xff));

    return (buff);
}

void sendJSON(std::string jsonstr)
{
  
  CURLcode ret;
  CURL *hnd;
  struct curl_slist *slist1;

  slist1 = NULL;
  slist1 = curl_slist_append(slist1, "Content-Type: application/json");

  hnd = curl_easy_init();
  curl_easy_setopt(hnd, CURLOPT_URL, "http://localhost:4200/emulator");
  curl_easy_setopt(hnd, CURLOPT_NOPROGRESS, 1L);
  curl_easy_setopt(hnd, CURLOPT_POSTFIELDS, jsonstr.c_str());
  curl_easy_setopt(hnd, CURLOPT_USERAGENT, "Atomik Controller");
  curl_easy_setopt(hnd, CURLOPT_HTTPHEADER, slist1);
  curl_easy_setopt(hnd, CURLOPT_MAXREDIRS, 50L);
  curl_easy_setopt(hnd, CURLOPT_CUSTOMREQUEST, "POST");
  curl_easy_setopt(hnd, CURLOPT_TCP_KEEPALIVE, 1L);

  ret = curl_easy_perform(hnd);

  curl_easy_cleanup(hnd);
  hnd = NULL;
  curl_slist_free_all(slist1);
  slist1 = NULL;
return;
}

void JSONfilewrite (std::string textjson) 
{
  JSONfileMutex.lock();
  
  char filename[] = "/var/log/atomik/AtomikEmulatorJSON.log";
  std::ofstream json;

  json.open(filename, std::ios_base::app);
  if (!json ) 
  {
        json.open(filename,  std::ios_base::app);
        json << textjson.c_str() << std::endl;
        json.close();
  } else {
  
        json << textjson.c_str() << std::endl;
        json.close();
  }
       
  JSONfileMutex.unlock();
  return;
}


std::string getTime()
{
    timeval curTime;
    time_t now;
    time(&now);
    
    gettimeofday(&curTime, NULL);
    int milli = curTime.tv_usec / 1000;

    char buf[sizeof "2011-10-08T07:07:09"];
    strftime(buf, sizeof buf, "%FT%T", gmtime(&now));
    
    sprintf(buf, "%s.%dZ", buf, milli);
    return buf;
}

std::string createJSON(std::string mac, std::string ip, std::string data, std::string config)
{                                    
    std::string output;
    output = "{\"Command\":\"Issue\",\"DateTime\":\"" + getTime() + "\",";
    output = output + "\"MAC\":\"" + mac + "\",";
    output = output + "\"IP\":\"" + ip + "\",";
    output = output + "\"Data\":\"" + data + "\",";
    output = output + "\"Configuration\":{" + config + "}}";
    return output;
}
   
void listen()
{
    fd_set socks;
    int discover_fd, data_fd;
    struct sockaddr_in discover_addr, data_addr, cliaddr;
    char mesg[42];
    char reply[30];

    discover_fd = socket(AF_INET, SOCK_DGRAM, 0);
    bzero(&discover_addr, sizeof(discover_addr));
    discover_addr.sin_family = AF_INET;
    discover_addr.sin_addr.s_addr = htonl(INADDR_ANY);
    discover_addr.sin_port = htons(48899);
    bind(discover_fd, (struct sockaddr *)&discover_addr, sizeof(discover_addr));

    data_fd = socket(AF_INET, SOCK_DGRAM, 0);
    bzero(&data_addr, sizeof(data_addr));
    data_addr.sin_family = AF_INET;
    data_addr.sin_addr.s_addr = htonl(INADDR_ANY);
    data_addr.sin_port = htons(8899);
    bind(data_fd, (struct sockaddr *)&data_addr, sizeof(data_addr));

    if (1)
    {
        FILE *fd;
        size_t s1, s2;
        fd = popen("ifconfig | grep \"inet addr\" | cut -d ':' -f 2 | cut -d ' ' -f 1 | grep -v \"127.0.0.1\" | head -n 1 | tr -d [:space:]", "r");
        s1 = fread(reply, 1, 15, fd);
        reply[s1] = ',';
        s1++;
        // fd = popen("ifconfig | awk '/HWaddr/&&/wlan0/' | cut -d ' ' -f 10 | tr -d [:space:] | tr -d ':' | tr [:lower:] [:upper:]", "r");
        fd = popen("ifconfig | grep \"HWaddr\" | cut -d ' ' -f 11 | tr -d [:space:] | tr -d ':' | tr [:lower:] [:upper:]", "r");
        s2 = fread(reply + s1, 1, 12 ,fd);
        reply[s1 + s2] = ',';
    }

    if (debug)
    {
        printf("Reply String: %s\n", reply);
        fflush(stdout);
    }

    while (1)
    {
        socklen_t len = sizeof(cliaddr);

        FD_ZERO(&socks);
        FD_SET(discover_fd, &socks);
        FD_SET(data_fd, &socks);
        if (select(FD_SETSIZE, &socks, NULL, NULL, NULL) >= 0)
        {
            if (FD_ISSET(discover_fd, &socks))
            {                       

		int n = recvfrom(discover_fd, mesg, 41, 0, (struct sockaddr *)&cliaddr, &len);
                mesg[n] = '\0';

                if (debug)
                {
                    char stri[INET_ADDRSTRLEN];
                    long ipv4 = cliaddr.sin_addr.s_addr;
                    inet_ntop(AF_INET, &ipv4, stri, INET_ADDRSTRLEN);
                    printf("UDP --> Received discovery request (%s) from %s\n", mesg, stri);
                }

                if (!strncmp(mesg, "Link_Wi-Fi", 41))
                {
                    sendto(discover_fd, reply, strlen(reply), 0, (struct sockaddr*)&cliaddr, len);
                }
            }
            
            if (FD_ISSET(data_fd, &socks))
            {
                int n = recvfrom(data_fd, mesg, 41, 0, (struct sockaddr *)&cliaddr, &len);
                mesg[n] = '\0';

                if (n == 2 || n == 3)
                {
                    char str[INET_ADDRSTRLEN];
                    long ip = cliaddr.sin_addr.s_addr;
                    inet_ntop(AF_INET, &ip, str, INET_ADDRSTRLEN);
                    std::string jsontext;
                                    
                    if (debug)
                    {
                        printf("Connection from %s\n", str);
                        fflush(stdout);
                    }

                    struct arpreq       areq;
                    struct sockaddr_in *sin;
                    struct in_addr      ipaddr;

                    std::string mac_address;
                    char message [50];
                                    
                    /* Make the ARP request.
                                                        */
                    memset(&areq, 0, sizeof(areq));
                    sin = (struct sockaddr_in *) &areq.arp_pa;
                    sin->sin_family = AF_INET;

                    if (inet_aton(str, &ipaddr) == 0)
                    {
                        fprintf(stderr, "-- Error: bad dotted-decimal IP '%s'.\n", str);
                    }

                    sin->sin_addr = ipaddr;
                    sin = (struct sockaddr_in *) &areq.arp_ha;
                    sin->sin_family = ARPHRD_ETHER;

                    strncpy(areq.arp_dev, "eth0", 15);

                    if (ioctl(data_fd, SIOCGARP, (caddr_t) &areq) == -1)
                    {
                        perror("-- Error: unable to make ARP request, error");
                    }
                    
                    if (debug)
                    {
                        printf("%s (%s) -> %s\n", str,
                                    inet_ntoa(((struct sockaddr_in *) &areq.arp_pa)->sin_addr), ethernet_mactoa(&areq.arp_ha));
                        printf("UDP --> Received hex value (%02x, %02x, %02x)\n", mesg[0], mesg[1], mesg[2]);
                        fflush(stdout);
                    }
                                        
                    mac_address = ethernet_mactoa(&areq.arp_ha);
                                  
                    sprintf (message, "%02x %02x %02x", mesg[0], mesg[1], mesg[2]);
                    jsontext = createJSON(mac_address.c_str(), str, message,  MiLightCypher.getSmartPhoneAtomikJSON(mesg[0], mesg[1], mesg[2]));
                    std::cout << getAtomikJSONMAC(jsontext).c_str() << std::endl;
                    JSONfilewrite(jsontext);
                    // sendJSON(jsontext);
                    int zone = validateJSON(jsontext);
                    printf(jsontext.c_str());
                    printf("\n");
                    
                    fflush(stdout);
                    
                } else {
                   
                    printf("failed! Message Error!");
                    fprintf(stderr, "Message has invalid size %d (expecting 2 or 3)!\n", n);
                    
                } /* End message size check */

            } /* End handling data */

        } /* End select */

    } /* While (1) */

}

void usage(const char *arg, const char *options)
{
    printf("\n");
    printf("Usage: %s [%s]\n", arg, options);
    printf("\n");
    printf("   -h                       Show this help\n");
    printf("   -d                       Show debug output\n");
    printf("\n");
}

int main(int argc, char** argv)
{
   
    const char *options = "hd";
    int c;

    while ((c = getopt(argc, argv, options)) != -1)
    {
        switch (c)
        {
            case 'h':
                usage(argv[0], options);
                exit(0);
                break;
            case 'd':
                debug = 1;
                break;
            default:
                fprintf(stderr, "Error parsing options");
                return -1;
        }
    }
    
    printf("Atomik MiLight Emulator - Version %.02f\n", ver);
    printf("Listening for Mi-Light Smart Phone Commands: ( press ctrl-c to end )\n");
    listen();

    return 0;
}
