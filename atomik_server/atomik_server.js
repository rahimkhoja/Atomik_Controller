var express = require('express');
var bodyParser = require('body-parser');
var mysql = require('mysql')
var fs = require('fs');
var async = require('async');
var exec = require('child_process').exec;
var system_timezone = require('system-timezone');
var request = require('request');

var connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: 'raspberry',
  database: 'atomik_controller'
});

connection.connect(function (err){
  if(!err) {
      console.log("Database is connected ... \n\n");  
  } else {
      console.log("Error connecting to the Database ... \n\n");  
  }
}); 


function log2system(text) {
  request({
    url: 'http://localhost:42002/log', //URL to hit
    qs: {from: 'Atomik_Server', time: +new Date()}, //Query string data
    method: 'POST',
    headers: {
        'Content-Type': 'text/html',
        'Custom-Header': 'Atomik'
    },
    body: text //Set the body as a string
  }, function(error, response, body){
    if(error) {
        console.log(error);
    }
  });
};

var app = express();

var PORT = 4200;

function updateCurrentChannel( channel, remote_id ) {
  console.log('Running -- updateCurrentChannel');
  var sql = 'UPDATE atomik_remotes SET remote_current_channel = '+channel+' WHERE remote_id = '+remote_id+';'; 
  console.log(sql);
  connection.query(sql, function(err) {
   if (!err) {
     console.log('Channel Updated');
   } else {
     console.log('Error while performing Query.');
    }
  });
} 


function log_tra_no_execute(channel, date, rec_data, status, colormode, color, whitetemp, bright, add1, add2) {

  var sql = 'INSERT INTO atomik_commands_received (command_received_source_type, command_received_channel_id, command_received_date, command_received_data, command_received_status, command_received_color_mode, command_received_rgb256, command_received_white_temprature, command_received_brightness, command_received_processed, command_received_ADD1, command_received_ADD2) VALUES ("Radio", '+channel+', "'+date+'", "'+rec_data+'", '+status+', '+colormode+', '+color+', '+whitetemp+', '+bright+', 0, "'+add1+'", "'+add2+'")';

  console.log(sql);
  connection.query(sql, function(err, rows, fields) {
    if (!err) {
      console.log('The solution is: ', rows);
      log2system(sql);
    } else {
      console.log('Error while performing Query.');
    }
  });
}


function log_tra_execute(channel, date, rec_data, status, colormode, color, whitetemp, bright, add1, add2) {

  var sql = 'INSERT INTO atomik_commands_received (command_received_source_type, command_received_channel_id, command_received_date, command_received_data, command_received_status, command_received_color_mode, command_received_rgb256, command_received_white_temprature, command_received_brightness, command_received_processed, command_received_ADD1, command_received_ADD2) VALUES ("Radio", '+channel+', "'+date+'", "'+rec_data+'", '+status+', '+colormode+', '+color+', '+whitetemp+', '+bright+', 1, "'+add1+'", "'+add2+'")';

  console.log(sql);

  connection.query(sql, function(err, rows, fields) {
    if (!err) {
      console.log('The solution is: ', rows);
      log2system(sql);
    } else {
      console.log('Error while performing Query.');
    }
  });
}

function validRF(zoneID, req){
  console.log('Valid Command!:');
  console.log("Zone_ID: " + zoneID );
  updateZone(req, zoneID);
  if (typeof  req.body.Configuration.Channel == 'undefined') {
    cha = 'NULL';
  } else {
    cha = '"'+req.body.Configuration.Channel+'"';
  }

  if (typeof req.body.Configuration.Status == 'undefined') {
    sta = 'NULL';
  } else {
    sta = '"'+req.body.Configuration.Status+'"';
  }

  if (typeof req.body.Configuration.ColorMode == 'undefined') {
    cm = 'NULL';
  } else {
    cm = '"'+req.body.Configuration.ColorMode+'"';
  }

  if (typeof req.body.Configuration.Color == 'undefined') {
    col = 'NULL';
  } else {
    col = req.body.Configuration.Color;
  }

  if (typeof req.body.Configuration.WhiteTemp == 'undefined') {
    wt = 'NULL';
  } else {
    wt = req.body.Configuration.WhiteTemp;
  }

  if (typeof req.body.Configuration.Brightness == 'undefined') {
    bri = 'NULL';
  } else {
    bri = req.body.Configuration.Brightness;
  }
  log_tra_execute(cha, req.body.DateTime, req.body.Data, sta, cm, col, wt, bri, req.body.Address1, req.body.Address2);
}

