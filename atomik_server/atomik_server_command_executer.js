// Atomik Server - System Command Executor
// atomik_server_command_executer.js
// By Rahim Khoja

// Executes incomming commands on the system

var express = require('express');
var bodyParser = require('body-parser');
var async = require('async');
var exec = require('child_process').exec;

var app = express();

var VERSION = 0.8;

var PORT = 42001;

function atomikTransmitCMD(type, address1, address2, color, bright, tran, command ) {
  async.series([ 
    execFn('/usr/bin/transceiver' + ' -t ' + type + ' -q ' + address1.toString(16)+' -r '+address2.toString(16)+' -c '+color.toString(16)+' -b '+bright.toString(16)+' -v '+trans.toString(16)+' -k '+command.toString(16), '/usr/atomik/')
  ]);
}

var execFn = function(cmd, dir) {
  return function(cb) {
    console.log('EXECUTING: '+ cmd);
    exec(cmd, { cwd: dir }, function() { cb(); });
  }
}

app.use(bodyParser());

app.use(bodyParser.urlencoded({     // to support URL-encoded bodies
  extended: true
})); 

app.post('/atomikexec', function (req, res) {
 res.send('ok!\n');  
 console.log('Sending Data:');
 console.log(req.body);
 
});

app.listen(PORT, function () {
  console.log('Atomik Server - System Command Executor - Version '+VERSION);
  console.log('Listening for Atomik JSON Data (Port: ' + PORT + ') : ( press ctrl-c to end )');
});