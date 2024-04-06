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
    $prep_name = clean($_POST['prep_name'],$conn);
    $prep_description = clean($_POST['prep_description'],$conn);
	
	
	// check if preparation already exists if it does redirect to new prep form page and display message to user
	$qry = "SELECT prep_id FROM preparation_works where prep_name = '$prep_name' and user_id= '$user_id' ";
	$result = $conn->query($qry);
	if (!$result) die ("Database access failed: " . $conn->error);
	if($result->num_rows == 1) {
		$errmsg_arr[] = 'The preparation work you trying to add is already in database.';
        $errflag = true;
		if($errflag) {
        $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
        session_write_close();
        header("location: index.php?page=new_prep_form");
        exit();
		}
	}
		// if preparation doesnt exists add new preparation work into data base.
		else {
				$qry = "INSERT INTO preparation_works(prep_name, prep_description, user_id) VALUES('$prep_name', '$prep_description', '$user_id')";
				$result = $conn->query($qry);
				if (!$result) die ("Database access failed: " . $conn->error);
				$errmsg_arr[] = 'Preparation work added successfully.';
				$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
				header("location: index.php?page=settings");
				}
	$result->close();
	$conn->close();

		
?>
	