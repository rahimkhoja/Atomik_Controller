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
<title>Atomik Controller - Scheduled Task Details</title>
<link rel="stylesheet" href="css/atomik.css">
<script src="js/jquery-1.12.3.min.js"></script>
<script src="js/jquery.redirect.min.js"></script>
<?php 

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

// Set Post Variables

if ( isset($_POST["new_task"]) ) {
	$_new_task = $_POST["new_task"];
} else {
	$_new_task = 0;
}

if ( isset($_POST["task_id"]) ) {
	$_task_id = $_POST["task_id"];
} else {
	$_task_id = "";
}

if ( $_new_task == 0 ) {
// Atomik Setting SQL
	$sql = "SELECT atomik_tasks.task_id, atomik_tasks.task_name, atomik_tasks.task_description, atomik_tasks.task_zone_id, atomik_tasks.task_status, atomik_tasks.task_color_mode, atomik_tasks.task_brightness, atomik_tasks.task_rgb256, atomik_tasks.task_white_temprature, atomik_tasks.task_cron_minute, atomik_tasks.task_cron_hour, atomik_tasks.task_cron_day, atomik_tasks.task_cron_month, atomik_tasks.task_cron_weekday FROM atomik_tasks WHERE atomik_tasks.task_id = ".$_task_id.";";  
	
	$rs=$conn->query($sql);
 
	if($rs === false) {
	  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
	} else {
	  $db_records = $rs->num_rows;
	}

	$rs->data_seek(0);
	$row = $rs->fetch_assoc();
}

// Post Variable 
if ( isset($_POST["task_name"])) {
	$_task_name = $_POST["task_name"];
} else {
	if ($_new_task == 0 ) {
		$_task_name = $row['task_name'];
	} 
}

if ( isset($_POST["task_description"])) {
	$_task_description = $_POST["task_description"];
} else {
	if ($_new_task == 0 ) {
		$_task_description = $row['task_description'];
	} 
}

if ( isset($_POST["task_zone_id"])) {
	$_task_zone = $_POST["task_zone_id"];
} else {
	if ($_new_task == 0 ) {
		$_task_zone = $row['task_zone_id'];
	} 
}

if ( isset($_POST["task_status"])) {
	$_task_status = $_POST["task_status"];
} else {
	if ($_new_task == 0 ) {
		$_task_status = $row['task_status'];
	} else {
		$_task_status = "";
	}
}

if ( isset($_POST["task_colormode"])) {
	$_task_colormode = $_POST["task_colormode"];
} else {
	if ($_new_task == 0 ) {
		$_task_colormode = $row['task_color_mode'];
	} else {
		$_task_colormode = 1;
	}
}

if ( isset($_POST["task_rgb256"])) {
	$_task_rgb256 = $_POST["task_rgb256"];
} else {
	if ($_new_task == 0 ) {
		$_task_rgb256 = $row['task_rgb256'];
	} else {
		$_task_rgb256 = 0;
	}
}

if ( isset($_POST["task_white_temprature"])) {
	$_task_white_temprature = $_POST["task_white_temprature"];
} else {
	if ($_new_task == 0 ) {
		$_task_white_temprature = $row['task_white_temprature'];
	} else {
		$_task_white_temprature = 2700;
	}
}

if ( isset($_POST["task_hour"])) {
	$_task_hour = $_POST["task_hour"];
} else {
	if ($_new_task == 0 ) {
		$_task_hour = unserialize($row['task_cron_hour']);
	} else {
		$_task_hour = array();
	}
}

if ( isset($_POST["task_day"])) {
	$_task_day = $_POST["task_day"];
	if (empty($_task_day)) {
		$_task_day = array();
	}
} else {
	$_task_day = "";
	if ($_new_task == 0 ) {
		$_task_day = unserialize($row['task_cron_day']);	
	} 
	if (empty($_task_day)) {
		$_task_day = array();
	}
}

if ( isset($_POST["task_weekday"])) {
	$_task_weekday = $_POST["task_weekday"];
	if (empty($_task_weekday)) {
		$_task_weekday = array();
	} 
} else {
	$_task_weekday = "";
	if ($_new_task == 0 ) {
		$_task_weekday = unserialize($row['task_cron_weekday']);
	} 
	if (empty($_task_weekday)) {
		$_task_weekday = array();
	}
}

if ( isset($_POST["task_minute"])) {
	$_task_minute = $_POST["task_minute"];
} else {
	if ($_new_task == 0 ) {
		
		$_task_minute = unserialize($row['task_cron_minute']);
	} else {
		$_task_minute = array();
	}
}

if ( isset($_POST["task_month"])) {
	$_task_month = $_POST["task_month"];
} else {
	if ($_new_task == 0 ) {
		$_task_month = unserialize($row['task_cron_month']);
	} else {
		$_task_month = array();
	}
}

