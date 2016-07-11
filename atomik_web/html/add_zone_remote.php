<?php
// Atomik Web Site - Add Zone Remote Page
// HTML/JQUERY/PHP/MySQL
// By Rahim Khoja

// Adds Atomik Remotes to Atomik Zones. Only lists available remotes.
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
<title>Atomik Controller - Add Remote to Zone</title>
<link rel="stylesheet" href="css/atomik.css">
<script src="js/jquery-1.12.3.min.js"></script>
<script src="js/jquery.redirect.min.js"></script>
<?php
// Set Default Error & Success Settings
$page_error = 0;
$page_success = 0;
$success_text = "";
$error = "";
// Timezone
$sql = "SELECT timezone FROM atomik_settings;";
$rs = $conn->query($sql);
if ($rs === false) {
  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
}
else {
  $db_records = $rs->num_rows;
}
$rs->data_seek(0);
$row = $rs->fetch_assoc();
$timezone = $row['timezone'];
$rs->free();
// Set Command

if ( isset($_POST["command"]) ) {
	$command = $_POST["command"];
} else {
	$command = "";
}
if (isset($_POST["zone_id"])) {
  $_zone_id = $_POST["zone_id"];
}
else {
  $_zone_id = "";
}
if (isset($_POST["remote_id"])) {
  $_remote_id = $_POST["remote_id"];
}
else {
  $_remote_id = "";
}

