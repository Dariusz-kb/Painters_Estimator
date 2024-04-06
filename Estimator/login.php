<?php
    //Start session
    session_start();
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
	// check if e mail correct format
	$reg_login = '/^[A-Za-z]\w{5,14}$/';		
	if(isset($_POST["login"]) && !empty($_POST["login"])){
		$login = clean($_POST['login'],$conn);
		if(!preg_match($reg_login, $login)) {
		$errmsg_arr[] = "Wrong Login format";
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		$errflag = true;
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
		
	// enctypt password using md5 function
	$encrypt_pass=md5($password);
    
	//Input Validations
    if($login == '') {
        $errmsg_arr[] = 'Login ID missing';
        $errflag = true;
    }
    if($password == '') {
        $errmsg_arr[] = 'Password missing';
        $errflag = true;
    }
	
	//If there are input validations, redirect back to the login form and display message
    if($errflag) {
        $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
        session_write_close();
        header("location: loginform.php");
        exit();
    }

      //Create query to check for login details

    $qry="SELECT * FROM registered_users WHERE login='$login' AND password='$encrypt_pass'";
    $result = $conn->query($qry);
    if (!$result) die ("Database access failed: " . $conn->error);
	if($result->num_rows == 0) {
		// if login not succesfull then redirect to login form and display error mesage to user
		$errmsg_arr[] = "<center><span style='font-size: 40px; color: Tomato;'> Login Failed </span></center>";
		$errmsg_arr[] = 'Login or password incorect.';
        $errflag = true;
			if($errflag) {
        $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
        session_write_close();
        header("location: loginform.php");
        exit();
		}}
	else{
			
		session_regenerate_id();
        $user = $result->fetch_array(MYSQLI_ASSOC);
        $_SESSION['LOGGED'] = true;
        $_SESSION['SESS_USER_ID'] = $user['id_num'];
        $_SESSION['SESS_USERNAME'] = $user['login'];
		$_SESSION['SESS_PROJECT_ID'] = 0;
        session_write_close();
		header("location: index.php");
		exit();
		}

      
?>