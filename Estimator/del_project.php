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
    $project_id = clean($_POST['project_id'],$conn);
	// queries to remove project costumer and estimate
	$sql = "DELETE FROM costumers_db where user_id = '$user_id' and project_id = '$project_id'";
	$result = $conn->query($sql);
	if(!$result)die($conn->error);
	$sql = "DELETE FROM estimates where estimate_id = '$project_id'";
	$result = $conn->query($sql);
	if(!$result)die($conn->error);
	$sql = "DELETE FROM projects where project_id = '$project_id' and user_id = '$user_id'";
	$result = $conn->query($sql);
	if(!$result)die($conn->error);
	// set message to be displayed to user
	$errmsg_arr[] = 'Record succesfully removed from database.';
    $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
	header("location: index.php?page=open-project");
	
?>