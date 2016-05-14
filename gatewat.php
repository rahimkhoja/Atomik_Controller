<?php
function getInterfaceGateway($interface) {
  $command = "netstat -nr | grep ".$interface." | grep UG | awk {'print $2'}";  
  exec($command, $result);
  if(is_array($result)) {
    return $result[0];
  } else {
    return "notfound";
  }
}
echo getInterfaceGateway('eth0');

