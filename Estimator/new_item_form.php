<?php

require_once('authorisation.php');
include("dbconnect.php");
if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
		echo '<center><span style="font-size: 40px; color: Red;"> Failed to add item. </span></center>';
        foreach($_SESSION['ERRMSG_ARR'] as $msg) {
            echo '<center><span style="font-size: 20px; color: Tomato;">'.$msg.'</span></center>';
        }
        unset($_SESSION['ERRMSG_ARR']);
    }
	
?>

<div class="container col-md-6 bg-info">
<br>
<center><span style="font-size: 25px; color: White;">Item details.</span></center>
<br>
<form action="add_item.php" id="newprojectForm" name="new_item" method="post">

<div class="form-row">
	<div class="form-group col-md-6 offset-md-3">
	<label for="worktype"><b>Type of work:</b></label>
    <select class="form-control form-control-lg" id="worktype" name="worktype" required>
	<option value="">Select type of work: </option>
	<?php
$sql = "SELECT * FROM work_type";
$result = $conn->query($sql);
if(!$result)die($conn->error);

$rows = $result->num_rows;
for($j=0; $j< $rows; ++$j)
	{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		echo '<option value="'.$row['type_id'].'">'.$row['type'].'</option>';

	}

		?>
	</select>
</div>
</div>

<div class="form-row">
<div class="form-group col-md-6 offset-md-3">
	<label for="category"><b>Category:</b></label>
  <input type="text" pattern="[a-zA-Z ]+" class="form-control form-control-lg" id="category" name="category" placeholder="Enter category" required>
</div>
</div>


<div class="form-row">
<div class="form-group col-md-6 offset-md-3">
	<label for="item"><b>Item name:</b></label>
  <input type="text" pattern="[a-zA-Z0-9 ]+" class="form-control form-control-lg" id="item" name="item" placeholder="Enter item name" required>
</div>
</div>

<div class="form-row">
	<div class="form-group col-md-6 offset-md-3">
 <label for="measure_type"><b>Measure type:</b></label>
    <select class="form-control form-control-lg" id="measure_type" name="measure_type" placeholder="Enter measure type" required>
	<option value="">Select measure type: </option>
	<option value="linear">linear</option>
	<option value="unit">unit</option>
	<option value="m2">area</sup></option>
	</select>
</div>
</div>

<div class="form-row">
<div class="form-group col-md-6 offset-md-3">
	 <label for="area_m2"><b>Enter area in m<sup style="vertical-align: super; font-size: smaller;">2</sup> per unit</b></label>
    <input type="number" min="0" step="0.01" class="form-control form-control-lg" id="area_m2" name="area_m2" placeholder="Enter area" required>
</div>
</div>

<div class="form-row">
<div class="form-group col-md-6 offset-md-3">
	 <label for="measure_price"><b>Enter unit price per coat</b></label>
    <input type="number" min="0" step="0.01" class="form-control form-control-lg" id="measure_price" name="measure_price" placeholder="Enter price" required>
</div>
</div>

<div class="form-row">
<div class="form-group col-md-6 offset-md-3">
	 <label for="item_time"><b>Enter time per unit in minutes</b></label>
    <input type="number" min="0" step="0.01" class="form-control form-control-lg" id="item_time" name="item_time" placeholder="Enter time" required>
</div>

</div>


<div class="form-row justify-content-center">
	<button type="submit" class="btn btn-warning btn-lg"> Add item </button>
</div>
<br>
</form>
 
</div>
