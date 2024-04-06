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
	
	$user_id = $_SESSION['SESS_USER_ID'];
	// get posted data and check if it is numeric
	if(isset($_POST["labour_price"]) && !empty($_POST["labour_price"])){
		if (is_numeric($_POST['labour_price'])) {
			$labour_price = clean($_POST['labour_price'],$conn);
			$qry = "INSERT INTO labour_price(user_id, prep_price) VALUES('$user_id', '$labour_price')";
			$result = $conn->query($qry);
				if (!$result) die ("Database access failed: " . $conn->error);
				$errmsg_arr[] = 'Price of labour added successfully.';
				$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
				header("location: index.php?page=settings");
		}
		else {
			$errmsg_arr[] = "Labour price must be numeric";
			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			$errflag = true;
			}
		}
		
		
	if(isset($_POST["change_price"]) && !empty($_POST["change_price"])){
		if (is_numeric($_POST['change_price'])) {
			$change_price = clean($_POST['change_price'],$conn);
			$qry = "UPDATE labour_price SET prep_price='$change_price' WHERE user_id='$user_id'";
			$result = $conn->query($qry);
				if (!$result) die ("Database access failed: " . $conn->error);
				$errmsg_arr[] = 'Price of labour changed successfully.';
				$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
				header("location: index.php?page=settings");
				}
		else {
			$errmsg_arr[] = "Labour price must be numeric";
			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			$errflag = true;
			}
		}
		// if there are any validation errors redirect back to settings and display message to the user
	if($errflag) {
        $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
        session_write_close();
        header("location: index.php?page=labour_price");
        exit();
		}
	$result->close();
	$conn->close();
		
				
	?>