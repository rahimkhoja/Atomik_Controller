#ifndef atomikCypher_H
#define atomikCypher_H

class atomikCypher
{
     private :
          void init();
          int hour;
          int minute;
          int second;
     public :
          //with default value
          atomikCypher();
          //	setter function
          std:string getAtomikJSON(int h, int m, int s);
          // Print a description of object in " hh:mm:ss"
};
 
#endif