<?php include 'script/database.php';?><!doctype html>
<html>
<head>

<meta charset="utf-8">
<title>Atomik Controller - Settings</title>
<link rel="stylesheet" href="css/atomik.css">
<script src="js/jquery-1.12.3.min.js"></script>
<script src="js/jquery.redirect.min.js"></script>
<?php

$page_error = 0;
$page_success = 0;

$sql = "SELECT * FROM atomik_settings LIMIT 1";  // Select ONLY one, instead of all

$rs=$conn->query($sql);
 
if($rs === false) {
  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
} else {
  $db_records = $rs->num_rows;
}

$rs->data_seek(0);
$row = $rs->fetch_assoc();





// System POST Data
$post_hostname = $_POST["hostname"];
$post_atomik_api = $_POST["atomik_api"];
$post_atomik_emulator = $_POST["atomik_emulator"];
$post_atomik_transceiver = $_POST["atomik_transceiver"];

// Password POST Data
$post_current_password = $_POST["password"];

// Time POST Data
$post_timezone = $_POST["timezone"];
$post_daylight_savings = $_POST["daylight_savings"];
$post_update_time_interval = $_POST["time_update_interval"];
$post_ntp_server1 = $_POST["ntp_server_1"];
$post_ntp_server2 = $_POST["ntp_server_2"];

// Eth0 POST Data
$post_eth0_status = $_POST["eth0_status"];
$post_eth0_type = $_POST["eth0_type"];
$post_eth0_ip = $_POST["eth0_ip"];
$post_eth0_mask = $_POST["eth0_mask"];
$post_eth0_gateway = $_POST["eth0_gateway"];
$post_eth0_dns = $_POST["eth0_dns"];

// Wifi POST Data
$post_wlan0_status = $_POST["wlan0_status"];
$post_wlan0_ssid = $_POST["wlan0_ssid"];
$post_wlan0_method = $_POST["wlan0_method"];
$post_wlan0_algorithm = $_POST["wlan0_algorithm"];
$post_wlan0_password = $_POST["wlan0_password"];
$post_wlan0_type = $_POST["wlan0_type"];
$post_wlan0_ip = $_POST["wlan0_ip"];
$post_wlan0_mask = $_POST["wlan0_mask"];
$post_wlan0_gateway = $_POST["wlan0_gateway"];
$post_wlan0_dns = $_POST["wlan0_dns"];

// System DB Data
$db_hostname = $row['hostname'];
$db_atomik_api = $row['atomik_api'];
$db_atomik_emulator = $row['atomik_emulator'];
$db_atomik_transceiver = $row['atomik_transceiver'];

// Password DB Data
$db_current_password = $row['password'];

// Time DB Data
$db_timezone = $row['timezone'];
$db_daylight_savings = $row['daylight_savings'];
$db_update_time_interval = $row['time_update_interval'];
$db_ntp_server1 = $row['ntp_server_1'];
$db_ntp_server2 = $row['ntp_server_2'];

// Eth0 DB Data
$db_eth0_status = $row['eth0_status'];
$db_eth0_type = $row['eth0_type'];
$db_eth0_ip = $row['eth0_ip'];
$db_eth0_mask = $row['eth0_mask'];
$db_eth0_gateway = $row['eth0_gateway'];
$db_eth0_dns = $row['eth0_dns'];

// Wifi DB Data
$db_wlan0_status = $row['wlan0_status'];
$db_wlan0_ssid = $row['wlan0_ssid'];
$db_wlan0_method = $row['wlan0_method'];
$db_wlan0_algorithm = $row['wlan0_algorithm'];
$db_wlan0_password = $row['wlan0_password'];
$db_wlan0_type = $row['wlan0_type'];
$db_wlan0_ip = $row['wlan0_ip'];
$db_wlan0_mask = $row['wlan0_mask'];
$db_wlan0_gateway = $row['wlan0_gateway'];
$db_wlan0_dns = $row['wlan0_dns'];



