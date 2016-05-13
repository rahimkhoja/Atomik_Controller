<?php include 'script/database.php';?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="icon" type="image/png" href="img/favicon-32x32.png" sizes="32x32" />
<title>Atomik Controller - Settings</title>
<link rel="stylesheet" href="css/atomik.css">
<script src="js/jquery-1.12.3.min.js"></script>
<script src="js/jquery.redirect.min.js"></script>
<?php
$tzone = 'UTC';
if (file_exists('/etc/timezone')) {
    // Ubuntu / Debian.
    $data = file_get_contents('/etc/timezone');
    if ($data) {
	$data = trim($data);
        $tzone = $data;
    }
} 
ini_set( 'date.timezone', $tzone );
date_default_timezone_set($tzone);

// Function
function isValidIP($ip)
{
	if(filter_var($ip, FILTER_VALIDATE_IP) !== false) {
		return true;
    } else {
		return false;
	}
}

function isValidMask($mask)
{
	 return ($result = log((ip2long($mask)^-1)+1,2)) != 0 && $result-(int)$result == 0;
}

function validateTimeSettings( $ntp1, $ntp2, $ntp3)
{
	$errors = array();
	if (!isValidIP($ntp1)) 
	{
		array_push($errors, "Invalid NTP Server 1 Address");
	}
	if (!isValidIP($ntp2)) 
	{
		array_push($errors, "Invalid NTP Server 2 Address");
	}
	if (!isValidIP($ntp3)) 
	{
		array_push($errors, "Invalid NTP Server 3 Address");
	}
	return $errors;
}

function validateSystemSettings($hn)
{
	$errors = array();
	if (preg_match('/^[a-z0-9.\-]+$/i', $hn)) {
		return $errors;
	} 
	array_push($errors, "Invalid Hostname");
	return $errors;
}

function validatePasswordUpdate($real, $cur, $p1, $p2)
{
	$errors = array();
	if ($real != $cur) {
		array_push($errors, "Invalid Current Password");
	} 
	if ($p1 != $p2) {
		array_push($errors, "New Passwords Do Not Match");
	} 
	return $errors;
}

function validateEth0Settings($stat, $ty, $eip, $emask, $egw, $edns)
{
	$errors = array();
	if ($stat == 0) {
		return $errors;
	} else {
		if($ty == 0) {
			return $errors;
		} else {
			if (!isValidIP($eip)) 
			{
				array_push($errors, "Invalid Eth0 IP Address");
			}
			if (!isValidIP($egw)) 
			{
				array_push($errors, "Invalid Eth0 Gateway Address");
			}
			if (!isValidIP($edns)) 
			{
				array_push($errors, "Invalid Eth0 DNS Address");
			}
			if (!isValidMask($emask)) 
			{
				array_push($errors, "Invalid Eth0 Subnet Mask");
			}
			
		}
	}
	return $errors;
}

function validateWlan0Settings($stat, $ty, $eip, $emask, $egw, $edns, $essid, $emethod, $ealgo, $epass)
{
	
	$errors = array();
	if ( $stat > 0 ) 
	{
		if ( $ty >0 ) 
		{
			if (!isValidIP($eip)) 
			{
				array_push($errors, "Invalid Wlan0 IP Address");
			}
			if (!isValidIP($egw)) 
			{
				array_push($errors, "Invalid Wlan0 Gateway Address");
			}
			if (!isValidIP($edns)) 
			{
				array_push($errors, "Invalid Wlan0 DNS Address");
			}
			if (!isValidMask($emask)) 
			{
				array_push($errors, "Invalid Wlan0 Subnet Mask");
			}
		}
		
		if ( strlen($essid) < 1 || $essid == "" ) 
		{
			array_push($errors, "Invalid SSID");
		}
		echo $emethod;
		if ( $emethod != 0 ) 
		{
			$message = "Emethod Not 0";
echo "<script type='text/javascript'>alert('$message');</script>";
			if ( $emethod <= 2 && $ealgo == 1 ) 
			{
				$message = "Emethod <= 2 0";
echo "<script type='text/javascript'>alert('$message');</script>";
$message = strlen($epass);
echo "<script type='text/javascript'>alert('$message');</script>";
				if ( ! ( strlen($epass) == 5 || strlen($epass) == 13 ) ) 
				{
					
					array_push($errors, "Invalid Wlan0 Password. Password Length Must Be 5 Or 13 Characters Long");
				}
			}
			
			if ( $emethod < 3 && $ealgo == 2 ) 
			{
				
				if ( ! ( strlen($epass) == 10 || strlen($epass) == 26 ) )
				{
					array_push($errors, "Invalid Wlan0 Password. Hex Password Length Must Be 10 Or 26 Characters Long");
				}
			
				if ( !( ctype_xdigit($epass) ) ) {
					array_push($errors, "Invalid Wlan0 Password. Password Is Not Hex");
				}
			}
			
			if ( $emethod == 3 || $emethod == 4 ) 
			{
				if ( strlen($epass) < 8 || strlen($epass) > 63 ) 
				{
					array_push($errors, "Invalid Wlan0 Password. Password Length Must Be 8 to 63 Characters Long");
				}
			}		
		}	 
	}
	return $errors;
}


// Set Default Error & Success Settings
$page_error = 0;
$page_success = 0;
$success_text = "";
$error = "";

// Set Command
$command = "";
$command = $_POST["command"];

