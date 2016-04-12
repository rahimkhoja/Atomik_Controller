 

#include <iostream>
#include <iomanip>
#include "atomikCypher.h"
using namespace std;
 
atomikCypher :: Time(const int h, const int m, const int s) 
  : hour(h), minute (m), second(s)
{}
 
void atomikCypher :: setTime(const int h, const int m, const int s) 
{
     hour = h;
     minute = m;
     second = s;     
}		
 
void atomikCypher :: print() const
{
     cout << setw(2) << setfill('0') << hour << ":"
	<< setw(2) << setfill('0') << minute << ":"
 	<< setw(2) << setfill('0') << second << "\n";	
 
}
 
bool atomikCypher :: equals(const Time &otherTime)
{
     if(hour == otherTime.hour 
          && minute == otherTime.minute 
          && second == otherTime.second)
          return true;
     else
          return false;
}