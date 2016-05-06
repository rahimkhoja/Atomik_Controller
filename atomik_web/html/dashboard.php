<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Atomik Controller - Dashboard</title>
<link rel="stylesheet" href="css/atomik.css">
<?php

function getInterfaceMAC($interface) {
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
function getInterfaceGateway($interface) {
  $command = "netstat -nr | grep ".$interface." | grep UG | awk {'print $2'}";
  exec($command, $result);
  if(is_array($result)) {
    return $result[0];
  } else {
    return "notfound";
  }
}

function getInterfaceAddress($interface) {
  $command = "ifconfig ".$interface." | grep 'inet addr' | cut -d: -f2 | awk {'print $1'}";
  exec($command, $result);
  if(is_array($result)) {
    return $result[0];
  } else {
    return "notfound";
  }
}

function getInterfaceMask($interface) {
  $command = "ifconfig ".$interface." | grep 'inet addr' | cut -d: -f4 | awk {'print $1'}";
  exec($command, $result);
  if(is_array($result)) {
    return $result[0];
  } else {
    return "notfound";
  }
}


function getInterfaceDNS($interface) {
  $command = "netstat -nr | grep ".$interface." | grep UG | awk {'print $2'}";
  exec($command, $result);
  if(is_array($result)) {
    return $result[0];
  } else {
    return "notfound";
  }
}

function getInterfaceType($interface) {
  $command = "netstat -nr | grep ".$interface." | grep UG | awk {'print $2'}";
  exec($command, $result);
  if(is_array($result)) {
    return $result[0];
  } else {
    return "notfound";
  }
}

function getInterfaceStatus($interface) {
  $command = "netstat -nr | grep ".$interface." | grep UG | awk {'print $2'}";
  exec($command, $result);
  if(is_array($result)) {
    return $result[0];
  } else {
    return "notfound";
  }
}

function getCPU() {
$command = "more /proc/cpuinfo | grep 'model name' | cut -d: -f2 "; //| awk '{\$1=\$1};1'";
  exec($command, $result);
  if(is_array($result)) {
    return $result[0];
  } else {
    return "Not Found";
  }
}

function getHostname() {
  $command = "hostname -s";
  exec($command, $result);
  if(is_array($result)) {
    return $result[0];
  } else {
    return "Not Found";
  }
}

function getUptime() {
  $command = "uptime -p | sed 's/up //g' "; //| awk '{\$1=\$1};1'";
  exec($command, $result);
  if(is_array($result)) {
    return $result[0];
  } else {
    return "Not Available";
  }
}


?></head>
<nav class="navbar navbar-default navbar-inverse">
  <div class="container-fluid"> 
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <a class="navbar-brand" href="#"><img src="img/Sun_Logo_Menu_50px.gif" width="50" height="50" alt=""/></a></div>
    
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="dashboard.php">Dashboard<span class="sr-only">(current)</span></a> </li>
        <li><a href="settings.php">Settings</a> </li>
        <li><a href="devices.php">Devices</a> </li>
        <li><a href="remotes.php">Remotes</a> </li>
        <li><a href="zones.php">Zones</a> </li>
        <li><a href="tasks.php">Scheduled Tasks</a> </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="logout.php">Logout</a> </li>
      </ul>
    </div>
    <!-- /.navbar-collapse --> 
  </div>
  <!-- /.container-fluid --> 
</nav>
<body>
<div class="wrapper">
<div class="PageTitle">
    <div class="row">
        <div class="PageNavTitle" ><h3>Dashboard</h3></div>
    </div>
   </div><hr><div class="alert alert-success">
  <strong>Success!</strong> Indicates a successful or positive action.
</div><div class="alert alert-danger">
  <strong>Danger!</strong> Indicates a dangerous or potentially negative action.
</div>
<hr>

<div class="container">
    <div class="row">
        <div class="col-xs-6">
           <h4><p>System Information:</p></h4>   
  <table class="table table-striped">
    <thead>
      <tr>
        <td>Hostname: </td>
        <td><?php echo getHostname(); ?></td>
      </tr>
    </thead>
    <tbody>
    <tr>
        <td>CPU: </td>
        <td><?php echo getCPU(); ?></td>
    </tr>
      <tr>
        <td>CPU Utilization: </td>
        <td>0.6%</td>
      </tr>
      <tr>
        <td>Total Ram / Free Ram: </td>
        <td>512MB / 148MB</td>
      </tr>
      <tr>
        <td>Time Zone: </td>
        <td>(GMT -8:00) Pacific Time (US &amp; Canada)</td>
      </tr>
      <tr>
        <td>Current System Time: </td>
        <td><?php echo date("F j, Y, g:i a"); ?></td>
      </tr>
      <tr>
        <td>System Uptime: </td>
        <td><?php echo getUptime(); ?></td>
      </tr>
    </tbody>
  </table>
<br>
            <h4><p>Atomik Controller Information:</p></h4>   
  <table class="table table-striped">
    <thead>
      <tr>
        <td>Atomik Controller Version: </td>
        <td>0.5a</td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Atomik API Service: </td>
        <td>Running</td>
      </tr>
    <tr>
        <td>Mi-Light Emulator Service: </td>
        <td>Running</td>
      </tr>
      <tr>
        <td>Mi-Light Transceiver Service: </td>
        <td>Running</td>
      </tr>
      <tr>
        <td>Total Devices: </td>
        <td>21</td>
      </tr>
      <tr>
        <td>Total Remotes: </td>
        <td>4 </td>
      </tr>
       <tr>
        <td>Total Zones: </td>
        <td>11</td>
      </tr>
      <tr>
        <td>Total Scheduled Tasks: </td>
        <td>4</td>
      </tr>
    </tbody>
  </table>
        </div>
        <div class="col-xs-6">
            <h4><p>Ethernet Adapter Information:</p></h4>   
  <table class="table table-striped">
    <thead>
      <tr>
        <td>Eth0 Status: </td>
        <td>Connected</td>
      </tr>
    </thead>
    <tbody>
    <tr>
        <td>Eth0 Type: </td>
        <td>Static</td>
      </tr>
      <tr>
        <td>Eth0 IP Address: </td>
        <td><?php echo getInterfaceAddress('eth0'); ?></td>
      </tr>
      <tr>
        <td>Eth0 Subnet Mask: </td>
        <td><?php echo getInterfaceMask('eth0'); ?></td>
      </tr>
      <tr>
        <td>Eth0 Gateway: </td>
        <td><?php echo getInterfaceGateway('eth0'); ?></td>
      </tr>
      <tr>
        <td>Eth0 DNS: </td>
        <td>8.8.8.8</td>
      </tr>
      <tr>
        <td>Eth0 MAC Address: </td>
        <td><?php echo getInterfaceMAC('eth0'); ?></td>
      </tr>
    </tbody>
  </table><br>
            <h4><p>Wifi Adapter Information:</p></h4>   
  <table class="table table-striped">
    <thead>
      <tr>
        <td>Wifi0 Status: </td>
        <td>Connected</td>
      </tr>
    </thead>
    <tbody>
    <tr>
        <td>Wifi0 SSID: </td>
        <td>Home Router</td>
      </tr>
    <tr>
        <td>Wifi0 Type: </td>
        <td>DHCP</td>
      </tr>
      <tr>
        <td>Wifi0 IP Address: </td>
        <td><?php echo getInterfaceAddress('wlan0'); ?></td>
      </tr>
      <tr>
        <td>Wifi0 Subnet Mask: </td>
        <td><?php echo getInterfaceMask('wlan0'); ?></td>
      </tr>
      <tr>
        <td>Wifi0 Gateway: </td>
        <td><?php echo getInterfaceGateway('wlan0'); ?></td>
      </tr>
      <tr>
        <td>Wifi0 DNS: </td>
        <td>192.168.100.1</td>
      </tr>
      <tr>
        <td>Wifi0 MAC Address: </td>
        <td><?php echo getInterfaceMAC('wlan0'); ?></td>
      </tr>
      </tbody>
  </table>
    </div>
</div>
</div>
  <hr><div class="alert alert-success">
  <strong>Success!</strong> Indicates a successful or positive action.
</div><div class="alert alert-danger">
  <strong>Danger!</strong> Indicates a dangerous or potentially negative action.
</div>
<hr>
  <div class="container text-center">
<p><a href="dashboard.php" class="btn-primary btn">Refresh Details</a></p>
</div>
<hr>
<div class="push"></div>
 </div>
<div class="footer FooterColor">
  
     <hr>
      <div class="col-xs-12 text-center">
        <p>Copyright © Atomik Technologies Inc. All rights reserved.</p>
      </div>
      <hr>
    </div>
</body>
</html>

