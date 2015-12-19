function validatefunc(){
  try{
  var unameValue = $('#usernameid').val();
  var passwordValue = $('#passwordid').val();
  $.post('phpScripts/datacheck.php',{postuname:unameValue,postpassword:passwordValue},
  function(data){
    if(data == "false"){
      $('#errorsignup').html("Invalid username or password");
    }
    else {
      window.location = "home.html"; // Redirecting to other page.
      return false;
    }
  });
  }catch(e){
  console.log(e);
   return false;
 }
}
