<?php
session_start();
require_once('authorisation.php');
include("dbconnect.php");
    //Array to store validation errors
    $errmsg_arr = array();
    //Validation error flag
    $errflag = false;
	
$user_id = $_SESSION['SESS_USER_ID'];

 $item_to_del = $_POST['del_paint'];
  if(empty($item_to_del))
  {
    $errmsg_arr[] = 'You didnt select any paint to delete';
       $errflag = true;
		if($errflag) {
        $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
        session_write_close();
        header("location: index.php?page=settings");
        exit();
       }
  }
  else
  {
    $del_list = count($item_to_del);
	for($i=0; $i < $del_list; $i++)
    {
		// get the paints base, brand and finish id
		$qry = "SELECT * FROM paint_info where paint_id='".$item_to_del[$i]."' and user_id='$user_id' ";
		$result = $conn->query($qry);
		if (!$result) die ("Database access failed: " . $conn->error);
		$rows = $result->num_rows;
		for($j=0; $j< $rows; ++$j)
		{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$base_id = $row['base_id'];
		$brand_id = $row['brand_id'];
		$finish_id = $row['finish_id'];
		
		// remove paint info from database
		$sql = "DELETE FROM base_type where base_id='$base_id' and user_id='$user_id'";
		$result = $conn->query($sql);
		if(!$result)die($conn->error);
		
		$sql = "DELETE FROM brands where brand_id='$brand_id' and user_id='$user_id'";
		$result = $conn->query($sql);
		if(!$result)die($conn->error);
		
		$sql = "DELETE FROM finish_type where finish_id='$finish_id' and user_id='$user_id'";
		$result = $conn->query($sql);
		if(!$result)die($conn->error);
		
		}
		// delete paint info from paint info table
		$sql = "DELETE FROM paint_info where paint_id='".$item_to_del[$i]."' and user_id='$user_id'";
		$result = $conn->query($sql);
		if(!$result)die($conn->error);
	
	}
	// if success redirect back to settings page and display message to user
	$errmsg_arr[] = 'You have deleted paints succesfully';
	$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
	session_write_close();
			header("location: index.php?page=settings");
			exit();
	
  }
	$conn->close();

?>