function invalidRF(req){
  console.log('Invalid Command:');
  if (typeof  req.body.Configuration.Channel == 'undefined') {
    cha = 'NULL';
  } else {
    cha = '"'+req.body.Configuration.Channel+'"';
  }
  if (typeof req.body.Configuration.Status == 'undefined') {
    sta = 'NULL';
  } else {
    sta = '"'+req.body.Configuration.Status+'"';
  }

  if (typeof req.body.Configuration.ColorMode == 'undefined') {
    cm = 'NULL';
  } else {
    cm = '"'+req.body.Configuration.ColorMode+'"';
  }

  if (typeof req.body.Configuration.Color == 'undefined') {
    col = 'NULL';
  } else {
    col = req.body.Configuration.Color;
  }

  if (typeof req.body.Configuration.WhiteTemp == 'undefined') {
    wt = 'NULL';
  } else {
    wt = req.body.Configuration.WhiteTemp;
  }

  if (typeof req.body.Configuration.Brightness == 'undefined') {
    bri = 'NULL';
  } else {
    bri = req.body.Configuration.Brightness;
  }
  
  log_tra_no_execute(cha, req.body.DateTime, req.body.Data, sta, cm, col, wt, bri, req.body.Address1, req.body.Address2);
}

function checkRFJSON ( address1, address2, channel, req ) {
  
  var addint1 = parseInt(address1, 16);
  var addint2 = parseInt(address2, 16);
  
  if (typeof channel == 'undefined') {
    (function(req) {
    var sql = "SELECT atomik_zones.zone_id FROM atomik_zones, atomik_remotes, atomik_zone_remotes WHERE atomik_zones.zone_id = atomik_zone_remotes.zone_remote_zone_id && atomik_zone_remotes.zone_remote_remote_id = atomik_remotes.remote_id && atomik_remotes.remote_address1="+addint1+" && atomik_remotes.remote_address2="+addint2+" && atomik_remotes.remote_current_channel=atomik_zone_remotes.zone_remote_channel_number;";
    console.log(sql);
    
    connection.query(sql, function(err, rows ) {
    if (err) throw err;
   
      if ( rows.length > 0) {
        if ( rows ) {
          console.log("Valid Command");
          console.log("Row Zone_ID:" + rows[0].zone_id );
          validRF(rows[0].zone_id, req);
          
        }
      }  else {
        invalidRF(req);
      }
    });
    })(req);
    
  } else {
    (function(req) {
      var sql = "SELECT atomik_zones.zone_id, atomik_zone_remotes.zone_remote_remote_id FROM atomik_zones, atomik_remotes, atomik_zone_remotes WHERE atomik_zones.zone_id=atomik_zone_remotes.zone_remote_zone_id && atomik_zone_remotes.zone_remote_remote_id=atomik_remotes.remote_id && atomik_remotes.remote_address1="+addint1+" && atomik_remotes.remote_address2="+addint2+" && atomik_zone_remotes.zone_remote_channel_number="+parseInt(channel)+";"; 
      console.log(sql);
    
      connection.query(sql, function(err, rows ) {
        if (err) throw err;
 
        if ( rows.length > 0) {
          if (rows ) {
            console.log("Valid Command and Updating Channel");
            console.log("Row Zone_ID:" + rows[0].zone_id );
            validRF(rows[0].zone_id, req);
            updateCurrentChannel(req.body.Configuration.Channel, rows[0].zone_remote_remote_id);
          }
        }  else {
          // Check if valid remote addresses without valid channel, if so update channel for remote
          var sql = "SELECT atomik_zones.zone_id, atomik_zone_remotes.zone_remote_remote_id FROM atomik_zones, atomik_remotes, atomik_zone_remotes WHERE atomik_zones.zone_id=atomik_zone_remotes.zone_remote_zone_id && atomik_zone_remotes.zone_remote_remote_id=atomik_remotes.remote_id && atomik_remotes.remote_address1="+addint1+" && atomik_remotes.remote_address2="+addint2+";"; 
          console.log(sql);
          connection.query(sql, function(err, rows ) {
            if (err) throw err;
        
            if ( rows.length > 0) {
              if (rows ) {
                updateCurrentChannel(req.body.Configuration.Channel, rows[0].zone_remote_remote_id);
              }
            }
          });
          invalidRF(req);
        }
      });
    })(req);
  }
}


