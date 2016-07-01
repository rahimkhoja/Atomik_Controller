#include <iostream>
#include <string>
#include <stdio.h>
#include <algorithm> 
#include <sstream>
#include <fstream>
#include "mysql_connection.h"

#include <cppconn/driver.h>
#include <cppconn/exception.h>
#include <cppconn/resultset.h>
#include <cppconn/statement.h>


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


void updateDeviceProperties(sql::Connection *con, int status, int colormode, int brightness, int rgb256, int whitetemp, int transnum, int device) {

    std::string sql_update;
	
	sql_update = "UPDATE atomik_devices SET device_status="+int2int(status)+", device_colormode="+int2int(colormode)+", device_brightness="+int2int(bright)+", device_rgb256="+int2int(rgb256)+", device_white_temprature="+int2int(whitetemp)+", device_transmission="+int2int(transnum)+" WHERE device_id="+int2int(device)+";";
	
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
    sendcommandbase = "sudo /usr/bin/transceiver -t 2 -q " + int2hex(add1) + " -r " + int2hex(add2) + " -c 01";

    // White Bulb Details

	int Brightness[] = {9, 18, 27, 36, 45, 54, 63, 72, 81, 90, 100};  // 11 Elements
    int WhiteTemp[] = {2700, 3080, 3460, 3840, 4220, 4600, 4980, 5360, 5740, 6120, 6500}; // 11 Elements 
	
    if (new_s != old_s) {
      // Status Changed

      trans = IncrementTransmissionNum(trans);

      if (new_s == 1) {
        sendcom = sendcommandbase + " -k " + int2hex((255 - trans)) + " -v " + int2hex(trans) + " -b 08" + " > /dev/null &";
		old_b = 9;
      } else {
        sendcom = sendcommandbase + " -k " + int2hex((255 - trans)) + " -v " + int2hex(trans) + " -b 0B" + " > /dev/null &";
      }

      printf(sendcom.c_str());
    } // End Status Change
    
	if (new_s == 1) {
      // Status On

      if (old_cm != new_cm) {
        trans = IncrementTransmissionNum(trans);
	  
        // Color Mode Change
		old_b = 9;
        if (new_cm == 1) {
          sendcom = sendcommandbase + " -k " + int2hex((255 - trans)) + " -v " + int2hex(trans) + " -b 18" + " > /dev/null &";
		  
        } else {
          sendcom = sendcommandbase + " -k " + int2hex((255 - trans)) + " -v " + int2hex(trans) + " -b 08" + " > /dev/null &";
        }

        printf(sendcom.c_str());
	  }

	if (new_b != old_b) {
		// Brightness Change
		new_b = whiteBright( new_b );
		int old_pos = std::distance(Brightness, std::find(Brightness, Brightness + 11, old_b));    //   array_search(old_b, Brightness);
		int new_pos = std::distance(Brightness, std::find(Brightness, Brightness + 11, new_b));    //   array_search(new_b, Brightness);
		
		if (new_pos > old_pos) {
			if (new_pos == std::distance(Brightness, std::find(Brightness, Brightness + 11, 100)) ) {
				trans = IncrementTransmissionNum(trans);
				sendcom = sendcommandbase + " -k " + int2hex((255 - trans)) + " -v " + int2hex(trans) + " -b 18" + " > /dev/null &";
				printf(sendcom.c_str());
            } else {
				move = new_pos - old_pos;
				for (int x = 0; x <= move; x++) {
					trans = IncrementTransmissionNum(trans);
					sendcom = sendcommandbase + " -k " + int2hex((255 - trans)) + " -v " + int2hex(trans) + " -b 0C" + " > /dev/null &";
					printf(sendcom.c_str());
				}
			}
		} else {
			move = old_pos - new_pos;
			for (int x = 0; x <= move; x++) {
				trans = IncrementTransmissionNum(trans);
				sendcom = sendcommandbase + " -k " + int2hex((255 - trans)) + " -v " + int2hex(trans) + " -b 04" + " > /dev/null &";
				printf(sendcom.c_str());
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
				sendcom = sendcommandbase + " -k " + int2hex((255 - trans)) + " -v " + int2hex(trans) + " -b 0f" + " > /dev/null &";
				printf(sendcom.c_str());
			}
		} else {
			move = old_pos - new_pos;
            for (int x = 0; x <= move; x++) {
              trans = IncrementTransmissionNum(trans);
              sendcom = sendcommandbase + " -k " + int2hex((255 - trans)) + " -v " + int2hex(trans) + " -b 0e" + " > /dev/null &";
              printf(sendcom.c_str());
            }
          }
        }
      }
	  
  } else if (cw == 1 && rgb == 1 || ww == 1 && rgb == 1) {
      sendcommandbase = "sudo /usr/bin/transceiver -t 1 -q " + int2hex(add1) + " -r " + int2hex(add2);
      // RGBWW and RGBCW

      if (new_s != old_s) {

        // Status Changed

        trans = IncrementTransmissionNum(trans);

        if (new_s == 1) {
          sendcom = sendcommandbase + " -k 03 -v " + int2hex(trans) + " > /dev/null &";
		  old_cm = -1;
		  old_b = 0;
		  
        }        else {
          sendcom = sendcommandbase + " -k 04 -v " + int2hex(trans) + " > /dev/null &";
        }
        printf(sendcom.c_str());
      }
      // End Status Change

      if (new_s == 1) {

        // Status On

        if (old_cm != new_cm) {

          // Color Mode Change

          trans = IncrementTransmissionNum(trans);

          if (new_cm == 1) {
            sendcom = sendcommandbase + " -k 13 -v " + int2hex(trans) + " -c " + int2hex(old_c) + " > /dev/null &";
			
          }          else {
            sendcom = sendcommandbase + " -k 03 -v " + int2hex(trans) + " -c " + int2hex(old_c) + " > /dev/null &";
			old_b = 0;
          }
          printf(sendcom.c_str());
        }

        // End Color Mode Change > /dev/null &

        if (new_cm == 0) {
          // Color Mode Color

          if (new_c != old_c ) {
            // Color Change
            trans = IncrementTransmissionNum(trans);

            initcom = sendcommandbase + " -c " + int2hex(new_c) + " -k 03 -v " + int2hex(trans) + " > /dev/null &";
            printf(initcom.c_str());
            trans = IncrementTransmissionNum(trans);

            sendcom = sendcommandbase + " -c " + int2hex(new_c) + " -k 0f -v " + int2hex(trans) + " > /dev/null &";
            printf(sendcom.c_str());
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
          sendcom = sendcom +  + " > /dev/null &";
          printf(sendcom.c_str());
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
            }
            
            int trans_id = transmit(new_b, old_brightness, new_s, old_status, new_c, old_color, new_wt, old_whitetemp, new_cm, old_colormode, address1, address2, old_trans_id, type_rgb, type_cw, type_ww);
            updateDeviceProperties(con, new_s, new_cm, new_b, new_c, new_wt, trans_id, dev_id);
        }
        
        updateZoneProperties(con, zone, new_b, new_s, new_c, new_wt, new_cm, timezone);
        updateZoneDevicesProperties(con, zone, timezone);
        
        std::cout << " updateZone: ( Zone: " << zone << " ) " << std::endl;
    
        delete stmt;

    } catch (sql::SQLException &e) {
        success = false;
        std::cout << "# ERR: SQLException in " << __FILE__;
        std::cout << "# ERR: " << e.what();
        std::cout << " (MySQL error code: " << e.getErrorCode();
        std::cout << ", SQLState: " << e.getSQLState() << " )" << std::endl;
    }
}

