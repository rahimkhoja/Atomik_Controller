<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Atomik Controller - Settings</title>
<link rel="stylesheet" href="css/atomik.css">
</head>
<nav class="navbar navbar-default navbar-inverse">
  <div class="container-fluid"> 
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <a class="navbar-brand" href="#"><img src="img/Sun_Logo_Menu_50px.gif" width="50" height="50" alt=""/></a></div>
    
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="dashboard.php">Dashboard</a> </li>
        <li class="active"><a href="settings.php">Settings<span class="sr-only">(current)</span></a> </li>
        <li><a href="devices.php">Devices</a> </li>
        <li><a href="remotes.php">Remotes</a> </li>
        <li><a href="zones.php">Zones</a> </li>
        <li><a href="tasks.php">Scheduled Tasks</a> </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="logout.php">Logout</a> </li>
      </ul>
    </div>
    <!-- /.navbar-collapse --> 
  </div>
  <!-- /.container-fluid --> 
</nav>
<body>
<div class="wrapper">
<div class="PageTitle">
    <div class="row">
        <div class="PageNavTitle" ><h3>Settings</h3></div>
    </div>
   </div><hr><div class="alert alert-success">
  <strong>Success!</strong> Indicates a successful or positive action.
</div><div class="alert alert-danger">
  <strong>Danger!</strong> Indicates a dangerous or potentially negative action.
</div>
<hr />

