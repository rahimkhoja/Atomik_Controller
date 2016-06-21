<?php include 'script/database.php';?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Atomik Controller - Login</title>
<link rel="stylesheet" href="css/atomik.css">
<script src="js/jquery-1.12.3.min.js"></script>
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
  			$sql  = "SELECT atomik_settings.id, atomik_settings.password FROM atomik_settings WHERE atomik_settings.password='".$password_sha1."';";
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
			} else {
    			$_SESSION['is_error'] = 1;
    			$_SESSION['signed_in'] = false;
    			$_SESSION['username'] = null;
    			header("Location: /index.php");
			}
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
  <strong>Success!</strong> <?php echo $success_text; ?>
</div><?php } ?><?php if ( $page_error ) { ?><div class="alert alert-danger">
  <strong>Danger!</strong> <?php echo $error_text; ?>
</div><?php } ?><hr>
  <br>
 <div class="container">
    <div class="row">
        <div class="col-xs-12"></div>
        <div class="col-xs-5 text-center"><img src="img/Sun_Logo_Center_450px.gif" width="350" height="350" alt=""/></div>
        <div class="col-xs-1" style="border-left:1px solid #000;height:350px"></div>
        <div class="col-xs-6"><h4><p>Login:</p></h4><BR><form id="loginfrm" name="loginfrm" enctype="multipart/form-data" action="index.php" method="post"><table class="table table-striped">
    <thead>
      <tr>
        <td>Username: </td>
        <td><input type="text" class="form-control" id="username" name="username" value="admin"></td>
      </tr>
    </thead>
    <tbody>
    <tr>
        <td>Password: <span class="col-xs-5"></span></td>
        <td><input type="password" class="form-control" id="password" name="password" value="admin"></td>
      </tr>
      <tr>
        <td>Save Password: </td>
        <td><input type="checkbox" class="form-control" id="savepass" name="savepass"></td>
      </tr>
    </tbody>
  </table></form></div>
    </div>
        </div>
  <hr>
  <div class="center col-xs-12">
  <div class="text-center col-xs-12"><p><a id="loginbtn" class="btn-success btn">Login</a></p></div>
  </div></div>
</div>
 </div><?php if ( $page_success || $page_error ) { ?><hr><?php } ?><?php if ( $page_success ) { ?><div class="alert alert-success">
  <strong>Success!</strong> <?php echo $success_text; ?>
</div><?php } ?><?php if ( $page_error ) { ?><div class="alert alert-danger">
  <strong>Danger!</strong> <?php echo $error_text; ?>
</div><?php } ?><hr>
<div class="footer FooterColor">
      <div class="col-xs-12 text-center"><BR><BR>
        <p>Copyright © Atomik Technologies Inc. All rights reserved.</p>
      </div></div><script type="text/javascript">
	$("#loginbtn").on('click', function() {
   document.loginfrm.submit();
});</script></body><?php
$rs->free();
$conn->close();
?>
</html>