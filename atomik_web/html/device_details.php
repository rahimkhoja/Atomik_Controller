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
<title>Atomik Controller - Device Details</title>
<link rel="stylesheet" href="css/atomik.css">
<script src="js/jquery-1.12.3.min.js"></script>
<script src="js/jquery.redirect.min.js"></script>
<?php 
function IncrementTransmissionNum( $number ) {
	$trans = $number + 1;
	if ( $trans >= 256 ) {
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

function generateAddress( $db, $ty  )
{
	$loop = true;
	while( $loop ) {
		 $a1 =rand(0,255);
		 $a2 =rand(0,255);
		 if ( $a2 != 27 ) {
			$sql = 'SELECT atomik_devices.device_id, atomik_devices.device_address1, atomik_devices.device_address2 FROM atomik_devices WHERE atomik_devices.device_type = '.$ty.' &&  atomik_devices.device_address1 = '.$a1.' && atomik_devices.device_address2 = '.$a2.';';
			$rs=$db->query($sql);
			$db_records = -1;
			if($rs === false) {
  				trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
			} else {
  				$db_records = $rs->num_rows;
			}
			if ( $db_records == 0 ) {
				$loop = false;	
			}
		 }	
	}
	$output = $a1."---".$a2;
	return $output;
}

function transmit($new_b, $old_b, $new_s, $old_s, $new_c, $old_c, $new_wt, $old_wt, $new_cm, $old_cm, $add1, $add2, $tra, $rgb, $cw, $ww) {
	$trans = $tra;
		
	if ( $cw == 1 && $ww == 1 && $rgb != 1) {
		
		$sendcommandbase = "/usr/bin/transceiver -t 2 -q ".dechex($add1)." -r ".dechex($add2)." -c 01";
		
		// White Bulb Details
		$Brightness = array(9,18,27,36,45,54,63,72,81,90,100);
		$WhiteTemp = array(2700,3080,3460,3840,4220,4600,4980,5360,5740,6120,6500);
		
		if ($new_s != $old_s) {
			// Status Changed
			$trans = IncrementTransmissionNum( $trans );
			if ($new_s == 1 ) {
				$sendcom = $sendcommandbase." -k ".dechex((255-$trans))." -v ".dechex($trans)." -b 08";
			} else {
				$sendcom = $sendcommandbase." -k ".dechex((255-$trans))." -v ".dechex($trans)." -b 0B";
			}
			exec($sendcom.' > /dev/null &');	
		} // End Status Change
		
		if ( $new_s == 1 ) {
		// Status On
			
			if ( $old_cm != $new_cm ) {
				$trans = IncrementTransmissionNum( $trans );
				echo 'current CM: '.$new_cm.'\n';
				// Color Mode Change
				if ( $new_cm == 1 ) {
					$sendcom = $sendcommandbase." -k ".dechex((255-$trans))." -v ".dechex($trans)." -b 18";
				} else {
					$sendcom = $sendcommandbase." -k ".dechex((255-$trans))." -v ".dechex($trans)." -b 08";
				}
				exec($sendcom.' > /dev/null &');	
			}
			
			if ($new_b != $old_b || $old_cm != $new_cm ) {
			// Brightness Change
				
				// Search Arrays for brightness values, reteieve Array positions of each Brightness value
				$old_pos = array_search ( $old_b, $Brightness );
				$new_pos = array_search ( $new_b, $Brightness );
				
				// Detect if there is a change to become Brighter
				if ( $new_pos > $old_pos ) {
					
					// Detect if brightness is being changed to 100% brightness. Issue 100% Brithgtness command
					if ( $new_pos == array_search ( 100, $Brightness ) ) {
						$trans = IncrementTransmissionNum( $trans );
						$sendcom = $sendcommandbase." -k ".dechex((255-$trans))." -v ".dechex($trans)." -b 18";
						exec($sendcom.' > /dev/null &');
					
					} else {
					// If not 100% brightness, calcuate how many Brightness positions to move. Issue correct amount of commands to increase Brightness to specified level
						$move = $new_pos - $old_pos;	
						for ($x = 0; $x <= $move; $x++) {
							$trans = IncrementTransmissionNum( $trans );
							$sendcom = $sendcommandbase." -k ".dechex((255-$trans))." -v ".dechex($trans)." -b 0C";
							exec($sendcom.' > /dev/null &');
						}
					}
				// Lower Brightness Detected	
				} else {
					// calcuate how many Brightness positions to move. Issue correct amount of commands to decrease Brightness to specified level
					$move = $old_pos - $new_pos;	
					for ($x = 0; $x <= $move; $x++) {
						$trans = IncrementTransmissionNum( $trans );
						$sendcom = $sendcommandbase." -k ".dechex((255-$trans))." -v ".dechex($trans)." -b 04";
						exec($sendcom.' > /dev/null &');
					}
				}	
			}
			
			if ($new_wt != $old_wt ) {
			// White Temp Change
				
				// Search Arrays for White Temp values, reteieve Array positions of each White Temp value
				$old_pos = array_search ( $old_wt, $WhiteTemp );
				$new_pos = array_search ( $new_wt, $WhiteTemp );
				
				// Detect if White Temprature is getting warm
				if ( $new_pos < $old_pos ) {
					// Detect if new White Temp is 100% Warm. Issue 100% Warm White command
					if ( $new_pos == array_search ( 2700, $WhiteTemp ) ) {
						$trans = IncrementTransmissionNum( $trans );
						$sendcom = $sendcommandbase." -k ".dechex((255-$trans))." -v ".dechex($trans)." -b 1f";
						exec($sendcom.' > /dev/null &');
					// If not 100% Warm White, calcuate how many Warm White positions to move. Issue correct amount of commands to increase Warm White to specified level
					} else {
						$move = $new_pos - $old_pos;	
						for ($x = 0; $x <= $move; $x++) {
							$trans = IncrementTransmissionNum( $trans );
							$sendcom = $sendcommandbase." -k ".dechex((255-$trans))." -v ".dechex($trans)." -b 0f";
							exec($sendcom.' > /dev/null &');
						}
					}
				// Else White Temprature is getting colder
				} else {
					// Detect if new White Temp is 100% Cold. Issue 100% Cold White command
					if ( $new_pos == array_search ( 6500, $WhiteTemp ) ) {
						$trans = IncrementTransmissionNum( $trans );
						$sendcom = $sendcommandbase." -k ".dechex((255-$trans))." -v ".dechex($trans)." -b 1e";
						exec($sendcom.' > /dev/null &');
					// If not 100% Cold White, calcuate how many Cold White positions to move. Issue correct amount of commands to decrease Cold White to specified level
					} else {
						$move = $old_pos - $new_pos;	
						for ($x = 0; $x <= $move; $x++) {
							$trans = IncrementTransmissionNum( $trans );
							$sendcom = $sendcommandbase." -k ".dechex((255-$trans))." -v ".dechex($trans)." -b 0e";
							exec($sendcom.' > /dev/null &');
						}
					}	
				}
			}
		}
			
	} else if ( $cw == 1 && $rgb == 1 || $ww == 1 && $rgb == 1 ) {
		$sendcommandbase = "/usr/bin/transceiver -t 1 -q ".dechex($add1)." -r ".dechex($add2);
		
	// RGBWW and RGBCW	
		if ($new_s != $old_s) {
		// Status Changed
			$trans = IncrementTransmissionNum( $trans );
			if ($new_s == 1 ) {	
				$sendcom = $sendcommandbase." -k 03 -c ".dechex($old_c)." -b ".dechex($old_b)." -v ".dechex($trans);
			} else {
				$sendcom = $sendcommandbase." -k 04 -c ".dechex($old_c)." -b ".dechex($old_b)." -v ".dechex($trans);
			}
			exec($sendcom.' > /dev/null &');	
		}
		// End Status Change
		
		if ( $new_s == 1 ) {
		// Status On
			
			if ( $old_cm != $new_cm ) {
				// Color Mode Change
				$trans = IncrementTransmissionNum( $trans );
				echo 'current CM: '.$new_cm.'\n';
				
				if ( $new_cm == 1 ) {
					$sendcom = $sendcommandbase." -k 13 -b ".dechex($old_b)." -v ".dechex($trans);
				} else {
					$sendcom = $sendcommandbase." -k 03 -c ".dechex($old_c)." -b ".dechex($old_b)." -v ".dechex($trans);
				}
				exec($sendcom.' > /dev/null &');	
			}
			// End Color Mode Change
		
			if ( $new_cm == 0 ) {
			// Color Mode Color
				if ($new_c != $old_c || $old_cm != $new_cm) {
					// Color Change
					$trans = IncrementTransmissionNum( $trans );
				
					$initcom = $sendcommandbase." -c ".dechex($new_c)." -k 03 -v ".dechex($trans);
					exec($initcom.' > /dev/null &');
					$trans = IncrementTransmissionNum( $trans );
					$sendcom = $sendcommandbase." -c ".dechex($new_c)." -k 0f -v ".dechex($trans);
					exec($sendcom.' > /dev/null &');	
					
				}
				// End Color Change
			}
			// End Color Mode Color
		
			if ($new_b != $old_b ) {
				// Brightness Change
				$trans = IncrementTransmissionNum( $trans );
				if ($new_b == 4) {
					$sendcom = $sendcommandbase." -c ".dechex($new_c)." -b ".dechex(129)." -k 0e -v ".dechex($trans);
				} else if ($new_b == 8) {
					$sendcom = $sendcommandbase." -c ".dechex($new_c)." -b ".dechex(121)." -k 0e -v ".dechex($trans);
				} else if ($new_b == 12) {
					$sendcom = $sendcommandbase." -c ".dechex($new_c)." -b ".dechex(113)." -k 0e -v ".dechex($trans);
				} else if ($new_b == 15) {
					$sendcom = $sendcommandbase." -c ".dechex($new_c)." -b ".dechex(105)." -k 0e -v ".dechex($trans);
				} else if ($new_b == 19) {
					$sendcom = $sendcommandbase." -c ".dechex($new_c)." -b ".dechex(97)." -k 0e -v ".dechex($trans);
				} else if ($new_b == 23) {
					$sendcom = $sendcommandbase." -c ".dechex($new_c)." -b ".dechex(89)." -k 0e -v ".dechex($trans);
				} else if ($new_b == 27) {
					$sendcom = $sendcommandbase." -c ".dechex($new_c)." -b ".dechex(81)." -k 0e -v ".dechex($trans);
				} else if ($new_b == 31) {
					$sendcom = $sendcommandbase." -c ".dechex($new_c)." -b ".dechex(73)." -k 0e -v ".dechex($trans);
				} else if ($new_b == 35) {
					$sendcom = $sendcommandbase." -c ".dechex($new_c)." -b ".dechex(65)." -k 0e -v ".dechex($trans);
				} else if ($new_b == 39) { //10
					$sendcom = $sendcommandbase." -c ".dechex($new_c)." -b ".dechex(57)." -k 0e -v ".dechex($trans);
				} else if ($new_b == 42) { //11
					$sendcom = $sendcommandbase." -c ".dechex($new_c)." -b ".dechex(49)." -k 0e -v ".dechex($trans);
				} else if ($new_b == 46) { //12
					$sendcom = $sendcommandbase." -c ".dechex($new_c)." -b ".dechex(41)." -k 0e -v ".dechex($trans);
				} else if ($new_b == 50) { //13
					$sendcom = $sendcommandbase." -c ".dechex($new_c)." -b ".dechex(33)." -k 0e -v ".dechex($trans);
				} else if ($new_b == 54) { //14
					$sendcom = $sendcommandbase." -c ".dechex($new_c)." -b ".dechex(25)." -k 0e -v ".dechex($trans);
				} else if ($new_b == 58) { //15
					$sendcom = $sendcommandbase." -c ".dechex($new_c)." -b ".dechex(17)." -k 0e -v ".dechex($trans);
				} else if ($new_b == 62) { //16
					$sendcom = $sendcommandbase." -c ".dechex($new_c)." -b ".dechex(9)." -k 0e -v ".dechex($trans);
				} else if ($new_b == 65) { //17
					$sendcom = $sendcommandbase." -c ".dechex($new_c)." -b ".dechex(1)." -k 0e -v ".dechex($trans);
				} else if ($new_b == 69) { //18
					$sendcom = $sendcommandbase." -c ".dechex($new_c)." -b ".dechex(249)." -k 0e -v ".dechex($trans);
				} else if ($new_b == 73) { //19
					$sendcom = $sendcommandbase." -c ".dechex($new_c)." -b ".dechex(241)." -k 0e -v ".dechex($trans);
				} else if ($new_b == 77) { // 20
					$sendcom = $sendcommandbase." -c ".dechex($new_c)." -b ".dechex(233)." -k 0e -v ".dechex($trans);
				} else if ($new_b == 81) { // 21
					$sendcom = $sendcommandbase." -c ".dechex($new_c)." -b ".dechex(225)." -k 0e -v ".dechex($trans);
				} else if ($new_b == 85) { // 22
					$sendcom = $sendcommandbase." -c ".dechex($new_c)." -b ".dechex(217)." -k 0e -v ".dechex($trans);
				} else if ($new_b == 88) { // 23
					$sendcom = $sendcommandbase." -c ".dechex($new_c)." -b ".dechex(209)." -k 0e -v ".dechex($trans);
				} else if ($new_b == 92) { // 24
					$sendcom = $sendcommandbase." -c ".dechex($new_c)." -b ".dechex(201)." -k 0e -v ".dechex($trans);
				} else if ($new_b == 96) { // 25
					$sendcom = $sendcommandbase." -c ".dechex($new_c)." -b ".dechex(193)." -k 0e -v ".dechex($trans);
				} else if ($new_b == 100) { // 26
					$sendcom = $sendcommandbase." -c ".dechex($new_c)." -b ".dechex(185)." -k 0e -v ".dechex($trans);
				}
				exec($sendcom.' > /dev/null &');	
			}
			// End Brightness Change
		}
		// End Status On
	} 
	return $trans;
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

// Set Default Error & Success Settings
$page_error = 0;
$page_success = 0;
$success_text = "";
$error = "";

// Set Command
$command = "";
$command = $_POST["command"];

if ( isset($_POST["new_device"]) ) {
	$_new_device = $_POST["new_device"];
} else {
	$_new_device = "0";
}

if ( isset($_POST["device_id"]) ) {
	$_device_id = $_POST["device_id"];
} else {
	$_device_id = "";
}

if ( isset($_POST["device_type"]) ) {
	$_device_type = $_POST["device_type"];
} else {
	$_device_type = "";
}

if ( $_new_device == 0 ) {
// Atomik Setting SQL
	$sql = "SELECT atomik_devices.device_id, atomik_devices.device_name, atomik_devices.device_description, atomik_devices.device_status, atomik_devices.device_type,  atomik_devices.device_colormode, atomik_devices.device_brightness, atomik_devices.device_rgb256, atomik_devices.device_white_temprature, atomik_devices.device_address1, atomik_devices.device_address2, atomik_devices.device_transmission, atomik_device_types.device_type_name, atomik_device_types.device_type_brightness, atomik_device_types.device_type_rgb256, atomik_device_types.device_type_warm_white, atomik_device_types.device_type_cold_white FROM atomik_devices, atomik_device_types WHERE atomik_devices.device_type = atomik_device_types.device_type_id && atomik_devices.device_id = ".$_device_id.";";  

} else { 
	$sql = "SELECT atomik_device_types.device_type_name, atomik_device_types.device_type_brightness, atomik_device_types.device_type_rgb256, atomik_device_types.device_type_warm_white, atomik_device_types.device_type_cold_white FROM atomik_device_types WHERE atomik_device_types.device_type_id = ".$_device_type.";";
}
$rs=$conn->query($sql);
 
if($rs === false) {
  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
} else {
  $db_records = $rs->num_rows;
}

$rs->data_seek(0);
$row = $rs->fetch_assoc();

if ( isset($_POST["device_name"])) {
	$_device_name = $_POST["device_name"];
} else {
	if ($_new_device == 0 ) {
		$_device_name = $row['device_name'];
	} else {
		$_device_name = "";
	}
}

if ( isset($_POST["device_description"])) {
	$_device_description = $_POST["device_description"];
} else {
	if ($_new_device == 0 ) {
		$_device_description = $row['device_description'];
	} else {
		$_device_description = "";
	}
}

if ( isset($_POST["device_status"])) {
	$_device_status = $_POST["device_status"];
} else {
	if ($_new_device == 0 ) {
		$_device_status = $row['device_status'];
	} else {
		$_device_status = "";
	}
}

if ( isset($_POST["device_colormode"])) {
	$_device_colormode = $_POST["device_colormode"];
} else {
	if ($_new_device == 0 ) {
		$_device_colormode = $row['device_colormode'];
	} else {
		$_device_colormode = 1;
	}
}

if ( isset($_POST["device_rgb256"])) {
	$_device_rgb256 = $_POST["device_rgb256"];
} else {
	if ($_new_device == 0 ) {
		$_device_rgb256 = $row['device_rgb256'];
	} else {
		$_device_rgb256 = 0;
	}
}

if ( isset($_POST["device_white_temprature"])) {
	$_device_white_temprature = $_POST["device_white_temprature"];
} else {
	if ($_new_device == 0 ) {
		$_device_white_temprature = $row['device_white_temprature'];
	} else {
		$_device_white_temprature = 2700;
	}
}

	if ($_new_device != 1 ) {
		$_device_address1 = $row['device_address1'];
		$_device_address2 = $row['device_address2'];
	} else {
		$_device_address1 = "";
		$_device_address2 = "";
	}
	if ($_new_device != 1 ) {
		$_device_transmission = $row['device_transmission'];
	} else {
		$_device_transmission = 0;
	}

if ( isset($_POST["device_type"])) {
	$_device_type = $_POST["device_type"];
} else {
	if ($_new_device == 0 ) {
		$_device_type = $row['device_type'];
	} else {
		$_device_type = "";
	}
}

$_device_type_name = $row['device_type_name'];
$_device_type_brightness = $row['device_type_brightness'];
$_device_type_warm_white = $row['device_type_warm_white'];
$_device_type_cold_white = $row['device_type_cold_white'];
$_device_type_rgb256 = $row['device_type_rgb256'];
if ( isset($_POST["device_brightness"])) {
	$_device_brightness = $_POST["device_brightness"];
} else {
	if ($_new_device == 0 ) {
		$_device_brightness = $row['device_brightness'];
	} else {
		$_device_brightness = 0;
	}
}

if ($_device_white_temprature <= 2700) {
	$_device_white_temprature = 2700;
} else if ($_device_white_temprature <= 3080) {
	$_device_white_temprature = 3080;
} else if ($_device_white_temprature <= 3460) {
	$_device_white_temprature = 3460;
} else if ($_device_white_temprature <= 3840) {
	$_device_white_temprature = 3840;
} else if ($_device_white_temprature <= 4220) {
	$_device_white_temprature = 4220;
} else if ($_device_white_temprature <= 4600) {
	$_device_white_temprature = 4600;
} else if ($_device_white_temprature <= 4980) {
	$_device_white_temprature = 4980;
} else if ($_device_white_temprature <= 5360) {
	$_device_white_temprature = 5360;
} else if ($_device_white_temprature <= 5740) {
	$_device_white_temprature = 5740;
} else if ($_device_white_temprature <= 6120) {
	$_device_white_temprature = 6120;
} else if ($_device_white_temprature <= 6500) {
	$_device_white_temprature = 6500;
} 



if ($_device_type_warm_white == 1 && $_device_type_cold_white == 1 ) {
	if ($_device_brightness <= 9) {
	$_device_brightness = 9;
} else if ($_device_brightness <= 18) {
	$_device_brightness = 18;
} else if ($_device_brightness <= 27) {
	$_device_brightness = 27;
} else if ($_device_brightness <= 36) {
	$_device_brightness = 36;
} else if ($_device_brightness <= 45) {
	$_device_brightness = 45;
} else if ($_device_brightness <= 54) {
	$_device_brightness = 54;
} else if ($_device_brightness <= 63) {
	$_device_brightness = 63;
} else if ($_device_brightness <= 72) {
	$_device_brightness = 72;
} else if ($_device_brightness <= 81) {
	$_device_brightness = 81;
} else if ($_device_brightness <= 90) {
	$_device_brightness = 90;
} else if ($_device_brightness <= 100) {
	$_device_brightness = 100;
} 

} else {
if ($_device_brightness <= 4) {
	$_device_brightness = 4;
} else if ($_device_brightness <= 8) {
	$_device_brightness = 8;
} else if ($_device_brightness <= 12) {
	$_device_brightness = 12;
} else if ($_device_brightness <= 15) {
	$_device_brightness = 15;
} else if ($_device_brightness <= 19) {
	$_device_brightness = 19;
} else if ($_device_brightness <= 23) {
	$_device_brightness = 23;
} else if ($_device_brightness <= 27) {
	$_device_brightness = 27;
} else if ($_device_brightness <= 31) {
	$_device_brightness = 31;
} else if ($_device_brightness <= 35) {
	$_device_brightness = 35;
} else if ($_device_brightness <= 39) {
	$_device_brightness = 39;
} else if ($_device_brightness <= 42) {
	$_device_brightness = 42;
} else if ($_device_brightness <= 46) {
	$_device_brightness = 46;
} else if ($_device_brightness <= 50) {
	$_device_brightness = 50;
} else if ($_device_brightness <= 54) {
	$_device_brightness = 54;
} else if ($_device_brightness <= 58) {
	$_device_brightness = 58;
} else if ($_device_brightness <= 62) {
	$_device_brightness = 62;
} else if ($_device_brightness <= 65) {
	$_device_brightness = 65;
} else if ($_device_brightness <= 69) {
	$_device_brightness = 69;
} else if ($_device_brightness <= 73) {
	$_device_brightness = 73;
} else if ($_device_brightness <= 77) {
	$_device_brightness = 77;
} else if ($_device_brightness <= 81) {
	$_device_brightness = 81;
} else if ($_device_brightness <= 85) {
	$_device_brightness = 85;
} else if ($_device_brightness <= 88) {
	$_device_brightness = 88;
} else if ($_device_brightness <= 92) {
	$_device_brightness = 92;
} else if ($_device_brightness <= 96) {
	$_device_brightness = 96;
} else if ($_device_brightness <= 100) {
	$_device_brightness = 100;
} 
}

// Save General Device Settings [Keep Post Data, Verify Form, DB] (save_general)
if ($command <> "" && $command !="" && $command == "save_general") 
{	
	$erro = array();
	if ($_new_device == 1 )
	{
		if (!preg_match("/^[a-zA-Z0-9. -]+$/", $_device_name)) {
			array_push($erro, "Device Name Contains Illegal Characters, Please Only Use Letters, Numbers, Spaces, Periods, and Dashes");
			$_error_device_name = 1;
		}
		
		if ( !( ( !empty($_device_description) && preg_match("/^[a-zA-Z0-9. -]+$/", $_device_description) ) || empty($_device_description) ) ) {
			array_push($erro, "Device Description Contains Illegal Characters, Please Only Use Letters, Numbers, Spaces, Periods, and Dashes");
			$_error_device_description = 1;
		}
		
	} else {
		if ( $_device_name == $row['device_name'] && $_device_description == $row['device_description'] )
		{
			array_push($erro, "No Changes To Save");
		} else {
			if (!preg_match("/^[a-zA-Z0-9. -]+$/", $_device_name)) {
				array_push($erro, "Device Name Contains Illegal Characters, Please Only Use Letters, Numbers, Spaces, Periods, and Dashes");
				$_error_device_name = 1;
			}
		
			if ( !( ( !empty($_device_description) && preg_match("/^[a-zA-Z0-9. -]+$/", $_device_description) ) || empty($_device_description) ) ) {
				array_push($erro, "Device Description  Contains Illegal Characters, Please Only Use Letters, Numbers, Spaces, Periods, and Dashes");
				$_error_device_description = 1;
			}
		}
	}
	
	if (count($erro) > 0) 
	{
		$page_error = 1;
		$error_text = processErrors($erro);	
	} else {
		if ( $_new_device == 1 ) {
			// Generate Random Numbers
			$new_address_string = generateAddress($conn, $_device_type);
			$new_addresses_array = explode("---", $new_address_string);
			
			
			$sql = "INSERT INTO atomik_devices (device_name, device_description, device_type, device_address1, device_address2, device_transmission ) VALUES ('".$_device_name."','".$_device_description."',".$_device_type.",".$new_addresses_array[0].",".$new_addresses_array[1].", 0)";
			$_device_address1 = $new_addresses_array[0];
			$_device_address2 = $new_addresses_array[1];
			$_device_transmission = 0;
			if ($conn->query($sql) === TRUE) {
    			$page_success = 1;
				$success_text = "General Device Details Updated!";
				$_new_device = 0;
				$_device_id = $conn->insert_id;
			} else {
    			$page_error = 1;
				$error_text = "Error Inserting General Device Details To DB!";
			}
		} else {
			$sql = "UPDATE atomik_devices SET device_name='".$_device_name."', device_description='".$_device_description."' WHERE device_id=".$_device_id.";";
			if ($conn->query($sql) === TRUE) {
    			$page_success = 1;
				$success_text = "General Device Details Updated!";
			} else {
    			$page_error = 1;
				$error_text = "Error Saving General Device Details To DB!";
			}
		}
	}		
}

// Save all Device Settings [Keep Post Data, Verify Form, DB] (save_all)
if ($command <> "" && $command !="" && $command == "save_all") 
{	
	$erro = array();
	if ($_new_device == 1 )
	{
		if (!preg_match("/^[a-zA-Z0-9. -]+$/", $_device_name)) {
			array_push($erro, "Device Name Contains Illegal Characters, Please Only Use Letters, Numbers, Spaces, Periods, and Dashes");
			$_error_device_name = 1;
		}		
		
		if ( !( ( !empty($_device_description) && preg_match("/^[a-zA-Z0-9. -]+$/", $_device_description) ) || empty($_device_description) ) ) {
			array_push($erro, "Device Description Contains Illegal Characters, Please Only Use Letters, Numbers, Spaces, Periods, and Dashes");
			$_error_device_description = 1;
		}
		
		if ( $_device_type_brightness == 1 ) {
			if (!Check0to100 ( $_device_brightness )) {
				array_push($erro, "Device Brightness Must Be A Number Between 0 and 100");
				$_error_device_brightness = 1;
			}
		}
			
		if ( $_device_type_rgb256 == 1 && $_device_colormode == 0) {
			if (!Check0to255 ( $_device_rgb256)) {
				array_push($erro, "Device Color Must Be A Number Between 0 and 255");
				$_error_device_rgb256 = 1;
			}
		}
			
		if ( $_device_type_cold_white == 1 && $_device_type_warm_white == 1 && $_device_colormode == 1 ) {
			if (!Check2700to6500 ( $_device_white_temprature )) {
				array_push($erro, "Device White Temprature Must Be A Number Between 2700 and 6500");
				$_error_device_white_temprature = 1;
			}
		}			
	} else {		
		if ( $_device_name == $row['device_name'] && $_device_description == $row['device_description'] && $_device_status == $row['device_status'] && $_device_colormode == $row['device_colormode'] && $_device_brightness == $row['device_brightness'] && $_device_rgb256 == $row['device_rgb256'] && $_device_white_temprature == $row['device_white_temprature'] ) {
			array_push($erro, "No Changes To Save");
		} else {

			if (!preg_match("/^[a-zA-Z0-9. -]+$/", $_device_name)) {
				array_push($erro, "Device Name Contains Illegal Characters, Please Only Use Letters, Numbers, Spaces, Periods, and Dashes");
				$_error_device_name = 1;
			}
		
		if ( !( ( !empty($_device_description) && preg_match("/^[a-zA-Z0-9. -]+$/", $_device_description) ) || empty($_device_description) ) ) {
				array_push($erro, "Device Description Contains Illegal Characters, Please Only Use Letters, Numbers, Spaces, Periods, and Dashes");
				$_error_device_description = 1;
			}
		
			if ( $_device_type_brightness == 1 ) {
				if (!Check0to100 ( $_device_brightness )) {
					array_push($erro, "Device Brightness Must Be A Number Between 0 and 100");
					$_error_device_brightness = 1;
				}
			}
			
			if ( $_device_type_rgb256 == 1 && $_device_colormode == 0) {
				if (!Check0to255 ( $_device_rgb256)) {
					array_push($erro, "Device Color Must Be A Number Between 0 and 255");
					$_error_device_rgb256 = 1;
				}
			}
			
			if ( $_device_type_cold_white == 1 && $_device_type_warm_white == 1 && $_device_colormode == 1 ) {
				if (!Check2700to6500 ( $_device_white_temprature )) {
					array_push($erro, "Device White Temprature Must Be A Number Between 2700 and 6500");
					$_error_device_white_temprature = 1;
				}
			}
		}
	}
	
	if (count($erro) > 0) 
	{
		$page_error = 1;
		$error_text = processErrors($erro);	
	} else {
		if ( $_new_device == 1 ) {
			// Generate Random Numbers
			$new_address_string = generateAddress($conn, $_device_type);
			$new_addresses_array = explode("---", $new_address_string);
			$_device_address1 = $new_addresses_array[0];
			$_device_address2 = $new_addresses_array[1];
			$_device_transmission = 0;
			$sql = "INSERT INTO atomik_devices (device_name, device_description, device_type, device_status, device_colormode, device_brightness, device_rgb256, device_white_temprature, device_address1, device_address2, device_transmission ) VALUES ('".$_device_name."','".$_device_description."',".trim($_device_type).",".trim($_device_status).",".trim($_device_colormode).",".trim($_device_brightness).",".trim($_device_rgb256).",".trim($_device_white_temprature).",".$new_addresses_array[0].",".$new_addresses_array[1].", 0);";		
			if ($conn->query($sql) === TRUE) {
    			$page_success = 1;
				$success_text = "All Device Details Updated!";
				$_new_device = 0;
				$_device_id = $conn->insert_id;
			} else {
    			$page_error = 1;
				$error_text = "Error Saving All New Device Details To DB!";
			}
		} else {
			$sql = "UPDATE atomik_devices SET device_name='".$_device_name."', device_description='".$_device_description."', device_status = ".trim($_device_status).", device_colormode = ".trim($_device_colormode).", device_brightness = ".trim($_device_brightness).", device_rgb256 = ".trim($_device_rgb256).", device_white_temprature = ".trim($_device_white_temprature)." WHERE device_id=".$_device_id.";";
			if ($conn->query($sql) === TRUE) {
    			$page_success = 1;
				$success_text = "All Device Details Updated!";
			} else {
    			$page_error = 1;
				$error_text = "Error Saving All Device Details To DB!";
			}
		}
	}		
}

// Save General Device Settings [Keep Post Data, Verify Form, DB] (save_properties)
if ($command <> "" && $command !="" && $command == "save_properties") 
{	
	$erro = array();
	if ($_new_device == 1 )
	{
		array_push($erro, "Please Save General Device Details Before Saving Device Properties");	
	} else {
		if ( $_device_status == $row['device_status'] && $_device_colormode == $row['device_colormode'] && $_device_brightness == $row['device_brightness'] && $_device_rgb256 == $row['device_rgb256'] && $_device_white_temprature == $row['device_white_temprature'] ) {
			array_push($erro, "No Changes To Save");
		} else {
			if ( $_device_type_brightness == 1 ) {
				if (!Check0to100 ( $_device_brightness )) {
					array_push($erro, "Device Brightness Must Be A Number Between 0 and 100");
					$_error_device_brightness = 1;
				}
			}
			
			if ( $_device_type_rgb256 == 1 && $_device_colormode == 0 ) {
				if (!Check0to255 ( $_device_rgb256)) {
					array_push($erro, "Device Color Must Be A Number Between 0 and 255");
					$_error_device_rgb256 = 1;
				}
			}
			
			if ( $_device_type_cold_white == 1 && $_device_type_warm_white == 1 && $_device_colormode == 1 ) {
				if (!Check2700to6500 ( $_device_white_temprature )) {
					array_push($erro, "Device White Temprature Must Be A Number Between 2700 and 6500");
					$_error_device_white_temprature = 1;
				}
			}	
		}	
	}
	
	if (count($erro) > 0) 
	{
		$page_error = 1;
		$error_text = processErrors($erro);	
	} else {
		$_device_transmission = transmit($_device_brightness, $row['device_brightness'], $_device_status, $row['device_status'], $_device_rgb256, $row['device_rgb256'], $_device_white_temprature, $row['device_white_temprature'], $_device_colormode, $row['device_colormode'], $_device_address1, $_device_address2, $_device_transmission, $_device_type_rgb256, $_device_type_warm_white, $_device_type_cold_white);
		$sql = "UPDATE atomik_devices SET device_status = ".trim($_device_status).", device_colormode = ".trim($_device_colormode).", device_brightness = ".
		trim($_device_brightness).", device_rgb256 = ".trim($_device_rgb256).", device_white_temprature = ".trim($_device_white_temprature).", device_transmission = ".trim($_device_transmission)." WHERE device_id=".$_device_id.";";
		if ($conn->query($sql) === TRUE) {
    		$page_success = 1;
			$success_text = "Device Properties Updated!";
			
		} else {
    		$page_error = 1;
			$error_text = "Error Saving Device Properties To DB!";
		}
	}		
}

// Sync Bulb (sync_device)
if ($command <> "" && $command !="" && $command == "sync_device") 
{	
	$erro = array();
	if ($_new_device == 1 )
	{
		array_push($erro, "Please Save General Device Details Before Syncing A Device");	
	} 
	
	if (count($erro) > 0) 
	{
		$page_error = 1;
		$error_text = processErrors($erro);	
	} else {
		
			// Run Sync Device Command
			if ($_device_type_warm_white && $_device_type_cold_white) {
				$sendcom = "/usr/bin/transceiver -s -t 2 -q ".dechex($_device_address1)." -r ".dechex($_device_address2)." -v ".dechex($_device_transmission);
			} else {
				$sendcom = "/usr/bin/transceiver -s -t 1 -q ".dechex($_device_address1)." -r ".dechex($_device_address2)." -v ".dechex($_device_transmission);
			}
			
			exec($sendcom.' > /dev/null &');
			$_device_transmission = $_device_transmission + 5;
			$sql = "UPDATE atomik_devices SET device_transmission = ".trim($_device_transmission)." WHERE device_id=".$_device_id.";";
			if ($conn->query($sql) === TRUE) {
    			$page_success = 1;
				$success_text = "Device Synced!";
			
			} else {
    			$page_error = 1;
				$error_text = "Device Synced , but DB Error!";
			}
			
	}	
	
}

// De-Sync Bulb (desync_device)
if ($command <> "" && $command !="" && $command == "desync_device") 
{	
	$erro = array();
	if ($_new_device == 1 )
	{
		array_push($erro, "Please Save General Device Details Before De-Syncing A Device");	
	} 
	
	if (count($erro) > 0) 
	{
		$page_error = 1;
		$error_text = processErrors($erro);	
	} else {
		
			// Run Sync Device Command
			if ($_device_type_warm_white && $_device_type_cold_white) {
				$sendcom = "/usr/bin/transceiver -u -t 2 -q ".dechex($_device_address1)." -r ".dechex($_device_address2)." -v ".dechex($_device_transmission);
			} else {
				$sendcom = "/usr/bin/transceiver -u -t 1 -q ".dechex($_device_address1)." -r ".dechex($_device_address2)." -v ".dechex($_device_transmission);
			}
			
			exec($sendcom.' > /dev/null &');
			$_device_transmission = $_device_transmission + 5;
			$sql = "UPDATE atomik_devices SET device_transmission = ".trim($_device_transmission )." WHERE device_id=".$_device_id.";";
			if ($conn->query($sql) === TRUE) {
    			$page_success = 1;
				$success_text = "Device De-Synced!";
			
			} else {
    			$page_error = 1;
				$error_text = "Device De-Synced , but DB Error!";
			}
			
	}	
	
}

// Delete Device (delete_device)
if ($command <> "" && $command !="" && $command == "delete_device") 
{	
	if ($_new_device == 1 )
	{
		header('Location: devices.php');
	} else {
		$sql="DELETE FROM atomik_devices WHERE device_id=".$_device_id.";";
 
		if($conn->query($sql) === false) {
			$page_error = 1;
			$error_text = "Error Deleting Device From Device DB!";
		} else {
  			$page_success = 1;
			$success_text = "Device Deleted!";
		}	
		
		$sql="DELETE FROM atomik_zone_devices WHERE zone_device_device_id=".trim($_device_id).";";
 
		if($conn->query($sql) === false) {
			$page_error = 1;
			$error_text = "Error Deleting Device From Zone DB!";
		} else {
	  		$page_success = 1;
			$success_text = "Device Deleted!";
			header('Location: devices.php');		
		}	
	}
}
?>
</head><div id="overlay"></div>
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
        <li><a href="settings.php">Settings</a> </li>
        <li class="active"><a href="devices.php">Devices<span class="sr-only">(current)</span></a> </li>
        <li><a href="remotes.php">Remotes</a> </li>
        <li><a href="zones.php">Zones</a> </li>
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
          <h3>Device Details</h3>
        </div>
    </div>
   </div><?php if ( $page_success || $page_error ) { ?><hr><?php } ?><?php if ( $page_success ) { ?><div class="alert alert-success">
  <strong>Success!</strong> <?php echo $success_text; ?>
</div><?php } ?><?php if ( $page_error ) { ?><div class="alert alert-danger">
  <strong>Danger!</strong> <?php echo $error_text; ?>
</div><?php } ?><hr>
  <br><form id="devicefrm" name="devicefrm" enctype="multipart/form-data" action="device_details.php" method="post"><input type="hidden" name="command" id="command" value="" >
  <div class="container">
        <div class="col-xs-2"></div>
        <div class="col-xs-8">
            <h4><p>General Device Details:</p></h4>   
  <table class="table table-striped">
  <thead>
    <tr<?php if ( $_error_device_name == 1 ) { ?> class="text-danger"<?php }; ?>>
        <td>
          <p>Device Name: </p>
        </td>
        <td><p><input type="text" class="form-control" id="device_name" name="device_name" value="<?php echo $_device_name; ?>"></p></td>
    </tr>  
  </thead>
    <tbody>
    <tr<?php if ( $_error_device_description == 1 ) { ?> class="text-danger"<?php }; ?>>
        <td><p>Device Description: </p></td>
        <td><p><textarea class="form-control" rows="4" cols="1" name="device_description" id="device_description"><?php echo $_device_description; ?></textarea></p></td>
      </tr>
      <tr>
        <td><p>Device Type: </p></td>
        <td><center><p><strong><?php echo $_device_type_name; ?></strong></p></center></td>
      </tr>
      </tbody>
  </table><input type="hidden" name="new_device" id="new_device" value="<?php echo $_new_device; ?>"><input type="hidden" name="device_type" id="device_type" value="<?php echo $_device_type; ?>"><input type="hidden" name="device_id" id="device_id" value="<?php echo $_device_id; ?>">
</div>
<div class="col-xs-2"></div></div><div class="container">
<div class="col-xs-2"></div>
  <div class="col-xs-8 text-center"><hr></div>
  <div class="col-xs-2"></div>
</div>
<div class="container">
<div class="col-xs-2"></div>
  <div class="col-xs-4 text-center"></div>
  <div class="col-xs-4 text-center"><p><a id="savegeneralbtn" class="btn-success btn">Save General Device Details</a></p></div>
  <div class="col-xs-2"></div>
  </div>
  <br>
  <div class="container">
        <div class="col-xs-2"></div>
        <div class="col-xs-8"><hr>
            <h4><p>Device Properties:</p></h4>
  <table class="table table-striped">
  <thead>
    <tr>
        <td>
          <p>Device Status: </p>
        </td>
        <td><p><select id="device_status" name="device_status" class="form-control">
  <option value="1" <?php if ($_device_status == 1) { echo ' selected'; }?>>ON</option>
  <option value="0" <?php if ($_device_status == 0) { echo ' selected'; }?>>OFF</option>
</select></p></td>
    </tr>  
  </thead>
    <tbody>
    <?php if ( ( $_device_type_rgb256 == 1 && $_device_type_warm_white == 1 ) || ( $_device_type_rgb256 == 1 && $_device_type_cold_white == 1 ) ) { ?><tr>
        <td>
          <p>Device Color Mode: </p>
        </td>
        <td><p><select id="device_colormode" name="device_colormode" class="form-control">
  <option value="1"<?php if ($_device_colormode == 1) { echo ' selected'; }?>>White Mode</option>
  <option value="0"<?php if ($_device_colormode == 0) { echo ' selected'; }?>>Color Mode</option>
</select></p></td>
    </tr> <?php }; ?>
    <?php if ( $_device_type_rgb256 == 0 ) { ?><tr>
        <td>
          <p>Device Color Mode: </p>
        </td>
        <td><input type="hidden" name="device_colormode" id="device_colormode" value="<?php echo $_device_colormode; ?>"><p><center><b>White Mode</b></center></p></td>
    </tr> <?php }; ?>
    <?php if ( $_device_type_brightness == 1 ) { ?><tr<?php if ( $_error_device_brightness == 1 ) { ?> class="text-danger"<?php }; ?>>
        <td>
          <p>Device Brightness (0-100): </p>
        </td>
        <td><p><input type="text" class="form-control" id="device_brightness" name="device_brightness" value="<?php echo $_device_brightness; ?>"></p></td>
    </tr> <?php }; ?>
    <?php if ( $_device_type_rgb256 == 1 ) { ?><tr<?php if ( $_error_device_rgb256 == 1 ) { ?> class="text-danger"<?php }; ?>>
        <td>
          <p>Device Color (0-255): </p>
        </td>
        <td><p><input type="text" class="form-control" id="device_rgb256" name="device_rgb256" value="<?php echo $_device_rgb256; ?>"></p></td>
    </tr><?php }; ?>
    <?php if ( $_device_type_cold_white == 1 && $_device_type_warm_white == 1 ) { ?><tr<?php if ( $_error_device_white_temprature == 1 ) { ?> class="text-danger"<?php }; ?>>
        <td>
          <p>Device White Temperature (2700-6500):</p>
        </td>
        <td><p><input type="text" class="form-control" id="device_white_temprature" name="device_white_temprature" value="<?php echo $_device_white_temprature; ?>"></p></td>
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
  <div class="col-xs-4 text-center"><p><a id="savepropertiesbtn" class="btn-success btn">Set Device Properties</a></p></div>
  <div class="col-xs-2"></div>
  </div>
<br>
  <div class="container">
        <div class="col-xs-2"></div>
        <div class="col-xs-8"><hr>
            <h4><p>MiLight Device Details:</p></h4>   
  <table class="table table-striped">
  <thead>
    <tr>
        <td>
          <p>Address Byte 1: </p>
        </td>
        <td><p><b><?php echo $_device_address1; ?></b></p></td>
    </tr>  
  </thead>
    <tbody>
    <tr>
        <td width="350"><p>Address Byte 2: </p></td>
        <td><p><b><?php echo $_device_address2; ?></b></p></td>
      </tr>
      <tr>
        <td><p>Transmission Number: </p></td>
        <td><p><b><?php echo $_device_transmission; ?></b></p></td>
      </tr>
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
  <div class="col-xs-4 text-center"><p><a id="syncdevbtn" class="btn-warning btn">Sync Device</a></p></div>
  <div class="col-xs-4 text-center"><p><a id="desyncdevbtn" class="btn-warning btn">De-Sync Device</a></p></div>
  
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
  <div class="col-xs-1"><a href="devices.php" class="btn-warning btn">Cancel</a>
  </div>
  <div class="col-xs-1"><a id="deldevbtn" class="btn-danger btn">Delete Device</a>
  </div>
  <div class="col-xs-4">
  </div>
  <div class="col-xs-2 text-right"><a id="saveallbtn" class="btn-success btn">Save All Details</a>
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
   document.forms["devicefrm"].command.value = "save_general";
   document.devicefrm.submit();
});
$("#savepropertiesbtn").on('click', function() {
   document.forms["devicefrm"].command.value = "save_properties";
   document.devicefrm.submit();
});
$("#saveallbtn").on('click', function() {
   document.forms["devicefrm"].command.value = "save_all";
   document.devicefrm.submit();
});
$("#deldevbtn").on('click', function() {
	$("#overlay").show();
	if (window.confirm("Are you sure?")) {
        document.forms["devicefrm"].command.value = "delete_device";
   		document.devicefrm.submit();
	}
	$("#overlay").hide();
});
$("#syncdevbtn").on('click', function() {
	$("#overlay").show();
	if (window.confirm("Sync Bulb\n\nPlease turn on the power to your bulb and immediately click the OK button below. \n\nAre you ready?")) {
        document.forms["devicefrm"].command.value = "sync_device";
   		document.devicefrm.submit();
	}
	$("#overlay").hide();
});
$("#desyncdevbtn").on('click', function() {
	$("#overlay").show();
	if (window.confirm("De-Sync Bulb\n\nPlease turn on the power to your bulb and immediately click the OK button below. \n\nAre you ready?")) {
        document.forms["devicefrm"].command.value = "desync_device";
   		document.devicefrm.submit();
	}
	$("#overlay").hide();
});
</script>
</body><?php
$rs->free();
$conn->close();
?>
</html>