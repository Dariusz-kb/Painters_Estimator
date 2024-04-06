<?php
    //Start session
	session_start();
    //Unset the variables stored in session
	unset ($_SESSION['LOGGED']);
    unset ($_SESSION['SESS_USER_ID']);
    unset ($_SESSION['SESS_USERNAME']);
	unset ($_SESSION['SESS_PROJECT_ID']);
	session_destroy();

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
</head>
<body style="background-color: #F3F5FA;">
<div class="d-flex flex-row justify-content-between bg-info" id="login_check">
  <div class="p-2">
  <span style="font-size: 25px; color: White;"> Estimator </span>
  </div>
  <div class="p-2">
 <?php
		
		if(!isset($_SESSION['LOGGED'])) {
		 echo  "[ Not logged ]";
			}
		else {
			
			?>
			<a href="index.php?page=user_profile" style="text-decoration: none;">Welcome - <?php echo $_SESSION['SESS_USERNAME'];?></a>
			<a href="log_out.php"> [ logout ]</a>
				<?php
				}
	?>
  </div>
 </div>

<p align="center">&nbsp;</p>
<h4 align="center" class="err">You have been succesfully logged out.</h4>
<center><a class="btn btn-info btn-lg" href="index.php"> OK </a></center>
</body>
</html>