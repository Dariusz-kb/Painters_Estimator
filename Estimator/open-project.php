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
	$project_info = array();
	$count_projects = 0;
	$sql = "SELECT * FROM projects WHERE user_id='$user_id' ORDER BY project_id DESC;";
	$result = $conn->query($sql);
	if(!$result)die($conn->error);
		$rows = $result->num_rows;
		for($j=0; $j< $rows; ++$j)	{
			$result->data_seek($j);
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$project_info[$j] = $row;
				}
			$count_projects = count($project_info);
			if ($count_projects == 0) {
			?>
	<br>	
<div class="form row">
  <div class="form-group col-md-6 offset-md-3">
	<div class="card text-center text-white bg-info">
		<div class="card-body">	
			<p class="card-text">You have currently no projects created.</p>
	
		</div>
	</div>
  </div>	
</div>
		
	<?php
}
else {


foreach($project_info as $project) {
?>
<br>
<div class="form row">
  <div class="form-group col-md-6 offset-md-3">
<div class="card text-center text-white bg-info">
<div class="card-header text-center bg-secondary"><?php echo $project['project_name'];?></div>
  <div class="card-body">
		 <p class="card-text"> Project address : <?php echo $project['number']." ".$project['street'].", ".$project['city'].", ".$project['county'];?></p>
		<p class="card-text"> Project description : <?php echo $project['description'];?></p>
		<p class="card-text"> Date created : <?php echo $project['date_created'];?></p>
	<?php
	$sql = "SELECT * FROM costumers_db where user_id='$user_id' and project_id='".$project['project_id']."' ";
	$result = $conn->query($sql);
	if(!$result)die($conn->error);
	if($result->num_rows == 0) {
	echo "</div>";
	echo "<p class='card-text'><span style='font-size: 20px; color: Yellow;'> You didnt add client into project</span> </p>";
	echo "<a href='index.php?page=contact_form&data=".$project['project_id']."' class='btn btn-primary'>Add client details</a>";
	echo "<div class='card-footer text-center bg-secondary'>";
    echo "<a href='index.php?page=del_project_conf&data=".$project['project_id']."' class='btn btn-danger'>Delete</a> ";
	echo "<button class='btn btn-primary' disabled>Edit</button> ";
	echo "<button class='btn btn-warning' disabled>Invoice</button> ";
	echo "<button class='btn btn-success' disabled>PDF</button> ";
	echo "</div></div></div></div>";
	}
	else{
	$rows = $result->num_rows;
	for($j=0; $j< $rows; ++$j)
	{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$first_name = $row['first_name'];
		$first_name = ucfirst($first_name);
		$surname = $row['surname'];
		$surname = ucfirst($surname);
		$phone = $row['phone'];
		$email = $row['email'];
	}
	
	?>
	<p class="card-text"> Client name : <?php echo $first_name." ".$surname;?></p>
	<p class="card-text"> Phone : <?php echo $phone;?></p>
	<p class="card-text"> E-mail : <?php echo $email;?></p>
<?php	

	$qry = "SELECT * FROM estimates where estimate_id='".$project['project_id']."'";
	$result = $conn->query($qry);
	if (!$result) die ("Database access failed: ". $conn->error);
	if($result->num_rows != 0) {
		echo "</div>"; //card body
		echo "<div class='card-footer text-center bg-secondary'>";
		echo "<a href='index.php?page=del_project_conf&data=".$project['project_id']."' class='btn btn-danger'>Delete</a> ";
		echo "<a href='index.php?page=estimate_view&data=".$project['project_id']."' class='btn btn-primary'>Edit</a> ";
		echo "<a href='index.php?page=invoice_form&data=".$project['project_id']."' class='btn btn-warning'>Invoice</a> ";
		echo "<a href='create_pdf.php?data=".$project['project_id']."' class='btn btn-success'>PDF</a> ";
		echo "</div>";
		echo "</div>";
		echo "</div>";
		echo "</div>";
		}
	else{
		echo "</div>"; //card body
		echo "<p class='card-text'><span style='font-size: 20px; color: Yellow;'> You didnt create estimate for this project</span> </p>";
		echo "<a href='index.php?page=create_estimate&data=".$project['project_id']."' class='btn btn-primary'> Add estimate </a>";
		echo "<div class='card-footer text-center bg-secondary'>";
		echo "<a href='index.php?page=del_project_conf&data=".$project['project_id']."' class='btn btn-danger'> Delete </a> ";
		echo "<button class='btn btn-primary' disabled>Edit</button> ";
		echo "<button class='btn btn-warning' disabled>Invoice</button> ";
		echo "<button class='btn btn-success' disabled>PDF</button> ";
		echo "</div></div></div></div>";
		}

	}
}
}

?>
	