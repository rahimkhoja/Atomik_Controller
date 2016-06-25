<?php
  session_start();
  if(!$_SESSION['username'])
  {
    header("Location: /index.php");
    exit; // IMPORTANT: Be sure to exit here!
  }
?><?php include 'script/database.php';?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="icon" type="image/png" href="img/favicon-32x32.png" sizes="32x32" />
<title>Atomik Controller - Add Device to Zone</title>
<link rel="stylesheet" href="css/atomik.css">
<script src="js/jquery-1.12.3.min.js"></script>
<script src="js/jquery.redirect.min.js"></script>
<?php
function IncrementTransmissionNum($number)
{
  $trans = $number + 1;
  if ($trans >= 256) {
    $trans = $trans - 256;
  }
  return $trans;
}

function colorBright ( $bri ) {
	$bright = $bri;
	
  	if ($bright <= 4) {
    	$bright = 4;
	} else if ($bright <= 8) {
    	$bright = 8;
	} else if ($bright <= 12) {
    	$bright = 12;
	} else if ($bright <= 15) {
    	$bright = 15;
	} else if ($bright <= 19) {
    	$bright = 19;
	} else if ($bright <= 23) {
    	$bright = 23;
	} else if ($bright <= 27) {
    	$bright = 27;
	} else if ($bright <= 31) {
    	$bright = 31;
	} else if ($bright <= 35) {
    	$bright = 35;
	} else if ($bright <= 39) {
    	$bright = 39;
	} else if ($bright <= 42) {
    	$bright = 42;
	} else if ($bright <= 46) {
    	$bright = 46;
	} else if ($bright <= 50) {
    	$bright = 50;
	} else if ($bright <= 54) {
    	$bright = 54;
	} else if ($bright <= 58) {
    	$bright = 58;
	} else if ($bright <= 62) {
    	$bright = 62;
	} else if ($bright <= 65) {
    	$bright = 65;
	} else if ($bright <= 69) {
    	$bright = 69;
	} else if ($bright <= 73) {
    	$bright = 73;
	} else if ($bright <= 77) {
    	$bright = 77;
	} else if ($bright <= 81) {
    	$bright = 81;
	} else if ($bright <= 85) {
    	$bright = 85;
	} else if ($bright <= 88) {
    	$bright = 88;
	} else if ($bright <= 92) {
    	$bright = 92;
	} else if ($bright <= 96) {
    	$bright = 96;
	} else if ($bright <= 100) {
	    $bright = 100;
	} else {
		$bright = 100;
	}
  
	return $bright;
}

function whiteBrightness( $bri ) {
	$bright = $bri;
	if ($bright <= 9) {
	    $bright = 9;
	} else if ($bright <= 18) {
    	$bright = 18;
  	} else if ($bright <= 27) {
   	 	$bright = 27;
  	} else if ($bright <= 36) {
    	$bright = 36;
  	} else if ($bright <= 45) {
    	$bright = 45;
  	} else if ($bright <= 54) {
    	$bright = 54;
  	} else if ($bright <= 63) {
    	$bright = 63;
  	} else if ($bright <= 72) {
    	$bright = 72;
  	} else if ($bright <= 81) {
    	$bright = 81;
  	} else if ($bright <= 90) {
    	$bright = 90;
  	} else if ($bright <= 100) {
    	$bright = 100;
  	} else {
		$bright = 100;
  	}
	return $bright;
}

