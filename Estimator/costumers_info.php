<?php
require_once('authorisation.php');
    //Connect to mysql server
 	include("dbconnect.php");
	$user_id = $_SESSION['SESS_USER_ID'];
	
	$costumer_info=array();
	
	$sql = "SELECT * FROM costumers_db where user_id = '$user_id' ORDER BY costumer_id DESC;";
	$result = $conn->query($sql);
	if(!$result)die($conn->error);
	if($result->num_rows == 0) {
		?>
		<br>
<div class="container">			
<div class="form row">
  <div class="form-group col-md-6 offset-md-3">
<div class="card text-center text-white bg-info">
  <div class="card-body">	
    <p class="card-text">You have currently no clients in your database.</p>
  </div>
</div>
</div>	
</div>
</div>
	<?php	

	}
	else{
	
	$rows = $result->num_rows;
	for($j=0; $j< $rows; ++$j)
	{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$first_name = ucfirst($row['first_name']);
		$surname = ucfirst($row['surname']);
		$phone = $row['phone'];
		$email = $row['email'];
		$number = $row['phone'];
		$street = ucfirst($row['street']);
		$city = ucfirst($row['city']);
		$county = ucfirst($row['county']);
		$project_id = $row['project_id'];
	
?>
<br>
<div class="form row">
  <div class="form-group col-md-6 offset-md-3">
<div class="card text-center text-white bg-info">
<div class="card-header text-center bg-secondary"><?php echo $first_name." ".$surname;?></div>
  <div class="card-body">
		<p class="card-text"> Address : <?php echo $number." ".$street.", ".$city.", ".$county;?></p>
		<p class="card-text"><a class="text-white" href="tel:<?php echo $phone;?>"> Phone   : <?php echo $phone;?></a></p>
		<p class="card-text"> E-mail  : <?php echo $email;?></p>
	</div>
	<div class="card-footer text-center bg-secondary">
	<?php
	$sql = "SELECT project_name FROM projects WHERE project_id='$project_id' and user_id='$user_id'";
	$result2 = $conn->query($sql);
	if(!$result2)die($conn->error);
	$row1 = $result2->fetch_array(MYSQLI_ASSOC);
	$project_name = $row1['project_name'];
	?>
	<p class="card-text"> Project name  : <?php echo $project_name;?></p>
  </div>
</div>
</div>	
</div>

<?php
	}
	}
	$result->close();
	$conn->close();
?>
