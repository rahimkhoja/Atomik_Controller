var express = require('express');
var bodyParser = require('body-parser');
var mysql = require('mysql')
var fs = require('fs');
var async = require('async');
var exec = require('child_process').exec;
var request = require('request');

var pool      =    mysql.createPool({
    connectionLimit : 2, //important
    host     : 'localhost',
    user     : 'root',
    password : 'raspberry',
    database : 'atomik_controller',
    debug    :  false
});

var app = express();

var PORT = 4200;

function log(processed, source, channel, data, status, colormode, color, whitetemp, bright) {

  var sql = 'INSERT INTO atomik_commands_received (command_received_source_type, command_received_channel_id, command_received_date, command_received_data, command_received_status, command_received_color_mode, command_received_rgb256, command_received_white_temprature, command_received_brightness, command_received_processed) VALUES ("' + source + '", ' + channel + ', UTC_TIMESTAMP(6), "' + data + '", ' + status + ', ' + colormode + ', ' + color + ', ' + whitetemp + ', ' + bright + ', ' + processed + ');'; 
 
  pool.getConnection(function(err,connection){
    if (err) {
      connection.release();
      console.log('{"code" : 100, "status" : "Error in connection database"}');
      return;
    }   

    console.log('connected as id ' + connection.threadId);
    console.log('SQL inside: ' + sql);
    connection.query(sql,function(err,rows){
      connection.release();
      if (!err) {
        console.log('The solution is: ', rows);
      } else {
        console.log('Error while performing Query.');
      }
    });
 
    connection.on('error', function(err) {      
      console.log('{"code" : 100, "status" : "Error in connection database"}');
      return;     
    });
  });
} 


function processJSON( JSON, Response ){

  var command = JSON.body.Command;
  
  if (typeof  JSON.body.Command == 'undefined') {
    getErrorJSON("Invalid Data", Response);
    return;
  }

  if ( command == 'List' ) {
    getListJSON(JSON, Response);
    return;
  }

  if ( command == 'Issue' ) {
    setIssueJSON(JSON, Response);
    return;    
  }
}

function getListJSON( JSN, Res ) {

  var JSON = JSN;
  var Response = Res;

  if (typeof JSON.body.User == 'undefined') {
    getErrorJSON("Invalid Username or Password", Response);
    return;
  }
  
  if (typeof JSON.body.Password == 'undefined') {
    getErrorJSON("Invalid Username or Password", Response);
    return;
  }
    
  var sql = "SELECT atomik_zones.zone_name, atomik_zones.zone_status, atomik_zones.zone_colormode, atomik_zones.zone_brightness, atomik_zones.zone_rgb256, atomik_zones.zone_white_temprature, atomik_zone_remotes.zone_remote_channel_number FROM atomik_zones, atomik_remotes, atomik_zone_remotes WHERE atomik_zones.zone_id=atomik_zone_remotes.zone_remote_zone_id && atomik_zone_remotes.zone_remote_remote_id=atomik_remotes.remote_id && atomik_remotes.remote_user='"+JSON.body.User+"' && atomik_remotes.remote_password='"+JSON.body.Password+"';";
  	 
  console.log(sql);
    
  pool.getConnection(function(err,connection){
    if (err) {
        connection.release();
        console.log('{"code" : 100, "status" : "Error in connection database"}');
        getErrorJSON("DB Error", Response);
        return;
    }

    console.log('connected as id ' + connection.threadId);
    connection.query(sql,function(err,rows){
      connection.release();
      
      var responseLIST = "{";
      if (err) throw err;
   
      if ( rows.length > 0) {
       if ( rows ) {
         for (var i = 0; i < rows.length; i++) {
           responseLIST = responseLIST + "{ \"ZoneName\":\""+rows[i].zone_name+"\", \"Configuration\":{ \"Channel\":\""+rows[i].zone_remote_channel_number+"\", \"Status\":\""+rows[i].zone_status+"\", \"ColorMode\":\""+rows[i].zone_colomode+"\", \"Brightness\":\""+rows[i].zone_brightness+"\", \"Color\":\""+rows[i].zone_rgb256+"\", \"WhiteTemp\":\""+rows[i].zone_white_temprature+"\"} }\n";
         }
         responseLIST = responseLIST + "}";
         console.log("Sending List to User:"+JSON.body.User);
         console.log(responseLIST);         
       }
      } else {
         getErrorJSON("Invalid Username or Password", Response);
         return;
      }
	});
   
    connection.on('error', function(err) {      
      console.log('{"code" : 100, "status" : "Error in connection database"}');
      getErrorJSON("SQL Error", Response);
      return;     
    });
  });
}