function transmit($new_b, $old_b, $new_s, $old_s, $new_c, $old_c, $new_wt, $old_wt, $new_cm, $old_cm, $add1, $add2, $tra, $rgb, $cw, $ww)
{
	
	echo $new_b.", ". $old_b.", ". $new_s.", ". $old_s.", ". $new_c.", ". $old_c.", ". $new_wt.", ". $old_wt.", ". $new_cm.", ". $old_cm.", ". $add1.", ". $add2.", ". $tra.", ". $rgb.", ". $cw.", ". $ww;
  $trans = $tra;
  if ($cw == 1 && $ww == 1 && $rgb != 1) {
	  echo "White Bulb Transmit";
    $sendcommandbase = "sudo /usr/bin/transceiver -t 2 -q " . dechex($add1) . " -r " . dechex($add2) . " -c 01";

    // White Bulb Details

    $Brightness = array(
      9,
      18,
      27,
      36,
      45,
      54,
      63,
      72,
      81,
      90,
      100
    );
    $WhiteTemp = array(
      2700,
      3080,
      3460,
      3840,
      4220,
      4600,
      4980,
      5360,
      5740,
      6120,
      6500
    );
    if ($new_s != $old_s) {

      // Status Changed

      $trans = IncrementTransmissionNum($trans);
      if ($new_s == 1) {
        $sendcom = $sendcommandbase . " -k " . dechex((255 - $trans)) . " -v " . dechex($trans) . " -b 08";
      }
      else {
        $sendcom = $sendcommandbase . " -k " . dechex((255 - $trans)) . " -v " . dechex($trans) . " -b 0B";
      }

      exec($sendcom . ' > /dev/null &');
    } // End Status Change
    if ($new_s == 1) {

      // Status On

      if ($old_cm != $new_cm) {
        $trans = IncrementTransmissionNum($trans);

        // Color Mode Change

        if ($new_cm == 1) {
          $sendcom = $sendcommandbase . " -k " . dechex((255 - $trans)) . " -v " . dechex($trans) . " -b 18";
        }
        else {
          $sendcom = $sendcommandbase . " -k " . dechex((255 - $trans)) . " -v " . dechex($trans) . " -b 08";
        }

        exec($sendcom . ' > /dev/null &');
      }

      if ($new_b != $old_b || $old_cm != $new_cm) {

        // Brightness Change
        // Search Arrays for brightness values, reteieve Array positions of each Brightness value

        $old_pos = array_search($old_b, $Brightness);
        $new_pos = array_search($new_b, $Brightness);

        // Detect if there is a change to become Brighter

        if ($new_pos > $old_pos) {

          // Detect if brightness is being changed to 100% brightness. Issue 100% Brithgtness command

          if ($new_pos == array_search(100, $Brightness)) {
            $trans = IncrementTransmissionNum($trans);
            $sendcom = $sendcommandbase . " -k " . dechex((255 - $trans)) . " -v " . dechex($trans) . " -b 18";
            exec($sendcom . ' > /dev/null &');
          } else {
            // If not 100% brightness, calcuate how many Brightness positions to move. Issue correct amount of commands to increase Brightness to specified level

            $move = $new_pos - $old_pos;
            for ($x = 0; $x <= $move; $x++) {
              $trans = IncrementTransmissionNum($trans);
              $sendcom = $sendcommandbase . " -k " . dechex((255 - $trans)) . " -v " . dechex($trans) . " -b 0C";
              exec($sendcom . ' > /dev/null &');
            }
          }
          // Lower Brightness Detected
        } else {
          // calcuate how many Brightness positions to move. Issue correct amount of commands to decrease Brightness to specified level

          $move = $old_pos - $new_pos;
          for ($x = 0; $x <= $move; $x++) {
            $trans = IncrementTransmissionNum($trans);
            $sendcom = $sendcommandbase . " -k " . dechex((255 - $trans)) . " -v " . dechex($trans) . " -b 04";
            exec($sendcom . ' > /dev/null &');
          }
        }
      }

      if ($new_wt != $old_wt) {
        // White Temp Change
        // Search Arrays for White Temp values, reteieve Array positions of each White Temp value

        $old_pos = array_search($old_wt, $WhiteTemp);
        $new_pos = array_search($new_wt, $WhiteTemp);
        // Detect if White Temprature is getting warm

        if ($new_pos < $old_pos) {
          // Detect if new White Temp is 100% Warm. Issue 100% Warm White command

          $move = $old_pos - $new_pos;
          for ($x = 0; $x <= $move; $x++) {
            $trans = IncrementTransmissionNum($trans);
            $sendcom = $sendcommandbase . " -k " . dechex((255 - $trans)) . " -v " . dechex($trans) . " -b 0e";
            exec($sendcom . ' > /dev/null &');
          }
          // Else White Temprature is getting colder

        }
        else {
          // Detect if new White Temp is 100% Cold. Issue 100% Cold White command

          $move = $new_pos - $old_pos;
          for ($x = 0; $x <= $move; $x++) {
            $trans = IncrementTransmissionNum($trans);
            $sendcom = $sendcommandbase . " -k " . dechex((255 - $trans)) . " -v " . dechex($trans) . " -b 0f";
            exec($sendcom . ' > /dev/null &');
          }
        }
      }
    }
  }
  else
  if ($cw == 1 && $rgb == 1 || $ww == 1 && $rgb == 1) {
    $sendcommandbase = "sudo /usr/bin/transceiver -t 1 -q " . dechex($add1) . " -r " . dechex($add2);
    // RGBWW and RGBCW

    if ($new_s != $old_s) {
      // Status Changed

      $trans = IncrementTransmissionNum($trans);
      if ($new_s == 1) {
        $sendcom = $sendcommandbase . " -k 03 -c " . dechex($old_c) . " -b " . dechex($old_b) . " -v " . dechex($trans);
      }
      else {
        $sendcom = $sendcommandbase . " -k 04 -c " . dechex($old_c) . " -b " . dechex($old_b) . " -v " . dechex($trans);
      }
      exec($sendcom . ' > /dev/null &');
    }

    // End Status Change
    if ($new_s == 1) {
      // Status On

      if ($old_cm != $new_cm) {
        // Color Mode Change

        $trans = IncrementTransmissionNum($trans);
        if ($new_cm == 1) {
          $sendcom = $sendcommandbase . " -k 13 -b " . dechex($old_b) . " -v " . dechex($trans);
        }
        else {
          $sendcom = $sendcommandbase . " -k 03 -c " . dechex($old_c) . " -b " . dechex($old_b) . " -v " . dechex($trans);
        }
        exec($sendcom . ' > /dev/null &');
      }
      // End Color Mode Change

      if ($new_cm == 0) {
        // Color Mode Color
        if ($new_c != $old_c || $old_cm != $new_cm) {
          // Color Change
          $trans = IncrementTransmissionNum($trans);
          $initcom = $sendcommandbase . " -c " . dechex($new_c) . " -k 03 -v " . dechex($trans);
          exec($initcom . ' > /dev/null &');
          $trans = IncrementTransmissionNum($trans);
          $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -k 0f -v " . dechex($trans);
          exec($sendcom . ' > /dev/null &');
        }
        // End Color Change
      }

      // End Color Mode Color
      if ($new_b != $old_b) {
        // Brightness Change

        $trans = IncrementTransmissionNum($trans);
        if ($new_b == 4) {
          $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(129) . " -k 0e -v " . dechex($trans);
        }
        else
        if ($new_b == 8) {
          $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(121) . " -k 0e -v " . dechex($trans);
        }
        else
        if ($new_b == 12) {
          $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(113) . " -k 0e -v " . dechex($trans);
        }
        else
        if ($new_b == 15) {
          $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(105) . " -k 0e -v " . dechex($trans);
        }
        else
        if ($new_b == 19) {
          $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(97) . " -k 0e -v " . dechex($trans);
        }
        else
        if ($new_b == 23) {
          $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(89) . " -k 0e -v " . dechex($trans);
        }
        else
        if ($new_b == 27) {
          $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(81) . " -k 0e -v " . dechex($trans);
        }
        else
        if ($new_b == 31) {
          $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(73) . " -k 0e -v " . dechex($trans);
        }
        else
        if ($new_b == 35) {
          $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(65) . " -k 0e -v " . dechex($trans);
        }
        else
        if ($new_b == 39) { //10
          $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(57) . " -k 0e -v " . dechex($trans);
        }
        else
        if ($new_b == 42) { //11
          $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(49) . " -k 0e -v " . dechex($trans);
        }
        else
        if ($new_b == 46) { //12
          $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(41) . " -k 0e -v " . dechex($trans);
        }
        else
        if ($new_b == 50) { //13
          $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(33) . " -k 0e -v " . dechex($trans);
        }
        else
        if ($new_b == 54) { //14
          $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(25) . " -k 0e -v " . dechex($trans);
        }
        else
        if ($new_b == 58) { //15
          $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(17) . " -k 0e -v " . dechex($trans);
        }
        else
        if ($new_b == 62) { //16
          $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(9) . " -k 0e -v " . dechex($trans);
        }
        else
        if ($new_b == 65) { //17
          $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(1) . " -k 0e -v " . dechex($trans);
        }
        else
        if ($new_b == 69) { //18
          $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(249) . " -k 0e -v " . dechex($trans);
        }
        else
        if ($new_b == 73) { //19
          $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(241) . " -k 0e -v " . dechex($trans);
        }
        else
        if ($new_b == 77) { // 20
          $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(233) . " -k 0e -v " . dechex($trans);
        }
        else
        if ($new_b == 81) { // 21
          $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(225) . " -k 0e -v " . dechex($trans);
        }
        else
        if ($new_b == 85) { // 22
          $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(217) . " -k 0e -v " . dechex($trans);
        }
        else
        if ($new_b == 88) { // 23
          $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(209) . " -k 0e -v " . dechex($trans);
        }
        else
        if ($new_b == 92) { // 24
          $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(201) . " -k 0e -v " . dechex($trans);
        }
        else
        if ($new_b == 96) { // 25
          $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(193) . " -k 0e -v " . dechex($trans);
        }
        else
        if ($new_b == 100) { // 26
          $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(185) . " -k 0e -v " . dechex($trans);
        }
        exec($sendcom . ' > /dev/null &');
      }
      // End Brightness Change
    }
    // End Status On
  }
  return $trans;
}