// Add Remote to Zone (add_remote)
if ($command <> "" && $command != "" && $command == "add_remote") {
  $erro = array();

  // addr_row will hold addr_rs. Information About The Remote
  $sql = "SELECT atomik_remotes.remote_id, atomik_remotes.remote_name, atomik_remotes.remote_type FROM atomik_remotes WHERE atomik_remotes.remote_id=" . $_remote_id . ";";
  $addr_rs = $conn->query($sql);
  if ($addr_rs === false) {
    trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
  }
  else {
    $addr_rs->data_seek(0);
    $addr_row = $addr_rs->fetch_assoc();
	
	// Mi-Light RF and Smart Phone Remotes
    if (!($addr_row['remote_type'] == 3)) {

      $sql = "SELECT atomik_remote_channels.remote_channel_id, atomik_remote_channels.remote_channel_number FROM atomik_remote_channels WHERE atomik_remote_channels.remote_channel_remote_id=" . $_remote_id . " && atomik_remote_channels.remote_channel_zone_id=0 ORDER BY atomik_remote_channels.remote_channel_number ASC;";
      $chn_num_rs = $conn->query($sql);
      if ($chn_num_rs === false) {
        trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
      }
      else {
        $chn_num_rs->data_seek(0);
        $chn_num_row = $chn_num_rs->fetch_assoc();
        
        $_remote_channel = $chn_num_row['remote_channel_number'];
        $sql = "UPDATE atomik_remote_channels SET remote_channel_zone_id=" . $_zone_id . " WHERE remote_channel_number=" . $_remote_channel . " && remote_channel_remote_id=" . $_remote_id . ";";
        if ($conn->query($sql) === TRUE) {
          $page_success = 1;
          $success_text = "Remote Channel Updated Updated!";
          $sql = "INSERT INTO atomik_zone_remotes (zone_remote_zone_id, zone_remote_remote_id, zone_remote_channel_number, zone_remote_last_update) VALUES (" . trim($_zone_id) . "," . trim($_remote_id) . "," . trim($_remote_channel) . ", CONVERT_TZ(NOW(), '" . $timezone . "', 'UTC') );";
          if ($conn->query($sql) === TRUE) {
            $page_success = 1;
            $success_text = "Atomik Zone Remote Added To Zone DB!";
            echo "<br />";
            echo '<script type="text/javascript">' . "$().redirect('zone_details.php', {'zone_id': " . trim($_zone_id) . "});</script>";
          }
          else {
            $page_error = 1;
            $error_text = "Error Adding Atomik Remote To Zone DB!";
          }
        }
        else {
          $page_error = 1;
          $error_text = "Error Saving Remote Channel Details To DB!";
        }
      }
    } else {
		
		
    // Atomik Remotes   
      // Get Remote Channel Data
      $sql = "SELECT atomik_remote_channels.remote_channel_id, atomik_remote_channels.remote_channel_number FROM atomik_remote_channels WHERE atomik_remote_channels.remote_channel_remote_id=" . $_remote_id . " ORDER BY atomik_remote_channels.remote_channel_number ASC;";
      $chn_num_rs = $conn->query($sql);
      if ($chn_num_rs === false) {
        trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
      }
      else {
        $chn_num_rs->data_seek(0);
        $_channels_used = $chn_num_rs->num_rows;
        $chn_num_row = $chn_num_rs->fetch_assoc();
   
        // If No Channel Entries for Remote Add First Channel Entry (Atomik API)
        if ($chn_num_row == 0) {
          $sql = "INSERT INTO atomik_remote_channels (remote_channel_zone_id, remote_channel_remote_id, remote_channel_number, remote_channel_name) VALUES (" . trim($_zone_id) . "," . trim($_remote_id) . ",0,'Atomik Remote Channel 1');";
          if ($conn->query($sql) === TRUE) {
            $page_success = 1;
            $success_text = "Remote Channel Updated Updated!";
            $sql = "INSERT INTO atomik_zone_remotes (zone_remote_zone_id, zone_remote_remote_id, zone_remote_channel_number, zone_remote_last_update) VALUES (" . trim($_zone_id) . "," . trim($_remote_id) . ",0 , CONVERT_TZ(NOW(), '" . $timezone . "', 'UTC') );";
            if ($conn->query($sql) === TRUE) {
              $page_success = 1;
              $success_text = "Atomik Zone Remote Added To Zone DB!";
              echo "<br />";
              echo '<script type="text/javascript">' . "$().redirect('zone_details.php', {'zone_id': " . trim($_zone_id) . "});</script>";
            }
            else {
              $page_error = 1;
              $error_text = "Error Adding Atomik Remote To Zone DB!";
            }
          }
          else {
            $page_error = 1;
            $error_text = "Error Adding Device To Zone DB!";
          }
        }
        else {
          // Already Channel Entries. Find The Lowest Possible Number For Channel
          // Find Gaps
          $sql = "SELECT a AS remote_channel_number, b AS next_id, (b - a) -1 AS missing_inbetween FROM ( SELECT a1.remote_channel_number AS a , MIN(a2.remote_channel_number) AS b FROM atomik_remote_channels AS a1 LEFT JOIN atomik_remote_channels AS a2 ON a2.remote_channel_number > a1.remote_channel_number WHERE a1.remote_channel_number <= 100 && a2.remote_channel_remote_id=" . trim($_remote_id) . " GROUP BY a1.remote_channel_number) AS tab WHERE b > a + 1";
          $avl_chn_rs = $conn->query($sql);
          if ($avl_chn_rs === false) {
            trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
          }
          else {
            $avl_chn_rs->data_seek(0);
            $_used_channels = $avl_chn_rs->num_rows;
            $avl_chn_row = $avl_chn_rs->fetch_assoc();
            // Gap Found Intest Based On First Gap in Channel Sequence
            if ($_used_channels > 0) {
              // figure out what number to use
              $sql = "INSERT INTO atomik_remote_channels (remote_channel_zone_id, remote_channel_remote_id, remote_channel_number, remote_channel_name) VALUES (" . trim($_zone_id) . "," . trim($_remote_id) . "," . ($avl_chn_row['remote_channel_number'] + 1) . ",'Atomik Remote Channel " . ($avl_chn_row['remote_channel_number'] + 2) . "');"; // here
              if ($conn->query($sql) === TRUE) {
                $page_success = 1;
                $success_text = "Atomik Zone Remote Channel Added To Zone DB!";
                $sql = "INSERT INTO atomik_zone_remotes (zone_remote_zone_id, zone_remote_remote_id, zone_remote_channel_number, zone_remote_last_update) VALUES (" . trim($_zone_id) . "," . trim($_remote_id) . "," . ($avl_chn_row['remote_channel_number'] + 1) . ", CONVERT_TZ(NOW(), '" . $timezone . "', 'UTC') );";
                if ($conn->query($sql) === TRUE) {
                  $page_success = 1;
                  $success_text = "Atomik Zone Remote Added To Zone DB!";
                  echo "<br />";
                  echo '<script type="text/javascript">' . "$().redirect('zone_details.php', {'zone_id': " . trim($_zone_id) . "});</script>";
                }
                else {
                  $page_error = 1;
                  $error_text = "Error Adding Atomik Remote  To Zone DB!";
                }
              }
              else {
                $page_error = 1;
                $error_text = "Error Adding Atomik Remote Channel To Zone DB!";
              }
            }
            else {
              // Use the Next Channel Number
              $sql = "INSERT INTO atomik_remote_channels (remote_channel_zone_id, remote_channel_remote_id, remote_channel_number, remote_channel_name) VALUES (" . trim($_zone_id) . "," . trim($_remote_id) . "," . $_channels_used . ",'Atomik Remote Channel " . ($_channels_used + 1) . "');";
              if ($conn->query($sql) === TRUE) {
                $page_success = 1;
                $success_text = "Atomik Zone Remote Channel Added To Zone DB!";
                $sql = "INSERT INTO atomik_zone_remotes (zone_remote_zone_id, zone_remote_remote_id, zone_remote_channel_number, zone_remote_last_update) VALUES (" . trim($_zone_id) . "," . trim($_remote_id) . "," . $_channels_used . ", CONVERT_TZ(NOW(), '" . $timezone . "', 'UTC') );";
                if ($conn->query($sql) === TRUE) {
                  $page_success = 1;
                  $success_text = "Atomik Zone Remote Added To Zone DB!";
                  echo "<br />";
                  echo '<script type="text/javascript">' . "$().redirect('zone_details.php', {'zone_id': " . trim($_zone_id) . "});</script>";
                }
                else {
                  $page_error = 1;
                  $error_text = "Error Adding Atomik Remote  To Zone DB!";
                }
              }
              else {
                $page_error = 1;
                $error_text = "Error Adding Atomik Remote Channel To Zone DB!";
              }
            }
          }
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
      <a class="navbar-brand" id="atomikLogo"><img src="img/Sun_Logo_Menu_50px.gif" width="50" height="50" alt=""/></a></div>
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
          <h3>Add Remote to Zone</h3>
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
   <form id="zoneremfrm" name="zoneremfrm" action="add_zone_remote.php" method="post"><input name="zone_id" id="zone_id" type="hidden" value="<?php echo $_zone_id; ?>"><input name="command" id="command" type="hidden" value="add_remote">         
  <table class="table table-striped">
  <thead>
    <tr>
        <td width="200" >
         <h4><p>Please Select Remote:</p></h4>
        </td>
    </tr>  
  </thead>
    <tbody>
    <tr>
        <td ><p><select id="remote_id" name="remote_id" class="form-control">
        <?php
$sql = "SELECT atomik_remotes.remote_id, atomik_remotes.remote_name, atomik_remotes.remote_type FROM atomik_remotes;";
$remrs=$conn->query($sql);
if($remrs === false) {
	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
} else {
  	$remrs->data_seek(0);
  	while($remrow = $remrs->fetch_assoc()){
	  	if ( $remrow['remote_type'] == 1 || $remrow['remote_type'] == 1 ) {
			$sql = "SELECT atomik_remote_channels.remote_channel_id FROM atomik_remote_channels WHERE atomik_remote_channels.remote_channel_remote_id=".$remrow['remote_id']." && atomik_remote_channels.remote_channel_zone_id=0;";
		  	$rchrs=$conn->query($sql);
		  	$_available_channels = 0;
		  	if($rchrs === false) {
			  	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
		  	} else {
			  	$_available_channels = $rchrs->num_rows;
		  	}
		  	if ( $_available_channels > 0 ) {
			  	echo '<option value="'. $remrow['remote_id']. '">'.$remrow['remote_name'].'</option>';
		  	}
	  	} else { 
			echo '<option value="'. $remrow['remote_id']. '">'.$remrow['remote_name'].'</option>';
		}
	}
}
?></select></p></td>
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
  <div class="col-xs-2 text-right"><a id="saveremotebtn" class="btn-success btn">Save</a>
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
$("#saveremotebtn").on('click', function() {
	document.zoneremfrm.submit();
});
</script>
</body><?php
$rs->free();
$remrs->free();
$chn_num_rs->free();
$addr_rs->free();
$rchrs->free();
$conn->close();
?>
</html>