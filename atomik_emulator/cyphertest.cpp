 
#include <iostream>
using namespace std;
#include "atomikCypher.h"

int main()
{
     atomikCypher cypher;
     cout << cypher.getAtomikJSON(64, 134, 0) << endl;
     return 0;
}