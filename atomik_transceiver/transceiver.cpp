//  sudo g++ -std=c++11 -lrf24-bcm PL1167_nRF24.cpp MiLightRadio.cpp transceiver.cpp -o atomik_transceiver -pthread

#include <cstdlib>
#include <iostream>
#include <string>
#include <stdio.h>
#include <unistd.h>
#include <sys/time.h>
#include <sys/select.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <arpa/inet.h>
#include <RF24/RF24.h>
#include <list>
#include <thread>
#include <vector>
#include <pthread.h>
#include <atomic>
#include <algorithm> 
#include <sstream>
#include <fstream>
#include <iterator>

#include <mutex>

#include "PL1167_nRF24.h"
#include "MiLightRadio.h"
#include "../atomik_cypher/atomikCypher.h"

RF24 radio(RPI_V2_GPIO_P1_22, RPI_V2_GPIO_P1_24, BCM2835_SPI_SPEED_8MHZ);

PL1167_nRF24 prf(radio);
MiLightRadio mlr(prf);

static int debug = 0;
static int dupesPrinted = 0;
std::list<std::string> commandList;
atomikCypher MiLightCypher;

std::mutex commandListMutex;
std::mutex JSONfileMutex;
std::mutex consoleMutex;

std::atomic<bool> disableSocket;

int do_receive = 0;
int do_command = 0;
int do_server = 0;
int alreadyRunning = 0;

uint8_t prefix   = 0xB8;
uint8_t rem_p    = 0x00;
uint8_t remote   = 0x01;
uint8_t color    = 0x00;
uint8_t bright   = 0x00;
uint8_t key      = 0x01;
uint8_t seq      = 0x00;
uint8_t resends  =   10;
uint64_t command = 0x00;

int radiomode = 1;

const char *options = "hdfslumt:n:p:q:r:c:b:k:v:w:";
  
std::thread socketServerThread;
  
int socketPort = 5000;

std::vector<std::string> all_args;
std::vector<std::string> socket_args;

enum option_code {
    h,
    d,
    f,
    s,
    l,
    u,
    m,
    t,
    n,
    p,
    q,
    r,
    c,
    b,
    k,
    v,
    w
};

option_code hashit (std::string inString) {
    if (inString == "-h") return h;
    if (inString == "-d") return d;
    if (inString == "-f") return f;
    if (inString == "-s") return s;
    if (inString == "-l") return l;
    if (inString == "-u") return u;
    if (inString == "-m") return m;
    if (inString == "-t") return t;
    if (inString == "-n") return n;
    if (inString == "-p") return p;
    if (inString == "-q") return q;
    if (inString == "-r") return r;
    if (inString == "-c") return c;
    if (inString == "-b") return b;
    if (inString == "-k") return k;
    if (inString == "-v") return v;
    if (inString == "-w") return w;
}

std::string strConcat(std::string a, std::string b)
{
  std::stringstream ss;
  ss << a << b;
  std::string s = ss.str();
  return s;
}

void JSONfilewrite (std::string textjson) 
{
  JSONfileMutex.lock();
  
  char filename[] = "AtomikRadioJSON.log";
  std::fstream json;

  json.open(filename, std::fstream::in | std::fstream::out | std::fstream::app);
  if (!json ) 
  {
        json.open(filename,  std::fstream::in | std::fstream::out | std::fstream::trunc);
        json << textjson.c_str();
        json << "\n";
        json.close();
  } else {
  
        json << textjson.c_str();
        json.close();
  }
       
  JSONfileMutex.unlock();
  return;
}

void consoleWrite(std::string input)
{
  consoleMutex.lock();
  printf(input.c_str());
  printf("\n");
  fflush(stdout);
  consoleMutex.unlock();
  return;
}

void usage(const char *arg, const char *options){
  printf("\n");
  printf("Usage: sudo %s [%s]\n", arg, options);
  printf("\n");
  printf("   -h                       Show this help\n");
  printf("   -d                       Show debug output\n");
  printf("   -n NN<dec>               Resends of the same message\n");
  printf("   -p PP<hex>               Prefix value (Disco Mode)\n");
  printf("   -q RR<hex>               First byte of the remote\n");
  printf("   -r RR<hex>               Second byte of the remote\n");
  printf("   -c CC<hex>               Color byte\n");
  printf("   -b BB<hex>               Brightness byte\n");
  printf("   -k KK<hex>               Key byte\n");
  printf("   -v SS<hex>               Sequence byte\n");
  printf("   -m M <int>               Radio Mode ( RGB=1 White=2 )\n");
  printf("   -w SSPPRRRRCCBBKKNN<hex> Complete message to send\n");
  printf("\n");
}


