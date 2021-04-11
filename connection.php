<?php 

	$con = mysqli_connect('127.0.0.1', 'root','');

    if(!$con) {
      echo 'Not connected';
    }


    if(!mysqli_select_db($con, 'map')) {
      echo 'Database not selected';
    } 
?>