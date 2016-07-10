#include <stdio.h>
#include <jsoncpp/json/json.h>
#include <jsoncpp/json/reader.h>
#include <jsoncpp/json/writer.h>
#include <jsoncpp/json/value.h>
#include <string>
#include <sstream>  
#include <stdlib.h>  


int hex2int(std::string hexnum) {

	int x = std::strtol(hexnum.c_str(), NULL, 16);
	return x;
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

int main( int argc, const char* argv[] )
{
    std::string strJson = "{\"Command\":\"Issue\",\"DateTime\":\"2016-07-02T22:56:37.995Z\",\"Address1\":\"81\",\"Address2\":\"1D\",\"Data\":\"B0 81 1D DC 78 01 D7\",\"Configuration\":{\"Status\":\"On\",\"Channel\":\"0\"}}"; // need escape the quotes

	std::cout << getAtomikJSONValue("Address1", strJson) << std::endl; 
	std::cout << getAtomikJSONValue("Address2", strJson) << std::endl;
	std::cout << getAtomikJSONValue("Status", strJson) << std::endl;
	std::cout << getAtomikJSONValue("Channel", strJson) << std::endl;
	std::cout << getAtomikJSONValue("ColorMode", strJson) << std::endl;
	std::cout << getAtomikJSONValue("Color", strJson) << std::endl;
	std::cout << getAtomikJSONValue("Brightness", strJson) << std::endl;


    return 0;
}