std::string int2hex(int x)
{
    char out[2];
    sprintf(out, "%02X", x);
    return std::string(out);
}

std::string int2int(int x)
{
    std::stringstream ss;
    ss << x;
    return ss.str();
}

void getOptions(std::vector<std::string> args, int type)
{
    int cint;
    uint64_t tmp;
    std::vector<std::string> arguments = args;
    
    if (type > 0 ) 
    {
        for(int i=0; i < arguments.size(); i++)
        {
            switch (hashit(arguments[i])) 
            {
                case n:
                 tmp = strtoll(arguments[i+1].c_str(), NULL, 10);
                 resends = (uint8_t)tmp;
                 break;
                case p:
                 tmp = strtoll(arguments[i+1].c_str(), NULL, 16);
                 prefix = (uint8_t)tmp;
                 break;
                case q:
                 tmp = strtoll(arguments[i+1].c_str(), NULL, 16);
                 rem_p = (uint8_t)tmp;       
                 break;
                case r:
                 tmp = strtoll(arguments[i+1].c_str(), NULL, 16);
                 remote = (uint8_t)tmp;   
                 break;
                case c:
                 tmp = strtoll(arguments[i+1].c_str(), NULL, 16);
                 color = (uint8_t)tmp;    
                 break;
                case b:
                 tmp = strtoll(arguments[i+1].c_str(), NULL, 16);
                 bright = (uint8_t)tmp;
                 break;
                case k:
                 tmp = strtoll(arguments[i+1].c_str(), NULL, 16);
                 key = (uint8_t)tmp;
                 break;
                case v:
                 tmp = strtoll(arguments[i+1].c_str(), NULL, 16);
                 seq = (uint8_t)tmp;
                 break;
                case t:
                 tmp = strtoll(arguments[i+1].c_str(), NULL, 10);
                 radiomode = (uint8_t)tmp;
                 break;
            }
        }
    
    } else {
    
        std::vector<const char *> argv(args.size());
        std::transform(args.begin(), args.end(), argv.begin(), [](std::string& str){
            return str.c_str();});
          
        while((cint = getopt(argv.size(), const_cast<char**>(argv.data()), options)) != -1)
	    {
		    switch(cint){
              case 'h':
                usage(argv[0], options);
                exit(0);
                break;
              case 'd':
                if ( type == 0 )
          {
            debug = 1;
          }
        break;
      case 'n':
         if ( type == 0 )
         {
            do_receive = 0;
            do_server = 0;
            do_command = 1;
            tmp = strtoll(optarg, NULL, 10);
            resends = (uint8_t)tmp;
         }
         break;
      case 'p':
          if ( type == 0 )
          {
            do_receive = 0;
            do_server = 0;      
            do_command = 1;
          }
		  tmp = strtoll(optarg, NULL, 16);
            prefix = (uint8_t)tmp;          
          
        break;
      case 'q':
        if ( type == 0 )
        {
            do_receive = 0;
            do_server = 0;      
            do_command = 1;
        } 
        tmp = strtoll(optarg, NULL, 16);
        rem_p = (uint8_t)tmp;       
        break;
      case 'r':
        if ( type == 0 )
        {
            do_receive = 0;
            do_server = 0;      
            do_command = 1;
        }
		tmp = strtoll(optarg, NULL, 16);
        remote = (uint8_t)tmp;   
        break;
      case 'c':
        if ( type == 0 )
        {
            do_receive = 0;
            do_server = 0;      
            do_command = 1;
        }
            tmp = strtoll(optarg, NULL, 16);
            color = (uint8_t)tmp;
        
        break;
      case 'b':
        if ( type == 0 )
        {
            do_receive = 0;
            do_server = 0;      
            do_command = 1;
        }
            tmp = strtoll(optarg, NULL, 16);
            bright = (uint8_t)tmp;
                
        break;
      case 'k':
        if ( type == 0 )
        {
            do_receive = 0;
            do_server = 0;      
            do_command = 1;
        }
            
            tmp = strtoll(optarg, NULL, 16);
            key = (uint8_t)tmp;
        
        break;
      case 'v':
        if ( type == 0 )
        {
            do_receive = 0;
            do_server = 0;      
            do_command = 1;
         }
            tmp = strtoll(optarg, NULL, 16);
            seq = (uint8_t)tmp;
        
        break;
      case 'w':
      if ( type == 0 )
        {
        do_receive = 0;
        do_server = 0;
        do_command = 2;
        command = strtoll(optarg, NULL, 16);
        }
        break;
      case 't':
        tmp = strtoll(optarg, NULL, 10);
        radiomode = (uint8_t)tmp;
        break;
      case '?':
        if (type == 0 ) {
        if(optopt == 'n' || optopt == 'p' || optopt == 'q' || 
           optopt == 'r' || optopt == 'c' || optopt == 'b' ||
           optopt == 'k' || optopt == 'w'|| optopt == 't'){
          fprintf(stderr, "Option -%c requires an argument.\n", optopt);
        }
        else if(isprint(optopt)){
          fprintf(stderr, "Unknown option `-%c'.\n", optopt);
        }
        else{
          fprintf(stderr, "Unknown option character `\\x%x'.\n", optopt);
        }
        exit(1);
        }
      default:
        fprintf(stderr, "Error parsing options");
        exit(-1);
    }
  }     
}
}

