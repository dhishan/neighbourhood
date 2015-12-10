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
    var inputsubmitneighbour = document.getElementById('neighbour');
    map.controls[google.maps.ControlPosition.LEFT].push(inputsubmit);
    var inputsubmitlat = document.getElementById('neighbourlat');
    map.controls[google.maps.ControlPosition.LEFT].push(inputsubmit);
    var inputsubmitlang = document.getElementById('neighbourlang');
    map.controls[google.maps.ControlPosition.LEFT].push(inputsubmit);



    var geocoder = new google.maps.Geocoder();
    var infowindow = new google.maps.InfoWindow();
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
