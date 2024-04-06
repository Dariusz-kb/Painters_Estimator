
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
	<a href="registerform.php" style="text-decoration: none;"><span style="font-size: 25px; color: White;"> Register </span></a> 
	<a href="loginform.php" style="text-decoration: none;"><span style="font-size: 25px; color: White;"> [ Login ] </span></a>
	</div>
 </div>
 
<br>
<?php
session_start();
if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
        foreach($_SESSION['ERRMSG_ARR'] as $msg) {
            echo '<center><span style="font-size: 20px; color: Tomato;">'.$msg.'</span></center>';
        }
        unset($_SESSION['ERRMSG_ARR']);
    }
?>
<div class="container col-md-6 text-center">

<h5> Password Reset </h5>
<form action="resetpassword.php" id="newprojectForm" name="newProject" method="post" align="center">
<div class="form-row">
    <div class="form-group col-md-6 offset-md-3">
      <label for="login">Enter login:</label>
      <input type="text" pattern="[a-zA-Z0-9]{6,15}" class="form-control form-control-lg" name="login" placeholder="Enter login" required>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-6 offset-md-3">
      <label for="password">Enter new password:</label>
      <input type="password" pattern="[a-zA-Z0-9]{6,15}" class="form-control form-control-lg" name="password" placeholder="Enter new password" required>
    <small id="passwordinfo" class="form-text text-muted">
  Your password must be 6-15 characters long, contain letters and numbers only.
</small>
	</div>
</div>
<div class="form-row">
    <div class="form-group col-md-6 offset-md-3">
      <label for="cpassword">Confirm new password:</label>
      <input type="password" min="1" class="form-control form-control-lg" name="cpassword" placeholder="Confirm new password" required>
    </div>
</div>
<div class="form-row"> 
  <div class="form-group col-md-6 offset-md-3">
  <button type="submit" class="btn btn-warning btn-lg">Reset Password</button>
  </div>

</form>




</div>
</body>
</html>