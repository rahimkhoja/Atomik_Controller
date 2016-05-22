<?php include 'script/database.php';?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="icon" type="image/png" href="img/favicon-32x32.png" sizes="32x32" />
<title>Atomik Controller - Device Details</title>
<link rel="stylesheet" href="css/atomik.css">
<script src="js/jquery-1.12.3.min.js"></script>
<script src="js/jquery.redirect.min.js"></script>
<?php 

function checkString($str)
{
	if (preg_match("/[^a-zA-Z0-9']/i", $string ))   
	{
	 	return 0;
	} else {
  		return 1;
	}
}

// Set Default Error & Success Settings
$page_error = 0;
$page_success = 0;
$success_text = "";
$error = "";

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
	$sql = "SELECT atomik_devices.device_id, atomik_devices.device_name, atomik_devices.device_description, atomik_devices.device_status, atomik_devices.device_type,  atomik_devices.device_colormode, atomik_devices.device_brightness, atomik_devices.device_rgb, atomik_devices.device_white_temprature, atomik_devices.device_address1, atomik_devices.device_address2, atomik_devices.device_transmission, atomik_device_types.device_type_name, atomik_device_types.device_type_brightness, atomik_device_types.device_type_rgb256, atomik_device_types.device_type_warm_white, atomik_device_types.device_type_cold_white FROM atomik_devices, atomik_device_types WHERE atomik_devices.device_type = atomik_device_types.device_type_id && atomik_devices.device_id = ".$_device_id.";";  

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
		$_device_colormode = "";
	}
}

if ( isset($_POST["device_brightness"])) {
	$_device_brightness = $_POST["device_brightness"];
} else {
	if ($_new_device == 0 ) {
		$_device_brightness = $row['device_brightness'];
	} else {
		$_device_brightness = "";
	}
}

if ( isset($_POST["device_rgb"])) {
	$_device_rgb = $_POST["device_rgb"];
} else {
	if ($_new_device == 0 ) {
		$_device_rgb = $row['device_rgb'];
	} else {
		$_device_rgb = "";
	}
}

if ( isset($_POST["device_white_temprature"])) {
	$_device_white_temprature = $_POST["device_white_temprature"];
} else {
	if ($_new_device == 0 ) {
		$_device_white_temprature = $row['device_white_temprature'];
	} else {
		$_device_white_temprature = "";
	}
}

if ( isset($_POST["device_address1"])) {
	$_device_address1 = $_POST["device_address1"];
} else {
	if ($_new_device == 0 ) {
		$_device_address1 = $row['device_address1'];
	} else {
		$_device_address1 = "";
	}
}

if ( isset($_POST["device_address2"])) {
	$_device_address2 = $_POST["device_address2"];
} else {
	if ($_new_device == 0 ) {
		$_device_address2 = $row['device_address2'];
	} else {
		$_device_address2 = "";
	}
}