// Set Default Error & Success Settings
$page_error = 0;
$page_success = 0;
$success_text = "";
$error = "";
// Timezone
$sql = "SELECT timezone FROM atomik_settings;";
$rs = $conn->query($sql);
if ($rs === false) {
  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
}
else {
  $db_records = $rs->num_rows;
}
$rs->data_seek(0);
$row = $rs->fetch_assoc();
$timezone = $row['timezone'];
$rs->free();
// Set Command

if ( isset($_POST["command"]) ) {
	$command = $_POST["command"];
} else {
	$command = "";
}
if (isset($_POST["zone_id"])) {
  $_zone_id = $_POST["zone_id"];
}
else {
  $_zone_id = "";
}
if (isset($_POST["zone_device"])) {
  $_zone_device = $_POST["zone_device"];
}
else {
  $_zone_device = "";
}
if (!isset($_POST["update_zone"])) {
	
  	$_update_zone = 0; }
else {
  $_update_zone = 1;
}

// Atomik Setting SQL
$sql = "SELECT atomik_devices.device_name, atomik_devices.device_id, atomik_device_types.device_type_rgb256, atomik_device_types.device_type_warm_white, atomik_device_types.device_type_cold_white, atomik_devices.device_status, atomik_devices.device_colormode, atomik_devices.device_brightness, atomik_devices.device_rgb256, atomik_devices.device_white_temprature, atomik_devices.device_address1, atomik_devices.device_address2, atomik_devices.device_transmission FROM atomik_devices, atomik_device_types WHERE atomik_devices.device_type = atomik_device_types.device_type_id && device_id NOT IN (SELECT zone_device_device_id FROM atomik_zone_devices);";
$rs = $conn->query($sql);
if ($rs === false) {
  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
}
else {
  $db_records = $rs->num_rows;
}

