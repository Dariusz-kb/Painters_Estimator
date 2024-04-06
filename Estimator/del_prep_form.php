<?php

require_once('authorisation.php');
include("dbconnect.php");
 //Array to store validation errors
    $errmsg_arr = array();
    //Validation error flag
    $errflag = false;

$user_id = $_SESSION['SESS_USER_ID'];

$preps = array();
$qry = "SELECT * FROM preparation_works where user_id= '$user_id' ";
	$result = $conn->query($qry);
	if (!$result) die ("Database access failed: " . $conn->error);
	if($result->num_rows == 0) {
		$errmsg_arr[] = 'You have no prepataion works in database.';
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
		$preps[$j]= $row;
	}
	}
	?>
<form action="del_prep.php" id="delprep" name="delprep" method="post">	
<div class="form-row">
<div class="form-group col-md-6 offset-md-3">

<div class="table-responsive">
<table class="table table-striped">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Preparation name</th>
	  <th> <input type="submit" name="delete" value="Delete" /></th>
    </tr>
  </thead>
  <tbody>
	
	<?php
		foreach($preps as $prep)  
		{ 
		?>
		
	<tr>
      <td><?php echo $prep['prep_name'];?></td>
	 <td><input type="checkbox" name="del_prep[]" value="<?php echo $prep['prep_id'];?>"/>
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