
<?php
    //Start session
session_start();
require_once('authorisation.php');
    //Array to store validation errors
    $errmsg_arr = array();

    //Validation error flag
    $errflag = false;

    //Connect to mysql server
 	include("dbconnect.php");

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

	// check if if there was redirect from open project to add contact to project
	if(isset($_GET["data"]))
    {
       $_SESSION['SESS_PROJECT_ID'] = clean($_GET["data"],$conn);
        
    }
	
	$user_id = $_SESSION['SESS_USER_ID'];
	$project_id = $_SESSION['SESS_PROJECT_ID'];
	
	
	
		// validate street entry only letters spaces allowed
	if(isset($_POST["street"]) && !empty($_POST["street"])){
		$street = clean($_POST['street'],$conn);
		if (!preg_match('/^[\p{L} ]+$/', $street)){
			$errmsg_arr[] = "street name must contain letters and spaces only!";
			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			$errflag = true;
				}
			}

	
	// validate county entry only letters spaces allowed
	if(isset($_POST["county"]) && !empty($_POST["county"])){
		$county = clean($_POST['county'],$conn);
		if (!preg_match('/^[\p{L} ]+$/', $county)){
			$errmsg_arr[] = "County name must contain letters and spaces only!";
			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			$errflag = true;
				}
			}


// validate city entry only letters spaces allowed
	if(isset($_POST["city"]) && !empty($_POST["city"])){
		$city = clean($_POST['city'],$conn);
		if (!preg_match('/^[\p{L} ]+$/', $city)){
			$errmsg_arr[] = "City name must contain letters and spaces only!";
			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			$errflag = true;
				}
			}
// validate first name only letters and spaces allowed
	if(isset($_POST["firstname"]) && !empty($_POST["firstname"])){
		$fname = clean($_POST['firstname'],$conn);
		if (!preg_match('/^[\p{L} ]+$/', $fname)){
		   $errmsg_arr[] = "Name can contain only letters and spaces";
			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			$errflag = true;
			}
		}

	// validate surname only letters and spaces allowed
	if(isset($_POST["surname"]) && !empty($_POST["surname"])){
		$sname = clean($_POST['surname'],$conn);
		if (!preg_match('/^[\p{L} ]+$/', $sname)){
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
	// validate housenumber	ctype_digit	
	if(isset($_POST["housenumber"]) && !empty($_POST["housenumber"])){
		$number = clean($_POST['housenumber'],$conn);
		if(!ctype_digit($number)){
			$errmsg_arr[] = "House number can contain only letters and digits";
			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			$errflag = true;
			}
		}	

    //If there are input validations, redirect back to contact form page
    if($errflag) {
        $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
        session_write_close();
        header("location: index.php?page=contact_form");
        exit();
    }
	// insert costumer data into data base
	$qry = "INSERT INTO costumers_db(first_name, surname, phone, email, number, street, city, county, user_id, project_id) VALUES ('$fname', '$sname', '$phone', '$email', '$number', '$street', '$city', '$county', '$user_id', '$project_id');";
	 $result = $conn->query($qry);
    if (!$result) die ("Database access failed: " . $conn->error);
    header("location: index.php?page=create_estimate");
	
	$result->close();
	$conn->close();
	

?>
