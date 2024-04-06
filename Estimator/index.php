<?php
session_start();
if(!isset($_SESSION['LOGGED'])) {
		header("location: main.php");
		exit();
		}
	else{
require_once('authorisation.php');
	}	
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
  
 <?php
	if(!isset($_SESSION['LOGGED'])) {
	 echo  "[ Not logged in ]";
	}
	else {
		echo "<a href='index.php?page=user_profile' style='text-decoration: none;'>";
		echo " Welcome - ".$_SESSION['SESS_USERNAME']."</a><a href='log_out.php'> [ logout ]</a>";
			}
	?>
	
  </div>
 </div>


<br>

<div class="container">	

<nav>
  <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">
    <a class="nav-item nav-link" id="nav-open-tab"  href="index.php?page=open-project" role="tab"  aria-controls="nav-open" aria-selected="false"><span style="font-size: 35px; color: Tomato;"><i class="fas fa-door-open"></i></span></a>
    <a class="nav-item nav-link" id="nav-contact-tab" href="index.php?page=costumers_info" role="tab" aria-controls="nav-contact" aria-selected="false"><span style="font-size: 35px; color: Tomato;"><i class="far fa-address-book"></i></span></a>
     <a class="nav-item nav-link" id="nav-estimates-tab" href="index.php?page=new-projectForm"  role="tab" aria-controls="nav-estimates" aria-selected="false"><span style="font-size: 35px; color: Tomato;"><i class="fas fa-calculator"></i></span></a>
 	 <a class="nav-item nav-link" id="nav-settings-tab" href="index.php?page=settings" role="tab" aria-controls="nav-settings" aria-selected="false"><span style="font-size: 35px; color: Tomato;"><i class="fas fa-cogs"></i></span></a>
	</div>
</nav>

</div>

<div class="container">
<?php
if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
        foreach($_SESSION['ERRMSG_ARR'] as $msg) {
            echo '<center><span style="font-size: 20px; color: Tomato;">'.$msg.'</span></center>';
        }
        unset($_SESSION['ERRMSG_ARR']);
    }
?>
</div>


<div id="page_content" class='container'>

 	<?php
		if(!isset($_GET['page'])) {
			include("open-project.php");
			}
		else {
			$page=$_GET['page'];
			include("$page.php");
				}

	?>

</div>

</body>
</html>