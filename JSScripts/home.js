jQuery(function(){

  $.post("phpScripts/user.php",{userName:"1"}, function(data){
    if(data.indexOf("Error") > -1){
      alert(data);
      return;
    }
    $('.username-disp').text(" "+data+" ");
  });
  // $.post("phpScripts/dashboard.php",{neighbourName:"1",blockName:"1"}, function(data){
  //   var user_info = $.parseJSON(data);
  //   $('#blocks_tab_name').text(user_info.blockName);
  //   $('#neighbourhood_tab_name').text(user_info.neighbourhoodName);
  // });



  $('#profile_click').click(function(){
    $('#profile_pg').hide();
    $('#notification').hide();
    $('#home').hide();
    $('#profile_pg').show();
    $.post("phpScripts/user.php",{displaypro:"1"}, function(data){
      var user_info = $.parseJSON(data);
      $('#uname').attr('placeholder',user_info.uname);
      $('#name').val(user_info.fullname);
      $('#email').attr('placeholder',user_info.email);
      $('#intro').val(user_info.intro);

    });
  });
  $('#tabs_home a[href="#block_tab"]').click(function () {


      $(this).tab('show');
      display_blockpost();
    });

  $('#tabs_home a[href="#neighbourhood_tab"]').click(function () {
      $(this).tab('show');
      display_neighbourhoodpost();

  });

  // $('#reply-btn').click(function () {
  //   var thread_id = Number($(this).parent().attr("id"));
  //   console.log(thread_id);
  // });

  $('#neighbourhood_tab #btn-create-thread').click(function(){
    var fd = new FormData();
        fd.append('img', $('#neighbourhood_tab #uploadfilen')[0].files[0] );
        fd.append('msg_body',$('#neighbourhood_tab #new-thread-body').val());
        fd.append('subject',$('#neighbourhood_tab #new-thread-subject').val());
        fd.append('latitude',$('#neighbourhood_tab #latitude_new_post').val());
        fd.append('longitude',$('#neighbourhood_tab #longitude_new_post').val());
        fd.append('create_new_post',"1");
        fd.append('scope',"neighbourhood");

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

    $('#block_tab #btn-create-thread').click(function(){
      var fd = new FormData();
          fd.append('img', $('#block_tab #uploadfileb')[0].files[0] );
          fd.append('msg_body',$('#block_tab #new-thread-body').val());
          fd.append('subject',$('#block_tab #new-thread-subject').val());
          fd.append('latitude',$('#block_tab #latitude_new_post').val());
          fd.append('longitude',$('#block_tab #longitude_new_post').val());
          fd.append('create_new_post',"1");
          fd.append('scope',"block");

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


  $('#neighbourhood_tab #loc_open').click(function (argument) {
    $('#neighbourhood_tab #mapn').toggle();
  });

  $('#block_tab #loc_open').click(function (argument) {
    $('#block_tab #mapb').toggle();
  });

  var imageLoader = document.getElementById('uploadfilen');
      imageLoader.addEventListener('change', handleImage, false);



  $('#neighbourhood_tab #new-thread-display').click(function(){
    $('#neighbourhood_tab #new-thread-container').toggle();
    $('#neighbourhood_tab #mapcontainer').toggle();
  });

  $('#block_tab #new-thread-display').click(function(){
    $('#block_tab #new-thread-container').toggle();
    $('#block_tab #mapcontainer').toggle();
  });


});

function load_home() {
  hide_all();
  $('#home').show();
  $('#tabs_home a[href="#neighbourhood_tab"]').show();
  display_neighbourhoodpost();
}

function logoutt() {
    //update the last logout time
    $.post("phpScripts/user.php",{logout:"1"}, function(data){
      window.location = "index.html";
    });
}
var canvas = document.getElementById('preview-img');
var ctx = canvas.getContext('2d');


function handleImage(e){
    var reader = new FileReader();
    reader.onload = function(event){
        var img = new Image();
        img.onload = function(){
            canvas.width = img.width;
            canvas.height = img.height;
            ctx.drawImage(img,0,0);
        };
        img.src = event.target.result;
    };
    reader.readAsDataURL(e.target.files[0]);
}

function reply_btn_click(tid,cntnum) {
  console.log(currentthread);
  var thid = tid;
  var currentthread = "#neighbourhood_tab #thread_container_"+cntnum+"_"+thid;
  var msg = $(currentthread).find("#thread-reply-new").val();
  $.post('phpScripts/dashboard.php',{msgreply:"1",m_body:msg,tid:thid},function (data) {
    alert(data);
  });
}

function insertThread(obj,loc){
  if(loc==="neighbourhood"){
      var threadNumber = $('#neighbourhood_tab .thread_post').length;

      // var previousthread = $('#neighbourhood_tab').find("[id^='thread_container_"+(threadNumber-1)+"_"+"']");
      // var previousthread = "#thread_container_" +(threadNumber-1);
      // var previousthread1 = $('#neighbourhood_tab #thread_container_0_0');
      var currentthread = "thread_container_"+threadNumber+"_"+obj.tid;

      $('#neighbourhood_tab #thread_container_0').clone().attr("id",currentthread).insertAfter($('#neighbourhood_tab [id^="thread_container_"]').last());
      $("#neighbourhood_tab #"+currentthread).addClass("threads");
      $("#neighbourhood_tab #"+currentthread).find("#thread_title").text(obj.subject);
      $("#neighbourhood_tab #"+currentthread).find("#thread_Body").text(obj.m_body);
      $("#neighbourhood_tab #"+currentthread).find("#reply-btn").attr("onclick","reply_btn_click("+obj.tid+","+threadNumber+");");
      $("#neighbourhood_tab #"+currentthread).find("#thread_by").text(obj.fullname);
      $("#neighbourhood_tab #"+currentthread).find("#thread_img").attr("src",obj.image);
      latitude = obj.lat;
      longitude = obj.long;

      var mapsrc = "https://maps.googleapis.com/maps/api/staticmap?center="+latitude+","+longitude+"&zoom=17&size=400x400&markers=red:blue%7Clabel:S%7C"+latitude+","+longitude+"&key=AIzaSyAMO8LVuDHXgJVR5vbDbkzaFXC5j2UFUYI";
      // var testsrc = "http://maps.googleapis.com/maps/api/staticmap?center=Tombouctou,Mali&amp;zoom=12&amp;size=300x250&amp;sensor=false";
      // var mapsrc = "http://maps.googleapis.com/maps/api/staticmap?center=-73.992177,40.747697&key=AIzaSyAMO8LVuDHXgJVR5vbDbkzaFXC5j2UFUYI&size=300x250";
      $("#neighbourhood_tab #"+currentthread).find("#thread_loc").attr("src",mapsrc);

  }else if(loc==="blocks"){
    var prefixb = "#block_tab";
    var threadNumberb = $(prefixb+" .thread_post").length;
    // var previousthreadb = prefixb+" #thread_container_" + (threadNumberb-1);
    var currentthreadb = prefixb+" #thread_container_"+threadNumberb+"_"+obj.tid;

    $(prefixb+"#thread_container_0").clone().attr("id","thread_container_"+threadNumberb+"_"+obj.tid).insertAfter($('#block_tab [id^="thread_container_"]').last());
    $(currentthreadb).addClass("threads");
    $(currentthreadb).find("#thread_title").text(obj.subject);
    $(currentthreadb).find("#thread_Body").text(obj.m_body);
    $(currentthreadb).find("#reply-btn").attr("onclick","reply_btn_click("+obj.tid+","+threadNumberb+");");
    $(currentthreadb).find("#thread_by").text(obj.fullname);
    $(currentthreadb).find("#thread_img").attr("src",obj.image);
    latitude = obj.lat;
    longitude = obj.long;

    var mapsrc1 = "https://maps.googleapis.com/maps/api/staticmap?center="+latitude+","+longitude+"&zoom=17&size=400x400&markers=red:blue%7Clabel:S%7C"+latitude+","+longitude+"&key=AIzaSyAMO8LVuDHXgJVR5vbDbkzaFXC5j2UFUYI";
    // var testsrc = "http://maps.googleapis.com/maps/api/staticmap?center=Tombouctou,Mali&amp;zoom=12&amp;size=300x250&amp;sensor=false";
    // var mapsrc = "http://maps.googleapis.com/maps/api/staticmap?center=-73.992177,40.747697&key=AIzaSyAMO8LVuDHXgJVR5vbDbkzaFXC5j2UFUYI&size=300x250";
    $(currentthreadb).find("#thread_loc").attr("src",mapsrc1);


  }

}

function insertMessage(obj,loc,container_cnt) {
  if(loc === "neighbourhood"){
  //clone the panel
    var prefix = "#neighbourhood_tab #thread_container_"+container_cnt+"_"+obj.tid;
    var messagecnt = $(prefix+" .reply-post").length;
    var previousmsg = prefix+" #reply-"+(messagecnt-1);
    var currentmsg = prefix+" #reply-"+messagecnt;

    $(prefix+" #reply-0").clone().attr("id","reply-"+messagecnt).insertAfter(previousmsg);

    $(currentmsg).find("#message-title").text(obj.fullname);
    $(currentmsg).find("#message-body").text(obj.m_body);

  }
  else if(loc === "blocks"){
    var prefixb = "#block_tab #thread_container_"+container_cnt+"_"+obj.tid;
    var messagecntb = $(prefixb+" .reply-post").length;
    var previousmsgb = prefixb+" #reply-"+(messagecntb-1);
    var currentmsgb = prefixb+" #reply-"+messagecntb;

    $(prefixb+" #reply-0").clone().attr("id","reply-"+messagecntb).insertAfter(previousmsgb);

    $(currentmsgb).find("#message-title").text(obj.fullname);
    $(currentmsgb).find("#message-body").text(obj.m_body);
  }
}

function display_neighbourhoodpost() {

  $("#neighbourhood_tab .threads").remove();
  $.post("phpScripts/dashboard.php",{neighbourpost:"1"}, function(data){
    var messages;
    try {
      messages = $.parseJSON(data);
    } catch (e) {
        alert(data);
    }
    for(var cnt=0;cnt<messages.length;cnt++){
      var obj = messages[cnt];
      //find the current object tid
      //if tid is present insert into the response
      //if tid is not present insert new thread
      var thread_foundv = false;
      for(var i=1;i<=$('#neighbourhood_tab .thread_post').length;i++){
          if(($("#neighbourhood_tab #thread_container_"+i+"_"+obj.tid).length)){
              thread_foundv = true;
              insertMessage(obj,"neighbourhood",i);
          }
      }
      if(!thread_foundv){
        insertThread(obj,"neighbourhood");
      }
    }

  });
}

function display_blockpost() {
  $("#block_tab .threads").remove();
  $.post("phpScripts/dashboard.php",{blockspost:"1"}, function(data){
    try {
      messages = $.parseJSON(data);
    } catch (e) {
        alert(data);
    }
    for(var cnt=0;cnt<messages.length;cnt++){
      var obj = messages[cnt];
      var thread_foundv = false;
      for(var i=1;i<=$('#block_tab .thread_post').length;i++){
          if(($("#block_tab #thread_container_"+i+"_"+obj.tid).length)){
              thread_foundv = true;
              insertMessage(obj,"blocks",i);
          }
      }
      if(!thread_foundv){
        insertThread(obj,"blocks");
      }
    }
  });

}





var map;
function initMap() {

     autocomplete = new google.maps.places.Autocomplete(
      /** @type {!HTMLInputElement} */(document.getElementById('address')),
      {types: ['geocode']});


    var myLatLng = {lat: 40.726931, lng: -73.992656};
    map = new google.maps.Map(document.getElementById('mapn'), {
    center: myLatLng,
    zoom: 14,

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
    var geocoder = new google.maps.Geocoder();
    var infowindow = new google.maps.InfoWindow();
    var inputsubmitneighbour = document.getElementById('locationField');
    map.controls[google.maps.ControlPosition.LEFT].push(inputsubmitneighbour);
    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
    });
    document.getElementById('mapit').addEventListener('click', function() {
          var address_user = document.getElementById('address').value;
          if(address_user !== "")
              geocodeAddress(geocoder, map,infowindow);
    });

    document.getElementById('address').addEventListener('keypress', function (e) {
      var key = e.which || e.keyCode;
      if (key === 13) { // 13 is enter
        var address_user = document.getElementById('address').value;
        if(address_user !== "")
            geocodeAddress(geocoder, map,infowindow);
      }
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
                // $('#latitude_new_post').attr('placeholder',event.latLng.lat());
                $('#latitude_new_post').val(event.latLng.lat());
                $('#longitude_new_post').val(event.latLng.lng());
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
                var loc=[];
                $('#latitude_new_post').val(results[0].geometry.location.lat());
                $('#longitude_new_post').val(results[0].geometry.location.lng());
            } else {
              alert('Geocode was not successful for the following reason: ' + status);
            }
        });
    }

}

// var map1;
// function initMap() {
//
//      autocomplete = new google.maps.places.Autocomplete(
//       /** @type {!HTMLInputElement} */(document.getElementById('address')),
//       {types: ['geocode']});
//
//
//     var myLatLng = {lat: 40.726931, lng: -73.992656};
//     map1 = new google.maps.Map(document.getElementById('mapb'), {
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
//     var inputsubmitneighbour = document.getElementById('locationField1');
//     map1.controls[google.maps.ControlPosition.LEFT].push(inputsubmitneighbour);
//     var marker = new google.maps.Marker({
//         position: myLatLng,
//         map: map1,
//     });
//     document.getElementById('mapit1').addEventListener('click', function() {
//           var address_user = document.getElementById('address1').value;
//           if(address_user !== "")
//               geocodeAddress(geocoder, map1,infowindow);
//     });
//
//     document.getElementById('address1').addEventListener('keypress', function (e) {
//       var key = e.which || e.keyCode;
//       if (key === 13) { // 13 is enter
//         var address_user = document.getElementById('address1').value;
//         if(address_user !== "")
//             geocodeAddress(geocoder, map1,infowindow);
//       }
//     });
//
//     google.maps.event.addListener(map1, 'click', function(event) {
//         myLatLng = {lat: event.latLng.lat(), lng: event.latLng.lng()};
//         //document.getElementById('demo').innerHTML = String(myLatLang);
//         geocoder.geocode({'location': myLatLng}, function(results, status) {
//             if (status === google.maps.GeocoderStatus.OK) {
//                 //resultsMap.setCenter(results[0].geometry.location);
//                 marker.setPosition(results[0].geometry.location);
//                 infowindow.setContent(results[0].formatted_address);
//                 infowindow.open(map1, marker);
//                 document.getElementById('address1').value= results[0].formatted_address;
//                 // $('#latitude_new_post').attr('placeholder',event.latLng.lat());
//                 $('#latitude_new_post').val(event.latLng.lat());
//                 $('#longitude_new_post').val(event.latLng.lng());
//             } else {
//               alert('Geocode was not successful for the following reason: ' + status);
//             }
//         });
//         console.log(myLatLng);
//         marker.setPosition(myLatLng);
//         marker.setMap(map1);
//     });
//     function geocodeAddress(geocoder,resultsMap,infowindow) {
//         var address = document.getElementById('address1').value;
//         geocoder.geocode({'address': address}, function(results, status) {
//             if (status === google.maps.GeocoderStatus.OK) {
//                 resultsMap.setCenter(results[0].geometry.location);
//                 marker.setPosition(results[0].geometry.location);
//                 infowindow.setContent(results[0].formatted_address);
//                 infowindow.open(map1, marker);
//                 var loc=[];
//                 $('#block_tab #latitude_new_post').val(results[0].geometry.location.lat());
//                 $('#block_tab #longitude_new_post').val(results[0].geometry.location.lng());
//             } else {
//               alert('Geocode was not successful for the following reason: ' + status);
//             }
//         });
//     }
//
// }