// Processing Commands
$command = $_POST["command"];
// Reboot
if ($command <> "" && $command !="" && $command == "reboot") {
	$Handle = fopen("/tmp/atomikreboot", 'w');
	fwrite($Handle, "doreboot");
	fclose($Handle);
	header("location:reboot.php");
}


// Save System Settings [Keep Post Data, Verify Form, DB, Start Service, Stop Service, Edit File, Reboot] (save_system)

// Save Password [Keep Post Data, Verify Form, DB] (save_password)

// Save Time Zone [Keep Post Data, Verify Form, DB, Edit Cron, Edit File] (save_time)

// Save Eth0 Settings [Keep Post Data, Verify Form, DB, Edit Files, Restart Service] (save_eth0)

// Save Wifi Settings [Keep Post Data, Verify Form, DB, Edit Files, Restart Service] (save_eth0)

// RefreshSSID []



?></head><script type="text/javascript">
    $('a#reboot').click(function(){ document.forms["settingsfrm"].command.value = "reboot"; document.settingsfrm.submit(); })
</script>
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
   </div><?php if ( $page_success || $page_error ) { ?><hr><?php } ?><?php if ( $page_success ) { ?><div class="alert alert-success">
  <strong>Success!</strong> Indicates a successful or positive action.
</div><?php } ?><?php if ( $page_error ) { ?><div class="alert alert-danger">
  <strong>Danger!</strong> Indicates a dangerous or potentially negative action.
</div><?php } ?><hr>
<form id="settingsfrm" name="settingsfrm" action="settings.php" method="post"><input type="hidden" name="command" value="" >
<div class="container">
    <div class="row">
        <div class="col-xs-6">
          <h4><p>System Settings:</p></h4>
          <table class="table table-striped">
           <thead>
             <tr>
               <td><table class="table table-striped">
                 <thead>
                   <tr>
                     <td>Hostname: </td>
                     <td><input type="text" class="form-control" id="usr" value="<?php if ( $post_hostname != "" && $post_hostname <> "" && $post_hostname != $db_hostname ) {
	echo $post_hostname;
} else {
	echo $db_hostname;
}; ?>"></td>
                   </tr>
                 </thead>
                 <tbody>
                   <tr>
                     <td>Atomik API Service: </td>
                     <td><input type="checkbox" class="form-control" id="atomikservice" <?php if ($row['atomik_api'] > 0 ) { ?>checked <?php }; ?>></td>
                   </tr>
                   <tr>
                     <td>Mi-Light Emulator Service: </td>
                     <td><input type="checkbox" id="emulatorservice" class="form-control" <?php if ($row['atomik_emulator'] > 0 ) { ?>checked  <?php }; ?>></td>
                   </tr>
                   <tr>
                     <td>Mi-Light Transceiver Service: </td>
                     <td><input type="checkbox" id="transceiverservice" class="form-control" <?php if ($row['atomik_transceiver'] > 0 ) { ?>checked  <?php }; ?>></td>
                   </tr>
                 </tbody>
               </table></td>
             </tr>
           </thead>
          </table>
          <hr>
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
        <td><input type="password" class="form-control" id="currentpassword" value=""></td>
      </tr>
      </thead>
    <tbody>
    <tr>
        <td>New Password: </td>
        <td><input type="password" class="form-control" id="newpassword" value=""></td>
      </tr>
      <tr>
        <td>Repeat Password: </td>
        <td><input type="password" class="form-control" id="newpassword2" value=""></td>
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
        <td><input type="text" class="form-control" id="timeservere1" value="<?php if ( $post_ntp_server1 != "" && $post_ntp_server1 <> "" && $post_ntp_server1 != $db_ntp_server1 ) {
	echo $post_ntp_server1;
} else {
	echo $db_ntp_server1;
}; ?>"></td>
      </tr>
      <tr>
        <td>NTP Time Server 2: </td>
        <td><input type="text" class="form-control" id="timeservere2" value="<?php if ( $post_ntp_server2 != "" && $post_ntp_server2 <> "" && $post_ntp_server2 != $db_ntp_server2 ) {
	echo $post_ntp_server2;
} else {
	echo $db_ntp_server2;
}; ?>"></td>
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
  <option value="1" <?php if ($row['eth0_status'] == 1 ) { ?>selected <?php }; ?>>Enable</option>
  <option value="0" <?php if ($row['eth0_status'] == 0 ) { ?>selected <?php }; ?>>Disable</option>
