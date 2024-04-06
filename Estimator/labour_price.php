<div class="container col-md-6 bg-info">
<form action="add_labour_price.php" id="newprojectForm" name="add_labour_price" method="post">
<?php

require_once('authorisation.php');
include("dbconnect.php");
if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
        foreach($_SESSION['ERRMSG_ARR'] as $msg) {
            echo '<center><span style="font-size: 20px; color: Tomato;">'.$msg.'</span></center>';
        }
        unset($_SESSION['ERRMSG_ARR']);
    }
	

$user_id = $_SESSION['SESS_USER_ID'];

// check the current rate per hour of labour
$qry = "SELECT prep_price FROM labour_price where user_id= '$user_id'";
	$result = $conn->query($qry);
	if (!$result) die ("Database access failed: " . $conn->error);
	$rows = $result->num_rows;
	if($result->num_rows == 1) {
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$prep_price = $row['prep_price'];
		?>
		<br>
		<div class="form-row">
		<div class="form-group col-md-6 offset-md-3">
			<li class="list-group-item list-group-item-info">Your current rate per hour of labour is &euro;<?php echo $prep_price;?></li>
		</div>
		</div>
		
		<div class="form-row">
	<div class="form-group col-md-6 offset-md-3">
	 <label for="change_price"><b>Enter the price per hour of labour:</b></label>
    <input type="number" min="0" step="0.01"  class="form-control form-control-lg" id="change_price" name="change_price" placeholder="Enter new price" required>
	</div>
	</div>
	
		<?php
		}
		
		// if not set up yet then get user entry
		else {
			?>
			<br>
			<div class="form-row">
		<div class="form-group col-md-6 offset-md-3">
		<li class="list-group-item list-group-item-warning">You didnt set the rate yet.</li>
		</div>
		</div>
			
		<div class="form-row">
	<div class="form-group col-md-6 offset-md-3">
	 <label for="labour_price"><b>Enter the price per hour of labour:</b></label>
    <input type="number" min="0" step="0.01" class="form-control form-control-lg" id="labour_price" name="labour_price" placeholder="Enter price" required>
	</div>
	</div>

		<?php
		}
?>	

<div class="form-row justify-content-center">
	<button type="submit" class="btn btn-warning btn-lg"> Submit </button>
</div>
<br>
</form>	
</div>	