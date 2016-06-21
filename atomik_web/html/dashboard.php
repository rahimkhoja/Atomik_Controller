<?php include 'script/database.php';?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="icon" type="image/png" href="img/favicon-32x32.png" sizes="32x32" />
<title>Atomik Controller - Dashboard</title>
<link rel="stylesheet" href="css/atomik.css">
<?php

$atomik_version = "0.8 Alpha";

$page_error = 0;
$page_success = 0;


if ($itemcount = $conn->query("SELECT device_id FROM atomik_devices")) {
	$device_total = $itemcount->num_rows;
    $itemcount->close();
}

if ($itemcount = $conn->query("SELECT remote_id FROM atomik_remotes")) {
	$remote_total = $itemcount->num_rows;
    $itemcount->close();
}

if ($itemcount = $conn->query("SELECT zone_id FROM atomik_zones")) {
	$zone_total = $itemcount->num_rows;
    $itemcount->close();
}

if ($itemcount = $conn->query("SELECT task_id FROM atomik_tasks")) {
	$task_total = $itemcount->num_rows;
    $itemcount->close();
}

$timezone = 'UTC';
if (file_exists('/etc/timezone')) {
    // Ubuntu / Debian.
    $data = file_get_contents('/etc/timezone');
	$data = trim($data);
	if ($data) {
        $timezone = $data;
    }
} 
ini_set( 'date.timezone', $timezone );
date_default_timezone_set($timezone);