</select></td>
      </tr>
    </thead>
    <tbody>
    <tr>
        <td>Eth0 Type: </td>
        <td><select  class="form-control">
  <option value="0" <?php if ($row['eth0_type'] == 0 ) { ?>selected <?php }; ?>>Static</option>
  <option value="1" <?php if ($row['eth0_type'] == 1 ) { ?>selected <?php }; ?>>DHCP</option>
</select></td>
      </tr>
      <tr>
        <td>Eth0 IP Address: </td>
        <td><input type="text" class="form-control" id="eth0ip" value="<?php if ( $post_eth0_ip != "" && $post_eth0_ip <> "" && $post_eth0_ip != $db_eth0_ip ) {
	echo $post_eth0_ip;
} else {
	echo $db_eth0_ip;
}; ?>"></td>
      </tr>
      <tr>
        <td>Eth0 Subnet Mask: </td>
        <td><input type="text" class="form-control" id="eth0mask" value="<?php if ( $post_eth0_mask != "" && $post_eth0_mask <> "" && $post_eth0_mask != $db_eth0_mask ) {
	echo '1. '.$post_eth0_mask;
} else {
	echo '2. '.$db_eth0_mask;
}; ?>"></td>
      </tr>
      <tr>
        <td>Eth0 Gateway: </td>
        <td><input type="text" class="form-control" id="eth0gate" value="<?php echo $row['eth0_gateway']; ?>"></td>
      </tr>
      <tr>
        <td>Eth0 DNS: </td>
        <td><input type="text" class="form-control" id="eth0dns" value="<?php echo $row['eth0_dns']; ?>"></td>
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
  <option value="0" <?php if ($row['wlan0_status'] == 0 ) { ?>selected <?php }; ?>>Disable</option>
  <option value="1" <?php if ($row['wlan0_status'] == 1 ) { ?>selected <?php }; ?>>Enable</option>
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
  <option value="0" <?php if ($row['eth0_type'] == 0 ) { ?>selected <?php }; ?>>Static</option>
  <option value="1" <?php if ($row['eth0_type'] == 1 ) { ?>selected <?php }; ?>>DHCP</option>
</select></td>
      </tr>
      <tr>
        <td>Wifi0 IP Address: </td>
        <td><input type="text" class="form-control" id="wifi0ip" value="<?php echo $row['wlan0_ip']; ?>"></td>
      </tr>
      <tr>
        <td>Wifi0 Subnet Mask: </td>
        <td><input type="text" class="form-control" id="eth0ip" value="<?php echo $row['wlan0_mask']; ?>"></td>
      </tr>
      <tr>
        <td>Wifi0 Gateway: </td>
        <td><input type="text" class="form-control" id="wifi0gate" value="<?php echo $row['wlan0_gateway']; ?>"></td>
      </tr>
      <tr>
        <td>Wifi0 DNS: </td>
        <td><input type="text" class="form-control" id="Wifi0dns" value="<?php echo $row['wlan0_dns']; ?>"></td>
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
</div></form><?php if ( $page_success || $page_error ) { ?><hr><?php } ?><?php if ( $page_success ) { ?><div class="alert alert-success">
  <strong>Success!</strong> Indicates a successful or positive action.
</div><?php } ?><?php if ( $page_error ) { ?><div class="alert alert-danger">
  <strong>Danger!</strong> Indicates a dangerous or potentially negative action.
</div><?php } ?><hr>
  <div class="container center">
  <div class="col-xs-2">
  </div>
  <div class="col-xs-2"><p><a href="settings.php"  class="btn-warning btn">Cancel</a></p>
  </div>
  <div class="col-xs-2"><p></p>
  </div>
  <div class="col-xs-2">
  </div>
  <div class="col-xs-2"><p><a id="reboot" class="btn-danger btn">Reboot System</a></p>
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
