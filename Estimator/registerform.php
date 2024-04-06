<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body style="background-color: #F3F5FA;">
<div class="d-flex flex-row justify-content-between bg-info" id="login_check">
  <div class="p-2">
  <a href="index.php" style="text-decoration: none;"><span style="font-size: 25px; color: White;"> Estimator </span></a>
  </div>
  <div class="p-2">
	<a href="loginform.php" style="text-decoration: none;"><span style="font-size: 25px; color: White;"> [ Login ] </span></a>
  </div>
 </div>

<br>
<!-- open form container -->
<div class="container">
<?php
session_start();
if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
        echo '<center><span style="font-size: 40px; color: Tomato;"> Failed to Register</span></center>';
		foreach($_SESSION['ERRMSG_ARR'] as $msg) {
            echo '<center><span style="font-size: 20px; color: Tomato;">'.$msg.'</span></center>';
        }
        unset($_SESSION['ERRMSG_ARR']);
    }
?>


<form action="registerme.php" id="regForm" name="registerForm" method="post" align="center">
	
	
<div class="form-row">
    <div class="form-group col-md-6 offset-md-3">
      <label for="firstname">First name:</label>
      <input type="text" pattern="[a-zA-Z ]+" class="form-control form-control-lg" name="firstname" placeholder="Name" required>
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
      <label for="phone">Phone</label>
      <input type="text" pattern="[0-9]+" class="form-control form-control-lg" name="phone" placeholder="Phone" required>
    </div>
  </div>
  
    <div class="form-row">
    <div class="form-group col-md-6 offset-md-3">
      <label for="email">Email</label>
      <input type="email" class="form-control form-control-lg" name="email" placeholder="Email" required>
    </div>
  </div>
  
  <div class="form-row">
    <div class="form-group col-md-6 offset-md-3">
      <label for="housenumber">house number:</label>
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
      <input type="text" pattern="[a-zA-Z ]+" class="form-control form-control-lg" name="county" placeholder="County" required>
    </div>
</div>
  
  
  <div class="form-row">
  <div class="form-group col-md-6 offset-md-3">
    <label for="login">Login</label>
    <input type="text" pattern="[a-zA-Z0-9]{6,15}" class="form-control form-control-lg" name="login" placeholder="enter your login ..." required>
  <small id="passwordinfo" class="form-text text-muted">
  Your Login name must be 6-15 characters long, contain letters and numbers only.
</small>
  </div>
  
  </div>
  
  <div class="form-row">

  <div class="form-group col-md-3 offset-md-3">
    <label for="password">Password</label>
    <input type="password" pattern="[a-zA-Z0-9]{6,15}" class="form-control form-control-lg" id="password" name="password" placeholder="Enter password" required>
	<small id="passwordinfo" class="form-text text-muted">
  Your password must be 6-15 characters long, contain letters and numbers only.
</small>

 </div>
  <div class="form-group col-md-3">
    <label for="cpassword">Confirm password</label>
    <input type="password" class="form-control form-control-lg" id="cpass" name="cpassword" placeholder="Confirm password ..." required>
  </div>
  </div>
  <div class="form-row"> 
  <div class="form-group col-md-3 offset-md-3">
  <button type="submit" class="btn btn-info btn-lg">Register</button>
  </div>
  <div class="form-group col-md-3">
	<input class="btn btn-warning btn-lg" type="reset" value="Clear form">
	</div>
	</div>
</form>

<!-- close form container -->
</div>
</div>

</body>
</html>
