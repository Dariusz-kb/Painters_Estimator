<?php
require_once('authorisation.php');
include("dbconnect.php");
$user_id = $_SESSION['SESS_USER_ID'];
// check if there was call from open project page to add estimate to project 
// if it was then set $_SESSION['SESS_PROJECT_ID'] to to project_id that is being passed in url
if(isset($_GET["data"]))
    {
       $_SESSION['SESS_PROJECT_ID'] = $_GET["data"];
        
    }

?>
<script type="text/javascript">
$(document).ready(function(){
    $('#worktype').on('change',function(){
        var typeID = $(this).val();
        if(typeID){
            $.ajax({
                type:'POST',
                url:'ajax.php',
				data:'type_id='+typeID,
                success:function(html){
                    $('#category').html(html);
					$('#item').html('<option value="">Select category</option>'); 
                }
            }); 
			
			
        }else{
            $('#category').html('<option value="">Select type of work</option>');
			$('#item').html('<option value="">Select category</option>'); 

        }
    });
	  $('#category').on('change',function(){
        var categoryID = $(this).val();
        if(categoryID){
            $.ajax({
                type:'POST',
                url:'ajax.php',
                data:'cat_id='+categoryID,
                success:function(html){
                    $('#item').html(html);
                }
            }); 
        }else{
            $('#item').html('<option value="">Select category</option>'); 
        }
    });
	
	$('#item').on('change',function(){
        var itemID = $(this).val();
        if(itemID != ""){
			$('#preparations').show();
			$('#materials').show();
			$('#primer').show();
			$('#paints').show();
			$('#measurement').show();
		
				$.ajax({
                type:'POST',
                url:'ajax.php',
                data:'item_id='+itemID,
                success:function(html){
                    $('#measurement').html(html);
                }
            }); 
        }else{
			$('#preparations').hide();
			$('#materials').hide();
			$('#primer').hide();
			$('#paints').hide();
            $('#measurement').hide();
			
        }
    });
	
	 $('#base_type').on('change',function(){
        var baseid = $(this).val();
        if(baseid){
            $.ajax({
                type:'POST',
                url:'ajax.php',
				data:'base_id='+baseid,
                success:function(html){
                    $('#brand').html(html);
					$('#finish').html('<option value="">Select Brand</option>'); 
                }
            }); 
			
			
        }else{
            $('#brand').html('<option value="">Select base first</option>');
			$('#finish').html('<option value="">Select brand first</option>'); 

        }
    });
	
	$('#brand').on('change',function(){
        var brandid = $(this).val();
        if(brandid){
            $.ajax({
                type:'POST',
                url:'ajax.php',
				data:'brand_id='+brandid,
                success:function(html){
                    $('#finish').html(html);
					
                }
            }); 
			
			
        }else{
        
			$('#finish').html('<option value="">Select brand first</option>'); 

        }
    });
	
	
	
	$('#add_paint').click(function(){
            if($(this).prop("checked") == true){
                $('#display_paints').show();
				$('#base_type').attr('required', '');
				$('#brand').attr('required', '');
				$('#finish').attr('required', '');
            }
            else if($(this).prop("checked") == false){
			$('#display_paints').hide();
			$('#base_type').removeAttr('required');
			$('#brand').removeAttr('required');
			$('#finish').removeAttr('required');
            }
        });
		
		$('#add_primer').click(function(){
            if($(this).prop("checked") == true){
                $('#display_primer').show();
				$('#primer_select').attr('required', '');
            }
            else if($(this).prop("checked") == false){
			$('#display_primer').hide();
			$('#primer_select').removeAttr('required');
            }
        });
		
		$('#add_material').click(function(){
            if($(this).prop("checked") == true){
                $('#display_materials').show();
            }
            else if($(this).prop("checked") == false){
			$('#display_materials').hide();
            }
        });
		
		$('#add_prep').click(function(){
            if($(this).prop("checked") == true){
                $('#display_prep').show();
            }
            else if($(this).prop("checked") == false){
			$('#display_prep').hide();
            }
        });
		
	
	});
	
	
</script>

