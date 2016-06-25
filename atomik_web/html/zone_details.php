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
<title>Atomik Controller - Zone Details</title>
<link rel="stylesheet" href="css/atomik.css">
<script src="js/jquery-1.12.3.min.js"></script>
<script src="js/jquery.redirect.min.js"></script>
<?php 

function deleteCRON( $task_id ) {
	
	// Text to Match
	$word = " Atomik: ".$task_id."-";
	$com = "crontab -l | sed -e '/".$word."/d'";
	//get contents of cron tab without reference to deleted cron
	$content = shell_exec($com);
	
	echo "Deleteing Crons!";
	// Get Rid Of New Lines
	$content = str_replace("\n\n\n","\n",$content);
	
	// Save New Crontab To File
	file_put_contents('/tmp/crontab.txt', $content.PHP_EOL);
	
	// Save Cron
	exec('crontab /tmp/crontab.txt');
 
}

function IncrementTransmissionNum($number)
{
  $trans = $number + 1;
  if ($trans >= 256) {
    $trans = $trans - 256;
  }
  return $trans;
}

function Check0to255( $input )
{
	if (preg_match("/^[0-9]+$/", $input)) {
		if (  ( $input >= 0 ) && ( $input <= 255 ) ) {
			return 1;
		}
	}
	return 0;
}

function Check0to100( $input )
{
	if (preg_match("/^[0-9]+$/", trim($input))) {
		if ( ( $input >= 0 ) && ( $input <= 100 ) ) {
			return 1;
		}
	}
	return 0;
}

function Check2700to6500( $input )
{
	if (preg_match("/^[0-9]+$/", $input)) {
		if ( ( $input >= 2700 ) && ( $input <= 6500 ) ) {
			return 1;
		}
	}
	return 0;
}


function transmit($new_b, $old_b, $new_s, $old_s, $new_c, $old_c, $new_wt, $old_wt, $new_cm, $old_cm, $add1, $add2, $tra, $rgb, $cw, $ww)
{
  $trans = $tra;
  if ($cw == 1 && $ww == 1 && $rgb != 1) {
    $sendcommandbase = "sudo /usr/bin/transceiver -t 2 -q " . dechex($add1) . " -r " . dechex($add2) . " -c 01";

    // White Bulb Details

    $Brightness = array(9, 18, 27, 36, 45, 54, 63, 72, 81, 90, 100);
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

      echo $sendcom;
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

        echo $sendcom;
        exec($sendcom . ' > /dev/null &');

	  }

      if ($new_b != $old_b) {
        // Brightness Change

        if ($new_b <= 9) {
          $new_b = 9;
        }
        else
        if ($new_b <= 18) {
            $new_b = 18;
          }
          else
          if ($new_b <= 27) {
            $new_b = 27;
          }
          else
          if ($new_b <= 36) {
            $new_b = 36;
          }
          else
          if ($new_b <= 45) {
            $new_b = 45;
          }
          else
          if ($new_b <= 54) {
            $new_b = 54;
          }
          else
          if ($new_b <= 63) {
            $new_b = 63;
          }
          else
          if ($new_b <= 72) {
            $new_b = 72;
          }
          else
          if ($new_b <= 81) {
            $new_b = 81;
          }
          else
          if ($new_b <= 90) {
            $new_b = 90;
          }
          else
          if ($new_b <= 100) {
            $new_b = 100;
          }

          if ($old_b <= 9) {
            $old_b = 9;
          }
          else
          if ($old_b <= 18) {
            $old_b = 18;
          }
          else
          if ($old_b <= 27) {
            $old_b = 27;
          }
          else
          if ($old_b <= 36) {
            $old_b = 36;
          }
          else
          if ($old_b <= 45) {
            $old_b = 45;
          }
          else
          if ($old_b <= 54) {
            $old_b = 54;
          }
          else
          if ($old_b <= 63) {
            $old_b = 63;
          }
          else
          if ($old_b <= 72) {
            $old_b = 72;
          }
          else
          if ($old_b <= 81) {
            $old_b = 81;
          }
          else
          if ($old_b <= 90) {
            $old_b = 90;
          }
          else
          if ($old_b <= 100) {
            $old_b = 100;
          }

          $old_pos = array_search($old_b, $Brightness);
          $new_pos = array_search($new_b, $Brightness);
          if ($new_pos > $old_pos) {
            if ($new_pos == array_search(100, $Brightness)) {
              $trans = IncrementTransmissionNum($trans);

              $sendcom = $sendcommandbase . " -k " . dechex((255 - $trans)) . " -v " . dechex($trans) . " -b 18";
              echo $sendcom;
              exec($sendcom . ' > /dev/null &');
            }
            else {
              $move = $new_pos - $old_pos;
              for ($x = 0; $x <= $move; $x++) {
                $trans = IncrementTransmissionNum($trans);

                $sendcom = $sendcommandbase . " -k " . dechex((255 - $trans)) . " -v " . dechex($trans) . " -b 0C";
                echo $sendcom;
                exec($sendcom . ' > /dev/null &');
              }
            }
          }
          else {
            $move = $old_pos - $new_pos;
            for ($x = 0; $x <= $move; $x++) {
              $trans = IncrementTransmissionNum($trans);

              $sendcom = $sendcommandbase . " -k " . dechex((255 - $trans)) . " -v " . dechex($trans) . " -b 04";
              echo $sendcom;
              exec($sendcom . ' > /dev/null &');
            }
          }
        }

        if ($new_wt != $old_wt) {

          // White Temp Change

          $old_pos = array_search($old_wt, $WhiteTemp);
          $new_pos = array_search($new_wt, $WhiteTemp);
          if ($new_pos > $old_pos) {
            $move = $new_pos - $old_pos;
            for ($x = 0; $x <= $move; $x++) {
              $trans = IncrementTransmissionNum($trans);
              $sendcom = $sendcommandbase . " -k " . dechex((255 - $trans)) . " -v " . dechex($trans) . " -b 0f";
              echo $sendcom;
              exec($sendcom . ' > /dev/null &');
            }
          }
          else {
            $move = $old_pos - $new_pos;
            for ($x = 0; $x <= $move; $x++) {
              $trans = IncrementTransmissionNum($trans);
              $sendcom = $sendcommandbase . " -k " . dechex((255 - $trans)) . " -v " . dechex($trans) . " -b 0e";
              echo $sendcom;
              exec($sendcom . ' > /dev/null &');
            }
          }
        }
      }
	  
  } else if ($cw == 1 && $rgb == 1 || $ww == 1 && $rgb == 1) {
      $sendcommandbase = "sudo /usr/bin/transceiver -t 1 -q " . dechex($add1) . " -r " . dechex($add2);

      // RGBWW and RGBCW

      if ($new_s != $old_s) {

        // Status Changed

        $trans = IncrementTransmissionNum($trans);

        if ($new_s == 1) {
          $sendcom = $sendcommandbase . " -k 03 -v " . dechex($trans);
        }
        else {
          $sendcom = $sendcommandbase . " -k 04 -v " . dechex($trans);
        }

        echo $sendcom;
        exec($sendcom . ' > /dev/null &');
      }

      // End Status Change

      if ($new_s == 1) {

        // Status On

        if ($old_cm != $new_cm) {

          // Color Mode Change

          $trans = IncrementTransmissionNum($trans);

          echo 'current CM: ' . $new_cm . '\n';
          if ($new_cm == 1) {
            $sendcom = $sendcommandbase . " -k 13 -v " . dechex($trans) . " -c " . dechex($old_c);
          }
          else {
            $sendcom = $sendcommandbase . " -k 03 -v " . dechex($trans) . " -c " . dechex($old_c);
          }

          echo $sendcom;
          exec($sendcom . ' > /dev/null &');
        }

        // End Color Mode Change > /dev/null &

        if ($new_cm == 0) {

          // Color Mode Color

          if ($new_c != $old_c || $old_cm != $new_cm) {

            // Color Change

            $trans = IncrementTransmissionNum($trans);

            $initcom = $sendcommandbase . " -c " . dechex($new_c) . " -k 03 -v " . dechex($trans);
            exec($initcom . ' > /dev/null &');
            echo $initcom;
            $trans = IncrementTransmissionNum($trans);

            $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -k 0f -v " . dechex($trans);
            echo $sendcom;
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

          echo $sendcom;
          exec($sendcom . ' > /dev/null &');
        }

        // End Brightness Change

      }

      // End Status On

    }

    return $trans;
  }
