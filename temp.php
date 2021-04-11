<?php 
  session_start();

  include_once("connection.php");
  $map_id = $_POST['id'];

  $query = "SELECT * from map where map_id= '$map_id'";
  $row = mysqli_query($con, $query);
  $result = mysqli_fetch_row($row);

   $_SESSION['fname'] = $result['1'];
   $_SESSION['lname'] = $result['2'];
   $_SESSION['gender'] = $result['3'];
   $_SESSION['request'] = $result['4'];
   $_SESSION['lat'] = $result['5'];
   $_SESSION['lng'] = $result['6'];
 ?>
 