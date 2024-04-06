<?php

session_start();
require_once('authorisation.php');
   include("dbconnect.php");
    //Array to store validation errors
    $errmsg_arr = array();
    //Validation error flag
    $errflag = false;
	
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

	// sanitize post values	
	$user_id = $_SESSION['SESS_USER_ID'];
    $work_type = clean($_POST['worktype'],$conn);
	$measure_type = clean($_POST['measure_type'],$conn);
	
	
	// validate category entry only letters spaces only allowed
	if(isset($_POST["category"]) && !empty($_POST["category"])){
		$category = clean($_POST['category'],$conn);
		if (!preg_match('/^[\p{L} ]+$/', $category)){
			$errmsg_arr[] = "Category name must contain letters and spaces only!";
			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			$errflag = true;
				}
			}
		
	// validate item name entry only letters spaces allowed
	if(isset($_POST["item"]) && !empty($_POST["item"])){
		$item = clean($_POST['item'],$conn);
		if (!preg_match('/^[\p{L}\p{N} ]+$/', $item)){
			$errmsg_arr[] = "item name must contain letters and spaces only!";
			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			$errflag = true;
				}
			}
			
	// verify time entry it must me numeric
	if(isset($_POST["item_time"]) && !empty($_POST["item_time"])){
		$time_minutes = clean($_POST['item_time'],$conn);
		if(!is_numeric($time_minutes)) {
			$errmsg_arr[] = "The time must numeric type";
			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			$errflag = true;
				}
			}
			
	// verify price per coat it must be numeric type
	if(isset($_POST["measure_price"]) && !empty($_POST["measure_price"])){
		$measure_price = clean($_POST['measure_price'],$conn);
		if(!is_numeric($measure_price)) {
			$errmsg_arr[] = "Price per coat must numeric";
			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			$errflag = true;
				}
			}
			
	// verify area_m2 entry 
	if(isset($_POST["area_m2"]) && !empty($_POST["area_m2"])){
		$area_m2 = clean($_POST['area_m2'],$conn);
		if(!is_numeric($area_m2)) {
			$errmsg_arr[] = "Area_m2 must be numeric";
			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			$errflag = true;
				}
			} 
			
// if there are any validation errors redirect back to new_item_form and display message to the user
		if($errflag) {
        $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
        session_write_close();
        header("location: index.php?page=new_item_form");
        exit();
		}
			
	
			// check if category already exists if it does just get the category id number
			$qry = "SELECT cat_id FROM category where cat_name = '$category' and type_id= '$work_type' and user_id= '$user_id' ";
			$result = $conn->query($qry);
			if (!$result) die ("Database access failed: " . $conn->error);
			if($result->num_rows == 1) {
				$row = $result->fetch_array(MYSQLI_ASSOC);
				$cat_id = $row['cat_id'];
		
				// check if item user is trying to add is already in db if it is redirect to add item page and display message to user
				$qry = "SELECT item_id FROM items where item_name = '$item' and cat_id= '$cat_id' and user_id= '$user_id' ";
				$result = $conn->query($qry);
				if (!$result) die ("Database access failed: " . $conn->error);
				if($result->num_rows == 1) {
					$errmsg_arr[] = 'The item you trying to add is already in database.';
					$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
					$errflag = true;
					header("location: index.php?page=new_item_form");
					exit();
						}
						
					}
				
		// if category doesnt exists add new category into data base and get its id number
		else {
				$qry = "INSERT INTO category(cat_name, type_id, user_id) VALUES('$category','$work_type', '$user_id')";
				$result = $conn->query($qry);
			if (!$result) die ("Database access failed: " . $conn->error);
				$qry = "SELECT cat_id FROM category where cat_name = '$category' and type_id= '$work_type' and user_id= '$user_id' ";
				$result = $conn->query($qry);
				if (!$result) die ("Database access failed: " . $conn->error);
				if($result->num_rows == 1) {
					$row = $result->fetch_array(MYSQLI_ASSOC);
					$cat_id = $row['cat_id'];
						}
				}
	
		
		// if the item is not in database then add it and get its item_id number
	
		$qry = "INSERT INTO items(item_name, cat_id, user_id) VALUES('$item','$cat_id', '$user_id')";
		$result = $conn->query($qry);
		if (!$result) die ("Database access failed: " . $conn->error);
		$qry = "SELECT item_id FROM items where item_name = '$item' and cat_id= '$cat_id' and user_id= '$user_id' ";
		$result = $conn->query($qry);
		if (!$result) die ("Database access failed: " . $conn->error);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$item_id = $row['item_id'];
	
		// add the measure details and price for the item
		$qry = "INSERT INTO measure_price(item_id, user_id, measure_type, area_m2, measure_price, time_minutes)
		VALUES('$item_id','$user_id', '$measure_type', '$area_m2', '$measure_price', '$time_minutes')";
		$result = $conn->query($qry);
		if (!$result) die ("Database access failed: " . $conn->error);
		$errmsg_arr[] = 'Item added successfully.';
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		header("location: index.php?page=settings");
	
	$result->close();
	$conn->close();

?>