function log_emu_no_execute(channel, date, rec_data, status, colormode, color, whitetemp, bright, ip, mac) {

  var sql = 'INSERT INTO atomik_commands_received (command_received_source_type, command_received_channel_id, command_received_date, command_received_data, command_received_status, command_received_color_mode, command_received_rgb256, command_received_white_temprature, command_received_brightness, command_received_processed, command_received_MAC, command_received_IP) VALUES ("Emulator", '+cha+', "'+date+'", "'+rec_data+'", '+sta+', '+cm+', '+col+', '+wt+', '+bri+', 0, "'+mac+'", "'+ip+'")'; 
  console.log(sql);
  connection.query(sql, function(err, rows, fields) {
  if (!err)
    console.log('The solution is: ', rows);
  else
    console.log('Error while performing Query.');
  });
} 

app.use(bodyParser.json());

app.use(bodyParser.urlencoded({     // to support URL-encoded bodies
  extended: true
}));  


app.get('/', function (req, res) {
  res.send('Hello Root!');
});


app.post('/emulator', function (req, res) {
  res.send('ok!\n'); 
  console.log('Emulator Data:');
  console.log(req.body);

  log_emu_no_execute(req.body.Configuration.Channel, req.body.DateTime, req.body.Data, req.body.Configuration.Status, req.body.Configuration.ColorMode, req.body.Configuration.Color, req.body.Configuration.WhiteMode, req.body.Configuration.Brightness, req.body.IP, req.body.MAC);

});

app.post('/transceiver', function (req, res) {
 res.send('ok!\n');  
 console.log('Transceiver Data:');
 console.log(req.body);
 
 checkRFJSON ( req.body.Address1, req.body.Address2, req.body.Configuration.Channel, req );
});

app.get('/cron', function (req, res) {
  res.send('Hello Cron!');
});


app.listen(PORT, function () {
  console.log('Atomik Server - Version 0.80');
  console.log('Listening for Atomik JSON Data (Port: ' + PORT + ') : ( press ctrl-c to end )');
});

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
  (function (req) {
    var sql = "SELECT atomik_devices.device_id, atomik_devices.device_status, atomik_devices.device_colormode, atomik_devices.device_brightness, atomik_devices.device_rgb256, atomik_devices.device_white_temprature, atomik_devices.device_address1, atomik_devices.device_address2, atomik_device_types.device_type_rgb256, atomik_device_types.device_type_warm_white, atomik_device_types.device_type_cold_white, atomik_devices.device_transmission, atomik_zone_devices.zone_device_zone_id FROM atomik_zone_devices, atomik_device_types, atomik_devices WHERE atomik_zone_devices.zone_device_zone_id="+zoneID+" && atomik_zone_devices.zone_device_device_id=atomik_devices.device_id && atomik_devices.device_type=atomik_device_types.device_type_id && atomik_device_types.device_type_brightness=1;";	
    console.log(sql);
    
    connection.query(sql, function(err, results ) {
      if (err) throw err;
   
      for (var i=0; i < results.length; i++) { 
     
        if (typeof req.body.Configuration.Status == 'undefined') {
          sta = results[i].device_status;
        } else if ( req.body.Configuration.Status == "On" ) {
          sta = 1;
        } else if ( req.body.Configuration.Status == "Off" ) {
          sta = 0;
        } else {
          sta = '"'+req.body.Configuration.Status+'"';
        }
                
        if (typeof req.body.Configuration.ColorMode == 'undefined') {
          cm = results[i].device_colormode;
        } else if ( req.body.Configuration.ColorMode == "RGB256" ) {
          cm = 0;
        } else if ( req.body.Configuration.ColorMode == "White" ) {
          cm = 1;
        }
    
        if (typeof req.body.Configuration.Color == 'undefined') {
          col = results[i].device_rgb256;
        } else {
          col = req.body.Configuration.Color;
        }

        if (typeof req.body.Configuration.WhiteTemp == 'undefined') {
          wt = results[i].device_white_temprature;
        } else {
          wt = req.body.Configuration.WhiteTemp;
        }
  
        if (typeof req.body.Configuration.Brightness == 'undefined') {
          bri = results[i].device_brightness;
        } else {
              bri = req.body.Configuration.Brightness;
        }
         console.log('Transmit Address: '+results[i].device_address1+' ('+parseInt(results[i].device_address1, 16)+') '+results[i].device_address2+' ('+parseInt(results[i].device_address2, 16)+')');
        traNumber = transmit(bri, results[i].device_brightness, sta, results[i].device_status, col, results[i].device_rgb256, wt, results[i].device_white_temprature, cm, results[i].device_colormode, results[i].device_address1, results[i].device_address2, results[i].device_transmission, results[i].device_type_rgb256, results[i].device_type_cold_white, results[i].device_type_warm_white);
        
        updateDevice(sta, cm, bri, col, wt, traNumber, results[i].device_id);
        lastUpdate_ZoneDevice(results[i].zone_device_zone_id);
        lastUpdate_Zone(results[i].zone_device_zone_id);
      }
    });
  })(req);
}

