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
        <li><a href="#">Zones</a> </li>
        <li class="active"><a href="#">Scheduled Tasks</a> </li>
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
          <h3>Scheduled Task Details</h3>
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
            <h4><p>General Task Details:</p></h4>   
  <table class="table table-striped">
  <thead>
    <tr>
        <td>
          <p>Task Name: </p>
        </td>
        <td><p><input type="text" class="form-control" id="devicename" value="Turn OFF Porch Lights - Morning"></p></td>
    </tr>  
  </thead>
    <tbody>
    <tr>
        <td><p>Task Description: </p></td>
        <td><p><textarea class="form-control" rows="4" cols="1">Turn off porch lights in the morning at 8 am everyday.
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
  <div class="col-xs-4 text-center"><p><a href="" class="btn-success btn">Save General Task Details</a></p></div>
  
  <div class="col-xs-2"></div>
  </div>

  <br>
  <div class="container">
        <div class="col-xs-2"></div>
        <div class="col-xs-8"><hr>
            <h4><p>Task Properties:</p></h4>
  <table class="table table-striped">
  <thead>
    <tr>
        <td>
          <p>Task Zone: </p>
        </td>
        <td><p><select id="devicestatus" class="form-control">
        <option value="11">Porch Lights</option>
        <option value="10">Living Room Lamps</option>
        <option value="9">Living Room Lights</option>
        <option value="8">Kitchen Lights</option>
        <option value="7">Downstairs Bathroom Light</option>
        <option value="6">Downstairs Hallway Lights</option>
        <option value="5">Bedroom 2 Lights</option>
        <option value="4">Upstairs Bathroom Lights</option>
        <option value="3">Upstairs Hallway Lights</option>
        <option value="2">Bedroom 1 Lamp</option>
  <option value="1">Bedroom 1 Lights</option>
  <option value="0">Please Choose Zone</option>
</select></p></td>
    </tr> 
  </thead>
    <tbody> <tr>
        <td>
          <p>Task Status: </p>
        </td>
        <td><p><select id="devicestatus" class="form-control">
  <option value="1">ON</option>
  <option value="0">OFF</option>
</select></p></td>
    </tr>  
    <tr>
        <td>
          <p>Task Color Mode: </p> - Multiple Colour Mode Bulbs
        </td>
        <td><p><select id="eth0status" class="form-control">
  <option value="1">White Mode</option>
  <option value="0">Color Mode</option>
</select></p></td>
    </tr> 
    
    <tr>
        <td>
          <p>Task Color Mode: </p> - Single Mode Bulbs
        </td>
           
        <td><p><center><b>White Mode</b></center></p></td>
    </tr> <tr>
        <td>
          <p>Task Brightness (0-100): </p>
        </td>
        <td><p><input type="text" class="form-control" id="remoteusername" value="100"></p></td>
    </tr> 
    <tr>
        <td>
          <p>Task Color (0-255): </p>- Only Avaiable for RGB Bulbs
        </td>
        <td><p><input type="text" class="form-control" id="remoteusername" value="1"></p></td>
    </tr>
    <tr>
        <td>
          <p>Task White Temperature (2700-6500):</p>- Only Available for Dual White Bulbs
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
  <div class="col-xs-4 text-center"><p><a href="" class="btn-success btn">Save Task Properties</a></p></div>
  
  <div class="col-xs-2"></div>
  </div>
<br>
  <div class="container">
        <div class="col-xs-2"></div>
        <div class="col-xs-8"><hr>
            <h4><p>Task Schedule:</p></h4><p> * Mutiple Choice Inputs</p>
            </div>
            <div class="col-xs-2"></div>
            </div>
            <div class="container">
            <div class="col-xs-2"></div>
            <div class="col-xs-4">
  <table class="table table-striped">
  <thead>
    <tr>
        <td>
          <p>Month: </p>
        </td>
        <td><p><select class="form-control" id="taskmonth" name="taskmonth" multiple>
  <option selected value="*">Every Month</option>
  <option value="1">January</option>
  <option value="2">February</option>
  <option value="3">March</option>
  <option value="4">April</option>
  <option value="5">May</option>
  <option value="6">June</option>
  <option value="7">July</option>
  <option value="8">August</option>
  <option value="9">September</option>
  <option value="10">October</option>
  <option value="11">November</option>
  <option value="12">December</option>
</select></p></td>
    </tr>
  </thead>
    <tbody>
      <tr>
        <td><p>Weekday: </p></td>
        <td><p><select class="form-control" id="taskweekday" name="taskweekday" multiple>
  <option selected value="*">Every Day</option>
  <option value="0">Sunday</option>
  <option value="1">Monday</option>
  <option value="2">Tuesday</option>
  <option value="3">Wednesday</option>
  <option value="4">Thursday</option>
  <option value="5">Friday</option>
  <option value="6">Saturday</option>
