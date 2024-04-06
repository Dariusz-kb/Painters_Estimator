<?php
require_once('authorisation.php');
include("dbconnect.php");
if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
        foreach($_SESSION['ERRMSG_ARR'] as $msg) {
            echo '<center><span style="font-size: 20px; color: Green;">'.$msg.'</span></center>';
        }
        unset($_SESSION['ERRMSG_ARR']);
    }
	
$user_id = $_SESSION['SESS_USER_ID'];

$user_details= array();
$qry = "SELECT name, surname, phone_number, email, user_addr FROM registered_users WHERE id_num='$user_id' ";
$result = $conn->query($qry);
if(!$result)die($conn->error);	
	$rows = $result->num_rows;
	for($j=0; $j< $rows; ++$j)
	{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$name = $row['name'];
		$surname = $row['surname'];
		$phone_number = $row['phone_number'];
		$email = $row['email'];
		$user_addr = $row['user_addr'];
	}
		?>
		
	<br>
<div>	
<div class="form row">
  <div class="form-group col-md-6 offset-md-3">
<div class="card text-center text-white bg-info">
<div class="card-header text-center bg-secondary"><?php echo $name." ".$surname;?></div>
  <div class="card-body">
		<p class="card-text"> Address : <?php echo $user_addr;?></p>
		<p class="card-text"> Phone   : <?php echo $phone_number;?></a></p>
		<p class="card-text"> E-mail  : <?php echo $email;?></p>
	</div>
	<div class="card-footer text-center bg-secondary">
	<button class="btn btn-warning btn-lg btn-block" type="button" data-toggle="collapse" data-target="#make_changes" aria-expanded="false" aria-controls="make_changes">
    Change your details
  </button>
  </div>
</div>
</div>	
</div>
	

	<br>
<div class="collapse" id="make_changes">	
	<div class="accordion col-md-6 offset-md-3" id="user_details">
  <div class="card text-center text-black bg-info">
    <div class="card-header" id="change_name">
      <h5 class="mb-0">
        <a class="list-group-item list-group-item-info" data-toggle="collapse" data-target="#show_new_name" aria-expanded="true" aria-controls="show_new_name">Change your name</a>
      </h5>
    </div>

    <div id="show_new_name" class="collapse" aria-labelledby="change_name" data-parent="#user_details">
      <div class="card-body bg-light">
	  <form action="change_details.php" id="change_details" name="change_details" method="post">
	<div class="input-group ">
  <input type="text" pattern="[a-zA-Z ]+" class="form-control form-control-lg" name="new_name" placeholder="Enter new name">
  <div class="input-group-append">
    <button class="btn btn-warning" type="submit">Change</button>
  </div>
</div>
</form>
	  
	  </div>
    </div>
  </div>
  
  <div class="card text-center text-black bg-info">
    <div class="card-header" id="change_surname">
      <h5 class="mb-0">
        <a class="list-group-item list-group-item-info" data-toggle="collapse" data-target="#show_new_surname" aria-expanded="true" aria-controls="show_new_surname">Change your surname</a>
      </h5>
    </div>

    <div id="show_new_surname" class="collapse" aria-labelledby="change_surname" data-parent="#user_details">
      <div class="card-body bg-light">
	  <form action="change_details.php" id="change_details" name="change_details" method="post">
	<div class="input-group ">
  <input type="text" pattern="[a-zA-Z ]+" class="form-control form-control-lg" name="new_surname" placeholder="Enter new surname">
  <div class="input-group-append">
    <button class="btn btn-warning" type="submit">Change</button>
  </div>
</div>
</form>
	  
	  </div>
    </div>
  </div>
  
   <div class="card text-center text-black bg-info">
    <div class="card-header" id="change_phone">
      <h5 class="mb-0">
        <a class="list-group-item list-group-item-info" data-toggle="collapse" data-target="#show_new_phone" aria-expanded="true" aria-controls="show_new_phone">Change your phone number</a>
      </h5>
    </div>

    <div id="show_new_phone" class="collapse" aria-labelledby="change_phone" data-parent="#user_details">
      <div class="card-body bg-light">
	  <form action="change_details.php" id="change_details" name="change_details" method="post">
	<div class="input-group ">
  <input type="text" pattern="[0-9]+" class="form-control form-control-lg" name="new_phone" placeholder="Enter new phone number">
  <div class="input-group-append">
    <button class="btn btn-warning" type="submit">Change</button>
  </div>
</div>
</form>
	  
	  </div>
    </div>
  </div>
  
  <div class="card text-center text-black bg-info">
    <div class="card-header" id="change_email">
      <h5 class="mb-0">
        <a class="list-group-item list-group-item-info" data-toggle="collapse" data-target="#show_new_email" aria-expanded="true" aria-controls="show_new_email">Change your e-mail</a>
      </h5>
    </div>

    <div id="show_new_email" class="collapse" aria-labelledby="change_email" data-parent="#user_details">
      <div class="card-body bg-light">
	  <form action="change_details.php" id="change_details" name="change_details" method="post">
	<div class="input-group ">
  <input type="email" class="form-control form-control-lg" name="new_email" placeholder="Enter new email">
  <div class="input-group-append">
    <button class="btn btn-warning" type="submit">Change</button>
  </div>
</div>
</form>
	  
	  </div>
    </div>
  </div>
  
   <div class="card text-center text-black bg-info">
    <div class="card-header" id="change_address">
      <h5 class="mb-0">
        <a class="list-group-item list-group-item-info" data-toggle="collapse" data-target="#show_new_address" aria-expanded="true" aria-controls="show_new_address">Change your address</a>
      </h5>
    </div>

    <div id="show_new_address" class="collapse" aria-labelledby="change_address" data-parent="#user_details">
      <div class="card-body bg-light">
	  <form action="change_details.php" id="change_details" name="change_details" method="post">
	<div class="input-group ">
  <input type="number" class="form-control form-control-lg" name="number" placeholder="Number...">
  </div><br>
  <div class="input-group ">
  <input type="text" class="form-control form-control-lg" name="street" placeholder="Street...">
	</div><br>
	<div class="input-group ">
  <input type="text" class="form-control form-control-lg" name="city" placeholder="City...">
  </div><br>
  <div class="input-group ">
  <input type="text" class="form-control form-control-lg" name="county" placeholder="County...">
	</div><br>
 <div class="input-group justify-content-center">
    <button class="btn btn-warning btn-lg" type="submit">Change</button>
  </div>
</div>
</form>
	  
	  </div>
    </div>
  
  <div class="card text-center text-black bg-info">
    <div class="card-header" id="remove_account">
      <h5 class="mb-0">
        <a class="list-group-item list-group-item-info" data-toggle="collapse" data-target="#show_remove_account" aria-expanded="true" aria-controls="show_remove_account">Delete your account</a>
      </h5>
    </div>

    <div id="show_remove_account" class="collapse" aria-labelledby="remove_account" data-parent="#user_details">
      <div class="card-body bg-light">
	<a href="index.php?page=del_user_conf" class="list-group-item list-group-item-info" ><span style="font-size: 20px;">Delete your user account</span></a>

	
	  </div>
    </div>
  </div>
 
</div>
</div>
<br>