// Atomik Setting SQL
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
// print_r($_POST);
 
if ( $_POST["hostname"] != $row['hostname'] && isset($_POST["hostname"])) {
	$_hostname = $_POST["hostname"];
} else {
	$_hostname = $row['hostname'];
}

if ( $command != "" && $command <> "") {
	if ( isset($_POST["atomik_api"]) ) {
		$_atomik_api = 1;
	} else {
		$_atomik_api = 0;
	}
} else {
	$_atomik_api = $row['atomik_api'];	
}

if ( $command != "" && $command <> "") {
	if ( isset($_POST["atomik_emulator"]) ) {
		$_atomik_emulator = 1;
	} else {
		$_atomik_emulator = 0;
	}
} else {
	$_atomik_emulator = $row['atomik_emulator'];
}

if ( $command != "" && $command <> "") {
	if ( isset($_POST["atomik_transceiver"]) ) {
		$_atomik_transceiver = 1;
	} else {
		$_atomik_transceiver = 0;
	}
} else {
	$_atomik_transceiver = $row['atomik_transceiver'];
}

// Password POST Data

if ( isset($_POST["current_password"]) ) {
	$_current_password = $_POST["current_password"];
} else {
	$_current_password = "";
}

if ( isset($_POST["new_password_1"]) ) {
	$_new_password_1 = $_POST["new_password_1"];
} else {
	$_new_password_1 = "";
}

if ( isset($_POST["new_password_2"]) ) {
	$_new_password_2 = $_POST["new_password_2"];
} else {
	$_new_password_2 = "";
}

$_real_password = $row['password'];
// Time POST Data

if ( $_POST["timezone"] != $row['timezone'] && isset($_POST["timezone"])) {
	$_timezone = $_POST["timezone"];
} else {
	$_timezone = $row['timezone'];
}

if ( $_POST["ntp_server_1"] != $row['ntp_server_1'] && isset($_POST["ntp_server_1"]) ) {
	$_ntp_server_1 = $_POST["ntp_server_1"];
} else {
	$_ntp_server_1 = $row['ntp_server_1'];
}

if ( $_POST["ntp_server_2"] != $row['ntp_server_2'] && isset($_POST["ntp_server_2"]) ) {
	$_ntp_server_2 = $_POST["ntp_server_2"];
} else {
	$_ntp_server_2 = $row['ntp_server_2'];
}

if ( $_POST["ntp_server_3"] != $row['ntp_server_3'] && isset($_POST["ntp_server_3"]) ) {
	$_ntp_server_3 = $_POST["ntp_server_3"];
} else {
	$_ntp_server_3 = $row['ntp_server_3'];
}

// Eth0 POST Data

if ( $_POST["eth0_status"] != $row['eth0_status'] && isset($_POST["eth0_status"]) ) {
	$_eth0_status = $_POST["eth0_status"];
} else {
	$_eth0_status = $row['eth0_status'];
}

if ( $_POST["eth0_type"] != $row['eth0_type'] && isset($_POST["eth0_type"]) ) {
	$_eth0_type = $_POST["eth0_type"];
} else {
	$_eth0_type = $row['eth0_type'];
}	

if ( $_POST["eth0_ip"] != $row['eth0_ip'] && isset($_POST["eth0_ip"]) ) {
	$_eth0_ip = $_POST["eth0_ip"];
} else {
	$_eth0_ip = $row['eth0_ip'];
}

if ( $_POST["eth0_mask"] != $row['eth0_mask'] && isset($_POST["eth0_mask"]) ) {
	$_eth0_mask = $_POST["eth0_mask"];
} else {
	$_eth0_mask = $row['eth0_mask'];
}

if ( $_POST["eth0_gateway"] != $row['eth0_gateway'] && isset($_POST["eth0_gateway"]) ) {
	$_eth0_gateway = $_POST["eth0_gateway"];
} else {
	$_eth0_gateway = $row['eth0_gateway'];
}

if ( $_POST["eth0_dns"] != $row['eth0_dns'] && isset($_POST["eth0_dns"]) ) {
	$_eth0_dns = $_POST["eth0_dns"];
} else {
	$_eth0_dns = $row['eth0_dns'];
}

// Wifi POST Data

$_wlan0_password = $_POST["wlan0_password"];

if ( $_POST["wlan0_ssid"] != $row['wlan0_ssid'] && isset($_POST["wlan0_ssid"]) ) {
	$_wlan0_ssid = $_POST["wlan0_ssid"];
} else {
	$_wlan0_ssid = $row['wlan0_ssid'];
}

if ( $_POST["wlan0_method"] != $row['wlan0_method'] && isset($_POST["wlan0_method"]) ) {
	$_wlan0_method = $_POST["wlan0_method"];
} else {
	$_wlan0_method = $row['wlan0_method'];
}	

if ( $_POST["wlan0_algorithm"] != $row['wlan0_algorithm'] && isset($_POST["wlan0_algorithm"]) ) {
	$_wlan0_algorithm = $_POST["wlan0_algorithm"];
} else {
	$_wlan0_algorithm = $row['wlan0_algorithm'];
}

if ( $_POST["wlan0_password"] != $row['wlan0_password'] && isset($_POST["wlan0_password"]) ) {
	$_wlan0_password = $_POST["wlan0_password"];
} else {
	$_wlan0_password = $row['wlan0_password'];
}