<div class="container">
    <div class="row">
        <div class="col-xs-6">
           <h4><p>System Settings:</p></h4>   
  <table class="table table-striped">
    <thead>
      <tr>
        <td>Hostname: </td>
        <td><input type="text" class="form-control" id="usr" value="AtomikController"></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Atomik API Service: </td>
        <td><input type="checkbox" id="atomikservice" class="form-control" ></label></td>
      </tr>
      <tr>
        <td>Mi-Light Emulator Service: </td>
        <td><input type="checkbox" id="emulatorservice" class="form-control" ></label></td>
      </tr>
      <tr>
        <td>Mi-Light Transceiver Service: </td>
        <td><input type="checkbox" id="transceiverservice" class="form-control" ></label></td>
      </tr>
    </tbody>
  </table><hr>
  <div class="container center col-xs-12">
  <div class="col-xs-6 text-center"></div>
  <div class="col-xs-6 text-center"><p><a href="" class="btn-success btn">Save System Settings</a></p></div>
  </div>
  <br><br>
  <hr><h4><p>Update Password:</p></h4>   
  <table class="table table-striped">
    <thead>
      <tr>
        <td>Current Password: </td>
        <td><input type="password" class="form-control" id="currentpassword" value="password"></td>
      </tr>
      </thead>
    <tbody>
    <tr>
        <td>New Password: </td>
        <td><input type="password" class="form-control" id="newpassword" value="password"></td>
      </tr>
      <tr>
        <td>Repeat Password: </td>
        <td><input type="password" class="form-control" id="newpassword2" value="password"></td>
      </tr>
    </tbody>
  </table><hr>
  <div class="container center col-xs-12">
  <div class="col-xs-6 text-center"></div>
  <div class="col-xs-6 text-center"><p><a href="" class="btn-success btn">Save Password</a></p></div>
  </div>
  <br><br>
  <hr>
            <h4><p>Time Settings:</p></h4>   
  <table class="table table-striped">
    <thead>
      <tr>
        <td>Current System Time: </td>
        <td>Tue, 3 Apr 2016 22:11:19 -0700</td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Time Zone: </td>
        <td><select  class="form-control">
  <option value="-12.0">(GMT -12:00) Eniwetok, Kwajalein</option>
      <option value="-11.0">(GMT -11:00) Midway Island, Samoa</option>
      <option value="-10.0">(GMT -10:00) Hawaii</option>
      <option value="-9.0">(GMT -9:00) Alaska</option>
      <option value="-8.0">(GMT -8:00) Pacific Time (US &amp; Canada)</option>
      <option value="-7.0">(GMT -7:00) Mountain Time (US &amp; Canada)</option>
      <option value="-6.0">(GMT -6:00) Central Time (US &amp; Canada), Mexico City</option>
      <option value="-5.0">(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima</option>
      <option value="-4.0">(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz</option>
      <option value="-3.5">(GMT -3:30) Newfoundland</option>
      <option value="-3.0">(GMT -3:00) Brazil, Buenos Aires, Georgetown</option>
      <option value="-2.0">(GMT -2:00) Mid-Atlantic</option>
      <option value="-1.0">(GMT -1:00 hour) Azores, Cape Verde Islands</option>
      <option value="0.0">(GMT) Western Europe Time, London, Lisbon, Casablanca</option>
      <option value="1.0">(GMT +1:00 hour) Brussels, Copenhagen, Madrid, Paris</option>
      <option value="2.0">(GMT +2:00) Kaliningrad, South Africa</option>
      <option value="3.0">(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg</option>
      <option value="3.5">(GMT +3:30) Tehran</option>
      <option value="4.0">(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi</option>
      <option value="4.5">(GMT +4:30) Kabul</option>
      <option value="5.0">(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent</option>
      <option value="5.5">(GMT +5:30) Bombay, Calcutta, Madras, New Delhi</option>
      <option value="5.75">(GMT +5:45) Kathmandu</option>
      <option value="6.0">(GMT +6:00) Almaty, Dhaka, Colombo</option>
      <option value="7.0">(GMT +7:00) Bangkok, Hanoi, Jakarta</option>
      <option value="8.0">(GMT +8:00) Beijing, Perth, Singapore, Hong Kong</option>
      <option value="9.0">(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk</option>
      <option value="9.5">(GMT +9:30) Adelaide, Darwin</option>
      <option value="10.0">(GMT +10:00) Eastern Australia, Guam, Vladivostok</option>
      <option value="11.0">(GMT +11:00) Magadan, Solomon Islands, New Caledonia</option>
      <option value="12.0">(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka</option>
</select></td>
      </tr>
      <tr>
        <td nowrap>Daylight Savings Time: </td>
        <td><input type="checkbox" id="daylightsavings" class="form-control" ></label></td>
      </tr>
      <tr>
        <td>Time Update Interval: </td>
        <td><select  class="form-control">
  <option value="0">Never</option>
  <option value="24">Daily</option>
  <option value="2">Every 2 Hours</option>
  <option value="6">Every 6 Hours</option>
  <option value="12">Every 12 Hours</option>
</select></label></td>
      </tr>
      <tr>
        <td>NTP Time Server 1: </td>
        <td><input type="text" class="form-control" id="timeservere1" value="192.5.41.40"></td>
      </tr>
      <tr>
        <td>NTP Time Server 2: </td>
        <td><input type="text" class="form-control" id="timeservere2" value="192.5.41.41"></td>
      </tr>
    </tbody>
  </table>
  <hr>
  <div class="container center col-xs-12">
  <div class="col-xs-6 text-center"></div>
  <div class="col-xs-6 text-center"><p><a href="" class="btn-success btn">Save Time Settings</a></p></div>
  </div>
  <br><br><hr>
        </div>
        <div class="col-xs-6">
            <h4><p>Ethernet Adapter Settings:</p></h4>   
  <table class="table table-striped">
    <thead>
      <tr>
        <td>Eth0 Status: </td>
        <td><select id="eth0status" class="form-control">
  <option value="1">Enable</option>
  <option value="0">Disable</option>
</select></td>
      </tr>
    </thead>
    <tbody>
    <tr>
        <td>Eth0 Type: </td>
        <td><select  class="form-control">
  <option value="Static">Static</option>
  <option value="DHCP">DHCP</option>
</select></td>
      </tr>
      <tr>
        <td>Eth0 IP Address: </td>
        <td><input type="text" class="form-control" id="eth0ip" value="192.168.1.100"></td>
      </tr>
      <tr>
        <td>Eth0 Subnet Mask: </td>
        <td><input type="text" class="form-control" id="eth0mask" value="255.255.255.0"></td>
      </tr>
      <tr>
        <td>Eth0 Gateway: </td>
        <td><input type="text" class="form-control" id="eth0gate" value="192.168.1.1"></td>
      </tr>
      <tr>
        <td>Eth0 DNS: </td>
        <td><input type="text" class="form-control" id="eth0dns" value="8.8.8.8"></td>
      </tr>
    </tbody>
  </table>
  <hr>
  <div class="container center col-xs-12">
  <div class="col-xs-6 text-center"></div>
  <div class="col-xs-6 text-center"><p><a href="" class="btn-success btn">Save Ethernet Settings</a></p></div>
  </div>
  <br><br><hr>
<h4><p>Wifi Adapter Settings:</p></h4>   
  <table class="table table-striped">
    <thead>
      <tr >
        <td>Wifi0 Status: </td>
        <td><select id="wifi0status" class="form-control">
  <option value="1">Enable</option>
  <option value="0">Disable</option>
</select></td>
      </tr>
    </thead>
    <tbody>
    <tr>
        <td>Wifi0 SSID: </td>
        <td><select id="wifi0ssid" class="form-control">
  <option value="0">None</option>
</select></td>
      </tr>
      <tr>
        <td>Wifi0 Method: </td>
        <td><select id="wifi0method" class="form-control">
  <option value="Disable">Disable</option>
  <option value="OpenWEP">OPENWEP</option>
  <option value="SHAREDWEP">SHAREDWEP</option>
  <option value="WPAPSK">WPAPSK</option>
  <option value="WPA2PSK">WPA2PSK</option>
</select></td>
      </tr>
      <tr>
        <td>Wifi0 Encryption Algorithm: </td>
        <td><select id="wifi0algorithm" class="form-control">
  <option value="0">AES</option>		// only visible wpa and wpa2 methods
  <option value="0">TKIP</option>		// only visible wpa and wpa2 methods
  <option value="0">ASCII</option> 		// only visible OPENWEP and SHAREDWEP methods
  <option value="0">HEX</option>		// only visible OPENWEP and SHAREDWEP methods
</select></td>
      </tr>
      <tr>
        <td>Wifi0 Password: </td>
        <td><input type="password" class="form-control" id="wifi0password" value="password"></td>
      </tr>
      <tr>
        <td>Wifi0 Type: </td>
        <td><select  class="form-control">
  <option value="Static">Static</option>
  <option value="DHCP">DHCP</option>
</select></td>
      </tr>
      <tr>
        <td>Wifi0 IP Address: </td>
        <td><input type="text" class="form-control" id="wifi0ip" value="192.168.2.1"></td>
      </tr>
      <tr>
        <td>Wifi0 Subnet Mask: </td>
        <td><input type="text" class="form-control" id="eth0ip" value="192.168.1.100"></td>
      </tr>
      <tr>
        <td>Wifi0 Gateway: </td>
        <td><input type="text" class="form-control" id="wifi0gate" value="192.168.1.1"></td>
      </tr>
      <tr>
        <td>Wifi0 DNS: </td>
        <td><input type="text" class="form-control" id="Wifi0dns" value="8.8.6.6"></td>
      </tr>
      </tbody>
  </table><hr>
  <div class="container center col-xs-12">
  <div class="col-xs-2 text-center"><p><a href="" class="btn-primary btn">Refresh SSID List</a></p></div>  
  <div class="col-xs-6 text-center"></div>
  <div class="col-xs-4 text-center"><p><a href="" class="btn-success btn">Save Wireless Settings</a></p></div>
  </div>
  <br><br><hr>
    </div>
</div>
</div>
  <hr><div class="alert alert-success">
  <strong>Success!</strong> Indicates a successful or positive action.
</div><div class="alert alert-danger">
  <strong>Danger!</strong> Indicates a dangerous or potentially negative action.
</div>
<hr>
  <div class="container center">
  <div class="col-xs-2">
  </div>
  <div class="col-xs-2"><p><a href="settings.php"  class="btn-warning btn">Cancel</a></p>
  </div>
  <div class="col-xs-2"><p></p>
  </div>
  <div class="col-xs-2">
  </div>
  <div class="col-xs-2"><p><a href="" class="btn-danger btn">Reboot System</a></p>
  </div>
  <div class="col-xs-2">
  </div>
</div>
<hr>
<div class="push"></div>
 </div>
<div class="footer FooterColor">
  
     <hr>
      <div class="col-xs-12 text-center">
        <p>Copyright © Atomik Technologies Inc. All rights reserved.</p>
      </div>
      <hr>
    </div>
</body>
</html>