//


function updateZone($db, $zon, $new_b,  $new_s,  $new_c,  $new_wt,  $new_cm, $tz) {

	$success = TRUE;

	$sql = "SELECT atomik_devices.device_id, atomik_devices.device_status, atomik_devices.device_colormode, 
	atomik_devices.device_brightness, 
	atomik_devices.device_rgb256, 
	atomik_devices.device_white_temprature, 
	atomik_devices.device_address1, 
	atomik_devices.device_address2,
	atomik_device_types.device_type_rgb256, 
	atomik_device_types.device_type_warm_white, 
	atomik_device_types.device_type_cold_white,
	atomik_devices.device_transmission 
	FROM 
	atomik_zone_devices, atomik_device_types, atomik_devices 
	WHERE 
	atomik_zone_devices.zone_device_zone_id=".$zon." && atomik_zone_devices.zone_device_device_id=atomik_devices.device_id && 
atomik_devices.device_type=atomik_device_types.device_type_id && 
atomik_device_types.device_type_brightness=1 ORDER BY atomik_devices.device_type ASC;";	

	$uzrs=$db->query($sql);
 
	if($uzrs === false) {
	  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
	  $success = FALSE;
	} else {
  		$_zone_devices = $uzrs->num_rows;
		$uzrs->data_seek(0);

		while($rowuzrs = $uzrs->fetch_assoc()){ 
    		$old_b = $rowuzrs['device_brightness']; 
			$old_s = $rowuzrs['device_status']; 
			$old_c = $rowuzrs['device_rgb256']; 
			$old_wt = $rowuzrs['device_white_temprature']; 
			$old_cm = $rowuzrs['device_colormode']; 
			$add1 = $rowuzrs['device_address1']; 
			$add2 = $rowuzrs['device_address2']; 
			$tra = $rowuzrs['device_transmission']; 
			$rgb = $rowuzrs['device_type_rgb256']; 
			$cw = $rowuzrs['device_type_cold_white']; 
			$ww = $rowuzrs['device_type_warm_white']; 
			$dev_id = $rowuzrs['device_id']; 
			
			// Transmit New Commands to each Device in Zone
			$tra = transmit($new_b, $old_b, $new_s, $old_s, $new_c, $old_c, $new_wt, $old_wt, $new_cm, $old_cm, $add1, $add2, $tra, $rgb, $cw, $ww);
			
			// Update Devices with new Properties 
			$sql = "UPDATE atomik_devices SET device_status = ".trim($new_s).", device_colormode = ".trim($new_cm).", device_brightness = ".
		trim($new_b).", device_rgb256 = ".trim($new_c).", device_white_temprature = ".trim($new_wt).", device_transmission = ".trim($tra)." WHERE device_id=".$dev_id.";";
			if ($db->query($sql) === TRUE) {
    			$success = TRUE;
			} else {
				$success = FALSE;
			}
		}
		
	
		$sql = "UPDATE atomik_zone_devices SET zone_device_last_update = CONVERT_TZ(NOW(), '".$tz."', 'UTC') WHERE zone_device_zone_id=".$zon.";";
		if ($db->query($sql) === TRUE) {
    		$success = TRUE;
		} else {
			$success = FALSE;
		}



		$sql = "UPDATE atomik_zones SET zone_status = ".trim($new_s).", zone_colormode = ".trim($new_cm).", zone_brightness = ".
		trim($new_b).", zone_rgb256 = ".trim($new_c).", zone_white_temprature = ".trim($new_wt).",zone_last_update = CONVERT_TZ(NOW(), '".$tz."', 'UTC') WHERE zone_id=".$zon.";";
		if ($db->query($sql) === TRUE) {
   			$success = TRUE;
		} else {
			$success = FALSE;
		}
	}
	$uzrs->free();
	return $success;
}


