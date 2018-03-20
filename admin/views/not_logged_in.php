<?php
	if(isset($login)) {
		if($login->errors) {
			foreach ($login->errors as $error) {
				echo $error;
			}
		}
		if($login->messages) {
			foreach ($login->messages as $message) {
				echo $message;
			}
		}
	}
?>

<form method="post" action="index.php">
	<label>USERNAME</label>
	<input type="text" name="username" required><br>
	<label>PASSWORD</label>
	<input type="password" name="password" autocomplete="off" required><br>
	<input type="submit" name="login" value="Log In">
</form>
