#ifndef atomikCypher_H
#define atomikCypher_H

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

    typedef std::unordered_map<const key_t,string,key_hash,key_equal> map_t;

};

class atomikCypher
{
     private :
          void init();
          Atomik::map_t MiLightCypher;
     public :
          //with default value
          atomikCypher();
          //	setter function
          std::string getAtomikJSON(int h, int m, int s);
          // Print a description of object in " hh:mm:ss"
};
 
#endif