function getInterfaceMAC($interface) {
	if (getInterfaceStatus($interface) == "Connected") {
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
}

function getInterfaceGateway($interface) {
	if (getInterfaceStatus($interface) == "Connected") {
		$command = "netstat -nr | grep ".$interface." | grep UG | awk {'print $2'}";
  		exec($command, $result);
  		if(is_array($result)) {
  		  return $result[0];
  		} else {
  		  return "notfound";
  		}
	}
}

function getService($servicename) {
	$command = "service ".$servicename." status | grep 'Active: '";
	exec($command, $output);
		if (strpos($output[0],'running') !== false) {
			echo "Running";
		} else {
		    echo "Stopped";
		};
}

function getInterfaceAddress($interface) {
	if (getInterfaceStatus($interface) == "Connected") { 
		$command = "ifconfig ".$interface." | grep 'inet addr' | cut -d: -f2 | awk {'print $1'}";
  		exec($command, $result);
  		if(is_array($result)) {
    		return $result[0];
  		} else {
    		return "notfound";
  		}
	}
}

function getInterfaceMask($interface) {
	if (getInterfaceStatus($interface) == "Connected") {
		$command = "ifconfig ".$interface." | grep 'inet addr' | cut -d: -f4 | awk {'print $1'}";
  		exec($command, $result);
  		if(is_array($result)) {
    		return $result[0];
  		} else {
    		return "notfound";
  		}
	}
}

function getInterfaceDNS($interface) {
	if (getInterfaceStatus($interface) == "Connected") {
		$inter = getInterfaceType($interface);
  		if ( $inter == "DHCP" ) {
			$command = "cat /var/lib/dhcp/dhclient.leases | awk '/".$interface."/,/}/' | grep domain-name-servers | tr ';' ' ' | cut -d' ' -f5  | awk {'print $1'}
";
      		exec($command, $result);
      		if(is_array($result)) {
		  		return $result[0];
      		} else {
          		return "notfound";
      		}  	
  		} else if ( $inter == "Static" ) {
	  		$command = "cat /etc/dhcpcd.conf | awk '/interface ".$interface."/{getline; getline; getline; print $2}' | grep domain_name_servers | cut -d= -f2";
      		exec($command, $result);
      		if(is_array($result)) {
		  		return $result[0];
      		} else {
          		return "notfound";
			}
      	}
  	}
}

function getInterfaceType($interface) {
	if (getInterfaceStatus($interface) == "Connected") {
		$command = "cat /etc/dhcpcd.conf | grep 'interface ".$interface."'";
		exec($command, $result);
		if(is_array($result)) {
			if (strpos($result[0], "interface ".$interface) !== false) {
				return "Static";
			} else {
				return "DHCP";
			}
		} else {
		return "Not Found";
		}
  	}
}

function getInterfaceStatus($interface) {
  $command = "ifplugstatus ".$interface;
  exec($command, $result);
  if(is_array($result)) {
	  if (strpos($result[0], 'link beat detected') !== false) {
		  return "Connected";
	  } else {
		  return "Disconnected";
	  }
  } else {
	  return "Not Found";
  }
}

function getSSID() {
  $command = "iwgetid -r";
  exec($command, $result);
  if(is_array($result)) {
    return $result[0];
  } else {
    return "notfound";
  }
}

function getCPU() {
$command = "more /proc/cpuinfo | grep 'model name' | cut -d: -f2 | awk '".'{$1=$1};1'."'";
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

function getRam() {
  $command = "free -m |  grep 'Mem:' | awk {'print $2 \"MB /\", $4 \"MB\"'}";
  exec($command, $result);
  if(is_array($result)) {
    return $result[0];
  } else {
    return "Not Available";
  }
}

function getCpuUsage() {
  $command = "mpstat | grep -A 5 \"%idle\" | tail -n 1 | awk -F \" \" '{print 100 - $12 \"%\"}'";
  exec($command, $result);
  if(is_array($result)) {
    return $result[0];
  } else {
    return "Not Available";
  }
}

function getTimeZone() {
    return date_default_timezone_get().' ( '.date('T').' ) ';
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
   </div><?php if ( $page_success || $page_error ) { ?><hr><?php } ?><?php if ( $page_success ) { ?><div class="alert alert-success">
  <strong>Success!</strong> Indicates a successful or positive action.
</div><?php } ?><?php if ( $page_error ) { ?><div class="alert alert-danger">
  <strong>Danger!</strong> Indicates a dangerous or potentially negative action.
</div><?php } ?>
<hr>
<div class="container">
    <div class="row">
        <div class="col-xs-6">
           <h4><p>System Information:</p></h4>   
  <table class="table table-striped">
    <thead>
      <tr>
        <td>Hostname: </td>
        <td><?php echo gethostname(); ?></td>
      </tr>
    </thead>
    <tbody>
    <tr>
        <td>CPU: </td>
        <td><?php echo getCPU(); ?></td>
    </tr>
      <tr>
        <td>CPU Utilization: </td>
        <td><?php echo getCpuUsage(); ?></td>
      </tr>
      <tr>
        <td>Total Ram / Free Ram: </td>
        <td><?php echo getRam(); ?></td>
      </tr>
      <tr>
        <td>Time Zone: </td>
        <td><?php echo date_default_timezone_get(); ?></td>
      </tr>
      <tr>
        <td>Current System Time: </td>
        <td><?php echo date("l, M jS Y, g:i:s A ( T )",time() ); ?></td>
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
        <td><?php echo $atomik_version; ?></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Atomik API Service: </td>
        <td><?php getService('atomik-server'); ?></td>
      </tr>
    <tr>
        <td>Mi-Light Emulator Service: </td>
        <td><?php getService('atomik-emulator'); ?></td>
      </tr>
      <tr>
        <td>Mi-Light Transceiver Service: </td>
        <td><?php getService('atomik-transceiver'); ?></td>
      </tr>
      <tr>
        <td>Total Devices: </td>
        <td><?php echo $device_total; ?></td>
      </tr>
      <tr>
        <td>Total Remotes: </td>
        <td><?php echo $remote_total; ?></td>
      </tr>
       <tr>
        <td>Total Zones: </td>
        <td><?php echo $zone_total; ?></td>
      </tr>
      <tr>
        <td>Total Scheduled Tasks: </td>
        <td><?php echo $task_total; ?></td>
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
        <td><?php echo getInterfaceStatus('eth0'); ?></td>
      </tr>
    </thead>
    <tbody>
    <tr>
        <td>Eth0 Type: </td>
        <td><?php echo getInterfaceType('eth0'); ?></td>
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
        <td><?php echo getInterfaceDNS('eth0'); ?></td>
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
        <td><?php echo getInterfaceStatus('wlan0'); ?></td>
      </tr>
    </thead>
    <tbody>
    <tr>
        <td>Wifi0 SSID: </td>
        <td><?php echo getSSID(); ?></td>
      </tr>
    <tr>
        <td>Wifi0 Type: </td>
        <td><?php echo getInterfaceType('wlan0'); ?></td>
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
        <td><?php echo getInterfaceDNS('wlan0'); ?></td>
      </tr>
      <tr>
        <td>Wifi0 MAC Address: </td>
        <td><?php echo getInterfaceMAC('wlan0'); ?></td>
      </tr>
      </tbody>
  </table>
    </div>
</div>
</div><?php if ( $page_success || $page_error ) { ?><hr><?php } ?><?php if ( $page_success ) { ?><div class="alert alert-success">
  <strong>Success!</strong> Indicates a successful or positive action.
</div><?php } ?><?php if ( $page_error ) { ?><div class="alert alert-danger">
  <strong>Danger!</strong> Indicates a dangerous or potentially negative action.
</div><?php } ?><hr>  <div class="container text-center">
<p><a href="dashboard.php" class="btn-primary btn">Refresh Details</a></p>
</div><hr>
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
</html><?php 
$conn->close();
?>