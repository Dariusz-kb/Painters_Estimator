<?php

require_once('authorisation.php');
include("dbconnect.php");
if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
		echo '<center><span style="font-size: 40px; color: Red;"> Failed to add paint. </span></center>';
        foreach($_SESSION['ERRMSG_ARR'] as $msg) {
            echo '<center><span style="font-size: 20px; color: Tomato;">'.$msg.'</span></center>';
        }
        unset($_SESSION['ERRMSG_ARR']);
    }
	
?>


<br>
<div class="container col-md-6 bg-info">
<br>
<center><span style="font-size: 25px; color: White;">Paint details</span></center>
<br>
<form action="add_paint.php" id="newprojectForm" name="new_paint" method="post">


<div class="form-row">
<div class="form-group col-md-6 offset-md-3">
	<label for="base_type"><b>Paint base:</b></label>
  <input type="text" class="form-control form-control-lg" id="base_type" name="base_type" placeholder="Enter base type" required>
</div>
</div>

<div class="form-row">
<div class="form-group col-md-6 offset-md-3">
	<label for="paint_brand"><b>Paint brand:</b></label>
  <input type="text" class="form-control form-control-lg" id="paint_brand" name="paint_brand" placeholder="Enter brand" required>
</div>
</div>

<div class="form-row">
<div class="form-group col-md-6 offset-md-3">
	<label for="finish_type"><b>Paint finish:</b></label>
  <input type="text" class="form-control form-control-lg" id="finish_type" name="finish_type" placeholder="Enter finish type" required>
</div>
</div>

<div class="form-row">
<div class="form-group col-md-6 offset-md-3">
	 <label for="coverage_m2"><b>Paint coverage m2</b></label>
    <input type="number" class="form-control form-control-lg" id="coverage_m2" name="coverage_m2" placeholder="Enter coverage" required>
</div>
</div>

<div class="form-row">
<div class="form-group col-md-6 offset-md-3">
	 <label for="price"><b>Enter price per L:</b></label>
    <input type="number" min="0" step="0.01" class="form-control form-control-lg" id="price" name="price" placeholder="Enter price" required>
</div>
</div>

<div class="form-row justify-content-center">
	<button type="submit" class="btn btn-warning btn-lg"> Add paint </button>
</div>
<br>
 </form>
 
</div>
