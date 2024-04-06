<?php
require_once('authorisation.php');
include("dbconnect.php");
    if(isset($_GET["data"]))
    {
       $del_account = $_GET["data"];
        
    }

$user_id = $_SESSION['SESS_USER_ID'];

?>
<br>
<div class="container">
<form action="del_user.php" id="del_user" name="del_user" method="post">
<div class="form row">
  <div class="form-group col-md-6 offset-md-3">
<div class="card text-center text-black bg-warning">
  <div class="card-body">
    <h5 class="card-title"> You are about to delete your user account</h5>
		<p class="card-text"> It  will remove all your data from the database :</p>
		</div>
		<div class="card-footer text-center">
		<a href="index.php?page=user_profile" class="btn btn-light">Cancel</a><button type="submit" class="btn btn-danger" name="project_id">Delete account</button>
   </div>
</div>
</div>	
</div>
</form>
</div>
