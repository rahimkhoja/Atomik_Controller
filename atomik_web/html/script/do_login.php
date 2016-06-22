<?php
if(!$do_login) exit;
 
// declare post fields
 
$post_username = trim($_POST["username"]);
$post_password = trim($_POST["password"]);
 
$post_autologin = $_POST["autologin"];

if($db_records > 0)
{
	
$login_ok = true;
 
$_SESSION['username'] = $config_username;
 
// Autologin Requested?
 
if($post_autologin == 1)
    {
    $password_hash = sha1($config_password); // will result in a 40 characters hash
 
    setcookie ($cookie_name, 'usr='.$config_username.'&hash='.$password_hash, time() + $cookie_time);
    }
 
header("Location: dashboard.php");
exit;
}
else
{
$login_error = true;
}
?>