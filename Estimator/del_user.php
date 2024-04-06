<?php

session_start();
require_once('authorisation.php');
include("dbconnect.php");
	
$user_id = $_SESSION['SESS_USER_ID'];

      $sql = "DELETE FROM base_type where user_id='$user_id'";
      $result = $conn->query($sql);
      if(!$result)die($conn->error);
	  $sql = "DELETE FROM brands where user_id='$user_id'";
      $result = $conn->query($sql);
      if(!$result)die($conn->error);
	  $sql = "DELETE FROM category where user_id='$user_id'";
      $result = $conn->query($sql);
      if(!$result)die($conn->error);
	  $sql = "DELETE FROM costumers_db where user_id='$user_id'";
      $result = $conn->query($sql);
      if(!$result)die($conn->error);
	  $sql = "DELETE FROM estimates where user_id='$user_id'";
      $result = $conn->query($sql);
      if(!$result)die($conn->error);
	  $sql = "DELETE FROM finish_type where user_id='$user_id'";
      $result = $conn->query($sql);
      if(!$result)die($conn->error);
	  $sql = "DELETE FROM items where user_id='$user_id'";
      $result = $conn->query($sql);
      if(!$result)die($conn->error);
	  $sql = "DELETE FROM labour_price where user_id='$user_id'";
      $result = $conn->query($sql);
      if(!$result)die($conn->error);
	  $sql = "DELETE FROM materials where user_id='$user_id'";
      $result = $conn->query($sql);
      if(!$result)die($conn->error);
	  $sql = "DELETE FROM measure_price where user_id='$user_id'";
      $result = $conn->query($sql);
      if(!$result)die($conn->error);
	  $sql = "DELETE FROM paint_info where user_id='$user_id'";
      $result = $conn->query($sql);
      if(!$result)die($conn->error);
	  $sql = "DELETE FROM preparation_works where user_id='$user_id'";
      $result = $conn->query($sql);
      if(!$result)die($conn->error);
	  $sql = "DELETE FROM primers_undercoats where user_id='$user_id'";
      $result = $conn->query($sql);
      if(!$result)die($conn->error);
	  $sql = "DELETE FROM projects where user_id='$user_id'";
      $result = $conn->query($sql);
      if(!$result)die($conn->error);
	  $sql = "DELETE FROM registered_users where id_num='$user_id'";
      $result = $conn->query($sql);
      if(!$result)die($conn->error);
	
	
header("location: del_user_success.php");
    

	$conn->close();

?>
