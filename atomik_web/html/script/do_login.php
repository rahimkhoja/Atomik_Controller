<?php
if(!$do_login) exit;
 
// declare post fields
 
$post_username = trim($_POST["username"]);
$post_password = trim($_POST["password"]);
 
$post_autologin = $_POST["autologin"];

if($post_username == $config_username && sha1($post_password) == $config_password)
{
	
$login_ok = true;
 
$_SESSION['username'] = $config_username;
 
// Autologin Requested?
 
if($post_autologin == 1)
    { 
    setcookie ($cookie_name, 'usr='.$config_username.'&hash='.$config_password, time() + $cookie_time);
    }
 
header("Location: dashboard.php");
exit;
}
else
{
$login_error = true;
}
?>