<?php include 'script/database.php';?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="icon" type="image/png" href="img/favicon-32x32.png" sizes="32x32" />
<title>Atomik Controller - Zone Details</title>
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

// Set Default Error & Success Settings
$page_error = 0;
$page_success = 0;
$success_text = "";
$error = "";

// Set Command
$command = "";
$command = $_POST["command"];

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

if ( $_new_zone == 0 ) {
// Atomik Setting SQL
	$sql = "SELECT atomik_zones.zone_id, atomik_zones.zone_name, atomik_zones.zone_description, atomik_zones.zone_status, atomik_zones.zone_colormode, atomik_zones.zone_brightness, atomik_zones.zone_rgb, atomik_zones.zone_white_temprature WHERE atomik_zones.zone_id = ".$_zone_id.";";  

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
}

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

if ( isset($_POST["zone_rgb"])) {
	$_zone_rgb = $_POST["zone_rgb"];
} else {
	if ($_new_zone == 0 ) {
		$_zone_rgb = $row['zone_rgb'];
	} else {
		$_zone_rgb = 0;
	}
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

// saveatomikbtn,
// Save General Remote Settings [Keep Post Data, Verify Form, DB] (save_general)
if ($command <> "" && $command !="" && $command == "save_general") 
{	
	$erro = array();
	if ($_new_remote == 1 )
	{
		if (!preg_match("/^[a-zA-Z0-9. -]+$/", $_remote_name)) {
			array_push($erro, "Remote Name Contains Illegal Characters, Please Only Use Letters, Numbers, Spaces, Periods, and Dashes");
			$_error_remote_name = 1;
		}
		
		if ( !( ( !empty($_remote_description) && preg_match("/^[a-zA-Z0-9. -]+$/", $_remote_description) ) || empty($_remote_description) ) ) {
			array_push($erro, "Remote Description Contains Illegal Characters, Please Only Use Letters, Numbers, Spaces, Periods, and Dashes");
			$_error_remote_description = 1;
		}
		
	} else {
		if ( $_remote_name == $row['remote_name'] && $_remote_description == $row['remote_description'] )
		{
			array_push($erro, "No Changes To Save");
		} else {
			if (!preg_match("/^[a-zA-Z0-9. -]+$/", $_remote_name)) {
				array_push($erro, "Remote Name Contains Illegal Characters, Please Only Use Letters, Numbers, Spaces, Periods, and Dashes");
				$_error_remote_name = 1;
			}
		
			if ( !( ( !empty($_remote_description) && preg_match("/^[a-zA-Z0-9. -]+$/", $_remote_description) ) || empty($_remote_description) ) ) {
				array_push($erro, "Remote Description  Contains Illegal Characters, Please Only Use Letters, Numbers, Spaces, Periods, and Dashes");
				$_error_remote_description = 1;
			}
		}
	}
	
	if (count($erro) > 0) 
	{
		$page_error = 1;
		$error_text = processErrors($erro);	
	} else {
		$_channels = 0;
		
		if ( $_remote_type == 1 || $_remote_type == 2 ) {
			$_channels = 5;
		}

		if ( $_new_remote == 1 ) {
			$sql = "INSERT INTO atomik_remotes (remote_name, remote_description, remote_type) VALUES ('".$_remote_name."','".$_remote_description."',".$_remote_type.")";
			if ($conn->query($sql) === TRUE) {
    			
				$_new_remote = 0;
				$_remote_id = $conn->insert_id;
				
								
				if ($_channels > 0 ) {
					$sql = "INSERT INTO atomik_remote_channels (remote_channel_remote_id, remote_channel_number, remote_channel_name) VALUES (".$_remote_id.",0,'Master Channel'), (".$_remote_id.",1,'Channel 1'), (".$_remote_id.",2,'Channel 2'), (".$_remote_id.",3,'Channel 3'), (".$_remote_id.",4,'Channel 4')";
					if ($conn->query($sql) === TRUE) {
    					$page_success = 1;
						$success_text = "General Remote Details Updated!";
					} else {
    					$page_error = 1;
						$error_text = "Error Inserting General Remote Channels To DB!";
					}
				}
				
			} else {
    			$page_error = 1;
				$error_text = "Error Inserting Remote Details To DB!";
			}
		} else {
			$sql = "UPDATE atomik_remotes SET remote_name='".$_remote_name."', remote_description='".$_remote_description."' WHERE remote_id=".$_remote_id.";";
			if ($conn->query($sql) === TRUE) {
    			$page_success = 1;
				$success_text = "General Remote Details Updated!";
			} else {
    			$page_error = 1;
				$error_text = "Error Saving General Remote Details To DB!";
			}
		}
	}		
}

// Add Device to Zone (add_device)
if ($command <> "" && $command !="" && $command == "save_smartphone") 
{	
	$erro = array();
	if ($_new_remote == 1 )
	{
		array_push($erro, "Please Save General Remote Details Before Saving Remote Properties");	
	} else {
		if ( $_remote_mac == $row['remote_mac'] &&  $_remote_mac != "") {
			array_push($erro, "No Changes To Save");
		} else {
			if (!is_valid_mac ( $_remote_mac )) {
				array_push($erro, "Remote MAC Address Is Invalid (Example Valid Input 48-2C-6A-1E-59-3D)");
				$_error_remote_mac = 1;
			} else {
				$_remote_mac = normalize_mac($_remote_mac);
			}
		}	
	}
	
	if (count($erro) > 0) 
	{
		$page_error = 1;
		$error_text = processErrors($erro);	
	} else {
		$sql = "UPDATE atomik_remotes SET remote_mac = '".trim($_remote_mac)."' WHERE remote_id=".$_remote_id.";";
		if ($conn->query($sql) === TRUE) {
    		$page_success = 1;
			$success_text = "Remote Mac Address Updated!";
		} else {
    		$page_error = 1;
			$error_text = "Error Saving Remote Mac Address To DB!";
		}
	}		
}

// Add Remote to Zone (add_device)
if ($command <> "" && $command !="" && $command == "listen_milight") 
{	
	$erro = array();
	if ($_new_remote == 1 )
	{
		array_push($erro, "Please Save General Remote Details Before Lisening For A Remote");	
	} 
	
	if (count($erro) > 0) 
	{
		$page_error = 1;
		$error_text = processErrors($erro);	
	} else {
		
		// wait for 10 seconds while the Atomik Server Listens for Remote RF signals
		
		// Check db with something like this
		
		// select * FROM updateside where add_date >= now() - interval 10 second  
		
		// set address to the most common unknown transmission address during the 10 second interval
		
	}		
}


// Delete Zone (delete_zone)
if ($command <> "" && $command !="" && $command == "delete_remote") 
{	
	if ($_new_remote == 1 )
	{
		header('Location: remotes.php');
	} else {
		$sql="DELETE FROM atomik_remotes WHERE remote_id=".trim($_remote_id).";";
 
		if($conn->query($sql) === false) {
			$page_error = 1;
			$error_text = "Error Deleting Remote From Remote DB!";
		} else {
		
			$sql="DELETE FROM atomik_remote_channels WHERE remote_channel_remote_id=".trim($_remote_id).";";
 
			if($conn->query($sql) === false) {
				$page_error = 1;
				$error_text = "Error Deleting Remote From Remote Channel DB!";
			}  else {
				$sql="DELETE FROM atomik_zone_remotes WHERE zone_remote_remote_id=".trim($_remote_id).";";
 
				if($conn->query($sql) === false) {
					$page_error = 1;
					$error_text = "Error Deleting Remote From Zone DB!";
				} else {
		  			$page_success = 1;
					$success_text = "Remote Deleted!";
					header('Location: remotes.php');		
				}	
			}
		}
	}
}
?></head>
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
        <li><a href="zones.php">Zones<span class="sr-only">(current)</span></a> </li>
        <li class="active"><a href="tasks.php">Scheduled Tasks</a> </li>
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
        <div class="PageNavTitle" >
          <h3>Zone Details</h3>
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
            <h4><p>General Zone Details:</p></h4>   
  <table class="table table-striped">
  <thead>
    <tr>
        <td>
          <p>Zone Name: </p>
        </td>
        <td><p><input type="text" class="form-control" id="zone_name" name="zone_name" value="<?php echo $_zone_name; ?>"></p></td>
    </tr>  
  </thead>
    <tbody>
    <tr>
        <td><p>Zone Description: </p></td>
        <td><p><textarea class="form-control" id="zone_description" name="zone_description" rows="4" cols="1"><?php echo $_zone_name; ?></textarea></p></td>
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
    <?php if ( $_zone_type_brightness == 1 ) { ?><tr>
        <td>
          <p>Zone Brightness (0-100): </p>
        </td>
        <td><p><input type="text" class="form-control" id="zone_brightness" name="zone_brightness" value="<?php echo $_zone_brightness; ?>"></p></td>
    </tr> <?php }; ?>
    <?php if ( $_zone_type_rgb256 == 1 ) { ?><tr>
        <td>
          <p>Zone Color (0-255): </p>
        </td>
        <td><p><input type="text" class="form-control" id="zone_rgb" name="zone_rgb" value="<?php echo $_zone_rgb; ?>"></p></td>
    </tr><?php }; ?>
    <?php if ( $_zone_type_cold_white == 1 && $_zone_type_warm_white == 1 ) { ?><tr>
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
  <div class="col-xs-4 text-center"><p><a href="" class="btn-success btn">Set Zone Properties</a></p></div>
  
  <div class="col-xs-2"></div>
  </div>
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
    <tbody>
      <tr>
        <td><center><p>Kitchen Light 1</p></center></td>
        <td><center><p>MiLight White</p></center></td>
        <td><center><p><a href="" class="btn-danger btn">Remove Device</a></p></center></td>
      </tr>
      <tr>
        <td><center><p>Kitchen Light 2</p></center></td>
        <td><center><p>MiLight White</p></center></td>
        <td><center><p><a href="" class="btn-danger btn">Remove Device</a></p></center></td>
      </tr>
      <tr>
        <td><center><p>Kitchen Light 3</p></center></td>
        <td><center><p>MiLight White</p></center></td>
        <td><center><p><a href="" class="btn-danger btn">Remove Device</a></p></center></td>
      </tr>
    </tbody>
  </table>
        
        </div><div class="col-xs-2"></div>
</div><div class="container center-block">
    <div class="col-xs-2"></div>
        <div class="col-xs-4">
           </div><div class="col-xs-4 text-right"><p><strong>Total Zone Devices: 3</strong></p><p><a href="" class="btn-primary btn">Add Zone Device</a></p>  </div>
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
    <tbody>
      <tr>
        <td><center><p>Frank's Remote - MiLight Zone 1</p></center></td>
        <td><center><p>MiLight Smartphone Remote</p></center></td>
        <td><center><p><a href="" class="btn-danger btn">Remove Remote</a></p></center></td>
      </tr>
      <tr>
        <td><center><p>Chantel's Remote - MiLight Zone 3</p></center></td>
        <td><center><p>MiLight Smartphone Remote</p></center></td>
        <td><center><p><a href="" class="btn-danger btn">Remove Remote</a></p></center></td>
      </tr>
      <tr>
        <td><center><p>Tablet</p></center></td>
        <td><center><p>Atomik API Remote</p></center></td>
        <td><center><p><a href="" class="btn-danger btn">Remove Remote</a></p></center></td>
      </tr>
      <tr>
        <td><center><p>Backup Remote - MiLight Zone 4</p></center></td>
        <td><center><p>MiLight RGBW RF Remote</p></center></td>
        <td><center><p><a href="" class="btn-danger btn">Remove Remote</a></p></center></td>
      </tr>
    </tbody>
  </table>
        
        </div><div class="col-xs-2"></div>
</div><div class="container center-block">
    <div class="col-xs-2"></div>
        <div class="col-xs-4">
           </div><div class="col-xs-4 text-right"><p><strong>Total Zone Remotes: 4</strong></p><p><a href="" class="btn-primary btn">Add Zone Remote</a></p>  </div>
           <div class="col-xs-2"></div>
           </div><?php if ( $page_success || $page_error ) { ?><hr><?php } ?><?php if ( $page_success ) { ?><div class="alert alert-success">
  <strong>Success!</strong> <?php echo $success_text; ?>
</div><?php } ?><?php if ( $page_error ) { ?><div class="alert alert-danger">
  <strong>Danger!</strong> <?php echo $error_text; ?>
</div><?php } ?><hr>
  <div class="container center">
  <div class="col-xs-2">
  </div>
  <div class="col-xs-1"><a href="zones.php"  class="btn-warning btn">Cancel</a>
  </div>
  <div class="col-xs-1"><a href="" class="btn-danger btn">Delete Zone</a>
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
    </div>
</body>
</html>
