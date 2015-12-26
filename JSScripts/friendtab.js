jQuery(function(){
  $("#new-thread-display_f").click(function () {
    $("#new-thread-container_f,#mapcontainer_f").toggle();

  });

  $('#btn-create-thread_f').click(function () {
    var fd = new FormData();
        fd.append('img', $('#uploadfilen_f')[0].files[0] );
        fd.append('msg_body',$('#new-thread-body_f').val());
        fd.append('subject',$('#new-thread-subject_f').val());
        fd.append('latitude',$('#latitude_new_post_f').val());
        fd.append('longitude',$('#longitude_new_post_f').val());
        fd.append('create_new_post',"1");
        fd.append('scope',"personnel");
        fd.append('scopeid',$('#tofield').val());

        $.ajax({
            url: 'phpScripts/dashboard.php',
            data: fd,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function(data){
              alert(data);
              //reload the current post
            }
          });
  });

  var imageLoader = document.getElementById('uploadfilen_f');
      imageLoader.addEventListener('change', handleImage_f, false);

      $('#loc_open_f').click(function (argument) {
        initMap1();
        $('#map2').toggle();
      });
});

var canvas_f = document.getElementById('preview-img_f');
var ctx_f = canvas_f.getContext('2d');

function handleImage_f(e){
    var reader = new FileReader();
    reader.onload = function(event){
        var img = new Image();
        img.onload = function(){
            canvas_f.width = img.width;
            canvas_f.height = img.height;
            ctx_f.drawImage(img,0,0);
        };
        img.src = event.target.result;
    };
    reader.readAsDataURL(e.target.files[0]);
}

function load_friend() {
hide_all();
$('#friends').show();
$('.prev').remove();
//load current friends
currentfriends();

}

function currentfriends() {
  $.post('phpScripts/friend.php',{friends:"1"},function (data) {
    var list;
    try {
      list = $.parseJSON(data);
    } catch (e) {
      alert(data);
    }
    for(var j=0;j<list.length;j++){
      var obj=list[j];
      var string = "<li class=\"list-group-item prev\"><a href=\"javascript:void(0);\" id=\"list-name\">"+obj.fullname+"</a><button type=\"button\" class=\"btn btn-success pull-right\" id=\"adbtn\" onclick=\"deletefriends("+obj.uid+");\">Unfriend</button></li>";
      $('#myfriendlist').append(string);
    }
  });
}

function deletefriends(uid) {
  var userid = uid;
  $.post("phpScripts/friend.php",{delfriends:"1",uid:userid},function (data) {
    if(data !== "Success"){
      alert(data);
    }
    alert("Successfuly Unfriend");
  });
}

function search_friends() {
  var key = $('#friendkeyword').val();
  $.post('phpScripts/friend.php',{findfriends:"1",keyword:key},function (data) {
    var list;
    try {
      list = $.parseJSON(data);
    } catch (e) {
      alert(data);
    }
    for(var j=0;j<list.length;j++){
      var obj=list[j];
      var string = "<li class=\"list-group-item prev\"><a href=\"javascript:void(0);\" id=\"list-name\">"+obj.fullname+"</a><button type=\"button\" class=\"btn btn-success pull-right\" id=\"adbtn\" onclick=\"friendrequest("+obj.uid+");\">Add Friend</button></li>";
      $('#friendsearchlist').append(string);
    }
  });
}

function friendrequest(uid) {
  var user = uid;
    $.post('phpScripts/friend.php',{frienduid:user,frequest:"1"},function (data) {
      if(data !== "Success"){
        alert(data);
      }
      alert("FRIEND REQUEST SENT");
    });
}

// var map2;
// function initMap1() {
//
//      autocomplete = new google.maps.places.Autocomplete(
//       /** @type {!HTMLInputElement} */(document.getElementById('address_f')),
//       {types: ['geocode']});
//
//
//     var myLatLng = {lat: 40.726931, lng: -73.992656};
//     map2 = new google.maps.Map(document.getElementById('map_f'), {
//     center: myLatLng,
//     zoom: 14,
//
//     mapTypeControl: true,
//     mapTypeControlOptions: {
//     style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
//     position: google.maps.ControlPosition.RIGHT_TOP
//     },
//     zoomControl: true,
//     zoomControlOptions: {
//         position: google.maps.ControlPosition.RIGHT_BOTTOM
//      },
//      scaleControl: true,
//      streetViewControl: true,
//      streetViewControlOptions: {
//          position: google.maps.ControlPosition.RIGHT_BOTTOM
//      }
//     });
//     var geocoder = new google.maps.Geocoder();
//     var infowindow = new google.maps.InfoWindow();
//     var inputsubmitneighbour = document.getElementById('locationField_f');
//     map.controls[google.maps.ControlPosition.LEFT].push(inputsubmitneighbour);
//     var marker = new google.maps.Marker({
//         position: myLatLng,
//         map: map,
//     });
//     document.getElementById('mapit_f').addEventListener('click', function() {
//           var address_user = document.getElementById('address_f').value;
//           if(address_user !== "")
//               geocodeAddress(geocoder, map,infowindow);
//     });
//
//     document.getElementById('address_f').addEventListener('keypress', function (e) {
//       var key = e.which || e.keyCode;
//       if (key === 13) { // 13 is enter
//         var address_user = document.getElementById('address_f').value;
//         if(address_user !== "")
//             geocodeAddress(geocoder, map,infowindow);
//       }
//     });
//
//     google.maps.event.addListener(map2, 'click', function(event) {
//         myLatLng = {lat: event.latLng.lat(), lng: event.latLng.lng()};
//         //document.getElementById('demo').innerHTML = String(myLatLang);
//         geocoder.geocode({'location': myLatLng}, function(results, status) {
//             if (status === google.maps.GeocoderStatus.OK) {
//                 //resultsMap.setCenter(results[0].geometry.location);
//                 marker.setPosition(results[0].geometry.location);
//                 infowindow.setContent(results[0].formatted_address);
//                 infowindow.open(map2, marker);
//                 document.getElementById('address_f').value= results[0].formatted_address;
//                 // $('#latitude_new_post').attr('placeholder',event.latLng.lat());
//                 $('#latitude_new_post_f').val(event.latLng.lat());
//                 $('#longitude_new_post_f').val(event.latLng.lng());
//             } else {
//               alert('Geocode was not successful for the following reason: ' + status);
//             }
//         });
//         console.log(myLatLng);
//         marker.setPosition(myLatLng);
//         marker.setMap(map2);
//     });
//     function geocodeAddress(geocoder,resultsMap,infowindow) {
//         var address = document.getElementById('address_f').value;
//         geocoder.geocode({'address': address}, function(results, status) {
//             if (status === google.maps.GeocoderStatus.OK) {
//                 resultsMap.setCenter(results[0].geometry.location);
//                 marker.setPosition(results[0].geometry.location);
//                 infowindow.setContent(results[0].formatted_address);
//                 infowindow.open(map2, marker);
//                 var loc=[];
//                 $('#latitude_new_post_f').val(results[0].geometry.location.lat());
//                 $('#longitude_new_post_f').val(results[0].geometry.location.lng());
//             } else {
//               alert('Geocode was not successful for the following reason: ' + status);
//             }
//         });
//     }
//
// }
