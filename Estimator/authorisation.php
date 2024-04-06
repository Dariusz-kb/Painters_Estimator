<?php
    if(!isset($_SESSION['SESS_USER_ID']) || (trim($_SESSION['SESS_USER_ID']) == '')) {
        header("location: loginform.php");
       exit();
    }
?>
