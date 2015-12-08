<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Rectangles</title>
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 100%;
      }
    </style>
    <script>

// This example adds a red rectangle to a map.

function initMap() {
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 15,
    center: {lat: 40.779498, lng: -73.949602},
    mapTypeId: google.maps.MapTypeId.TERRAIN
  });

  var rectangle = new google.maps.Rectangle({
    strokeColor: '#FF0000',
    strokeOpacity: 0.8,
    strokeWeight: 2,
    fillColor: '#FF0000',
    fillOpacity: 0.35,
    map: map,
    bounds: {
      north: 40.779498,
      south: 40.778490,
      east: -73.949602,
      west: -73.959107
    }
  });
}

    </script>
  </head>
  <body>
    <div id="map"></div>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBJcflEGoe0V_Le0yzEiYhosX6rwAeZhAY&signed_in=true&callback=initMap"></script>
  </body>
</html>