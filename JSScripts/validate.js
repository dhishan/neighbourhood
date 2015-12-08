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
      alert("Login successfully");
      window.location = "login1.html"; // Redirecting to other page.
      return false;
    }
  });
  }catch(e){
  console.log(e);
   return false;
 }
}