void resetVars()
{
  do_receive = 0;
  do_command = 0;

  prefix   = 0xB8;
  rem_p    = 0x00;
  remote   = 0x01;
  color    = 0x00;
  bright   = 0x00;
  key      = 0x01;
  seq      = 0x00;
  resends  =   10;

  command = 0x00;
}

int getCommandListSize()
{
    int z;
    commandListMutex.lock();
    z = commandList.size();
    commandListMutex.unlock();
    return z; 
}

void addCommand(std::string str)
{;
    // add command string to bottom element of list
    commandListMutex.lock();
    commandList.push_back (str);
    commandListMutex.unlock();
    return; 
}

std::string getCommand()
{
    // returns the first command sting element in the list
    
    std::string str;
    commandListMutex.lock();
    str = commandList.front();
    commandListMutex.unlock();
    return str;
}


void removeCommand()
{
    // removes the first command string element from the listlong long c;
    commandListMutex.lock();
    commandList.pop_front();
    commandListMutex.unlock();
	return;     
}

std::string Vector2String(std::vector<std::string> vec)
{
    std::stringstream ss;
    for(size_t i = 0; i < vec.size(); ++i)
    {
        if(i != 0)
            ss << ",";
        ss << vec[i];
    }
    return ss.str();
}

std::vector<std::string> String2Vector (std::string vecstring)
{
    std::string str = vecstring;
    std::string delimiter = ",";
    std::vector<std::string> vec;
    size_t pos = 0;
    std::string token;

    while ((pos = str.find(delimiter)) != std::string::npos) {
        token = str.substr(0, pos);
        vec.push_back( token );
        str.erase(0, pos + delimiter.length());
    }
    vec.push_back( str );
    return vec;    
}

std::string getTime()
{
    timeval curTime;
    time_t now;
    time(&now);
    
    gettimeofday(&curTime, NULL);
    int milli = curTime.tv_usec / 1000;

    char buf[sizeof "2011-10-08T07:07:09"];
    strftime(buf, sizeof buf, "%FT%T", gmtime(&now));
    
    sprintf(buf, "%s.%dZ", buf, milli);
    return buf;
}


std::string createJSON(std::string add1, std::string add2, std::string data, std::string config)
{                                    
    std::string output;
    output = "{\n \"Command\": \"Issue\",\n \"DateTime\": \"" + getTime() + "\",\n ";
    output = output + "\"Address1\": \"" + add1 + "\",\n ";
    output = output + "\"Address2\": \"" + add2 + "\",\n ";
    output = output + "\"Data\": \"" + data + "\",\n ";
    output = output + "\"Configuration\": {\n " + config + " }\n}";
    return output;
}