if ( $_POST["wlan0_status"] != $row['wlan0_status'] && isset($_POST["wlan0_status"]) ) {
	$_wlan0_status = $_POST["wlan0_status"];
} else {
	$_wlan0_status = $row['wlan0_status'];
}

if ( $_POST["wlan0_type"] != $row['wlan0_type'] && isset($_POST["wlan0_type"]) ) {
	$_wlan0_type = $_POST["wlan0_type"];
} else {
	$_wlan0_type = $row['wlan0_type'];
}	

if ( $_POST["wlan0_ip"] != $row['wlan0_ip'] && isset($_POST["wlan0_ip"]) ) {
	$_wlan0_ip = $_POST["wlan0_ip"];
} else {
	$_wlan0_ip = $row['wlan0_ip'];
}

if ( $_POST["wlan0_mask"] != $row['wlan0_mask'] && isset($_POST["wlan0_mask"]) ) {
	$_wlan0_mask = $_POST["wlan0_mask"];
} else {
	$_wlan0_mask = $row['wlan0_mask'];
}

if ( $_POST["wlan0_gateway"] != $row['wlan0_gateway'] && isset($_POST["wlan0_gateway"]) ) {
	$_wlan0_gateway = $_POST["wlan0_gateway"];
} else {
	$_wlan0_gateway = $row['wlan0_gateway'];
}

if ( $_POST["wlan0_dns"] != $row['wlan0_dns'] && isset($_POST["wlan0_dns"]) ) {
	$_wlan0_dns = $_POST["wlan0_dns"];
} else {
	$_wlan0_dns = $row['wlan0_dns'];
}

// Processing Command

// Reboot
if ($command <> "" && $command !="" && $command == "reboot") {
	$Handle = fopen("/tmp/atomikreboot", 'w');
	fwrite($Handle, "doreboot");
	fclose($Handle);
	header("location:reboot.php");
}


// Save System Settings [Keep Post Data, Verify Form, DB, Start Service, Stop Service, Edit File, Reboot] (save_system)
if ($command <> "" && $command !="" && $command == "save_system") 
{
	$erro = validateSystemSettings($_hostname);
	if (count($erro) > 0) 
	{
		$page_error = 1;
		$error_text = $erro[0].'.';
		
	} else {
		
		$sql = "UPDATE atomik_settings SET hostname='".$_hostname."', atomik_api='".$_atomik_api."', atomik_emulator='".$_atomik_emulator."', atomik_transceiver='".$_atomik_transceiver."';";
		if ($conn->query($sql) === TRUE) {
    		$page_success = 1;
			$success_text = "System Settings Updated!";
		} else {
    		$page_error = 1;
			$error_text = "Error Saving System Settings To DB!";
		}
		
		// Set Hostname Here
		
		
	}
}
// Save Password [Keep Post Data, Verify Form, DB] (save_password)
if ($command <> "" && $command !="" && $command == "save_password") 
{
	$erro = validatePasswordUpdate($_real_password, $_current_password, $_new_password_1, $_new_password_2);
	if (count($erro) > 0) 
	{
		$page_error = 1;
		$prefix = '';
		$len = count($erro);
		foreach ($erro as $er)
		{
    		$error_text .= $prefix . '"' . $er . '"';
    		$prefix = ', ';
			if ($i == $len - 2 && $len != 2) {
        		$prefix = ', and ';
    		} else if ($i == $len - 2 && $len == 2) {
				$prefix = ' and ';
			}
			$i++;
		}
		$error_text .= '.';
	} else {
		$sql = "UPDATE atomik_settings SET password='".$_new_password_1."';";
		if ($conn->query($sql) === TRUE) {
    		$page_success = 1;
			$success_text = "Password Settings Updated!";
		} else {
    		$page_error = 1;
			$error_text = "Error Saving Password To DB!";
		}
	}
		
}
// Save Time Zone [Keep Post Data, Verify Form, DB, Edit Cron, Edit File] (save_time)
if ($command <> "" && $command !="" && $command == "save_time") 
{
	$erro = validateTimeSettings($_ntp_server_1, $_ntp_server_2, $_ntp_server_3);
	$i = 0;
	if (count($erro) > 0) 
	{
		$page_error = 1;
		$prefix = '';
		$len = count($erro);
		foreach ($erro as $er)
		{
    		$error_text .= $prefix . '"' . $er . '"';
    		$prefix = ', ';
			if ($i == $len - 2 && $len != 2) {
        		$prefix = ', and ';
    		} else if ($i == $len - 2 && $len == 2) {
				$prefix = ' and ';
			}
			$i++;
		}
		$error_text .= '.';
		
	} else {
		
		$sql = "UPDATE atomik_settings SET timezone='".$_timezone."', ntp_server_1='".$_ntp_server_1."', ntp_server_2='".$_ntp_server_2."', ntp_server_3='".$_ntp_server_3."';";
		
		if ($conn->query($sql) === TRUE) {
    		$page_success = 1;
			$success_text = "Time Settings Updated!";
		} else {
    		$page_error = 1;
			$error_text = "Error Saving Time Settings To DB!";
		}
	$timecommand = "sudo -S /usr/bin/timedatectl set-timezone ".$_timezone." 2>&1";
	
	ini_set( 'date.timezone', trim($_timezone) );
	date_default_timezone_set( trim($_timezone) );
	}
	
}
// Save Eth0 Settings [Keep Post Data, Verify Form, DB, Edit Files, Restart Service] (save_eth0)

