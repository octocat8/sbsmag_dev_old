<?php
require_once ("admin/config/db.php");
$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
if (!$conn) {
  echo "Cannot lock onto server :(";
}
?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>SBSMAG | Home</title>
        <link href="index.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato:400,900" rel="stylesheet">
        <script defer src="Assets/fontawesome-all.js"></script>
    </head>
    <body>
        <div class="header">
                <a href="index.php">
                    <img src="Assets/sbsmaglogo2.jpg">
                </a>
        </div>
        <div id="navbar">
            <a href="section.php?section=news" id="news" class="nav-item">News</a>
            <a href="section.php?section=science" id="sci"  class="nav-item">Science</a>
            <a href="section.php?section=features" id="feat" class="nav-item">Features</a>
            <a href="section.php?section=sbs_life" id="life" class="nav-item">SBS Life</a>
            <a href="section.php?section=sports" id="spo"  class="nav-item">Sports</a>
            <a href="section.php?section=poetry" id="poe"  class="nav-item">Poetry</a>
            <a href="section.php?section=business" id="busi" class="nav-item">Business</a> 
            <a href="gallery.php" class="nav-item">Gallery</a> 
        </div>
        <div id="main">
        </div>
        <br><br>
        <div class="secondary">
            <div class="announcements">
                <h1>Announcements</h1>
                <?php
                  $announcement_sql = "SELECT * FROM announcements LIMIT 5";
                  $announcement_exec = mysqli_query($conn, $announcement_sql);
                  while ($row2 = mysqli_fetch_array($announcement_exec, MYSQLI_ASSOC)) { ?>
                        <p><?php echo $row2['announcement']; ?></p>
                  <?php } ?>
            </div>
            <div class="events">
                <h1>Upcoming Events</h1>
                <?php
                  $event_sql = "SELECT * FROM events LIMIT 5";
                  $event_exec = mysqli_query($conn, $event_sql);?>
                <div class="events-main">
                    <?php while ($row3 = mysqli_fetch_array($event_exec, MYSQLI_ASSOC)) { ?>
                      <p id="dates"><?php echo $row3['event_date']; ?></p>
                      <p><?php echo $row3['event_desc']; ?></p>
                    <?php } ?>
                </div>
            </div>
            <div class="about">
                <h1>About Us</h1>
		<p>The SBSMAG acts as a mirror that reflects the students points of view. It acts as a medium for our students to express their opinions on various issues ranging from those pertaining to global security to thosethat affect keep relevance in our daily lives. </p>
            </div>
        </div>
        <footer>
            <a href="index.php">
                <img src="Assets/sbsmaglogo2.jpg">
            </a>
            <p>Step By Step School</p>
            <p id="call">Are you interested in the SBSMAG? <br>Submit your articles to thesbsmag@gmail.com</p>
        </footer>
    </body>
</html>