void send(uint8_t data[8])
{
  int ret = mlr.setRadioMode(radiomode);
  
  if(ret < 0)
  {
      fprintf(stderr, "Failed to open connection to the 2.4GHz module.\n");
      fprintf(stderr, "Make sure to run this program as root (sudo)\n\n");
      usage(all_args.front().c_str(), options);
      exit(-1);
  }
  
  static uint8_t seq = 1;
  char sendDATA[50];
  char tdata[50];

  uint8_t resends = data[7];
  if(data[6] == 0x00){
    data[6] = seq;
    seq++;
  }

  sprintf(sendDATA, "%02X %02X %02X %02X %02X %02X %02X ", data[0], data[1], data[2], data[3], data[4], data[5], data[6]);
  consoleWrite(strConcat("2.4GHz --> Sending: ", sendDATA));
  JSONfilewrite(strConcat("2.4GHz --> Sending: ", sendDATA));
  if(radiomode == 1) {
	sprintf(tdata, "Color Mode: Color - Resends: %d\n", resends);
  } else {
  sprintf(tdata, "Color Mode: White - Resends: %d\n", resends);
  }
  
  consoleWrite(tdata);
  JSONfilewrite(tdata);
  
  mlr.write(data, 7);
    
  for(int i = 0; i < resends; i++){
    mlr.resend();
  }
}

void send(uint64_t v)
{
  uint8_t data[8];
  data[7] = (v >> (7*8)) & 0xFF;
  data[0] = (v >> (6*8)) & 0xFF;
  data[1] = (v >> (5*8)) & 0xFF;
  data[2] = (v >> (4*8)) & 0xFF;
  data[3] = (v >> (3*8)) & 0xFF;
  data[4] = (v >> (2*8)) & 0xFF;
  data[5] = (v >> (1*8)) & 0xFF;
  data[6] = (v >> (0*8)) & 0xFF;

  send(data);
}

void send(uint8_t color, uint8_t bright, uint8_t key,
          uint8_t remote = 0x01, uint8_t remote_prefix = 0x00,
	  uint8_t prefix = 0xB8, uint8_t seq = 0x00, uint8_t resends = 10)
{
  
  uint8_t data[8];
  data[0] = prefix;
  data[1] = remote_prefix;
  data[2] = remote;
  data[3] = color;
  data[4] = bright;
  data[5] = key;
  data[6] = seq;
  data[7] = resends;

  send(data);
}


void receive()
{
    printf("Receiving mode, press Ctrl-C to end\n");
    while(1){
        // check if there are any new messages to send! 
        if(getCommandListSize() == 0)
		{
			char data[50];
			radiomode = 1;
			int ret = mlr.setRadioMode(radiomode);
  
			if(ret < 0)
			{
				fprintf(stderr, "Failed to open connection to the 2.4GHz module.\n");
				fprintf(stderr, "Make sure to run this program as root (sudo)\n\n");
				usage(all_args.front().c_str(), options);
				exit(-1);
			}
             
			if(mlr.available()) {
                uint8_t packet[7];
                size_t packet_length = sizeof(packet);
                mlr.read(packet, packet_length);
                if (packet[5] > 0) 
                {
                    sprintf(data, "%02X %02X %02X %02X %02X %02X %02X", packet[0], packet[1], packet[2], packet[3], packet[4], packet[5], packet[6]);
                    std::string output = createJSON(int2hex(packet[1]), int2hex(packet[2]), data, MiLightCypher.getRadioAtomikJSON(packet[5], packet[3], packet[4]));
                    JSONfilewrite(output);
                    
                    consoleWrite(output);
                    
                    // Run Command Temporary
                    char commandOUT[100];
                    sprintf(commandOUT, "/var/working/atomik_controller/transceiver -p %02X -q 43 -r 1d -c %02X -b %02X -k %02X -v %02X -t %d -n 99", packet[0], packet[3], packet[4], packet[5], packet[6], radiomode);
                     system(commandOUT);
                    
                } else {
                   // printf("0");
                }
            }
            
            int dupesReceived = mlr.dupesReceived();
            for (; dupesPrinted < dupesReceived; dupesPrinted++) {
               // printf(".");
            }
           // fflush(stdout);
       
        } else {
        
            std::string comandSTR = getCommand();     
			if (debug) {			
				consoleWrite(strConcat("Command Processed: ", comandSTR));
			}
            getOptions(String2Vector(comandSTR), 1);
            
			send(color, bright, key, remote, rem_p, prefix, seq, resends);
            
			removeCommand();
            resetVars();
        }
    }
}