function processErrors($ers)
{
	$error_text = "";
	$i = 0;
	$prefix = '';
	$len = count($ers);
	foreach ($ers as $er)
	{
    	$error_text .= $prefix . $er;
    	$prefix = ', ';
		if ($i == $len - 2 && $len != 2) {
       		$prefix = ', and ';
    	} else if ($i == $len - 2 && $len == 2) {
			$prefix = ' and ';
		}
		$i++;
	}
	$error_text .= '.';
	return $error_text;
}

// Timezone

$sql = "SELECT timezone FROM atomik_settings;";
$rs=$conn->query($sql);
if($rs === false) {
  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
} else {
  $db_records = $rs->num_rows;
}
$rs->data_seek(0);
$row = $rs->fetch_assoc();
$timezone = $row['timezone'];
$rs->free();

// Set Default Error & Success Settings
$page_error = 0;
$page_success = 0;
$success_text = "";
$error = "";

// Set Command

if ( isset($_POST["command"]) ) {
	$command = $_POST["command"];
} else {
	$command = "";
}


if ( isset($_POST["remote_channel_id"]) ) {
	$_remote_channel_id = $_POST["remote_channel_id"];
} else {
	$_remote_channel_id = "0";
}

if ( isset($_POST["new_zone"]) ) {
	$_new_zone = $_POST["new_zone"];
} else {
	$_new_zone = "0";
}

if ( isset($_POST["zone_id"]) ) {
	$_zone_id = $_POST["zone_id"];
} else {
	$_zone_id = "";
}

if ( isset($_POST["zone_device_id"]) ) {
	$_zone_device_id = $_POST["zone_device_id"];
} else {
	$_zone_device_id = "0";
}

if ( isset($_POST["zone_remote_id"]) ) {
	$_zone_remote_id = $_POST["zone_remote_id"];
} else {
	$_zone_remote_id = "0";
}

if ( $_new_zone == 0 ) {
// Atomik Setting SQL
	$sql = "SELECT atomik_zones.zone_id, atomik_zones.zone_name, atomik_zones.zone_description, atomik_zones.zone_status, atomik_zones.zone_colormode, atomik_zones.zone_brightness, atomik_zones.zone_rgb256, atomik_zones.zone_white_temprature FROM atomik_zones WHERE atomik_zones.zone_id = ".$_zone_id.";";  

	$rs=$conn->query($sql);
 
	if($rs === false) {
 		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
	} 

	$rs->data_seek(0);
	$row = $rs->fetch_assoc();

	$sql = "SELECT 
atomik_device_types.device_type_rgb256, 
atomik_device_types.device_type_warm_white, 
atomik_device_types.device_type_cold_white, 
atomik_device_types.device_type_brightness 
FROM 
atomik_zone_devices, atomik_device_types, atomik_devices 
WHERE 
atomik_zone_devices.zone_device_zone_id=".$_zone_id." &&
atomik_zone_devices.zone_device_device_id=atomik_devices.device_id && 
atomik_devices.device_type=atomik_device_types.device_type_id && 
atomik_device_types.device_type_warm_white=1;";  

	$wwrs=$conn->query($sql);
 
	if($wwrs === false) {
	  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
	} else {
		if ( $wwrs->num_rows >= 1 ) {
	  		$_zone_type_warm_white = 1;
		} else {
			$_zone_type_warm_white = 0;
		}
	}
	$wwrs->free();
	
	$sql = "SELECT 
atomik_device_types.device_type_rgb256, 
atomik_device_types.device_type_warm_white, 
atomik_device_types.device_type_cold_white, 
atomik_device_types.device_type_brightness 
FROM 
atomik_zone_devices, atomik_device_types, atomik_devices 
WHERE 
atomik_zone_devices.zone_device_zone_id=".$_zone_id." &&
atomik_zone_devices.zone_device_device_id=atomik_devices.device_id && 
atomik_devices.device_type=atomik_device_types.device_type_id && 
atomik_device_types.device_type_cold_white=1;";  

	$cwrs=$conn->query($sql);
 
	if($cwrs === false) {
  		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
	} else {
		if ( $cwrs->num_rows >= 1 ) {
  			$_zone_type_cold_white = 1;
		} else {
			$_zone_type_cold_white = 0;
		}
	}
	$cwrs->free();
		
	$sql = "SELECT atomik_device_types.device_type_rgb256, atomik_device_types.device_type_warm_white, atomik_device_types.device_type_cold_white, atomik_device_types.device_type_brightness FROM atomik_zone_devices, atomik_device_types, atomik_devices WHERE atomik_zone_devices.zone_device_zone_id=".$_zone_id." && atomik_zone_devices.zone_device_device_id=atomik_devices.device_id && atomik_devices.device_type=atomik_device_types.device_type_id && atomik_device_types.device_type_rgb256=1;";  

	$rgbrs=$conn->query($sql);
 
	if($rgbrs === false) {
	  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
	} else {
		if ( $rgbrs->num_rows >= 1 ) {
 			$_zone_type_rgb256 = 1;
		} else {
			$_zone_type_rgb256 = 0;
		}
	}
	$rgbrs->free();

	$sql = "SELECT 
atomik_device_types.device_type_rgb256, 
atomik_device_types.device_type_warm_white, 
atomik_device_types.device_type_cold_white, 
atomik_device_types.device_type_brightness 
FROM 
atomik_zone_devices, atomik_device_types, atomik_devices 
WHERE 
atomik_zone_devices.zone_device_zone_id=".$_zone_id." &&
atomik_zone_devices.zone_device_device_id=atomik_devices.device_id && 
atomik_devices.device_type=atomik_device_types.device_type_id && 
atomik_device_types.device_type_brightness=1;";   

	$brs=$conn->query($sql);
 
	if($brs === false) {
  		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
	} else {
		if ( $brs->num_rows >= 1 ) {
  			$_zone_type_brightness = 1;
		} else {
			$_zone_type_brightness = 0;
		}
	}
	$brs->free();
}

$sql = "SELECT atomik_remotes.remote_id From atomik_remotes WHERE atomik_remotes.remote_type = 3;";

