<!DOCTYPE HTML>
<?php

?>
<html>
<head> 
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title> You in the wrong neighbourhood, motha***</title>
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
    <style>
      #locationField, #controls {
        position: relative;
        width: 480px;
      }
      #autocomplete {
        position: absolute;
        top: 0px;
        left: 0px;
        width: 99%;
      }
      .label {
        text-align: right;
        font-weight: bold;
        width: 100px;
        color: #303030;
      }
      #address {
        border: 1px solid #000090;
        background-color: #f0f0ff;
        width: 480px;
        padding-right: 2px;
      }
      #address td {
        font-size: 10pt;
      }
      .field {
        width: 99%;
      }
      .slimField {
        width: 50px;
      }
      .wideField {
        width: 200px;
      }
      #locationField {
        height: 20px;
        margin-bottom: 2px;
      }
    </style>
  </head>
    <style type="text/css">
        html, body { height: 100%; margin: 10; padding: 0; }
        #map {
            height: 100% ; width: 100%;
            
        }
        #floating-panel {
            position: absolute;
            top: 70px;
            left: 35%;
            z-index: 10;
            background-color: #fff;
            padding: 5px;
            border: 1px solid #999;
            text-align: center;
            font-family: 'Roboto','sans-serif';
            line-height: 50px;
            padding-left: 10px;
        }
    </style>
</head>
<body>

     <div id="locationField">

        <input id="address" type="textbox" value="New York, NY">
        <input id="neighbourlat" type="textbox" value="Neighbour">
        <input id="neighbourlang" type="textbox" value="Neighbour">

    
    </div>
    <div><input id="submit" type="button" value="Geocode"></div>
  
    <div id="map"></div>
    <script type="text/javascript">
        var map;
        function initMap() {

             autocomplete = new google.maps.places.Autocomplete(
              /** @type {!HTMLInputElement} */(document.getElementById('address')),
              {types: ['geocode']});


            var myLatLng = {lat: 40.726931, lng: -73.992656};
            var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 12,
            center: {lat: 40.726931, lng: -73.992656},

            mapTypeControl: true,
            mapTypeControlOptions: {
                 style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                 position: google.maps.ControlPosition.RIGHT_TOP
             },
             zoomControl: true,
             zoomControlOptions: {
                 position: google.maps.ControlPosition.RIGHT_BOTTOM
              },
              scaleControl: true,
              streetViewControl: true,
              streetViewControlOptions: {
                  position: google.maps.ControlPosition.RIGHT_BOTTOM
              }
            });


            var input = document.getElementById('locationField');
            var searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.LEFT_TOP].push(input);

            var inputsubmit = document.getElementById('submit');
            map.controls[google.maps.ControlPosition.LEFT].push(inputsubmit);
            var inputsubmit = document.getElementById('neighbour');
            map.controls[google.maps.ControlPosition.LEFT].push(inputsubmit);
            var inputsubmit = document.getElementById('neighbourlat');
            map.controls[google.maps.ControlPosition.LEFT].push(inputsubmit);
            var inputsubmit = document.getElementById('neighbourlang');
            map.controls[google.maps.ControlPosition.LEFT].push(inputsubmit);

            

            var geocoder = new google.maps.Geocoder();  
            var infowindow = new google.maps.InfoWindow; 
            document.getElementById('submit').addEventListener('click', function() {
                geocodeAddress(geocoder, map,infowindow);
            });
            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
            });
            google.maps.event.addListener(map, 'click', function(event) {
                myLatLng = {lat: event.latLng.lat(), lng: event.latLng.lng()};
                //document.getElementById('demo').innerHTML = String(myLatLang);
                geocoder.geocode({'location': myLatLng}, function(results, status) {
                    if (status === google.maps.GeocoderStatus.OK) {
                        //resultsMap.setCenter(results[0].geometry.location);
                        marker.setPosition(results[0].geometry.location);
                        infowindow.setContent(results[0].formatted_address);
                        infowindow.open(map, marker);
                        document.getElementById('address').value= results[0].formatted_address;
                      //  var latty=getCenter();
                       // var latty1=latty.lat();
                        var NewMapCenter = map.getCenter();
                        var latitude = NewMapCenter.lat();
                        var longitude = NewMapCenter.lng();
                        document.getElementById('neighbourlat').value=latitude;
                        document.getElementById('neighbourlang').value=longitude;
                       
                
                    } else {
                      alert('Geocode was not successful for the following reason: ' + status);
                    }
                });
                console.log(myLatLng);
                marker.setPosition(myLatLng);
                marker.setMap(map);
            });
            function geocodeAddress(geocoder,resultsMap,infowindow) {
                var address = document.getElementById('address').value;
                geocoder.geocode({'address': address}, function(results, status) {
                    if (status === google.maps.GeocoderStatus.OK) {
                        resultsMap.setCenter(results[0].geometry.location);
                        marker.setPosition(results[0].geometry.location);
                        infowindow.setContent(results[0].formatted_address);
                        infowindow.open(map, marker);
                        var NewMapCenter = map.getCenter();
                        var latitude = NewMapCenter.lat();
                        var longitude = NewMapCenter.lng();
                        document.getElementById('neighbourlat').value=latitude;
                        document.getElementById('neighbourlang').value=longitude;

                    } else {
                      alert('Geocode was not successful for the following reason: ' + status);
                    }
                });
            }

        }
       // function initAutocomplete() {
  // Create the autocomplete object, restricting the search to geographical
  // location types.
  

  // When the user selects an address from the dropdown, populate the address
  // fields in the form.
 // autocomplete.addListener('place_changed', fillInAddress);
//}
    </script>
    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBJcflEGoe0V_Le0yzEiYhosX6rwAeZhAY&callback=initMap&libraries=places">
    </script>


</body>
</html>