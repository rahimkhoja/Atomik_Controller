<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Atomik_Web_Interface_V1_Header</title>
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
        <li><a href="#">Dashboard<span class="sr-only">(current)</span></a> </li>
        <li><a href="#">Settings</a> </li>
        <li><a href="#">Devices</a> </li>
        <li><a href="#">Remotes</a> </li>
        <li class="active"><a href="#">Zones</a> </li>
        <li><a href="#">Scheduled Tasks</a> </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Logout</a> </li>
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
          <h3>Zone Details</h3>
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
            <h4><p>General Zone Details:</p></h4>   
  <table class="table table-striped">
  <thead>
    <tr>
        <td>
          <p>Zone Name: </p>
        </td>
        <td><p><input type="text" class="form-control" id="devicename" value="Living Room Lamp 1"></p></td>
    </tr>  
  </thead>
    <tbody>
    <tr>
        <td><p>Zone Description: </p></td>
        <td><p><textarea class="form-control" rows="4" cols="1">Livingroom Lamp . To the right of the TV.
</textarea></p></td>
        
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
  <div class="col-xs-4 text-center"><p><a href="" class="btn-success btn">Save General Zone Details</a></p></div>
  
  <div class="col-xs-2"></div>
  </div>

  <br>
  <div class="container">
        <div class="col-xs-2"></div>
        <div class="col-xs-8"><hr>
            <h4><p>Zone Properties:</p></h4>
  <table class="table table-striped">
  <thead>
    <tr>
        <td>
          <p>Zone Status: </p>
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
          <p>Zone Color Mode: </p> - Only Visible if Zone contains Dual Mode Bulbs (RGBCW or RGBWW)
        </td>
        <td><p><select id="eth0status" class="form-control">
  <option value="1">White Mode</option>
  <option value="0">Color Mode</option>
</select></p></td>
    </tr> 
    
    <tr>
        <td>
          <p>Zone Color Mode: </p> - Only Visible if Zone contains Single Mode Bulbs (White or RGB)
        </td>
           
        <td><p><center><b>White Mode</b></center></p></td>
    </tr> <tr>
        <td>
          <p>Zone Brightness (0-100): </p>
        </td>
        <td><p><input type="text" class="form-control" id="remoteusername" value="100"></p></td>
    </tr> 
    <tr>
        <td>
          <p>Zone Color (0-255): </p>- Only Visible if zone contains at least 1 RGB Bulb
        </td>
        <td><p><input type="text" class="form-control" id="remoteusername" value="1"></p></td>
    </tr>
    <tr>
        <td>
          <p>Zone White Temperature (2700-6500):</p>- Only Visible if zone contains at least 1 Dual White Bulb
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
  <div class="col-xs-4 text-center"><p><a href="" class="btn-success btn">Set Zone Properties</a></p></div>
  
  <div class="col-xs-2"></div>
  </div>
<br><div class="container center-block">
<div class="col-xs-2"></div>
<div class="col-xs-8"><hr></div>
<div class="col-xs-2"></div>
</div>
  <div class="container center-block">
    <div class="col-xs-2"></div>
        <div class="col-xs-8">
           <h4><p>Zone Devices:</p></h4></div>
           <div class="col-xs-2"></div>
           </div><br>
           <div class="container center-block">
    <div class="col-xs-2"></div>
        <div class="col-xs-8">
  <table class="table table-striped">
    <thead>
      <tr>
        <td><b><center>Name</center></b></td>
        <td><b><center>Type</center></b></td>
        <td></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><center><p>Kitchen Light 1</p></center></td>
        <td><center><p>MiLight White</p></center></td>
        <td><center><p><a href="" class="btn-danger btn">Remove Device</a></p></center></td>
      </tr>
      <tr>
        <td><center><p>Kitchen Light 2</p></center></td>
        <td><center><p>MiLight White</p></center></td>
        <td><center><p><a href="" class="btn-danger btn">Remove Device</a></p></center></td>
      </tr>
      <tr>
        <td><center><p>Kitchen Light 3</p></center></td>
        <td><center><p>MiLight White</p></center></td>
        <td><center><p><a href="" class="btn-danger btn">Remove Device</a></p></center></td>
      </tr>
    </tbody>
  </table>
        
        </div><div class="col-xs-2"></div>
</div><div class="container center-block">
    <div class="col-xs-2"></div>
        <div class="col-xs-4">
           </div><div class="col-xs-4 text-right"><p><strong>Total Zone Devices: 3</strong></p><p><a href="" class="btn-primary btn">Add Zone Device</a></p>  </div>
           <div class="col-xs-2"></div>
           </div><br><div class="container center-block">
<div class="col-xs-2"></div>
<div class="col-xs-8"><hr></div>
<div class="col-xs-2"></div>
</div>
  <div class="container center-block">
    <div class="col-xs-2"></div>
        <div class="col-xs-8">
           <h4><p>Zone Remotes:</p></h4></div>
           <div class="col-xs-2"></div>
           </div><br>
           <div class="container center-block">
    <div class="col-xs-2"></div>
        <div class="col-xs-8">
  <table class="table table-striped">
    <thead>
      <tr>
        <td><b><center>Name</center></b></td>
        <td><b><center>Type</center></b></td>
        <td></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><center><p>Frank's Remote - MiLight Zone 1</p></center></td>
        <td><center><p>MiLight Smartphone Remote</p></center></td>
        <td><center><p><a href="" class="btn-danger btn">Remove Remote</a></p></center></td>
      </tr>
      <tr>
        <td><center><p>Chantel's Remote - MiLight Zone 3</p></center></td>
        <td><center><p>MiLight Smartphone Remote</p></center></td>
        <td><center><p><a href="" class="btn-danger btn">Remove Remote</a></p></center></td>
      </tr>
      <tr>
        <td><center><p>Tablet</p></center></td>
        <td><center><p>Atomik API Remote</p></center></td>
        <td><center><p><a href="" class="btn-danger btn">Remove Remote</a></p></center></td>
      </tr>
      <tr>
        <td><center><p>Backup Remote - MiLight Zone 4</p></center></td>
        <td><center><p>MiLight RGBW RF Remote</p></center></td>
        <td><center><p><a href="" class="btn-danger btn">Remove Remote</a></p></center></td>
      </tr>
    </tbody>
  </table>
        
        </div><div class="col-xs-2"></div>
</div><div class="container center-block">
    <div class="col-xs-2"></div>
        <div class="col-xs-4">
           </div><div class="col-xs-4 text-right"><p><strong>Total Zone Remotes: 4</strong></p><p><a href="" class="btn-primary btn">Add Zone Remote</a></p>  </div>
           <div class="col-xs-2"></div>
           </div><br>
  <hr><div class="alert alert-success">
  <strong>Success!</strong> Indicates a successful or positive action.
</div><div class="alert alert-danger">
  <strong>Danger!</strong> Indicates a dangerous or potentially negative action.
</div><hr>
  <div class="container center">
  <div class="col-xs-2">
  </div>
  <div class="col-xs-1"><a href=""  class="btn-warning btn">Cancel</a>
  </div>
  <div class="col-xs-1"><a href="" class="btn-danger btn">Delete Device</a>
  </div>
  <div class="col-xs-4">
  </div>
  <div class="col-xs-2 text-right">
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
