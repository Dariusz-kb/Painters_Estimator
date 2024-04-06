<?php
require_once('authorisation.php');
include("dbconnect.php");
if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
        foreach($_SESSION['ERRMSG_ARR'] as $msg) {
            echo '<center><span style="font-size: 20px; color: Tomato;">'.$msg.'</span></center>';
        }
        unset($_SESSION['ERRMSG_ARR']);
    }

 if(isset($_GET["data"]))
    {
       $project_id = $_GET["data"];
        
    }

?>
<br>
<form action="create_invoice.php" id="invoice" name="invoice" method="post">
<input type="hidden" class="form-control" id="project_id" name="project_id" value="<?php echo $project_id;?>">

<div class="form row">
 <div class="form-group col-md-6 offset-md-3">
<div class="card text-center text-white bg-info">
<div class="card-header text-center bg-secondary"><h3>Invoice Details</h3></div>
  <div class="card-body">
  
<div class="form-row justify-content-center">
<div class="form-group">
	<label for="invoice_number"><b>Invoice number:</b></label>
  <input type="number" min="1" class="form-control form-control-lg" id="invoice_number" name="invoice_number" placeholder="Enter invoice number" required>
</div>
</div>

<div class="form-row justify-content-center">
<div class="form-group">
	<label for="tax_number"><b>Your tax number:</b></label>
  <input type="text" class="form-control form-control-lg" id="tax_number" name="tax_number" placeholder="Enter your tax number" required>
</div>
</div>

<div class="form-row justify-content-center">
<div class="form-group">
	<label for="vat_rate"><b>Your VAT rate:</b></label>
	<select class="form-control form-control-lg" id="vat_rate" name="vat_rate" required>
	<option value="">Select VAT rate: </option>
	<option value="N/A">N/A</option>
	<option value="0.23">23 %</option>
	<option value="0.135">13.5 %</option>
	</select>
</div>
</div>
	</div>
	<div class="card-footer text-center">
    <a href="index.php?page=open-project" class="btn btn-primary">Go back</a> <button type="submit" class="btn btn-warning">Create invoice</button>
  </div>
</div>
</form>