function setIssueJSON(JSN, Res) {
  console.log('Running -- setIssueJSON');
  
  var JSON = JSN;
  var Response = Res;

  if (typeof JSON.body.User == 'undefined') {
    getErrorJSON("Invalid Username or Password", Response);
    return;
  }
  
  if (typeof JSON.body.Password == 'undefined') {
    getErrorJSON("Invalid Username or Password", Response);
    return;
  }
  
  if (typeof JSON.body.Configuration.Channel == 'undefined') {
    getErrorJSON("Invalid Username or Password", Response);
    return;
  }
  
  if (typeof JSON.body.Configuration.Status == 'undefined') {
    getErrorJSON("Invalid Command", Response);
    return;
  }
  
  if (typeof JSON.body.Configuration.Brightness == 'undefined') {
    getErrorJSON("Invalid Command", Response);
    return;
  }
  
  if (typeof JSON.body.Configuration.ColorMode == 'undefined') {
    getErrorJSON("Invalid Command", Response);
    return;
  }
  
  if (typeof JSON.body.Configuration.Color == 'undefined') {
    getErrorJSON("Invalid Command", Response);
    return;
  }
  
  if (typeof JSON.body.Configuration.WhiteTemp == 'undefined') {
    getErrorJSON("Invalid Command", Response);
    return;
  }
  
  var sql = "SELECT atomik_zones.zone_id atomik_zones.zone_name, atomik_zones.zone_status, atomik_zones.zone_colormode, atomik_zones.zone_brightness, atomik_zones.zone_rgb256, atomik_zones.zone_white_temprature, atomik_zone_remotes.zone_remote_channel_number FROM atomik_zones, atomik_remotes, atomik_zone_remotes WHERE atomik_zones.zone_id=atomik_zone_remotes.zone_remote_zone_id && atomik_zone_remotes.zone_remote_remote_id=atomik_remotes.remote_id && atomik_remotes.remote_user=\""+JSON.body.User+"\" && atomik_remotes.remote_password=\""+JSON.body.Password+"\" && atomik_zone_remotes.zone_remote_channel_number="+JSON.body.Configuration.Channel+";";
  
  console.log(sql);
    
  pool.getConnection(function(err,connection){
    if (err) {
        connection.release();
        console.log('{"code" : 100, "status" : "Error in connection database"}');
        getErrorJSON("DB Error", Response);
        return;
    }

    console.log('connected as id ' + connection.threadId);
    connection.query(sql,function(err,rows){
      connection.release();
      
      if (err) throw err;
   
      if ( rows.length > 0) {
         log(1, "Atomik API", JSON.body.Configuration.Channel, JSON, JSON.body.Configuration.Status, JSON.body.Configuration.ColorMode, JSON.body.Configuration.Color, JSON.body.Configuration.WhiteTemp, JSON.body.Configuration.Brightness)
         async.series([ 
          execFn('/usr/bin/atomik-zone-update '+row[0].zone_id+' '+row[0].zone_status+' '+row[0].zone_brightness+' '+row[0].zone_colormode+' '+row[0].zone_rgb256+' '+row[0].zone_white_temprature, '/usr/atomik/')
        ]);
         getListJSON(JSON, Response);
         
      } else {
         getErrorJSON("Invalid Username or Password", Response);
         return;
      }
	});
    connection.on('error', function(err) {      
      console.log('{"code" : 100, "status" : "Error in connection database"}');
      getErrorJSON("SQL Error", Response);
      return;     
    });
  });
}


function getErrorJSON(error, Response) {
  var errorJSON = "{\"Error\": \""+error+"\"}";
  Response.setHeader('Content-Type', 'application/json');
  Response.send(errorJSON);
}


var execFn = function(cmd, dir) {
  return function(cb) {
    console.log('EXECUTING: '+ cmd);
    exec(cmd, { cwd: dir }, function() { cb(); });
  }
}

app.use(bodyParser.json());

app.use(bodyParser.urlencoded({     // to support URL-encoded bodies
  extended: true
}));  

app.post('/atomik', function (req, res) { 
 console.log('Atomik API JSON Data:');
 console.log(req.body);
 processJSON(req, res);
});

app.listen(PORT, function () {
  console.log('Atomik Server - Version 0.80');
  console.log('Listening for Atomik JSON Data (Port: ' + PORT + ') : ( press ctrl-c to end )');
});
