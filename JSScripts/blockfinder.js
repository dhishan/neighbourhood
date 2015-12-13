var latitude;
var longitude;
var map;
var hoods;
var blocks;
function initMap() {
     autocomplete = new google.maps.places.Autocomplete(
      /** @type {!HTMLInputElement} */(document.getElementById('searchbox')),
      {types: ['geocode']});


    var myLatLng = {lat: 40.726931, lng: -73.992656};
    var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 12,
    center: myLatLng,

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


    // var input = document.getElementById('addresssec');
    // var searchBox = new google.maps.places.SearchBox(input);
    // map.controls[google.maps.ControlPosition.LEFT_TOP].push(input);

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
    document.getElementById('srchbtn').addEventListener('click', function() {
        var address_user = document.getElementById('searchbox').value;
        if(address_user !== "")
            geocodeAddress(geocoder, map,infowindow);
    });
    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
    });
    google.maps.event.addListener(map, 'click', function(event) {
        myLatLng = {lat: event.latLng.lat(), lng: event.latLng.lng()};
        geocoder.geocode({'location': myLatLng}, function(results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                marker.setPosition(results[0].geometry.location);
                infowindow.setContent(results[0].formatted_address);
                infowindow.open(map, marker);
                document.getElementById('searchbox').value= results[0].formatted_address;
              //  var latty=getCenter();
               // var latty1=latty.lat();
                var NewMapCenter = map.getCenter();
                latitude = NewMapCenter.lat();
                longitude = NewMapCenter.lng();


            } else {
              alert('Geocode was not successful for the following reason: ' + status);
            }
        });
        console.log(myLatLng);
        marker.setPosition(myLatLng);
        marker.setMap(map);
    });
    function geocodeAddress(geocoder,resultsMap,infowindow) {
        var address = document.getElementById('searchbox').value;
        geocoder.geocode({'address': address}, function(results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                resultsMap.setCenter(results[0].geometry.location);
                marker.setPosition(results[0].geometry.location);
                infowindow.setContent(results[0].formatted_address);
                infowindow.open(map, marker);
                var NewMapCenter = map.getCenter();
                latitude = NewMapCenter.lat();
                longitude = NewMapCenter.lng();
                //post the results to php file
                search_click();
            } else {
              alert('Geocode was not successful for the following reason: ' + status);
            }
        });
    }

    function search_click() {
        //insert a combobox
        var hoodox_cont = document.getElementById('hoodbox');
        hoodox_cont.style.display = "inline-block";
        $('#hoods_dropdown').empty();
        //get the neighbourhood and display all the neighbourhoods in the table
        $.post("phpScripts/blockFinder.php",{lat:latitude,long:longitude}, function(data){
            hoods = $.parseJSON(data);
            for(var i =0; i<hoods.length;i++){
                var obj = hoods[i];
                var hood_name = obj.name;
                $('#hoods_dropdown').append($("<option></option>").attr("value",obj.nid).text(hood_name));
            }
            $('#hoods_dropdown').trigger("click");
            //trigger an select event
        });
        //
    }



}

function hoods_change(){
    /* setting currently changed option value to option variable */
    var block_cont = document.getElementById('blockbox');
    block_cont.style.display = "inline-block";
    $('#blocks_dropdown').empty();
    var option = $('#hoods_dropdown').find('option:selected').val();
    $.post("phpScripts/blockFinder.php",{lat:latitude,long:longitude,hoodid:option}, function(data){
        blocks = $.parseJSON(data);
        for(var i =0; i<blocks.length;i++){
            var obj = blocks[i];
            var block_name = obj.name;
            $('#blocks_dropdown').append($("<option></option>").attr("value",obj.bid).text(block_name));
        }
        $('#blocks_dropdown').trigger("click");
        //trigger an select event
    });
    /* setting input box value to selected option value */
    // $('#showoption').val(option);
}

function block_change(){
    //clear any already drawn bo
    var option = $('#blocks_dropdown').find('option:selected').val();
    for(var i =0; i<blocks.length;i++){
        var obj = blocks[i];
        if(obj.bid === option){
            //obj has all the co-ordinates for drawing
            return;
        }
    }
}
