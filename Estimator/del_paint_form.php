<?php

require_once('authorisation.php');
include("dbconnect.php");
 //Array to store validation errors
    $errmsg_arr = array();
    //Validation error flag
    $errflag = false;

$user_id = $_SESSION['SESS_USER_ID'];

$paints = array();
$qry = "SELECT * FROM paint_info where user_id= '$user_id' ";
	$result = $conn->query($qry);
	if (!$result) die ("Database access failed: " . $conn->error);
	if($result->num_rows == 0) {
		$errmsg_arr[] = 'You have no paint in database.';
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
		$paints[$j]= $row;
	}
	}
	?>
<form action="del_paint.php" id="del_paint" name="del_paint" method="post">	
<div class="form-row">
<div class="form-group col-md-6 offset-md-3">

<div class="table-responsive">
<table class="table table-striped">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Brand</th>
	  <th scope="col">Base</th>
	  <th scope="col">Finish</th>
	  
	  <th> <input type="submit" name="delete" value="Delete" /></th>
    </tr>
  </thead>
  <tbody>
	
	<?php
		foreach($paints as $paint)  
		{ 
		//echo $paint['brand_id'];
			$qry = "SELECT brand_name FROM brands where brand_id ='".$paint['brand_id']."' and user_id ='$user_id' ";
			$result = $conn->query($qry);
			if (!$result) die ("Database access failed: " . $conn->error);
			$rows = $result->num_rows;
				for($j=0; $j< $rows; ++$j)
				{
				$result->data_seek($j);
				$row = $result->fetch_array(MYSQLI_ASSOC);
				$brand_name = $row['brand_name'];
				?>
				<tr>
				<td><?php echo $brand_name;?></td>
				<?php
				
		$qry = "SELECT base_type FROM base_type where base_id ='".$paint['base_id']."' and user_id ='$user_id' ";
			$result = $conn->query($qry);
			if (!$result) die ("Database access failed: " . $conn->error);
			$rows = $result->num_rows;
				for($j=0; $j< $rows; ++$j)
				{
				$result->data_seek($j);
				$row = $result->fetch_array(MYSQLI_ASSOC);
				$base_type = $row['base_type'];
				?>
				<td><?php echo $base_type;?></td>
				<?php
				
				$qry = "SELECT finish_type FROM finish_type where finish_id ='".$paint['finish_id']."' and user_id ='$user_id' ";
			$result = $conn->query($qry);
			if (!$result) die ("Database access failed: " . $conn->error);
			$rows = $result->num_rows;
				for($j=0; $j< $rows; ++$j)
				{
				$result->data_seek($j);
				$row = $result->fetch_array(MYSQLI_ASSOC);
				$finish_type = $row['finish_type'];
				?>
				<td><?php echo $finish_type;?></td>
				<?php
				
				}
				}
				}
				?>
				<td><input type="checkbox" name="del_paint[]" value="<?php echo $paint['paint_id'];?>"/>
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
		
