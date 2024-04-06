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
	$str = trim($str); 
	return $str;
	}
	// function to clean inputs 
	function clean($str, $connection)
	{	
	$str= escape($str, $connection);
	$str = sanitize($str);
	return $str;
	}
	
	$type = clean($_POST['material'], $conn);
	$price = clean($_POST['price'],$conn);
	
	echo $type."<br>";
   
	$user_id = $_SESSION['SESS_USER_ID'];
  
  // validate $type entry only letters spaces and numerics allowed
   if (!preg_match('/^[\p{L}\p{N} .-]+$/', $type)){
	   $errmsg_arr[] = "Material type must contain letters spaces and numeric values !";
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		$errflag = true;
		}
		
	// validate price entry
	if(!is_numeric($price)) {
		$errmsg_arr[] = "The price must be numeric type !";
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		$errflag = true;
		}
	
	// check if material already exists if it does just get the material id number
	$qry = "SELECT material_id FROM materials where type = '$type' and user_id= '$user_id' ";
	$result = $conn->query($qry);
	if (!$result) die ("Database access failed: " . $conn->error);
	if($result->num_rows == 1) {
		$errmsg_arr[] = 'The material you trying to add is already in database.';
        $errflag = true;
		
	}
	
	if($errflag) {
        $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
        session_write_close();
        header("location: index.php?page=new_material_form");
        exit();
		}
		
		// if material doesnt exists add new material into data base.
		else {
				$qry = "INSERT INTO materials(type, price, user_id) VALUES('$type', '$price', '$user_id')";
				$result = $conn->query($qry);
				if (!$result) die ("Database access failed: " . $conn->error);
				$errmsg_arr[] = 'Material added successfully.';
				$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
				header("location: index.php?page=settings");
				}
	$result->close();
	$conn->close();
	
?>
	