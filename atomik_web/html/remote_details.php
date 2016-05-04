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
        <li class="active"><a href="#">Remotes</a> </li>
        <li><a href="#">Zones</a> </li>
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
          <h3>Remote Details</h3>
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
            <h4><p>General Remote Details:</p></h4>   
  <table class="table table-striped">
  <thead>
    <tr>
        <td>
          <p>Remote Name: </p>
        </td>
        <td><p><input type="text" class="form-control" id="remotename" value="Frank's Remote"></p></td>
    </tr>  
  </thead>
    <tbody>
    <tr>
        <td><p>Remote Description: </p></td>
        <td><p><textarea class="form-control" rows="4" cols="1">
At w3schools.com you will learn how to make a website. We offer free tutorials in all web development technologies.
</textarea></p></td>
        
      </tr>
      <tr>
        <td><p>Remote Type: </p></td>
        <td><center>
          <p><b>MiLight Smartphone Remote</b></p>
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
  <div class="col-xs-4 text-center"><p><a href="" class="btn-success btn">Save General Remote Details</a></p></div>
  
  <div class="col-xs-2"></div>
  </div>

  <br>
  <div class="container">
        <div class="col-xs-2"></div>
        <div class="col-xs-8"><hr>
            <h4><p>Atomik Remote Details:</p></h4>   
  <table class="table table-striped">
  <thead>
    <tr>
        <td>
          <p>Username: </p>
        </td>
        <td><p><input type="text" class="form-control" id="remoteusername" value="Remote User"></p></td>
    </tr>  
  </thead>
    <tbody>
    <tr>
        <td><p>Password: </p></td>
        <td><p><input type="password" class="form-control" id="remotepassword1" value="password"></p></td>
      </tr>
      <tr>
        <td><p>Repeat Password: </p></td>
        <td><p><input type="password" class="form-control" id="remotepassword2" value="password"></p></td>
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
  <div class="col-xs-4 text-center"><p><a href="" class="btn-success btn">Save Atomik Remote Details</a></p></div>
  
  <div class="col-xs-2"></div>
  </div>
<br>
  <div class="container">
        <div class="col-xs-2"></div>
        <div class="col-xs-8"><hr>
            <h4><p>MiLight RF Remote Details:</p></h4>   
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
  <div class="col-xs-4 text-center"><a href=""  class="btn-warning btn">Listen for Remote</a></div>
  <div class="col-xs-4 text-center"><p><a href="" class="btn-success btn">Save MiLight RF Remote Details</a></p></div>
  
  <div class="col-xs-2"></div>
  </div>
<br>
  <div class="container">
        <div class="col-xs-2"></div>
        <div class="col-xs-8"><hr>
            <h4><p>MiLight Smartphone Remote Details:</p></h4>   
  <table class="table table-striped">
  <thead>
    <tr>
        <td>
          <p>MAC Address: </p>
        </td>
        <td><p><input type="text" class="form-control" id="macaddress" value="08:00:69:02:01:fc"></p></td>
    </tr>  
  </thead>
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
  <div class="col-xs-4 text-center"><p><a href="" class="btn-success btn">Save MiLight Smartphone Details</a></p></div>
  
  <div class="col-xs-2"></div>
  </div>
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
  <div class="col-xs-1"><a href="" class="btn-danger btn">Delete Remote</a>
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