if ( isset($_POST["device_transmission"])) {
	$_device_transmission = $_POST["device_transmission"];
} else {
	if ($_new_device == 0 ) {
		$_device_transmission = $row['device_transmission'];
	} else {
		$_device_transmission = "";
	}
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


// Save General Device Settings [Keep Post Data, Verify Form, DB] (save_general)
if ($command <> "" && $command !="" && $command == "save_general") 
{	
	$erro = array();
	if ($_new_device == 1 )
	{
		if ( checkString($_device_name) == 0 ) {
			array_push($erro, "Device Name Contains Illegal Characters. Please Only Use Letters, Numbers, Spaces, and Apostrophes.");
			$_error_device_name = 1;
		}
		
		if ( checkString($_device_description) == 0 ) {
			array_push($erro, "Device Description Contains Illegal Characters. Please Only Use Letters, Numbers, Spaces, and Apostrophes.");
			$_error_device_description = 1;
		}
		
	} else {
		if ( $_device_name == $row['device_name'] && $_device_description == $row['device_description'] )
		{
			array_push($erro, "No Changes To Save");
		} else {
			if ( checkString($_device_name) == 0 ) {
				array_push($erro, "Device Name Contains Illegal Characters. Please Only Use Letters, Numbers, Spaces, and Apostrophes.");
				$_error_device_name = 1;
			}
		
			if ( checkString($_device_description) == 0 ) {
				array_push($erro, "Device Description Contains Illegal Characters. Please Only Use Letters, Numbers, Spaces, and Apostrophes.");
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
			$sql = "INSERT INTO tbl (device_name, device_description) VALUES ('".$_device_name."','".$_device_description."')";
			if ($conn->query($sql) === TRUE) {
    			$page_success = 1;
				$success_text = "General Device Details Updated!";
				$_new_device = 0;
				$_device_id = $conn->insert_id;
			} else {
    			$page_error = 1;
				$error_text = "Error Saving General Device Details To DB!";
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


?>
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
    <tr>
        <td>
          <p>Device Name: </p>
        </td>
        <td><p><input type="text" class="form-control" id="device_name" name="device_name" value="<?php echo $_device_name; ?>"></p></td>
    </tr>  
  </thead>
    <tbody>
    <tr>
        <td><p>Device Description: </p></td>
        <td><p><textarea class="form-control" rows="4" cols="1" name="device_description" id="device_description"><?php echo $_device_description; ?></textarea></p></td>
        
      </tr>
      <tr>
        <td><p>Device Type: 
          <input type="hidden" name="new_device" id="new_device" value="<?php echo $_new_device; ?>"><input type="hidden" name="device_type" id="device_type" value="<?php echo $_device_type; ?>"><input type="hidden" name="device_id" id="device_id" value="<?php echo $_device_id; ?>">
        </p></td>
        <td><center><p><strong><?php echo $_device_type_name; ?></strong></p></center></td>
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
        <td><p><select id="device_color_mode" class="form-control">
  <option value="1"<?php if ($_device_color_mode == 1) { echo ' selected'; }?>>White Mode</option>
  <option value="0"<?php if ($_device_color_mode == 0) { echo ' selected'; }?>>Color Mode</option>
</select></p></td>
    </tr> <?php }; ?>
    <?php if ( $_device_type_rgb256 == 0 ) { ?><tr>
        <td>
          <p>Device Color Mode: </p>
        </td>
        <td><p><center><b>White Mode</b></center></p></td>
    </tr> <?php }; ?>
    <?php if ( $_device_type_brightness == 1 ) { ?><tr>
        <td>
          <p>Device Brightness (0-100): </p>
        </td>
        <td><p><input type="text" class="form-control" id="device_brightness" name="device_brightness" value="<?php echo $_device_brightness; ?>"></p></td>
    </tr> <?php }; ?>
    <?php if ( $_device_type_rgb256 == 1 ) { ?><tr>
        <td>
          <p>Device Color (0-255): </p>
        </td>
        <td><p><input type="text" class="form-control" id="device_color" name="device_color" value="<?php echo $_device_color; ?>"></p></td>
    </tr><?php }; ?>
    <?php if ( $_device_type_cold_white == 1 && $_device_type_warm_white == 1 ) { ?><tr>
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
  <div class="col-xs-4 text-center"><p><a href="" class="btn-success btn">Set Device Properties</a></p></div>
  
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
        <td><p><input type="text" class="form-control" id="device_address1" name="device_address1" value="<?php echo $_device_address1; ?>"></p></td>
    </tr>  
  </thead>
    <tbody>
    <tr>
        <td><p>Address Byte 2: </p></td>
        <td><p><input type="text" class="form-control" id="device_address2" name="device_address2" value="<?php echo $_device_address2; ?>"></p></td>
      </tr>
      <tr>
        <td><p>Sequence ID: </p></td>
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
  <div class="col-xs-2 text-center"><a href=""  class="btn-warning btn">Sync Device</a></div>
  <div class="col-xs-2 text-center"><a href=""  class="btn-warning btn">De-Sync Device</a></div>
  <div class="col-xs-4 text-center"><p><a href="" class="btn-success btn">Save MiLight Device Details</a></p></div>
  
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
  <div class="col-xs-1"><a href="devices.php"  class="btn-warning btn">Cancel</a>
  </div>
  <div class="col-xs-1"><a href="" class="btn-danger btn">Delete Device</a>
  </div>
  <div class="col-xs-4">
  </div>
  <div class="col-xs-2 text-right"><a href="" class="btn-success btn">Save All Details</a>
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
</script>
</body><?php
$rs->free();
$conn->close();
?>
</html>