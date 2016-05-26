<?php include 'script/database.php';?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="icon" type="image/png" href="img/favicon-32x32.png" sizes="32x32" />
<title>Atomik Controller - Remote Details</title>
<link rel="stylesheet" href="css/atomik.css">
<script src="js/jquery-1.12.3.min.js"></script>
<script src="js/jquery.redirect.min.js"></script>
<?php 

function is_valid_mac($mac)
{
  // 01:23:45:67:89:ab
  if (preg_match('/^([a-fA-F0-9]{2}:){5}[a-fA-F0-9]{2}$/', $mac))
    return true;
  // 01-23-45-67-89-ab
  if (preg_match('/^([a-fA-F0-9]{2}\-){5}[a-fA-F0-9]{2}$/', $mac))
    return true;
  // 0123456789ab
  else if (preg_match('/^[a-fA-F0-9]{12}$/', $mac))
    return true;
  // 0123.4567.89ab
  else if (preg_match('/^([a-fA-F0-9]{4}\.){2}[a-fA-F0-9]{4}$/', $mac))
    return true;
  else
    return false;
}

function normalize_mac($mac)
{
  // remove any dots
  $mac =  str_replace(".", "", $mac);

  // replace dashes with colons
  $mac =  str_replace("-", ":", $mac);

  // counting colons
  $colon_count = substr_count ($mac , ":");

  // insert enough colons if none exist
  if ($colon_count == 0)
  {
    $mac =  substr_replace($mac, ":", 2, 0);
    $mac =  substr_replace($mac, ":", 5, 0);
    $mac =  substr_replace($mac, ":", 8, 0);
    $mac =  substr_replace($mac, ":", 11, 0);
    $mac =  substr_replace($mac, ":", 14, 0);
  }

  // uppercase
  $mac = strtoupper($mac);

  // DE:AD:BE:EF:10:24
  return $mac;
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

if ( isset($_POST["new_remote"]) ) {
	$_new_remote = $_POST["new_remote"];
} else {
	$_new_remote = "0";
}

if ( isset($_POST["remote_id"]) ) {
	$_remote_id = $_POST["remote_id"];
} else {
	$_remote_id = "";
}

if ( isset($_POST["remote_type"]) ) {
	$_remote_type = $_POST["remote_type"];
} else {
	$_remote_type = "";
}

if ( $_new_remote == 0 ) {
// Atomik Setting SQL
	$sql = "SELECT atomik_remotes.remote_id, atomik_remotes.remote_name, atomik_remotes.remote_description, atomik_remotes.remote_type, atomik_remotes.remote_address1, atomik_remotes.remote_address2, atomik_remotes.remote_user, atomik_remotes.remote_mac, atomik_remote_types.remote_type_name, atomik_remote_types.remote_type_atomik, atomik_remote_types.remote_type_milight_smartphone, atomik_remote_types.remote_type_milight_radio, atomik_remote_types.remote_type_channels FROM atomik_remotes, atomik_remote_types WHERE atomik_remotes.remote_type = atomik_remote_types.remote_type_id && atomik_remotes.remote_id = ".$_remote_id.";";  

} else { 
	$sql = "SELECT atomik_remote_types.remote_type_name, atomik_remote_types.remote_type_atomik, atomik_remote_types.remote_type_milight_smartphone, atomik_remote_types.remote_type_milight_radio, atomik_remote_types.remote_type_channels FROM atomik_remote_types WHERE atomik_remote_types.remote_type_id = ".$_remote_type.";";
}
$rs=$conn->query($sql);
 
if($rs === false) {
  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
} else {
  $db_records = $rs->num_rows;
}

$rs->data_seek(0);
$row = $rs->fetch_assoc();

if ( isset($_POST["remote_name"])) {
	$_remote_name = $_POST["remote_name"];
} else {
	if ($_new_remote == 0 ) {
		$_remote_name = $row['remote_name'];
	} else {
		$_remote_name = "";
	}
}

if ( isset($_POST["remote_description"])) {
	$_remote_description = $_POST["remote_description"];
} else {
	if ($_new_remote == 0 ) {
		$_remote_description = $row['remote_description'];
	} else {
		$_remote_description = "";
	}
}

if ( isset($_POST["remote_address1"])) {
	$_remote_address1 = $_POST["remote_address1"];
} else {
	if ($_new_remote == 0 ) {
		$_remote_address1 = $row['remote_address1'];
	} else {
		$_remote_address1 = "";
	}
}

if ( isset($_POST["remote_address2"])) {
	$_remote_address2 = $_POST["remote_address2"];
} else {
	if ($_new_remote == 0 ) {
		$_remote_address2 = $row['remote_address2'];
	} else {
		$_remote_address2 = "";
	}
}

if ( isset($_POST["remote_type"])) {
	$_remote_type = $_POST["remote_type"];
} else {
	if ($_new_remote == 0 ) {
		$_remote_type = $row['remote_type'];
	} else {
		$_remote_type = "";
	}
}

$_remote_user = "";
$_current_remote_user = "";
$_current_remote_password = "";
$_remote_password_1 = "";
$_remote_password_2 = "";

if ($_new_remote == 0 ) {
	$_current_remote_user = $row['remote_user'];
	$_current_remote_password = $row['remote_password'];
}

if ( isset($_POST["remote_user"])) {
	$_remote_user = $_POST["remote_user"];
} else {
	if ($_new_remote == 0 ) {
		$_remote_user = $row['remote_user'];
	} 
}

if ( isset($_POST["remote_password_1"])) {
	$_remote_password_1 = $_POST["remote_password_1"];
} 

if ( isset($_POST["remote_password_2"])) {
	$_remote_password_2 = $_POST["remote_password_2"];
}

if ( isset($_POST["remote_mac"])) {
	$_remote_mac = $_POST["remote_mac"];
} else {
	if ($_new_remote == 0 ) {
		$_remote_mac = $row['remote_mac'];
	} else {
		$_remote_mac = "";
	}
}

$_remote_type_name = $row['remote_type_name'];


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
		
		if ( $_remote_type == 1 || $_remote_type == 1 ) {
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

// Save all Remote Settings [Keep Post Data, Verify Form, DB] (save_aa)
if ($command <> "" && $command !="" && $command == "save_all") 
{	
	$erro = array();
	if ($_new_remote == 1 )
	{
		if (!preg_match("/^[a-zA-Z0-9. -]+$/", $_device_name)) {
			array_push($erro, "Remote Name Contains Illegal Characters, Please Only Use Letters, Numbers, Spaces, Periods, and Dashes");
			$_error_device_name = 1;
		}		
		
		if ( !( ( !empty($_device_description) && preg_match("/^[a-zA-Z0-9. -]+$/", $_device_description) ) || empty($_device_description) ) ) {
			array_push($erro, "Remote Description Contains Illegal Characters, Please Only Use Letters, Numbers, Spaces, Periods, and Dashes");
			$_error_device_description = 1;
		}
		
		if ( $_device_type_brightness == 1 ) {
			if (!Check0to100 ( $_device_brightness )) {
				array_push($erro, "Remote Brightness Must Be A Number Between 0 and 100");
				$_error_device_brightness = 1;
			}
		}
			
		if ( $_device_type_rgb256 == 1 && $_device_colormode == 0) {
			if (!Check0to255 ( $_device_rgb)) {
				array_push($erro, "Remote Color Must Be A Number Between 0 and 255");
				$_error_device_rgb = 1;
			}
		}
			
		if ( $_device_type_cold_white == 1 && $_device_type_warm_white == 1 && $_device_colormode == 1 ) {
			if (!Check2700to6500 ( $_device_white_temprature )) {
				array_push($erro, "Remote White Temprature Must Be A Number Between 2700 and 6500");
				$_error_device_white_temprature = 1;
			}
		}			
	} else {		
		if ( $_device_name == $row['device_name'] && $_device_description == $row['device_description'] && $_device_status == $row['device_status'] && $_device_colormode == $row['device_colormode'] && $_device_brightness == $row['device_brightness'] && $_device_rgb == $row['device_rgb'] && $_device_white_temprature == $row['device_white_temprature'] ) {
			array_push($erro, "No Changes To Save");
		} else {

			if (!preg_match("/^[a-zA-Z0-9. -]+$/", $_device_name)) {
				array_push($erro, "Remote Name Contains Illegal Characters, Please Only Use Letters, Numbers, Spaces, Periods, and Dashes");
				$_error_device_name = 1;
			}
		
		if ( !( ( !empty($_device_description) && preg_match("/^[a-zA-Z0-9. -]+$/", $_device_description) ) || empty($_device_description) ) ) {
				array_push($erro, "Remote Description Contains Illegal Characters, Please Only Use Letters, Numbers, Spaces, Periods, and Dashes");
				$_error_device_description = 1;
			}
		
			if ( $_device_type_brightness == 1 ) {
				if (!Check0to100 ( $_device_brightness )) {
					array_push($erro, "Remote Brightness Must Be A Number Between 0 and 100");
					$_error_device_brightness = 1;
				}
			}
			
			if ( $_device_type_rgb256 == 1 && $_device_colormode == 0) {
				if (!Check0to255 ( $_device_rgb)) {
					array_push($erro, "Remote Color Must Be A Number Between 0 and 255");
					$_error_device_rgb = 1;
				}
			}
			
			if ( $_device_type_cold_white == 1 && $_device_type_warm_white == 1 && $_device_colormode == 1 ) {
				if (!Check2700to6500 ( $_device_white_temprature )) {
					array_push($erro, "Remote White Temprature Must Be A Number Between 2700 and 6500");
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
			$sql = "INSERT INTO atomik_devices (device_name, device_description, device_type, device_status, device_colormode, device_brightness, device_rgb, device_white_temprature ) VALUES ('".$_device_name."','".$_device_description."',".trim($_device_type).",".trim($_device_status).",".trim($_device_colormode).",".trim($_device_brightness).",".trim($_device_rgb).",".trim($_device_white_temprature).")";		
			if ($conn->query($sql) === TRUE) {
    			$page_success = 1;
				$success_text = "All Remote Details Updated!";
				$_new_device = 0;
				$_device_id = $conn->insert_id;
			} else {
    			$page_error = 1;
				$error_text = "Error Saving All New Remote Details To DB!";
			}
		} else {
			$sql = "UPDATE atomik_devices SET device_name='".$_device_name."', device_description='".$_device_description."', device_status = ".trim($_device_status).", device_colormode = ".trim($_device_colormode).", device_brightness = ".trim($_device_brightness).", device_rgb = ".trim($_device_rgb).", device_white_temprature = ".trim($_device_white_temprature)." WHERE device_id=".$_device_id.";";
			if ($conn->query($sql) === TRUE) {
    			$page_success = 1;
				$success_text = "All Remote Details Updated!";
			} else {
    			$page_error = 1;
				$error_text = "Error Saving All Remote Details To DB!";
			}
		}
	}		
}

// Save Password [Keep Post Data, Verify Form, DB] (save_atomik)
if ($command <> "" && $command !="" && $command == "save_atomik") 
{	
	$erro = array();
	if ($_current_remote_password == $_remote_password_1 && $_current_remote_password == $_remote_password_2 && $_current_remote_user == $_remote_user ) {
		array_push($erro, "No Changes To Save");
	} else {
		if (strlen($_remote_user) < 5) {
			array_push($erro, "Remote Username Must Be At Least 5 Characters Long");
			$_error_remote_user = 1;
		} 		
		
		if (!preg_match("/^[a-zA-Z0-9. -]+$/", $_remote_user)) {
			array_push($erro, "Remote Username Contains Illegal Characters, Please Only Use Letters, Numbers, Spaces, Periods, and Dashes");
			$_error_remote_user = 1;
		}	 
		if ($_remote_password_1 != $_remote_password_2) {
			array_push($erro, "New Passwords Do Not Match");
			$_error_remote_password_2 = 1;
			$_error_remote_password_1 = 1;
		}
	}
	
	if (count($erro) > 0) 
	{
		$page_error = 1;
		$error_text = processErrors($erro);	
	} else {
		$sql = "UPDATE atomik_remotes SET remote_password='".trim($_remote_password_1)."';";
		if ($conn->query($sql) === TRUE) {
    		$page_success = 1;
			$success_text = "Password Settings Updated!";
		} else {
    		$page_error = 1;
			$error_text = "Error Saving Password To DB!";
		}
	}
		
}


// Save Smartphone Remote Settings [Keep Post Data, Verify Form, DB] (save_smartphone)
if ($command <> "" && $command !="" && $command == "save_smartphone") 
{	
	$erro = array();
	if ($_new_device == 1 )
	{
		array_push($erro, "Please Save General Remote Details Before Saving Remote Properties");	
	} else {
		if ( $_remote_mac == $row['remote_mac'] ) {
			array_push($erro, "No Changes To Save");
		} else {
			if ( $_device_type_brightness == 1 ) {
				if (!is_valid_mac ( $_remote_mac )) {
					array_push($erro, "Remote MAC Address Is Invalid (Example Valid Input 48-2C-6A-1E-59-3D)");
					$_error_remote_mac = 1;
				} else {
					$_remote_mac = normalize_mac($_remote_mac);
				}
			}
		}	
	}
	
	if (count($erro) > 0) 
	{
		$page_error = 1;
		$error_text = processErrors($erro);	
	} else {
		$sql = "UPDATE atomik_remotess SET remote_mac = '".trim($_remote_mac)."' WHERE remote_id=".$_remote_id.";";
		if ($conn->query($sql) === TRUE) {
    		$page_success = 1;
			$success_text = "Remote Mac Address Updated!";
		} else {
    		$page_error = 1;
			$error_text = "Error Saving Remote Mac Address To DB!";
		}
	}		
}

// Listen for Mi-Light RGB RF Remote (listen_milight)
if ($command <> "" && $command !="" && $command == "listen_milight") 
{	
	$erro = array();
	if ($_new_device == 1 )
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


// Delete Remote (delete_remote)
if ($command <> "" && $command !="" && $command == "delete_remote") 
{	
	if ($_new_device == 1 )
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
        <li><a href="dashboard.php">Dashboard<span class="sr-only">(current)</span></a> </li>
        <li><a href="settings.php">Settings</a> </li>
        <li><a href="devices.php">Devices</a> </li>
        <li class="active"><a href="remotes.php">Remotes</a> </li>
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
        <div class="PageNavTitle" >
          <h3>Remote Details</h3>
        </div>
    </div>
   </div><?php if ( $page_success || $page_error ) { ?><hr><?php } ?><?php if ( $page_success ) { ?><div class="alert alert-success">
  <strong>Success!</strong> <?php echo $success_text; ?>
</div><?php } ?><?php if ( $page_error ) { ?><div class="alert alert-danger">
  <strong>Danger!</strong> <?php echo $error_text; ?>
</div><?php } ?><hr>
  <br><form id="remotefrm" name="remotefrm" enctype="multipart/form-data" action="remote_details.php" method="post"><input type="hidden" name="command" id="command" value="" >
  <div class="container">
        <div class="col-xs-2"></div>
        <div class="col-xs-8">
            <h4><p>General Remote Details:</p></h4>   
  <table class="table table-striped">
  <thead>
    <tr>
        <td>
          <p>Remote Name: </p>
        </td>
        <td><p><input name="remote_name" type="text" class="form-control" id="remote_name" value="<?php echo $_remote_name; ?>"></p></td>
    </tr>  
  </thead>
    <tbody>
    <tr>
        <td><p>Remote Description: </p></td>
        <td><p><textarea name="remote_description" cols="1" rows="4" class="form-control" id="remote_description"><?php echo $_remote_description; ?></textarea></p></td>
        
      </tr>
      <tr>
        <td><p>Remote Type: </p></td>
        <td><center>
          <p><b><?php echo $_remote_type_name; ?></b></p>
        </center></td>
      </tr>
      </tbody>
  </table><input type="hidden" name="new_remote" id="new_remote" value="<?php echo $_new_remote; ?>"><input type="hidden" name="remote_type" id="remote_type" value="<?php echo $_remote_type; ?>"><input type="hidden" name="remote_id" id="remote_id" value="<?php echo $_remote_id; ?>">
</div>
<div class="col-xs-2"></div></div><div class="container">
<div class="col-xs-2"></div>
  <div class="col-xs-8 text-center"><hr></div>
  <div class="col-xs-2"></div>
</div>
<div class="container">
<div class="col-xs-2"></div>
  <div class="col-xs-4 text-center"></div>
  <div class="col-xs-4 text-center"><p><a id="savegeneralbtn" class="btn-success btn">Save General Remote Details</a></p></div>
  
  <div class="col-xs-2"></div>
  </div>
  <br><?php if ($_remote_type == 3) { ?>
  <div class="container">
        <div class="col-xs-2"></div>
        <div class="col-xs-8"><hr>
            <h4><p>Atomik Remote Details:</p></h4>   
  <table class="table table-striped">
  <thead>
    <tr>
        <td>
          <p>Username: </p>
        </td>
        <td><p><input name="remote_user" type="text" class="form-control" id="remote_user" value="<?php echo $_remote_user; ?>"></p></td>
    </tr>  
  </thead>
    <tbody>
    <tr>
        <td><p>Password: </p></td>
        <td><p><input type="password" class="form-control" id="remote_password_1" name="remote_password_1" value="<?php echo $_remote_password_1; ?>"></p></td>
      </tr>
      <tr>
        <td><p>Repeat Password: </p></td>
        <td><p><input type="password" class="form-control" id="remote_password_2" name="remote_password_2" value="<?php echo $_remote_password_2; ?>"></p></td>
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
  <div class="col-xs-4 text-center"></div>
  <div class="col-xs-4 text-center"><p><a id="saveatomikbtn" class="btn-success btn">Save Atomik Remote Details</a></p></div>
  
  <div class="col-xs-2"></div>
  </div>
<br><?php }; 
if ($_remote_type == 2) {  ?>
  <div class="container">
        <div class="col-xs-2"></div>
        <div class="col-xs-8"><hr>
            <h4><p>MiLight RF Remote Details:</p></h4>   
  <table class="table table-striped">
  <thead>
    <tr>
        <td >
          <p>Address Byte 1: </p>
        </td>
        <td width="350"><p><?php echo $_remote_address1; ?></p></td>
    </tr>  
  </thead>
    <tbody>
    <tr>
        <td><p>Address Byte 2: </p></td>
        <td><p><?php echo $_remote_address2; ?></p></td>
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
  <div class="col-xs-4 text-center"></div>
  <div class="col-xs-4 text-center"><p><a id="listenmilightbtn"  class="btn-warning btn">Listen for Remote</a></p></div>
  
  <div class="col-xs-2"></div>
  </div>
<br><?php }; 
if ($_remote_type == 1) {  ?>
  <div class="container">
        <div class="col-xs-2"></div>
        <div class="col-xs-8"><hr>
            <h4><p>MiLight Smartphone Remote Details:</p></h4>   
  <table class="table table-striped">
  <thead>
    <tr>
        <td>
          <p>MAC Address: </p>
        </td>
        <td><p><input type="text" class="form-control" id="remote_mac" name="remote_mac" value="<?php echo $_remote_mac; ?>"></p></td>
    </tr>  
  </thead>
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
  <div class="col-xs-4 text-center"><p><a id="savemobilebtn" class="btn-success btn">Save MiLight Smartphone Details</a></p></div>
  <div class="col-xs-2"></div>
  </div></form>
<?php }; ?>
  <?php if ( $page_success || $page_error ) { ?><hr><?php } ?><?php if ( $page_success ) { ?><div class="alert alert-success">
  <strong>Success!</strong> <?php echo $success_text; ?>
</div><?php } ?><?php if ( $page_error ) { ?><div class="alert alert-danger">
  <strong>Danger!</strong> <?php echo $error_text; ?>
</div><?php } ?><hr>
  <div class="container center">
  <div class="col-xs-2">
  </div>
  <div class="col-xs-1"><a href="remotes.php"  class="btn-warning btn">Cancel</a>
  </div>
  <div class="col-xs-1"><a id="delrembtn" class="btn-danger btn">Delete Remote</a>
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
   document.forms["remotefrm"].command.value = "save_general";//
   document.remotefrm.submit();
});
$("#delrembtn").on('click', function() {
   document.forms["remotefrm"].command.value = "delete_remote";//
   document.remotefrm.submit();
});
$("#saveatomikbtn").on('click', function() {
   document.forms["remotefrm"].command.value = "save_atomik";
   document.remotefrm.submit();
});
$("#listenmilightbtn").on('click', function() {
   document.forms["remotefrm"].command.value = "listen_milight";//
   document.remotefrm.submit();
});
$("#savemobilebtn").on('click', function() {
   document.forms["remotefrm"].command.value = "save_smartphone";
   document.remotefrm.submit();
});
$("#saveallbtn").on('click', function() {
   document.forms["remotefrm"].command.value = "save_all";
   document.remotefrm.submit();
});
</script>
</body><?php
$rs->free();
$conn->close();
?>
</html>