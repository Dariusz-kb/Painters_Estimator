<?php
//Include database configuration file
session_start();
require_once('authorisation.php');
include('dbconnect.php');
$user_id = $_SESSION['SESS_USER_ID'];

// get categories from database
if(isset($_POST["type_id"]) && !empty($_POST["type_id"])){
	
$sql = "SELECT * FROM category where type_id=".$_POST['type_id']." and user_id='$user_id'";
$result = $conn->query($sql);
if(!$result)die($conn->error);

$rows = $result->num_rows;
if(!$rows){
	echo '<option value="">Category not available</option>';
}
else{
	echo '<option value="">Select Category</option>';
	for($j=0; $j< $rows; ++$j)
	{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		echo '<option value="'.$row['cat_id'].'">'.$row['cat_name'].'</option >';

	}
	
	
}
}

// get all the items for category choosen
if(isset($_POST["cat_id"]) && !empty($_POST["cat_id"])){
	
	$sql = "SELECT * FROM items where cat_id=".$_POST['cat_id']." and user_id='$user_id'";
$result = $conn->query($sql);
if(!$result)die($conn->error);

$rows = $result->num_rows;
if(!$rows){
	echo '<option value="">Item not available</option>';
}
else{
	echo '<option value="">Select Item</option>';
for($j=0; $j< $rows; ++$j)
	{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		echo '<option value="'.$row['item_id'].'">'.$row['item_name'].'</option>';

	}
	
	
}
	
}
	
	// get the mesure and price for selected item
if(isset($_POST["item_id"]) && !empty($_POST["item_id"])){
	
	$sql = "SELECT measure_type FROM measure_price where item_id=".$_POST['item_id']." and user_id='$user_id'";
	$result = $conn->query($sql);
		if(!$result)die($conn->error);
		
	
		$rows = $result->num_rows;
		if ($rows > 0){
		for($j=0; $j< $rows; ++$j)
		{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$measure = $row['measure_type'];
		
		}
		
			if($measure == "linear"){
				echo "<label for='heigth'><b>Enter length:</b></label>";
				echo "<input type='number' min='0' step='0.01' class='form-control form-control-lg' id='length' name='length' placeholder='Enter length' required>";
				}
			if ($measure =="m2"){
				echo "<label for='heigth'><b>Enter height:</b></label><input type='number' min='0' step='0.01' class='form-control form-control-lg' id='heigth' name='heigth' placeholder='Enter heigth' required>";
				echo "<label for='width'><b>Enter width:</b></label><input type='number' min='0' step='0.01' class='form-control form-control-lg' id='width' name='width' placeholder='Enter width' required>";
				}
			if ($measure =="unit"){		
				echo "<label for='unit'><b>Enter number of units:</b></label>";
				echo "<input type='number' min='1' class='form-control form-control-lg' id='unit' name='unit' placeholder='Enter number of units' required>";
			}
			
		}
		else {
				echo '<p>measure not available</p>';
			}
		echo "<label for='no_coats'><b> Enter Number of coats:</b></label>";
		echo "<input type='number' min='1' class='form-control form-control-lg' id='no_coats' name='no_coats' placeholder='Enter total coats' required>";
		}
	
	// get the paint base type
if(isset($_POST["base_id"]) && !empty($_POST["base_id"])){
	
$sql = "SELECT * FROM brands where base_id=".$_POST["base_id"]." and user_id='$user_id'";
$result = $conn->query($sql);
if(!$result)die($conn->error);
$rows = $result->num_rows;
if(!$rows){
	echo '<option value="">Brand not available</option>';
}
else{
	echo '<option value="">Select Brand</option>';

for($j=0; $j< $rows; ++$j)
	{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		echo '<option value="'.$row['brand_id'].'">'.$row['brand_name'].'</option>';
	}

}
}

// get brand for base selected	
if(isset($_POST["brand_id"]) && !empty($_POST["brand_id"])){
	
$sql = "SELECT * FROM finish_type where brand_id=".$_POST["brand_id"]." and user_id='$user_id'";
$result = $conn->query($sql);
if(!$result)die($conn->error);
$rows = $result->num_rows;
if(!$rows){
	echo '<option value="">Finish not available</option>';
}
else{
	echo '<option value="">Select finish</option>';

for($j=0; $j< $rows; ++$j)
	{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		echo '<option value="'.$row['finish_id'].'">'.$row['finish_type'].'</option>';
	}

}
}

	$result->close();
	$conn->close();



?>
	
	
