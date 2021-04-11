<!DOCTYPE HTML>
<html>
<head>
<title>Form</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 500px;
        width: 800px;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #description {
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
      }

      #infowindow-content .title {
        font-weight: bold;
      }

      #infowindow-content {
        display: none;
      }

      #map #infowindow-content {
        display: inline;
      }

      .pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
      }

      #pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
      }

      .pac-controls {
        display: inline-block;
        padding: 5px 11px;
      }

      .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 400px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      #title {
        color: #fff;
        background-color: #4d90fe;
        font-size: 25px;
        font-weight: 500;
        padding: 6px 12px;
      }
    </style>
</head>
<body>
  
<?php
    //session_start();
    include_once('connection.php');
    //getting from database
    $query = "SELECT * from map";
    $result = mysqli_query($con, $query);


    //inserting in database
    if(isset($_POST['submit'])) {
      $fname=$_POST['fname'];
      $lname=$_POST['lname'];
      $gender=$_POST['gender'];
      $request=$_POST['request'];
      $lat=$_POST['lat'];
      $lng=$_POST['lng'];
      $query="INSERT INTO map(fname, lname, gender, request, lat, lng) 
      VALUES('$fname', '$lname', '$gender', '$request', '$lat', '$lng')";
      if(!mysqli_query($con, $query)) {
        echo 'Not added';
      } else {
        echo"<div class='alert alert-success'>Pace inserted in Database</div>";
      }
      
      //echo $lat."".$lng;
    }
  ?>


<form method="post" action="">
<fieldset>
    <legend>Personal information:</legend>
 First name:<br>
  <input type="text" name="fname"><br>
  Last name:<br>
  <input type="text" name="lname"><br>
  <input type="radio" name="gender" value="male" checked/> Male<br>
  <input type="radio" name="gender" value="female"/> Female<br>
  <input type="radio" name="gender" value="other"/> Other<br>


  Emergency:<input type="textarea" name='request'id='help'/>

  <input type="hidden" name="lat" id="lat">
  <input type="hidden" name="lng" id="lng">
  <input type="hidden" name="loc" id="loc">
    
  
  <div class="pac-card" id="pac-card">
      <div>
        <div id="title">
          Search Your Location
        </div>
        <div id="type-selector" class="pac-controls">
        </div>
      </div>
      <div id="pac-container">
        <input id="pac-input" type="text"
            placeholder="Enter a location">
      </div>
      
      
    
    </div>
    <div id="map"></div>
    <div id="infowindow-content">
      <img src="" width="16" height="16" id="place-icon">
      <span id="place-name"  class="title"></span><br>
      <span id="place-address"></span>
    </div>

    <script>
      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 19.07283, lng: 72.88261},
          zoom: 17
        });
        var card = document.getElementById('pac-card');
        var input = document.getElementById('pac-input');
        var types = document.getElementById('type-selector');
        var strictBounds = document.getElementById('strict-bounds-selector');

        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);

        var autocomplete = new google.maps.places.Autocomplete(input);

        // Bind the map's bounds (viewport) property to the autocomplete object,
        // so that the autocomplete requests use the current map bounds for the
        // bounds option in the request.
        autocomplete.bindTo('bounds', map);

        // Set the data fields to return when the user selects a place.
        autocomplete.setFields(
            ['address_components', 'geometry', 'icon', 'name']);

        var infowindow = new google.maps.InfoWindow();
        var infowindowContent = document.getElementById('infowindow-content');
        infowindow.setContent(infowindowContent);
        var marker = new google.maps.Marker({
          map: map,
          draggable: true,
          anchorPoint: new google.maps.Point(0, -29)
        });

        google.maps.event.addListener(marker, 'dragend', function() {
          geocodePosition(marker.getPosition());
        });

        function geocodePosition(pos) 
{
   geocoder = new google.maps.Geocoder();
   geocoder.geocode
    ({
        latLng: pos
    }, 
        function(results, status) 
        {
            if (status == google.maps.GeocoderStatus.OK) 
            {
                $("#mapSearchInput").val(results[0].formatted_address);
                $("#mapErrorMsg").hide(100);
            } 
            else 
            {
                $("#mapErrorMsg").html('Cannot determine address at this location.'+status).show(100);
            }
        }
    );
}

        autocomplete.addListener('place_changed', function() {
          infowindow.close();
          marker.setVisible(false);
          var place = autocomplete.getPlace();
          if (!place.geometry) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            window.alert("No details available for input: '" + place.name + "'");
            return;
          }

          // If the place has a geometry, then present it on a map.
          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(24);  // Why 17? Because it looks good.
          }
          marker.setPosition(place.geometry.location);
          marker.setVisible(true);

          var posLat = place.geometry.location.lat();
          var posLng = place.geometry.location.lng();
          var posLoc = place.formatted_address;


          //alert("lat="+posLat+"lng="+posLng+"loc="+posLoc);
          document.getElementById("lat").value=posLat;
          document.getElementById("lng").value=posLng;

          //$("#loc").val(posLoc);
          //$("#fname").getElementByName("fname");
          //$("#lname").getElementByName("lname");
          //$("#gender").get(gender);
          //$("#request").val(request);

          //alert("fname="+fname)


          var address = '';
          if (place.address_components) {
            address = [
              (place.address_components[0] && place.address_components[0].short_name || ''),
              (place.address_components[1] && place.address_components[1].short_name || ''),
              (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
          }

          infowindowContent.children['place-icon'].src = place.icon;
          infowindowContent.children['place-name'].textContent = place.name;
          infowindowContent.children['place-address'].textContent = address;
          infowindow.open(map, marker);
        });

        // Sets a listener on a radio button to change the filter type on Places
        // Autocomplete.
        function setupClickListener(id, types) {
          var radioButton = document.getElementById(id);
          radioButton.addEventListener('click', function() {
            autocomplete.setTypes(types);
          });
        }

        setupClickListener('changetype-all', []);
        setupClickListener('changetype-address', ['address']);
        setupClickListener('changetype-establishment', ['establishment']);
        setupClickListener('changetype-geocode', ['geocode']);

        document.getElementById('use-strict-bounds')
            .addEventListener('click', function() {
              console.log('Checkbox clicked! New state=' + this.checked);
              autocomplete.setOptions({strictBounds: this.checked});
            });
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB3UjNHkxFsJ-lmCOIDINFpHkXfthClJkA&libraries=places&callback=initMap"
        async defer></script>

  <input type="submit" name="submit" value="Submit">
  </fieldset>
 </form>

 </body>
 </html>