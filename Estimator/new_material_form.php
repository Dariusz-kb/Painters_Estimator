<?php

require_once('authorisation.php');
include("dbconnect.php");
if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
		echo '<center><span style="font-size: 40px; color: Red;"> Failed to add material. </span></center>';
        foreach($_SESSION['ERRMSG_ARR'] as $msg) {
            echo '<center><span style="font-size: 20px; color: Tomato;">'.$msg.'</span></center>';
        }
        unset($_SESSION['ERRMSG_ARR']);
    }
	
?>

<br>
<div class="container col-md-6 bg-info">
<br>
<center><span style="font-size: 25px; color: White;">Materials details</span></center>
<br>
<form action="add_material.php" id="newprojectForm" name="new_material" method="post">

<div class="form-row">
<div class="form-group col-md-6 offset-md-3">
	<label for="material"><b>Name of material</b></label>
  <input type="text" class="form-control form-control-lg" id="material" name="material" placeholder="Enter material" required>
</div>
</div>

<div class="form-row">
<div class="form-group col-md-6 offset-md-3">
	 <label for="price"><b>Material Price</b></label>
    <input type="number" min="0" step="0.01" class="form-control form-control-lg" id="price" name="price" placeholder="Enter price" required>
</div>
</div>



<div class="form-row justify-content-center">
	<button type="submit" class="btn btn-warning btn-lg"> Add material </button>
</div>
<br>
 </form>
 
</div>
