jQuery(function() {

  //initially display none;
  hide_all();
  $('#notification').show();
  check_membership();
  load_notification();

  $('#notification-click').click(function() {
      hide_all();
      $('#notification').show();
      load_notification();
  });

  $('#leaveblock').click(function () {
    window.location = "joinblock.html"
  });

  $('#leaveblock').click(function(){
    //navigate to the join block
  });
});

function acceptReq_btn_clk(uid) {
  var uid1 = uid;
  $.post('phpScripts/home.php',{accept:"membership_block",accept_uid:uid1},function(data){
    if(data.indexOf("Success") > -1){
      $("#notification #m-req-"+uid1).remove();
    }
  });
}


function notification_display() {
  // $('#profile_pg').hide();
  // $('#home').hide();
  $('#notification').show();
  $('#notification .notificv').remove();
  $.post('phpScripts/home.php', {
    memreq: "1"
  }, function(data) {
    var mnote;
    try {
      mnote = $.parseJSON(data);
    } catch (e) {
      alert(data);
      return;
    }
    if(mnote.length !== 0){
      $('#m_req_head').show();
    }else {
      $('#m_req_head').hide();
    }
    for (var i = 0; i < mnote.length; i++) {
      var obj = mnote[i];
      // memebershipreq
      var string = "<li class=\"list-group-item notificv\" id=\"m-req-"+obj.uid+"\"><a href=\"javascript:void(0);\" id=\"list-name\">"+obj.uname+"</a><button type=\"button\" class=\"btn btn-success pull-right\" id=\"adbtn\" onclick=\"acceptReq_btn_clk("+obj.uid+");\">Add</button></li>";
      $('#notification #memebershipreq').append(string);
    }
    //add an hr

  });
  $.post("phpScripts/friend.php",{requests:"1"},function (data) {
    var list;
    try {
      list = $.parseJSON(data);
    } catch (e) {
      alert(data);
    }
    for(var j=0;j<list.length;j++){
      var each = list[j];
      var string = "<li class=\"list-group-item notificv\" id=\"f-req-"+each.uid+"\"><a href=\"javascript:void(0);\" id=\"list-name\">"+each.fullname+"</a><button type=\"button\" class=\"btn btn-success pull-right\" id=\"adbtn\" onclick=\"acceptfriend("+each.uid+");\">Accept</button></li>";
      $('#notification #myfriendreq').append(string);
    }
  });
}

function check_membership() {
  $.post('phpScripts/user.php',{check_mem:"1"},function (data) {

    var selector = "#notification #general_notification";
    if(data.indexOf("Wait") > -1){
      $test = data.split(".")[1];
      $(selector).find("#notiic_heading").text("Membership Approval Pending");
      $(selector).find("#notiic_subheading").text($test + " More Approvals");
      $(selector).show();
    } else if (data.indexOf("Now") > -1) {
      $(selector).find("#notiic_heading").text("Welcome");
      $(selector).find("#notiic_subheading").text("Your Neighbourhood welcomes you");
      $(selector).show();
    } else if (data.indexOf("Exist") > -1){
      $(selector).find("#notiic_heading").text("Welcome Back");
      $(selector).show();
    }
  });
}

function load_notification() {
  $('.notefics').remove();
  //find all the new messages directed to the user since the last login
  //find any membership requests sent to the block
  $.post('phpScripts/home.php', {
    memreq: "1"
  }, function(data) {
    var mnote;
    try {
      mnote = $.parseJSON(data);
    } catch (e) {
      alert(data);
      return;
    }
    if(mnote.length === 0){
      var strings_none = "<li><a href=\"javascript:void(0)\" class=\"notefics\">None </a></li>";
      $('#alert-dropdown').append(strings_none);
    }

    for (var i = 0; i < mnote.length; i++) {
      var obj = mnote[i];
      var strings = "<li><a href=\"javascript:void(0)\" onclick=\"notification_display()\" class=\"notefics\">"+obj.uname+"</a><span class=\"label label-info notefics\">Membership Request</span></li>";
      $('#alert-dropdown').append(strings);
      // if(i===2 || i ===mnote.length-1){
      //
      // }

    }

  });
  $.post("phpScripts/friend.php",{requests:"1"},function (data) {
    var list;
    try {
      list = $.parseJSON(data);
    } catch (e) {
      alert(data);
    }
    if(list.length > 0){
      $('#alert-dropdown').append("<hr class=\"divider notefics\">");
    }
    for(var j=0 ;j < list.length; j++){
      var each = list[j];
      var string2 = "<li><a href=\"javascript:void(0)\" onclick=\"notification_display()\" class=\"notefics\">"+each.fullname+"</a><span class=\"label label-info notefics\">Friend Request</span></li>";

      // var string2 = "<li class=\"notefics\"><a href=\"javascript:void(0);\" onclick=\"notification_display()\">"+each.fullname+"</a><span class=\"label label-info notefics\">Friend Request</span></li>";
      $('#alert-dropdown').append(string2);
    }
    $('.dropdown-menu').append("<li class=\"divider notefics\"></li>");
    var stringsview = "<li><a href=\"javascript:void(0)\" onclick=\"notification_display()\" class=\"notefics\">View More</a></li>";
    $('.dropdown-menu').append(stringsview);
    return;
  });

}


function acceptfriend(uid) {
  var user = uid;
  $.post("phpScripts/friend.php",{acceptreq:"1",uid:user},function (data) {
    if(data !== "Success"){
      alert(data);
      return;
    }
    deletereqUI(user);
    alert("Friend Added");
  });
}

function deletereqUI(uid) {
  var user = uid;
  var selector = "#notification #f-req-"+user;
  $(selector).remove();
}

function hide_all() {
  $('#profile_pg').hide();
  $('#notification').hide();
  $('#home').hide();
  $('#friends').hide();
}
