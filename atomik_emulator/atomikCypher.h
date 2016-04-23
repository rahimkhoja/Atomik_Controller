#ifndef atomikCypher_H
#define atomikCypher_H

#include <iostream>
#include <unordered_map>
#include <tuple>
#include <string>

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
    
    
    
    
    typedef std::tuple<int, int, int,int, int, int, int> key_t7;
    struct key_hash7 : public std::unary_function<key_t7, std::size_t>
    {
        std::size_t operator()(const key_t7& k) const
        {
            return std::get<0>(k) ^ std::get<1>(k) ^ std::get<2>(k) ^ std::get<3>(k) ^ std::get<4>(k) ^ std::get<5>(k) ^ std::get<6>(k);
        }
    };

    struct key_equal7 : public std::binary_function<key_t7, key_t7, bool>
    {
        bool operator()(const key_t7& v0, const key_t7& v1) const
        {
             return 
             (
                  std::get<0>(v0) == std::get<0>(v1) &&
                  std::get<1>(v0) == std::get<1>(v1) &&
                  std::get<2>(v0) == std::get<2>(v1) &&
                  std::get<3>(v0) == std::get<3>(v1) &&
                  std::get<4>(v0) == std::get<4>(v1) &&
                  std::get<5>(v0) == std::get<5>(v1) &&
                  std::get<6>(v0) == std::get<6>(v1) 
             );
        }
    };

    typedef std::unordered_map<const key_t7,std::string,key_hash7,key_equal7> map_t7;
    
    
};


class atomikCypher
{
     private :
          void init();
          Atomik::map_t MiLightSmartPhonetoJSONCypher;
          Atomik::map_t7 MiLightRadiotoJSONCypher;
     public :
          //with default value
          atomikCypher();
          //	setter function
          std::string getAtomikJSON(int h, int m, int s);
          // Print a description of object in " hh:mm:ss"
};
 
#endif