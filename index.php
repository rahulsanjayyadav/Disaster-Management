<html>
<head>
<meta charset="UTF-8">
<title>FLOODS</title>
<script type='text/javascript' src='jquery-3.4.1.min.js'></script>
  
<style>
p{
color:black;
positon:relative;
align:center
}
img{
opacity:0.8;
linear-gradient:(top,);
}

.bottom-left {
  position: absolute;
  bottom: 20px;
  left: 20px
  }
  
 a:link,a:visited{
  background-color: #f44336;
  color: white;
  text-decoration: none;
   padding: 15px 25px;
   top:30px;
  text-align: center;
   display: inline-block
}
 a:hover,a:active {
  background-color: red;
  text-decoration: underline;
}
  
  
</style>
</head>
<body>
<!------------Upper tiles-------------->
<?php
    
    include_once('connection.php');    
    $query = "SELECT * from map";
    $result = mysqli_query($con, $query);
?>

<?php

  while($rows=mysqli_fetch_assoc($result)) {

?>

<!----------------Div for Uppertiles---------------->
  <div onclick="redirect(this.id)" style="display:inline-block; height: 200px; width: 300px; background-color: blue"
  id="<?php echo htmlspecialchars($rows['map_id']);?>">
    <?php echo $rows['fname'] ?></div>

<?php 
  }
?>

<img  src="f1.jpg" width="cover" height="cover" >
<div class="bottom-left"><h1><b>FLOODS</b></h1><br></div>
<p  style="overflow:auto; width: 300px; height:300px;"></p>
<a href="formproject.php">HELP</a>

<script>
  
  function redirect(ID){    
      var a = ID;
      $.post('temp.php',{id:a},
        function(data){
            window.location.href = "request.php";
        });
  }

</script>
 
</body>
</html>