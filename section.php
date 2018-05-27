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
        <title>SBSMAG | Section</title>
        <link href="section.css" rel="stylesheet" type="text/css">
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
          <a href="section.php?section=business" id="busi" class="nav-item">Business</a>
          <a href="gallery.php" class="nav-item">Gallery</a> -->
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
            <a href="#navbar" id="open">
                <i class="fas fa-bars"></i>
            </a>
            <script>
                var open_btn = document.getElementById("open");
                open_btn.onclick = function() {
                    document.getElementById("navbar").style.transform = "translateY(0)";
                    document.getElementById("navbar").style.display = "grid";
                }
            </script>
            <?php
              if (isset($_GET['section'])) {
                $section_name = $_GET['section'];
                echo "<h1 id='section_name'>$section_name</h1>";
                $article_sql = "SELECT * FROM articles WHERE section = '$section_name' ORDER BY id DESC LIMIT 20";
                $article_exec = mysqli_query($conn, $article_sql);
                while ($row = mysqli_fetch_array($article_exec, MYSQLI_ASSOC)) {
                  if ($row['image_path'] != "") { ?>
                    <a <?php echo "href = 'article.php?article_id=".$row['id']."' style='background-image: url(uploads/".$row['image_path'].");'"; ?> class="article">
                    			<p class="title"><?php echo $row['article_title']; ?></p>
                		</a>
                  <?php } else { ?>
                    <a <?php echo "href = 'article.php?article_id=".$row['id']."'"; ?> class="article" id="noimg">
                        <div class="container">
                          <p class="title"><?php echo $row['article_title']; ?></p>
                          <p class="sub"> By <?php echo $row['author_name']. " of " . $row['author_class']; ?></p>
                        </div>
                		</a>
                  <?php }
                }
              }
            ?>
            <script>
              var colors = ["#A0011D", "#ED5222","#FFB21C", "#FFFD5A"];
              function random_number(lower,upper) {
                  return Math.floor(Math.random() * (upper-lower) + lower);
              }
              var section = document.getElementById("section_name");
              switch (section.innerHTML.toLowerCase()) {
                case "news":
                  section.style.background = "#ff0";
                  break;
                case "science":
                  section.style.background = "rgb(255, 72, 0)";
                  break;
                case "features":
                  section.style.background = "rgb(255, 0, 128)";
                  break;
                case "sbs life":
                  section.style.background = "rgb(119, 0, 255)";
                  break;
                case "sports":
                  section.style.background = "#0ff";
                  break;
                case "poetry":
                  section.style.background = "#0f0";
                  break;
                case "business":
                  section.style.background = "rgb(0, 96, 0)";
                  break;
              }
              var articles = document.getElementsByClassName("article");
              for(var i = 0; i < articles.length; i++) {
                  articles[i].className = "article h"+random_number(2,4)+" w"+random_number(2,4);
                  // if (articles[i].id === "noimg") {
                  //   articles[i].style.background = colors[random_number(0,2)];
                  // }
              }
              var art_container = document.getElementById("main");
              function generate_filler() {
                  for(var j = 0; j < articles.length; j++) {
                    // var colors = array("rgb(180,15,20)", "rgb(249,140,45)","rgb(255,236,179)","rgb(238,80,235)");
                      var fill = document.createElement("div");
                      fill.className = "filler";
                      fill.style.background = colors[random_number(0,4)];
                      art_container.appendChild(fill);
                  }
              }
              generate_filler();
            </script>
        </div>
        <br><br>
        <footer>
            <a href="index.php">
                <img src="Assets/sbsmaglogo2.jpg">
            </a>
            <p>Step By Step School</p>
            <p id="call">Are you interested in the SBSMAG? <br>Submit your articles to thesbsmag@gmail.com</p>
        </footer>
    </body>
</html>