$remavrs=$conn->query($sql);
 
if($remavrs === false) {
	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
} else {
	if ( $remavrs->num_rows >= 1 ) {
		$_remotes_available = 1;
	} else {

		$sql = "SELECT atomik_remote_channels.remote_channel_id FROM atomik_remote_channels WHERE atomik_remote_channels.remote_channel_zone_id = 0;";

   		$regremavrs=$conn->query($sql);
 
		if($regremavrs === false) {
			trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
		} else {
			if ( $regremavrs->num_rows >= 1 ) {
  				$_remotes_available = 1;
			} else {
				$_remotes_available = 0;
			}
		}
	}
}

$remavrs->free();

if ( isset($_POST["zone_name"])) {
	$_zone_name = $_POST["zone_name"];
} else {
	if ($_new_zone == 0 ) {
		$_zone_name = $row['zone_name'];
	} else {
		$_zone_name = "";
	}
}

if ( isset($_POST["zone_description"])) {
	$_zone_description = $_POST["zone_description"];
} else {
	if ($_new_zone == 0 ) {
		$_zone_description = $row['zone_description'];
	} else {
		$_zone_description = "";
	}
}

if ( isset($_POST["zone_status"])) {
	$_zone_status = $_POST["zone_status"];
} else {
	if ($_new_zone == 0 ) {
		$_zone_status = $row['zone_status'];
	} else {
		$_zone_status = "";
	}
}

if ( isset($_POST["zone_colormode"])) {
	$_zone_colormode = $_POST["zone_colormode"];
} else {
	if ($_new_zone == 0 ) {
		$_zone_colormode = $row['zone_colormode'];
	} else {
		$_zone_colormode = 1;
	}
}

if ( isset($_POST["zone_brightness"])) {
	$_zone_brightness = $_POST["zone_brightness"];
} else {
	if ($_new_zone == 0 ) {
		$_zone_brightness = $row['zone_brightness'];
	} else {
		$_zone_brightness = 0;
	}
}