$rs->data_seek(0);

// Add Device to Zone (add_device)
if ($command <> "" && $command != "" && $command == "add_device") {
	$sql = "SELECT atomik_zones.zone_id, atomik_zones.zone_status, atomik_zones.zone_colormode, atomik_zones.zone_brightness, atomik_zones.zone_rgb256, atomik_zones.zone_white_temprature FROM atomik_zones WHERE atomik_zones.zone_id = ".$_zone_id.";";
	$zrs = $conn->query($sql);
	if ($zrs === false) {
  		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
	}

	$zrs->data_seek(0);
	$zrow = $zrs->fetch_assoc();
	
  $sql = "INSERT INTO atomik_zone_devices (zone_device_zone_id, zone_device_device_id, zone_device_last_update) VALUES (" . trim($_zone_id) . "," . trim($_zone_device) . ",CONVERT_TZ(NOW(), '" . $timezone . "', 'UTC') );";
  if ($conn->query($sql) === TRUE) {
    if ($_update_zone > 0) {
		
		$sql = "SELECT atomik_devices.device_name, atomik_devices.device_id, atomik_device_types.device_type_rgb256, atomik_device_types.device_type_warm_white, atomik_device_types.device_type_cold_white, atomik_devices.device_status, atomik_devices.device_colormode, atomik_devices.device_brightness, atomik_devices.device_rgb256, atomik_devices.device_white_temprature, atomik_devices.device_address1, atomik_devices.device_address2, atomik_devices.device_transmission FROM atomik_devices, atomik_device_types WHERE atomik_devices.device_type = atomik_device_types.device_type_id && atomik_devices.device_id=". trim($_zone_device) .";";
$drs = $conn->query($sql);
if ($drs === false) {
  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
}
$drs->data_seek(0);
		
		$row = $drs->fetch_assoc();
		$tra = transmit($zrow['zone_brightness'], $row['device_brightness'], $zrow['zone_status'], $row['device_status'], $zrow['zone_rgb256'], $row['device_rgb256'], $zrow['zone_white_temprature'], $row['device_white_temprature'], $zrow['zone_colormode'], $row['device_colormode'], $row['device_address1'], $row['device_address2'], $row['device_transmission'], $row['device_type_rgb256'], $row['device_type_cold_white'], $row['device_type_warm_white']);
		
		$sql = "UPDATE atomik_devices SET device_status = ".trim($zrow['zone_status']).", device_colormode = ".trim($zrow['zone_colormode']).", device_brightness = ".
		trim($zrow['zone_brightness']).", device_rgb256 = ".trim($zrow['zone_rgb256']).", device_white_temprature = ".trim($zrow['zone_white_temprature']).", device_transmission=".trim($tra)." WHERE device_id=".$_zone_device.";";
		if ($conn->query($sql) === TRUE) {
			$page_success = 1;
    		$success_text = "Zone Device Added To Zone DB!";
    		//echo "<br />";
    		//echo '<script type="text/javascript">' . "$().redirect('zone_details.php', {'zone_id': " . trim($_zone_id) . "});</script>";
  		}
	}	
    
  }
  else {
    $page_error = 1;
    $error_text = "Error Adding Device To Zone DB!";
  }
}


