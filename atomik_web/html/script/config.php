<?php
error_reporting(E_ALL ^ E_NOTICE);
 
session_start(); // Start Session
header('Cache-control: private'); // IE 6 FIX
 
// always modified
header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
// HTTP/1.1
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
// HTTP/1.0
header('Pragma: no-cache');
 
// ---------- Login Info ---------- //

$sql  = "SELECT atomik_settings.id, atomik_settings.password FROM atomik_settings;";
$rs=$conn->query($sql);
if($rs === false) {
	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
} else {
  	$db_records = $rs->num_rows;
}
$rs->data_seek(0);
$row = $rs->fetch_assoc();

$config_username = "admin";
$config_password = $row['password'];
$db_records = 0;

$rs->free();
$conn->close();
 
// ---------- Cookie Info ---------- //
 
$cookie_name = 'atomikAuth';
$cookie_time = (3600 * 24 * 30); // 30 days
 
// ---------- Invoke Auto-Login if no session is registered ---------- //
 
if(!$_SESSION['username'])
{
include_once 'autologin.php';
}
?>