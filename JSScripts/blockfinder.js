var latitude;
var longitude;
var map;
var hoods;
var blocks;
var bermudaTriangle;



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
                formatted_adr = results[0].address_components;
                marker.setPosition(results[0].geometry.location);
                infowindow.setContent(results[0].formatted_address);
                infowindow.open(map, marker);
                document.getElementById('searchbox').value= results[0].formatted_address;

               console.log(results[0].geometry.location);
               var NewMapCenter = map.getCenter();
                latitude = event.latLng.lat();
                longitude = event.latLng.lng();
                console.log(latitude+" "+longitude);

                search_click();
                bermudaTriangle.setMap(null);

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
                formatted_adr = results[0].address_components;

                resultsMap.setCenter(results[0].geometry.location);
                marker.setPosition(results[0].geometry.location);
                infowindow.setContent(results[0].formatted_address);
                infowindow.open(map, marker);
                console.log(results[0].geometry.location);
                var NewMapCenter = map.getCenter();
                latitude = NewMapCenter.lat();
                longitude = NewMapCenter.lng();
                //post the results to php file
                console.log(latitude+" "+longitude);
                search_click();
            } else {
              alert('Geocode was not successful for the following reason: ' + status);
            }
        });
    }


    function search_click() {
        //insert a combobox
        var hoodox_cont = document.getElementById('hoodbox');
        hoodox_cont.style.display = "none";
        var block_cont = document.getElementById('blockbox');
        block_cont.style.display = "none";
        //hide the button
        $('#hoods_dropdown').empty();
        //get the neighbourhood and display all the neighbourhoods in the table
        $.post("phpScripts/blockFinder.php",{lat:latitude,long:longitude,nhoodid:"1"}, function(data){
            hoods = $.parseJSON(data);
            if(hoods.length === 0){
                return;
            }

            hoodox_cont.style.display = "inline-block";

            for(var i =0; i<hoods.length;i++){
                var obj = hoods[i];
                var hood_name = obj.name;
                $('#hoods_dropdown').append($("<option></option>").attr("value",obj.nid).text(hood_name));
            }
            hoods_change();


            //trigger an select event
        });
        //
    }

    $('#hoods_dropdown').change(function(){
        hoods_change();
    });

    $('#btn').click(function(){
        submitclk();
    });

    $('#blocks_dropdown').click(function(){
        //clear any already drawn bo
        var option = $('#blocks_dropdown').find('option:selected').val();
        for(var i =0; i<blocks.length;i++){
        var obj = blocks[i];
        if(obj.bid === option){
            drawpolygon(obj);
            //obj has all the co-ordinates for drawing
            return;
        }
    }
    });

    $('#blocks_dropdown').change(function(){
        //clear any already drawn bo
        var option = $('#blocks_dropdown').find('option:selected').val();
        for(var i =0; i<blocks.length;i++){
        var obj = blocks[i];
        if(obj.bid === option){
            drawpolygon(obj);
            var btn_cont = document.getElementById('btn');
            btn_cont.style.display = "inline-block";

            return;
        }
    }
    });

    function drawpolygon(obj){
        if(bermudaTriangle)
        {
            bermudaTriangle.setMap(null);
        }

            var triangleCoords = [
        {lat: parseFloat(obj.nw_lat), lng: parseFloat(obj.nw_long)},
        {lat: parseFloat(obj.ne_lat), lng: parseFloat(obj.ne_long)},
        {lat: parseFloat(obj.se_lat), lng: parseFloat(obj.se_long)},
        {lat: parseFloat(obj.sw_lat), lng: parseFloat(obj.sw_long)}

      ];

      bermudaTriangle = new google.maps.Polygon({
        paths: triangleCoords,
        strokeColor: '#FF0000',
        strokeOpacity: 0.8,
        strokeWeight: 3,
        fillColor: '#FF0000',
        fillOpacity: 0.35
      });
      bermudaTriangle.setMap(map);

    }

    function submitclk(){
    //format the address from the search bar
    //into fields str adr1, str adr2, city, state and zip
    //post address and bid
    // console.log(formatted_adr);
    var street_number="";
    var address1="";
    var address2="";
    var state = "";
    var city = "";
    var zip=0;
    for (var i = 0; i < formatted_adr.length; i++) {
    // var addressType = formatted_adr[i].types[0];
        console.log(formatted_adr[i].long_name);
        console.log(formatted_adr[i].types[0]);
        switch(formatted_adr[i].types[0]){
            case "street_number": street_number = formatted_adr[i].long_name;
            break;
            case "route": address1 = formatted_adr[i].long_name;
            break;
            case "neighborhood": address2 = formatted_adr[i].long_name;
            break;
            case "administrative_area_level_1": state = formatted_adr[i].long_name;
            break;
            case "locality": city = formatted_adr[i].long_name;
            break;
            case "postal_code": zip = parseInt(formatted_adr[i].long_name);
            break;

        }

    }

    $.post("phpScripts/blockFinder.php",{join:"1",streetadr1:street_number+" "+address1,streetadr2:address2,state:state,zip:zip,city:city,lat:latitude,long:longitude}, function(data){
            //navigate to home page

            alert("successful");
        });

    }


}

function hoods_change(){
    /* setting currently changed option value to option variable */
    var block_cont = document.getElementById('blockbox');
        block_cont.style.display = "none";
    $('#blocks_dropdown').empty();
    var option = $('#hoods_dropdown').find('option:selected').val();
    if(option === ""){
        return;
    }
    $.post("phpScripts/blockFinder.php",{lat:latitude,long:longitude,hoodid:option}, function(data){
        blocks = $.parseJSON(data);
        if(blocks.length === 0){
            //
            return;
        }

        block_cont.style.display = "inline-block";

        for(var i =0; i<blocks.length;i++){
            var obj = blocks[i];
            var block_name = obj.name;
            $('#blocks_dropdown').append($("<option></option>").attr("value",obj.bid).text(block_name));
       // $('#blocks_dropdown').trigger("change");
        }
        $('#blocks_dropdown').trigger('change');
        //trigger an select event
    });
    /* setting input box value to selected option value */
     $('#showoption').val(option);
}
