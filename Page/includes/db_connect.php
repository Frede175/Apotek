<?php
  include_once 'pls-config.php';
  $mysqli = new mysqli(SERVER, USER, PASSWORD, DATABASE);

  if(mysqli_connect_errno()){
		echo "Failed to connect: " . mysqli_connect_error();
	}
?>
