<?php
require_once('authorisation.php');
include("dbconnect.php");
if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
        foreach($_SESSION['ERRMSG_ARR'] as $msg) {
            echo '<center><span style="font-size: 20px; color: Green;">'.$msg.'</span></center>';
        }
        unset($_SESSION['ERRMSG_ARR']);
    }
$_SESSION['SESS_PROJECT_ID'] = 0;
$user_id = $_SESSION['SESS_USER_ID'];

$items=array();
$qry = "SELECT * FROM items where user_id= '$user_id'";
	$result = $conn->query($qry);
	if (!$result) die ("Database access failed: " . $conn->error);
	$rows = $result->num_rows;
	for($j=0; $j< $rows; ++$j)
	{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$items[$j] = $row;
	}
	$count_items=0;
	$count_items = count($items);
	if ($count_items == 0) {
	?>	
<div class="form row">
  <div class="form-group col-md-6 offset-md-3">
<div class="card text-center text-white bg-info">
  <div class="card-body">	
    <p class="card-text">You have no items added to data base.</p>
	<p class="card-text">To start creating estimates you must first add painting items.</p>
	<p class="card-text">Click button bellow to add items.</p>
    <a href="index.php?page=new_item_form" class="btn btn-warning"> Add items </a>
  </div>
</div>
</div>	
</div>
	<?php
}
$qry = "SELECT prep_price FROM labour_price where user_id= '$user_id'";
	$result = $conn->query($qry);
	if (!$result) die ("Database access failed: " . $conn->error);
	$rows = $result->num_rows;
	if($result->num_rows == 0) {
		?>
		<div class="form row">
  <div class="form-group col-md-6 offset-md-3">
<div class="card text-center text-white bg-info">
  <div class="card-body">	
    <p class="card-text">You didnt set the labour price per hour yet.</p>
	<p class="card-text">Click button bellow set labour price.</p>
    <a href="index.php?page=labour_price" class="btn btn-warning"> Set labour price </a>
  </div>
</div>
</div>	
</div>
		
	<?php
	}


else {
	
	?>
	
<br>
<div class="container col-md-6 bg-info">
<br>
<center><span style="font-size: 25px; color: White;">Project details.</span></center>
<br>
<form action="new-project.php" id="newprojectForm" name="newProject" method="post" align="center">
<div class="form-row">
    <div class="form-group col-md-6 offset-md-3">
      <label for="projectname">Project name:</label>
      <input type="text" pattern="[a-zA-Z0-9 ]+"class="form-control form-control-lg" name="projectname" placeholder="Project Name" required>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-6 offset-md-3">
      <label for="housenumber">House number:</label>
      <input type="text" pattern="[0-9]+" class="form-control form-control-lg" name="housenumber" placeholder="House number" required>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-6 offset-md-3">
      <label for="street">Street name:</label>
      <input type="text" pattern="[a-zA-Z ]+" class="form-control form-control-lg" name="street" placeholder="Street Name" required>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-6 offset-md-3">
      <label for="city">City:</label>
      <input type="text" pattern="[a-zA-Z ]+" class="form-control form-control-lg" name="city" placeholder="City" required>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-6 offset-md-3">
      <label for="county">County:</label>
      <input type="text" pattern="[a-zA-Z ]+" class="form-control form-control-lg" name="county" placeholder="County" required>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-6 offset-md-3">
		<label for="description">Project description:</label>
		<textarea pattern="[a-zA-Z0-9 ]+" class="form-control form-control-lg" rows="3" name="description" placeholder="Enter description here..." required></textarea>
         </div>
</div>
<div class="form-row justify-content-center">
 <button type="submit" class="btn btn-warning btn-lg">Save and Next</button>
 </div>
 <br>
</form>
</div>
<?php
}

$result->close();
$conn->close();

?>
