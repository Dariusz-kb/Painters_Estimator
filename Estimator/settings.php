<?php
require_once('authorisation.php');
include("dbconnect.php");
if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
        foreach($_SESSION['ERRMSG_ARR'] as $msg) {
            echo '<center><span style="font-size: 20px; color: Green;">'.$msg.'</span></center>';
        }
        unset($_SESSION['ERRMSG_ARR']);
    }
	
?>

<br>
<div class="accordion col-md-6 offset-md-3" id="settings">
  <div class="card text-center text-black bg-info">
    <div class="card-header" id="add_new">
      <h5 class="mb-0">
        <a class="list-group-item list-group-item-info" data-toggle="collapse" data-target="#show_new" aria-expanded="true" aria-controls="show_new">Add new</a>
      </h5>
    </div>

    <div id="show_new" class="collapse" aria-labelledby="add_new" data-parent="#settings">
      <div class="card-body bg-light">
        <a href="index.php?page=new_item_form" class="list-group-item list-group-item-info"><span style="font-size: 20px;">Add new item</span></a><br>
      <a href="index.php?page=new_material_form" class="list-group-item list-group-item-info"><span style="font-size: 20px;">Add new material</span></a><br>
<a href="index.php?page=new_paint_form" class="list-group-item list-group-item-info"><span style="font-size: 20px;">Add new paint</span></a><br>
<a href="index.php?page=new_primer_form" class="list-group-item list-group-item-info"><span style="font-size: 20px;">Add new primer</span></a><br>
<a href="index.php?page=new_prep_form" class="list-group-item list-group-item-info"><span style="font-size: 20px;">Add preparation work</span></a><br>
<a href="index.php?page=labour_price" class="list-group-item list-group-item-info"><span style="font-size: 20px;">Set labour price</span></a><br>
	  </div>
    </div>
  </div>
 
    <div class="card text-center text-black bg-info">
    <div class="card-header" id="delete">
      <h5 class="mb-0">
        <a class="list-group-item list-group-item-info" data-toggle="collapse" data-target="#show_delete" aria-expanded="true" aria-controls="show_delete">Delete</a>
      </h5>
    </div>

    <div id="show_delete" class="collapse" aria-labelledby="delete" data-parent="#settings">
      <div class="card-body bg-light">
        <a href="index.php?page=del_item_form" class="list-group-item list-group-item-info"><span style="font-size: 20px;">Delete Items</span></a><br>
      <a href="index.php?page=del_mat_form" class="list-group-item list-group-item-info"><span style="font-size: 20px;">Delete Material</span></a><br>
<a href="index.php?page=del_paint_form" class="list-group-item list-group-item-info"><span style="font-size: 20px;">Delete Paint</span></a><br>
<a href="index.php?page=del_primer_form" class="list-group-item list-group-item-info"><span style="font-size: 20px;">Delete Primer</span></a><br>
<a href="index.php?page=del_prep_form" class="list-group-item list-group-item-info"><span style="font-size: 20px;">Delete Preparation Work</span></a><br>
	  </div>
    </div>
  </div>
 </div>
