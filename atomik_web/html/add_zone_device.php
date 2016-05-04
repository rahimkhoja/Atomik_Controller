<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Atomik Controller - Add Device to Zone</title>
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
        <li><a href="devices.php">Devices</a> </li>
        <li><a href="remotes.php">Remotes</a> </li>
        <li class="active"><a href="zones.php">Zones<span class="sr-only">(current)</span></a> </li>
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
          <h3>Add Device to Zone</h3>
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
        <td width="200" >
         <h4><p>Please Select Device:</p></h4>
        </td>
        <td><p> &nbsp; <p></td>
    </tr>  
  </thead>
    <tbody>
    <tr>
        <td colspan="2"><p><select id="devicetype" name="devicetype" class="form-control">
        <option value="16">Porch Light 2</option>
        <option value="16">Porch Light 1</option>
		<option value="16">Living Room Lamp 2</option>
		<option value="16">Living Room Lamp 1</option>
        <option value="16">Living Room Light 2</option>
        <option value="16">Living Room Light 1</option>
        <option value="15">Kitchen Light 3</option>
        <option value="14">Kitchen Light 2</option>
        <option value="13">Kitchen Light 1</option>
        <option value="12">Downstairs Bathroom Light 1</option>
        <option value="11">Downstairs Hallway Light 2</option>
        <option value="10">Downstairs Hallway Light 1</option>
        <option value="9">Bedroom 2 Light 2</option>
        <option value="8">Bedroom 2 Light 1</option>
        <option value="7">Upstairs Bathroom Light 2</option>
        <option value="6">Upstairs Bathroom Light 1</option>
        <option value="5">Upstairs Hallway Light 2</option>
        <option value="4">Upstairs Hallway Light 1<</option>
        <option value="3">Bedroom 1 Night Table Lamp</option>
  <option value="2">Bedroom 1 Light 2</option>
  <option value="1">Bedroom 1 Light 1</option>
</select></p></td>
      </tr>
      <tr>
      <td><p>Set Device to Zone Settings: </p>
      </td>
      <td> <p><input type="checkbox" id="zonedevicetype" name="zonedevtype" class="form-control"  width="80"></label></p> </td>
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
  <div class="col-xs-1"><a href="zones.php"  class="btn-warning btn">Cancel</a>
  </div>
  <div class="col-xs-1"></div>
  <div class="col-xs-4">
  </div>
  <div class="col-xs-2 text-right"><a href="" class="btn-success btn">Save</a>
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
