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
	
	$datecreated = date("Y/m/d");
	$user_id = $_SESSION['SESS_USER_ID'];
	
	
	// validate projectname entry only letters spaces and digits allowed
	if(isset($_POST["projectname"]) && !empty($_POST["projectname"])){
		$projectname = clean($_POST['projectname'],$conn);
		if (!preg_match('/^[\p{L}\p{N} ]+$/', $projectname)){
			$errmsg_arr[] = "Projectname name must contain letters, spaces and digits only!";
			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			$errflag = true;
				}
			}
	
	
	// validate house number is a digit
	if(isset($_POST["housenumber"]) && !empty($_POST["housenumber"])){
		$number = clean($_POST['housenumber'],$conn);
		if(!ctype_digit($number)){
			$errmsg_arr[] = "House number must be a digit";
			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			$errflag = true;
			} 
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
	// validate city entry only letters spaces allowed
	if(isset($_POST["city"]) && !empty($_POST["city"])){
		$city = clean($_POST['city'],$conn);
		if (!preg_match('/^[\p{L} ]+$/', $city)){
			$errmsg_arr[] = "City name must contain letters and spaces only!";
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
		
		// validate description entry only letters spaces and numbers allowed
	if(isset($_POST["description"]) && !empty($_POST["description"])){
		$description = clean($_POST['description'],$conn);
		if (!preg_match('/^[\p{L}\p{N} _]+$/', $description)){
			$errmsg_arr[] = "Description name must contain letters spaces only!";
			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			$errflag = true;
				}
			}
		

    //If there are input validations, redirect back to project form
    if($errflag) {
        $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
        session_write_close();
        header("location: index.php?page=new-projectForm");
        exit();
    }

	
    //Create INSERT query
	
	//$qry = "INSERT INTO projects(user_id, project_name, date_created) Values ('$user_id', '$projectname', '$datecreated');";
    $qry = "INSERT INTO projects(user_id, project_name, number, street, city, county, description, date_created) VALUES ('$user_id', '$projectname', '$number', '$street', '$city', '$county', '$description', '$datecreated');";
    $result = $conn->query($qry);
    if (!$result) die ("Database access failed: " . $conn->error);
   
	  
	// get the project id of project just added to database	
    $qry="SELECT max(project_id) AS project_id FROM projects WHERE user_id='$user_id';";
    $result = $conn->query($qry);
    if (!$result) die ("Database access failed: " . $conn->error);
    //Check whether the query was successful or not
    if($result->num_rows == 1) {
            //Login Successful	
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$project = $row['project_id'];
		$_SESSION['SESS_PROJECT_ID'] = $project;
		
		header("location: index.php?page=contact_form");
 
	}

	$result->close();
	$conn->close();

?>