<?php
session_start();
require_once('authorisation.php');
   include("dbconnect.php");
    //Array to store validation errors
    $errmsg_arr = array();
    //Validation error flag
    $errflag = false;

    function clean($str, $connection) {
        return $connection->real_escape_string($str);
    }
		
    //Sanitize the POST values
	$user_id = $_SESSION['SESS_USER_ID'];
    $base_type = clean($_POST['base_type'],$conn);
    $paint_brand = clean($_POST['paint_brand'],$conn);
	$finish_type = clean($_POST['finish_type'],$conn);
	
	// verify time coverage_m2 
	if(isset($_POST["coverage_m2"]) && !empty($_POST["coverage_m2"])){
		if(is_numeric($_POST['coverage_m2'])) {
			$coverage_m2 = clean($_POST['coverage_m2'],$conn);
			} 
			else {
				$errmsg_arr[] = "The coverage_m2 must be numeric";
				$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
				$errflag = true;
				}
			}
	
	// verify time price 
	if(isset($_POST["price"]) && !empty($_POST["price"])){
		if(is_numeric($_POST['price'])) {
			$price = clean($_POST['price'],$conn);
			} 
			else {
				$errmsg_arr[] = "The price must be numeric";
				$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
				$errflag = true;
				}
			}
	
	// check if base_type already exists if it does get the base_type id number
	$qry = "SELECT base_id FROM base_type where base_type = '$base_type' and user_id= '$user_id' ";
	$result = $conn->query($qry);
	if (!$result) die ("Database access failed: " . $conn->error);
	if($result->num_rows == 1) {
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$base_id = $row['base_id'];
		}
		// if base_type doesnt exists add new base_type into data base and get its id number
		else {
				$qry = "INSERT INTO base_type(base_type, user_id) VALUES('$base_type', '$user_id')";
				$result = $conn->query($qry);
				if (!$result) die ("Database access failed: " . $conn->error);
				$qry = "SELECT base_id FROM base_type where base_type = '$base_type' and user_id= '$user_id'";
				$result = $conn->query($qry);
				if (!$result) die ("Database access failed: " . $conn->error);
				if($result->num_rows == 1) {
				$row = $result->fetch_array(MYSQLI_ASSOC);
				$base_id = $row['base_id'];
				}
			}
			
		// check if paint_brand user is trying to add is already in db if it is get the paint_brand id number
	$qry = "SELECT brand_id FROM brands where brand_name = '$paint_brand' and base_id= '$base_id' and user_id= '$user_id' ";
	$result = $conn->query($qry);
	if (!$result) die ("Database access failed: " . $conn->error);
	if($result->num_rows == 1) {
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$brand_id = $row['brand_id'];
		}
		// if the paint_brand is not in database then add it and get its brand_id number
	else{
		$qry = "INSERT INTO brands(brand_name, base_id, user_id) VALUES('$paint_brand','$base_id', '$user_id')";
		$result = $conn->query($qry);
		if (!$result) die ("Database access failed: " . $conn->error);
		$qry = "SELECT brand_id FROM brands where brand_name = '$paint_brand' and base_id= '$base_id' and user_id= '$user_id' ";
		$result = $conn->query($qry);
		if (!$result) die ("Database access failed: " . $conn->error);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$brand_id = $row['brand_id'];
		}
	
		// check if finish_type user is trying to add is already in db if it is get the finish_type id number
	$qry = "SELECT finish_id FROM finish_type where finish_type = '$finish_type' and brand_id= '$brand_id' and user_id= '$user_id' ";
	$result = $conn->query($qry);
	if (!$result) die ("Database access failed: " . $conn->error);
	if($result->num_rows == 1) {
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$finish_id = $row['finish_id'];
		}
		// if the finish_type is not in database then add it and get its finish_id number
	else{
		$qry = "INSERT INTO finish_type(finish_type, brand_id, user_id) VALUES('$finish_type','$brand_id', '$user_id')";
		$result = $conn->query($qry);
		if (!$result) die ("Database access failed: " . $conn->error);
		$qry = "SELECT finish_id FROM finish_type where finish_type = '$finish_type' and brand_id= '$brand_id' and user_id= '$user_id' ";
		$result = $conn->query($qry);
		if (!$result) die ("Database access failed: " . $conn->error);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$finish_id = $row['finish_id'];
		}
		// check if paint is in db 
	$qry = "SELECT paint_id FROM paint_info where base_id = '$base_id' and brand_id= '$brand_id' and finish_id= '$finish_id' and user_id= '$user_id' ";
	$result = $conn->query($qry);
	if (!$result) die ("Database access failed: " . $conn->error);
	// if paint is in db already create err message
	if($result->num_rows == 1) {
		$errmsg_arr[] = 'The paint you trying to add is already in database.';
        $errflag = true;
		}
		
	if($errflag) {
        $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
        session_write_close();
        header("location: index.php?page=new_paint_form");
        exit();
		}	
		
	else {
			
	// add the paint coverage details and price for the paint
	$qry = "INSERT INTO paint_info(base_id, brand_id, coverage_m2, price, finish_id, user_id)
	VALUES('$base_id','$brand_id', '$coverage_m2', '$price', '$finish_id', '$user_id')";
		$result = $conn->query($qry);
		if (!$result) die ("Database access failed: " . $conn->error);
		$errmsg_arr[] = 'Paint added successfully.';
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		header("location: index.php?page=settings");
	}
	$result->close();
	$conn->close();

?>