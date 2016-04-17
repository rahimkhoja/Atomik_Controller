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

#include "PL1167_nRF24.h"
#include "MiLightRadio.h"

#include <pthread.h>

#include <atomic>

#include <algorithm> 

RF24 radio(RPI_V2_GPIO_P1_22, RPI_V2_GPIO_P1_24, BCM2835_SPI_SPEED_1MHZ);

PL1167_nRF24 prf(radio);
MiLightRadio mlr(prf);

static int debug = 0;

static int dupesPrinted = 0;

static std::list<std::string> commandList;

pthread_mutex_t commandList_mutex;

std::atomic<bool> disableSocket;

int do_receive = 0;
int do_command = 0;
int do_client = 0;

uint8_t prefix   = 0xB8;
uint8_t rem_p    = 0x00;
uint8_t remote   = 0x01;
  uint8_t color    = 0x00;
  uint8_t bright   = 0x00;
  uint8_t key      = 0x01;
  uint8_t seq      = 0x00;
  uint8_t resends  =   10;

  uint64_t command = 0x00;

  int c;

  uint64_t tmp;
  
  const char *options = "hdfslumn:p:q:r:c:b:k:v:w:";
  
  std::thread foo;
  
  int socketPort = 5000;

void resetVars()
{
int do_receive = 0;
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

void addCommand(std::string str)
{
    // add command string to bottom element of list
    pthread_mutex_lock(&commandList_mutex);
    commandList.push_front (str);
    pthread_mutex_unlock(&commandList_mutex);
    return; 
}

std::string getCommand()
{
    // returns the first command sting element in the list
    std::string str;
    pthread_mutex_lock(&commandList_mutex);
    str = commandList.front();
    pthread_mutex_unlock(&commandList_mutex);
    return str;
}

void removeCommand()
{
    // removes the first command string element from the listlong long c;
    pthread_mutex_lock(&commandList_mutex);
    commandList.pop_front();
    pthread_mutex_unlock(&commandList_mutex);
	return;     
}


void receive()
{

  while(1){
// check if there are any new messages to send! 
    if(mlr.available()) {
      printf("\n");
      uint8_t packet[7];
      size_t packet_length = sizeof(packet);
      mlr.read(packet, packet_length);

      for(size_t i = 0; i < packet_length; i++) {
        printf("%02X ", packet[i]);
        fflush(stdout);
      }
      
    }

    int dupesReceived = mlr.dupesReceived();
    for (; dupesPrinted < dupesReceived; dupesPrinted++) {
      printf(".");
    }
    fflush(stdout);
  } 
}







void send(uint8_t data[8])
{
  static uint8_t seq = 1;

  uint8_t resends = data[7];
  if(data[6] == 0x00){
    data[6] = seq;
    seq++;
  }

  if(debug){
    printf("2.4GHz --> Sending: ");
    for (int i = 0; i < 7; i++) {
      printf("%02X ", data[i]);
    }
    printf(" [x%d]\n", resends);
  }

  mlr.write(data, 7);
    
  for(int i = 0; i < resends; i++){
    mlr.resend();
  }
  resetVars();

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

void usage(const char *arg, const char *options){
  printf("\n");
  printf("Usage: sudo %s [%s]\n", arg, options);
  printf("\n");
  printf("   -h                       Show this help\n");
  printf("   -d                       Show debug output\n");
  printf("   -l                       Listening (receiving) mode\n");
  printf("   -n NN<dec>               Resends of the same message\n");
  printf("   -p PP<hex>               Prefix value (Disco Mode)\n");
  printf("   -q RR<hex>               First byte of the remote\n");
  printf("   -r RR<hex>               Second byte of the remote\n");
  printf("   -c CC<hex>               Color byte\n");
  printf("   -b BB<hex>               Brightness byte\n");
  printf("   -k KK<hex>               Key byte\n");
  printf("   -v SS<hex>               Sequence byte\n");
  printf("   -w SSPPRRRRCCBBKKNN<hex> Complete message to send\n");
  printf("\n");
}


int socketConnect(int type , std::string data)
{
    int sock;
    struct sockaddr_in server;
    char message[1000] , server_reply[2000];
     
    //Create socket
    sock = socket(AF_INET , SOCK_STREAM , 0);
    if (sock == -1)
    {
        printf("Could not create socket");
    }
    puts("Socket created");
     
    server.sin_addr.s_addr = inet_addr("127.0.0.1");
    server.sin_family = AF_INET;
    server.sin_port = htons( socketPort );
 
    //Connect to remote server
    if (connect(sock , (struct sockaddr *)&server , sizeof(server)) < 0)
    {
        perror("connect failed. Error");
        return 1;
    }
     
    puts("Connected\n");
     
    //keep communicating with server
    while(1)
    {
        //printf("Enter message : ");
        //scanf("%s" , message);
         
        //Send some data
        if( send(sock , message , strlen(message) , 0) < 0)
        {
            puts("Send failed");
            return 1;
        }
         
        //Receive a reply from the server
        if( recv(sock , server_reply , 2000 , 0) < 0)
        {
            puts("recv failed");
            break;
        }
         
        puts("Server reply :");
        puts(server_reply);
    }
     
    close(sock);
    return 0;
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
      
    //a message
    std::string message = "Atomik Tranceiver V0.5 alpha\r\n";
  
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
    printf("Listener on port %d \n", socketPort);
     
    //try to specify maximum of 3 pending connections for the master socket
    if (listen(master_socket, 3) < 0)
    {
        perror("listen");
        exit(EXIT_FAILURE);
    }
      
    //accept the incoming connection
    addrlen = sizeof(address);
    puts("Waiting for connections ...");
     
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
            printf("select error");
        }
          
        //If something happened on the master socket , then its an incoming connection
        if (FD_ISSET(master_socket, &readfds)) 
        {
            if ((new_socket = accept(master_socket, (struct sockaddr *)&address, (socklen_t*)&addrlen))<0)
            {
                perror("accept");
                exit(EXIT_FAILURE);
            }
          
            //inform user of socket number - used in send and receive commands
            printf("New connection , socket fd is %d , ip is : %s , port : %d \n" , new_socket , inet_ntoa(address.sin_addr) , ntohs(address.sin_port));
        
            //send new connection greeting message
            if( send(new_socket, message.c_str(), strlen(message.c_str()), 0) != strlen(message.c_str()) ) 
            {
                perror("send");
            }
              
            puts("Welcome message sent successfully");
              
            //add new socket to array of sockets
            for (i = 0; i < max_clients; i++) 
            {
                //if position is empty
                if( client_socket[i] == 0 )
                {
                    client_socket[i] = new_socket;
                    printf("Adding to list of sockets as %d\n" , i);
                     
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
                    printf("\nHost disconnected , ip %s , port %d \n" , inet_ntoa(address.sin_addr) , ntohs(address.sin_port));
                      
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
                    if(commandSTR.find ("\n"))
                    {
                      getpeername(sd , (struct sockaddr*)&address , (socklen_t*)&addrlen);
                      printf("\nHost disconnected , ip %s , port %d \n" , inet_ntoa(address.sin_addr) , ntohs(address.sin_port));
                      close( sd );
                      client_socket[i] = 0;
                    }
                    
                }
            }
        }
    }
      
}


