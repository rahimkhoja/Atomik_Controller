// Atomik Server - System File Logger
// Node.js
// By Rahim Khoja

// Writes incomming text to a log file

var express = require('express');
var bodyParser = require('body-parser');
var fs = require('fs');

var app = express();

var VERSION = 0.8;

var PORT = 42002;

var LOGFILE = '/var/log/atomik/AtomikServerJSON.log';

function log2file(text) {
	fs.appendFile(LOGFILE, text+"\n", function (err) {
		if (err) throw err;
			console.log('Success!');
	});
}

app.use(bodyParser());

app.use(bodyParser.urlencoded({     // to support URL-encoded bodies
  extended: true
})); 

app.post('/atomiklog', function (req, res) {
 res.send('ok!\n');  
 console.log('Logging Data:');
 console.log(req.body);
 log2file(req.body);
 
});

app.listen(PORT, function () {
  console.log('Atomik Server - System File Logger - Version '+VERSION);
  console.log('Listening for Atomik JSON Data (Port: ' + PORT + ') : ( press ctrl-c to end )');
});