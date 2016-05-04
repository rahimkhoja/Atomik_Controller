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
          <h3>Add New Remote</h3>
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
            
  <table class="table table-striped">
  <thead>
    <tr>
        <td>
         <h4><p>Please Select Remote Type:</p></h4>
        </td>
        
    </tr>  
  </thead>
    <tbody>
    <tr>
        
        <td><p><select id="remotetype" name="remotetype" class="form-control">
  <option value="3">MiLight RGBW RF Remotes</option>
  <option value="2">Atomik API Remote</option>
  <option value="1">MiLight Smartphone Remote</option>
</select></p></td>
        
      </tr>
      </tbody>
  </table>
</div>
<div class="col-xs-2"></div></div>
<div class="container">
<div class="col-xs-2"></div>
  <div class="col-xs-4 text-center"></div>
  <div class="col-xs-4 text-center"><p></p></div>
  
  <div class="col-xs-2"></div>
  </div>

  <br><hr><div class="alert alert-success">
  <strong>Success!</strong> Indicates a successful or positive action.
</div><div class="alert alert-danger">
  <strong>Danger!</strong> Indicates a dangerous or potentially negative action.
</div><hr>
  <div class="container center">
  <div class="col-xs-2">
  </div>
  <div class="col-xs-1"><a href=""  class="btn-warning btn">Cancel</a>
  </div>
  <div class="col-xs-1"></div>
  <div class="col-xs-4">
  </div>
  <div class="col-xs-2 text-right"><a href="" class="btn-success btn">Save & Next</a>
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
