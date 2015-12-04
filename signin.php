<!doctype html>
<html>
<head>
	<title> signin</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
	<script src="jquery.validate.js"></script>
	<script>
	$(function(){
		$("#login").validate({
			rules: {
				Username:{
				//	required: true,
					Lettersandnumbers: true
				},
				Fullname: {
					required: true
				},

				email: {
					required: true,
					email: true,
					remote:"checkemail.php"

},
				streetadr1: {
					required: true
				},

				streetadr2: { 
					required: true

				},

				country:{
					required: true
				},

				city: {
					required: true
				},

				state: {
					required: true
				},

				zip: {
					required: true
				},

				password:{
					required: true,
					minlength: 3,
					maxlength: 20
				}
			}
			
		});

		$.validator.addMethod('Lettersandnumbers',function(value,element){
				return this.optional(element) || value == value.match(/^[0-9a-zA-Z_]+$/);
			},"* Letters,numbers and underscore only please ");

	});

	</script>
	<body>
		<form id="login" method = "post" action=" ">
			<label for="username">Username </label>
			<input type="text" id="name" name="Username"/> <br />

			<label for="fullname">Fullname </label>
			<input type="text" id="fullname" name="Fullname"/> <br />

			<label for="email">email</label>
			<input type="text" id="email" name="email"/> <br />

			<label for="streetadr1">Street address line 1</label>
			<input type="text" id="streetadr1" name="streetadr1"/> <br />

			<label for="streetadr2">Street address line 2</label>
			<input type="text" id="streetadr2" name="streetadr2"/> <br />

			<label for="city">City</label>
			<input type="text" id="city" name="city"/> <br />
		
			<label for="state">State</label>
			<input type="text" id="state" name="state"/> <br /> 

			<label for="zip">zip</label>
			<input type="number" id="zip" name="zip"/> <br />

			<label for="Password">Password </label>
			<input type="password" id="password" name="password"/> <br />


			<input type="submit" value="Signup"/> 

		</form>


	</body>
</head>
</html>