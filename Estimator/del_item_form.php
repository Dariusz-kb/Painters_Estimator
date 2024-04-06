<?php

require_once('authorisation.php');
include("dbconnect.php");
 //Array to store validation errors
    $errmsg_arr = array();
    //Validation error flag
    $errflag = false;

$user_id = $_SESSION['SESS_USER_ID'];

$items = array();
$qry = "SELECT item_id, item_name FROM items where user_id= '$user_id' ";
	$result = $conn->query($qry);
	if (!$result) die ("Database access failed: " . $conn->error);
	if($result->num_rows == 0) {
		$errmsg_arr[] = 'You have no items in database.';
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
		$items[$j]= $row;
	}
	}
	?>
	
<form action="del_item.php" id="delitem" name="del_item" method="post">	
<div class="form-row">
<div class="form-group col-md-6 offset-md-3">

<div class="table-responsive">
<table class="table table-striped">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Item_name</th>
	  <th> <input type="submit" name="delete" id="del_btn" value="Delete"/></th>
    </tr>
  </thead>
  <tbody>
	
	<?php
		foreach($items as $item)  
		{ 
		?>
		
	<tr>
      <td><?php echo $item['item_name'];?></td>
	 <td><input type="checkbox" name="del_item[]" value="<?php echo $item['item_id'];?>"/></td>
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