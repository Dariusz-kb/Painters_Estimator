<?php

require_once('authorisation.php');
include("dbconnect.php");
 //Array to store validation errors
    $errmsg_arr = array();
    //Validation error flag
    $errflag = false;

$user_id = $_SESSION['SESS_USER_ID'];

$materials = array();
$qry = "SELECT material_id, type, price FROM materials where user_id= '$user_id' ";
	$result = $conn->query($qry);
	if (!$result) die ("Database access failed: " . $conn->error);
	if($result->num_rows == 0) {
		$errmsg_arr[] = 'You have no materials in database.';
        $errflag = true;
		if($errflag) {
        $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
        session_write_close();
        header("location: index.php?page=settings");
        exit();
		}
	}
	else {
				
	$rows = $result->num_rows;
	for($j=0; $j< $rows; ++$j)
	{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$materials[$j]= $row;
	}
	}
	?>
<form action="del_material.php" id="del_material" name="del_material" method="post">	
<div class="form-row">
<div class="form-group col-md-6 offset-md-3">

<div class="table-responsive">
<table class="table table-striped">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Material name</th>
	  <th scope="col">Price</th>
	  <th> <input type="submit" name="delete" value="Delete" /></th>
    </tr>
  </thead>
  <tbody>
	
	<?php
		foreach($materials as $material)  
		{ 
		?>
		
	<tr>
      <td><?php echo $material['type'];?></td>
	  <td><?php echo $material['price'];?></td>
	 <td><input type="checkbox" name="del_mat[]" value="<?php echo $material['material_id'];?>"/>
    </tr>
	
	<?php
	
		}
	?>
   </tbody>
</table>

</div>
</div>
</div>
</form>