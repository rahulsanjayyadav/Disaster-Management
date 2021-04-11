<!DOCTYPE html>
 <html>
 <head>
 	<title>Request</title>
 	<script type='text/javascript' src='jquery-3.4.1.min.js'></script>
 	<meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <style>
      #map {
        height: 500px;
        width: 800px;
      }
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>

 </head>
 <body>

 	 <?php 
      //Variavles to use in html
 	    session_start(); 	
 		  $fname = $_SESSION['fname'];
  		$lname = $_SESSION['lname'];
  		$gender = $_SESSION['gender'];
  		$request = $_SESSION['request'];
  		$lat = $_SESSION['lat'];
  		$lng = $_SESSION['lng'];
  	
	?>

  <!-------------MAP------------>
	<div id="map"></div>
    <script>
      var map;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: <?php echo $lat ?>, lng: <?php echo $lng?>},
          zoom: 17
        });
        var marker = new google.maps.Marker({
        	position: {lat: <?php echo $lat ?>, lng: <?php echo $lng?>}, 
        	map: map
        });

      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB3UjNHkxFsJ-lmCOIDINFpHkXfthClJkA&callback=initMap"
    async defer></script>
 </body>
 </html>