<?php

require_once('authorisation.php');
include("dbconnect.php");
if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
		echo '<center><span style="font-size: 40px; color: Red;"> Failed to add preparation. </span></center>';
        foreach($_SESSION['ERRMSG_ARR'] as $msg) {
            echo '<center><span style="font-size: 20px; color: Tomato;">'.$msg.'</span></center>';
        }
        unset($_SESSION['ERRMSG_ARR']);
    }
	
?>
<br>
<div class="container col-md-6 bg-info">
<br>
<center><span style="font-size: 25px; color: White;">Preparaton details</span></center>
<br>
<form action="add_prep.php" id="newprojectForm" name="add_prep" method="post">

<div class="form-row">
<div class="form-group col-md-6 offset-md-3">
	<label for="prep_name"><b>Name of preparation</b></label>
  <input type="text" class="form-control form-control-lg" id="prep_name" name="prep_name" placeholder="Enter preparation" required>
</div>
</div>

<div class="form-row">
<div class="form-group col-md-6 offset-md-3">
	 <label for="prep_description"><b>Description</b></label> 
	<textarea class="form-control form-control-lg" rows="3" id="prep_description" name="prep_description" placeholder="Enter description" required></textarea>
</div>
</div>



<div class="form-row justify-content-center">
	<button type="submit" class="btn btn-warning btn-lg"> Add preparation</button>
</div>
<br>
</form>
 
</div>
