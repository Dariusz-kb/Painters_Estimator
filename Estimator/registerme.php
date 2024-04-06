<?php
// start session
session_start();
// include connection file
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
	
	// validate street entry only letters spaces allowed
	if(isset($_POST["street"]) && !empty($_POST["street"])){
		$street = clean($_POST['street'],$conn);
		if (!preg_match('/^[\p{L} ]+$/', $street)){
			$errmsg_arr[] = "Street name must contain letters and spaces only!";
			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			$errflag = true;
				}
			}
		   
	// validate city name only letters and spaces
	if(isset($_POST["city"]) && !empty($_POST["city"])){
		$city = clean($_POST['city'],$conn);
		if (!preg_match('/^[\p{L} ]+$/', $city)){
			$errmsg_arr[] = "City name can contain only letters and spaces";
			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			$errflag = true;
			}
		}
	
	// validate county name only letters and spaces
	if(isset($_POST["county"]) && !empty($_POST["county"])){
		$county = clean($_POST['county'],$conn);
		if (!preg_match('/^[\p{L} ]+$/', $county)){
		    $errmsg_arr[] = "County name can contain only letters and spaces";
			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			$errflag = true;
			}
		}
	
	// validate first name only letters and spaces
	if(isset($_POST["firstname"]) && !empty($_POST["firstname"])){
		$fname = clean($_POST['firstname'],$conn);
		if (!preg_match('/^[\p{L} ]+$/', $fname)){
		   $errmsg_arr[] = "Name can contain only letters and spaces";
			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			$errflag = true;
			}
		}
		
	// validate surname only letters and spaces
	if(isset($_POST["surname"]) && !empty($_POST["surname"])){
		$lname = clean($_POST['surname'],$conn);
		if (!preg_match('/^[\p{L} ]+$/', $lname)){
		   $errmsg_arr[] = "Surname can contain only letters and spaces";
		   $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		   $errflag = true;
			}
		}
	
	// validate phone number with ctype_digit()	function to allow only numbers
	if(isset($_POST["phone"]) && !empty($_POST["phone"])){
		$phone = clean($_POST['phone'],$conn);
		if (!ctype_digit($phone)) {
			$errmsg_arr[] = "Phone can contain only digits";
			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			$errflag = true;
			}
		}
	
		// validate email using regular expression and preg_mach() function
	$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
	if(isset($_POST["email"]) && !empty($_POST["email"])){
		$email = clean($_POST['email'],$conn);
		if(!preg_match($regex, $email)) {
		$errmsg_arr[] = "Email is wrong format";
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		$errflag = true;
			}
		 }

	// validate housenumber	with ctype_digit() function to allow only digits	
	if(isset($_POST["housenumber"]) && !empty($_POST["housenumber"])){
		$housenumber = clean($_POST['housenumber'],$conn);
		if(!ctype_digit($housenumber)) {
			$errmsg_arr[] = "House number can contain only digits";
			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			$errflag = true;
			}
		}	
		

	
	
	// validate login, it may contain only letters and digits
	// it must be at least 6 characters and no more that 15
	$reg_login='/^[A-Za-z]\w{5,14}$/';		
	if(isset($_POST["login"]) && !empty($_POST["login"])){
		$login = clean($_POST['login'],$conn);
		if(!preg_match($reg_login, $login)) {
		$errmsg_arr[] = "Wrong Login format";
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		$errflag = true;
			}
		else {
		//Check for duplicate login ID
		if($login != '') {
			$qry = "SELECT * FROM registered_users WHERE login='$login'";
			$result = $conn->query($qry);
			if (!$result) die ("Database access failed: " . $conn->error);
			if($result->num_rows != 0) {
				$errmsg_arr[] = 'Login name already in use.';
				$errmsg_arr[] = 'Try to enter diferent login name.';
				$errflag = true;
				}
			}
		  }
		} 
		
	// validate password, it may contain only letters and digits
	// it must be at least 6 characters and no more that 15
	$pass_reg = '/^[A-Za-z]\w{5,14}$/';
	if(isset($_POST["password"]) && !empty($_POST["password"])){
		$password = clean($_POST['password'],$conn);
		if(!preg_match($pass_reg, $password)) {
		$errmsg_arr[] = "Wrong password format";
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		$errflag = true;
			}
		 }
	
	// check if passwords match
	if(isset($_POST["cpassword"]) && !empty($_POST["cpassword"])){
    $cpassword = clean($_POST['cpassword'],$conn);
		if( strcmp($password, $cpassword) != 0 ) {
        $errmsg_arr[] = 'Passwords do not match';
        $errflag = true;
		}
		}
	
    //If there are input validations, redirect back to the registration page and display error message to user
    if($errflag) {
        $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
        session_write_close();
        header("location: registerform.php");
        exit();
    }
	
	// encrypt password entered by user before inserting into database
	$enc_password = md5($password);
	// put user address into string
	$user_addr = "";
	$user_addr .= $housenumber.",".$street.",".$city.",".$county.",";
	
    //Create INSERT query
    $qry = "INSERT INTO registered_users(name, surname, phone_number, email, user_addr, login, password) VALUES('$fname', '$lname', '$phone', '$email', '$user_addr', '$login', '$enc_password')";
    $result = $conn->query($qry);
    if (!$result) die ("Database access failed: " . $conn->error);
    //if the query was successful redirect to register_success page
    header("location: register_success.php");



?>