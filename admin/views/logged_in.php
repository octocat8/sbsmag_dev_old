<?php 
	$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if(!$conn) {
		echo "cannot get a lock on host";
	}
	$username = $_SESSION['username'];
	echo $username;
?>
<br>
<a href="index.php?logout">Logout</a>
<?php 
	#SEGMENT TO ADD NEW USERS
	#ACCESSIBLE TO ONLY THOSE USERS WITH A CLASS OF ROOT
	$sql_root = "SELECT class FROM users WHERE username = '" . $username . "';";
	$check_root = mysqli_query($conn,$sql_root);
	$check_result = $check_root->fetch_object();
	if($check_result->class == "root") {
?>
	<br><br>
	<h1>ADD / DELETE USERS</h1>
	<table>
		<tr>
			<th>ID</th>
			<th>Username</th>
			<th>Class</th>
		</tr>
<?php
		$user_get_sql = "SELECT * FROM users ORDER BY id";
		$user_get_exec = mysqli_query($conn, $user_get_sql);
		$user_show_rows = mysqli_fetch_array($user_get_exec, MYSQLI_ASSOC);
?>
		<tr>
			<td><?php echo $user_show_rows['id'];?></td>
			<td><?php echo $user_show_rows['username'];?></td>
			<td><?php echo $user_show_rows['class'];?></td>
		</tr>	
<?php
		echo "</table><a href='../register.php?authorised'>Add new user</a>";
	}
?>

<?php 
	#SEGMENT TO ADD/EDIT/DELETE NEW ARTICLES
	#ACCESSIBLE TO ONLY THOSE USERS WITH A CLASS OF ROOT/ EDITOR
	$sql_edit = "SELECT class FROM users WHERE username = '" . $username . "';";
	$check_edit = mysqli_query($conn,$sql_edit);
	$check_edit = $check_edit->fetch_object();
	if($check_edit->class == "root" || $check_edit->class == "editor") {
?>
	<br><br>
	<h1>ADD / DELETE/ EDIT ARTICLES</h1>
	<form method="post" action="" enctype="multipart/formdata">
		<label>Article Title: </label>
		<input type="text" name="title" required><br>
		<label>Author Name: </label>
		<input type="text" name="auth_name" required><br>
		<label>Author Class: </label>
		<input type="text" name="auth_class" required><br>
		<label>Date Added: </label>
		<input type="text" name="date_added" required><br>
		<label>Content: </label>
		<textarea name="content" required></textarea><br>
		<label>Section: </label>
		<input type="text" name="section" required><br>
		<label>Image Path: </label>
		<input type="file" name="image"><br>
		<input type="submit" name="submit" value="Add Article"><br>
	</form>
	<table>
		<tr>
			<th>ID</th>
			<th>TITLE</th>
			<th>AUTHOR</th>
			<th>AUTHOR CLASS</th>
			<th>DATE ADDED</th>
			<th>SECTION</th>
			<th>IMAGE PATH</th>
			<th>EDIT/DELETE</th>
		</tr>
<?php
		$user_get_sql = "SELECT * FROM articles ORDER BY id DESC";
		$user_get_exec = mysqli_query($conn, $user_get_sql);
		$user_show_rows = mysqli_fetch_array($user_get_exec, MYSQLI_ASSOC);
?>
		<tr>
			<td><?php echo $user_show_rows['id'];?></td>
			<td><?php echo $user_show_rows['article_title'];?></td>
			<td><?php echo $user_show_rows['author'];?></td>
			<td><?php echo $user_show_rows['author_class'];?></td>
			<td><?php echo $user_show_rows['date_added'];?></td>
			<td><?php echo $user_show_rows['section'];?></td>
			<td><?php echo $user_show_rows['image_path'];?></td>
			<td><?php echo "<a href='index.php?article_id=".$user_show_rows['id']."'"?></td>
		</tr>	
<?php
		echo "</table><a href='../register.php?authorised'>Add new user</a>";
	}
?>