<?php
if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
        foreach($_SESSION['ERRMSG_ARR'] as $msg) {
            echo '<center><span style="font-size: 20px; color: Tomato;">'.$msg.'</span></center>';
        }
        unset($_SESSION['ERRMSG_ARR']);
    }
?>
<div class="container col-md-6 bg-info">
<br>
<center><span style="font-size: 25px; color: White;">Items selection.</span></center>
<form method="post" action="test.php" align="center" id="newprojectForm">
<br>
<div class="form-row">
	<div class="form-group col-md-6 offset-md-3">
 <label for="worktype"><b>Choose type of work:</b></label>
    <select class="form-control form-control-lg" id="worktype" name="worktype" required>
	<option value="">Select type of work: </option>
	<?php
$sql = "SELECT * FROM work_type";
$result = $conn->query($sql);
if(!$result)die($conn->error);

$rows = $result->num_rows;
for($j=0; $j< $rows; ++$j)
	{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		echo '<option value="'.$row['type_id'].'">'.$row['type'].'</option>';

	}

		?>
	
	
	</select>
</div>
</div>

<div class="form-row">
	<div class="form-group col-md-6 offset-md-3">
    <label for="category"><b>Choose Category:</b></label>
    <select class="form-control form-control-lg" id="category" name="category" required>
	<option> Select type of work </option>
	</select>
</div>	
</div>

<div class="form-row">
	<div class="form-group col-md-6 offset-md-3">
    <label for="item"><b>Choose item:</b></label>
    <select class="form-control form-control-lg" id="item" name="item" required>	
	<option> Select type of work </option>
	</select>
</div>	
</div>



<!-- div to display apropriate measure type -->
<div class="form-row">
	<div class="form-group col-md-6 offset-md-3" id="measurement">
</div>
</div>

<div class="form-row" id="paints" style="display: none;">
<div class="form-group offset-md-3">
<div class="custom-control custom-checkbox">
  <input type="checkbox" class="custom-control-input" name="add_paint" id="add_paint" value="">
  <label class="custom-control-label" for="add_paint"><span style="font-size: 25px; color: Blue;"> Add paint </span> </label>
</div>
</div>
</div>

<div class="container" id="display_paints" style="display: none;">

<div class="form-row">
	<div class="form-group col-md-6 offset-md-3">
<label for="base_type"><b>Choose base:</b></label>
    <select class="form-control form-control-lg" id="base_type" name="base_type">
	<option value=""> Choose base </option>

<?php
include("dbconnect.php");
$sql = "SELECT base_id, base_type FROM base_type where user_id='$user_id'";
$result = $conn->query($sql);
if(!$result)die($conn->error);

$rows = $result->num_rows;
for($j=0; $j< $rows; ++$j)
	{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		echo '<option value="'.$row['base_id'].'">'.$row['base_type'].'</option>';

	}




?>
	</select>
</div>
</div>

<div class="form-row">
	<div class="form-group col-md-6 offset-md-3">	
<label for="brand"><b>Select brand:</b></label>
    <select class="form-control form-control-lg" id="brand" name="brand">
	<option value=""> Choose base first </option>
	</select>
</div>
</div>

<div class="form-row">
	<div class="form-group col-md-6 offset-md-3">
<label for="finish"><b>Select finish:</b></label>
    <select class="form-control form-control-lg" id="finish" name="finish">
	<option value=""> Choose brand first </option>
	</select>

</div>
</div>
</div>

<div class="form-row" id="primer" style="display: none;">
<div class="form-group offset-md-3">
<div class="custom-control custom-checkbox">
  <input type="checkbox" class="custom-control-input" name="add_primer" id="add_primer" value="">
  <label class="custom-control-label" for="add_primer"><span style="font-size: 25px; color: Blue;"> Add primer </span> </label>
</div>
</div>
</div>


<div class="container" id="display_primer" style="display: none;">
<div class="form-row">
	<div class="form-group col-md-6 offset-md-3">
<label for="primer_select"><b>Choose primer:</b></label>
    <select class="form-control form-control-lg" id="primer_select" name="primer_select">
	<option value=""> Choose primer ... </option>