if ($_task_white_temprature <= 2700) {
	$_task_white_temprature = 2700;
} else if ($_task_white_temprature <= 3080) {
	$_task_white_temprature = 3080;
} else if ($_task_white_temprature <= 3460) {
	$_task_white_temprature = 3460;
} else if ($_task_white_temprature <= 3840) {
	$_task_white_temprature = 3840;
} else if ($_task_white_temprature <= 4220) {
	$_task_white_temprature = 4220;
} else if ($_task_white_temprature <= 4600) {
	$_task_white_temprature = 4600;
} else if ($_task_white_temprature <= 4980) {
	$_task_white_temprature = 4980;
} else if ($_task_white_temprature <= 5360) {
	$_task_white_temprature = 5360;
} else if ($_task_white_temprature <= 5740) {
	$_task_white_temprature = 5740;
} else if ($_task_white_temprature <= 6120) {
	$_task_white_temprature = 6120;
} else if ($_task_white_temprature <= 6500) {
	$_task_white_temprature = 6500;
} else if ($_task_white_temprature > 6500) {
	$_task_white_temprature = 6500;
} 

if ( isset($_POST["task_brightness"])) {
	$_task_brightness = intval($_POST["task_brightness"]);
	if ($_task_brightness <= 4) {
	$_task_brightness = 4;
} else if ($_task_brightness <= 8) {
	$_task_brightness = 8;
} else if ($_task_brightness <= 12) {
	$_task_brightness = 12;
} else if ($_task_brightness <= 15) {
	$_task_brightness = 15;
} else if ($_task_brightness <= 19) {
	$_task_brightness = 19;
} else if ($_task_brightness <= 23) {
	$_task_brightness = 23;
} else if ($_task_brightness <= 27) {
	$_task_brightness = 27;
} else if ($_task_brightness <= 31) {
	$_task_brightness = 31;
} else if ($_task_brightness <= 35) {
	$_task_brightness = 35;
} else if ($_task_brightness <= 39) {
	$_task_brightness = 39;
} else if ($_task_brightness <= 42) {
	$_task_brightness = 42;
} else if ($_task_brightness <= 46) {
	$_task_brightness = 46;
} else if ($_task_brightness <= 50) {
	$_task_brightness = 50;
} else if ($_task_brightness <= 54) {
	$_task_brightness = 54;
} else if ($_task_brightness <= 58) {
	$_task_brightness = 58;
} else if ($_task_brightness <= 62) {
	$_task_brightness = 62;
} else if ($_task_brightness <= 65) {
	$_task_brightness = 65;
} else if ($_task_brightness <= 69) {
	$_task_brightness = 69;
} else if ($_task_brightness <= 73) {
	$_task_brightness = 73;
} else if ($_task_brightness <= 77) {
	$_task_brightness = 77;
} else if ($_task_brightness <= 81) {
	$_task_brightness = 81;
} else if ($_task_brightness <= 85) {
	$_task_brightness = 85;
} else if ($_task_brightness <= 88) {
	$_task_brightness = 88;
} else if ($_task_brightness <= 92) {
	$_task_brightness = 92;
} else if ($_task_brightness <= 96) {
	$_task_brightness = 96;
} else if ($_task_brightness <= 100) {
	$_task_brightness = 100;
} else if ($_task_brightness > 100) {
	$_task_brightness = 100;
} 
} else {
	if ($_new_task == 0 ) {
		$_task_brightness = intval($row['task_brightness']);
	} else {
		$_task_brightness = 0;
	}
}

// Atomik Zone List

$sql = "SELECT atomik_zones.zone_name, atomik_zones.zone_id FROM atomik_zones;";  

$zlrs=$conn->query($sql);
 
if($zlrs === false) {
	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
} else {
	$totalZones = $zlrs->num_rows;
	if ($_new_task == 1) {
		$zlrs->data_seek(0);	
		$_task_zone = 0;
		
		if ( $totalZones >= 1 ) {
			$zlrow = $zlrs->fetch_assoc();
			if ( isset($_POST["task_zone_id"])) {
				$_task_zone = $_POST["task_zone_id"];
			} else {
				$_task_zone = $zlrow['zone_id'];
			}
		}
		
	}
	
	$zlrs->data_seek(0);	
}

