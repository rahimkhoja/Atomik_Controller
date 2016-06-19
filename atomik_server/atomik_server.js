var express = require('express');
var bodyParser = require('body-parser');
var mysql = require('mysql')
var fs = require('fs');

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
      fs.appendFile('/var/log/atomik/AtomikServerJSON.log', sql+"\n", function (err) {
      if (err) throw err;
        console.log('The "data to append" was appended to file!');
      });
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
      fs.appendFile('/var/log/atomik/AtomikServerJSON.log', sql+"\n", function (err) {
      if (err) throw err;
        console.log('The "data to append" was appended to file!');
      });
    } else {
      console.log('Error while performing Query.');
    }
  });
}

function validRF(zoneID, req){
  console.log('Valid Command!:');
  console.log("Zone_ID: " + zoneID );
  
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
