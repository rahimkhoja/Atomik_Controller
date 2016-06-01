<?php include 'script/database.php';?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="icon" type="image/png" href="img/favicon-32x32.png" sizes="32x32" />
<title>Atomik Controller - Add Device to Zone</title>
<link rel="stylesheet" href="css/atomik.css">
<script src="js/jquery-1.12.3.min.js"></script>
<script src="js/jquery.redirect.min.js"></script>
<?php 
// Set Default Error & Success Settings
$page_error = 0;
$page_success = 0;
$success_text = "";
$error = "";

// Set Command
$command = "";
$command = $_POST["command"];

if ( isset($_POST["zone_id"]) ) {
	$_zone_id = $_POST["zone_id"];
} else {
	$_zone_id = "";
}

if ( isset($_POST["zone_device"]) ) {
	$_zone_device = $_POST["zone_device"];
} else {
	$_zone_device = "";
}

if ( isset($_POST["update_zone"]) ) {
	$_update_zone = $_POST["update_zone"];
} else {
	$_update_zone = 1;
}

// Add Device to Zone (add_device)
if ($command <> "" && $command !="" && $command == "add_device") 
{	
	$erro = array();
	$sql = "INSERT INTO atomik_zone_devices (zone_device_zone_id, zone_device_device_id, zone_device_last_update) VALUES (".trim($_zone_id).",".trim($_zone_device).",now() );";
	
	if ($conn->query($sql) === TRUE) {
    	if ($_update_zone > 0 ) {
		//	Run Command To Update Device
		//  $updatecmd = shell_exec("echo 'hello world' > /dev/null &");	
		}
		$page_success = 1;
		$success_text = "Zone Device Added To Zone DB!";
		echo "<BR>";
		echo '<script type="text/javascript">'."$().redirect('zone_details.php', {'zone_id': ".trim($_zone_id)."});</script>";	
	} else {
    	$page_error = 1;
		$error_text = "Error Adding Device To Zone DB!";
	}	
}

// Atomik Setting SQL
$sql = "SELECT atomik_devices.device_name, atomik_devices.device_id FROM atomik_devices WHERE device_id NOT IN (SELECT zone_device_device_id FROM atomik_zone_devices);";  

$rs=$conn->query($sql);
 
if($rs === false) {
  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
} else {
  $db_records = $rs->num_rows;
}
$rs->data_seek(0);

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
