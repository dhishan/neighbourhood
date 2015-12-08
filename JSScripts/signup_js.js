$(document).ready(function() {

  $("#name").keyup(function() {
    unamevalid = false;
    var imd = document.getElementById("uvalid");
    imd.src = "images/waiting.svg";
    try{
      var uname1 = $('#name').val();
      $.post("phpScripts/signup_validity.php",{unamecheck:uname1},
      function(data){
        if(data == "false"){
          //user with that username already exists
          imd.src = "images/cross.png";
          $('#errormsguname').text("Username already exists");
        }
        else {
          //check for alphanumeric
          var retvalid = checkvaliduname(uname1);
          if(retvalid[0] === false){
            imd.src = "images/cross.png";
            $('#errormsguname').text(retvalid[1]);
          } else {
            imd.src = "images/tick.png";
            $('#errormsguname').text("");
          }
        }
      });
      }catch(e){
        console.log(e);
      }
  });

  $('#password_re').keyup(function(){
    var imdp = document.getElementById("ppv");
    if($('#password').val() === $('#password_re').val()){
      imdp.src = "images/tick.png";
      $('#errormsgpassword_re').text("");
    }else {
      imdp.src = "images/cross.png";
      $('#errormsgpassword_re').text("Password Mismatch");
    }
  });

  $('#email').keyup(function(){
    var imde = document.getElementById("ev");
    imde.src = "images/waiting.svg";

    try{
      var email1 = $('#email').val();
      $.post("phpScripts/signup_validity.php",{emailcheck:email1},
      function(data){
        if(data == "false"){
          //user with that username already exists
          imd.src = "images/cross.png";
          $('#errormsgemail').text("Already Registered");
        }
        else {
          if(validateEmail($('#email').val())){
            imde.src = "images/tick.png";
            $('#errormsgemail').text("");
          }else {
            imde.src = "images/cross.png";
            $('#errormsgemail').text("Invalid Email");
          }
        }
      });
      }catch(e){
        console.log(e);
      }






  });
});

var unamevalid = null;

function checkvaliduname(uname){
  //verify length
  var myRegxp = /^([a-zA-Z0-9_-]){3,10}$/;
  var val = $('#name').val();
  if(myRegxp.test(val) === false){
  return [false,"Enter only alphanumeric"];
}else return[true,null];
}

function validateEmail(email) {
    var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    return re.test(email);
}

// var elem = document.createElement("img");
// elem.setAttribute("src", "images/tick.png");
// elem.setAttribute("height", "10px");
// elem.setAttribute("width", "10px");
// document.getElementById('utick').appendChild(elem);
