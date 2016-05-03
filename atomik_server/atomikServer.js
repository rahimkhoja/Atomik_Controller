var express = require('express');
var bodyParser = require('body-parser');

var app = express();

var PORT = 4200;

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

});

app.post('/transceiver', function (req, res) {
 res.send('ok!\n');  
console.log('Transceiver Data:');
  console.log(req.body);
});


app.get('/cron', function (req, res) {
  res.send('Hello Cron!');
});


app.listen(PORT, function () {
  console.log('Atomik Server - Version 0.80');
  console.log('Listening for Atomik JSON Data (Port: ' + PORT + ') : ( press ctrl-c to end )');
});