int main(int argc, char** argv)
{
        
    try {
        
        sql::Statement *stmt;
        int recordsUpdated;

        /* Create a connection */
        driver = get_driver_instance();
        con = driver->connect("tcp://127.0.0.1:3306", "root", "raspberry");
        /* Connect to the MySQL test database */
        con->setSchema("atomik_controller");    
    
     } catch (sql::SQLException &e) {
        std::cout << "# ERR: SQLException in " << __FILE__;
        std::cout << "# ERR: " << e.what();
        std::cout << " (MySQL error code: " << e.getErrorCode();
        std::cout << ", SQLState: " << e.getSQLState() << " )" << std::endl;
    }
    
    if (argc != 7 ) {
        std::cout <<  "Command Requires 6 Integer arguments\n" << std::endl;
        std::cout <<  argv[0] << " Zone_id Zone_Status Zone_Brightness Zone_ColorMode Zone_Color Zone_WhiteTemp\n" << std::endl;
        exit;
    } else {
        int zone = atoi(argv[1]);
        int b_new = atoi(argv[3]);
        int c_new = atoi(argv[5]);
        int s_new = atoi(argv[2]);
        int wt_new = atoi(argv[6]);
        int cm_new = atoi(argv[4]);
         
	    std::string outputTXT = "Updating Zone "+int2int(zone)+" To: Status: "+int2int(s_new)+" - Brightness: "+int2int(b_new)+"% - Color Mode: "+int2int(cm_new)+" - Color: "+int2int(c_new)+" - White Temp: "+int2int(wt_new);      
        std::cout << outputTXT << std::endl;
        if (updateZone(con, zone, colorBright(b_new), s_new, c_new, wt_new, cm_new, getLocalTimezone())) {
            std::cout << "Zone Updated" << std::endl;
        };
    }
    
    delete con;
    return 0;
}