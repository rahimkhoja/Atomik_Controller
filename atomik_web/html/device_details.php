<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Atomik Controller - Device Details</title>
<link rel="stylesheet" href="css/atomik.css">
</head>
<nav class="navbar navbar-default navbar-inverse">
  <div class="container-fluid"> 
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <a class="navbar-brand" href="#"><img src="img/Sun_Logo_Menu_50px.gif" width="50" height="50" alt=""/></a></div>
    
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="dashboard.php">Dashboard</a> </li>
        <li><a href="settings.php">Settings</a> </li>
        <li class="active"><a href="devices.php">Devices<<span class="sr-only">(current)</span></a> </li>
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
        <div class="PageNavTitle" >
          <h3>Device Details</h3>
        </div>
    </div>
   </div><hr><div class="alert alert-success">
  <strong>Success!</strong> Indicates a successful or positive action.
</div><div class="alert alert-danger">
  <strong>Danger!</strong> Indicates a dangerous or potentially negative action.
</div>
<hr>
  <br>
  <div class="container">
        <div class="col-xs-2"></div>
        <div class="col-xs-8">
            <h4><p>General Device Details:</p></h4>   
  <table class="table table-striped">
  <thead>
    <tr>
        <td>
          <p>Device Name: </p>
        </td>
        <td><p><input type="text" class="form-control" id="devicename" value="Living Room Lamp 1"></p></td>
    </tr>  
  </thead>
    <tbody>
    <tr>
        <td><p>Device Description: </p></td>
        <td><p><textarea class="form-control" rows="4" cols="1">Livingroom Lamp . To the right of the TV.
</textarea></p></td>
        
      </tr>
      <tr>
        <td><p>Device Type: </p></td>
        <td><center>
          <p><strong>Milight RGB Warm White</strong></p>
        </center></td>
      </tr>
      </tbody>
  </table>
</div>
<div class="col-xs-2"></div></div><div class="container">
<div class="col-xs-2"></div>
  <div class="col-xs-8 text-center"><hr></div>
  <div class="col-xs-2"></div>
</div>
<div class="container">
<div class="col-xs-2"></div>
  <div class="col-xs-4 text-center"></div>
  <div class="col-xs-4 text-center"><p><a href="" class="btn-success btn">Save General Device Details</a></p></div>
  
  <div class="col-xs-2"></div>
  </div>

  <br>
  <div class="container">
        <div class="col-xs-2"></div>
        <div class="col-xs-8"><hr>
            <h4><p>Device Properties:</p></h4>
  <table class="table table-striped">
  <thead>
    <tr>
        <td>
          <p>Device Status: </p>
        </td>
        <td><p><select id="devicestatus" class="form-control">
  <option value="1">ON</option>
  <option value="0">OFF</option>
</select></p></td>
    </tr>  
  </thead>
    <tbody>
    <tr>
        <td>
          <p>Device Color Mode: </p> - Multiple Colour Mode Bulbs
        </td>
        <td><p><select id="eth0status" class="form-control">
  <option value="1">White Mode</option>
  <option value="0">Color Mode</option>
</select></p></td>
    </tr> 
    
    <tr>
        <td>
          <p>Device Color Mode: </p> - Single Mode Bulbs
        </td>
           
        <td><p><center><b>White Mode</b></center></p></td>
    </tr> <tr>
        <td>
          <p>Device Brightness (0-100): </p>
        </td>
        <td><p><input type="text" class="form-control" id="remoteusername" value="100"></p></td>
    </tr> 
    <tr>
        <td>
          <p>Device Color (0-255): </p>- Only Avaiable for RGB Bulbs
        </td>
        <td><p><input type="text" class="form-control" id="remoteusername" value="1"></p></td>
    </tr>
    <tr>
        <td>
          <p>Device White Temperature (2700-6500):</p>- Only Available for Dual White Bulbs
        </td>
        <td><p><input type="text" class="form-control" id="remoteusername" value="1"></p></td>
    </tr>
      </tbody>
  </table>
</div>
<div class="col-xs-2"></div></div>
<div class="container">
<div class="col-xs-2"></div>
  <div class="col-xs-8 text-center"><hr></div>
  <div class="col-xs-2"></div>
</div>
<div class="container">
<div class="col-xs-2"></div>
  <div class="col-xs-4 text-center"></div>
  <div class="col-xs-4 text-center"><p><a href="" class="btn-success btn">Set Device Properties</a></p></div>
  
  <div class="col-xs-2"></div>
  </div>
<br>
  <div class="container">
        <div class="col-xs-2"></div>
        <div class="col-xs-8"><hr>
            <h4><p>MiLight Device Details:</p></h4>   
  <table class="table table-striped">
  <thead>
    <tr>
        <td>
          <p>Address Byte 1: </p>
        </td>
        <td><p><input type="text" class="form-control" id="address1" value="126"></p></td>
    </tr>  
  </thead>
    <tbody>
    <tr>
        <td><p>Address Byte 2: </p></td>
        <td><p><input type="text" class="form-control" id="address2" value="45"></p></td>
      </tr>
      <tr>
        <td><p>Address Byte 3: </p></td>
        <td><p><input type="text" class="form-control" id="address3" value="229"></p></td>
      </tr>
      <tr>
        <td><p>Sequence Byte: </p></td>
        <td><p><input type="text" class="form-control" id="address3" value="74"></p></td>
      </tr>
      </tbody>
  </table>
</div>
<div class="col-xs-2"></div></div>
<div class="container">
<div class="col-xs-2"></div>
  <div class="col-xs-8 text-center"><hr></div>
  <div class="col-xs-2"></div>
</div>
<div class="container">
<div class="col-xs-2"></div>
  <div class="col-xs-2 text-center"><a href=""  class="btn-warning btn">Sync Device</a></div>
  <div class="col-xs-2 text-center"><a href=""  class="btn-warning btn">De-Sync Device</a></div>
  <div class="col-xs-4 text-center"><p><a href="" class="btn-success btn">Save MiLight Device Details</a></p></div>
  
  <div class="col-xs-2"></div>
  </div>
<br>
  <hr><div class="alert alert-success">
  <strong>Success!</strong> Indicates a successful or positive action.
</div><div class="alert alert-danger">
  <strong>Danger!</strong> Indicates a dangerous or potentially negative action.
</div><hr>
  <div class="container center">
  <div class="col-xs-2">
  </div>
  <div class="col-xs-1"><a href="devices.php"  class="btn-warning btn">Cancel</a>
  </div>
  <div class="col-xs-1"><a href="" class="btn-danger btn">Delete Device</a>
  </div>
  <div class="col-xs-4">
  </div>
  <div class="col-xs-2 text-right"><a href="" class="btn-success btn">Save All Details</a>
  </div>
  <div class="col-xs-2">
  </div>
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
