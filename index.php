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
        <div id="navbar">
            <a id="close" class="nav-top">
                <i class="far fa-times-circle"></i>
            </a>
            <!-- <a href="section.php?section=news" id="news" class="nav-item">News</a>
            <a href="section.php?section=science" id="sci"  class="nav-item">Science</a>
            <a href="section.php?section=features" id="feat" class="nav-item">Features</a>
            <a href="section.php?section=sbs_life" id="life" class="nav-item">SBS Life</a>
            <a href="section.php?section=sports" id="spo"  class="nav-item">Sports</a>
            <a href="section.php?section=poetry" id="poe"  class="nav-item">Poetry</a>
            <a href="section.php?section=business" id="busi" class="nav-item">Business</a> -->
            <a href="#" id="news" class="nav-item">News</a>
            <a href="#" id="sci"  class="nav-item">Science</a>
            <a href="#" id="feat" class="nav-item">Features</a>
            <a href="#" id="life" class="nav-item">SBS Life</a>
            <a href="#" id="spo"  class="nav-item">Sports</a>
            <a href="#" id="poe"  class="nav-item">Poetry</a>
            <a href="#" id="busi" class="nav-item">Business</a>
            <a href="gallery.php" class="nav-item">Gallery</a>
            <script>
                var close_btn = document.getElementById("close");
                close_btn.onclick = function() {
                    document.getElementById("navbar").style.transform = "translateX(-100%)";
                    // document.getElementById("navbar").style.display = "none";
                }
            </script>
        </div>
        <div class="header">
                <a href="index.php">
                    <img src="Assets/sbsmaglogo2.jpg">
                </a>
        </div>
        <div id="main">
            <a id="open">
                <i class="fas fa-bars"></i>
            </a>
            <script>
                var open_btn = document.getElementById("open");
                open_btn.onclick = function() {
                    document.getElementById("navbar").style.transform = "translateX(0)";
                    // document.getElementById("navbar").style.display = "grid";
                }
            </script>
            <?php
              $article_sql = "SELECT * FROM articles ORDER BY id DESC LIMIT 20";
              $article_exec = mysqli_query($conn, $article_sql);
              	while ($row = mysqli_fetch_array($article_exec, MYSQLI_ASSOC)) {
			if($row['image_path'] != "") {
	    ?>
                		<a <?php echo "href = 'article.php?article_id=".$row['id']."#preview' style='background-image: url(uploads/".$row['image_path'].");'"; ?> class="article">
                    			<p class="title"><?php echo $row['article_title']; ?></p>
                		</a>
			<?php } else { ?>
				<a <?php echo "href = 'article.php?article_id=".$row['id']."#preview'"; ?> class="article" id="noimg">
                        <div class="container">
                          <p class="title"><?php echo $row['article_title']; ?></p>
                          <p class="sub"> By <?php echo $row['author_name']. " of " . $row['author_class']; ?></p>
                        </div>
                		</a>

	        	<?php } ?>
	        <?php } ?>
            <script>
                var colors = ["var(--bhanu)", "var(--bhaskar)","var(--surya)", "var(--tejas)"];
                function random_number(lower,upper) {
                    return Math.floor(Math.random() * (upper-lower) + lower);
                }
                var articles = document.getElementsByClassName("article");
                for(var i = 0; i < articles.length; i++) {
                    var square = random_number(2,4);
                    articles[i].className = "article h"+square+" w"+square;

                }
                var art_container = document.getElementById("main");
                function generate_filler() {
                  if (articles.length <= 15) {
                    limit = 15;
                  } else {
                    limit = articles.length;
                  }
                    for(var j = 0; j < limit; j++) {
                      // var colors = array("rgb(180,15,20)", "rgb(249,140,45)","rgb(255,236,179)","rgb(238,80,235)");
                        var fill = document.createElement("div");
                        fill.className = "filler";
                        // fill.style.background = "rgb("+random_number(0,255)+","+random_number(0,255)+","+random_number(0,255)+")";
                        fill.style.background = colors[random_number(0,4)];
                        art_container.appendChild(fill);
                    }
                }
                generate_filler();
            </script>
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
