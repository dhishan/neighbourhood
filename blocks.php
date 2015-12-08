


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

function initialize() {
  var infoWindow = null,
    rectangle = null,
    bounds, map,
    mapOptions = {
      center: new google.maps.LatLng(40.778602, -73.951324),
      mapTypeId: google.maps.MapTypeId.TERRAIN,
      zoom:17
    };
  map = new google.maps.Map(document.getElementById('map'), mapOptions);

  google.maps.event.addListener(map, 'click', function(event) {
    bounds = new google.maps.LatLngBounds(
      new google.maps.LatLng(40.778602, -73.951324),
      new google.maps.LatLng(40.778883, -73.958110),
      new google.maps.LatLng(40.780805,-73.956639),
      new google.maps.LatLng(40.776591, -73.952565)
    );
    rectangle = new google.maps.Rectangle({
      bounds: bounds,

    });
    rectangle.setMap(map);
    infoWindow = new google.maps.InfoWindow();
    createClickablePoly(rectangle, "hello world", map);

  });
}

    </script>
  </head>
  <body>
    <div id="map"></div>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBJcflEGoe0V_Le0yzEiYhosX6rwAeZhAY&signed_in=true&callback=initialize"></script>
  </body>
</html>

