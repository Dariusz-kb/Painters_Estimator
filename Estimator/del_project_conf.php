<?php
require_once('authorisation.php');
include("dbconnect.php");
    if(isset($_GET["data"]))
    {
       $project_id = $_GET["data"];
        
    }

$user_id = $_SESSION['SESS_USER_ID'];

$sql = "SELECT project_name FROM projects WHERE project_id = '$project_id' and user_id='$user_id'";
	$result = $conn->query($sql);
	if(!$result)die($conn->error);
	
$rows = $result->num_rows;
for($j=0; $j< $rows; ++$j)
	{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$project_name = $row['project_name'];
}

?>
<br>
<div class="container">
<form action="del_project.php" id="del_project" name="del_project" method="post">
<div class="form row">
  <div class="form-group col-md-6 offset-md-3">
<div class="card text-center text-black bg-warning">
  <div class="card-body">
    <h5 class="card-title"> You are about to delete the project</h5>
		<p class="card-text"><span style="font-size: 25px; color: Black;"><?php echo $project_name;?></span></p>
		<p class="card-text"> Removing the project will also remove all record asosiated with this project :</p>
		</div>
		<div class="card-footer text-center">
		<a href="index.php?page=open-project" class="btn btn-light">Cancel</a><button type="submit" class="btn btn-danger" name="project_id" value="<?php echo $project_id;?>">Delete Project</button>
   </div>
</div>
</div>	
</div>
</form>
</div>