void socketConnect(int type , std::string data)
{
    int sock;
    struct sockaddr_in server;
    char serverData[256];
    
    int ty = type;
    if (debug) 
	{			
		consoleWrite(strConcat("Socket Connect Data: ", data));
	}
    
    //Create socket
    sock = socket(AF_INET , SOCK_STREAM , 0);
    if (sock == -1)
    {
        
    }
	if (debug) 
	{
		consoleWrite("Socket Created"); 
    }
    server.sin_addr.s_addr = inet_addr("127.0.0.1");
    server.sin_family = AF_INET;
    server.sin_port = htons( socketPort );
 
    //Connect to remote server
    if (connect(sock , (struct sockaddr *)&server , sizeof(server)) < 0)
    {
        perror("connect failed. Error");
        alreadyRunning = 0;
        return;
    }
    if (debug) 
	{
		consoleWrite("Connected"); 
	}
     
    //keep communicating with server
    while(1)
    {
        bzero(serverData, 256);
        
        //Receive a reply from the server
        if( recv(sock , serverData , 256 , 0) < 0)
        {
            consoleWrite("Receive Failed"); 
            break;
        }
               
        std::string sData(serverData);
                                 
        if (ty == 1)
        {	
			if (debug) 
			{
				consoleWrite(strConcat("Sending Arg String: ", Vector2String(all_args)));
			}
            if( send(sock , Vector2String(all_args).c_str() , strlen(Vector2String(all_args).c_str()) , 0) < 0)
            {
                perror("Send to Atomik Transceiver Failed.");
                exit(1);
            }
        } 
        
        if (debug) 
		{
			consoleWrite(sData);
        }
        
        if( sData.find("Atomik") != std::string::npos )
        {
            if (debug) 
			{
				consoleWrite("Atomik Server already Running!");
            }
			alreadyRunning = 1;
        } else {
            perror("Atomik Transceiver Socket Busy.");
            exit(1);
        }
        
        break;
    }
     
    close(sock);
}


