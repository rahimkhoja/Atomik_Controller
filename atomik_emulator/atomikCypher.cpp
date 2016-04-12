#include <iostream>
#include <unordered_map>
#include <tuple>
#include <sstream>
#include <string>

namespace Atomik    {
    typedef std::tuple<int, int, int> key_t;
    struct key_hash : public std::unary_function<key_t, std::size_t>
        {
            std::size_t operator()(const key_t& k) const
                {
                    return std::get<0>(k) ^ std::get<1>(k) ^ std::get<2>(k);
                }
        };

    struct key_equal : public std::binary_function<key_t, key_t, bool>
        {
            bool operator()(const key_t& v0, const key_t& v1) const
                {
                    return (
                               std::get<0>(v0) == std::get<0>(v1) &&
                               std::get<1>(v0) == std::get<1>(v1) &&
                               std::get<2>(v0) == std::get<2>(v1) );
                }
        };

    typedef std::unordered_map<const key_t,std::string,key_hash,key_equal> map_t;

};

#include "atomikCypher.h"
 
atomikCypher :: atomikCypher() 
{
    init();
}
 
void atomikCypher :: init() 
{
    //    Mi-Light RGB+W Bulbs

    MiLightCypher[std::make_tuple(64, 0, 0)] = "Color: 0";                                                   // HEX Values 40, 00, 00
    MiLightCypher[std::make_tuple(64, 1, 0)] = "Color: 1";                                                   // HEX Values 40, 01, 00
    MiLightCypher[std::make_tuple(64, 2, 0)] = "Color: 2";                                                   // HEX Values 40, 02, 00
    MiLightCypher[std::make_tuple(64, 3, 0)] = "Color: 3";                                                   // HEX Values 40, 03, 00
    MiLightCypher[std::make_tuple(64, 4, 0)] = "Color: 4";                                                   // HEX Values 40, 04, 00
    MiLightCypher[std::make_tuple(64, 5, 0)] = "Color: 5";                                                   // HEX Values 40, 05, 00
    MiLightCypher[std::make_tuple(64, 6, 0)] = "Color: 6";                                                   // HEX Values 40, 06, 00
    MiLightCypher[std::make_tuple(64, 7, 0)] = "Color";                                                   // HEX Values 40, 07, 00
    MiLightCypher[std::make_tuple(64, 8, 0)] = "Color";                                                   // HEX Values 40, 08, 00
    MiLightCypher[std::make_tuple(64, 9, 0)] = "Color";                                                   // HEX Values 40, 09, 00
    MiLightCypher[std::make_tuple(64, 10, 0)] = "Color";                                                  // HEX Values 40, 0a, 00
    MiLightCypher[std::make_tuple(64, 11, 0)] = "Color";                                                  // HEX Values 40, 0b, 00
    MiLightCypher[std::make_tuple(64, 12, 0)] = "Color";                                                  // HEX Values 40, 0c, 00
    MiLightCypher[std::make_tuple(64, 13, 0)] = "Color";                                                  // HEX Values 40, 0d, 00
    MiLightCypher[std::make_tuple(64, 14, 0)] = "Color";                                                  // HEX Values 40, 0e, 00
    MiLightCypher[std::make_tuple(64, 15, 0)] = "Color";                                                  // HEX Values 40, 0f, 00
    MiLightCypher[std::make_tuple(64, 16, 0)] = "Color";                                                  // HEX Values 40, 00, 00
    MiLightCypher[std::make_tuple(64, 17, 0)] = "Color";                                                  // HEX Values 40, 11, 00
    MiLightCypher[std::make_tuple(64, 18, 0)] = "Color";                                                  // HEX Values 40, 12, 00
    MiLightCypher[std::make_tuple(64, 19, 0)] = "Color";                                                  // HEX Values 40, 13, 00
    MiLightCypher[std::make_tuple(64, 20, 0)] = "Color";                                                  // HEX Values 40, 14, 00
    MiLightCypher[std::make_tuple(64, 21, 0)] = "Color";                                                  // HEX Values 40, 15, 00
    MiLightCypher[std::make_tuple(64, 22, 0)] = "Color";                                                  // HEX Values 40, 16, 00
    MiLightCypher[std::make_tuple(64, 23, 0)] = "Color";                                                  // HEX Values 40, 17, 00
    MiLightCypher[std::make_tuple(64, 24, 0)] = "Color";                                                  // HEX Values 40, 18, 00
    MiLightCypher[std::make_tuple(64, 25, 0)] = "Color";                                                  // HEX Values 40, 19, 00
    MiLightCypher[std::make_tuple(64, 26, 0)] = "Color";                                                  // HEX Values 40, 1a, 00
    MiLightCypher[std::make_tuple(64, 27, 0)] = "Color";                                                  // HEX Values 40, 1b, 00
    MiLightCypher[std::make_tuple(64, 28, 0)] = "Color";                                                  // HEX Values 40, 1c, 00
    MiLightCypher[std::make_tuple(64, 29, 0)] = "Color";                                                  // HEX Values 40, 1d, 00
    MiLightCypher[std::make_tuple(64, 30, 0)] = "Color";                                                  // HEX Values 40, 1e, 00
    MiLightCypher[std::make_tuple(64, 31, 0)] = "Color";                                                  // HEX Values 40, 1f, 00
    MiLightCypher[std::make_tuple(64, 32, 0)] = "Color";                                                  // HEX Values 40, 20, 00
    MiLightCypher[std::make_tuple(64, 33, 0)] = "Color";                                                  // HEX Values 40, 21, 00
    MiLightCypher[std::make_tuple(64, 34, 0)] = "Color";                                                  // HEX Values 40, 22, 00
    MiLightCypher[std::make_tuple(64, 35, 0)] = "Color";                                                  // HEX Values 40, 23, 00
    MiLightCypher[std::make_tuple(64, 36, 0)] = "Color";                                                  // HEX Values 40, 24, 00
    MiLightCypher[std::make_tuple(64, 37, 0)] = "Color";                                                  // HEX Values 40, 25, 00
    MiLightCypher[std::make_tuple(64, 38, 0)] = "Color";                                                  // HEX Values 40, 26, 00
    MiLightCypher[std::make_tuple(64, 39, 0)] = "Color";                                                  // HEX Values 40, 27, 00
    MiLightCypher[std::make_tuple(64, 40, 0)] = "Color";                                                  // HEX Values 40, 28, 00
    MiLightCypher[std::make_tuple(64, 41, 0)] = "Color";                                                  // HEX Values 40, 29, 00
    MiLightCypher[std::make_tuple(64, 42, 0)] = "Color";                                                  // HEX Values 40, 2a, 00
    MiLightCypher[std::make_tuple(64, 43, 0)] = "Color";                                                  // HEX Values 40, 2b, 00
    MiLightCypher[std::make_tuple(64, 44, 0)] = "Color";                                                  // HEX Values 40, 2c, 00
    MiLightCypher[std::make_tuple(64, 45, 0)] = "Color";                                                  // HEX Values 40, 2d, 00
    MiLightCypher[std::make_tuple(64, 46, 0)] = "Color";                                                  // HEX Values 40, 2e, 00
    MiLightCypher[std::make_tuple(64, 47, 0)] = "Color";                                                  // HEX Values 40, 2f, 00
    MiLightCypher[std::make_tuple(64, 48, 0)] = "Color";                                                  // HEX Values 40, 30, 00
    MiLightCypher[std::make_tuple(64, 49, 0)] = "Color";                                                  // HEX Values 40, 31, 00
    MiLightCypher[std::make_tuple(64, 50, 0)] = "Color";                                                  // HEX Values 40, 32, 00
    MiLightCypher[std::make_tuple(64, 51, 0)] = "Color";                                                  // HEX Values 40, 33, 00
    MiLightCypher[std::make_tuple(64, 52, 0)] = "Color";                                                  // HEX Values 40, 34, 00
    MiLightCypher[std::make_tuple(64, 53, 0)] = "Color";                                                  // HEX Values 40, 35, 00
    MiLightCypher[std::make_tuple(64, 54, 0)] = "Color";                                                  // HEX Values 40, 36, 00
    MiLightCypher[std::make_tuple(64, 55, 0)] = "Color";                                                  // HEX Values 40, 37, 00
    MiLightCypher[std::make_tuple(64, 56, 0)] = "Color";                                                  // HEX Values 40, 38, 00
    MiLightCypher[std::make_tuple(64, 57, 0)] = "Color";                                                  // HEX Values 40, 39, 00
    MiLightCypher[std::make_tuple(64, 58, 0)] = "Color";                                                  // HEX Values 40, 3a, 00
    MiLightCypher[std::make_tuple(64, 59, 0)] = "Color";                                                  // HEX Values 40, 3b, 00
    MiLightCypher[std::make_tuple(64, 60, 0)] = "Color";                                                  // HEX Values 40, 3c, 00
    MiLightCypher[std::make_tuple(64, 61, 0)] = "Color";                                                  // HEX Values 40, 3d, 00
    MiLightCypher[std::make_tuple(64, 62, 0)] = "Color";                                                  // HEX Values 40, 3e, 00
    MiLightCypher[std::make_tuple(64, 63, 0)] = "Color";                                                  // HEX Values 40, 3f, 00
    MiLightCypher[std::make_tuple(64, 64, 0)] = "Color";                                                  // HEX Values 40, 40, 00
    MiLightCypher[std::make_tuple(64, 65, 0)] = "Color";                                                  // HEX Values 40, 41, 00
    MiLightCypher[std::make_tuple(64, 66, 0)] = "Color";                                                  // HEX Values 40, 42, 00
    MiLightCypher[std::make_tuple(64, 67, 0)] = "Color";                                                  // HEX Values 40, 43, 00
    MiLightCypher[std::make_tuple(64, 68, 0)] = "Color";                                                  // HEX Values 40, 44, 00
    MiLightCypher[std::make_tuple(64, 69, 0)] = "Color";                                                  // HEX Values 40, 45, 00
    MiLightCypher[std::make_tuple(64, 70, 0)] = "Color";                                                  // HEX Values 40, 46, 00
    MiLightCypher[std::make_tuple(64, 71, 0)] = "Color";                                                  // HEX Values 40, 47, 00
    MiLightCypher[std::make_tuple(64, 72, 0)] = "Color";                                                  // HEX Values 40, 48, 00
    MiLightCypher[std::make_tuple(64, 73, 0)] = "Color";                                                  // HEX Values 40, 49, 00
    MiLightCypher[std::make_tuple(64, 74, 0)] = "Color";                                                  // HEX Values 40, 4a, 00
    MiLightCypher[std::make_tuple(64, 75, 0)] = "Color";                                                  // HEX Values 40, 4b, 00
    MiLightCypher[std::make_tuple(64, 76, 0)] = "Color";                                                  // HEX Values 40, 4c, 00
    MiLightCypher[std::make_tuple(64, 77, 0)] = "Color";                                                  // HEX Values 40, 4d, 00
    MiLightCypher[std::make_tuple(64, 78, 0)] = "Color";                                                  // HEX Values 40, 4e, 00
    MiLightCypher[std::make_tuple(64, 79, 0)] = "Color";                                                  // HEX Values 40, 4f, 00
    MiLightCypher[std::make_tuple(64, 80, 0)] = "Color";                                                  // HEX Values 40, 50, 00
    MiLightCypher[std::make_tuple(64, 81, 0)] = "Color";                                                  // HEX Values 40, 51, 00
    MiLightCypher[std::make_tuple(64, 82, 0)] = "Color";                                                  // HEX Values 40, 52, 00
    MiLightCypher[std::make_tuple(64, 83, 0)] = "Color";                                                  // HEX Values 40, 53, 00
    MiLightCypher[std::make_tuple(64, 84, 0)] = "Color";                                                  // HEX Values 40, 54, 00
    MiLightCypher[std::make_tuple(64, 85, 0)] = "Color";                                                  // HEX Values 40, 55, 00
    MiLightCypher[std::make_tuple(64, 86, 0)] = "Color";                                                  // HEX Values 40, 56, 00
    MiLightCypher[std::make_tuple(64, 87, 0)] = "Color";                                                  // HEX Values 40, 57, 00
    MiLightCypher[std::make_tuple(64, 88, 0)] = "Color";                                                  // HEX Values 40, 58, 00
    MiLightCypher[std::make_tuple(64, 89, 0)] = "Color";                                                  // HEX Values 40, 59, 00
    MiLightCypher[std::make_tuple(64, 90, 0)] = "Color";                                                  // HEX Values 40, 5a, 00
    MiLightCypher[std::make_tuple(64, 91, 0)] = "Color";                                                  // HEX Values 40, 5b, 00
    MiLightCypher[std::make_tuple(64, 92, 0)] = "Color";                                                  // HEX Values 40, 5c, 00
    MiLightCypher[std::make_tuple(64, 93, 0)] = "Color";                                                  // HEX Values 40, 5d, 00
    MiLightCypher[std::make_tuple(64, 94, 0)] = "Color";                                                  // HEX Values 40, 5e, 00
    MiLightCypher[std::make_tuple(64, 95, 0)] = "Color";                                                  // HEX Values 40, 5f, 00
    MiLightCypher[std::make_tuple(64, 96, 0)] = "Color";                                                  // HEX Values 40, 60, 00
    MiLightCypher[std::make_tuple(64, 97, 0)] = "Color";                                                  // HEX Values 40, 61, 00
    MiLightCypher[std::make_tuple(64, 98, 0)] = "Color";                                                  // HEX Values 40, 62, 00
    MiLightCypher[std::make_tuple(64, 99, 0)] = "Color";                                                  // HEX Values 40, 63, 00
    MiLightCypher[std::make_tuple(64, 100, 0)] = "Color";                                                 // HEX Values 40, 64, 00
    MiLightCypher[std::make_tuple(64, 101, 0)] = "Color";                                                 // HEX Values 40, 65, 00
    MiLightCypher[std::make_tuple(64, 102, 0)] = "Color";                                                 // HEX Values 40, 66, 00
    MiLightCypher[std::make_tuple(64, 103, 0)] = "Color";                                                 // HEX Values 40, 67, 00
    MiLightCypher[std::make_tuple(64, 104, 0)] = "Color";                                                 // HEX Values 40, 68, 00
    MiLightCypher[std::make_tuple(64, 105, 0)] = "Color";                                                 // HEX Values 40, 69, 00
    MiLightCypher[std::make_tuple(64, 106, 0)] = "Color";                                                 // HEX Values 40, 6a, 00
    MiLightCypher[std::make_tuple(64, 107, 0)] = "Color";                                                 // HEX Values 40, 6b, 00
    MiLightCypher[std::make_tuple(64, 108, 0)] = "Color";                                                 // HEX Values 40, 6c, 00
    MiLightCypher[std::make_tuple(64, 109, 0)] = "Color";                                                 // HEX Values 40, 6d, 00
    MiLightCypher[std::make_tuple(64, 110, 0)] = "Color";                                                 // HEX Values 40, 6e, 00
    MiLightCypher[std::make_tuple(64, 111, 0)] = "Color";                                                 // HEX Values 40, 6f, 00
    MiLightCypher[std::make_tuple(64, 112, 0)] = "Color";                                                 // HEX Values 40, 70, 00
    MiLightCypher[std::make_tuple(64, 113, 0)] = "Color";                                                 // HEX Values 40, 71, 00
    MiLightCypher[std::make_tuple(64, 114, 0)] = "Color";                                                 // HEX Values 40, 72, 00
    MiLightCypher[std::make_tuple(64, 115, 0)] = "Color";                                                 // HEX Values 40, 73, 00
    MiLightCypher[std::make_tuple(64, 116, 0)] = "Color";                                                 // HEX Values 40, 74, 00
    MiLightCypher[std::make_tuple(64, 117, 0)] = "Color";                                                 // HEX Values 40, 75, 00
    MiLightCypher[std::make_tuple(64, 118, 0)] = "Color";                                                 // HEX Values 40, 76, 00
    MiLightCypher[std::make_tuple(64, 119, 0)] = "Color";                                                 // HEX Values 40, 77, 00
    MiLightCypher[std::make_tuple(64, 120, 0)] = "Color";                                                 // HEX Values 40, 78, 00
    MiLightCypher[std::make_tuple(64, 121, 0)] = "Color";                                                 // HEX Values 40, 79, 00
    MiLightCypher[std::make_tuple(64, 122, 0)] = "Color";                                                 // HEX Values 40, 7a, 00
    MiLightCypher[std::make_tuple(64, 123, 0)] = "Color";                                                 // HEX Values 40, 7b, 00
    MiLightCypher[std::make_tuple(64, 124, 0)] = "Color";                                                 // HEX Values 40, 7c, 00
    MiLightCypher[std::make_tuple(64, 125, 0)] = "Color";                                                 // HEX Values 40, 7d, 00
    MiLightCypher[std::make_tuple(64, 126, 0)] = "Color";                                                 // HEX Values 40, 7e, 00
    MiLightCypher[std::make_tuple(64, 127, 0)] = "Color";                                                 // HEX Values 40, 7f, 00
    MiLightCypher[std::make_tuple(64, 128, 0)] = "Color";                                                 // HEX Values 40, 80, 00
    MiLightCypher[std::make_tuple(64, 129, 0)] = "Color";                                                 // HEX Values 40, 81, 00
    MiLightCypher[std::make_tuple(64, 130, 0)] = "Color";                                                 // HEX Values 40, 82, 00
    MiLightCypher[std::make_tuple(64, 131, 0)] = "Color";                                                 // HEX Values 40, 83, 00
    MiLightCypher[std::make_tuple(64, 132, 0)] = "Color";                                                 // HEX Values 40, 84, 00
    MiLightCypher[std::make_tuple(64, 133, 0)] = "Color";                                                 // HEX Values 40, 85, 00
    MiLightCypher[std::make_tuple(64, 134, 0)] = "Color";                                                 // HEX Values 40, 86, 00
    MiLightCypher[std::make_tuple(64, 135, 0)] = "Color";                                                 // HEX Values 40, 87, 00
    MiLightCypher[std::make_tuple(64, 136, 0)] = "Color";                                                 // HEX Values 40, 88, 00
    MiLightCypher[std::make_tuple(64, 137, 0)] = "Color";                                                 // HEX Values 40, 89, 00
    MiLightCypher[std::make_tuple(64, 138, 0)] = "Color";                                                 // HEX Values 40, 8a, 00
    MiLightCypher[std::make_tuple(64, 139, 0)] = "Color";                                                 // HEX Values 40, 8b, 00
    MiLightCypher[std::make_tuple(64, 140, 0)] = "Color";                                                 // HEX Values 40, 8c, 00
    MiLightCypher[std::make_tuple(64, 141, 0)] = "Color";                                                 // HEX Values 40, 8d, 00
    MiLightCypher[std::make_tuple(64, 142, 0)] = "Color";                                                 // HEX Values 40, 8e, 00
    MiLightCypher[std::make_tuple(64, 143, 0)] = "Color";                                                 // HEX Values 40, 8f, 00
    MiLightCypher[std::make_tuple(64, 144, 0)] = "Color";                                                 // HEX Values 40, 90, 00
    MiLightCypher[std::make_tuple(64, 145, 0)] = "Color";                                                 // HEX Values 40, 91, 00
    MiLightCypher[std::make_tuple(64, 146, 0)] = "Color";                                                 // HEX Values 40, 92, 00
    MiLightCypher[std::make_tuple(64, 147, 0)] = "Color";                                                 // HEX Values 40, 93, 00
    MiLightCypher[std::make_tuple(64, 148, 0)] = "Color";                                                 // HEX Values 40, 94, 00
    MiLightCypher[std::make_tuple(64, 149, 0)] = "Color";                                                 // HEX Values 40, 95, 00
    MiLightCypher[std::make_tuple(64, 150, 0)] = "Color";                                                 // HEX Values 40, 96, 00
    MiLightCypher[std::make_tuple(64, 151, 0)] = "Color";                                                 // HEX Values 40, 97, 00
    MiLightCypher[std::make_tuple(64, 152, 0)] = "Color";                                                 // HEX Values 40, 98, 00
    MiLightCypher[std::make_tuple(64, 153, 0)] = "Color";                                                 // HEX Values 40, 99, 00
    MiLightCypher[std::make_tuple(64, 154, 0)] = "Color";                                                 // HEX Values 40, 9a, 00
    MiLightCypher[std::make_tuple(64, 155, 0)] = "Color";                                                 // HEX Values 40, 9b, 00
    MiLightCypher[std::make_tuple(64, 156, 0)] = "Color";                                                 // HEX Values 40, 9c, 00
    MiLightCypher[std::make_tuple(64, 157, 0)] = "Color";                                                 // HEX Values 40, 9d, 00
    MiLightCypher[std::make_tuple(64, 158, 0)] = "Color";                                                 // HEX Values 40, 9e, 00
    MiLightCypher[std::make_tuple(64, 159, 0)] = "Color";                                                 // HEX Values 40, 9f, 00
    MiLightCypher[std::make_tuple(64, 160, 0)] = "Color";                                                 // HEX Values 40, a0, 00
    MiLightCypher[std::make_tuple(64, 161, 0)] = "Color";                                                 // HEX Values 40, a1, 00
    MiLightCypher[std::make_tuple(64, 162, 0)] = "Color";                                                 // HEX Values 40, a2, 00
    MiLightCypher[std::make_tuple(64, 163, 0)] = "Color";                                                 // HEX Values 40, a3, 00
    MiLightCypher[std::make_tuple(64, 164, 0)] = "Color";                                                 // HEX Values 40, a4, 00
    MiLightCypher[std::make_tuple(64, 165, 0)] = "Color";                                                 // HEX Values 40, a5, 00
    MiLightCypher[std::make_tuple(64, 166, 0)] = "Color";                                                 // HEX Values 40, a6, 00
    MiLightCypher[std::make_tuple(64, 167, 0)] = "Color";                                                 // HEX Values 40, a7, 00
    MiLightCypher[std::make_tuple(64, 168, 0)] = "Color";                                                 // HEX Values 40, a8, 00
    MiLightCypher[std::make_tuple(64, 169, 0)] = "Color";                                                 // HEX Values 40, a9, 00
    MiLightCypher[std::make_tuple(64, 170, 0)] = "Color";                                                 // HEX Values 40, aa, 00
    MiLightCypher[std::make_tuple(64, 171, 0)] = "Color";                                                 // HEX Values 40, ab, 00
    MiLightCypher[std::make_tuple(64, 172, 0)] = "Color";                                                 // HEX Values 40, ac, 00
    MiLightCypher[std::make_tuple(64, 173, 0)] = "Color";                                                 // HEX Values 40, ad, 00
    MiLightCypher[std::make_tuple(64, 174, 0)] = "Color";                                                 // HEX Values 40, ae, 00
    MiLightCypher[std::make_tuple(64, 175, 0)] = "Color";                                                 // HEX Values 40, af, 00
    MiLightCypher[std::make_tuple(64, 176, 0)] = "Color";                                                 // HEX Values 40, b0, 00
    MiLightCypher[std::make_tuple(64, 177, 0)] = "Color";                                                 // HEX Values 40, b1, 00
    MiLightCypher[std::make_tuple(64, 178, 0)] = "Color";                                                 // HEX Values 40, b2, 00
    MiLightCypher[std::make_tuple(64, 179, 0)] = "Color";                                                 // HEX Values 40, b3, 00
    MiLightCypher[std::make_tuple(64, 180, 0)] = "Color";                                                 // HEX Values 40, b4, 00
    MiLightCypher[std::make_tuple(64, 181, 0)] = "Color";                                                 // HEX Values 40, b5, 00
    MiLightCypher[std::make_tuple(64, 182, 0)] = "Color";                                                 // HEX Values 40, b6, 00
    MiLightCypher[std::make_tuple(64, 183, 0)] = "Color";                                                 // HEX Values 40, b7, 00
    MiLightCypher[std::make_tuple(64, 184, 0)] = "Color";                                                 // HEX Values 40, b8, 00
    MiLightCypher[std::make_tuple(64, 185, 0)] = "Color";                                                 // HEX Values 40, b9, 00
    MiLightCypher[std::make_tuple(64, 186, 0)] = "Color";                                                 // HEX Values 40, ba, 00
    MiLightCypher[std::make_tuple(64, 187, 0)] = "Color";                                                 // HEX Values 40, bb, 00
    MiLightCypher[std::make_tuple(64, 188, 0)] = "Color";                                                 // HEX Values 40, bc, 00
    MiLightCypher[std::make_tuple(64, 189, 0)] = "Color";                                                 // HEX Values 40, bd, 00
    MiLightCypher[std::make_tuple(64, 190, 0)] = "Color";                                                 // HEX Values 40, be, 00
    MiLightCypher[std::make_tuple(64, 191, 0)] = "Color";                                                 // HEX Values 40, bf, 00
    MiLightCypher[std::make_tuple(64, 192, 0)] = "Color";                                                 // HEX Values 40, c0, 00
    MiLightCypher[std::make_tuple(64, 193, 0)] = "Color";                                                 // HEX Values 40, c1, 00
    MiLightCypher[std::make_tuple(64, 194, 0)] = "Color";                                                 // HEX Values 40, c2, 00
    MiLightCypher[std::make_tuple(64, 195, 0)] = "Color";                                                 // HEX Values 40, c3, 00
    MiLightCypher[std::make_tuple(64, 196, 0)] = "Color";                                                 // HEX Values 40, c4, 00
    MiLightCypher[std::make_tuple(64, 197, 0)] = "Color";                                                 // HEX Values 40, c5, 00
    MiLightCypher[std::make_tuple(64, 198, 0)] = "Color";                                                 // HEX Values 40, c6, 00
    MiLightCypher[std::make_tuple(64, 199, 0)] = "Color";                                                 // HEX Values 40, c7, 00
    MiLightCypher[std::make_tuple(64, 200, 0)] = "Color";                                                 // HEX Values 40, c8, 00
    MiLightCypher[std::make_tuple(64, 201, 0)] = "Color";                                                 // HEX Values 40, c9, 00
    MiLightCypher[std::make_tuple(64, 202, 0)] = "Color";                                                 // HEX Values 40, ca, 00
    MiLightCypher[std::make_tuple(64, 203, 0)] = "Color";                                                 // HEX Values 40, cb, 00
    MiLightCypher[std::make_tuple(64, 204, 0)] = "Color";                                                 // HEX Values 40, cc, 00
    MiLightCypher[std::make_tuple(64, 205, 0)] = "Color";                                                 // HEX Values 40, cd, 00
    MiLightCypher[std::make_tuple(64, 206, 0)] = "Color";                                                 // HEX Values 40, ce, 00
    MiLightCypher[std::make_tuple(64, 207, 0)] = "Color";                                                 // HEX Values 40, cf, 00
    MiLightCypher[std::make_tuple(64, 208, 0)] = "Color";                                                 // HEX Values 40, d0, 00
    MiLightCypher[std::make_tuple(64, 209, 0)] = "Color";                                                 // HEX Values 40, d1, 00
    MiLightCypher[std::make_tuple(64, 210, 0)] = "Color";                                                 // HEX Values 40, d2, 00
    MiLightCypher[std::make_tuple(64, 211, 0)] = "Color";                                                 // HEX Values 40, d3, 00
    MiLightCypher[std::make_tuple(64, 212, 0)] = "Color";                                                 // HEX Values 40, d4, 00
    MiLightCypher[std::make_tuple(64, 213, 0)] = "Color";                                                 // HEX Values 40, d5, 00
    MiLightCypher[std::make_tuple(64, 214, 0)] = "Color";                                                 // HEX Values 40, d6, 00
    MiLightCypher[std::make_tuple(64, 215, 0)] = "Color";                                                 // HEX Values 40, d7, 00
    MiLightCypher[std::make_tuple(64, 216, 0)] = "Color";                                                 // HEX Values 40, d8, 00
    MiLightCypher[std::make_tuple(64, 217, 0)] = "Color";                                                 // HEX Values 40, d9, 00
    MiLightCypher[std::make_tuple(64, 218, 0)] = "Color";                                                 // HEX Values 40, da, 00
    MiLightCypher[std::make_tuple(64, 219, 0)] = "Color";                                                 // HEX Values 40, db, 00
    MiLightCypher[std::make_tuple(64, 220, 0)] = "Color";                                                 // HEX Values 40, dc, 00
    MiLightCypher[std::make_tuple(64, 221, 0)] = "Color";                                                 // HEX Values 40, dd, 00
    MiLightCypher[std::make_tuple(64, 222, 0)] = "Color";                                                 // HEX Values 40, de, 00
    MiLightCypher[std::make_tuple(64, 223, 0)] = "Color";                                                 // HEX Values 40, df, 00
    MiLightCypher[std::make_tuple(64, 224, 0)] = "Color";                                                 // HEX Values 40, e0, 00
    MiLightCypher[std::make_tuple(64, 225, 0)] = "Color";                                                 // HEX Values 40, e1, 00
    MiLightCypher[std::make_tuple(64, 226, 0)] = "Color";                                                 // HEX Values 40, e2, 00
    MiLightCypher[std::make_tuple(64, 227, 0)] = "Color";                                                 // HEX Values 40, e3, 00
    MiLightCypher[std::make_tuple(64, 228, 0)] = "Color";                                                 // HEX Values 40, e4, 00
    MiLightCypher[std::make_tuple(64, 229, 0)] = "Color";                                                 // HEX Values 40, e5, 00
    MiLightCypher[std::make_tuple(64, 230, 0)] = "Color";                                                 // HEX Values 40, e6, 00
    MiLightCypher[std::make_tuple(64, 231, 0)] = "Color";                                                 // HEX Values 40, e7, 00
    MiLightCypher[std::make_tuple(64, 232, 0)] = "Color";                                                 // HEX Values 40, e8, 00
    MiLightCypher[std::make_tuple(64, 233, 0)] = "Color";                                                 // HEX Values 40, e9, 00
    MiLightCypher[std::make_tuple(64, 234, 0)] = "Color";                                                 // HEX Values 40, ea, 00
    MiLightCypher[std::make_tuple(64, 235, 0)] = "Color";                                                 // HEX Values 40, eb, 00
    MiLightCypher[std::make_tuple(64, 236, 0)] = "Color";                                                 // HEX Values 40, ec, 00
    MiLightCypher[std::make_tuple(64, 237, 0)] = "Color";                                                 // HEX Values 40, ed, 00
    MiLightCypher[std::make_tuple(64, 238, 0)] = "Color";                                                 // HEX Values 40, ee, 00
    MiLightCypher[std::make_tuple(64, 239, 0)] = "Color";                                                 // HEX Values 40, ef, 00
    MiLightCypher[std::make_tuple(64, 240, 0)] = "Color";                                                 // HEX Values 40, f0, 00
    MiLightCypher[std::make_tuple(64, 241, 0)] = "Color";                                                 // HEX Values 40, f1, 00
    MiLightCypher[std::make_tuple(64, 242, 0)] = "Color";                                                 // HEX Values 40, f2, 00
    MiLightCypher[std::make_tuple(64, 243, 0)] = "Color";                                                 // HEX Values 40, f3, 00
    MiLightCypher[std::make_tuple(64, 244, 0)] = "Color";                                                 // HEX Values 40, f4, 00
    MiLightCypher[std::make_tuple(64, 245, 0)] = "Color";                                                 // HEX Values 40, f5, 00
    MiLightCypher[std::make_tuple(64, 246, 0)] = "Color";                                                 // HEX Values 40, f6, 00
    MiLightCypher[std::make_tuple(64, 247, 0)] = "Color";                                                 // HEX Values 40, f7, 00
    MiLightCypher[std::make_tuple(64, 248, 0)] = "Color";                                                 // HEX Values 40, f8, 00
    MiLightCypher[std::make_tuple(64, 249, 0)] = "Color";                                                 // HEX Values 40, f9, 00
    MiLightCypher[std::make_tuple(64, 250, 0)] = "Color";                                                 // HEX Values 40, fa, 00
    MiLightCypher[std::make_tuple(64, 251, 0)] = "Color";                                                 // HEX Values 40, fb, 00
    MiLightCypher[std::make_tuple(64, 252, 0)] = "Color";                                                 // HEX Values 40, fc, 00
    MiLightCypher[std::make_tuple(64, 253, 0)] = "Color";                                                 // HEX Values 40, fd, 00
    MiLightCypher[std::make_tuple(64, 254, 0)] = "Color";                                                 // HEX Values 40, fe, 00
    MiLightCypher[std::make_tuple(64, 255, 0)] = "Color";                                                 // HEX Values 40, ff, 00

    MiLightCypher[std::make_tuple(65, 0, 0)] = "\"Status\": \"Off\"";                             // HEX Values 41, 00, 00
    MiLightCypher[std::make_tuple(66, 0, 0)] = "\"Status\": \"On\"";                              // HEX Values 42, 00, 00
    MiLightCypher[std::make_tuple(194, 0, 0)] = "\"Status\": \"On\"\n \"ColorMode\": \"White\"\n \"Brightness\": \"Max\"";                         // HEX Values c2, 00, 00
    MiLightCypher[std::make_tuple(193, 0, 0)] = "Master Nightlight";                              // HEX Values c1, 00, 00
    MiLightCypher[std::make_tuple(77, 0, 0)] = "Mode";                                            // HEX Values 4d, 00, 00
    MiLightCypher[std::make_tuple(205, 0, 0)] = "Unknown (Hold Mode Button)";                     // HEX Values cd, 00, 00
    MiLightCypher[std::make_tuple(67, 0, 0)] = "Decrease Speed";                                  // HEX Values 43, 00, 00
    MiLightCypher[std::make_tuple(68, 0, 0)] = "Increase Speed";                                  // HEX Values 44, 00, 00
    MiLightCypher[std::make_tuple(195, 0, 0)] = "Change Mode Down";                               // HEX Values c3, 00, 00
    MiLightCypher[std::make_tuple(196, 0, 0)] = "Change Mode Up";                                 // HEX Values c4, 00, 00
    MiLightCypher[std::make_tuple(69, 0, 0)] = "Zone 1 On";                                       // HEX Values 45, 00, 00
    MiLightCypher[std::make_tuple(70, 0, 0)] = "Zone 1 Off";                                      // HEX Values 46, 00, 00
    MiLightCypher[std::make_tuple(197, 0, 0)] = "Zone 1 White Mode Full";                         // HEX Values c5, 00, 00
    MiLightCypher[std::make_tuple(198, 0, 0)] = "Zone 1 Nightlight";                              // HEX Values c6, 00, 00
    MiLightCypher[std::make_tuple(71, 0, 0)] = "Zone 2 On";                                       // HEX Values 47, 00, 00
    MiLightCypher[std::make_tuple(72, 0, 0)] = "Zone 2 Off";                                      // HEX Values 48, 00, 00
    MiLightCypher[std::make_tuple(199, 0, 0)] = "Zone 2 White Mode Full";                         // HEX Values c7, 00, 00
    MiLightCypher[std::make_tuple(200, 0, 0)] = "Zone 2 Nightlight";                              // HEX Values c8, 00, 00
    MiLightCypher[std::make_tuple(73, 0, 0)] = "Zone 3 On";                                       // HEX Values 49, 00, 00
    MiLightCypher[std::make_tuple(74, 0, 0)] = "Zone 3 Off";                                      // HEX Values 4a, 00, 00
    MiLightCypher[std::make_tuple(201, 0, 0)] = "Zone 3 White Mode Full";                         // HEX Values c9, 00, 00
    MiLightCypher[std::make_tuple(202, 0, 0)] = "Zone 3 Nightlight";                              // HEX Values ca, 00, 00
    MiLightCypher[std::make_tuple(75, 0, 0)] = "Zone 4 On";                                       // HEX Values 4b, 00, 00
    MiLightCypher[std::make_tuple(76, 0, 0)] = "Zone 4 Off";                                      // HEX Values 4c, 00, 00
    MiLightCypher[std::make_tuple(203, 0, 0)] = "Zone 4 White Mode Full";                         // HEX Values cb, 00, 00
    MiLightCypher[std::make_tuple(204, 0, 0)] = "Zone 4 Nightlight";                              // HEX Values cc, 00, 00
    MiLightCypher[std::make_tuple(78, 0, 0)] = "Brightness 0";                                    // HEX Values 4e, 00, 00
    MiLightCypher[std::make_tuple(78, 1, 0)] = "Brightness 1";                                    // HEX Values 4e, 01, 00
    MiLightCypher[std::make_tuple(78, 2, 0)] = "Brightness 2";                                    // HEX Values 4e, 02, 00
    MiLightCypher[std::make_tuple(78, 3, 0)] = "Brightness 3";                                    // HEX Values 4e, 03, 00
    MiLightCypher[std::make_tuple(78, 4, 0)] = "Brightness 4";                                    // HEX Values 4e, 04, 00
    MiLightCypher[std::make_tuple(78, 5, 0)] = "Brightness 5";                                    // HEX Values 4e, 05, 00
    MiLightCypher[std::make_tuple(78, 6, 0)] = "Brightness 6";                                    // HEX Values 4e, 06, 00
    MiLightCypher[std::make_tuple(78, 7, 0)] = "Brightness 7";                                    // HEX Values 4e, 07, 00
    MiLightCypher[std::make_tuple(78, 8, 0)] = "Brightness 8";                                    // HEX Values 4e, 08, 00
    MiLightCypher[std::make_tuple(78, 9, 0)] = "Brightness 9";                                    // HEX Values 4e, 09, 00
    MiLightCypher[std::make_tuple(78, 10, 0)] = "Brightness 10";                                  // HEX Values 4e, 1a, 00
    MiLightCypher[std::make_tuple(78, 11, 0)] = "Brightness 11";                                  // HEX Values 4e, 1b, 00
    MiLightCypher[std::make_tuple(78, 12, 0)] = "Brightness 12";                                  // HEX Values 4e, 1c, 00
    MiLightCypher[std::make_tuple(78, 13, 0)] = "Brightness 13";                                  // HEX Values 4e, 1d, 00
    MiLightCypher[std::make_tuple(78, 14, 0)] = "Brightness 14";                                  // HEX Values 4e, 1e, 00
    MiLightCypher[std::make_tuple(78, 15, 0)] = "Brightness 15";                                  // HEX Values 4e, 1f, 00
    return;    
}		
 
std::string atomikCypher :: getAtomikJSON(int x, int y, int z)
{
    std::stringstream buffer;
    auto t = MiLightCypher.find(std::make_tuple(x, y, z));
    if (t == MiLightCypher.end()) return std::string();
        buffer << t->second;
    return buffer.str();
}