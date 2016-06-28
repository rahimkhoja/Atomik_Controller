#include <iostream>
#include <string>
#include <vector>
#include <chrono>
#include <algorithm>
#include <sys/time.h>

class repeatBuffer {
public:
  repeatBuffer();
  bool addTransmission(int add1, int add2, int col, int bri, int wt, int command);
private:
  struct transmissionData {
  int add1;
  int add2;  
  int command;
  int color;
  int bright;
  int whitetemp;
};

struct transmission{
  struct transmissionData data;
  double timestamp;
};
  void removeOldTransmissions();
  bool compare_trans( const transmissionData & e1, const transmissionData & e2);
  std::vector<transmission> trans;
};

repeatBuffer::repeatBuffer() {
  std::cout << "Repeat Buffer Initiated" << std::endl;
};

bool repeatBuffer::compare_trans( const repeatBuffer::transmissionData & e1, const repeatBuffer::transmissionData & e2) {
  if( e1.add1 == e2.add1 &&  e1.add2 == e2.add2 && e1.color == e2.color && e1.bright == e2.bright && e1.whitetemp == e2.whitetemp)
    return true;
  return false;
};

void repeatBuffer::removeOldTransmissions() {
    
    timeval tv;
    gettimeofday (&tv, NULL);
    double currentTime = (tv.tv_sec) + 0.0000001 * tv.tv_usec;
    

    for(std::vector<transmission>::iterator it = trans.begin(); it != trans.end(); ++it) {
        double elapsedTime = currentTime - (*it).timestamp;
        if ( elapsedTime > 350000 ) {
            trans.erase(it);
        }
    }
};


bool repeatBuffer::addTransmission(int add1, int add2, int col, int bri, int wt, int command) {
  std::cout << "Adding Tramsission to Buffer!" << std::endl;
  bool returnVal = false;
  repeatBuffer::transmissionData newTrans;
  newTrans.add1 = add1;
  newTrans.add2 = add2;
  newTrans.bright = bri;
  newTrans.color = col;
  newTrans.whitetemp = wt;
  newTrans.command = command;
  for(std::vector<transmission>::iterator it = trans.begin(); it != trans.end(); ++it) {
      if (compare_trans(newTrans, it.data){
          trans.erase(it);
          returnVal = true;
          break;
      }
  }
  transmission newTra;
  newTra.data = newTrans;
   timeval tv;
    gettimeofday (&tv, NULL);
    double newTra.timestamp = (tv.tv_sec) + 0.0000001 * tv.tv_usec;
  trans.push_back(newTra);
  retrun returnVal;
  
}