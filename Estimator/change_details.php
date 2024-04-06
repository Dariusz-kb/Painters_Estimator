<?php
session_start();
require_once('authorisation.php');
include("dbconnect.php");
$user_id = $_SESSION['SESS_USER_ID'];

//function to Sanitize the POST values
function clean($str, $connection) {
        return $connection->real_escape_string($str);
    }

	
	// validate that name is only letters and spaces
	if(isset($_POST["new_name"]) && !empty($_POST["new_name"])){
		if (preg_match('/^[\p{L} ]+$/', $_POST['new_name'])){
		$new_name = clean($_POST['new_name'],$conn);
		$qry = "UPDATE registered_users SET name='$new_name' WHERE id_num='$user_id'";
			$result = $conn->query($qry);
				if (!$result) die ("Database access failed: " . $conn->error);
				$errmsg_arr[] = 'Name changed successfully.';
				$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
				header("location: index.php?page=user_profile");
				exit();
				}		
		else {
        $errmsg_arr[] = "Name can contain only letters and spaces";
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		$errflag = true;
    }
	}
		// validate surname	and update or not		
	if(isset($_POST["new_surname"]) && !empty($_POST["new_surname"])){
		if (preg_match('/^[\p{L} ]+$/', $_POST['new_surname'])){
		$new_surname = clean($_POST['new_surname'],$conn);
		$qry = "UPDATE registered_users SET surname='$new_surname' WHERE id_num='$user_id'";
			$result = $conn->query($qry);
				if (!$result) die ("Database access failed: " . $conn->error);
				$errmsg_arr[] = 'Surname changed successfully.';
				$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
				header("location: index.php?page=user_profile");
				exit();
				}
		else {
        $errmsg_arr[] = "Surname can contain only letters and spaces";
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		$errflag = true;
    }
	}
		// validate phone and update or not		
	if(isset($_POST["new_phone"]) && !empty($_POST["new_phone"])){
		if (ctype_digit($_POST['new_phone'])) {
		$new_phone = clean($_POST['new_phone'],$conn);
		$qry = "UPDATE registered_users SET phone_number='$new_phone' WHERE id_num='$user_id'";
			$result = $conn->query($qry);
				if (!$result) die ("Database access failed: " . $conn->error);
				$errmsg_arr[] = 'Phone changed successfully.';
				$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
				header("location: index.php?page=user_profile");
				exit();
				}
		else {
        $errmsg_arr[] = "Phone can contain only digits";
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		$errflag = true;
		}
		}
	
		// validate email and update or not
		$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
	if(isset($_POST["new_email"]) && !empty($_POST["new_email"])){
		if(preg_match($regex, $_POST['new_email'])) {
		$new_email = clean($_POST['new_email'],$conn);
		$qry = "UPDATE registered_users SET email='$new_email' WHERE id_num='$user_id'";
			$result = $conn->query($qry);
				if (!$result) die ("Database access failed: " . $conn->error);
				$errmsg_arr[] = 'Email changed successfully.';
				$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
				header("location: index.php?page=user_profile");
				exit();
				}
		else {
        $errmsg_arr[] = "Email is wrong format";
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		$errflag = true;
    }
	}
				
	if(isset($_POST["number"]) && !empty($_POST["number"]) && isset($_POST["street"]) && !empty($_POST["street"])
		&& isset($_POST["city"]) && !empty($_POST["city"]) && isset($_POST["county"]) && !empty($_POST["county"])){
		
		$number = clean($_POST['number'],$conn);
		$street = clean($_POST['street'],$conn);
		$city = clean($_POST['city'],$conn);
		$county = clean($_POST['county'],$conn);


	// validate user entry
	if (!ctype_digit($number)) {
			$errmsg_arr[] = "House number can contain only digits";
			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			$errflag = true;
			}
	if (!preg_match('/^[\p{L} ]+$/', $street)){	
			$errmsg_arr[] = "Street can contain only laters and spaces";
			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			$errflag = true;
			}
	if (!preg_match('/^[\p{L} ]+$/', $city)){	
			$errmsg_arr[] = "City can contain only laters and spaces";
			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			$errflag = true;
			}		
	if (!preg_match('/^[\p{L} ]+$/', $county)){	
			$errmsg_arr[] = "County can contain only laters and spaces";
			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			$errflag = true;
			}		
	else {
		// put address parts into a string and execute query
		$address = "";
		$address .= $number.",".$street.",".$city.",".$county;
		$qry = "UPDATE registered_users SET user_addr='$address' WHERE id_num='$user_id'";
			$result = $conn->query($qry);
				if (!$result) die ("Database access failed: " . $conn->error);
				$errmsg_arr[] = 'Address changed successfully.';
				$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
				header("location: index.php?page=user_profile");
			}
		}
		
		// if there are input validations 
		if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: index.php?page=user_profile");
		exit();
		}



	?>
	