void socketCommand ( std::atomic<bool> & quit )
{

    int opt = 1;
    int master_socket , addrlen , new_socket , client_socket[5] , max_clients = 5 , activity, i , valread , sd;
    int max_sd;
    struct sockaddr_in address;
    struct timeval tv;
      
    char buffer[1025];  //data buffer of 1K
      
    //set of socket descriptors
    fd_set readfds;
      
    std::string welcomMessage = "Atomik Tranceiver V0.5 alpha";
  
    //initialise all client_socket[] to 0 so not checked
    for (i = 0; i < max_clients; i++) 
    {
        client_socket[i] = 0;
    }
      
    //create a master socket
    if( (master_socket = socket(AF_INET , SOCK_STREAM , 0)) == 0) 
    {
        perror("socket failed");
        exit(EXIT_FAILURE);
    }
  
    //set master socket to allow multiple connections , this is just a good habit, it will work without this
    if( setsockopt(master_socket, SOL_SOCKET, SO_REUSEADDR, (char *)&opt, sizeof(opt)) < 0 )
    {
        perror("setsockopt");
        exit(EXIT_FAILURE);
    }
  
    //type of socket created
    address.sin_family = AF_INET;
    address.sin_addr.s_addr = INADDR_ANY;
    address.sin_port = htons( socketPort );
      
    //bind the socket to localhost 
    if (bind(master_socket, (struct sockaddr *)&address, sizeof(address))<0) 
    {
        perror("bind failed");
        exit(EXIT_FAILURE);
    }
	if (debug) {
		char listninSTR[50];
		sprintf(listninSTR, "Listener on port %d \n", socketPort);
		consoleWrite(listninSTR);
    }
    
     
    //try to specify maximum of 3 pending connections for the master socket
    if (listen(master_socket, 3) < 0)
    {
        perror("listen");
        exit(EXIT_FAILURE);
    }
      
    //accept the incoming connection
    addrlen = sizeof(address);
    if (debug) {
		consoleWrite("Waiting for connections ...");
    }
	
    while(!quit) 
    {
        // reset the time value for select timeout
        tv.tv_sec = 0;
        tv.tv_usec = 1000 * 1000;
   
        //clear the socket set
        FD_ZERO(&readfds);
  
        //add master socket to set
        FD_SET(master_socket, &readfds);
        max_sd = master_socket;
         
        //add child sockets to set
        for ( i = 0 ; i < max_clients ; i++) 
        {
            //socket descriptor
            sd = client_socket[i];
             
            //if valid socket descriptor then add to read list
            if(sd > 0)
                FD_SET( sd , &readfds);
             
            //highest file descriptor number, need it for the select function
            if(sd > max_sd)
                max_sd = sd;
        }
  
        //wait for an activity on one of the sockets , timeout is NULL , so wait indefinitely
        activity = select( max_sd + 1 , &readfds , NULL , NULL , &tv);
    
        if ((activity < 0) && (errno!=EINTR)) 
        {
            consoleWrite("Select Error");
        }
          
        //If something happened on the master socket , then its an incoming connection
        if (FD_ISSET(master_socket, &readfds)) 
        {
            if ((new_socket = accept(master_socket, (struct sockaddr *)&address, (socklen_t*)&addrlen))<0)
            {
                perror("accept");
                exit(EXIT_FAILURE);
            }
            
            char outputchar[100];
            //inform user of socket number - used in send and receive commands
            sprintf(outputchar, "New connection , socket fd is %d , ip is : %s , port : %d \n" , new_socket , inet_ntoa(address.sin_addr) , ntohs(address.sin_port));
            
           //send new connection greeting message
            if( send(new_socket, welcomMessage.c_str(), strlen(welcomMessage.c_str()), 0) != strlen(welcomMessage.c_str()) ) 
            {
                perror("send");
            }
              if (debug) {
				consoleWrite("Welcome message sent successfully");
			  }
             
            //add new socket to array of sockets
            for (i = 0; i < max_clients; i++) 
            {
                //if position is empty
                if( client_socket[i] == 0 )
                {
                    client_socket[i] = new_socket;
                    char txtsocket[50];
                    sprintf(txtsocket, "Adding to list of sockets as %d\n" , i);
					if (debug) {                    
						consoleWrite(txtsocket);
					}
					break;
                }
            }
        }
          
        //else its some IO operation on some other socket :)
        for (i = 0; i < max_clients; i++) 
        {
            sd = client_socket[i];
              
            if (FD_ISSET( sd , &readfds)) 
            {
                //Check if it was for closing , and also read the incoming message
                if ((valread = read( sd , buffer, 1024)) == 0)
                {
                    //Somebody disconnected , get his details and print
                    getpeername(sd , (struct sockaddr*)&address , (socklen_t*)&addrlen);
                    if (debug) 
                    {
                        char debugtxt[100];
                         sprintf(debugtxt, "Host disconnected , ip %s , port %d " , inet_ntoa(address.sin_addr) , ntohs(address.sin_port));
                         consoleWrite(debugtxt);
                    } 
                    
                    //Close the socket and mark as 0 in list for reuse
                    close( sd );
                    client_socket[i] = 0;
                }
                  
                //Echo back the message that came in
                else
                {
                    //set the string terminating NULL byte on the end of the data read
                    buffer[valread] = '\0';
                    send(sd , buffer , strlen(buffer) , 0 );
                    std::string commandSTR (buffer);
                    addCommand(commandSTR);
                    if (debug) 
                    {
                        consoleWrite(strConcat("Socket Server Receiving Command: ", commandSTR));
                    }
                    
                    if(commandSTR.find ("\n"))
                    {
                      getpeername(sd , (struct sockaddr*)&address , (socklen_t*)&addrlen);
                      if (debug) {
                          char debugtxt[100];
                          sprintf(debugtxt, "Host disconnected , ip %s , port %d " , inet_ntoa(address.sin_addr) , ntohs(address.sin_port));
                          consoleWrite(debugtxt);
                      }
                      close( sd );
                      client_socket[i] = 0;
                    }
                    
                }
            }
        }
    }
      
}

int main(int argc, char** argv)
{
    
    all_args = std::vector<std::string>(argv, argv + argc);
    
    do_receive = 1;
    do_server = 1;
    
    getOptions(all_args, 0);
    
    if (debug) 
    {
        char argstrout[100];
        sprintf(argstrout, "Arg String: %s", Vector2String(all_args).c_str());
        consoleWrite(argstrout);
    }
    
    
    
    if(do_server) 
    {
        socketConnect(0,"");
        if(alreadyRunning) 
        { 
           perror("Atomik Transceiver Already Running!");
           exit(1);
        }
       
        disableSocket = false;
        socketServerThread = std::thread(socketCommand, std::ref(disableSocket));
    }
  
    if(do_receive)
    {
        
        receive();
    }
 
    if(do_command>0)
    {
        socketConnect(0, "");
        if(alreadyRunning) { 
            socketConnect(1, Vector2String(all_args));
             exit(1);
        } 
        
        if (do_command==2) 
        {
            send(command);
        } else {
            send(color, bright, key, remote, rem_p, prefix, seq, resends);
        }
       
    }
   
    if(do_server) 
    {
        disableSocket = true;
        socketServerThread.join();
    }
    
    return 0;
}