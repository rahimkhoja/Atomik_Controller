<?php

echo "Atomik Techonologies - CRON Zone Properties Update Script\n";
echo "Version 0.8 Alpha\n";

// Set Color Brightness to Valid Value
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

// Set White Brightness To Valid Value
function whiteBright( $bri ) {
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

// Increment Transmission Number Between 0 and 255
function IncrementTransmissionNum($number){
        $trans = $number + 1;
        
        if ($trans >= 256) {
            $trans = $trans - 256;
        }

        return $trans;
    }

// Transmits Commands To Bulbs
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

      if ($new_b != $old_b) {
        // Brightness Change

        if ($new_b <= 9) {
          $new_b = 9;
         } else if ( $new_b <= 18) {
            $new_b = 18;
           } else if ( $new_b <= 27) {
            $new_b = 27;
           } else if ( $new_b <= 36) {
            $new_b = 36;
           } else if ( $new_b <= 45) {
            $new_b = 45;
           } else if ( $new_b <= 54) {
            $new_b = 54;
           } else if ( $new_b <= 63) {
            $new_b = 63;
           } else if ( $new_b <= 72) {
            $new_b = 72;
           } else if ( $new_b <= 81) {
            $new_b = 81;
           } else if ( $new_b <= 90) {
            $new_b = 90;
           } else if ( $new_b <= 100) {
            $new_b = 100;
          }

          $old_pos = array_search($old_b, $Brightness);
          $new_pos = array_search($new_b, $Brightness);
          if ($new_pos > $old_pos) {
            if ($new_pos == array_search(100, $Brightness)) {
              $trans = IncrementTransmissionNum($trans);

              $sendcom = $sendcommandbase . " -k " . dechex((255 - $trans)) . " -v " . dechex($trans) . " -b 18";
              exec($sendcom . ' > /dev/null &');
            }
            else {
              $move = $new_pos - $old_pos;
              for ($x = 0; $x <= $move; $x++) {
                $trans = IncrementTransmissionNum($trans);

                $sendcom = $sendcommandbase . " -k " . dechex((255 - $trans)) . " -v " . dechex($trans) . " -b 0C";
                exec($sendcom . ' > /dev/null &');
              }
            }
          }
          else {
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

          $old_pos = array_search($old_wt, $WhiteTemp);
          $new_pos = array_search($new_wt, $WhiteTemp);
          if ($new_pos > $old_pos) {
            $move = $new_pos - $old_pos;
            for ($x = 0; $x <= $move; $x++) {
              $trans = IncrementTransmissionNum($trans);
              $sendcom = $sendcommandbase . " -k " . dechex((255 - $trans)) . " -v " . dechex($trans) . " -b 0f";
              exec($sendcom . ' > /dev/null &');
            }
          }
          else {
            $move = $old_pos - $new_pos;
            for ($x = 0; $x <= $move; $x++) {
              $trans = IncrementTransmissionNum($trans);
              $sendcom = $sendcommandbase . " -k " . dechex((255 - $trans)) . " -v " . dechex($trans) . " -b 0e";
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
        exec($sendcom . ' > /dev/null &');
      }
      // End Status Change

      if ($new_s == 1) {

        // Status On

        if ($old_cm != $new_cm) {

          // Color Mode Change

          $trans = IncrementTransmissionNum($trans);

          if ($new_cm == 1) {
            $sendcom = $sendcommandbase . " -k 13 -v " . dechex($trans) . " -c " . dechex($old_c);
          }
          else {
            $sendcom = $sendcommandbase . " -k 03 -v " . dechex($trans) . " -c " . dechex($old_c);
			$old_b = 0;
          }
          exec($sendcom . ' > /dev/null &');
        }

        // End Color Mode Change > /dev/null &

        if ($new_cm == 0) {
          // Color Mode Color

          if ($new_c != $old_c ) {
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
           } else if ( $new_b == 8) {
            $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(121) . " -k 0e -v " . dechex($trans);
           } else if ( $new_b == 12) {
            $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(113) . " -k 0e -v " . dechex($trans);
           } else if ( $new_b == 15) {
            $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(105) . " -k 0e -v " . dechex($trans);
           } else if ( $new_b == 19) {
            $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(97) . " -k 0e -v " . dechex($trans);
           } else if ( $new_b == 23) {
            $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(89) . " -k 0e -v " . dechex($trans);
           } else if ( $new_b == 27) {
            $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(81) . " -k 0e -v " . dechex($trans);
           } else if ( $new_b == 31) {
            $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(73) . " -k 0e -v " . dechex($trans);
           } else if ( $new_b == 35) {
            $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(65) . " -k 0e -v " . dechex($trans);
           } else if ( $new_b == 39) { //10
            $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(57) . " -k 0e -v " . dechex($trans);
           } else if ( $new_b == 42) { //11
            $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(49) . " -k 0e -v " . dechex($trans);
           } else if ( $new_b == 46) { //12
            $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(41) . " -k 0e -v " . dechex($trans);
           } else if ( $new_b == 50) { //13
            $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(33) . " -k 0e -v " . dechex($trans);
           } else if ( $new_b == 54) { //14
            $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(25) . " -k 0e -v " . dechex($trans);
           } else if ( $new_b == 58) { //15
            $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(17) . " -k 0e -v " . dechex($trans);
           } else if ( $new_b == 62) { //16
            $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(9) . " -k 0e -v " . dechex($trans);
           } else if ( $new_b == 65) { //17
            $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(1) . " -k 0e -v " . dechex($trans);
           } else if ( $new_b == 69) { //18
            $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(249) . " -k 0e -v " . dechex($trans);
           } else if ( $new_b == 73) { //19
            $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(241) . " -k 0e -v " . dechex($trans);
           } else if ( $new_b == 77) { // 20
            $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(233) . " -k 0e -v " . dechex($trans);
           } else if ( $new_b == 81) { // 21
            $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(225) . " -k 0e -v " . dechex($trans);
           } else if ( $new_b == 85) { // 22
            $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(217) . " -k 0e -v " . dechex($trans);
           } else if ( $new_b == 88) { // 23
            $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(209) . " -k 0e -v " . dechex($trans);
           } else if ( $new_b == 92) { // 24
            $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(201) . " -k 0e -v " . dechex($trans);
           } else if ( $new_b == 96) { // 25
            $sendcom = $sendcommandbase . " -c " . dechex($new_c) . " -b " . dechex(193) . " -k 0e -v " . dechex($trans);
           } else if ( $new_b == 100) { // 26
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
                
                if ( $cw == 1 & $ww == 1 ) {
                    $new_b = whiteBright($new_b);
                }

                $tra = transmit($new_b, $old_b, $new_s, $old_s, $new_c, $old_c, $new_wt, $old_wt, $new_cm, $old_cm, $add1, $add2, $tra, $rgb, $cw, $ww);
                // Update Devices with new Properties 
                $sql = "UPDATE atomik_devices SET device_status = ".trim($new_s).", device_colormode = ".trim($new_cm).", device_brightness = ".trim($new_b).", device_rgb256 = ".trim($new_c).", device_white_temprature = ".trim($new_wt).", device_transmission = ".trim($tra)." WHERE device_id=".$dev_id.";";
                
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

            $sql = "UPDATE atomik_zones SET zone_status = ".trim($new_s).", zone_colormode = ".trim($new_cm).", zone_brightness = ".trim($new_b).", zone_rgb256 = ".trim($new_c).", zone_white_temprature = ".trim($new_wt).",zone_last_update = CONVERT_TZ(NOW(), '".$tz."', 'UTC') WHERE zone_id=".$zon.";";
            
            if ($db->query($sql) === TRUE) {
                $success = TRUE;
            } else {
                $success = FALSE;
            }

        }

        $uzrs->free();
        return $success;
    }


$DBServer = '127.0.0.1';
$DBUser   = 'root';
$DBPass   = 'raspberry';
$DBName   = 'atomik_controller';

$con = mysqli_connect( $DBServer  , "root" , $DBPass , $DBName);

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  } else {
	echo "Connected to DB\n";
  }

// Timezone
    $sql = "SELECT timezone FROM atomik_settings;";
    $rs=$con->query($sql);
    
    if($rs === false) {
        trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
    } 

    $rs->data_seek(0);
    $row = $rs->fetch_assoc();
    $timezone = $row['timezone'];
    $rs->free();

if ($argc != 7 ) {
        echo "Command Requires 6 Integer arguments\n";
        echo $argv[0].' Zone_id Zone_Status Zone_Brightness Zone_ColorMode Zone_Color Zone_WhiteTemp'."\n";
 exit;
    } else {
        $zone = $argv[1];
        $b_new = $argv[3];
        $c_new = $argv[5];
        $s_new = $argv[2];
        $wt_new = $argv[6];
        $cm_new = $argv[4];
        echo "Updating Zone ".$zone." To: ";
	echo "Status: ".$s_new." - Brightness: ".$b_new."% - Color Mode: ".$cm_new." - Color: ".$c_new." - White Temp: ".$wt_new;        

 updateZone($con, $zone, colorBright($b_new),  $s_new,  $c_new,  $wt_new,  $cm_new, $timezone);
    }
mysqli_close($con);

?> 
