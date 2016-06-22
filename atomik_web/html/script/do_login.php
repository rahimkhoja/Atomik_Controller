<?php
if(!$do_login) exit;
 
// declare post fields
 
$post_username = trim($_POST["username"]);
$post_password = trim($_POST["password"]);
 
$post_autologin = $_POST["autologin"];
 
 // ---------- Login Info ---------- //
 
$config_username = "admin";


$db_records = 0;
if ( $username == 'admin' ) {
  $sql  = "SELECT atomik_settings.id, atomik_settings.password FROM atomik_settings WHERE atomik_settings.password='".sha1($post_password)."';";
  $rs=$conn->query($sql);
	if($rs === false) {
  		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
	} else {
  		$db_records = $rs->num_rows;
	}
}
 
if($db_records > 0)
{
	$rs->data_seek(0);
	$row = $rs->fetch_assoc();
	$config_password = $row['password'];
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
$rs->free();
$conn->close();
?>