</select></p></td>
      </tr>
      <tr>
        <td><p>Minute: </p></td>
        <td><p><select class="form-control" id="taskday" name="taskday" multiple>
  <option value="*">Every Minute</option>
  <option selected value="0">0</option>
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
  <option value="5">5</option>
  <option value="6">6</option>
  <option value="7">7</option>
  <option value="8">8</option>
  <option value="9">9</option>
  <option value="10">10</option>
  <option value="11">11</option>
  <option value="12">12</option>
  <option value="13">13</option>
  <option value="14">14</option>
  <option value="15">15</option>
  <option value="16">16</option>
  <option value="17">17</option>
  <option value="18">18</option>
  <option value="19">19</option>
  <option value="20">20</option>
  <option value="21">21</option>
  <option value="22">22</option>
  <option value="23">23</option>
  <option value="24">24</option>
  <option value="25">25</option>
  <option value="26">26</option>
  <option value="27">27</option>
  <option value="28">28</option>
  <option value="29">29</option>
  <option value="30">30</option>
  <option value="31">31</option>
  <option value="32">32</option>
  <option value="33">33</option>
  <option value="34">34</option>
  <option value="35">35</option>
  <option value="36">36</option>
  <option value="37">37</option>
  <option value="38">38</option>
  <option value="39">39</option>
  <option value="40">40</option>
  <option value="41">41</option>
  <option value="42">42</option>
  <option value="43">43</option>
  <option value="44">44</option>
  <option value="45">45</option>
  <option value="46">46</option>
  <option value="47">47</option>
  <option value="48">48</option>
  <option value="49">49</option>
  <option value="50">50</option>
  <option value="51">51</option>
  <option value="52">52</option>
  <option value="53">53</option>
  <option value="54">54</option>
  <option value="55">55</option>
  <option value="56">56</option>
  <option value="57">57</option>
  <option value="58">58</option>
  <option value="59">59</option>
</select></p></td>
      </tr>
      </tbody>
  </table>
</div><div class="col-xs-4">
  <table class="table table-striped">
  <thead>
    <tr>
        <td><p>Day: </p></td>
        <td><p><select class="form-control" id="taskday" name="taskday" multiple>
  <option selected value="*">Every Day</option>
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
  <option value="5">5</option>
  <option value="6">6</option>
  <option value="7">7</option>
  <option value="8">8</option>
  <option value="9">9</option>
  <option value="10">10</option>
  <option value="11">11</option>
  <option value="12">12</option>
  <option value="13">13</option>
  <option value="14">14</option>
  <option value="15">15</option>
  <option value="16">16</option>
  <option value="17">17</option>
  <option value="18">18</option>
  <option value="19">19</option>
  <option value="20">20</option>
  <option value="21">21</option>
  <option value="22">22</option>
  <option value="23">23</option>
  <option value="24">24</option>
  <option value="25">25</option>
  <option value="26">26</option>
  <option value="27">27</option>
  <option value="28">28</option>
  <option value="29">29</option>
  <option value="30">30</option>
  <option value="31">31</option>
</select></p></td>
      </tr>  
  </thead>
    <tbody>
    <tr>
        <td><p>Hour: </p></td>
        <td><p><select class="form-control" id="taskday" name="taskday" multiple>
  <option value="*">Every Hour</option>
  <option value="0">0</option>
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
  <option value="5">5</option>
  <option value="6">6</option>
  <option value="7">7</option>
  <option selected value="8">8</option>
  <option value="9">9</option>
  <option value="10">10</option>
  <option value="11">11</option>
  <option value="12">12</option>
  <option value="13">13</option>
  <option value="14">14</option>
  <option value="15">15</option>
  <option value="16">16</option>
  <option value="17">17</option>
  <option value="18">18</option>
  <option value="19">19</option>
  <option value="20">20</option>
  <option value="21">21</option>
  <option value="22">22</option>
  <option value="23">23</option>
</select></p></td>
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
  <div class="col-xs-2 text-center"></div>
  <div class="col-xs-2 text-center"></div>
  <div class="col-xs-4 text-center"><p><a href="" class="btn-success btn">Save Task Schedule</a></p></div>
  
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
  <div class="col-xs-1"><a href=""  class="btn-warning btn">Cancel</a>
  </div>
  <div class="col-xs-1"><a href="" class="btn-danger btn">Delete Scheduled Task</a>
  </div>
  <div class="col-xs-4">
  </div>
  <div class="col-xs-2 text-right"><a href="" class="btn-success btn">Save All Task Details</a>
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
