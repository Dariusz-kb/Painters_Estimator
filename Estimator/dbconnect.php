<?php
require_once('config.php');
		$conn = new mysqli($hn, $un, $pw, $db);
			if($conn->connect_error)die($conn->connect_error);
//else echo "Connected"."<br>" ;
?>