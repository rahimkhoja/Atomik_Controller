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

  var sql = 'UPDATE atomik_remotes SET remote_current_channel = '+channel+'? WHERE remote_id = '+remote_id+';'; 
  console.log(sql);
  connection.query(sql, function(err) {
   if (!err)
     console.log('Channel Updated');
   else
     console.log('Error while performing Query.');
   });
} 





function log_tra_no_execute(channel, date, rec_data, status, colormode, color, whitetemp, bright, add1, add2) {

  if (typeof channel == 'undefined') {
    cha = 'NULL';
  } else {
    cha = '"'+channel+'"';
  }

  if (typeof status == 'undefined') {
    sta = 'NULL';
  } else {
    sta = '"'+status+'"';
  }

  if (typeof colormode == 'undefined') {
    cm = 'NULL';
  } else {
    cm = '"'+colormode+'"';
  }

  if (typeof color == 'undefined') {
    col = 'NULL';
  } else {
    col = color;
  }

  if (typeof whitetemp == 'undefined') {
    wt = 'NULL';
  } else {
    wt = whitetemp;
  }

  if (typeof bright == 'undefined') {
    bri = 'NULL';
  } else {
    bri = bright;
  }

  var sql = 'INSERT INTO atomik_commands_received (command_received_source_type, command_received_channel_id, command_received_date, command_received_data, command_received_status, command_received_color_mode, command_received_rgb256, command_received_white_temprature, command_received_brightness, command_received_processed, command_received_ADD1, command_received_ADD2) VALUES ("Radio", '+cha+', "'+date+'", "'+rec_data+'", '+sta+', '+cm+', '+col+', '+wt+', '+bri+', 0, "'+add1+'", "'+add2+'")';

  console.log(sql);

  connection.query(sql, function(err, rows, fields) {
    if (!err) {
     console.log('The solution is: ', rows);
    } else {
     console.log('Error while performing Query.');
     fs.appendFile('/var/log/atomik/AtomikServerJSON.log', sql, function (err) {
      if (err) throw err;
        console.log('The "data to append" was appended to file!');
    });
 });
}

function log_tra_execute(channel, date, rec_data, status, colormode, color, whitetemp, bright, add1, add2) {

  if (typeof channel == 'undefined') {
    cha = 'NULL';
  } else {
    cha = '"'+channel+'"';
  }

  if (typeof status == 'undefined') {
    sta = 'NULL';
  } else {
    sta = '"'+status+'"';
  }

  if (typeof colormode == 'undefined') {
    cm = 'NULL';
  } else {
    cm = '"'+colormode+'"';
  }

  if (typeof color == 'undefined') {
    col = 'NULL';
  } else {
    col = color;
  }

  if (typeof whitetemp == 'undefined') {
    wt = 'NULL';
  } else {
    wt = whitetemp;
  }

  if (typeof bright == 'undefined') {
    bri = 'NULL';
  } else {
    bri = bright;
  }

  var sql = 'INSERT INTO atomik_commands_received (command_received_source_type, command_received_channel_id, command_received_date, command_received_data, command_received_status, command_received_color_mode, command_received_rgb256, command_received_white_temprature, command_received_brightness, command_received_processed, command_received_ADD1, command_received_ADD2) VALUES ("Radio", '+cha+', "'+date+'", "'+rec_data+'", '+sta+', '+cm+', '+col+', '+wt+', '+bri+', 1, "'+add1+'", "'+add2+'")';

  console.log(sql);

  connection.query(sql, function(err, rows, fields) {
    if (!err) {
     console.log('The solution is: ', rows);
    } else {
     console.log('Error while performing Query.');
     fs.appendFile('/var/log/atomik/AtomikServerJSON.log', sql+"\n", function (err) {
      if (err) throw err;
        console.log('The "data to append" was appended to file!');
    });
 });
}

function validRF(zoneID, req){
  console.log('Valid Command!:');
  console.log("Zone_ID: " + zoneID );
  log_tra_execute(req.body.Channel, req.body.DateTime, req.body.Data, req.body.Configuration.Status, req.body.Configuration.ColorMode, req.body.Configuration.Color, req.body.Configuration.WhiteMode, req.body.Configuration.Brightness, req.body.Address1, req.body.Address2);
}

function invalidRF(req){
  console.log('Invalid Command:');
  log_tra_no_execute(req.body.Channel, req.body.DateTime, req.body.Data, req.body.Configuration.Status, req.body.Configuration.ColorMode, req.body.Configuration.Color, req.body.Configuration.WhiteMode, req.body.Configuration.Brightness, req.body.Address1, req.body.Address2);
}

function checkRFJSON ( address1, address2, channel, req ) {
  
  var addint1 = parseInt(address1, 16);
  var addint2 = parseInt(address2, 16);
  
  if (typeof channel == 'undefined') {
  
  var sql = "SELECT atomik_zones.zone_id, atomik_zone_remotes.zone_remote_remote_id FROM atomik_zones, atomik_remotes, atomik_zone_remotes WHERE atomik_zones.zone_id=atomik_zone_remotes.zone_remote_zone_id && atomik_zone_remotes.zone_remote_remote_id=atomik_remotes.remote_id && atomik_remotes.remote_address1="+addint1+" && atomik_remotes.remote_address2="+addint2+" atomik_zone_remotes.zone_remote_channel_number="+channel+";"; 
  connection.query(sql, function(err, rows, req ) {
    if (err) throw err;
 
      if ( rows.length > 0) {
        if (rows ) {
          console.log("Rows Length:" + rows.length );
          console.log("Row Zone_ID:" + rows[0].zone_id );
          validRF(rows[0].zone_id, req);
          updateCurrentChannel(req.body.Channel, rows[0].zone_remote_remote_id);
          }
      }  else {
        invalidRF(req);
      }
    });
    
  } else {
    var sql = "SELECT atomik_zones.zone_id FROM atomik_zones, atomik_remotes, atomik_zone_remotes WHERE atomik_zones.zone_id = atomik_zone_remotes.zone_remote_zone_id && atomik_zone_remotes.zone_remote_remote_id = atomik_remotes.remote_id && atomik_remotes.remote_address1 = "+addint1+" && atomik_remotes.remote_address2 = "+addint2+" atomik_remotes.atomik_remote_current_channel = atomik_zone_remotes.zone_remote_channel_number;";
    connection.query(sql, function(err, rows, req ) {
    if (err) throw err;
 
      if ( rows.length > 0) {
        if (rows ) {
          console.log("Rows Length:" + rows.length );
          console.log("Row Zone_ID:" + rows[0].zone_id );
          validRF(rows[0].zone_id, req);
          }
      }  else {
        invalidRF(req);
      }
    });
  
  }
}

function log_emu_no_execute(channel, date, rec_data, status, colormode, color, whitetemp, bright, ip, mac) {

if (typeof channel == 'undefined') {
  cha = 'NULL';
} else {
  cha = '"'+channel+'"';
}

if (typeof status == 'undefined') {
  sta = 'NULL'; 
} else {
  sta = '"'+status+'"';
}

if (typeof colormode == 'undefined') {
  cm = 'NULL';
} else {
  cm = '"'+colormode+'"';
}

if (typeof color == 'undefined') {
  col = 'NULL';
} else {
  col = color;
}

if (typeof whitetemp == 'undefined') {
  wt = 'NULL';
} else {
  wt = whitetemp;
}

if (typeof bright == 'undefined') {
  bri = 'NULL';
} else {
  bri = bright;
}

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

  log_emu_no_execute(req.body.Channel, req.body.DateTime, req.body.Data, req.body.Configuration.Status, req.body.Configuration.ColorMode, req.body.Configuration.Color, req.body.Configuration.WhiteMode, req.body.Configuration.Brightness, req.body.IP, req.body.MAC);

});

app.post('/transceiver', function (req, res) {
 res.send('ok!\n');  
 console.log('Transceiver Data:');
 console.log(req.body);
 
 checkRFJSON ( req.body.Address1, req.body.Address2, req.body.Channel, req );
});

app.get('/cron', function (req, res) {
  res.send('Hello Cron!');
});


app.listen(PORT, function () {
  console.log('Atomik Server - Version 0.80');
  console.log('Listening for Atomik JSON Data (Port: ' + PORT + ') : ( press ctrl-c to end )');
});
