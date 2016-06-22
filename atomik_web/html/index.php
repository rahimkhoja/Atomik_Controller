<?php include 'script/database.php';?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Atomik Controller - Login</title>
<link rel="stylesheet" href="css/atomik.css">
<script src="js/jquery-1.12.3.min.js"></script><?php

require_once 'script/config.php';
  
if($_SESSION['username'])
{
header("Location: dashboard.php");
exit;
}
 
if( isSet( $_POST["username"] ) && isSet( $_POST["password"]) )
{
$do_login = true;
include_once 'script/do_login.php';
}?></head>
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
</div><?php } ?><?php if ( $login_error ) { ?><div class="alert alert-danger">
  <strong>Danger!</strong> Invalid Username Or Password!</div><?php } ?><hr>
  <br>
 <div class="container">
    <div class="row">
        <div class="col-xs-12"></div>
        <div class="col-xs-5 text-center" style="overflow:hidden"><img src="img/Sun_Logo_Center_450px.gif" width="350" height="350" alt=""/></div>
        <div class="col-xs-1" style="border-left:1px solid #000;height:350px"></div>
        <div class="col-xs-6"><h4><p>Login:</p></h4><BR><form id="loginfrm" name="loginfrm" action="/index.php" method="post"><table class="table table-striped">
    <thead>
      <tr>
        <td>Username: </td>
        <td><input type="text" class="form-control" id="username" name="username"></td>
      </tr>
    </thead>
    <tbody>
    <tr>
        <td>Password: </td>
        <td><input type="password" class="form-control" id="password" name="password"></td>
      </tr>
      <tr>
        <td>Save Password: </td>
        <td><input type="checkbox" class="form-control" id="autologin" name="autologin" value="1" checked></td>
      </tr>
    </tbody>
  </table></form></div>
    </div></div>
  <hr>
  <div class="center col-xs-12">
  <div class="text-center col-xs-12"><p><a class="btn-success btn" id="loginbtn">Login</a></p>
  </div>
  </div></div>
</div>
 </div><?php if ( $page_success || $page_error ) { ?><hr><?php } ?><?php if ( $page_success ) { ?><div class="alert alert-success">
  <strong>Success!</strong> <?php echo $success_text; ?>
</div><?php } ?><?php if ( $login_error ) { ?><div class="alert alert-danger">
  <strong>Danger!</strong> Invalid Username Or Password!
</div><?php } ?><hr>
 </div>
<div class="footer FooterColor">
     <hr>
      <div class="col-xs-12 text-center">
        <p>Copyright © Atomik Technologies Inc. All rights reserved.</p>
      </div>
      <hr>
    </div><script type="text/javascript">
	$("#loginbtn").on('click', function() {
		$('#loginfrm').submit();
		});</script></body>
</html>