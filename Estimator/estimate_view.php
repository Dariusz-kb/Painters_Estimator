<?php
require_once('authorisation.php');
include ("dbconnect.php");
if(isset($_GET["data"]))
    {
       $_SESSION['SESS_PROJECT_ID'] = $_GET["data"];
        
    }
$estimate_id = $_SESSION['SESS_PROJECT_ID'];
?>

<br>
<form action="del_est_item.php" id="del_item" name="del_item" method="post">

<div class="table-responsive-sm">
<table class="table table-striped">
  <thead class="thead-dark">
    <tr>
	  <th scope="col"><button type="submit" name="delete" id="del_btn"><i class="fas fa-trash-alt"></i></button></th>
      <th scope="col">Item </th>
      <th scope="col">Units</th>
      <th scope="col">Coats</th>
      <th scope="col">Price</th>
    </tr>
  </thead>
  <tbody>

<?php

$end_price = 0;
$qry = "SELECT est_item_id, item_name, total_area, no_coats, total_time, total_price FROM estimates where estimate_id='$estimate_id' ORDER BY est_item_id DESC";
$result = $conn->query($qry);
if (!$result) die ("Database access failed: ". $conn->error);
	$rows = $result->num_rows;
	for($j=0; $j< $rows; ++$j)
	{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$est_item_id = $row['est_item_id'];
		$item_name = $row['item_name'];
		$total_area = $row['total_area'];
		$total_area= round($total_area, 2);
		$no_coats = $row['no_coats'];	
		$total_time = $row['total_time'];
		$total_price = $row['total_price'];
		$total_price = round($total_price, 2);
		$end_price = $end_price + $total_price;
		$end_price = round($end_price, 2);
		?>
	<tr>
	  <th scope="row"><input type="checkbox" name="del_item[]" value="<?php echo $est_item_id;?>"/></th>
      <td><?php echo $item_name; ?></td>
	  <td><?php echo $total_area; ?></td>
	  <td><?php echo $no_coats; ?></td>
	  <td><?php echo $total_price; ?></td>
    </tr>
	
	<?php
	}

	
	?>
	<tr class="table-info text-right">
      <td colspan='5'><b> Total project price : &euro; <?php echo $end_price; ?></b></td>
	  </tr>
   </tbody>
</table>
</div>
<div class="form-row justify-content-center">
<div class="form-group">
<a type="button" class="btn btn-warning" href="index.php?page=create_estimate"> Add another item </a>
<a type="button" class="btn btn-success" href="index.php?page=open-project"> Finish </a>
</div>
</div>
</div>
</div>
</form>


