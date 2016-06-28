#include <iostream>
#include <string>
#include <vector>
#include <chrono>
#include <algorithm>
#include <sys/time.h>

struct transmissionData {
  int add1;
  int add2;  
  int command;
  int color;
  int bright;
  int prefix;
};

struct transmission{
  struct transmissionData data;
  double timestamp;
};

class repeatBuffer {

private:
 
  std::vector<transmission> trans;



bool compare_trans( const transmissionData & e1, const transmissionData & e2) {
  if( e1.add1 == e2.add1 &&  e1.add2 == e2.add2 && e1.color == e2.color && e1.bright == e2.bright && e1.prefix == e2.prefix)
    return true;
  return false;
};

void removeOldTransmissions() {
    
    timeval tv;
    gettimeofday (&tv, NULL);
    double currentTime = (tv.tv_sec) + 0.0000001 * tv.tv_usec;
    

    for(std::vector<transmission>::iterator it = trans.begin(); it != trans.end(); ++it) {
        double elapsedTime = currentTime - (*it).timestamp;
        std::cout << std::fixed << (*it).timestamp << std::endl;
        
        std::cout << std::fixed << currentTime << std::endl;
        std::cout << std::fixed << elapsedTime << std::endl;
        if ( elapsedTime > 0.350000 ) {
            std::cout << std::fixed << "deleted: " << (*it).timestamp << std::endl;
            trans.erase(it);
        }
    }
};

public:
  
bool addTransmission(int add1, int add2, int col, int bri, int pf, int command) {
  std::cout << "Adding Tramsission to Buffer!" << std::endl;
  bool returnVal = false;
  transmissionData newTrans;
  newTrans.add1 = add1;
  newTrans.add2 = add2;
  newTrans.bright = bri;
  newTrans.color = col;
  newTrans.prefix = pf;
  newTrans.command = command;
  removeOldTransmissions();
  for(std::vector<transmission>::iterator it = trans.begin(); it != trans.end(); ++it) {
      if (compare_trans(newTrans, (*it).data)) {
          trans.erase(it);
          returnVal = true;
      }
  }
  transmission newTra;
  newTra.data = newTrans;
   timeval tv;
    gettimeofday (&tv, NULL);
    newTra.timestamp = (tv.tv_sec) + 0.0000001 * tv.tv_usec;
    std::cout << newTra.timestamp << std::endl;
  trans.push_back(newTra);
  return returnVal;
  
};
};