if ($command <> "" && $command !="" && $command == "save_eth0") // ($stat, $ty, $eip, $emask, $egw, $edns)
{
	$erro = validateEth0Settings($_eth0_status, $_eth0_type, $_eth0_ip, $_eth0_mask, $_eth0_gateway, $_eth0_dns);
	$i = 0;
	if (count($erro) > 0) 
	{
		$page_error = 1;
		$prefix = '';
		$len = count($erro);
		foreach ($erro as $er)
		{
    		$error_text .= $prefix . '"' . $er . '"';
    		$prefix = ', ';
			if ($i == $len - 2 && $len != 2) {
        		$prefix = ', and ';
    		} else if ($i == $len - 2 && $len == 2) {
				$prefix = ' and ';
			}
			$i++;
		}
		$error_text .= '.';
		
	} else {
		
		$sql = "UPDATE atomik_settings SET eth0_type='".$_eth0_type."', eth0_status='".$_eth0_status."', eth0_ip='".$_eth0_ip."', eth0_mask='".$_eth0_mask."', eth0_gateway='".$_eth0_gateway."', eth0_dns='".$_eth0_dns."';";
		
		if ($conn->query($sql) === TRUE) {
    		$page_success = 1;
			$success_text = "Eth0 Adaptor Information Saved!";
		} else {
    		$page_error = 1;
			$error_text = "Error Saving Eth0 Adpator Information To DB!";
		}
	
	}
	
}


// Save Wifi Settings [Keep Post Data, Verify Form, DB, Edit Files, Restart Service] (save_wlan0)

