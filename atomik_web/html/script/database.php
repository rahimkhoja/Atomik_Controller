<?php

$DBServer = '127.0.0.1'; // e.g 'localhost' or '192.168.1.100'
$DBUser   = 'root';  // change this as some point
$DBPass   = 'raspberry';
$DBName   = 'atomik_controller';

$conn = new mysqli($DBServer, $DBUser, $DBPass, $DBName);
 
// check connection
if ($conn->connect_error) {
  trigger_error('Database connection failed: '  . $conn->connect_error, E_USER_ERROR);
}


?>