if ( isset($_POST["zone_rgb256"])) {
	$_zone_rgb256 = $_POST["zone_rgb256"];
} else {
	if ($_new_zone == 0 ) {
		$_zone_rgb256 = $row['zone_rgb256'];
	} else {
		$_zone_rgb256 = 0;
	}
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

if ( isset($_POST["zone_white_temprature"])) {
	$_zone_white_temprature = $_POST["zone_white_temprature"];
} else {
	if ($_new_zone == 0 ) {
		$_zone_white_temprature = $row['zone_white_temprature'];
	} else {
		$_zone_white_temprature = 2700;
	}
}

if ($_zone_white_temprature <= 2700) {
	$_zone_white_temprature = 2700;
} else if ($_zone_white_temprature <= 3080) {
	$_zone_white_temprature = 3080;
} else if ($_zone_white_temprature <= 3460) {
	$_zone_white_temprature = 3460;
} else if ($_zone_white_temprature <= 3840) {
	$_zone_white_temprature = 3840;
} else if ($_zone_white_temprature <= 4220) {
	$_zone_white_temprature = 4220;
} else if ($_zone_white_temprature <= 4600) {
	$_zone_white_temprature = 4600;
} else if ($_zone_white_temprature <= 4980) {
	$_zone_white_temprature = 4980;
} else if ($_zone_white_temprature <= 5360) {
	$_zone_white_temprature = 5360;
} else if ($_zone_white_temprature <= 5740) {
	$_zone_white_temprature = 5740;
} else if ($_zone_white_temprature <= 6120) {
	$_zone_white_temprature = 6120;
} else if ($_zone_white_temprature <= 6500) {
	$_zone_white_temprature = 6500;
} 

$_zone_brightness = colorBrightness($_zone_brightness);

// Save General Zone Settings [Keep Post Data, Verify Form, DB] (save_general)
if ($command <> "" && $command !="" && $command == "save_general") 
{	
	$erro = array();
	if ($_new_zone == 1 )
	{
		if (!preg_match("/^[a-zA-Z0-9. -]+$/", $_zone_name)) {
			array_push($erro, "Zone Name Contains Illegal Characters, Please Only Use Letters, Numbers, Spaces, Periods, and Dashes");
			$_error_zone_name = 1;
		}
		
		if ( !( ( !empty($_zone_description) && preg_match("/^[a-zA-Z0-9. -]+$/", $_zone_description) ) || empty($_zone_description) ) ) {
			array_push($erro, "Zone Description Contains Illegal Characters, Please Only Use Letters, Numbers, Spaces, Periods, and Dashes");
			$_error_zone_description = 1;
		}
		
	} else {
		if ( $_zone_name == $row['zone_name'] && $_zone_description == $row['zone_description'] )
		{
			array_push($erro, "No Changes To Save");
		} else {
			if (!preg_match("/^[a-zA-Z0-9. -]+$/", $_zone_name)) {
				array_push($erro, "Zone Name Contains Illegal Characters, Please Only Use Letters, Numbers, Spaces, Periods, and Dashes");
				$_error_zone_name = 1;
			}
		
			if ( !( ( !empty($_zone_description) && preg_match("/^[a-zA-Z0-9. -]+$/", $_zone_description) ) || empty($_zone_description) ) ) {
				array_push($erro, "Zone Description  Contains Illegal Characters, Please Only Use Letters, Numbers, Spaces, Periods, and Dashes");
				$_error_zone_description = 1;
			}
		}
	}
	
	if (count($erro) > 0) 
	{
		$page_error = 1;
		$error_text = processErrors($erro);	
	} else {
		

		if ( $_new_zone == 1 ) {
			$sql = "INSERT INTO atomik_zones (zone_name, zone_description, zone_last_update) VALUES ('".$_zone_name."','".$_zone_description."', CONVERT_TZ(NOW(), '".$timezone."', 'UTC') )";
			if ($conn->query($sql) === TRUE) {
    			
				$_new_zone = 0;
				$_zone_id = $conn->insert_id;
				$page_success = 1;
				$success_text = "General Zone Details Added to DB!";
								
			} else {
    			$page_error = 1;
				$error_text = "Error Inserting Zone Details To DB!";
			}
		} else {
			$sql = "UPDATE atomik_zones SET atomik_zones.zone_name='".trim($_zone_name)."', atomik_zones.zone_description='".trim($_zone_description)."', zone_last_update = CONVERT_TZ(NOW(), '".$timezone."', 'UTC') WHERE atomik_zones.zone_id=".trim($_zone_id).";";
			if ($conn->query($sql) === TRUE) {
    			$page_success = 1;
				$success_text = "General Zone Details Updated!";
			} else {
    			$page_error = 1;
				$error_text = "Error Saving General Zone Details To DB!";
			}
		}
	}		
}

// Update Zone Propeties [Keep Post Data, Verify Form, DB] (save_properties)
if ($command <> "" && $command !="" && $command == "save_properties") 
{	
	$erro = array();
	if ($_new_zone == 1 )
	{
		array_push($erro, "Please Save General Zone Details Before Saving Zone Properties");	
	} else {
		if ( $_zone_status == $row['zone_status'] && $_zone_colormode == $row['zone_colormode'] && $_zone_brightness == $row['zone_brightness'] && $_zone_rgb256 == $row['zone_rgb256'] && $_zone_white_temprature == $row['zone_white_temprature'] ) {
			array_push($erro, "No Changes To Save");
		} else {
			if ( $_zone_type_brightness == 1 ) {
				if (!Check0to100 ( $_zone_brightness )) {
					array_push($erro, "Zone Brightness Must Be A Number Between 0 and 100");
					$_error_zone_brightness = 1;
				}
			}
			
			if ( $_zone_type_rgb256 == 1 && $_zone_colormode == 0 ) {
				if (!Check0to255 ( $_zone_rgb256)) {
					array_push($erro, "Zone Color Must Be A Number Between 0 and 255");
					$_error_zone_rgb256 = 1;
				}
			}
			
			if ( $_zone_type_cold_white == 1 && $_zone_type_warm_white == 1 && $_zone_colormode == 1 ) {
				if (!Check2700to6500 ( $_zone_white_temprature )) {
					array_push($erro, "Zone White Temprature Must Be A Number Between 2700 and 6500");
					$_error_zone_white_temprature = 1;
				}
			}	
		}	
	}
	
	if (count($erro) > 0) 
	{
		$page_error = 1;
		$error_text = processErrors($erro);	
	} else {
		if($_zone_colormode == 1 && $row['zone_colormode'] == 0) {
				$_zone_brightness = 100;
		}
		if (updateZone($conn, $_zone_id, $_zone_brightness, $_zone_status, $_zone_rgb256, $_zone_white_temprature, $_zone_colormode, $timezone)) {
			$page_success = 1;
			$success_text = "Zone Properties Updated!";
		} else {
    		$page_error = 1;
			$error_text = "Error Updateing and Saving Zone Properties To DB!";
		}
	}		
}

// Add Device to Zone (add_device)
if ($command <> "" && $command !="" && $command == "add_device") 
{	
	$erro = array();
	
	if ($_new_zone == 1 )
	{
		array_push($erro, "Please Save General Zone Details Before Adding A Device");	
	} else {
		
		if (!($_zone_name == $row['zone_name'] && $_zone_description == $row['zone_description']) )
		{
			array_push($erro, "Please Save Changes to Zone Details Before Adding A Device");	
		}
		
		$sql = 'SELECT atomik_devices.device_name, atomik_devices.device_id FROM atomik_devices WHERE device_id NOT IN (SELECT zone_device_device_id FROM atomik_zone_devices)';
		$cdrs=$conn->query($sql);
 		
		if($cdrs === false) {
  			trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
		} else {
  			$_available_devices = $cdrs->num_rows;
		}		
		if ($_available_devices == 0 )
		{
			array_push($erro, "No Devices Available To Add To Zone");	
		}
	}
	
	if (count($erro) > 0) 
	{
		$page_error = 1;
		$error_text = processErrors($erro);	
	} else {
		echo "<BR>";
		echo '<script type="text/javascript">'."$().redirect('add_zone_device.php', {'zone_id': ".trim($_zone_id)."});</script>";			
	}		
}

// Add Remote to Zone (add_remote)
if ($command <> "" && $command !="" && $command == "add_remote") 
{	

	$erro = array();
	if ($_new_zone == 1 )
	{
		array_push($erro, "Please Save General Zone Details Before Adding A Remote");	
	}  else {
		if (!($_zone_name == $row['zone_name'] && $_zone_description == $row['zone_description']) )
		{
			array_push($erro, "Please Save Changes to Zone Details Before Adding A Remote");	
		}		
	}
	
	if ($_remotes_available == 0 )
	{
		array_push($erro, "No Remotes Available To Add To Zone");	
	}
		
	if (count($erro) > 0) 
	{
		$page_error = 1;
		$error_text = processErrors($erro);	
	} else {
		echo "<BR>";
		echo '<script type="text/javascript">'."$().redirect('add_zone_remote.php', {'zone_id': ".trim($_zone_id)."});</script>";			
	}		
}

// Remove Device from Zone (remove_device)
if ($command <> "" && $command !="" && $command == "remove_device") 
{	
	$sql="DELETE FROM atomik_zone_devices WHERE zone_device_id=".trim($_zone_device_id).";";
 	if($conn->query($sql) === false) {
		$page_error = 1;
		$error_text = "Error Deleting Zone Device From Zone DB!";
	} else {
		$page_success = 1;
		$success_text = "Zone Device Removed!";
	}
}

// Remove Device from Zone (remove_remote)
if ($command <> "" && $command !="" && $command == "remove_remote") 
{	
	$sql = "SELECT atomik_remote_channels.remote_channel_id, atomik_remote_channels.remote_channel_zone_id, atomik_remote_channels.remote_channel_remote_id, atomik_remote_channels.remote_channel_number, atomik_remotes.remote_id, atomik_remotes.remote_name, atomik_remotes.remote_type FROM atomik_remotes, atomik_remote_channels WHERE atomik_remote_channels.remote_channel_remote_id=atomik_remotes.remote_id && atomik_remote_channels.remote_channel_id=".trim($_remote_channel_id).";";
	
	$rdchrs=$conn->query($sql);
 
	if($rdchrs === false) {
  	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
	} else {

		$rdchrs->data_seek(0);
		$rdchrs_row = $rdchrs->fetch_assoc();
	
		if ($rdchrs_row['remote_type'] == 3) {
			$sql="DELETE FROM atomik_remote_channels WHERE atomik_remote_channels.remote_channel_id=".trim($_remote_channel_id)." && atomik_remote_channels.remote_channel_remote_id=".trim($rdchrs_row['remote_channel_remote_id'])." && atomik_remote_channels.remote_channel_zone_id=".trim($rdchrs_row['remote_channel_zone_id'])." && atomik_remote_channels.remote_channel_number=".trim($rdchrs_row['remote_channel_number']).";";
			
		  	if($conn->query($sql) === false) {
				$page_error = 1;
				$error_text = "Error Deleting Zone Remote Channels From Zone DB!";
			}	 
		} else {
			
			$sql="UPDATE atomik_remote_channels set remote_channel_zone_id=0 WHERE remote_channel_id=".trim($_remote_channel_id).";";
			
			if($conn->query($sql) === false) {
				$page_error = 1;
				$error_text = "Error Removing MiLight Remote Channels From Zone DB!";
			}
		}
		$sql="DELETE FROM atomik_zone_remotes WHERE zone_remote_remote_id=".trim($rdchrs_row['remote_channel_remote_id'])." && zone_remote_zone_id=".trim($rdchrs_row['remote_channel_zone_id'])." && zone_remote_channel_number=".trim($rdchrs_row['remote_channel_number']).";";
				
		if($conn->query($sql) === false) {
			$page_error = 1;
			$error_text = "Error Deleting Zone Remote From Zone DB!";
		} else {
			$page_success = 1;
			$success_text = "Zone Remote Removed!";
		}
		
	}
}

// Delete Zone (delete_zone)
if ($command <> "" && $command !="" && $command == "delete_zone") 
{	

	if ($_new_zone == 1 )
	{
		header('Location: zones.php');
	} else {
		$sql="DELETE FROM atomik_zones WHERE zone_id=".trim($_zone_id).";";
 
		if($conn->query($sql) === false) {
			$page_error = 1;
			$error_text = "Error Deleting Zone From Zone DB!";
		} else {
		
			$sql="DELETE FROM atomik_zone_devices WHERE zone_device_zone_id=".trim($_zone_id).";";
 
			if($conn->query($sql) === false) {
				$page_error = 1;
				$error_text = "Error Deleting Devices From Zone DB!";
			}  else {
				
				$sql="DELETE FROM atomik_zone_remotes WHERE zone_remote_zone_id=".trim($_zone_id).";";
 
				if($conn->query($sql) === false) {
					$page_error = 1;
					$error_text = "Error Deleting Devices From Zone DB!";
				}  else {
				
					$sql="DELETE FROM atomik_remote_channels WHERE EXISTS( SELECT atomik_remote_channels.remote_channel_id FROM atomik_remotes WHERE atomik_remote_channels.remote_channel_remote_id=atomik_remotes.remote_id && atomik_remotes.remote_type=3 && atomik_remote_channels.remote_channel_zone_id=".$_zone_id." );";
 
					if($conn->query($sql) === false) {
						$page_error = 1;
						$error_text = "Error Deleting Atomik Remote Channels From Zone DB!";
					} else {
						$sql="UPDATE atomik_remote_channels set remote_channel_zone_id=0 WHERE remote_channel_zone_id=".$_zone_id.";";
 
 						if($conn->query($sql) === false) {
							$page_error = 1;
							$error_text = "Error Removing MiLight Remotes From Zone DB!";
						} else {
							
							$sql = "SELECT atomik_tasks.task_id FROM atomik_tasks WHERE atomik_tasks.task_zone_id=".trim($_zone_id).";";
							$ztrs=$conn->query($sql);
 
							if($ztrs === false) {
								trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
							} else {
								$ztrs->data_seek(0);
	
								 while($ztrs_row = $ztrs->fetch_assoc()){
									deleteCRON ($ztrs_row['task_id']);
								}
								$ztrs->free();
								
								$sql="DELETE FROM atomik_tasks WHERE atomik_tasks.task_zone_id=".$_zone_id.";";
 
								if($conn->query($sql) === false) {
									$page_error = 1;
									$error_text = "Error Deleting Atomik Zone from Atomik Tasks DB!";
								} else {
									$page_success = 1;
									$success_text = "Zone Deleted!";
									header('Location: zones.php');	
								}
							}
						}
					}
				}
			}
		}
	}
}

if ( $_new_zone == 0 ) {
// Atomik Zone Remotes SQL
$sql = "SELECT atomik_remote_channels.remote_channel_id, atomik_remote_channels.remote_channel_remote_id, atomik_remote_channels.remote_channel_name, atomik_remotes.remote_name, atomik_remote_types.remote_type_name FROM atomik_remote_types, atomik_remotes, atomik_remote_channels WHERE atomik_remote_channels.remote_channel_remote_id=atomik_remotes.remote_id && atomik_remotes.remote_type=atomik_remote_types.remote_type_id && atomik_remote_channels.remote_channel_zone_id=".$_zone_id.";";  

$rzrs=$conn->query($sql);
 
if($rzrs === false) {
  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
} else {
  $_zone_remotes = $rzrs->num_rows;
}
$rzrs->data_seek(0);

// Atomik Zone Devices SQL
$sql = "SELECT atomik_zone_devices.zone_device_id, atomik_devices.device_name, atomik_device_types.device_type_name FROM atomik_zone_devices, atomik_device_types, atomik_devices WHERE atomik_zone_devices.zone_device_device_id = atomik_devices.device_id && atomik_devices.device_type = atomik_device_types.device_type_id && atomik_zone_devices.zone_device_zone_id = ".$_zone_id.";";  

$dzrs=$conn->query($sql);
 
if($dzrs === false) {
  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
} else {
  $_zone_devices = $dzrs->num_rows;
}
$dzrs->data_seek(0);
} else {
	$_zone_devices = 0;
	$_zone_remotes = 0;
}
?></head><div id="overlay"></div>
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
          <h3>Zone Details</h3>
        </div>
    </div>
   </div><?php if ( $page_success || $page_error ) { ?><hr><?php } ?><?php if ( $page_success ) { ?><div class="alert alert-success">
  <strong>Success!</strong> <?php echo $success_text; ?>
</div><?php } ?><?php if ( $page_error ) { ?><div class="alert alert-danger">
  <strong>Danger!</strong> <?php echo $error_text; ?>
</div><?php } ?><hr>
  <br><form id="zonefrm" name="zonefrm" enctype="multipart/form-data" action="zone_details.php" method="post"><input type="hidden" name="command" id="command" value="" >
  <div class="container">
        <div class="col-xs-2"></div>
        <div class="col-xs-8">
            <h4><p>General Zone Details:</p></h4>   
  <table class="table table-striped">
  <thead>
    <tr<?php if ( $_error_zone_name == 1 ) { ?> class="text-danger"<?php }; ?>>
        <td>
          <p>Zone Name: </p>
        </td>
        <td><p><input type="text" class="form-control" id="zone_name" name="zone_name" value="<?php echo $_zone_name; ?>"></p></td>
    </tr>  
  </thead>
    <tbody>
    <tr<?php if ( $_error_zone_description == 1 ) { ?> class="text-danger"<?php }; ?>>
        <td><p>Zone Description: </p></td>
        <td><p><textarea class="form-control" id="zone_description" name="zone_description" rows="4" cols="1"><?php echo $_zone_description; ?></textarea></p></td>
      </tr>
      </tbody>
  </table><input type="hidden" name="new_zone" id="new_zone" value="<?php echo $_new_zone; ?>"><input type="hidden" name="zone_id" id="zone_id" value="<?php echo $_zone_id; ?>">
</div>
<div class="col-xs-2"></div></div><div class="container">
<div class="col-xs-2"></div>
  <div class="col-xs-8 text-center"><hr></div>
  <div class="col-xs-2"></div>
</div>
<div class="container">
<div class="col-xs-2"></div>
  <div class="col-xs-4 text-center"></div>
  <div class="col-xs-4 text-center"><p><a id="savegeneralbtn" class="btn-success btn">Save General Zone Details</a></p></div>
  <div class="col-xs-2"></div>
  </div>
  <br>
<?php if ( $_zone_type_rgb256 == 1 || $_zone_type_warm_white == 1 || $_zone_type_cold_white == 1 || $_zone_type_brightness == 1 ) { ?>
  <div class="container">
        <div class="col-xs-2"></div>
        <div class="col-xs-8"><hr>
            <h4><p>Zone Properties:</p></h4>
  <table class="table table-striped">
  <thead>
    <tr>
        <td>
          <p>Zone Status: </p>
        </td>
        <td><p><select id="zone_status" name="zone_status" class="form-control">
  <option value="1" <?php if ($_zone_status == 1) { echo ' selected'; }?>>ON</option>
  <option value="0" <?php if ($_zone_status == 0) { echo ' selected'; }?>>OFF</option>
</select></p></td>
    </tr>  
  </thead>
    <tbody>
    <?php if ( ( $_zone_type_rgb256 == 1 && $_zone_type_warm_white == 1 ) || ( $_zone_type_rgb256 == 1 && $_zone_type_cold_white == 1 ) ) { ?><tr>
        <td>
          <p>Zone Color Mode: </p>
        </td>
        <td><p><select id="zone_colormode" name="zone_colormode" class="form-control">
  <option value="1"<?php if ($_zone_colormode == 1) { echo ' selected'; }?>>White Mode</option>
  <option value="0"<?php if ($_zone_colormode == 0) { echo ' selected'; }?>>Color Mode</option>
</select></p></td>
    </tr> <?php }; ?>
    <?php if ( $_zone_type_rgb256 == 0 ) { ?><tr>
        <td>
          <p>Zone Color Mode: </p>
        </td>
        <td><input type="hidden" name="zone_colormode" id="zone_colormode" value="<?php echo $_zone_colormode; ?>"><p><center><b>White Mode</b></center></p></td>
    </tr> <?php }; ?>
    <?php if ( $_zone_type_brightness == 1 ) { ?><tr<?php if ( $_error_zone_brightness == 1 ) { ?> class="text-danger"<?php }; ?>>
        <td>
          <p>Zone Brightness (0-100): </p>
        </td>
        <td><p><input type="text" class="form-control" id="zone_brightness" name="zone_brightness" value="<?php echo $_zone_brightness; ?>"></p></td>
    </tr> <?php }; ?>
    <?php if ( $_zone_type_rgb256 == 1 ) { ?><tr<?php if ( $_error_zone_rgb256 == 1 ) { ?> class="text-danger"<?php }; ?>>
        <td>
          <p>Zone Color (0-255): </p>
        </td>
        <td><p><input type="text" class="form-control" id="zone_rgb256" name="zone_rgb256" value="<?php echo $_zone_rgb256; ?>"></p></td>
    </tr><?php }; ?>
    <?php if ( $_zone_type_cold_white == 1 && $_zone_type_warm_white == 1 ) { ?><tr<?php if ( $_error_zone_white_temprature == 1 ) { ?> class="text-danger"<?php }; ?>>
        <td>
          <p>Zone White Temperature (2700-6500):</p>
        </td>
        <td><p><input type="text" class="form-control" id="zone_white_temprature" name="zone_white_temprature" value="<?php echo $_zone_white_temprature; ?>"></p></td>
    </tr><?php }; ?>
      </tbody>
  </table>
</div>
<div class="col-xs-2"></div></div>
<div class="container">
<div class="col-xs-2"></div>
  <div class="col-xs-8 text-center"><hr></div>
  <div class="col-xs-2"></div>
</div>
<div class="container">
<div class="col-xs-2"></div>
  <div class="col-xs-4 text-center"></div>
  <div class="col-xs-4 text-center"><p><a id="savepropertiesbtn" class="btn-success btn">Set Zone Properties</a></p></div>
  <div class="col-xs-2"></div>
  </div><?php }; ?>
<br><div class="container center-block">
<div class="col-xs-2"></div>
<div class="col-xs-8"><hr></div>
<div class="col-xs-2"></div>
</div>
  <div class="container center-block">
    <div class="col-xs-2"></div>
        <div class="col-xs-8">
           <h4><p>Zone Devices:</p></h4></div>
           <div class="col-xs-2"></div>
           </div><br>
           <div class="container center-block">
    <div class="col-xs-2"></div>
        <div class="col-xs-8">
  <table class="table table-striped">
    <thead>
      <tr>
        <td><b><center>Name</center></b></td>
        <td><b><center>Type</center></b></td>
        <td></td>
      </tr>
    </thead>
    <tbody><input type="hidden" id="zone_device_id" name="zone_device_id" value="">
<?php if ( $_zone_devices > 0 ) { while($dzrow = $dzrs->fetch_assoc()){ ?>
    <tr>
        <td><center><p><?php echo $dzrow['device_name']; ?></p></center></td>
        <td><center><p><?php echo $dzrow['device_type_name']; ?></p></center></td>
        <td><center><p><a id="deletedev<?php echo $dzrow['zone_device_id']; ?>" class="btn-danger btn">Remove Device</a></p></center></td>
        <script type="text/javascript">
	$("#deletedev<?php echo $dzrow['zone_device_id']; ?>").on('click', function() {
		$("#overlay").show();
	if (window.confirm("Are you sure?")) {
        document.forms["zonefrm"].command.value = "remove_device";
		document.forms["zonefrm"].zone_device_id.value = "<?php echo $dzrow['zone_device_id']; ?>";
   		document.zonefrm.submit(); }
	$("#overlay").hide();
	}); </script>
      </tr><?php } } else { ?>
      <tr>
      <td colspan="3" class="text-center"><h3>No Devices</h3></td>
      </tr> <?php }; ?>
    </tbody>
  </table>
        </div><div class="col-xs-2"></div>
</div><div class="container center-block">
    <div class="col-xs-2"></div>
        <div class="col-xs-4">
           </div><div class="col-xs-4 text-right"><p><strong>Total Zone Devices: <?php echo $_zone_devices; ?></strong></p><p><a id="adddevicebtn" class="btn-primary btn">Add Zone Device</a></p>  </div>
           <div class="col-xs-2"></div>
           </div><br><div class="container center-block">
<div class="col-xs-2"></div>
<div class="col-xs-8"><hr></div>
<div class="col-xs-2"></div>
</div>
  <div class="container center-block">
    <div class="col-xs-2"></div>
        <div class="col-xs-8">
           <h4><p>Zone Remotes:</p></h4></div>
           <div class="col-xs-2"></div>
           </div><br>
           <div class="container center-block">
    <div class="col-xs-2"></div>
        <div class="col-xs-8">
  <table class="table table-striped">
    <thead>
      <tr>
        <td><b><center>Name</center></b></td>
        <td><b><center>Type</center></b></td>
        <td></td>
      </tr>
    </thead>
    <tbody><input type="hidden" id="remote_channel_id" name="remote_channel_id" value="">
      <?php if ( $_zone_remotes > 0 ) { while($rzrow = $rzrs->fetch_assoc()){ ?>
    <tr>
        <td><center><p><?php echo $rzrow['remote_name'].' - '.$rzrow['remote_channel_name']; ?></p></center></td>
        <td><center><p><?php echo $rzrow['remote_type_name']; ?></p></center></td>
        <td><center><p><a id="deleterem<?php echo $rzrow['remote_channel_id']; ?>" class="btn-danger btn">Remove Remote</a></p></center></td>
        <script type="text/javascript">
	$("#deleterem<?php echo $rzrow['remote_channel_id']; ?>").on('click', function() {
		$("#overlay").show();
	if (window.confirm("Are you sure?")) {
        document.forms["zonefrm"].command.value = "remove_remote";
		document.forms["zonefrm"].remote_channel_id.value = "<?php echo $rzrow['remote_channel_id']; ?>";
   		document.zonefrm.submit(); }
	$("#overlay").hide();}); </script>
      </tr><?php } } else { ?>
      <tr>
      <td colspan="3" class="text-center"><h3>No Remotes</h3></td>
      </tr> <?php }; ?>
    </tbody>
  </table>
        </div><div class="col-xs-2"></div>
</div><div class="container center-block">
    <div class="col-xs-2"></div>
        <div class="col-xs-4">
           </div><div class="col-xs-4 text-right"><p><strong>Total Zone Remotes: <?php echo $_zone_remotes; ?></strong></p><p><a id="addremotebtn" class="btn-primary btn">Add Zone Remote</a></p>  </div>
           <div class="col-xs-2"></div>
           </div></form>
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
  <div class="col-xs-1"><a id="delzonebtn" class="btn-danger btn">Delete Zone</a>
  </div>
  <div class="col-xs-4">
  </div>
  <div class="col-xs-2 text-right">
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
$("#savegeneralbtn").on('click', function() {
   document.forms["zonefrm"].command.value = "save_general";
   document.zonefrm.submit();
});
$("#savepropertiesbtn").on('click', function() {
   document.forms["zonefrm"].command.value = "save_properties";
   document.zonefrm.submit();
});
$("#delzonebtn").on('click', function() {
	$("#overlay").show();
	if (window.confirm("Are you sure?")) {
        document.forms["zonefrm"].command.value = "delete_zone";
   		document.zonefrm.submit();
	}
	$("#overlay").hide();
});
$("#adddevicebtn").on('click', function() {
   document.forms["zonefrm"].command.value = "add_device";
   document.zonefrm.submit();
});
$("#addremotebtn").on('click', function() {
   document.forms["zonefrm"].command.value = "add_remote";
   document.zonefrm.submit();
});
</script></body><?php
$dzrs->free();
$rzrs->free();
$cdrs->free();
$rs->free();
$conn->close();
?>
</html>