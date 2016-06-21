<?php include 'script/database.php';?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Atomik Controller - Login</title>
<link rel="stylesheet" href="css/atomik.css">
<?php

	session_start();
	$db_records = 0; 
	
	if ( $_SESSION['is_error'] == 1 ) {
		$page_error = 1;
		$error_text = "Invalid Username Or Password!";	
	}
	
    session_destroy();
    session_start();
	if (isset($_POST['username']) && isset($_POST['username'])) {
	  	$username = $_POST['username'];
  		$password_sha1 = sha1($_POST['password']);

	  	if ( $username == 'admin' ) {
  			$sql  = "SELECT atomik_settings.id, atomik_settings.password";
  			$sql .= "FROM atomik_settings ";
  			$sql .= "WHERE atomik_settings.password=:p";
  			$rs=$conn->query($sql);
			if($rs === false) {
  				trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
			} else {
  				$db_records = $rs->num_rows;
			}


		    if ($db_records > 0) {
		    	$_SESSION['signed_in'] = true;
        		$_SESSION['username'] = $username;
       			header("Location: /dashboard.php");
  			}
		} else {
    		$_SESSION['is_error'] = 1;
    		$_SESSION['signed_in'] = false;
    		$_SESSION['username'] = null;
    		header("Location: /index.php");
  		}
	}
?></head>
<nav class="navbar navbar-default navbar-inverse">
  <div class="container-fluid"> 
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
     </div>
    
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      
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
          <h3>Atomik Controller</h3>
        </div>
    </div>
   </div><?php if ( $page_success || $page_error ) { ?><hr><?php } ?><?php if ( $page_success ) { ?><div class="alert alert-success">
  <strong>Success!</strong> Indicates a successful or positive action.
</div><?php } ?><?php if ( $page_error ) { ?><div class="alert alert-danger">
  <strong>Danger!</strong> Indicates a dangerous or potentially negative action.
</div><?php } ?>
<hr>
  <br>
  <div class="container">
        <div class="col-xs-5"><img src="img/Sun_Logo_Center_450px.gif" width="350" height="350" alt=""/></div>
        <div class="col-xs-1"><div style="border-left:1px solid #000;height:350px"></div></div>
        <div class="col-xs-6">
            <h4><p>Login:</p></h4>   
  <table class="table table-striped">
    <thead>
      <tr>
        <td>Username: </td>
        <td><input type="text" class="form-control" id="username" name="username" value="admin"></td>
      </tr>
    </thead>
    <tbody>
    <tr>
        <td>Password: </td>
        <td><input type="password" class="form-control" id="password" name="password" value="admin"></td>
      </tr>
      <tr>
        <td>Save Password: </td>
        <td><input type="checkbox" class="form-control" id="savepass" name="savepass"></td>
      </tr>
    </tbody>
  </table>
  <hr>
  <div class="center col-xs-12">
  <div class="text-center col-xs-6"></div>
  <div class="text-center col-xs-6"><p><a href="" class="btn-success btn">Login</a></p></div>
  </div>
  </div>
  <br><hr>
</div>
  <br><?php if ( $page_success || $page_error ) { ?><hr><?php } ?><?php if ( $page_success ) { ?><div class="alert alert-success">
  <strong>Success!</strong> Indicates a successful or positive action.
</div><?php } ?><?php if ( $page_error ) { ?><div class="alert alert-danger">
  <strong>Danger!</strong> Indicates a dangerous or potentially negative action.
</div><?php } ?>
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