int getOptions(std::vector<std::string>& args)
{
    std::vector<const char *> argv(args.size());
    std::transform(args.begin(), args.end(), argv.begin(), [](std::string& str){
        return str.c_str();});
        
    while((c = getopt(argv.size(), const_cast<char**>(argv.data()), options)) != -1){
    switch(c){
      case 'h':
        usage(argv[0], options);
        exit(0);
        break;
      case 'd':
        debug = 1;
        break;
      case 'l':
        do_receive = 1;
       break;
      case 'n':
        tmp = strtoll(optarg, NULL, 10);
        resends = (uint8_t)tmp;
        break;
      case 'p':
        tmp = strtoll(optarg, NULL, 16);
        prefix = (uint8_t)tmp;
        break;
      case 'q':
        tmp = strtoll(optarg, NULL, 16);
        rem_p = (uint8_t)tmp;
        break;
      case 'r':
        tmp = strtoll(optarg, NULL, 16);
        remote = (uint8_t)tmp;
        break;
      case 'c':
        tmp = strtoll(optarg, NULL, 16);
        color = (uint8_t)tmp;
        break;
      case 'b':
        tmp = strtoll(optarg, NULL, 16);
        bright = (uint8_t)tmp;
        break;
      case 'k':
        tmp = strtoll(optarg, NULL, 16);
        key = (uint8_t)tmp;
        break;
      case 'v':
        tmp = strtoll(optarg, NULL, 16);
        seq = (uint8_t)tmp;
        break;
      case 'w':
        do_command = 1;
        command = strtoll(optarg, NULL, 16);
        break;
      case 'z':
        do_client = 1;
        break;
      case '?':
        if(optopt == 'n' || optopt == 'p' || optopt == 'q' || 
           optopt == 'r' || optopt == 'c' || optopt == 'b' ||
           optopt == 'k' || optopt == 'w'|| optopt == 'z'){
          fprintf(stderr, "Option -%c requires an argument.\n", optopt);
        }
        else if(isprint(optopt)){
          fprintf(stderr, "Unknown option `-%c'.\n", optopt);
        }
        else{
          fprintf(stderr, "Unknown option character `\\x%x'.\n", optopt);
        }
        return 1;
      default:
        fprintf(stderr, "Error parsing options");
        disableSocket = true;
        foo.join();
        return -1;
    }
  }
    
    
}



