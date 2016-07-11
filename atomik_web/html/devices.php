<?php
// Atomik Web Site - Devices List Page
// HTML/JQUERY/PHP/MySQL
// By Rahim Khoja

// Lists all the available devices, lets users click them to open device details. Page includes a add new device button.
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
<title>Atomik Controller - Devices</title>
<link rel="stylesheet" href="css/atomik.css">
<script src="js/jquery-1.12.3.min.js"></script>
<script src="js/jquery.redirect.min.js"></script>
<?php 
// Set Default Error & Success Settings
$page_error = 0;
$page_success = 0;
$success_text = "";
$error = "";

// Atomik Setting SQL
$sql = "SELECT atomik_devices.device_name, atomik_devices.device_id, atomik_devices.device_status, atomik_device_types.device_type_name FROM atomik_devices, atomik_device_types WHERE atomik_devices.device_type = atomik_device_types.device_type_id;";  

$rs=$conn->query($sql);
 
if($rs === false) {
  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
} else {
  $db_records = $rs->num_rows;
}
$rs->data_seek(0);
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
        <div class="PageNavTitle" ><h3>Devices</h3></div>
    </div>
   </div><?php if ( $page_success || $page_error ) { ?><hr><?php } ?><?php if ( $page_success ) { ?><div class="alert alert-success">
  <strong>Success!</strong> <?php echo $success_text; ?>
</div><?php } ?><?php if ( $page_error ) { ?><div class="alert alert-danger">
  <strong>Danger!</strong> <?php echo $error_text; ?>
</div><?php } ?><hr>
<div class="container center-block">
    <div class="col-xs-2"></div>
        <div class="col-xs-4">
           <h4><p>Device List:</p></h4></div><div class="col-xs-4 text-right"><p><strong>Total Devices: <?php echo $db_records; ?></strong></p><p><a href="add_device.php" class="btn-primary btn">Add New Device</a></p>  </div>
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
        <td><b><center>Status</center></b></td>
        <td></td>
      </tr>
    </thead>
    <tbody>
<?php if ( $db_records > 0 ) { while($row = $rs->fetch_assoc()){ ?>
    <tr id="dev<?php echo $row['device_id']; ?>">
        <td><center><p><?php echo $row['device_name']; ?></p></center></td>
        <td><center><p><?php echo $row['device_type_name']; ?></p></center></td>
        <td><center><p><?php if ($row['device_status'] == 1) { echo "ON"; } else { echo "OFF"; }; ?></p></center></td>
        <td onclick="event.cancelBubble=true;"><form id="delform<?php echo $row['device_id']; ?>" name="delform<?php echo $row['device_id']; ?>" action="devices.php" method="post"><input type="hidden" name="item" id="item" value="<?php echo $row['device_id']; ?>" ><center><p><a id="delete<?php echo $row['device_id']; ?>" class="btn-danger btn">Delete Device</a></p></center></form></td>
        <script type="text/javascript">
	$("#delete<?php echo $row['device_id']; ?>").on('click', function() {
   $("#overlay").show();
	if (window.confirm("Are You Sure You Want To Delete This Device?")) {
    	$().redirect('device_details.php', {'device_id': '<?php echo $row['device_id']; ?>', 'command': 'delete_device'});
	}
	$("#overlay").hide();
});
$("#dev<?php echo $row['device_id']; ?>").on('click', function() {
   $().redirect('device_details.php', {'device_id': '<?php echo $row['device_id']; ?>'});
});
</script>
      </tr><?php } } else { ?>
      <tr>
      <td colspan="4" class="text-center"><h3>No Devices</h3></td>
      </tr> <?php } ?>
    </tbody>
  </table>
        </div><div class="col-xs-2"></div>
</div><div class="container center-block">
    <div class="col-xs-2"></div>
        <div class="col-xs-4">
           </div><div class="col-xs-4 text-right"><p><strong>Total Devices: <?php echo $db_records; ?></strong></p><p><a href="add_device.php" class="btn-primary btn">Add New Device</a></p>  </div>
           <div class="col-xs-2"></div>
           </div><br>
  <?php if ( $page_success || $page_error ) { ?><hr><?php } ?><?php if ( $page_success ) { ?><div class="alert alert-success">
  <strong>Success!</strong> <?php echo $success_text; ?>
</div><?php } ?><?php if ( $page_error ) { ?><div class="alert alert-danger">
  <strong>Danger!</strong> <?php echo $error_text; ?>
</div><?php } ?><hr>
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
</script>
</body><?php
$rs->free();
$conn->close();
?>
</html>