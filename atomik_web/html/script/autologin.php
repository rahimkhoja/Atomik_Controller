<?php
// Atomik Web Site - Autologin Script
// PHP

// Checks if cookie exists with username and password for the Atomik System
if(isSet($cookie_name))
{
    // Check if the cookie exists
if(isSet($_COOKIE[$cookie_name]))
    {
    parse_str($_COOKIE[$cookie_name]);
 
    // Make a verification
 
    if(($usr == $config_username) && ($hash == $config_password))
        {
        // Register the session
        $_SESSION['username'] = $config_username;
        }
    }
}
?>