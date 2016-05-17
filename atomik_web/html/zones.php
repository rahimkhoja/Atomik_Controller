<?php include 'script/database.php';?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Atomik Controller - Zones</title>
<link rel="stylesheet" href="css/atomik.css">
<script src="js/jquery-1.12.3.min.js"></script>
<script src="js/jquery.redirect.min.js"></script>
</head><?php 
// Set Default Error & Success Settings
$page_error = 0;
$page_success = 0;
$success_text = "";
$error = "";

// Check for delete

if ( isset($_POST["item"]) ) {
	$_item = $_POST["item"];

	$sql="DELETE FROM atomik_zones WHERE zonee_id=".$_item;
 
	if($conn->query($sql) === false) {
		$page_error = 1;
		$error_text = "Error Deleting Device From DB!";
	} else {
  		$page_success = 1;
		$success_text = "Zone Deleted!";
	}
}
		
// Atomik Setting SQL
$sql = "SELECT atomik_devices.device_name, atomik_devices.device_id, atomik_devices.device_status, atomik_device_types.device_type_name FROM atomik_devices, atomik_device_types WHERE atomik_devices.device_type = atomik_device_types.device_type_id;";  

$rs=$conn->query($sql);
 
if($rs === false) {
  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
} else {
  $db_records = $rs->num_rows;
}
$rs->data_seek(0);
?>
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
        <div class="PageNavTitle" ><h3>Zones</h3></div>
    </div>
   </div><<?php if ( $page_success || $page_error ) { ?><hr><?php } ?><?php if ( $page_success ) { ?><div class="alert alert-success">
  <strong>Success!</strong> <?php echo $success_text; ?>
</div><?php } ?><?php if ( $page_error ) { ?><div class="alert alert-danger">
  <strong>Danger!</strong> <?php echo $error_text; ?>
</div><?php } ?><hr>
<div class="container center-block">
    <div class="col-xs-2"></div>
        <div class="col-xs-4">
           <h4><p>Zones List:</p></h4></div><div class="col-xs-4 text-right"><p><strong>Total Zones: <?php echo $db_records; ?></strong></p><p><a href="zone_details.php" class="btn-primary btn">Add New Zone</a></p>  </div>
           <div class="col-xs-2"></div>
           </div><br>
           <div class="container center-block">
    <div class="col-xs-2"></div>
        <div class="col-xs-8">
  <table class="table table-striped">
    <thead>
      <tr>
        <td><b><center>Name</center></b></td>
        <td><b><center>Status</center></b></td>
        <td><b><center># of Remotes</center></b></td>
        <td><b><center># of Devices</center></b></td>
        <td></td>
      </tr>
    </thead>
    <tbody>
    <tr>
        <td valign="bottom"><center><p>Bedroom 1 Lights</p></center></td>
        <td><center><p>OFF</p></center></td>
        <td><center><p>1</p></center></td>        
        <td><center><p>2</p></center></td>
        <td><center><p><a href="" class="btn-danger btn">Delete Zone</a></p></center></td>
      </tr>
      <tr>
        <td><center><p>Bedroom 1 Lamp</p></center></td>
        <td><center><p>OFF</p></center></td>
        <td><center><p>1</p></center></td>        
        <td><center><p>1</p></center></td>
        <td><center><p><a href="" class="btn-danger btn">Delete Zone</a></p></center></td>
      </tr>
      <tr>
        <td><center><p>Upstairs Hallway Lights</p></center></td>
        <td><center><p>ON</p></center></td>
        <td><center><p>3</p></center></td>        
        <td><center><p>2</p></center></td>
        <td><center><p><a href="" class="btn-danger btn">Delete Zone</a></p></center></td>
      </tr>
      <tr>
        <td><center><p>Upstairs Bathroom Lights</p></center></td>
        <td><center><p>OFF</p></center></td>
        <td><center><p>3</p></center></td>        
        <td><center><p>2</p></center></td>
        <td><center><p><a href="" class="btn-danger btn">Delete Zone</a></p></center></td>
      </tr>
      <tr>
        <td><center><p>Bedroom 2 Lights</p></center></td>
        <td><center><p>OFF</p></center></td>
        <td><center><p>2</p></center></td>        
        <td><center><p>2</p></center></td>
        <td><center><p><a href="" class="btn-danger btn">Delete Zone</a></p></center></td>
      </tr>
      <tr>
        <td><center><p>Downstairs Hallway Lights</p></center></td>
        <td><center><p>ON</p></center></td>
        <td><center><p>4</p></center></td>        
        <td><center><p>2</p></center></td>
        <td><center><p><a href="" class="btn-danger btn">Delete Zone</a></p></center></td>
      </tr>
      <tr>
        <td><center><p>Downstairs Bathroom Light</p></center></td>
        <td><center><p>OFF</p></center></td>
        <td><center>
          <p>4</p>
        </center></td>        
        <td><center><p>1</p></center></td>
        <td><center><p><a href="" class="btn-danger btn">Delete Zone</a></p></center></td>
      </tr>
      <tr>
        <td><center><p>Kitchen Lights</p></center></td>
        <td><center><p>ON</p></center></td>
        <td><center><p>4</p></center></td>        
        <td><center><p>3</p></center></td>
        <td><center><p><a href="" class="btn-danger btn">Delete Zone</a></p></center></td>
      </tr>
      <tr>
        <td><center><p>Living Room Lights</p></center></td>
        <td><center><p>OFF</p></center></td>
        <td><center><p>4</p></center></td>        
        <td><center><p>2</p></center></td>
        <td><center><p><a href="" class="btn-danger btn">Delete Zone</a></p></center></td>
      </tr>
      <tr>
        <td><center><p>Living Room Lamps</p></center></td>
        <td><center><p>OFF</p></center></td>
        <td><center><p>4</p></center></td>        
        <td><center><p>2</p></center></td>
        <td><center><p><a href="" class="btn-danger btn">Delete Zone</a></p></center></td>
      </tr>
      <tr>
        <td><center><p>Porch Lights</p></center></td>
        <td><center><p>OFF</p></center></td>
        <td><center>
          <p>2</p>
        </center></td>        
        <td><center><p>2</p></center></td>
        <td><center><p><a href="" class="btn-danger btn">Delete Zone</a></p></center></td>
      </tr>
    </tbody>
  </table>
        
        </div><div class="col-xs-2"></div>
</div><div class="container center-block">
    <div class="col-xs-2"></div>
        <div class="col-xs-4">
           </div><div class="col-xs-4 text-right"><p><strong>Total Zones: <?php echo $db_records; ?></strong></p><p><a href="zone_details.php" class="btn-primary btn">Add New Zone</a></p>  </div>
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