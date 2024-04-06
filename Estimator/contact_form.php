<?php
require_once('authorisation.php');
if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
        foreach($_SESSION['ERRMSG_ARR'] as $msg) {
            echo '<center><span style="font-size: 20px; color: Tomato;">'.$msg.'</span></center>';
        }
        unset($_SESSION['ERRMSG_ARR']);
    }
// check if if there was redirect from project page to add contact to project
	if(isset($_GET["data"]))
    {
       $_SESSION['SESS_PROJECT_ID'] = $_GET["data"];
        
    }	
	
?>


<!-- open form container -->
<br>
<div class="container col-md-6 bg-info">
<br>
<center><span style="font-size: 25px; color: White;">Enter client details.</span></center>
<br>
<form action="new_contact.php" id="newprojectForm" name="newcontact" method="post" align="center">

<div class="form-row">
    <div class="form-group col-md-6 offset-md-3">
      <label for="firstname">First name:</label>
      <input type="text" pattern="[a-zA-Z ]+" class="form-control form-control-lg" name="firstname" placeholder="First Name" required>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-6 offset-md-3">
      <label for="surname">Surname:</label>
      <input type="text" pattern="[a-zA-Z ]+" class="form-control form-control-lg" name="surname" placeholder="Surname" required>
    </div>
</div>
	
<div class="form-row">
    <div class="form-group col-md-6 offset-md-3">
      <label for="phone">Phone number:</label>
      <input type="text" pattern="[0-9]+" class="form-control form-control-lg" name="phone" placeholder="Phone number" >
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-6 offset-md-3">
      <label for="email">E-mail:</label>
      <input type="email" class="form-control form-control-lg" name="email" placeholder="E-mail" required>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-6 offset-md-3">
      <label for="housenumber">House number:</label>
      <input type="text" pattern="[0-9]+" class="form-control form-control-lg" name="housenumber" placeholder="House number" required>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-6 offset-md-3">
      <label for="street">Street name:</label>
      <input type="text" pattern="[a-zA-Z ]+" class="form-control form-control-lg" name="street" placeholder="Street Name" required>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-6 offset-md-3">
      <label for="city">City:</label>
      <input type="text" pattern="[a-zA-Z ]+" class="form-control form-control-lg" name="city" placeholder="City" required>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-6 offset-md-3">
      <label for="county">County:</label>
      <input type="text" pattern="[a-zA-Z ]+" class="form-control form-control-lg" name="county" placeholder="County" >
    </div>
</div>
<div class="form-row justify-content-center">
  <button type="submit" class="btn btn-warning btn-lg">Next</button>
</div>
<br>
</form>
<!-- close form container -->
</div>
