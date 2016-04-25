
#include <sstream>

#include "atomikCypher.h"
 
atomikCypher :: atomikCypher() 
{
    init();
}
 
void atomikCypher :: init() 
{
    //    Mi-Light RGB+W Bulbs
    
    //  Radio Cypher for the 4 int tuple
    // MiLightRadiotoJSONCypher[std::make_tuple(64, 0, 0, 0)] = "TestRadioCypher";   
    // MiLightRadiotoJSONCypher[std::make_tuple(64, 0, 0, 0)] = "TestRadioCypher";   
    // MiLightRadiotoJSONCypher[std::make_tuple(64, 0, 0, 0)] = "TestRadioCypher";   
    // MiLightRadiotoJSONCypher[std::make_tuple(64, 0, 0, 0)] = "TestRadioCypher";   

   // MiLightRadiotoJSONCypher[std::make_tuple(64, 0, 0)]




    // Smart Phone Cypher
    // Status : On / Off
    // Channel : 0 - * (0 == all channels) (Mi-Light Remotes have 5 Channels main and 4 zones )
    // Color : 0 - 255
    // Brightness : 1 - 100, Lowest, Highest, Nightlight
    // ColorMode: RGB / White    
    
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 0, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"0\"";                                      // HEX Values 40, 00, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 1, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"1\"";                                      // HEX Values 40, 01, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 2, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"2\"";                                      // HEX Values 40, 02, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 3, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"3\"";                                      // HEX Values 40, 03, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 4, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"4\"";                                      // HEX Values 40, 04, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 5, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"5\"";                                      // HEX Values 40, 05, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 6, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"6\"";                                      // HEX Values 40, 06, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 7, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"7\"";                                      // HEX Values 40, 07, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 8, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"8\"";                                      // HEX Values 40, 08, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 9, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"9\"";                                      // HEX Values 40, 09, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 10, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"10\"";                                    // HEX Values 40, 0a, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 11, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"11\"";                                    // HEX Values 40, 0b, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 12, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"12\"";                                    // HEX Values 40, 0c, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 13, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"13\"";                                    // HEX Values 40, 0d, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 14, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"14\"";                                    // HEX Values 40, 0e, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 15, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"15\"";                                    // HEX Values 40, 0f, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 16, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"16\"";                                    // HEX Values 40, 00, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 17, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"17\"";                                    // HEX Values 40, 11, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 18, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"18\"";                                    // HEX Values 40, 12, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 19, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"19\"";                                    // HEX Values 40, 13, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 20, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"20\"";                                    // HEX Values 40, 14, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 21, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"21\"";                                    // HEX Values 40, 15, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 22, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"22\"";                                    // HEX Values 40, 16, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 23, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"23\"";                                    // HEX Values 40, 17, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 24, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"24\"";                                    // HEX Values 40, 18, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 25, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"25\"";                                    // HEX Values 40, 19, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 26, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"26\"";                                    // HEX Values 40, 1a, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 27, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"27\"";                                    // HEX Values 40, 1b, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 28, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"28\"";                                    // HEX Values 40, 1c, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 29, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"29\"";                                    // HEX Values 40, 1d, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 30, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"30\"";                                    // HEX Values 40, 1e, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 31, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"31\"";                                    // HEX Values 40, 1f, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 32, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"32\"";                                    // HEX Values 40, 20, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 33, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"33\"";                                    // HEX Values 40, 21, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 34, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"34\"";                                    // HEX Values 40, 22, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 35, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"35\"";                                    // HEX Values 40, 23, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 36, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"36\"";                                    // HEX Values 40, 24, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 37, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"37\"";                                    // HEX Values 40, 25, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 38, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"38\"";                                    // HEX Values 40, 26, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 39, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"39\"";                                    // HEX Values 40, 27, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 40, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"40\"";                                    // HEX Values 40, 28, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 41, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"41\"";                                    // HEX Values 40, 29, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 42, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"42\"";                                    // HEX Values 40, 2a, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 43, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"43\"";                                    // HEX Values 40, 2b, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 44, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"44\"";                                    // HEX Values 40, 2c, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 45, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"45\"";                                    // HEX Values 40, 2d, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 46, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"46\"";                                    // HEX Values 40, 2e, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 47, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"47\"";                                    // HEX Values 40, 2f, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 48, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"48\"";                                    // HEX Values 40, 30, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 49, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"49\"";                                    // HEX Values 40, 31, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 50, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"50\"";                                    // HEX Values 40, 32, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 51, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"51\"";                                    // HEX Values 40, 33, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 52, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"52\"";                                    // HEX Values 40, 34, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 53, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"53\"";                                    // HEX Values 40, 35, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 54, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"54\"";                                    // HEX Values 40, 36, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 55, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"55\"";                                    // HEX Values 40, 37, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 56, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"56\"";                                    // HEX Values 40, 38, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 57, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"57\"";                                    // HEX Values 40, 39, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 58, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"58\"";                                    // HEX Values 40, 3a, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 59, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"59\"";                                    // HEX Values 40, 3b, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 60, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"60\"";                                    // HEX Values 40, 3c, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 61, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"61\"";                                    // HEX Values 40, 3d, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 62, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"62\"";                                    // HEX Values 40, 3e, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 63, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"63\"";                                    // HEX Values 40, 3f, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 64, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"64\"";                                    // HEX Values 40, 40, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 65, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"65\"";                                    // HEX Values 40, 41, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 66, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"66\"";                                    // HEX Values 40, 42, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 67, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"67\"";                                    // HEX Values 40, 43, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 68, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"68\"";                                    // HEX Values 40, 44, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 69, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"69\"";                                    // HEX Values 40, 45, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 70, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"70\"";                                    // HEX Values 40, 46, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 71, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"71\"";                                    // HEX Values 40, 47, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 72, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"72\"";                                    // HEX Values 40, 48, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 73, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"73\"";                                    // HEX Values 40, 49, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 74, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"74\"";                                    // HEX Values 40, 4a, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 75, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"75\"";                                    // HEX Values 40, 4b, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 76, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"76\"";                                    // HEX Values 40, 4c, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 77, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"77\"";                                    // HEX Values 40, 4d, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 78, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"78\"";                                    // HEX Values 40, 4e, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 79, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"79\"";                                    // HEX Values 40, 4f, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 80, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"80\"";                                    // HEX Values 40, 50, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 81, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"81\"";                                    // HEX Values 40, 51, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 82, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"82\"";                                    // HEX Values 40, 52, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 83, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"83\"";                                    // HEX Values 40, 53, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 84, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"84\"";                                    // HEX Values 40, 54, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 85, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"85\"";                                    // HEX Values 40, 55, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 86, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"86\"";                                    // HEX Values 40, 56, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 87, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"87\"";                                    // HEX Values 40, 57, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 88, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"88\"";                                    // HEX Values 40, 58, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 89, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"89\"";                                    // HEX Values 40, 59, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 90, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"90\"";                                    // HEX Values 40, 5a, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 91, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"91\"";                                    // HEX Values 40, 5b, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 92, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"92\"";                                    // HEX Values 40, 5c, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 93, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"93\"";                                    // HEX Values 40, 5d, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 94, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"94\"";                                    // HEX Values 40, 5e, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 95, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"95\"";                                    // HEX Values 40, 5f, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 96, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"96\"";                                    // HEX Values 40, 60, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 97, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"97\"";                                    // HEX Values 40, 61, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 98, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"98\"";                                    // HEX Values 40, 62, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 99, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"99\"";                                    // HEX Values 40, 63, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 100, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"100\"";                                    // HEX Values 40, 64, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 101, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"101\"";                                    // HEX Values 40, 65, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 102, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"102\"";                                    // HEX Values 40, 66, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 103, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"103\"";                                    // HEX Values 40, 67, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 104, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"104\"";                                    // HEX Values 40, 68, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 105, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"105\"";                                    // HEX Values 40, 69, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 106, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"106\"";                                    // HEX Values 40, 6a, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 107, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"107\"";                                    // HEX Values 40, 6b, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 108, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"108\"";                                    // HEX Values 40, 6c, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 109, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"109\"";                                    // HEX Values 40, 6d, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 110, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"110\"";                                    // HEX Values 40, 6e, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 111, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"111\"";                                    // HEX Values 40, 6f, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 112, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"112\"";                                    // HEX Values 40, 70, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 113, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"113\"";                                    // HEX Values 40, 71, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 114, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"114\"";                                    // HEX Values 40, 72, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 115, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"115\"";                                    // HEX Values 40, 73, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 116, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"116\"";                                    // HEX Values 40, 74, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 117, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"117\"";                                    // HEX Values 40, 75, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 118, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"118\"";                                    // HEX Values 40, 76, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 119, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"119\"";                                    // HEX Values 40, 77, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 120, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"120\"";                                    // HEX Values 40, 78, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 121, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"121\"";                                    // HEX Values 40, 79, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 122, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"122\"";                                    // HEX Values 40, 7a, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 123, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"123\"";                                    // HEX Values 40, 7b, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 124, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"124\"";                                    // HEX Values 40, 7c, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 125, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"125\"";                                    // HEX Values 40, 7d, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 126, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"126\"";                                    // HEX Values 40, 7e, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 127, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"127\"";                                    // HEX Values 40, 7f, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 128, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"128\"";                                    // HEX Values 40, 80, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 129, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"129\"";                                    // HEX Values 40, 81, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 130, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"130\"";                                    // HEX Values 40, 82, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 131, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"131\"";                                    // HEX Values 40, 83, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 132, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"132\"";                                    // HEX Values 40, 84, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 133, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"133\"";                                    // HEX Values 40, 85, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 134, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"134\"";                                    // HEX Values 40, 86, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 135, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"135\"";                                    // HEX Values 40, 87, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 136, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"136\"";                                    // HEX Values 40, 88, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 137, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"137\"";                                    // HEX Values 40, 89, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 138, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"138\"";                                    // HEX Values 40, 8a, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 139, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"139\"";                                    // HEX Values 40, 8b, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 140, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"140\"";                                    // HEX Values 40, 8c, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 141, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"141\"";                                    // HEX Values 40, 8d, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 142, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"142\"";                                    // HEX Values 40, 8e, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 143, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"143\"";                                    // HEX Values 40, 8f, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 144, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"144\"";                                    // HEX Values 40, 90, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 145, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"145\"";                                    // HEX Values 40, 91, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 146, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"146\"";                                    // HEX Values 40, 92, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 147, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"147\"";                                    // HEX Values 40, 93, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 148, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"148\"";                                    // HEX Values 40, 94, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 149, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"149\"";                                    // HEX Values 40, 95, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 150, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"150\"";                                    // HEX Values 40, 96, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 151, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"151\"";                                    // HEX Values 40, 97, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 152, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"152\"";                                    // HEX Values 40, 98, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 153, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"153\"";                                    // HEX Values 40, 99, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 154, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"154\"";                                    // HEX Values 40, 9a, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 155, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"155\"";                                    // HEX Values 40, 9b, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 156, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"156\"";                                    // HEX Values 40, 9c, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 157, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"157\"";                                    // HEX Values 40, 9d, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 158, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"158\"";                                    // HEX Values 40, 9e, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 159, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"159\"";                                    // HEX Values 40, 9f, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 160, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"160\"";                                    // HEX Values 40, a0, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 161, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"161\"";                                    // HEX Values 40, a1, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 162, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"162\"";                                    // HEX Values 40, a2, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 163, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"163\"";                                    // HEX Values 40, a3, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 164, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"164\"";                                    // HEX Values 40, a4, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 165, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"165\"";                                    // HEX Values 40, a5, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 166, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"166\"";                                    // HEX Values 40, a6, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 167, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"167\"";                                    // HEX Values 40, a7, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 168, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"168\"";                                    // HEX Values 40, a8, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 169, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"169\"";                                    // HEX Values 40, a9, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 170, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"170\"";                                    // HEX Values 40, aa, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 171, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"171\"";                                    // HEX Values 40, ab, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 172, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"172\"";                                    // HEX Values 40, ac, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 173, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"173\"";                                    // HEX Values 40, ad, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 174, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"174\"";                                    // HEX Values 40, ae, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 175, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"175\"";                                    // HEX Values 40, af, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 176, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"176\"";                                    // HEX Values 40, b0, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 177, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"177\"";                                    // HEX Values 40, b1, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 178, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"178\"";                                    // HEX Values 40, b2, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 179, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"179\"";                                    // HEX Values 40, b3, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 180, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"180\"";                                    // HEX Values 40, b4, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 181, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"181\"";                                    // HEX Values 40, b5, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 182, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"182\"";                                    // HEX Values 40, b6, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 183, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"183\"";                                    // HEX Values 40, b7, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 184, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"184\"";                                    // HEX Values 40, b8, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 185, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"185\"";                                    // HEX Values 40, b9, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 186, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"186\"";                                    // HEX Values 40, ba, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 187, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"187\"";                                    // HEX Values 40, bb, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 188, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"188\"";                                    // HEX Values 40, bc, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 189, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"189\"";                                    // HEX Values 40, bd, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 190, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"190\"";                                    // HEX Values 40, be, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 191, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"191\"";                                    // HEX Values 40, bf, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 192, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"192\"";                                    // HEX Values 40, c0, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 193, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"193\"";                                    // HEX Values 40, c1, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 194, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"194\"";                                    // HEX Values 40, c2, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 195, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"195\"";                                    // HEX Values 40, c3, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 196, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"196\"";                                    // HEX Values 40, c4, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 197, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"197\"";                                    // HEX Values 40, c5, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 198, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"198\"";                                    // HEX Values 40, c6, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 199, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"199\"";                                    // HEX Values 40, c7, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 200, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"200\"";                                    // HEX Values 40, c8, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 201, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"201\"";                                    // HEX Values 40, c9, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 202, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"202\"";                                    // HEX Values 40, ca, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 203, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"203\"";                                    // HEX Values 40, cb, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 204, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"204\"";                                    // HEX Values 40, cc, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 205, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"205\"";                                    // HEX Values 40, cd, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 206, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"206\"";                                    // HEX Values 40, ce, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 207, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"207\"";                                    // HEX Values 40, cf, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 208, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"208\"";                                    // HEX Values 40, d0, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 209, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"209\"";                                    // HEX Values 40, d1, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 210, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"210\"";                                    // HEX Values 40, d2, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 211, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"211\"";                                    // HEX Values 40, d3, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 212, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"212\"";                                    // HEX Values 40, d4, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 213, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"213\"";                                    // HEX Values 40, d5, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 214, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"214\"";                                    // HEX Values 40, d6, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 215, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"215\"";                                    // HEX Values 40, d7, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 216, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"216\"";                                    // HEX Values 40, d8, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 217, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"217\"";                                    // HEX Values 40, d9, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 218, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"218\"";                                    // HEX Values 40, da, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 219, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"219\"";                                    // HEX Values 40, db, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 220, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"220\"";                                    // HEX Values 40, dc, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 221, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"221\"";                                    // HEX Values 40, dd, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 222, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"222\"";                                    // HEX Values 40, de, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 223, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"223\"";                                    // HEX Values 40, df, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 224, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"224\"";                                    // HEX Values 40, e0, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 225, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"225\"";                                    // HEX Values 40, e1, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 226, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"226\"";                                    // HEX Values 40, e2, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 227, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"227\"";                                    // HEX Values 40, e3, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 228, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"228\"";                                    // HEX Values 40, e4, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 229, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"229\"";                                    // HEX Values 40, e5, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 230, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"230\"";                                    // HEX Values 40, e6, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 231, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"231\"";                                    // HEX Values 40, e7, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 232, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"232\"";                                    // HEX Values 40, e8, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 233, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"233\"";                                    // HEX Values 40, e9, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 234, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"234\"";                                    // HEX Values 40, ea, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 235, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"235\"";                                    // HEX Values 40, eb, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 236, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"236\"";                                    // HEX Values 40, ec, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 237, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"237\"";                                    // HEX Values 40, ed, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 238, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"238\"";                                    // HEX Values 40, ee, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 239, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"239\"";                                    // HEX Values 40, ef, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 240, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"240\"";                                    // HEX Values 40, f0, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 241, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"241\"";                                    // HEX Values 40, f1, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 242, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"242\"";                                    // HEX Values 40, f2, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 243, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"243\"";                                    // HEX Values 40, f3, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 244, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"244\"";                                    // HEX Values 40, f4, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 245, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"245\"";                                    // HEX Values 40, f5, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 246, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"246\"";                                    // HEX Values 40, f6, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 247, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"247\"";                                    // HEX Values 40, f7, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 248, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"248\"";                                    // HEX Values 40, f8, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 249, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"249\"";                                    // HEX Values 40, f9, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 250, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"250\"";                                    // HEX Values 40, fa, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 251, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"251\"";                                    // HEX Values 40, fb, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 252, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"252\"";                                    // HEX Values 40, fc, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 253, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"253\"";                                    // HEX Values 40, fd, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 254, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"254\"";                                    // HEX Values 40, fe, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(64, 255, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"RGB256\"\n \"Color\": \"255\"";                                    // HEX Values 40, ff, 00


    MiLightSmartPhonetoJSONCypher[std::make_tuple(65, 0, 0)] = "\"Status\": \"Off\"\n \"Channel\": \"0\"";                                                                  // HEX Values 41, 00, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(66, 0, 0)] = "\"Status\": \"On\"\n \"Channel\": \"0\"";                                                                   // HEX Values 42, 00, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(194, 0, 0)] = "\"Status\": \"On\"\n \"Channel\": \"0\" \n \"ColorMode\": \"White\"\n \"Brightness\": \"Max\"";            // HEX Values c2, 00, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(193, 0, 0)] = "\"Status\": \"On\"\n \"Channel\": \"0\" \n \"ColorMode\": \"White\"\n \"Brightness\": \"Nightlight\"";     // HEX Values c1, 00, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(77, 0, 0)] = "\"temp\": \"Mode\"";                                                                                        // HEX Values 4d, 00, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(205, 0, 0)] = "\"temp\": \"Unknown (Hold Mode Button)\"";                                                                 // HEX Values cd, 00, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(67, 0, 0)] = "\"temp\": \"Decrease Speed\"";                                                                              // HEX Values 43, 00, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(68, 0, 0)] = "\"temp\": \"Increase Speed\"";                                                                              // HEX Values 44, 00, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(195, 0, 0)] = "\"temp\": \"Change Mode Down\"";                                                                           // HEX Values c3, 00, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(196, 0, 0)] = "\"temp\": \"Change Mode Up\"";                                                                             // HEX Values c4, 00, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(69, 0, 0)] = "\"Status\": \"On\"\n \"Channel\": \"1\"";                                                                   // HEX Values 45, 00, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(70, 0, 0)] = "\"Status\": \"Off\"\n \"Channel\": \"1\"";                                                                  // HEX Values 46, 00, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(197, 0, 0)] = "\"Status\": \"On\"\n \"Channel\": \"1\" \n \"ColorMode\": \"White\"\n \"Brightness\": \"Max\"";            // HEX Values c5, 00, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(198, 0, 0)] = "\"Status\": \"On\"\n \"Channel\": \"1\" \n \"ColorMode\": \"White\"\n \"Brightness\": \"Nightlight\"";     // HEX Values c6, 00, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(71, 0, 0)] = "\"Status\": \"On\"\n \"Channel\": \"2\"";                                                                   // HEX Values 47, 00, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(72, 0, 0)] = "\"Status\": \"Off\"\n \"Channel\": \"2\"";                                                                  // HEX Values 48, 00, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(199, 0, 0)] = "\"Status\": \"On\"\n \"Channel\": \"2\" \n \"ColorMode\": \"White\"\n \"Brightness\": \"Max\"";            // HEX Values c7, 00, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(200, 0, 0)] = "\"Status\": \"On\"\n \"Channel\": \"2\" \n \"ColorMode\": \"White\"\n \"Brightness\": \"Nightlight\"";     // HEX Values c8, 00, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(73, 0, 0)] = "\"Status\": \"On\"\n \"Channel\": \"3\"";                                                                   // HEX Values 49, 00, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(74, 0, 0)] = "\"Status\": \"Off\"\n \"Channel\": \"3\"";                                                                  // HEX Values 4a, 00, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(201, 0, 0)] = "\"Status\": \"On\"\n \"Channel\": \"3\" \n \"ColorMode\": \"White\"\n \"Brightness\": \"Max\"";            // HEX Values c9, 00, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(202, 0, 0)] = "\"Status\": \"On\"\n \"Channel\": \"3\" \n \"ColorMode\": \"White\"\n \"Brightness\": \"Nightlight\"";     // HEX Values ca, 00, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(75, 0, 0)] = "\"Status\": \"On\"\n \"Channel\": \"4\"";                                                                   // HEX Values 4b, 00, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(76, 0, 0)] = "\"Status\": \"Off\"\n \"Channel\": \"4\"";                                                                  // HEX Values 4c, 00, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(203, 0, 0)] = "\"Status\": \"On\"\n \"Channel\": \"4\" \n \"ColorMode\": \"White\"\n \"Brightness\": \"Max\"";            // HEX Values cb, 00, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(204, 0, 0)] = "\"Status\": \"On\"\n \"Channel\": \"4\" \n \"ColorMode\": \"White\"\n \"Brightness\": \"Nightlight\"";      // HEX Values cc, 00, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(78, 0, 0)] = "\"Status\": \"On\"\n \"Brightness\": \"3\"";                                                                // HEX Values 4e, 00, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(78, 1, 0)] = "\"Status\": \"On\"\n \"Brightness\": \"6\"";                                                                // HEX Values 4e, 01, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(78, 2, 0)] = "\"Status\": \"On\"\n \"Brightness\": \"9\"";                                                                // HEX Values 4e, 02, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(78, 3, 0)] = "\"Status\": \"On\"\n \"Brightness\": \"12\"";                                                               // HEX Values 4e, 03, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(78, 4, 0)] = "\"Status\": \"On\"\n \"Brightness\": \"15\"";                                                               // HEX Values 4e, 04, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(78, 5, 0)] = "\"Status\": \"On\"\n \"Brightness\": \"19\"";                                                               // HEX Values 4e, 05, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(78, 6, 0)] = "\"Status\": \"On\"\n \"Brightness\": \"22\"";                                                               // HEX Values 4e, 06, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(78, 7, 0)] = "\"Status\": \"On\"\n \"Brightness\": \"25\"";                                                               // HEX Values 4e, 07, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(78, 8, 0)] = "\"Status\": \"On\"\n \"Brightness\": \"28\"";                                                               // HEX Values 4e, 08, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(78, 9, 0)] = "\"Status\": \"On\"\n \"Brightness\": \"31\"";                                                               // HEX Values 4e, 09, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(78, 10, 0)] = "\"Status\": \"On\"\n \"Brightness\": \"34\"";                                                              // HEX Values 4e, 0a, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(78, 11, 0)] = "\"Status\": \"On\"\n \"Brightness\": \"37\"";                                                              // HEX Values 4e, 0b, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(78, 12, 0)] = "\"Status\": \"On\"\n \"Brightness\": \"40\"";                                                              // HEX Values 4e, 0c, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(78, 13, 0)] = "\"Status\": \"On\"\n \"Brightness\": \"44\"";                                                              // HEX Values 4e, 0d, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(78, 14, 0)] = "\"Status\": \"On\"\n \"Brightness\": \"47\"";                                                              // HEX Values 4e, 0e, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(78, 15, 0)] = "\"Status\": \"On\"\n \"Brightness\": \"50\"";                                                              // HEX Values 4e, 0f, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(78, 16, 0)] = "\"Status\": \"On\"\n \"Brightness\": \"53\"";                                                               // HEX Values 4e, 10, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(78, 17, 0)] = "\"Status\": \"On\"\n \"Brightness\": \"56\"";                                                               // HEX Values 4e, 11, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(78, 18, 0)] = "\"Status\": \"On\"\n \"Brightness\": \"59\"";                                                               // HEX Values 4e, 12, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(78, 19, 0)] = "\"Status\": \"On\"\n \"Brightness\": \"62\"";                                                               // HEX Values 4e, 13, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(78, 20, 0)] = "\"Status\": \"On\"\n \"Brightness\": \"65\"";                                                               // HEX Values 4e, 14, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(78, 21, 0)] = "\"Status\": \"On\"\n \"Brightness\": \"69\"";                                                               // HEX Values 4e, 15, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(78, 22, 0)] = "\"Status\": \"On\"\n \"Brightness\": \"72\"";                                                               // HEX Values 4e, 16, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(78, 23, 0)] = "\"Status\": \"On\"\n \"Brightness\": \"75\"";                                                               // HEX Values 4e, 17, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(78, 24, 0)] = "\"Status\": \"On\"\n \"Brightness\": \"78\"";                                                               // HEX Values 4e, 18, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(78, 25, 0)] = "\"Status\": \"On\"\n \"Brightness\": \"81\"";                                                               // HEX Values 4e, 19, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(78, 26, 0)] = "\"Status\": \"On\"\n \"Brightness\": \"84\"";                                                              // HEX Values 4e, 1a, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(78, 27, 0)] = "\"Status\": \"On\"\n \"Brightness\": \"87\"";                                                              // HEX Values 4e, 1b, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(78, 28, 0)] = "\"Status\": \"On\"\n \"Brightness\": \"90\"";                                                              // HEX Values 4e, 1c, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(78, 29, 0)] = "\"Status\": \"On\"\n \"Brightness\": \"94\"";                                                              // HEX Values 4e, 1d, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(78, 30, 0)] = "\"Status\": \"On\"\n \"Brightness\": \"97\"";                                                              // HEX Values 4e, 1e, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(78, 31, 0)] = "\"Status\": \"On\"\n \"Brightness\": \"100\"";                                                             // HEX Values 4e, 1f, 00
    MiLightSmartPhonetoJSONCypher[std::make_tuple(78, 32, 0)] = "\"Status\": \"On\"\n \"Brightness\": \"100\"";                                                             // HEX Values 4e, 20, 00
    return;    
}		
 
std::string atomikCypher :: getAtomikJSON(int x, int y, int z)
{
    std::stringstream buffer;
    auto t = MiLightSmartPhonetoJSONCypher.find(std::make_tuple(x, y, z));
    if (t == MiLightSmartPhonetoJSONCypher.end()) return std::string();
        buffer << t->second;
    return buffer.str();
}