function updateDevice (status, colormode, brightness, color, whitetemp, transmission, device_id) {
  console.log('Running -- updateDevice');
  
  var sql = "UPDATE atomik_devices SET device_status = "+status+", device_colormode = "+colormode+", device_brightness = "+brightness+", device_rgb256 = "+color+", device_white_temprature = "+whitetemp+", device_transmission = "+transmission+" WHERE device_id="+device_id+";";
  
  console.log(sql);
  connection.query(sql, function(err) {
   if (!err) {
     console.log('Device- Update Details');
   } else {
     console.log('Error while performing Query.');
    }
  });
}


function lastUpdate_ZoneDevice(zone_id) {
  console.log('Running -- lastUpdate_ZoneDevice');
  
  var tz = system_timezone();
  
  var sql = "UPDATE atomik_zone_devices SET zone_device_last_update = CONVERT_TZ(NOW(), '"+tz+"', 'UTC') WHERE zone_device_zone_id="+zone_id+";"; 
  
  console.log(sql);
  connection.query(sql, function(err) {
   if (!err) {
     console.log('Zone Device- Last Update Set');
   } else {
     console.log('Error while performing Query.');
    }
  });
}


function lastUpdate_Zone(zone_id) {
  console.log('Running -- lastUpdate_Zone');
  
  var tz = system_timezone();
  
  var sql = "UPDATE atomik_zones SET zone_last_update = CONVERT_TZ(NOW(), '"+tz+"', 'UTC') WHERE zone_id="+zone_id+";"; 
  
  console.log(sql);
  connection.query(sql, function(err) {
   if (!err) {
     console.log('Zone - Last Update Set');
   } else {
     console.log('Error while performing Query.');
    }
  });
}


