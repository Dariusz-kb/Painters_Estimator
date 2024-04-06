<?php
session_start();
require_once('authorisation.php');
include("dbconnect.php");
    //Array to store validation errors
    $errmsg_arr = array();
    //Validation error flag
    $errflag = false;
	
$user_id = $_SESSION['SESS_USER_ID'];

 $item_to_del = $_POST['del_prep'];
  if(empty($item_to_del))
  {
    $errmsg_arr[] = 'You didnt select any preparations to delete';
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
      $sql = "DELETE FROM preparation_works where prep_id='$item_to_del[$i]' and user_id='$user_id'";
      $result = $conn->query($sql);
      if(!$result)die($conn->error);
   	}
	$errmsg_arr[] = 'You have deleted preparations succesfully';
	$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
	header("location: index.php?page=settings");
		
    }


	$conn->close();

?>
