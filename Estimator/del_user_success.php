<?php

session_start();
	unset ($_SESSION['LOGGED']);
    unset ($_SESSION['SESS_USER_ID']);
    unset ($_SESSION['SESS_USERNAME']);
	unset ($_SESSION['SESS_PROJECT_ID']);
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> 
<link href="styles.css" type="text/css" rel="stylesheet">
</head>
<body>

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
<br>
<div class="container">
<center><span style="font-size: 40px; color: Red;">Your account has been deleted.</span></center>
</div>
<br>

<div class="container">
<center><a href="main.php"> Go to home page page </a></center>
</div>
</div>
</body>
</html>