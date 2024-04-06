<?php
session_start();
require_once('authorisation.php');
include("dbconnect.php");
    //Array to store validation errors
    $errmsg_arr = array();

    //Validation error flag
    $errflag = false;

$est_id = $_SESSION['SESS_PROJECT_ID'];
$user_id = $_SESSION['SESS_USER_ID'];

// function to prevent escape characters being injected into a string 
    function escape($str, $connection) {		
        return $connection-> real_escape_string($str);
    }
	//  remove slashes, any HTML from, strip HTML entirely
	// stripp whitespace from the beginning and end 
	function sanitize($str)
	{
	if (get_magic_quotes_gpc())
	$str = stripslashes($str);
	$str = htmlentities($str);
	$str = strip_tags($str);
	$str = @trim($str); 
	return $str;
	}
	// function to clean inputs 
	function clean($str, $connection)
	{	
	$str= escape($str, $connection);
	$str = sanitize($str);
	return $str;
	}
	
    //Sanitize the POST values
	if(isset($_POST["worktype"]) && !empty($_POST["worktype"])){
	$work_type = clean($_POST['worktype'],$conn);
	}
	else {
		echo "Work_type not selected...";
	}
	if(isset($_POST["category"]) && !empty($_POST["category"])){
	$category = clean($_POST['category'],$conn);
	}
	else {
		echo "Category not selected...";
	}
	if(isset($_POST["item"]) && !empty($_POST["item"])){
	$item = clean($_POST['item'],$conn);
	}
	else {
		echo "Item not selected...";
	}
	// Get selected item name from database
	
	$qry = "SELECT item_name FROM items where item_id = '$item' and user_id= '$user_id' ";
	$result = $conn->query($qry);
	if (!$result) die ("Database access failed: " . $conn->error);
	$rows = $result->num_rows;
	for($j=0; $j< $rows; ++$j)
	{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$item_name= $row['item_name'];
		
	}
	
	// get area_m2 in order to calculate square meter area for linear measure type and units
	$qry = "SELECT area_m2 FROM measure_price where item_id = '$item' and user_id= '$user_id' ";
	$result = $conn->query($qry);
	if (!$result) die ("Database access failed: " . $conn->error);
	$rows = $result->num_rows;
	for($j=0; $j< $rows; ++$j)
	{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$area_m2= $row['area_m2'];
	}
	 // calculate total area of item. for linear total_area=length
	 // for unit measure type total_area=total number of units to paint.
	$total_area = 0;
	
	// verify the length 
	if(isset($_POST["length"]) && !empty($_POST["length"])){
		if(is_numeric($_POST['length'])) {
			$total_lenght=clean($_POST['length'],$conn);
			$total_area = $total_lenght;
			} 
			else {
				$errmsg_arr[] = "The length must be number";
				$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
				$errflag = true;
				}
			}
		// verify the heigth and width 
	if(isset($_POST["heigth"]) && isset($_POST["width"])){
		if(is_numeric($_POST['heigth']) && is_numeric($_POST['width'])) {
			$heigth= clean($_POST['heigth'],$conn);
			$width = clean($_POST['width'],$conn);
			// calculate total area and round it to 2 decimal places
			$total_area=$heigth * $width;
			$total_area = round($total_area, 2);
			} 
			else {
				$errmsg_arr[] = "The heigth and width must be numbers";
				$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
				$errflag = true;
				}
			}
			
		// validate unit is only digits
	if(isset($_POST["unit"]) && !empty($_POST["unit"])){
		if (ctype_digit($_POST['unit'])) {
		$total_units=clean($_POST['unit'],$conn);
		$total_area = $total_units;
		} else {
			$errmsg_arr[] = "Unit can contain only digits";
			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			$errflag = true;
			}
		}
		
	// get total number of coats and verify that coat number is a digit only
	if(isset($_POST["no_coats"]) && !empty($_POST["no_coats"])){
		if (ctype_digit($_POST['no_coats'])) {
		$no_coats=clean($_POST["no_coats"],$conn);
		} else {
			$errmsg_arr[] = "Number of coats  can contain only digits";
			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			$errflag = true;
			}
		}
		
	// get measure price and time needed to compleate painting selected item
	$qry = "SELECT measure_price, time_minutes FROM measure_price where item_id = '$item' and user_id='$user_id' ";
	$result = $conn->query($qry);
	if (!$result) die ("Database access failed: " . $conn->error);
	$rows = $result->num_rows;
	for($j=0; $j< $rows; ++$j)
	{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$price_per_area = $row['measure_price'];
		$time_minutes = $row['time_minutes'];
		
	}
	
	$prep_hour_price = 0;
	// get preparation price per hour of labour of preparation works
	$qry = "SELECT prep_price FROM labour_price where user_id = '$user_id' ";
			$result = $conn->query($qry);
			if (!$result) die ("Database access failed: " . $conn->error);
			$rows = $result->num_rows;
				for($j=0; $j< $rows; ++$j)
				{
				$result->data_seek($j);
				$row = $result->fetch_array(MYSQLI_ASSOC);
				$prep_hour_price = $row['prep_price'];
				}	
		
		
		
	// paint details. If add_paint = yes then get base_type, paint_brand and finish_type
	if(isset($_POST["add_paint"])){
		$add_paint="yes";
		if($add_paint="yes"){
		if(isset($_POST["base_type"])){
		$base_id=clean($_POST["base_type"],$conn);
		$qry = "SELECT base_type FROM base_type where base_id = '$base_id' and user_id= '$user_id'";
		$result = $conn->query($qry);
		$result = $conn->query($qry);
		if (!$result) die ("Database access failed: " . $conn->error);
		$rows = $result->num_rows;
		for($j=0; $j< $rows; ++$j)
		{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$base_type = $row['base_type'];
		
		}
		}
		
		if(isset($_POST["brand"]) && !empty($_POST["brand"])){
		$brand_id=clean($_POST["brand"],$conn);
		$qry = "SELECT brand_name FROM brands where brand_id = '$brand_id' and user_id= '$user_id'";
		$result = $conn->query($qry);
		$result = $conn->query($qry);
		if (!$result) die ("Database access failed: " . $conn->error);
		$rows = $result->num_rows;
		for($j=0; $j< $rows; ++$j)
		{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$brand_name = $row['brand_name'];
		
		}
		}
		if(isset($_POST["finish"]) && !empty($_POST["finish"])){
		$finish_id=clean($_POST["finish"],$conn);
		$qry = "SELECT finish_type FROM finish_type where finish_id = '$finish_id' and user_id= '$user_id'";
		$result = $conn->query($qry);
		$result = $conn->query($qry);
		if (!$result) die ("Database access failed: " . $conn->error);
		$rows = $result->num_rows;
		for($j=0; $j< $rows; ++$j)
		{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$finish_type = $row['finish_type'];
		
		}
		}
		
		// get the coverage and price of selected paint and calculate the amount of paint needed and paint price
		$paint_needed=0;
		$qry = "SELECT coverage_m2, price FROM paint_info where base_id = '$base_id' and brand_id='$brand_id' and finish_id = '$finish_id' and user_id= '$user_id'";
		$result = $conn->query($qry);
		$result = $conn->query($qry);
		if (!$result) die ("Database access failed: " . $conn->error);
		$rows = $result->num_rows;
		for($j=0; $j< $rows; ++$j)
		{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		
		$coverage_m2 = $row['coverage_m2'];
		$paint_price = $row['price'];
		}
		// calculate total paint needed and round it to 2 decimal places
		$paint_needed= ($total_area * $area_m2 * $no_coats)/$coverage_m2;
		$paint_needed = round($paint_needed, 2);
		$paint_price = $paint_needed * $paint_price;
		$paint_price = round($paint_price, 2);
		
		}
		
		}	
	// else set values so they wont throw error
		else {
		$add_paint="no";
		$paint_needed=0;
		$paint_price=0;
		$paint_needed=0;
		$brand_name ="";
		$finish_type="";
		$base_type="";
		
		}
		
		// if add primer=yes get the primer data from database else set the data so wont throw errors
	if(isset($_POST["add_primer"])){
		$add_primer="yes";
		
		if($add_primer="yes"){

		if(isset($_POST["primer_select"]) && !empty($_POST['primer_select'])){
		$primer_id=clean($_POST["primer_select"],$conn);
		$primer_needed=0;	
		$priming_time = 0;
		
		$qry = "SELECT * FROM primers_undercoats where primer_id = '$primer_id' and user_id= '$user_id'";
		$result = $conn->query($qry);
		if (!$result) die ("Database access failed: " . $conn->error);
		$rows = $result->num_rows;
		for($j=0; $j< $rows; ++$j)
		{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$primer_name = $row['primer_name'];
		$primer_brand = $row['primer_brand'];
		$primer_base = $row['primer_base'];
		$primer_coverage = $row['primer_coverage'];
		$primer_price = $row['primer_price'];
		}
		
		// calculate total primer needed and primer price
		$primer_needed= ($total_area * $area_m2)/$primer_coverage;
		$primer_needed = round($primer_needed, 2);
		$primer_price = $primer_needed * $primer_price;
		$primer_price = round($primer_price, 2);
		
		// calculate total time of priming
		$priming_time = ($total_area * $time_minutes)/60;
		$priming_time = round($priming_time, 2);
	
		}
		// else set values so they wont throw error
		else {
			$priming_time = 0;
			$primer_needed=0;
			$primer_price = 0;
			$primer_name ="";
			$primer_brand ="";
			$primer_base ="";
			$add_primer="no";
		}
		}
		}
	// else set values so they wont throw error
	else {
		$priming_time = 0;
		$primer_needed=0;
		$primer_price = 0;
		$primer_name ="";
		$primer_brand ="";
		$primer_base =""; 
		$add_primer="no";
		}
	
		// if add materials get the multiple materials data, calculate total materials price
		// and create string from it all_materials. Else set data so wont throw errors.
	if(isset($_POST["add_material"])){
		$add_material="yes";
		if ($add_material="yes"){
		if(isset($_POST['materials']) && !empty($_POST['materials'])){
			$material=$_POST['materials'];  
			$all_materials ="";
			$material_price=0;
			$materials_price = 0;
				
		foreach($material as $selected)  
		{  
			$selected =	clean($selected ,$conn);
			$qry = "SELECT price FROM materials where type ='$selected' and user_id='$user_id' ";
			$result = $conn->query($qry);
			if (!$result) die ("Database access failed: " . $conn->error);
			$rows = $result->num_rows;
				for($j=0; $j< $rows; ++$j)
				{
				$result->data_seek($j);
				$row = $result->fetch_array(MYSQLI_ASSOC);
				$material_price = $row['price'];
		
				}
			$materials_price = $materials_price + $material_price;
			$all_materials .= $selected.","; 
			//$material_price
		}  
		}
		else {
			$add_material="no";
			$all_materials ="";
			$material_price=0;
			$materials_price = 0;
		}
	}
	}
	else {
		$add_material="no";
		$all_materials="";
		$material_price = 0;
		$materials_price = 0;
		}
	// add preparation works and total prep time	
	if(isset($_POST["add_prep"])){
		$add_prep="yes";
		if ($add_prep="yes"){
		
		$all_prep ="";
		if(isset($_POST['prep'])&& !empty($_POST['prep'])){
			$prep=$_POST['prep'];  
			  
		foreach($prep as $selected)  
		{  
			$all_prep .= $selected.",";  
		} 
		
			
			// validate that if prep time is set and is a number
		if(isset($_POST['prep_time'])&& !empty($_POST['prep_time'])){
			if(is_numeric($_POST['prep_time'])) {
				$prep_time=$_POST['prep_time'];
				} else { 
					$errmsg_arr[] = "The Preparation time be a number";
					$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
					$errflag = true;
			} 
			
			}
		
		}
		else {
			$all_prep="";
			$add_prep="no";
			$prep_time=0;
		}
		
		}
		else {
			$add_prep="no";
			$all_prep ="";
		}
	}
	else {
		$add_prep="no";
		$all_prep="";
		$prep_time=0;
		$prep_price = 0;
		}
		

	// calculate prep_price, total painting and priming time and total time to compleate project
	// painting price and total price of project
	$prep_price = 0;
	$prep_price = $prep_hour_price * $prep_time;
	$prep_price = round($prep_price, 2);
	
	$painting_time= ($total_area * $no_coats * $time_minutes)/60;
	$painting_time = round($painting_time, 2);
	
	$total_time = $painting_time + $prep_time + $priming_time;
	$total_time = round($total_time, 2);

	$painting_price = 0;
	$painting_price = $price_per_area * $total_area * $no_coats;
	$painting_price = round($painting_price, 2);
	
		
	$total_price = 0;
	$total_price = $painting_price + $materials_price + $prep_price + $paint_price + $primer_price;
	$total_price = round($total_price, 2);

	 //If there are input validations, redirect back to the create_estimate
    if($errflag) {
        $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
        session_write_close();
        header("location: index.php?page=create_estimate");
        exit();
    }
	
	
	//insert data into database
	
	$qry = "INSERT INTO estimates(estimate_id, user_id, item_name, total_area, no_coats, painting_price, painting_time, include_paint, paint_brand, finish_type, paint_base, paint_amount, paint_price, include_primer, primer_name, primer_brand, primer_base, primer_amount, primer_price, primer_time, include_materials, materials, materials_price, include_prep, prep, prep_time, prep_price, total_time, total_price)
	VALUES('$est_id', '$user_id', '$item_name', '$total_area', '$no_coats','$painting_price', '$painting_time', '$add_paint', '$brand_name', '$finish_type', '$base_type', '$paint_needed', '$paint_price', '$add_primer','$primer_name', '$primer_brand', '$primer_base', '$primer_needed', '$primer_price', '$priming_time', '$add_material','$all_materials', '$materials_price', '$add_prep', '$all_prep', '$prep_time', '$prep_price', '$total_time', '$total_price')";
	$result = $conn->query($qry);
	if (!$result) die ("Database access failed: ". $conn->error);
	// if the query was successfully added to database then go to estimate wiev page
	header("location: index.php?page=estimate_view");

?>
