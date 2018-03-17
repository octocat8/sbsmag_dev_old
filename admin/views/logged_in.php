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
<br><br>
<?php
	#SEGMENT TO ADD/EDIT/DELETE NEW ARTICLES
	#ACCESSIBLE TO ONLY THOSE USERS WITH A CLASS OF ROOT/ EDITOR
	$sql_edit = "SELECT class FROM users WHERE username = '" . $username . "';";
	$check_edit = mysqli_query($conn,$sql_edit);
	$check_edit = $check_edit->fetch_object();
	if($check_edit->class == "root" || $check_edit->class == "editor") {
		if(isset($_POST['article_submit']) && $_FILES["file_upload"]["error"] == 0) {
			$file_to_upload = $_FILES["file_upload"];
			$title = mysqli_real_escape_string($conn, $_POST['title']);
			$auth_name = mysqli_real_escape_string($conn, $_POST['auth_name']);
			$auth_class = mysqli_real_escape_string($conn, $_POST['auth_class']);
			$date_added = mysqli_real_escape_string($conn, $_POST['date_added']);
			$content = mysqli_real_escape_string($conn, $_POST['content']);
			$section = mysqli_real_escape_string($conn, $_POST['section']);
			$file_name = mysqli_real_escape_string($conn, $file_to_upload["name"]);
			$sql_add_article = "INSERT INTO
			articles(article_title, author_name, author_class, date_added, content, section, image_path) VALUES ('".$title."','".$auth_name."','".$auth_class."','".$date_added."','".$content."','".$section."','".$file_name."');";
			$query_add_article = mysqli_query($conn, $sql_add_article);
			if($query_add_article) {
				echo "Article added to database, moving image file.";
				$target_dir = "uploads/";
				$file_size = $file_to_upload["size"];
				$file_type = explode(".", $file_name);
				$file_ext = $file_type[1];
				$allowed = array("png","jpg","jpeg","gif","svg");
				if (in_array($file_ext, $allowed)) {
					if($file_size < 10000000) {
						if(move_uploaded_file($file_to_upload["tmp_name"], SITE_ROOT.$target_dir.$file_to_upload["name"])) {
							echo "File Successfully Moved. Congratulations.";
							delay(1000);
							header("index.php");
						} else {
							echo "Failure to move file. ";
						}
					} else {
						echo "File Size > 10MB not allowed";
					}
				} else {
					echo "You cant upload a file with that extension";
				}
			} else {
				echo "Unable to upload article";
			}
		}
		?>
		<h1>ADD / DELETE/ EDIT ARTICLES</h1>
		<form method="post" action="" enctype="multipart/form-data">
		<label>Article Title: </label>
		<input type="text" name="title" value="" required><br>
		<label>Author Name: </label>
		<input type="text" name="auth_name" value="" required><br>
		<label>Author Class: </label>
		<input type="text" name="auth_class" value="" required><br>
		<label>Date Added: </label>
		<input type="text" name="date_added" value="" required><br>
		<label>Content: </label>
		<textarea name="content" value="" required></textarea><br>
		<label>Section: </label>
		<input type="text" name="section" value="" required><br>
		<label>Image Path: </label>
		<input type="file" name="file_upload"><br>
		<input type="submit" name="article_submit" value="Add Article"><br>
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
			$user_get_sql = "SELECT * FROM `articles` ORDER BY id DESC";
			$user_get_exec = mysqli_query($conn, $user_get_sql);
			while($user_show_rows = mysqli_fetch_array($user_get_exec, MYSQLI_ASSOC)) {
		?>
				<tr>
				<td><?php echo $user_show_rows['id'];?></td>
				<td><?php echo $user_show_rows['article_title'];?></td>
				<td><?php echo $user_show_rows['author_name'];?></td>
				<td><?php echo $user_show_rows['author_class'];?></td>
				<td><?php echo $user_show_rows['date_added'];?></td>
				<td><?php echo $user_show_rows['section'];?></td>
				<td><?php echo $user_show_rows['image_path'];?></td>
				<td><?php echo "<a href='index.php?article_id=".$user_show_rows['id']."'> EDIT/DELETE</a>";?></td>
				</tr>
				<?php
			}
			echo "</table><a href='../register.php?authorised'>Add new user</a>";
	}
?>
