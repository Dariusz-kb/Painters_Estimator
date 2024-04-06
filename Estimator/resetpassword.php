<?php
session_start();
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
	echo $cpassword;
		if( strcmp($password, $cpassword) != 0 ) {
        $errmsg_arr[] = 'Passwords do not match';
        $errflag = true;
		}
		}
			


	
	// validate login, it may contain only letters and digits
	// it must be at least 6 characters and no more that 15
	$reg_login='/^[A-Za-z]\w{5,14}$/';		
	if(isset($_POST["login"]) && !empty($_POST["login"])){
		$login = clean($_POST['login'],$conn);
		if(!preg_match($reg_login, $login)) {
		$errmsg_arr[] = "<p> Login wrong format</p>";
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		$errflag = true;
			}
	
	
	if($login != '') {
			$qry = "SELECT login FROM registered_users WHERE login='$login'";
			$result = $conn->query($qry);
			if (!$result) die ("Database access failed: " . $conn->error);
			if($result->num_rows != 1) {
				$errmsg_arr[] = "<p> Password wrong format</p>";
				$errflag = true;
				}
			}
	}
	
    //If there are input validations, redirect back to the registration page and display error message to user
    if($errflag) {
        $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
        session_write_close();
        header("location: passwordrecovery.php");
        exit();
    }
	
	$enc_password = md5($password);
	
	$qry = "UPDATE registered_users SET password='$enc_password' WHERE login='$login'";
			$result = $conn->query($qry);
				if (!$result) die ("Database access failed: " . $conn->error);
				$errmsg_arr[] = "<p> Password changed succesfully</p>";
				$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
				header("location: loginform.php");
		
	
	
	
	
	
?>
		 
	