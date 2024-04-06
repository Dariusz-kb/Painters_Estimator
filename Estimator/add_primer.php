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
    $primer_name = clean($_POST['primer_name'],$conn);
    $primer_brand = clean($_POST['primer_brand'],$conn);
	$primer_base = clean($_POST['primer_base'],$conn);
	
	// verify time primer_coverage 
	if(isset($_POST["primer_coverage"]) && !empty($_POST["primer_coverage"])){
		if(is_numeric($_POST['primer_coverage'])) {
			$primer_coverage = clean($_POST['primer_coverage'],$conn);
			} 
			else {
				$errmsg_arr[] = "The primer_coverage must be numeric";
				$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
				$errflag = true;
				}
			}
			
		// verify time primer_price 
	if(isset($_POST["primer_price"]) && !empty($_POST["primer_price"])){
		if(is_numeric($_POST['primer_price'])) {
			$primer_price = clean($_POST['primer_price'],$conn);
			} 
			else {
				$errmsg_arr[] = "The primer_price must be numeric";
				$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
				$errflag = true;
				}
			}	
	
	
	// check if primer already exists in db
	$qry = "SELECT primer_id FROM primers_undercoats where primer_name = '$primer_name' and primer_brand = '$primer_brand' and primer_base = '$primer_base' and user_id= '$user_id' ";
	$result = $conn->query($qry);
	if (!$result) die ("Database access failed: " . $conn->error);
	// if primer already exists in db create err message to user
	if($result->num_rows == 1) {
		$errmsg_arr[] = 'The primer you trying to add is already in database.';
        $errflag = true;
		}
		
	 //If there are input validations, redirect back to the primer form	
	if($errflag) {
        $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
        session_write_close();
        header("location: index.php?page=new_primer_form");
        exit();
		}
		
		// if primer doesnt exists add new primer into data base and display success message to user
		else {
				$qry = "INSERT INTO primers_undercoats(primer_name, primer_brand, primer_base, primer_coverage, primer_price, user_id)
				VALUES('$primer_name', '$primer_brand', '$primer_base', '$primer_coverage', '$primer_price', '$user_id')";
				$result = $conn->query($qry);
			if (!$result) die ("Database access failed: " . $conn->error);
				$errmsg_arr[] = 'Primer added successfully.';
				$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
				header("location: index.php?page=settings");
				}
				
	$result->close();
	$conn->close();

	
?>