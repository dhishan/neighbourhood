jQuery(function(){
  $.post("phpScripts/user.php",{userName:"1"}, function(data){
    $('#user_fullname').text(" "+data+" ");
    $('#user_fullname_profile').text(" "+data+" ");
    $('#user_home').text(" "+data+" ");
  });
  $.post("phpScripts/dashboard.php",{neighbourName:"1",blockName:"1"}, function(data){
    var user_info = $.parseJSON(data);
    $('#blocks_tab_name').text(user_info.blockName);
    $('#neighbourhood_tab_name').text(user_info.neighbourhoodName);
  });

  $('#profile_click').click(function(){
    //hide other tabs
    $('#profile_pg').toggle();
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
      //delete all the threads
  });

  $('#tabs_home a[href="#neighbourhood_tab"]').click(function () {
      $(this).tab('show');
    //dete the threads


    $("#neighbourhood_tab .threads").remove();
    $.post("phpScripts/dashboard.php",{neighbourpost:"1"}, function(data){
      var messages = $.parseJSON(data);
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

  });

});

function insertThread(obj,loc){
  if(loc==="neighbourhood"){
      var threadNumber = $('#neighbourhood_tab .thread_post').length;
      var previousthread = "#thread_container_" + (threadNumber-1);
      var currentthread = "thread_container_"+threadNumber+"_"+obj.tid;

      $('#neighbourhood_tab #thread_container_0').clone().attr("id",currentthread).insertAfter("#neighbourhood_tab "+previousthread);
      $("#neighbourhood_tab #"+currentthread).addClass("threads");
      $("#neighbourhood_tab #"+currentthread).find("#thread_title").text(obj.subject);
      $("#neighbourhood_tab #"+currentthread).find("#thread_Body").text(obj.m_body);

  }else if(loc===blocks){
    var prefixb = "#block_tab";
    var threadNumberb = $(prefixb+".thread_post").length;
    var previousthreadb = prefixb+" #thread_container_" + (threadNumberb-1);
    var currentthreadb = prefixb+"thread_container_"+threadNumberb+"_"+obj.tid;

    $(prefixb+"#thread_container_0").clone().attr("id","thread_container_"+threadNumberb+"_"+obj.tid).insertAfter(previousthreadb);
    $(currentthreadb).addClass("threads");
    $(currentthreadb).find("#thread_title").text(obj.subject);
    $(currentthreadb).find("#thread_Body").text(obj.m_body);
  }

}

function insertMessage(obj,loc,container_cnt) {
  if(loc === "neighbourhood"){
  //clone the panel
    var prefix = "#neighbourhood_tab #thread_container_"+container_cnt+"_"+obj.tid;
    var messagecnt = $(prefix+" .panel-group").length;
    var previousmsg = prefix+" #panel-"+(messagecnt-1);
    var currentmsg = prefix+" #panel-"+messagecnt;

    $(prefix+" #panel-0").clone().attr("id","panel-"+messagecnt).insertAfter(previousmsg);

    $(currentmsg).find("#message-title").text(obj.fullname);
    $(currentmsg).find("#message-body").text(obj.m_body);

  }
}
