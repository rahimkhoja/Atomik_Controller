<?php
function getMacLinux($interface) {
  exec('netstat -ie', $result);
  if(is_array($result)) {
    foreach($result as $key => $line) {
      if($key > 0) {
        $tmp = str_replace(" ", "", substr($line, 0, 10));
        if($tmp == $interface) {
          $macpos = strpos($line, "HWaddr");
          if($macpos !== false) {
            $iface = strtolower(substr($line, $macpos+7, 17));
          }
        }
      }
    }
    return $iface;
  } else {
    return "notfound";
  }
}
echo getMacLinux('eth0');
echo getMacLinux('wlan0');


?>