function transmit(new_b, old_b, new_s, old_s, new_c, old_c, new_wt, old_wt, new_cm, old_cm, add1, add2, tra, rgb, cw, ww) {
   console.log('Running -- Transmit');
    console.log('Bright(o/n): '+old_b+'/'+new_b+' - '+'Status(o/n): '+old_s+'/'+new_s+' - '+'Color(o/n): '+old_c+'/'+new_c+' - '+'ColorMode(o/n): '+old_cm+'/'+new_cm+' - '+'WhiteTemp(o/n): '+old_wt+'/'+new_wt);

  trans = tra;
  if (cw == 1 && ww == 1 && rgb != 1) {
    // White Bulb Details
    Brightness = [9, 18, 27, 36, 45, 54, 63, 72, 81, 90, 100];
    WhiteTemp = [2700, 3080, 3460, 3840, 4220, 4600, 4980, 5360, 5740, 6120, 6500];
    if (new_s != old_s) {
      // Status Changed
      trans = increaseTrans(trans);
      if (new_s == 1) {
        atomikTransmitCMD(2, add1, add2, 1, 8, trans, (255 - trans));
      } else {
        atomikTransmitCMD(2, add1, add2, 1, 11, trans, (255 - trans));
      }
    } // End Status Change
    if (new_s == 1) {
      // Status On
      if (old_cm != new_cm) {
        trans = increaseTrans(trans);
        // Color Mode Change
        if (new_cm == 1) {
          atomikTransmitCMD(2, add1, add2, 1, 24, trans, (255 - trans));
        } else {
          atomikTransmitCMD(2, add1, add2, 1, 08, trans, (255 - trans));
        }
      }
      if (new_cm == 1) {}
      if (new_b != old_b) {
        // Brightness Change
        if (new_b <= 9) {
          new_b = 9;
        } else if (new_b <= 18) {
          new_b = 18;
        } else if (new_b <= 27) {
          new_b = 27;
        } else if (new_b <= 36) {
          new_b = 36;
        } else if (new_b <= 45) {
          new_b = 45;
        } else if (new_b <= 54) {
          new_b = 54;
        } else if (new_b <= 63) {
          new_b = 63;
        } else if (new_b <= 72) {
          new_b = 72;
        } else if (new_b <= 81) {
          new_b = 81;
        } else if (new_b <= 90) {
          new_b = 90;
        } else if (new_b <= 100) {
          new_b = 100;
        }
        old_pos = array_search(old_b, Brightness);
        new_pos = array_search(new_b, Brightness);
        if (new_pos > old_pos) {
          if (new_pos == array_search(100, Brightness)) {
            trans = increaseTrans(trans);
            atomikTransmitCMD(2, add1, add2, 1, 24, trans, (255 - trans));
          } else {
            move = new_pos - old_pos;
            for (x = 0; x <= move; x++) {
              trans = increaseTrans(trans);
              atomikTransmitCMD(2, add1, add2, 1, 12, trans, (255 - trans));
            }
          }
        } else {
          move = old_pos - new_pos;
          for (x = 0; x <= move; x++) {
            trans = increaseTrans(trans);
            atomikTransmitCMD(2, add1, add2, 1, 4, trans, (255 - trans));
          }
        }
      }
      if (new_wt != old_wt) {
        // White Temp Change
        old_pos = array_search(old_wt, WhiteTemp);
        new_pos = array_search(new_wt, WhiteTemp);
        if (new_pos > old_pos) {
          if (new_pos == array_search(2700, WhiteTemp)) {
            trans = increaseTrans(trans);
            atomikTransmitCMD(2, add1, add2, 1, 31, trans, (255 - trans));
          } else {
            move = new_pos - old_pos;
            for (x = 0; x <= move; x++) {
              trans = increaseTrans(trans);
              atomikTransmitCMD(2, add1, add2, 1, 15, trans, (255 - trans));
            }
          }
        } else {
          if (new_pos == array_search(6500, WhiteTemp)) {
            trans = increaseTrans(trans);
            atomikTransmitCMD(2, add1, add2, 1, 30, trans, (255 - trans));
          } else {
            move = old_pos - new_pos;
            for (x = 0; x <= move; x++) {
              trans = increaseTrans(trans);
              atomikTransmitCMD(2, add1, add2, 1, 14, trans, (255 - trans));
            }
          }
        }
      }
    }
    // Close White CCT Bulb Transmissiom
  } else if (cw == 1 && rgb == 1 || ww == 1 && rgb == 1) {
    // Start RGB WW and RGB CW Bulb Transmission
    // atomikTransmitCMD(1, add1, add2, old_c, old_b, trans, 3);
    // RGBWW and RGBCW
    if (new_s != old_s) {
      // Status Changed
      trans = increaseTrans(trans);
      if (new_s == 1) {
        atomikTransmitCMD(1, add1, add2, old_c, ColBrightnessPercent2Value(old_b), trans, 3);
      } else {
        atomikTransmitCMD(1, add1, add2, old_c, ColBrightnessPercent2Value(old_b), trans, 4);
      }
    } // End Status Change
    if (new_s == 1) {
      // Status On
      if (old_cm != new_cm) {
        // Color Mode Change
        trans = increaseTrans(trans);
        if (new_cm == 1) {
          new_b = 185;
          atomikTransmitCMD(1, add1, add2, old_c, ColBrightnessPercent2Value(old_b), trans, 19);
        } else {
          atomikTransmitCMD(1, add1, add2, old_c, ColBrightnessPercent2Value(old_b), trans, 3);
        }
      } // End Color Mode Change > /dev/null &
      if (new_cm == 0) {
        // Color Mode Color
        if (new_c != old_c || old_cm != new_cm) {
          // Color Change
          trans = increaseTrans(trans);
          atomikTransmitCMD(1, add1, add2, old_c, ColBrightnessPercent2Value(old_b), trans, 3);
          trans = increaseTrans(trans);
          atomikTransmitCMD(1, add1, add2, new_c, ColBrightnessPercent2Value(old_b), trans, 15);
        } // End Color Change
      } // End Color Mode Color
      if (new_b != old_b) {
        // Brightness Change
        trans = increaseTrans(trans);
        atomikTransmitCMD(1, add1, add2, new_c, ColBrightnessPercent2Value(new_b), trans, 14);
      } // End Brightness Change
    } // End Status On
  } // Close RGB WW and RGB CW Bulb Transmission
  return trans;
}