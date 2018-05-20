<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>SBSMAG | Admin</title>
		<link href="https://fonts.googleapis.com/css?family=Lato:400,900|Roboto+Condensed" rel="stylesheet">
		<style media="screen">
			body {
				background-color: #eee;
				font-family: "Lato", sans-serif;
				letter-spacing: 1.5px;
			}
			a {
				background-color: #b40f14;
				padding: 5px;
				color: white;
				text-decoration: none;
				text-transform: uppercase;
			}
			.display_items td,th{
				border: 1px solid grey;
				padding: 5px;
			}
			.form {
				display: grid;
				grid-template-columns: 150px 300px;
			}
			.form label {
				grid-column-start: 1;
			}
			.form .btn{
				background-color: #f98c2d;
				text-decoration: none;
				padding: 10px;
				color: black;
				text-transform: uppercase;
			}
			?>
		</style>
	</head>
	<body>
		<?php
			$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			if(!$conn) {
				echo "cannot get a lock on host";
			}
			$username = $_SESSION['username'];
			echo $username;
		?>
		<a href="index.php?logout">Logout</a>
		<?php
			#SEGMENT TO ADD NEW USERS
			#ACCESSIBLE TO ONLY THOSE USERS WITH A CLASS OF ROOT
			$sql_root = "SELECT class FROM users WHERE username = '" . $username . "';";
			$check_root = mysqli_query($conn,$sql_root);
			$check_result = $check_root->fetch_object();
			if($check_result->class == "root") {
				?>
				<br>
				<br><br>
				<h1>ADD / DELETE USERS</h1>
				<table class="display_items">
				<tr>
				<th>ID</th>
				<th>Username</th>
				<th>Class</th>
				</tr>
				<?php
					$user_get_sql = "SELECT * FROM users ORDER BY id";
					$user_get_exec = mysqli_query($conn, $user_get_sql);
					while($user_show_rows = mysqli_fetch_array($user_get_exec, MYSQLI_ASSOC)) {
						?>
						<tr>
						<td><?php echo $user_show_rows['id'];?></td>
						<td><?php echo $user_show_rows['username'];?></td>
						<td><?php echo $user_show_rows['class'];?></td>
						</tr>
						<?php
					}
					echo "</table><a href='register.php?authorised'>Add new user</a>";
			}
		?>
		<?php
			#SEGMENT TO ADD/EDIT/DELETE NEW ARTICLES
			#ACCESSIBLE TO ONLY THOSE USERS WITH A CLASS OF ROOT/ EDITOR
			$sql_edit = "SELECT class FROM users WHERE username = '" . $username . "';";
			$check_edit = mysqli_query($conn,$sql_edit);
			$check_edit = $check_edit->fetch_object();
			if($check_edit->class == "root" || $check_edit->class == "editor") {
				$titleval = $auth_name_val = $auth_class_val = $date_added_val = $content_val = $section_val = $image_val =  "";
				$btn_val = "Add Article";
				$btn_name = "article_submit";
				if (isset($_GET["article_id"])) {
					$idval = $_GET["article_id"];
					$getforedit = "SELECT * FROM articles WHERE id = '$idval'";
					$queryforedit = mysqli_query($conn, $getforedit);
					$showforedit = mysqli_fetch_array($queryforedit, MYSQLI_ASSOC);
					$titleval = $showforedit["article_title"];
					$auth_name_val = $showforedit["author_name"];
					$auth_class_val = $showforedit["author_class"];
					$date_added_val = $showforedit["date_added"];
					$content_val = $showforedit["content"];
					$section_val = $showforedit["section"];
					$image_val = $showforedit["image_path"];
					$btn_val = "Edit Article";
					$btn_name = "article_edit";
				}
				if(isset($_POST['article_submit'])) {
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
						if (!file_exists(SITE_ROOT.$target_dir.$file_to_upload["name"])) {
							if (in_array($file_ext, $allowed)) {
								if($file_size < 10000000) {
									if(move_uploaded_file($file_to_upload["tmp_name"], SITE_ROOT.$target_dir.$file_to_upload["name"])) {
										echo "File Successfully Moved. Congratulations.";
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
							echo "The file already exists. You might want to add a duplicate article with a different image name, and delete this copy";
						}
					} else {
						echo "Unable to upload article";
					}
				} elseif(isset($_POST['article_edit'])) {
					$title = mysqli_real_escape_string($conn, $_POST['title']);
					$auth_name = mysqli_real_escape_string($conn, $_POST['auth_name']);
					$auth_class = mysqli_real_escape_string($conn, $_POST['auth_class']);
					$date_added = mysqli_real_escape_string($conn, $_POST['date_added']);
					$content = mysqli_real_escape_string($conn, $_POST['content']);
					$section = mysqli_real_escape_string($conn, $_POST['section']);
					$file_name = mysqli_real_escape_string($conn, $_POST["file_upload"]);
					$sql_edit_article = "UPDATE articles SET
					article_title = '$title',
					author_name = '$auth_name',
					author_class = '$auth_class',
					date_added = '$date_added',
					content = '$content',
					section = '$section',
					image_path = '$file_name' WHERE id = '$idval';";
					$query_edit_article = mysqli_query($conn, $sql_edit_article);
					if($query_edit_article) {
						echo "Article Edited";
					} else {
						echo "Unable to edit article";
					}
				} elseif(isset($_POST['article_delete'])) {
					$sql_del_article = "DELETE FROM articles WHERE id = '$idval';";
					$query_del_article = mysqli_query($conn, $sql_del_article);
					if($query_del_article) {
						echo "Article Edited";
					} else {
						echo "Unable to edit article";
					}
				}
				?>
				<br><br>
				<h1>ADD / DELETE/ EDIT ARTICLES</h1>
				<form method="post" action="" enctype="multipart/form-data" class="form">
				<label>Article Title: </label>
				<input type="text" name="title" <?php echo "value = '$titleval'"; ?> required><br>
				<label>Author Name: </label>
				<input type="text" name="auth_name" <?php echo "value = '$auth_name_val'"; ?> required><br>
				<label>Author Class: </label>
				<input type="text" name="auth_class" <?php echo "value = '$auth_class_val'"; ?> required><br>
				<label>Date Added: </label>
				<input type="text" name="date_added" <?php echo "value = '$date_added_val'"; ?> required><br>
				<label>Content: </label>
				<textarea name="content" required><?php echo $content_val; ?></textarea><br>
				<label>Section: </label>
				<input type="text" name="section" <?php echo "value = '$section_val'"; ?> required><br>
				<label>Image Path: </label>
				<?php if (isset($_GET["article_id"])){ ?>
					<input type="text" name="file_upload" <?php echo "value = '$image_val'"; ?>><br>
					<input type="submit" class="btn" value="Delete Article" name="article_delete">
				<?php } else { ?>
					<input type="file" name="file_upload"><br>
				<?php } ?>
				<input type="submit" class="btn" <?php echo "value = '$btn_val' name='$btn_name'"; ?>><br>
				</form>
				<table class="display_items">
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
						$user_get_sql = "SELECT * FROM `articles` ORDER BY id DESC LIMIT 15";
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
				?> </table><?php
			}
		?>
		<?php
			#SEGMENT TO ADD/EDIT/DELETE NEW PHOTOGRAPHS
			#ACCESSIBLE TO ONLY THOSE USERS WITH A CLASS OF ROOT/ PHOTOGRAPHER
			$sql_edit = "SELECT class FROM users WHERE username = '" . $username . "';";
			$check_edit = mysqli_query($conn,$sql_edit);
			$check_edit = $check_edit->fetch_object();
			if($check_edit->class == "root" || $check_edit->class == "photographer") {
				$photographer_name_val = $photographer_class_val = $date_added_val = $image_val =  "";
				$btn_val = "Add Image";
				$btn_name = "image_submit";
				if (isset($_GET["image_id"])) {
					$idval = $_GET["image_id"];
					$getfordel = "SELECT * FROM images WHERE id = '$idval'";
					$queryfordel = mysqli_query($conn, $getfordel);
					$showfordel = mysqli_fetch_array($queryfordel, MYSQLI_ASSOC);
					$photographer_name_val = $showforedit["photographer_name"];
					$photographer_class_val = $showforedit["photographer_class"];
					$date_added_val = $showforedit["date_added"];
					$image_val = $showforedit["image_path"];
					$btn_val = "Delete Image";
					$btn_name = "image_delete";
				}
				if(isset($_POST['image_submit']) && $_FILES["file_upload"]["error"] == 0) {
					$file_to_upload = $_FILES["file_upload"];
					$photographer_name = mysqli_real_escape_string($conn, $_POST['photographer_name']);
					$photographer_class = mysqli_real_escape_string($conn, $_POST['photographer_class']);
					$date_added = mysqli_real_escape_string($conn, $_POST['date_added']);
					$file_name = mysqli_real_escape_string($conn, $file_to_upload["name"]);
					$sql_add_image = "INSERT INTO
					images(photographer_name, photographer_class, date_added, image_path) VALUES ('".$photographer_name."','".$photographer_class."','".$date_added."','".$file_name."');";
					$query_add_image = mysqli_query($conn, $sql_add_image);
					if($query_add_image) {
						echo "Image added to database, moving image file.";
						$target_dir = "uploads/";
						$file_size = $file_to_upload["size"];
						$file_type = explode(".", $file_name);
						$file_ext = $file_type[1];
						$allowed = array("png","jpg","jpeg","gif","svg");
						if (!file_exists(SITE_ROOT.$target_dir.$file_to_upload["name"])) {
							if (in_array($file_ext, $allowed)) {
								if($file_size < 10000000) {
									if(move_uploaded_file($file_to_upload["tmp_name"], SITE_ROOT.$target_dir.$file_to_upload["name"])) {
										echo "File Successfully Moved. Congratulations.";
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
							echo "The file already exists. You might want to add a duplicate photograph with a different image name, and delete this copy";
						}
					} else {
						echo "Unable to upload image";
					}
				} elseif(isset($_POST['image_delete'])) {
					$sql_del_image = "DELETE FROM images WHERE id = '$idval';";
					$query_del_image = mysqli_query($conn, $sql_del_image);
					if($query_del_image) {
						echo "Image Edited";
					} else {
						echo "Unable to edit image";
					}
				}
				?>
				<br><br>
				<h1>ADD / DELETE PHOTOGRAPHS</h1>
				<form method="post" action="" enctype="multipart/form-data" class="form">
				<label>Photographer Name: </label>
				<input type="text" name="photographer_name" <?php echo "value = '$photographer_name_val'"; ?> required><br>
				<label>Photographer Class: </label>
				<input type="text" name="photographer_class" <?php echo "value = '$photographer_class_val'"; ?> required><br>
				<label>Date Added: </label>
				<input type="text" name="date_added" <?php echo "value = '$date_added_val'"; ?> required><br>
				<label>Image Path: </label>
				<?php if (isset($_GET["image_id"])){ ?>
					<input type="text" name="file_upload" <?php echo "value = '$image_val'"; ?>><br>
				<?php } else { ?>
					<input type="file" name="file_upload" required><br>
				<?php } ?>
				<input type="submit" class="btn" <?php echo "value = '$btn_val' name='$btn_name'"; ?>><br>
				</form>
				<table class="display_items">
					<tr>
					<th>ID</th>
					<th>PHOTOGRAPHER</th>
					<th>PHOTOGRAPHER CLASS</th>
					<th>DATE ADDED</th>
					<th>IMAGE PATH</th>
					<th>EDIT/DELETE</th>
					</tr>
					<?php
						$user_get_sql = "SELECT * FROM `images` ORDER BY id DESC LIMIT 15";
						$user_get_exec = mysqli_query($conn, $user_get_sql);
						while($user_show_rows = mysqli_fetch_array($user_get_exec, MYSQLI_ASSOC)) {
					?>
							<tr>
							<td><?php echo $user_show_rows['id'];?></td>
							<td><?php echo $user_show_rows['photographer_name'];?></td>
							<td><?php echo $user_show_rows['photographer_class'];?></td>
							<td><?php echo $user_show_rows['date_added'];?></td>
							<td><?php echo $user_show_rows['image_path'];?></td>
							<td><?php echo "<a href='index.php?image_id=".$user_show_rows['id']."'> EDIT/DELETE</a>";?></td>
							</tr>
							<?php
						}?>
				</table> <?php
			}
		?>
		<?php
			#SEGMENT TO ADD/EDIT/DELETE NEW ANNOUNCEMENTS
			#ACCESSIBLE TO ONLY THOSE USERS WITH A CLASS OF ROOT/ EDITOR
			$sql_edit = "SELECT class FROM users WHERE username = '" . $username . "';";
			$check_edit = mysqli_query($conn,$sql_edit);
			$check_edit = $check_edit->fetch_object();
			if($check_edit->class == "root" || $check_edit->class == "editor") {
				$announcement_val = "";
				$btn_val = "Add Announcement";
				$btn_name = "announcement_submit";
				if (isset($_GET["announcement_id"])) {
					$idval = $_GET["announcement_id"];
					$getforedit = "SELECT * FROM announcements WHERE id = '$idval'";
					$queryforedit = mysqli_query($conn, $getforedit);
					$showforedit = mysqli_fetch_array($queryforedit, MYSQLI_ASSOC);
					$announcement_val = $showforedit["announcement"];
					$btn_val = "Edit announcement";
					$btn_name = "announcement_edit";
				}
				if(isset($_POST['announcement_submit'])) {
					$announcement = mysqli_real_escape_string($conn, $_POST['announcement']);
					$sql_add_announcement = "INSERT INTO announcements(announcement) VALUES ('".$announcement."');";
					$query_add_announcement = mysqli_query($conn, $sql_add_announcement);
					if($query_add_announcement) {
						echo "Announcement added to database.";
					} else {
						echo "Unable to upload announcement";
					}
				} elseif(isset($_POST['announcement_edit'])) {
					$announcement = mysqli_real_escape_string($conn, $_POST['announcement']);
					$sql_edit_announcement = "UPDATE announcements SET announcement = '$announcement' WHERE id = '$idval';";
					$query_edit_announcement = mysqli_query($conn, $sql_edit_announcement);
					if($query_edit_announcement) {
						echo "Announcement Edited";
					} else {
						echo "Unable to edit announcement";
					}
				} elseif(isset($_POST['announcement_delete'])) {
					$sql_del_announcement = "DELETE FROM announcements WHERE id = '$idval';";
					$query_del_announcement = mysqli_query($conn, $sql_del_announcement);
					if($query_del_announcement) {
						echo "Announcement Edited";
					} else {
						echo "Unable to edit announcement";
					}
				}
				?>
				<br><br>
				<h1>ADD / DELETE/ EDIT ANNOUNCEMENTS</h1>
				<form method="post" action="" class="form">
				<label>Announcement: </label>
				<input type="text" name="announcement" <?php echo "value = '$announcement_val'"; ?> required><br>
				<?php if (isset($_GET["announcement_id"])){ ?>
					<input type="submit" class="btn" value="Delete Announcement" name="announcement_delete">
				<?php } ?>
				<input type="submit" class="btn" <?php echo "value = '$btn_val' name='$btn_name'"; ?>><br>
				</form>
				<table class="display_items">
					<tr>
					<th>ID</th>
					<th>ANNOUNCEMENT</th>
					<th>EDIT/DELETE</th>
					</tr>
					<?php
						$user_get_sql = "SELECT * FROM `announcements` ORDER BY id DESC LIMIT 15";
						$user_get_exec = mysqli_query($conn, $user_get_sql);
						while($user_show_rows = mysqli_fetch_array($user_get_exec, MYSQLI_ASSOC)) { ?>
					<tr>
					<td><?php echo $user_show_rows['id'];?></td>
					<td><?php echo $user_show_rows['announcement'];?></td>
					<td><?php echo "<a href='index.php?announcement_id=".$user_show_rows['id']."'> EDIT/DELETE</a>";?></td>
					</tr>
						<?php } ?>
				</table><?php
			}
		?>
		<?php
			#SEGMENT TO ADD/EDIT/DELETE NEW UPCOMING EVENTS
			#ACCESSIBLE TO ONLY THOSE USERS WITH A CLASS OF ROOT/ EDITOR
			$sql_edit = "SELECT class FROM users WHERE username = '" . $username . "';";
			$check_edit = mysqli_query($conn,$sql_edit);
			$check_edit = $check_edit->fetch_object();
			if($check_edit->class == "root" || $check_edit->class == "editor") {
				$event_val = $date_val = "";
				$btn_val = "Add Event";
				$btn_name = "event_submit";
				if (isset($_GET["event_id"])) {
					$idval = $_GET["event_id"];
					$getforedit = "SELECT * FROM events WHERE id = '$idval'";
					$queryforedit = mysqli_query($conn, $getforedit);
					$showforedit = mysqli_fetch_array($queryforedit, MYSQLI_ASSOC);
					$event_val = $showforedit["event_desc"];
					$date_val = $showforedit["event_date"];
					$btn_val = "Edit event";
					$btn_name = "event_edit";
				}
				if(isset($_POST['event_submit'])) {
					$event_desc = mysqli_real_escape_string($conn, $_POST['event_desc']);
					$event_date = mysqli_real_escape_string($conn, $_POST['event_date']);
					$sql_add_event = "INSERT INTO events(event_desc, event_date) VALUES ('".$event_desc."','".$event_date."');";
					$query_add_event = mysqli_query($conn, $sql_add_event);
					if($query_add_event) {
						echo "Event added to database.";
					} else {
						echo "Unable to upload event";
					}
				} elseif(isset($_POST['event_edit'])) {
					$event_desc = mysqli_real_escape_string($conn, $_POST['event_desc']);
					$event_date = mysqli_real_escape_string($conn, $_POST['event_date']);
					$sql_edit_event = "UPDATE events SET event_desc = '$event_desc',event_date = '$event_date' WHERE id = '$idval';";
					$query_edit_event = mysqli_query($conn, $sql_edit_event);
					if($query_edit_event) {
						echo "Event Edited";
					} else {
						echo "Unable to edit event";
					}
				} elseif(isset($_POST['event_delete'])) {
					$sql_del_event = "DELETE FROM events WHERE id = '$idval';";
					$query_del_event = mysqli_query($conn, $sql_del_event);
					if($query_del_event) {
						echo "Event Edited";
					} else {
						echo "Unable to edit event";
					}
				}
				?>
				<br><br>
				<h1>ADD / DELETE/ EDIT EVENTS</h1>
				<form method="post" action="" class="form">
				<label>Event Description: </label>
				<input type="text" name="event_desc" <?php echo "value = '$event_val'"; ?> required><br>
				<label>Date: </label>
				<input type="text" name="event_date" <?php echo "value = '$date_val'"; ?> required><br>
				<?php if (isset($_GET["event_id"])){ ?>
					<input type="submit" class="btn" value="Delete Event" name="event_delete">
				<?php } ?>
				<input type="submit" class="btn" <?php echo "value = '$btn_val' name='$btn_name'"; ?>><br>
				</form>
				<table class="display_items">
					<tr>
					<th>ID</th>
					<th>EVENT</th>
					<th>DATE</th>
					<th>EDIT/DELETE</th>
					</tr>
					<?php
						$user_get_sql = "SELECT * FROM `events` ORDER BY id DESC LIMIT 15";
						$user_get_exec = mysqli_query($conn, $user_get_sql);
						while($user_show_rows = mysqli_fetch_array($user_get_exec, MYSQLI_ASSOC)) {
					?>
							<tr>
							<td><?php echo $user_show_rows['id'];?></td>
							<td><?php echo $user_show_rows['event_desc'];?></td>
							<td><?php echo $user_show_rows['event_date'];?></td>
							<td><?php echo "<a href='index.php?event_id=".$user_show_rows['id']."'> EDIT/DELETE</a>";?></td>
							</tr>
							<?php
						}
				?> </table> <?php
			}
		?>
	</body>
</html>
