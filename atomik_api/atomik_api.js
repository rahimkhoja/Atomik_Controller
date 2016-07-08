var express = require('express');
var bodyParser = require('body-parser');
var mysql = require('mysql')
var fs = require('fs');
var async = require('async');
var exec = require('child_process').exec;
var system_timezone = require('system-timezone');
var request = require('request');

var pool      =    mysql.createPool({
    connectionLimit : 2, //important
    host     : 'localhost',
    user     : 'root',
    password : 'raspberry',
    database : 'atomik_controller',
    debug    :  false
});

connection.connect(function (err){
  if(!err) {
      console.log("Database is connected ... \n\n");  
  } else {
      console.log("Error connecting to the Database ... \n\n");  
  }
}); 

var app = express();

var PORT = 4200;

function log(processed, source, channel, data, status, colormode, color, whitetemp, bright, ip, mac) {

  var sql = 'INSERT INTO atomik_commands_received (command_received_source_type, command_received_channel_id, command_received_date, command_received_data, command_received_status, command_received_color_mode, command_received_rgb256, command_received_white_temprature, command_received_brightness, command_received_processed, command_received_MAC, command_received_IP) VALUES ("Emulator", '+cha+', "'+date+'", "'+rec_data+'", '+sta+', '+cm+', '+col+', '+wt+', '+bri+', 0, "'+mac+'", "'+ip+'")'; 
 
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
    
  var sql = "SELECT atomik_zones.zone_name, atomik_zones.zone_status, atomik_zones.zone_colormode, atomik_zones.zone_brightness, atomik_zones.zone_rgb256, atomik_zones.zone_white_temprature, atomik_zone_remotes.zone_remote_channel_number FROM atomik_zones, atomik_remotes, atomik_zone_remotes WHERE atomik_zones.zone_id=atomik_zone_remotes.zone_remote_zone_id && atomik_zone_remotes.zone_remote_remote_id=atomik_remotes.remote_id && atomik_remotes.remote_user="+JSON.body.User+" && atomik_remotes.remote_password="+JSON.body.Password+";";
  	 
  console.log(sql);
    
  pool.getConnection(function(err,connection){
    if (err) {
        connection.release();
        console.log('{"code" : 100, "status" : "Error in connection database"}');
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
  
  var sql = "SELECT atomik_zones.zone_name, atomik_zones.zone_status, atomik_zones.zone_colormode, atomik_zones.zone_brightness, atomik_zones.zone_rgb256, atomik_zones.zone_white_temprature, atomik_zone_remotes.zone_remote_channel_number FROM atomik_zones, atomik_remotes, atomik_zone_remotes WHERE atomik_zones.zone_id=atomik_zone_remotes.zone_remote_zone_id && atomik_zone_remotes.zone_remote_remote_id=atomik_remotes.remote_id && atomik_remotes.remote_user=\""+JSON.body.User+"\" && atomik_remotes.remote_password=\""+JSON.body.Password+"\" && atomik_zone_remotes.zone_remote_channel_number="+JSON.body.Configuration.Channel+";";
  
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
         log
         execute
         getListJSON(JSON, Response);
         
      } else {
         getErrorJSON("Invalid Username or Password", Response);
         return;
      }
	});
   
   
   
  
  
  
 

function getErrorJSON(error, Response) {
  var errorJSON = "{\"Error\": \""+error+"\"}";
  Response.setHeader('Content-Type', 'application/json');
  Response.send(errorJSON);
}


 
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

function ColBrightnessPercent2Value(percent) {
	if (percent >= 4) {
		return 129;
	} else if (percent >= 8) {
		return 121;
	} else if (percent >= 12) {
		return 113;
	} else if (percent >= 15) {
		return 105;
	} else if (percent >= 19) {
		return 97;
	} else if (percent >= 23) {
		return 89;
	} else if (percent >= 27) {
		return 81;
	} else if (percent >= 31) {
		return 73;
	} else if (percent >= 35) {
		return 65;
	} else if (percent >= 39) {
		return 57;
	} else if (percent >= 42) {
		return 49;
	} else if (percent >= 46) {
		return 41;
	} else if (percent >= 50) {
		return 33;
	} else if (percent >= 54) {
		return 25;
	} else if (percent >= 58) {
		return 17;
	} else if (percent >= 62) {
		return 9;
	} else if (percent >= 65) {
		return 1;
	} else if (percent >= 69) {
		return 249;
	} else if (percent >= 73) {
		return 241;
	} else if (percent >= 77) {
		return 233;
	} else if (percent >= 81) {
		return 225;
	} else if (percent >= 85) {
		return 217;
	} else if (percent >= 88) {
		return 209;
	} else if (percent >= 92) {
		return 201;
	} else if (percent >= 96) {
		return 193;
	} else if (percent >= 100) {
		return 185;
	}
}


function array_search(needle, haystack) {
    for(var i in haystack) {
        if(haystack[i] == needle) return i;
    }
    return false;
}


function increaseTrans(tra) {
	trans = tra + 1;
    if ( trans >= 256 ) {
		trans = trans - 256;
    }
	return trans;

}

function updateZone(req, zoneID) {
    console.log('Running -- updatezone');

    var zoneID = zoneID;
    var req = req;
    var sql = "SELECT atomik_devices.device_id, atomik_devices.device_status, atomik_devices.device_colormode, atomik_devices.device_brightness, atomik_devices.device_rgb256, atomik_devices.device_white_temprature, atomik_devices.device_address1, atomik_devices.device_address2, atomik_device_types.device_type_rgb256, atomik_device_types.device_type_warm_white, atomik_device_types.device_type_cold_white, atomik_devices.device_transmission, atomik_zone_devices.zone_device_zone_id FROM atomik_zone_devices, atomik_device_types, atomik_devices WHERE atomik_zone_devices.zone_device_zone_id=" + zoneID + " && atomik_zone_devices.zone_device_device_id=atomik_devices.device_id && atomik_devices.device_type=atomik_device_types.device_type_id && atomik_device_types.device_type_brightness=1;";

    pool.getConnection(function(err, connection) {
        if (err) {
            connection.release();
            console.log('{"code" : 100, "status" : "Error in connection database"}');
            return;
        }

        console.log('connected as id ' + connection.threadId);
        connection.query(sql, function(err, rows) {

            console.log('SQL inside: ' + sql);
            connection.release();
            if (err) throw err;

            if (rows.length > 0) {
                if (rows) {
                    for (var i = 0; i < rows.length; i++) {

                        if (typeof req.body.Configuration.Status == 'undefined') {
                            sta = rows[i].device_status;
                        } else if (req.body.Configuration.Status == "On") {
                            sta = 1;
                        } else if (req.body.Configuration.Status == "Off") {
                            sta = 0;
                        } else {
                            sta = '"' + req.body.Configuration.Status + '"';
                        }

                        if (typeof req.body.Configuration.ColorMode == 'undefined') {
                            cm = rows[i].device_colormode;
                        } else if (req.body.Configuration.ColorMode == "RGB256") {
                            cm = 0;
                        } else if (req.body.Configuration.ColorMode == "White") {
                            cm = 1;
                        }

                        if (typeof req.body.Configuration.Color == 'undefined') {
                            col = rows[i].device_rgb256;
                        } else {
                            col = req.body.Configuration.Color;
                        }

                        if (typeof req.body.Configuration.WhiteTemp == 'undefined') {
                            wt = rows[i].device_white_temprature;
                        } else {
                            wt = req.body.Configuration.WhiteTemp;
                        }

                        if (typeof req.body.Configuration.Brightness == 'undefined') {
                            bri = rows[i].device_brightness;
                        } else {
                            bri = req.body.Configuration.Brightness;
                        }
                        console.log('Transmit Address: ' + rows[i].device_address1 + ' (' + parseInt(rows[i].device_address1, 16) + ') ' + rows[i].device_address2 + ' (' + parseInt(rows[i].device_address2, 16) + ')');
                        traNumber = transmit(bri, rows[i].device_brightness, sta, rows[i].device_status, col, rows[i].device_rgb256, wt, rows[i].device_white_temprature, cm, rows[i].device_colormode, rows[i].device_address1, rows[i].device_address2, rows[i].device_transmission, rows[i].device_type_rgb256, rows[i].device_type_cold_white, rows[i].device_type_warm_white);

                        updateDevice(sta, cm, bri, col, wt, traNumber, rows[i].device_id);
                    }
                    lastUpdate_ZoneDevice(zoneID);
                    lastUpdate_Zone(zoneID);
                }
            }
        });

        connection.on('error', function(err) {
            console.log('{"code" : 100, "status" : "Error in connection database"}');
            return;
        });
    });
}


function validRFAddressCheck( add1, add2, callback ) {

	var sql = "SELECT atomik_zones.zone_id, atomik_zone_remotes.zone_remote_remote_id FROM atomik_zones, atomik_remotes, atomik_zone_remotes WHERE atomik_zones.zone_id=atomik_zone_remotes.zone_remote_zone_id && atomik_zone_remotes.zone_remote_remote_id=atomik_remotes.remote_id && atomik_remotes.remote_address1="+add1+" && atomik_remotes.remote_address2="+add2+";"; 
    console.log(sql);
	
	pool.getConnection(function(err,connection){
	  if (err) {
        connection.release();
        console.log('{"code" : 100, "status" : "Error in connection database"}');
        return;
      }   

      console.log('connected as id ' + connection.threadId);
      connection.query(sql,function(err,rows){
			
        connection.release();
        if (err) throw err;
   
        if ( rows.length > 0) {
          if ( rows ) {
            console.log("Valid RF Remote"); 
			callback(true);
          }
        } else {
			callback(false);
		}
      });

      connection.on('error', function(err) {      
        console.log('{"code" : 100, "status" : "Error in connection database"}');
        return;     
      });
	});
}

app.use(bodyParser.json());

app.use(bodyParser.urlencoded({     // to support URL-encoded bodies
  extended: true
}));  

app.post('/atomik', function (req, res) {
 res.send('ok!\n');  
 console.log('Atomik API JSON Data:');
 validateJSON(req.body);
 console.log(req.body);
 
 checkRFJSON ( req.body.Address1, req.body.Address2, req.body.Configuration.Channel, req );
});

app.listen(PORT, function () {
  console.log('Atomik Server - Version 0.80');
  console.log('Listening for Atomik JSON Data (Port: ' + PORT + ') : ( press ctrl-c to end )');
});