if ( $_task_zone != 0 ) {	
	
// Atomik Setting SQL

	$sql = "SELECT 
atomik_device_types.device_type_rgb256, 
atomik_device_types.device_type_warm_white, 
atomik_device_types.device_type_cold_white, 
atomik_device_types.device_type_brightness 
FROM 
atomik_zone_devices, atomik_device_types, atomik_devices 
WHERE 
atomik_zone_devices.zone_device_zone_id=".$_task_zone." &&
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
atomik_zone_devices.zone_device_zone_id=".$_task_zone." &&
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
		
	$sql = "SELECT atomik_device_types.device_type_rgb256, atomik_device_types.device_type_warm_white, atomik_device_types.device_type_cold_white, atomik_device_types.device_type_brightness FROM atomik_zone_devices, atomik_device_types, atomik_devices WHERE atomik_zone_devices.zone_device_zone_id=".$_task_zone." && atomik_zone_devices.zone_device_device_id=atomik_devices.device_id && atomik_devices.device_type=atomik_device_types.device_type_id && atomik_device_types.device_type_rgb256=1;";  

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
atomik_zone_devices.zone_device_zone_id=".$_task_zone." &&
atomik_zone_devices.zone_device_device_id=atomik_devices.device_id && 
atomik_devices.device_type=atomik_device_types.device_type_id && 
atomik_device_types.device_type_rgb256=1;";  

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

// Save General Task Settings [Keep Post Data, Verify Form, DB] (save_general)
if ($command <> "" && $command !="" && $command == "save_general") 
{	
	$erro = array();
	if ($_new_task == 1 )
	{
		if (!preg_match("/^[a-zA-Z0-9. -]+$/", $_task_name)) {
			array_push($erro, "Task Name Contains Illegal Characters, Please Only Use Letters, Numbers, Spaces, Periods, and Dashes");
			$_error_task_name = 1;
		}
		
		if ( !( ( !empty($_task_description) && preg_match("/^[a-zA-Z0-9. -]+$/", $_task_description) ) || empty($_task_description) ) ) {
			array_push($erro, "Task Description Contains Illegal Characters, Please Only Use Letters, Numbers, Spaces, Periods, and Dashes");
			$_error_task_description = 1;
		}
		
		if ( $totalZones == 0 ) {
			array_push($erro, "No Zone Avaialble! Please Create A Zone Before Creating A Task");
			$_error_task_no_zone = 1;
		}
		
	} else {
		if ( $_task_name == $row['task_name'] && $_task_description == $row['task_description'] )
		{
			array_push($erro, "No Changes To Save");
		} else {
			if (!preg_match("/^[a-zA-Z0-9. -]+$/", $_remote_name)) {
				array_push($erro, "Task Name Contains Illegal Characters, Please Only Use Letters, Numbers, Spaces, Periods, and Dashes");
				$_error_task_name = 1;
			}
		
			if ( !( ( !empty($_task_description) && preg_match("/^[a-zA-Z0-9. -]+$/", $_task_description) ) || empty($_task_description) ) ) {
				array_push($erro, "Task Description  Contains Illegal Characters, Please Only Use Letters, Numbers, Spaces, Periods, and Dashes");
				$_error_task_description = 1;
			}
		}
	}
	
	if (count($erro) > 0) 
	{
		$page_error = 1;
		$error_text = processErrors($erro);	
	} else {
		
		if ( $_new_task == 1 ) {
			$sql = "INSERT INTO atomik_tasks (task_name, task_description, task_zone_id) VALUES ('".$_task_name."','".$_task_description."', ".$_task_zone.")";
			if ($conn->query($sql) === TRUE) {
    			
				$_new_task = 0;
				$_task_id = $conn->insert_id;
								
			} else {
    			$page_error = 1;
				$error_text = "Error Inserting Task Details To DB!";
			}
		} else {
			$sql = "UPDATE atomik_tasks SET task_name='".$_task_name."', task_description='".$_task_description."', task_zone_id=".$_task_zone." WHERE task_id=".$_task_id.";";
			if ($conn->query($sql) === TRUE) {
    			$page_success = 1;
				$success_text = "General Task Details Updated!";
			} else {
    			$page_error = 1;
				$error_text = "Error Saving General Task Details To DB!";
			}
		}
	}		
}

// Update Task Propeties [Keep Post Data, Verify Form, DB] (save_properties)
if ($command <> "" && $command !="" && $command == "save_properties") 
{	
	$erro = array();
	if ($_new_task == 1 )
	{
		array_push($erro, "Please Save General Task Details Before Saving Task Properties");	
	} else {
		if ( $_task_zone_id == $row['task_zone_id'] && $_task_status == $row['task_status'] && $_task_colormode == $row['task_colormode'] && $_task_brightness == $row['task_brightness'] && $_task_rgb256 == $row['task_rgb256'] && $_task_white_temprature == $row['task_white_temprature'] ) {
			array_push($erro, "No Changes To Save");
		} else {
			if ( $_zone_type_brightness == 1 ) {
				if (!Check0to100 ( $_task_brightness )) {
					array_push($erro, "Task Brightness Must Be A Number Between 0 and 100");
					$_error_task_brightness = 1;
				}
			}
			
			if ( $_zone_type_rgb256 == 1 && $_task_colormode == 0 ) {
				if (!Check0to255 ( $_task_rgb256)) {
					array_push($erro, "Task Color Must Be A Number Between 0 and 255");
					$_error_task_rgb256 = 1;
				}
			}
			
			if ( $_zone_type_cold_white == 1 && $_zone_type_warm_white == 1 && $_task_colormode == 1 ) {
				if (!Check2700to6500 ( $_task_white_temprature )) {
					array_push($erro, "Task White Temprature Must Be A Number Between 2700 and 6500");
					$_error_task_white_temprature = 1;
				}
			}	
		}	
	}
	
	if (count($erro) > 0) 
	{
		$page_error = 1;
		$error_text = processErrors($erro);	
	} else {
		
		$sql = "UPDATE atomik_tasks SET task_zone_id=".$_task_zone.", task_status=".$_task_status.", task_color_mode=".$_task_colormode.", task_brightness=".$_task_brightness.", task_rgb256=".$_task_rgb256.", task_white_temprature=".$_task_white_temprature."  WHERE task_id=".$_task_id.";";
		if ($conn->query($sql) === TRUE) {
    		$page_success = 1;
			$success_text = "Task Properties Updated!";
		} else {
    		$page_error = 1;
			$error_text = "Error Saving Task Properties To DB!";
		}
	}		
}	

// Update Task Schedule [Keep Post Data, Verify Form, DB] (save_schedule)
if ($command <> "" && $command !="" && $command == "save_schedule") 
{	
	$erro = array();
	if ($_new_task == 1 )
	{
		array_push($erro, "Please Save General Task Details Before Saving Task Schedule");	
	} else {
		if ( serialize($_task_minute) == $row['task_minute'] && serialize($_task_hour) == $row['task_hour'] && serialize($_task_day) == $row['task_day'] && serialize($_task_weekday) == $row['task_weekday'] && serialize($_task_year) == $row['task_year'] && serialize($_task_month) == $row['task_month'] ) {
			array_push($erro, "No Changes To Save");
		} else {
			if (  sizeof($_task_minute) == 0 ) {
					array_push($erro, "Task Minute Is A Required Input.");
					$_error_task_minute = 1;
				
			}
			
			if ( sizeof($_task_hour) == 0 ) {
					array_push($erro, "Task Hour Is A Required Input.");
					$_error_task_hour = 1;
			}
			
			if ( sizeof($_task_month) == 0 ) {
					array_push($erro, "Task Month Is A Required Input.");
					$_error_task_month = 1;
			}
			
			if ( in_array('*', $_task_weekday, true) && sizeof($_task_weekday) > 1 ) {
					array_push($erro, "Task Weekday Cannot Have Every Weekday As Well As Other Weekdays Selected.");
					$_error_task_weekday = 1;
			}
			
			if ( in_array('*', $_task_day, true) && sizeof($_task_day) > 1 ) {
					array_push($erro, "Task Day Cannot Have Everyday As Well As Other Days Selected.");
					$_error_task_day = 1;
			}
			
			if ( in_array('*', $_task_hour, true) && sizeof($_task_hour) > 1 ) {
					array_push($erro, "Task Hour Cannot Have Every Hour As Well As Other Hours Selected.");
					$_error_task_hour = 1;
			}
			
			if ( in_array('*', $_task_month, true) && sizeof($_task_month) > 1 ) {
					array_push($erro, "Task Month Cannot Have Every Month As Well As Other Months Selected.");
					$_error_task_month = 1;
			}			
			
			if ( sizeof($_task_day) == 0 && sizeof($_task_weekday) == 0 ) {
					array_push($erro, "Either Task Day Or Task Weekday Is A Required Input.");
					$_error_task_weekday = 1;
					$_error_task_day = 1;
			}

			if ( sizeof($_task_day) > 0 && sizeof($_task_weekday) > 0 ) {
					array_push($erro, "Please Only Select Either The Task Day Or The Task Weekday Input.");
					$_error_task_weekday = 1;
					$_error_task_day = 1;
			}
		}	
	}
	
	if (count($erro) > 0) 
	{
		$page_error = 1;
		$error_text = processErrors($erro);	
	} else {
		
		$sql = "UPDATE atomik_tasks SET task_cron_minute='".serialize($_task_minute)."', task_cron_hour='".serialize($_task_hour)."', task_cron_month='".serialize($_task_month)."', task_cron_day='".serialize($_task_day)."', task_cron_weekday='".serialize($_task_weekday)."'  WHERE task_id=".$_task_id.";";
		if ($conn->query($sql) === TRUE) {
    		$page_success = 1;
			$success_text = "Task Schedule Updated!";
		} else {
    		$page_error = 1;
			$error_text = "Error Saving Task Schedule To DB!";
		}
	}		
}	


// Delete Task (delete_task)
if ($command <> "" && $command !="" && $command == "delete_task") 
{	

	if ($_new_task == 1 )
	{
		header('Location: tasks.php');
	} else {
		$sql="DELETE FROM atomik_tasks WHERE task_id=".trim($_task_id).";";
 
		if($conn->query($sql) === false) {
			$page_error = 1;
			$error_text = "Error Deleting Task From Task DB!";
		} else {
			$page_success = 1;
			$success_text = "Task Deleted!";
			header('Location: tasks.php');		
		}
	}
}
?></head><div id="overlay"></div>
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
        <li><a href="devices.php">Devices</a> </li>
        <li><a href="remotes.php">Remotes</a> </li>
        <li><a href="zones.php">Zones</a> </li>
        <li class="active"><a href="tasks.php">Scheduled Tasks<span class="sr-only">(current)</span></a> </li>
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
          <h3>Scheduled Task Details</h3>
        </div>
    </div>
   </div><?php if ( $page_success || $page_error ) { ?><hr><?php } ?><?php if ( $page_success ) { ?><div class="alert alert-success">
  <strong>Success!</strong> <?php echo $success_text; ?>
</div><?php } ?><?php if ( $page_error ) { ?><div class="alert alert-danger">
  <strong>Danger!</strong> <?php echo $error_text; ?>
</div><?php } ?><hr>
  <br><form id="taskfrm" name="taskfrm" enctype="multipart/form-data" action="task_details.php" method="post"><input type="hidden" name="command" id="command" value="" >
  <div class="container">
        <div class="col-xs-2"></div>
        <div class="col-xs-8">
            <h4><p>General Task Details:</p></h4>   
  <table class="table table-striped">
  <thead>
    <tr>
        <td>
          <p>Task Name: </p>
        </td>
        <td><p><input type="text" class="form-control" id="task_name" name="task_name" value="<?php echo $_task_name; ?>"></p></td>
    </tr>  
  </thead>
    <tbody>
    <tr>
        <td><p>Task Description: </p><input type="hidden" name="new_task" id="new_task" value="<?php echo $_new_task; ?>"><input type="hidden" name="task_id" id="task_id" value="<?php echo $_task_id; ?>"></td>
        <td><p><textarea class="form-control" rows="4" cols="1" id="task_description" name="task_description" ><?php echo $_task_description; ?></textarea></p></td>
      </tr>
      </tbody>
  </table>
</div>
<div class="col-xs-2"></div></div><div class="container">
<div class="col-xs-2"></div>
  <div class="col-xs-8 text-center"><hr></div>
  <div class="col-xs-2"></div>
</div>
<div class="container">
<div class="col-xs-2"></div>
  <div class="col-xs-4 text-center"></div>
  <div class="col-xs-4 text-center"><p><a id="savegeneralbtn" class="btn-success btn">Save General Task Details</a></p></div>
  
  <div class="col-xs-2"></div>
  </div>
  <br>
  <div class="container">
        <div class="col-xs-2"></div>
        <div class="col-xs-8"><hr>
            <h4><p>Task Properties:</p></h4>
  <table class="table table-striped"><?php if ($totalZones == 0 ) { ?> 
  <thead>
    <tr>
        <td class="text-center" colspan="2"><p><b>No Zones Available</b></p></td>
    </tr> 
  </thead><?php } else { ?>
 <thead>
    <tr>
        <td width="250">
          <p>Task Zone: </p>
        </td>
        <td><p><select id="task_zone_id" name="task_zone_id" class="form-control">
        <?php while($zlrow = $zlrs->fetch_assoc()){ ?> <option value="<?php echo $zlrow['zone_id']; ?>"<?php if ( $zlrow['zone_id'] == $_task_zone ) { echo ' selected'; }; ?>><?php echo $zlrow['zone_name']; ?></option>
 <?php }; ?>
</select></p></td>
    </tr> 
  </thead>
    <tbody>
    <tr>
     <td><p>Task Status: </p></td>
        <td><p><select id="task_status" name="task_status" class="form-control">
  <option value="1" <?php if ($_task_status == 1) { echo ' selected'; }?>>ON</option>
  <option value="0" <?php if ($_task_status == 0) { echo ' selected'; }?>>OFF</option>
</select></p></td>
    </tr>  
    <?php if ( ( $_zone_type_rgb256 == 1 && $_zone_type_warm_white == 1 ) || ( $_zone_type_rgb256 == 1 && $_zone_type_cold_white == 1 ) ) { ?><tr>
        <td>
          <p>Task Color Mode: </p>
        </td>
        <td><p><select id="task_colormode" name="task_colormode" class="form-control">
  <option value="1"<?php if ($_task_colormode == 1) { echo ' selected'; }?>>White Mode</option>
  <option value="0"<?php if ($_task_colormode == 0) { echo ' selected'; }?>>Color Mode</option>
</select></p></td>
    </tr> <?php }; ?>
    <?php if ( $_zone_type_rgb256 == 0 ) { ?><tr>
        <td>
          <p>Task Color Mode: </p>
        </td>
        <td><input type="hidden" name="task_colormode" id="task_colormode" value="<?php echo $_task_colormode; ?>"><p><center><b>White Mode</b></center></p></td>
    </tr> <?php }; ?>
    <?php if ( $_zone_type_brightness == 1 ) { ?><tr>
        <td>
          <p>Task Brightness (0-100): </p>
        </td>
        <td><p><input type="text" class="form-control" id="task_brightness" name="task_brightness" value="<?php echo $_task_brightness; ?>"></p></td>
    </tr> <?php }; ?>
    <?php if ( $_zone_type_rgb256 == 1 ) { ?><tr>
        <td>
          <p>Task Color (0-255): </p>
        </td>
        <td><p><input type="text" class="form-control" id="task_rgb256" name="task_rgb256" value="<?php echo $_task_rgb256; ?>"></p></td>
    </tr><?php }; ?>
    <?php if ( $_zone_type_cold_white == 1 && $_zone_type_warm_white == 1 ) { ?><tr>
        <td>
          <p>Task White Temperature (2700-6500):</p>
        </td>
        <td><input type="text" class="form-control" id="task_white_temprature" name="task_white_temprature" value="<?php echo $_task_white_temprature; ?>"></td>
    </tr><?php }; ?>
      </tbody>
 <?php } ?> </table>
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
  <div class="col-xs-4 text-center"><p><a id="savepropertiesbtn" class="btn-success btn">Save Task Properties</a></p></div>
  
  <div class="col-xs-2"></div>
  </div>
<br>
  <div class="container">
        <div class="col-xs-2"></div>
        <div class="col-xs-8"><hr>
            <h4><p>Task Schedule:</p></h4>
        </div>
            <div class="col-xs-2"></div>
            </div>
            <div class="container">
            <div class="col-xs-2"></div>
            <div class="col-xs-4">
  <table class="table table-striped">
  <thead>
    <tr>
        <td>
          <p>Month: </p>
        </td>
        <td><p><select class="form-control" id="task_month[]" name="task_month[]" multiple>
  <option value="*" <?php if (in_array('*', $_task_month, true)) {
    echo "selected";
}; ?>>Every Month</option>
  <option value="1" <?php if (in_array('1', $_task_month, true)) {
    echo "selected";
}; ?>>January</option>
  <option value="2" <?php if (in_array('2', $_task_month, true)) {
    echo "selected";
}; ?>>February</option>
  <option value="3" <?php if (in_array('3', $_task_month, true)) {
    echo "selected";
}; ?>>March</option>
  <option value="4" <?php if (in_array('4', $_task_month, true)) {
    echo "selected";
}; ?>>April</option>
  <option value="5" <?php if (in_array('5', $_task_month, true)) {
    echo "selected";
}; ?>>May</option>
  <option value="6" <?php if (in_array('6', $_task_month, true)) {
    echo "selected";
}; ?>>June</option>
  <option value="7" <?php if (in_array('7', $_task_month, true)) {
    echo "selected";
}; ?>>July</option>
  <option value="8" <?php if (in_array('8', $_task_month, true)) {
    echo "selected";
}; ?>>August</option>
  <option value="9" <?php if (in_array('9', $_task_month, true)) {
    echo "selected";
}; ?>>September</option>
  <option value="10" <?php if (in_array('10', $_task_month, true)) {
    echo "selected";
}; ?>>October</option>
  <option value="11" <?php if (in_array('11', $_task_month, true)) {
    echo "selected";
}; ?>>November</option>
  <option value="12" <?php if (in_array('12', $_task_month, true)) {
    echo "selected";
}; ?>>December</option>
</select></p></td>
    </tr>
  </thead>
    <tbody>
      <tr>
        <td><p>Weekday: </p></td>
        <td><p><select class="form-control" id="task_weekday[]" name="task_weekday[]" multiple>
  <option value="*" <?php if (in_array('*', $_task_weekday, true)) {
    echo "selected";
}; ?>>Every Weekday</option>
  <option value="0" <?php if (in_array('0', $_task_weekday, true)) {
    echo "selected";
}; ?>>Sunday</option>
  <option value="1" <?php if (in_array('1', $_task_weekday, true)) {
    echo "selected";
}; ?>>Monday</option>
  <option value="2" <?php if (in_array('2', $_task_weekday, true)) {
    echo "selected";
}; ?>>Tuesday</option>
  <option value="3" <?php if (in_array('3', $_task_weekday, true)) {
    echo "selected";
}; ?>>Wednesday</option>
  <option value="4" <?php if (in_array('4', $_task_weekday, true)) {
    echo "selected";
}; ?>>Thursday</option>
  <option value="5" <?php if (in_array('5', $_task_weekday, true)) {
    echo "selected";
}; ?>>Friday</option>
  <option value="6" <?php if (in_array('6', $_task_weekday, true)) {
    echo "selected";
}; ?>>Saturday</option>
</select></p></td>
      </tr>
      <tr>
        <td><p>Minute: </p></td>
        <td><p><select class="form-control" id="task_minute[]" name="task_minute[]" multiple>
  <option value="0" <?php if ( in_array('0', $_task_minute, true) ){ 
echo 'selected'; 
 }; ?>>0</option>
  <option value="1" <?php if ( in_array('1', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>1</option>
  <option value="2" <?php if ( in_array('2', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>2</option>
  <option value="3" <?php if ( in_array('3', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>3</option>
  <option value="4" <?php if ( in_array('4', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>4</option>
  <option value="5" <?php if ( in_array('5', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>5</option>
  <option value="6" <?php if ( in_array('6', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>6</option>
  <option value="7" <?php if ( in_array('7', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>7</option>
  <option value="8" <?php if ( in_array('8', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>8</option>
  <option value="9" <?php if ( in_array('9', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>8</option>
  <option value="10" <?php if ( in_array('10', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>10</option>
  <option value="11" <?php if ( in_array('11', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>11</option>
  <option value="12" <?php if ( in_array('12', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>12</option>
  <option value="13" <?php if ( in_array('13', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>13</option>
  <option value="14" <?php if ( in_array('14', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>14</option>
  <option value="15" <?php if ( in_array('15', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>15</option>
  <option value="16" <?php if ( in_array('16', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>16</option>
  <option value="17" <?php if ( in_array('17', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>17</option>
  <option value="18" <?php if ( in_array('18', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>18</option>
  <option value="19" <?php if ( in_array('19', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>19</option>
  <option value="20" <?php if ( in_array('20', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>20</option>
  <option value="21" <?php if ( in_array('21', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>21</option>
  <option value="22" <?php if ( in_array('22', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>22</option>
  <option value="23" <?php if ( in_array('23', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>23</option>
  <option value="24" <?php if ( in_array('24', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>24</option>
  <option value="25" <?php if ( in_array('25', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>25</option>
  <option value="26" <?php if ( in_array('26', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>26</option>
  <option value="27" <?php if ( in_array('27', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>27</option>
  <option value="28" <?php if ( in_array('28', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>28</option>
  <option value="29" <?php if ( in_array('29', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>29</option>
  <option value="30" <?php if ( in_array('30', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>30</option>
  <option value="31" <?php if ( in_array('31', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>31</option>
  <option value="32" <?php if ( in_array('32', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>32</option>
  <option value="33" <?php if ( in_array('33', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>33</option>
  <option value="34" <?php if ( in_array('34', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>34</option>
  <option value="35" <?php if ( in_array('35', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>35</option>
  <option value="36" <?php if ( in_array('36', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>36</option>
  <option value="37" <?php if ( in_array('37', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>37</option>
  <option value="38" <?php if ( in_array('38', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>38</option>
  <option value="39" <?php if ( in_array('39', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>39</option>
  <option value="40" <?php if ( in_array('40', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>40</option>
  <option value="41" <?php if ( in_array('41', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>41</option>
  <option value="42" <?php if ( in_array('42', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>42</option>
  <option value="43" <?php if ( in_array('43', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>43</option>
  <option value="44" <?php if ( in_array('44', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>44</option>
  <option value="45" <?php if ( in_array('45', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>45</option>
  <option value="46" <?php if ( in_array('46', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>46</option>
  <option value="47" <?php if ( in_array('47', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>47</option>
  <option value="48" <?php if ( in_array('48', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>48</option>
  <option value="49" <?php if ( in_array('49', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>49</option>
  <option value="50" <?php if ( in_array('50', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>50</option>
  <option value="51" <?php if ( in_array('51', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>51</option>
  <option value="52" <?php if ( in_array('52', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>52</option>
  <option value="53" <?php if ( in_array('53', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>53</option>
  <option value="54" <?php if ( in_array('54', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>54</option>
  <option value="55" <?php if ( in_array('55', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>55</option>
  <option value="56" <?php if ( in_array('56', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>56</option>
  <option value="57" <?php if ( in_array('57', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>57</option>
  <option value="58" <?php if ( in_array('58', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>58</option>
  <option value="59" <?php if ( in_array('59', $_task_minute, true) ) { 
echo 'selected'; 
 }; ?>>59</option>
</select></p></td>
      </tr>
      </tbody>
  </table>
</div><div class="col-xs-4">
  <table class="table table-striped">
  <thead>
    <tr>
        <td><p>Day: </p></td>
        <td><p><select class="form-control" id="task_day[]" name="task_day[]" multiple>
    <option value="*" <?php if ( in_array('*', $_task_day, true) ) { 
echo 'selected'; 
 }; ?>>Everyday</option>
  <option value="0" <?php if ( in_array('0', $_task_day, true) ) { 
echo 'selected'; 
 }; ?>>0</option>
  <option value="1" <?php if ( in_array('1', $_task_day, true) ) { 
echo 'selected'; 
 }; ?>>1</option>
  <option value="2" <?php if ( in_array('2', $_task_day, true) ) { 
echo 'selected'; 
 }; ?>>2</option>
  <option value="3" <?php if ( in_array('3', $_task_day, true) ) { 
echo 'selected'; 
 }; ?>>3</option>
  <option value="4" <?php if ( in_array('4', $_task_day, true) ) { 
echo 'selected'; 
 }; ?>>4</option>
  <option value="5" <?php if ( in_array('5', $_task_day, true) ) { 
echo 'selected'; 
 }; ?>>5</option>
  <option value="6" <?php if ( in_array('6', $_task_day, true) ) { 
echo 'selected'; 
 }; ?>>6</option>
  <option value="7" <?php if ( in_array('7', $_task_day, true) ) { 
echo 'selected'; 
 }; ?>>7</option>
  <option value="8" <?php if ( in_array('8', $_task_day, true) ) { 
echo 'selected'; 
 }; ?>>8</option>
  <option value="9" <?php if ( in_array('9', $_task_day, true) ) { 
echo 'selected'; 
 }; ?>>8</option>
  <option value="10" <?php if ( in_array('10', $_task_day, true) ) { 
echo 'selected'; 
 }; ?>>10</option>
  <option value="11" <?php if ( in_array('11', $_task_day, true) ) { 
echo 'selected'; 
 }; ?>>11</option>
  <option value="12" <?php if ( in_array('12', $_task_day, true) ) { 
echo 'selected'; 
 }; ?>>12</option>
  <option value="13" <?php if ( in_array('13', $_task_day, true) ) { 
echo 'selected'; 
 }; ?>>13</option>
  <option value="14" <?php if ( in_array('14', $_task_day, true) ) { 
echo 'selected'; 
 }; ?>>14</option>
  <option value="15" <?php if ( in_array('15', $_task_day, true) ) { 
echo 'selected'; 
 }; ?>>15</option>
  <option value="16" <?php if ( in_array('16', $_task_day, true) ) { 
echo 'selected'; 
 }; ?>>16</option>
  <option value="17" <?php if ( in_array('17', $_task_day, true) ) { 
echo 'selected'; 
 }; ?>>17</option>
  <option value="18" <?php if ( in_array('18', $_task_day, true) ) { 
echo 'selected'; 
 }; ?>>18</option>
  <option value="19" <?php if ( in_array('19', $_task_day, true) ) { 
echo 'selected'; 
 }; ?>>19</option>
  <option value="20" <?php if ( in_array('20', $_task_day, true) ) { 
echo 'selected'; 
 }; ?>>20</option>
  <option value="21" <?php if ( in_array('21', $_task_day, true) ) { 
echo 'selected'; 
 }; ?>>21</option>
  <option value="22" <?php if ( in_array('22', $_task_day, true) ) { 
echo 'selected'; 
 }; ?>>22</option>
  <option value="23" <?php if ( in_array('23', $_task_day, true) ) { 
echo 'selected'; 
 }; ?>>23</option>
  <option value="24" <?php if ( in_array('24', $_task_day, true) ) { 
echo 'selected'; 
 }; ?>>24</option>
  <option value="25" <?php if ( in_array('25', $_task_day, true) ) { 
echo 'selected'; 
 }; ?>>25</option>
  <option value="26" <?php if ( in_array('26', $_task_day, true) ) { 
echo 'selected'; 
 }; ?>>26</option>
  <option value="27" <?php if ( in_array('27', $_task_day, true) ) { 
echo 'selected'; 
 }; ?>>27</option>
  <option value="28" <?php if ( in_array('28', $_task_day, true) ) { 
echo 'selected'; 
 }; ?>>28</option>
  <option value="29" <?php if ( in_array('29', $_task_day, true) ) { 
echo 'selected'; 
 }; ?>>29</option>
  <option value="30" <?php if ( in_array('30', $_task_day, true) ) { 
echo 'selected'; 
 }; ?>>30</option>
  <option value="31" <?php if ( in_array('31', $_task_day, true) ) { 
echo 'selected'; 
 }; ?>>31</option>
</select></p></td>
      </tr>  
  </thead>
    <tbody>
    <tr>
        <td><p>Hour: </p></td>
        <td><p><select class="form-control" id="task_hour[]" name="task_hour[]" multiple>
  <option value="*" <?php if (in_array('*', $_task_hour, true)) {
    echo "selected";
}; ?>>Every Hour</option>
  <option value="0" <?php if (in_array('0', $_task_hour, true)) {
    echo "selected";
}; ?>>0</option>
  <option value="1" <?php if (in_array('1', $_task_hour, true)) {
    echo "selected";
}; ?>>1</option>
  <option value="2" <?php if (in_array('2', $_task_hour, true)) {
    echo "selected";
}; ?>>2</option>
  <option value="3" <?php if (in_array('3', $_task_hour, true)) {
    echo "selected";
}; ?>>3</option>
  <option value="4" <?php if (in_array('4', $_task_hour, true)) {
    echo "selected";
}; ?>>4</option>
  <option value="5" <?php if (in_array('5', $_task_hour, true)) {
    echo "selected";
}; ?>>5</option>
  <option value="6" <?php if (in_array('6', $_task_hour, true)) {
    echo "selected";
}; ?>>6</option>
  <option value="7" <?php if (in_array('7', $_task_hour, true)) {
    echo "selected";
}; ?>>7</option>
  <option value="8" <?php if (in_array('8', $_task_hour, true)) {
    echo "selected";
}; ?>>8</option>
  <option value="9" <?php if (in_array('9', $_task_hour, true)) {
    echo "selected";
}; ?>>9</option>
  <option value="10" <?php if (in_array('10', $_task_hour, true)) {
    echo "selected";
}; ?>>10</option>
  <option value="11" <?php if (in_array('11', $_task_hour, true)) {
    echo "selected";
}; ?>>11</option>
  <option value="12" <?php if (in_array('12', $_task_hour, true)) {
    echo "selected";
}; ?>>12</option>
  <option value="13" <?php if (in_array('13', $_task_hour, true)) {
    echo "selected";
}; ?>>13</option>
  <option value="14" <?php if (in_array('14', $_task_hour, true)) {
    echo "selected";
}; ?>>14</option>
  <option value="15" <?php if (in_array('15', $_task_hour, true)) {
    echo "selected";
}; ?>>15</option>
  <option value="16" <?php if (in_array('16', $_task_hour, true)) {
    echo "selected";
}; ?>>16</option>
  <option value="17" <?php if (in_array('17', $_task_hour, true)) {
    echo "selected";
}; ?>>17</option>
  <option value="18" <?php if (in_array('18', $_task_hour, true)) {
    echo "selected";
}; ?>>18</option>
  <option value="19" <?php if (in_array('19', $_task_hour, true)) {
    echo "selected";
}; ?>>19</option>
  <option value="20" <?php if (in_array('20', $_task_hour, true)) {
    echo "selected";
}; ?>>20</option>
  <option value="21" <?php if (in_array('21', $_task_hour, true)) {
    echo "selected";
}; ?>>21</option>
  <option value="22" <?php if (in_array('22', $_task_hour, true)) {
    echo "selected";
}; ?>>22</option>
  <option value="23" <?php if (in_array('23', $_task_hour, true)) {
    echo "selected";
}; ?>>23</option>
</select></p></td>
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
  <div class="col-xs-2 text-center"></div>
  <div class="col-xs-2 text-center"></div>
  <div class="col-xs-4 text-center"><p><a id="saveschedulebtn" class="btn-success btn">Save Task Schedule</a></p></div>
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
  <div class="col-xs-1"><a href="tasks.php" class="btn-warning btn">Cancel</a>
  </div>
  <div class="col-xs-1"><a id="deltaskbtn" class="btn-danger btn">Delete Scheduled Task</a>
  </div>
  <div class="col-xs-4">
  </div>
  <div class="col-xs-2 text-right"><a id="saveallbtn" class="btn-success btn">Save All Task Details</a>
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
   document.forms["taskfrm"].command.value = "save_general";
   document.taskfrm.submit();
});
$("#savepropertiesbtn").on('click', function() {
   document.forms["taskfrm"].command.value = "save_properties";
   document.taskfrm.submit();
});
$("#saveschedulebtn").on('click', function() {
   document.forms["taskfrm"].command.value = "save_schedule";
   document.taskfrm.submit();
});
$("#deltaskbtn").on('click', function() {
	$("#overlay").show();
	if (window.confirm("Are you sure?")) {
        document.forms["taskfrm"].command.value = "delete_task";
   		document.taskfrm.submit();
	}
	$("#overlay").hide();
});
$("#saveallbtn").on('click', function() {
   document.forms["taskfrm"].command.value = "save_all";
   document.taskfrm.submit();
});
$("#task_zone_id").on('change', function() {
   document.taskfrm.submit();
});
</script></body><?php
$rs->free();
$zlrs->free();
$conn->close();
?>
</html>