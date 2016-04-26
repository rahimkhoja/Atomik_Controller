#ifndef atomikCypher_H
#define atomikCypher_H

#include <iostream>
#include <unordered_map>
#include <tuple>
#include <string>
#include <vector>
#include <utility>

namespace Atomik
{
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
             return 
             (
                  std::get<0>(v0) == std::get<0>(v1) &&
                  std::get<1>(v0) == std::get<1>(v1) &&
                  std::get<2>(v0) == std::get<2>(v1) 
             );
        }
    };

    typedef std::unordered_map<const key_t,std::string,key_hash,key_equal> map_t;
    
    
    
    
    typedef std::tuple<int, int, int,int> key_t4;
    struct key_hash4 : public std::unary_function<key_t4, std::size_t>
    {
        std::size_t operator()(const key_t4& k) const
        {
            return std::get<0>(k) ^ std::get<1>(k) ^ std::get<2>(k) ^ std::get<3>(k);
        }
    };

    struct key_equal4 : public std::binary_function<key_t4, key_t4, bool>
    {
        bool operator()(const key_t4& v0, const key_t4& v1) const
        {
             return 
             (
                  std::get<0>(v0) == std::get<0>(v1) &&
                  std::get<1>(v0) == std::get<1>(v1) &&
                  std::get<2>(v0) == std::get<2>(v1) &&
                  std::get<3>(v0) == std::get<3>(v1)
             );
        }
    };

    typedef std::unordered_map<const key_t4,std::string,key_hash4,key_equal4> map_t4;
    
    
};


class atomikCypher
{
     private :
          void init();
          Atomik::map_t MiLightSmartPhonetoJSONCypher;
          //Atomik::map_t MiLightRadiotoJSONCypher;
          std::vector<std::pair<int,int>> MiLightRadiotoJSONCypher;
          
     public :
          //with default value
          atomikCypher();
          //	setter function
          std::string getSmartPhoneAtomikJSON(int h, int m, int s);
          std::string getRadioAtomikJSON(int h, int m);
          // Print a description of object in " hh:mm:ss"
};
 
#endif