if ($command <> "" && $command !="" && $command == "save_wlan0") // ($stat, $ty, $eip, $emask, $egw, $edns, $essid, $emethod, $ealgo, $epass)
{
$message = "Before Function ( Wlan0_method = " . $_wlan0_method. ")";
echo "<script type='text/javascript'>alert('$message');</script>";
	$erro = validateWlan0Settings($_wlan0_status, $_wlan0_type, $_wlan0_ip, $_wlan0_mask, $_wlan0_gateway, $_wlan0_dns, $_wlan0_ssid, $_wlan0_method, $_wlan0_algorithm, $_wlan0_password);
	$i = 0;
	if (count($erro) > 0) 
	{
		$page_error = 1;
		$prefix = '';
		$len = count($erro);
		foreach ($erro as $er)
		{
    		$error_text .= $prefix . '"' . $er . '"';
    		$prefix = ', ';
			if ($i == $len - 2 && $len != 2) {
        		$prefix = ', and ';
    		} else if ($i == $len - 2 && $len == 2) {
				$prefix = ' and ';
			}
			$i++;
		}
		$error_text .= '.';
		
	} else {
		
		$sql = "UPDATE atomik_settings SET wlan0_type='".$_wlan0_type."', wlan0_status='".$_wlan0_status."', wlan0_ip='".$_wlan0_ip."', wlan0_mask='".$_wlan0_mask."', wlan0_gateway='".$_wlan0_gateway."', wlan0_dns='".$_wlan0_dns."', wlan0_method='".$_wlan0_method."', wlan0_algorithm='".$_wlan0_algorithm."', wlan0_password='".$_wlan0_password."';";
		
		if ($conn->query($sql) === TRUE) {
    		$page_success = 1;
			$success_text = "Wlan0 Adaptor Information Saved!";
		} else {
    		$page_error = 1;
			$error_text = "Error Saving Wlan0 Adpator Information To DB!";
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
  <strong>Success!</strong> <?php echo $success_text; ?>
</div><?php } ?><?php if ( $page_error ) { ?><div class="alert alert-danger">
  <strong>Danger!</strong> <?php echo $error_text; ?>
</div><?php } ?><hr>
<form id="settingsfrm" name="settingsfrm"  enctype="multipart/form-data" action="settings.php" method="post"><input type="hidden" name="command" id="command" value="" >
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
                     <td><input type="text" class="form-control" id="hostname" name="hostname" value="<?php echo $_hostname; ?>"></td>
                   </tr>
                 </thead>
                 <tbody>
                   <tr>
                     <td>Atomik API Service: </td>
                     <td><input type="checkbox" class="form-control" id="atomik_api" name="atomik_api" value="1" <?php if ($_atomik_api == "1" ) { ?>checked <?php }; ?>></td>
                   </tr>
                   <tr>
                     <td>Mi-Light Emulator Service: </td>
                     <td><input type="checkbox" id="atomik_emulator" name="atomik_emulator" class="form-control" value="1" <?php if ($_atomik_emulator == "1" ) { ?>checked  <?php }; ?>></td>
                   </tr>
                   <tr>
                     <td>Mi-Light Transceiver Service: </td>
                     <td><input type="checkbox" id="atomik_transceiver" name="atomik_transceiver" class="form-control" value="1" <?php if ($_atomik_transceiver == "1" ) { ?>checked  <?php }; ?>></td>
                   </tr>
                 </tbody>
               </table></td>
             </tr>
           </thead>
          </table>
          <hr>
  <div class="container center col-xs-12">
  <div class="col-xs-6 text-center"></div>
  <div class="col-xs-6 text-center"><p><a id="savesystem" href="#" class="btn-success btn">Save System Settings</a></p></div>
  </div>
  <br><br>
  <hr><h4><p>Update Password:</p></h4>   
  <table class="table table-striped">
    <thead>
      <tr>
        <td>Current Password: </td>
        <td><input type="password" class="form-control" id="current_password" name="current_password" value=""></td>
      </tr>
      </thead>
    <tbody>
    <tr>
        <td>New Password: </td>
        <td><input type="password" class="form-control" id="new_password_1" name="new_password_1" value=""></td>
      </tr>
      <tr>
        <td>Repeat Password: </td>
        <td><input type="password" class="form-control" id="new_password_2" name="new_password_2" value=""></td>
      </tr>
    </tbody>
  </table><hr>
  <div class="container center col-xs-12">
  <div class="col-xs-6 text-center"></div>
  <div class="col-xs-6 text-center"><p><a id="savepassword" href="#" class="btn-success btn">Save Password</a></p></div>
  </div>
  <br><br>
  <hr>
            <h4><p>Time Settings:</p></h4>   
  <table class="table table-striped">
    <thead>
      <tr>
        <td>Current System Time: </td>
        <td><?php echo date("l, M jS Y, g:i:s A ( T )",time() ); ?></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Time Zone: </td>
        <td><select  class="form-control" id="timezone" name="timezone">
        <?php 
		$timezonelistcmd = shell_exec("timedatectl list-timezones | awk {'print $1'}");  
		foreach(preg_split("/((\r?\n)|(\r\n?))/", $timezonelistcmd) as $line) 
		{
			$selected = "";
			
			if ($line == $_timezone) 
			{
				$selected = "selected";
			}
			
			if ($line != "" && $line <>"") 
			{
				echo '<option value="'.$line.'" '.$selected.'>'.$line.'</option>'."\r\n";
			}
		}?></select></td>
      </tr>
      <tr>
        <td>NTP Time Server 1: </td>
        <td><input type="text" class="form-control" id="ntp_server_1" name="ntp_server_1" value="<?php echo $_ntp_server_1; ?>"></td>
      </tr>
      <tr>
        <td>NTP Time Server 2: </td>
        <td><input type="text" class="form-control" id="ntp_server_2" name="ntp_server_2" value="<?php echo $_ntp_server_2; ?>"></td>
      </tr>
      <tr>
        <td>NTP Time Server 3: </td>
        <td><input type="text" class="form-control" id="ntp_server_3" name="ntp_server_3" value="<?php echo $_ntp_server_3; ?>"></td>
      </tr>
    </tbody>
  </table>
  <hr>
  <div class="container center col-xs-12">
  <div class="col-xs-6 text-center"></div>
  <div class="col-xs-6 text-center"><p><a id="savetime" href="#" class="btn-success btn">Save Time Settings</a></p></div>
  </div>
  <br><br><hr>
        </div>
        <div class="col-xs-6">
            <h4><p>Ethernet Adapter Settings:</p></h4>   
  <table class="table table-striped">
    <thead>
      <tr>
        <td>Eth0 Status: </td>
        <td><select id="eth0_status" name="eth0_status" class="form-control">
  <option value="1" <?php if ($_eth0_status == 1 ) { ?>selected <?php }; ?>>Enable</option>
  <option value="0" <?php if ($_eth0_status == 0 ) { ?>selected <?php }; ?>>Disable</option>
</select></td>
      </tr>
    </thead>
    <tbody>
    <tr>
        <td>Eth0 Type: </td>
        <td><select id="eth0_type" name="eth0_type" class="form-control"<?php if ($_eth0_status == 0) { ?> disabled<?php }; ?>>
  <?php if ($_eth0_status > 0 ) { ?><option value="1" <?php if ($_eth0_type == 1 ) { ?>selected <?php }; ?>>Static</option>
  <option value="0" <?php if ($_eth0_type == 0 ) { ?>selected <?php }; ?>>DHCP</option><?php }; ?>
</select></td>
      </tr>
      <tr>
        <td>Eth0 IP Address: </td>
        <td><input type="text" class="form-control" id="eth0_ip" name="eth0_ip" <?php if ($_eth0_status > 0 && $_eth0_type > 0 ) { ?>value="<?php echo $_eth0_ip; ?>"<?php }; ?><?php if ($_eth0_status == 0 || $_eth0_type == 0) { ?> disabled<?php }; ?>></td>
      </tr>
      <tr>
        <td>Eth0 Subnet Mask: </td>
        <td><input type="text" class="form-control" id="eth0_mask" name="eth0_mask" <?php if ($_eth0_status > 0 && $_eth0_type > 0 ) { ?>value="<?php echo $_eth0_mask; ?>"<?php }; ?><?php if ($_eth0_status == 0 || $_eth0_type == 0) { ?> disabled<?php }; ?>></td>
      </tr>
      <tr>
        <td>Eth0 Gateway: </td>
        <td><input type="text" class="form-control" id="eth0_gateway" name="eth0_gateway" <?php if ($_eth0_status > 0 && $_eth0_type > 0 ) { ?>value="<?php echo $_eth0_gateway; ?>"<?php }; ?><?php if ($_eth0_status == 0 || $_eth0_type == 0) { ?> disabled<?php }; ?>></td>
      </tr>
      <tr>
        <td>Eth0 DNS: </td>
        <td><input type="text" class="form-control" id="eth0_dns" name="eth0_dns" <?php if ($_eth0_status > 0 && $_eth0_type > 0 ) { ?>value="<?php echo $_eth0_dns; ?>"<?php }; ?><?php if ($_eth0_status == 0 || $_eth0_type == 0) { ?> disabled<?php }; ?>></td>
      </tr>
    </tbody>
  </table>
  <hr>
  <div class="container center col-xs-12">
    <div class="container center col-xs-12">
      <div class="col-xs-6 text-center"></div>
      <div class="col-xs-6 text-center">
        <p><a id="saveeth0" href="#" class="btn-success btn">Save Ethernet Settings</a></p>
      </div>
    </div>
  </div>
  <br><br><hr>
<h4><p>Wifi Adapter Settings:</p></h4>   
  <table class="table table-striped">
    <thead>
      <tr >
        <td>Wifi0 Status: </td>
        <td><select id="wlan0_status" name="wlan0_status" class="form-control">
  <option value="0" <?php if ($_wlan0_status == 0 ) { ?>selected <?php }; ?>>Disable</option>
  <option value="1" <?php if ($_wlan0_status == 1 ) { ?>selected <?php }; ?>>Enable</option>
</select></td>
      </tr>
    </thead>
    <tbody>
    <tr>
        <td>Wifi0 SSID: </td>
        <td><select id="wlan0_ssid" name="wlan0_ssid" class="form-control"<?php if ($_wlan0_status == 0) { ?> disabled<?php }; ?>><?php if ($_wlan0_status > 0) { ?>
   <?php 
		$ssidcmd = shell_exec("sudo iwlist wlan0 scan | grep SSID: | cut -d: -f2 | tr '\"' ' ' | awk {'print $1'}");  
		foreach(preg_split("/((\r?\n)|(\r\n?))/", $ssidcmd) as $line) 
		{
			$selected = "";
			
			if ($line == $_wlan0_ssid) 
			{
				$selected = "selected";
			}
			
			if ($line != "" && $line <>"") 
			{
				echo '<option value="'.$line.'" '.$selected.'>'.$line.'</option>'."\r\n";
			}
		}?>
<?php }; ?></select></td>
      </tr>
      <tr>
        <td>Wifi0 Method: </td>
        <td><select id="wlan0_method" name="wlan0_method" class="form-control">
  <?php if ($_wlan0_status > 0) { ?><option value="0" <?php if ($_wlan0_method == 0 ) { ?>selected <?php }; ?><?php if ($_wlan0_status == 0) { ?> disabled<?php }; ?>>Disable</option>
  <option value="1" <?php if ($_wlan0_method == 1 ) { ?>selected <?php }; ?>>OPENWEP</option>
  <option value="2" <?php if ($_wlan0_method == 2 ) { ?>selected <?php }; ?>>SHAREDWEP</option>
  <option value="3" <?php if ($_wlan0_method == 3 ) { ?>selected <?php }; ?>>WPAPSK</option>
  <option value="4" <?php if ($_wlan0_method == 4 ) { ?>selected <?php }; ?>>WPA2PSK</option><?php }; ?>
</select></td>
      </tr>
      <tr>
        <td>Wifi0 Encryption Algorithm: </td>
        <td><select id="wlan0_algorithm" name="wlan0_algorithm" class="form-control"<?php if ($_wlan0_status == 0 || $_wlan0_method == 0) { ?> disabled<?php }; ?>><?php if ($_wlan0_status > 0 && $_wlan0_method > 0 ) { ?>
  <?php if ( $_wlan0_algorithm == 2 || $_wlan0_algorithm == 3) { ?><option value="3"<?php if ($_wlan0_algorithm == 3) { echo ' selected'; } ?>>AES</option><?php }; ?> // only visible wpa and wpa2 methods
  <?php if ( $_wlan0_algorithm == 2 || $_wlan0_algorithm == 3) { ?><option value="2"<?php if ($_wlan0_algorithm == 2) { echo ' selected'; } ?>>TKIP</option><?php }; ?>// only visible wpa and wpa2 methods
<?php if ( $_wlan0_algorithm == 0 || $_wlan0_algorithm == 1 ) { ?><option value="0"<?php if ($_wlan0_algorithm == 0) { echo ' selected'; } ?>>ASCII</option><?php }; ?> // only visible OPENWEP and SHAREDWEP methods 	
<?php if ( $_wlan0_algorithm == 0 || $_wlan0_algorithm == 1 ) { ?><option value="1"<?php if ($_wlan0_algorithm == 1) { echo ' selected'; } ?>>HEX</option><?php }; ?> // only visible OPENWEP and SHAREDWEP methods 		
<?php }; ?></select></td>
      </tr>
      <tr>
        <td>Wifi0 Password: </td>
        <td><input type="password" class="form-control" id="wlan0_password" name="wlan0_password" <?php if ($_wlan0_status > 0 && $_wlan0_method > 0 ) { ?>value="<?php echo $_wlan0_password; ?>"<?php }; ?><?php if ($_wlan0_status == 0 || $_wlan0_method == 0) { ?> disabled<?php }; ?>></td>
      </tr>
      <tr>
        <td>Wifi0 Type: </td>
        <td><select  class="form-control" id="wlan0_type" name="wlan0_type"<?php if ($_wlan0_status == 0) { ?> disabled<?php }; ?>><?php if ($_wlan0_status > 0) { ?>
  <option value="1" <?php if ($_wlan0_type == 1 ) { ?>selected <?php }; ?>>Static</option>
  <option value="0" <?php if ($_wlan0_type == 0 ) { ?>selected <?php }; ?>>DHCP</option>
<?php }; ?></select></td>
      </tr>
      <tr>
        <td>Wifi0 IP Address: </td>
        <td><input type="text" class="form-control" id="wlan0_ip" name="wlan0_ip" <?php if ($_wlan0_status > 0 && $_wlan0_type > 0 ) { ?>value="<?php echo $_wlan0_ip; ?>"<?php }; ?><?php if ($_wlan0_status == 0 || $_wlan0_type == 0) { ?> disabled<?php }; ?>></td>
      </tr>
      <tr>
        <td>Wifi0 Subnet Mask: </td>
        <td><input type="text" class="form-control" id="wlan0_mask" name="wlan0_mask" <?php if ($_wlan0_status > 0 && $_wlan0_type > 0 ) { ?>value="<?php echo $_wlan0_mask; ?>"<?php }; ?><?php if ($_wlan0_status == 0 || $_wlan0_type == 0) { ?> disabled<?php }; ?>></td>
      </tr>
      <tr>
        <td>Wifi0 Gateway: </td>
        <td><input type="text" class="form-control" id="wlan0_gateway" name="wlan0_gateway" <?php if ($_wlan0_status > 0 && $_wlan0_type > 0 ) { ?>value="<?php echo $_wlan0_gateway; ?>"<?php }; ?><?php if ($_wlan0_status == 0 || $_wlan0_type == 0) { ?> disabled<?php }; ?>></td>
      </tr>
      <tr>
        <td>Wifi0 DNS: </td>
        <td><input type="text" class="form-control" id="wlan0_dns" name="wlan0_dns" <?php if ($_wlan0_status > 0 && $_wlan0_type > 0 ) { ?>value="<?php echo $_wlan0_dns; ?>"<?php }; ?><?php if ($_wlan0_status == 0 || $_wlan0_type == 0) { ?> disabled<?php }; ?>></td>
      </tr>
      </tbody>
  </table><hr>
  <div class="container center col-xs-12">
  <div class="col-xs-2 text-center"><p><a id="refreshssid" href="#" class="btn-primary btn">Refresh SSID List</a></p></div>  
  <div class="col-xs-6 text-center"></div>
  <div class="col-xs-4 text-center"><p><a id="savewlan0" href="#" class="btn-success btn">Save Wireless Settings</a></p></div>
  </div>
  <br><br><hr> 
    </div>
</div>
</div></form><?php if ( $page_success || $page_error ) { ?><hr><?php } ?><?php if ( $page_success ) { ?><div class="alert alert-success">
  <strong>Success!</strong> <?php echo $success_text; ?>
</div><?php } ?><?php if ( $page_error ) { ?><div class="alert alert-danger">
  <strong>Danger!</strong> <?php echo $error_text; ?>
</div><?php } ?><hr>
  <div class="container center">
  <div class="col-xs-2">
  </div>
  <div class="col-xs-2"><p><a href="settings.php" class="btn-warning btn">Cancel</a></p>
  </div>
  <div class="col-xs-2"><p></p>
  </div>
  <div class="col-xs-2">
  </div>
  <div class="col-xs-2"><p><a href="#" id="reboot" class="btn-danger btn">Reboot System</a></p>
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
	$("#reboot").on('click', function() {
   document.forms["settingsfrm"].command.value = "reboot";
   document.settingsfrm.submit();
});
$("#savewlan0").on('click', function() {
   document.forms["settingsfrm"].command.value = "save_wlan0";
   document.settingsfrm.submit();
});
$("#saveeth0").on('click', function() {
   document.forms["settingsfrm"].command.value = "save_eth0";
   document.settingsfrm.submit();
});
$("#savewlan0").on('click', function() {
   document.forms["settingsfrm"].command.value = "save_wlan0";
   document.settingsfrm.submit();
});
$("#savetime").on('click', function() {
   document.forms["settingsfrm"].command.value = "save_time";
   document.settingsfrm.submit();
});
$("#savepassword").on('click', function() {
   document.forms["settingsfrm"].command.value = "save_password";
   document.settingsfrm.submit();
});
$("#savesystem").on('click', function() {
   document.forms["settingsfrm"].command.value = "save_system";
   document.settingsfrm.submit();
});

$("#refreshssid").on('click', function() {
   document.forms["settingsfrm"].command.value = "";
   document.settingsfrm.submit();
});

$('#eth0_status').on('change', function() {
  if (this.value == 0) {
	  $( "#eth0_type" ).prop( "disabled", true );
	  $( "#eth0_type" ).children().remove();
	  $( "#eth0_ip" ).prop( "disabled", true );
	  $( "#eth0_ip" ).val('');
	  $( "#eth0_gateway" ).prop( "disabled", true );
	  $( "#eth0_gateway" ).val('');
	  $( "#eth0_dns" ).prop( "disabled", true );
	  $( "#eth0_dns" ).val('');
	  $( "#eth0_mask" ).prop( "disabled", true );
	  $( "#eth0_mask" ).val('');
  } else {
	  $( "#eth0_type" ).prop( "disabled", false );
	  $( "#eth0_type" ).append('<option value="1" selected>Static</option>');
	  $( "#eth0_type" ).append('<option value="0" >DHCP</option>');
	  $( "#eth0_ip" ).prop( "disabled", false );
	  $( "#eth0_gateway" ).prop( "disabled", false );
	  $( "#eth0_dns" ).prop( "disabled", false );
	  $( "#eth0_mask" ).prop( "disabled", false );
  }
});

$('#eth0_type').on('change', function() {
  if (this.value == 0) {
	  $( "#eth0_ip" ).prop( "disabled", true );
	  $( "#eth0_ip" ).val('');
	  $( "#eth0_gateway" ).prop( "disabled", true );
	  $( "#eth0_gateway" ).val('');
	  $( "#eth0_dns" ).prop( "disabled", true );
	  $( "#eth0_dns" ).val('');
	  $( "#eth0_mask" ).prop( "disabled", true );
	  $( "#eth0_mask" ).val('');
  } else {
	  $( "#eth0_ip" ).prop( "disabled", false );
	  $( "#eth0_gateway" ).prop( "disabled", false );
	  $( "#eth0_dns" ).prop( "disabled", false );
	  $( "#eth0_mask" ).prop( "disabled", false );
  }
});

$('#wlan0_status').on('change', function() {
  if (this.value == 0) {
	   
	  $( "#wlan0_ssid" ).prop( "disabled", true );
	  $( "#wlan0_ssid" ).children().remove();
	   
	  $( "#wlan0_algorithm" ).prop( "disabled", true );
	  $( "#wlan0_algorithm" ).children().remove();
	  
	  $( "#wlan0_method" ).prop( "disabled", true );
	  $( "#wlan0_method" ).children().remove();
	  
	  $( "#wlan0_password" ).prop( "disabled", true );
	  $( "#wlan0_password" ).val('');
	  
	  $( "#wlan0_type" ).prop( "disabled", true );
	  $( "#wlan0_type" ).children().remove();
	  $( "#wlan0_ip" ).prop( "disabled", true );
	  $( "#wlan0_ip" ).val('');
	  $( "#wlan0_gateway" ).prop( "disabled", true );
	  $( "#wlan0_gateway" ).val('');
	  $( "#wlan0_dns" ).prop( "disabled", true );
	  $( "#wlan0_dns" ).val('');
	  $( "#wlan0_mask" ).prop( "disabled", true );
	  $( "#wlan0_mask" ).val('');
  } else {
	  $( "#wlan0_ssid" ).prop( "disabled", false );
	  
	  $( "#wlan0_method" ).prop( "disabled", false );
	  $( "#wlan0_method" ).append('<option value="0" selected>Disable</option>');
	  $( "#wlan0_method" ).append('<option value="1" >OPENWEP</option>');
	  $( "#wlan0_method" ).append('<option value="2" >SHAREDWEP</option>');
	  $( "#wlan0_method" ).append('<option value="3" >WPAPSK</option>');
	  $( "#wlan0_method" ).append('<option value="4" >WPA2PSK</option>');
	  	  
	  $( "#wlan0_type" ).prop( "disabled", false );
	  $( "#wlan0_type" ).append('<option value="1">Static</option>');
	  $( "#wlan0_type" ).append('<option value="0" selected>DHCP</option>');
	  $( "#wlan0_ip" ).prop( "disabled", false );
	  $( "#wlan0_gateway" ).prop( "disabled", false );
	  $( "#wlan0_dns" ).prop( "disabled", false );
	  $( "#wlan0_mask" ).prop( "disabled", false );
	  
	  document.settingsfrm.submit();
  }
});
    
$('#wlan0_type').on('change', function() {
  if (this.value == 0) {
	  $( "#wlan0_ip" ).prop( "disabled", true );
	  $( "#wlan0_ip" ).val('');
	  $( "#wlan0_gateway" ).prop( "disabled", true );
	  $( "#wlan0_gateway" ).val('');
	  $( "#wlan0_dns" ).prop( "disabled", true );
	  $( "#wlan0_dns" ).val('');
	  $( "#wlan0_mask" ).prop( "disabled", true );
	  $( "#wlan0_mask" ).val('');
  } else {
	  $( "#wlan0_ip" ).prop( "disabled", false );
	  $( "#wlan0_gateway" ).prop( "disabled", false );
	  $( "#wlan0_dns" ).prop( "disabled", false );
	  $( "#wlan0_mask" ).prop( "disabled", false );
  }
});

$('#wlan0_method').on('change', function() {
  if (this.value == 0) {
	  $( "#wlan0_algorithm" ).prop( "disabled", true );
	  $( "#wlan0_algorithm" ).children().remove();
	  $( "#wlan0_password" ).prop( "disabled", true );
	  $( "#wlan0_password" ).val('');
  } else if (this.value == 1 || this.value ==2) {
	  $( "#wlan0_algorithm" ).children().remove();
	  $( "#wlan0_algorithm" ).append('<option value="0" selected>ASCII</option>');
	  $( "#wlan0_algorithm" ).append('<option value="1">HEX</option>');
	  $( "#wlan0_algorithm" ).prop( "disabled", false );
	  $( "#wlan0_password" ).prop( "disabled", false );
  } else if (this.value == 3 || this.value ==4) {
	  $( "#wlan0_algorithm" ).children().remove();
	  $( "#wlan0_algorithm" ).append('<option value="2" selected>TKIP</option>');
	  $( "#wlan0_algorithm" ).append('<option value="3">AES</option>');
	  $( "#wlan0_algorithm" ).prop( "disabled", false );
	  $( "#wlan0_password" ).prop( "disabled", false );
  }
});
</script>
</body>
</html>
