<?php
if(isSet($cookie_name))
{
    // Check if the cookie exists
if(isSet($_COOKIE[$cookie_name]))
    {
    parse_str($_COOKIE[$cookie_name]);
 
    // Make a verification
 
    if(($usr == $config_username) && ($hash == sha1($config_password)))
        {
        // Register the session
        $_SESSION['username'] = $config_username;
        }
    }
}
?>