<?php
include("dbconnect.php");
$sql = "SELECT * FROM primers_undercoats where user_id = '$user_id' ORDER BY primer_brand ASC";
$result = $conn->query($sql);
if(!$result)die($conn->error);

$rows = $result->num_rows;
for($j=0; $j< $rows; ++$j)
	{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$primer_id = $row['primer_id'];
		$primer_name = $row['primer_name'];
		$primer_name = ucfirst($primer_name);
		$primer_brand = $row['primer_brand'];
		$primer_brand = ucfirst($primer_brand);
		echo '<option value="'.$primer_id.'">'.$primer_brand.' - '.$primer_name.'</option>';

	}

?>
	</select>
</div>
</div>
</div>



<div class="form-row" id="materials" style="display: none;">
<div class="form-group offset-md-3">
<div class="custom-control custom-checkbox">
  <input type="checkbox" class="custom-control-input" name="add_material" id="add_material" value="">
  <label class="custom-control-label" for="add_material"><span style="font-size: 25px; color: Blue;"> Add materials </span></label>
</div>
</div>
</div>

<div class="container" id="display_materials" style="display: none;">
<div class="form-row">
<div class="form-group col-md-6 offset-md-3">
<div class="card">
  <div class="card-body">
  
	<?php
	
$materials = array();
 $qry = "SELECT * FROM materials where user_id = '$user_id'";
 $result = $conn->query($qry);
  if (!$result) die ("Database access failed: " . $conn->error);
	$rows = $result->num_rows;
	for($j=0; $j< $rows; ++$j)
	{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$materials[$j] = $row['type'];
				
	}
	$lgt = count($materials);
		for($j=0; $j< $lgt; ++$j)
			{
			?>
	<div class="custom-control custom-checkbox" style="display: block;">
  <input type="checkbox" class="custom-control-input" name="materials[]" id="<?php echo $materials[$j]; ?>" value="<?php echo $materials[$j]; ?>">
  <label class="custom-control-label" for="<?php echo $materials[$j]; ?>"><span style="font-size: 20px; color: Black;"><?php echo $materials[$j]; ?></span></label>
</div>

	<?php
	
	}

	?>
	 
  </div>
</div>
</div>
</div>
</div>

<div class="form-row" id="preparations" style="display: none;">
<div class="form-group offset-md-3">
<div class="custom-control custom-checkbox">
  <input type="checkbox" class="custom-control-input" name="add_prep" id="add_prep" value="">
  <label class="custom-control-label" for="add_prep"><span style="font-size: 25px; color: Blue;"> Add preparation works </span> </label>
</div>
</div>
</div>

<div class="container" id="display_prep" style="display: none;"> 
<div class="form-row">
<div class="form-group col-md-6 offset-md-3">
<div class="card">
  <div class="card-body">
  
	<?php
	
$preparations = array();
 $qry = "SELECT prep_name FROM preparation_works where user_id = '$user_id'";
 $result = $conn->query($qry);
  if (!$result) die ("Database access failed: " . $conn->error);
	$rows = $result->num_rows;
	for($j=0; $j< $rows; ++$j)
	{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$preparations[$j] = $row['prep_name'];
				
	}
	$lgt = count($preparations);
		for($j=0; $j< $lgt; ++$j)
			{
			?>
	<div class="custom-control custom-checkbox" style="display: block;">
  <input type="checkbox" class="custom-control-input" name="prep[]" id="<?php echo $preparations[$j]; ?>" value="<?php echo $preparations[$j]; ?>">
  <label class="custom-control-label" for="<?php echo $preparations[$j]; ?>"><span style="font-size: 20px; color: Black;"><?php echo $preparations[$j]; ?></span></label>
	</div>

	<?php
	
	}

	?>
	<hr width="100%">
	 <label for="prep_time">Enter total prep time in hours:</label>
    <input type="number" min="0" step="0.01" class="form-control form-control-lg" id="prep_time" name="prep_time">
	
  </div>
</div>
</div>
</div>
</div>
<div class="form-row justify-content-center">
<button class='btn btn-warning btn-lg' type='submit'> Estimate </button>
</div>
</form>

<br>	
<br>
<!-- end of form -->
</div>  <!-- end of form container -->