?></head>
<nav class="navbar navbar-default navbar-inverse">
  <div class="container-fluid"> 
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <a class="navbar-brand" id="atomikLogo"><img src="img/Sun_Logo_Menu_50px.gif" width="50" height="50" alt=""/></a></div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="dashboard.php">Dashboard</a> </li>
        <li><a href="settings.php">Settings</a> </li>
        <li><a href="devices.php">Devices</a> </li>
        <li><a href="remotes.php">Remotes</a> </li>
        <li class="active"><a href="zones.php">Zones<span class="sr-only">(current)</span></a> </li>
        <li><a href="tasks.php">Scheduled Tasks</a> </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a id="logoutbtn">Logout</a> </li>
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
        <div class="PageNavTitle" >
          <h3>Add Device to Zone</h3>
        </div>
    </div>
   </div><?php if ( $page_success || $page_error ) { ?><hr><?php } ?><?php if ( $page_success ) { ?><div class="alert alert-success">
  <strong>Success!</strong> <?php echo $success_text; ?>
</div><?php } ?><?php if ( $page_error ) { ?><div class="alert alert-danger">
  <strong>Danger!</strong> <?php echo $error_text; ?>
</div><?php } ?><hr>
  <br>
  <div class="container">
        <div class="col-xs-2"></div>
        <div class="col-xs-8">
        <form id="zonedevfrm" name="zonedevfrm" action="add_zone_device.php" method="post"><input name="zone_id" id="zone_id" type="hidden" value="<?php echo $_zone_id; ?>"><input name="command" id="command" type="hidden" value="add_device"> 
  <table class="table table-striped">
  <thead>
    <tr>
        <td width="200" >
         <h4><p>Please Select Device:</p></h4>
        </td>
        <td><p> &nbsp; <p></td>
    </tr>  
  </thead>
    <tbody>
    <tr>
        <td colspan="2"><p><select id="zone_device" name="zone_device" class="form-control">
 <?php while($row = $rs->fetch_assoc()){ ?> <option value="<?php echo $row['device_id']; ?>"><?php echo $row['device_name']; ?></option>
 <?php }; ?>
</select></p></td>
      </tr>
      <tr>
      <td><p>Set Device to Zone Settings: </p>
      </td>
      <td> <p><input name="update_zone" type="checkbox" class="form-control" value="1" id="update_zone"<?php if ( $_update_zone == 1 ) { ?> checked="checked"<?php }; ?> width="80"></label></p> </td>
      </tr>
      </tbody>
  </table></form>
</div>
<div class="col-xs-2"></div></div>
<div class="container">
<div class="col-xs-2"></div>
  <div class="col-xs-4 text-center"></div>
  <div class="col-xs-4 text-center"><p></p></div>
  <div class="col-xs-2"></div>
  </div>
  <?php if ( $page_success || $page_error ) { ?><hr><?php } ?><?php if ( $page_success ) { ?><div class="alert alert-success">
  <strong>Success!</strong> <?php echo $success_text; ?>
</div><?php } ?><?php if ( $page_error ) { ?><div class="alert alert-danger">
  <strong>Danger!</strong> <?php echo $error_text; ?>
</div><?php } ?><hr>
  <div class="container center">
  <div class="col-xs-2">
  </div>
  <div class="col-xs-1"><a href="zones.php"  class="btn-warning btn">Cancel</a>
  </div>
  <div class="col-xs-1"></div>
  <div class="col-xs-4">
  </div>
  <div class="col-xs-2 text-right"><a id="savedevicebtn" class="btn-success btn">Save</a>
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
    </div><script type="text/javascript">
    $("#logoutbtn").on('click', function() {
	$().redirect('logout.php', {'logout_title': 'Logout', 'description': 'You are now logged out of the Atomik Controller.'});
});
$("#savedevicebtn").on('click', function() {
	document.forms["zonedevfrm"].command.value = "add_device";
    document.zonedevfrm.submit();
});
</script>
</body><?php
$rs->free();
$conn->close();
?>
</html>