int main(int argc, char** argv)
{
  

  disableSocket = false;
  foo = std::thread(socketCommand, std::ref(disableSocket));
    
  std::vector<std::string> all_args;
  all_args = std::vector<std::string>(argv, argv + argc);
  
 
  
/**
  //while((c = getopt(argc, argv, options)) != -1){
  while((c = getopt(intargs, all_args.size(), options)) != -1){
    switch(c){
      case 'h':
        usage(argv[0], options);
        exit(0);
        break;
      case 'd':
        debug = 1;
        break;
      case 'l':
        do_receive = 1;
       break;
      case 'n':
        tmp = strtoll(optarg, NULL, 10);
        resends = (uint8_t)tmp;
        break;
      case 'p':
        tmp = strtoll(optarg, NULL, 16);
        prefix = (uint8_t)tmp;
        break;
      case 'q':
        tmp = strtoll(optarg, NULL, 16);
        rem_p = (uint8_t)tmp;
        break;
      case 'r':
        tmp = strtoll(optarg, NULL, 16);
        remote = (uint8_t)tmp;
        break;
      case 'c':
        tmp = strtoll(optarg, NULL, 16);
        color = (uint8_t)tmp;
        break;
      case 'b':
        tmp = strtoll(optarg, NULL, 16);
        bright = (uint8_t)tmp;
        break;
      case 'k':
        tmp = strtoll(optarg, NULL, 16);
        key = (uint8_t)tmp;
        break;
      case 'v':
        tmp = strtoll(optarg, NULL, 16);
        seq = (uint8_t)tmp;
        break;
      case 'w':
        do_command = 1;
        command = strtoll(optarg, NULL, 16);
        break;
      case '?':
        if(optopt == 'n' || optopt == 'p' || optopt == 'q' || 
           optopt == 'r' || optopt == 'c' || optopt == 'b' ||
           optopt == 'k' || optopt == 'w'){
          fprintf(stderr, "Option -%c requires an argument.\n", optopt);
        }
        else if(isprint(optopt)){
          fprintf(stderr, "Unknown option `-%c'.\n", optopt);
        }
        else{
          fprintf(stderr, "Unknown option character `\\x%x'.\n", optopt);
        }
        return 1;
      default:
        fprintf(stderr, "Error parsing options");
        disableSocket = true;
        foo.join();
        return -1;
    }
  }
**/
  int test = getOptions(all_args);

  int ret = mlr.begin();

  if(ret < 0){
    fprintf(stderr, "Failed to open connection to the 2.4GHz module.\n");
    fprintf(stderr, "Make sure to run this program as root (sudo)\n\n");
    usage(argv[0], options);
    exit(-1);
  }
  if(do_client) {
     printf("Clinet Mode\n");
     socketConnect(0,"");
  }


  if(do_receive){
    printf("Receiving mode, press Ctrl-C to end\n");
    receive();
  }
 
  if(do_command){
    send(command);
  }
  else{
    send(color, bright, key, remote, rem_p, prefix, seq, resends);
  }
disableSocket = true;
        foo.join();
  return 0;
}
