<?php
	if(isset($registration)) {
		 if($registration->errors) {
		 	foreach($registration->errors as $error) {
				echo $error;
			}
		 }
		 if($registration->messages) {
		 	foreach($registration->messages as $message) {
				echo $message;
			}
		 }
	}
?>
<form method="post" action="register.php">
	<label>USERNAME</label>
	<input type="text" name="username" required><br>
	<label>PASSWORD</label>
	<input type="password" name="password" required><br>
	<label>REPEAT PASSWORD</label>
	<input type="password" name="password_repeat" required><br>
	<input type="submit" name="register" value="Register">
</form>
