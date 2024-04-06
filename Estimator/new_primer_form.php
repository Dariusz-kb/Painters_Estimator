<?php

require_once('authorisation.php');
include("dbconnect.php");
if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
		echo '<center><span style="font-size: 40px; color: Red;"> Failed to add primer. </span></center>';
        foreach($_SESSION['ERRMSG_ARR'] as $msg) {
            echo '<center><span style="font-size: 20px; color: Tomato;">'.$msg.'</span></center>';
        }
        unset($_SESSION['ERRMSG_ARR']);
    }
	
?>


<br>
<div class="container col-md-6 bg-info">
<br>
<center><span style="font-size: 25px; color: White;">Primer details</span></center>
<br>
<form action="add_primer.php" id="newprojectForm" name="new_item" method="post">


<div class="form-row">
<div class="form-group col-md-6 offset-md-3">
	<label for="primer_name"><b>Primer name:</b></label>
  <input type="text" class="form-control form-control-lg" id="primer_name" name="primer_name" placeholder="Enter primer name" required>
</div>
</div>

<div class="form-row">
<div class="form-group col-md-6 offset-md-3">
	<label for="primer_brand"><b>Primer brand:</b></label>
  <input type="text" class="form-control form-control-lg" id="primer_brand" name="primer_brand" placeholder="Enter primer brand" required>
</div>
</div>

<div class="form-row">
<div class="form-group col-md-6 offset-md-3">
	<label for="primer_base"><b>Primer base:</b></label>
  <input type="text" class="form-control form-control-lg" id="primer_base" name="primer_base" placeholder="Enter primer base" required>
</div>
</div>

<div class="form-row">
<div class="form-group col-md-6 offset-md-3">
	 <label for="primer_coverage"><b>Primer coverage m2</b></label>
    <input type="number" class="form-control form-control-lg" id="primer_coverage" name="primer_coverage" placeholder="Enter coverage m2" required>
</div>
</div>

<div class="form-row">
<div class="form-group col-md-6 offset-md-3">
	 <label for="primer_price"><b>Enter price per L:</b></label>
    <input type="number" min="0" step="0.01" class="form-control form-control-lg" id="primer_price" name="primer_price" placeholder="Enter price" required>
</div>
</div>

<div class="form-row justify-content-center">
	<button type="submit" class="btn btn-warning btn-lg"> Add primer </button>
</div>
<br>
</form>
 
</div>
