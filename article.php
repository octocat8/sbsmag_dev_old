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
        <title>SBSMAG | Article</title>
        <link rel="stylesheet" href="article.css">
        <link href="https://fonts.googleapis.com/css?family=Lato:400,900|Roboto+Condensed" rel="stylesheet">
        <script defer src="Assets/fontawesome-all.js"></script>
    </head>
    <body>
      <div id="navbar">
          <a id="close" class="nav-top">
              <i class="far fa-times-circle"></i>
          </a>
          <a href="section.php?section=news" id="news" class="nav-item">News</a>
          <a href="section.php?section=science" id="sci"  class="nav-item">Science</a>
          <a href="section.php?section=features" id="feat" class="nav-item">Features</a>
          <a href="section.php?section=sbs_life" id="life" class="nav-item">SBS Life</a>
          <a href="section.php?section=sports" id="spo"  class="nav-item">Sports</a>
          <a href="section.php?section=poetry" id="poe"  class="nav-item">Poetry</a>
          <a href="section.php?section=business" id="busi" class="nav-item">Business</a>
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
        <!-- image + info -->
        <div id="preview">
            <a href="#navbar" id="open">
                <i class="fas fa-bars"></i>
            </a>
            <script>
                var open_btn = document.getElementById("open");
                open_btn.onclick = function() {
                    document.getElementById("navbar").style.transform = "translateY(0)";
                    // document.getElementById("navbar").style.display = "grid";
                }
            </script>
            <?php
              if (isset($_GET["article_id"])) {
                $id = $_GET['article_id'];
                $article_sql = "SELECT * FROM articles WHERE id = '$id' LIMIT 1";
                $article_exec = mysqli_query($conn, $article_sql);
                $row = mysqli_fetch_array($article_exec, MYSQLI_ASSOC);
		if($row['image_path'] != "") {
			echo "<style>#preview {background: url('uploads/".$row["image_path"]."'); color: #fff;} #heading {background-color: #333333bb; padding: 20px; max-width: 60vw;} #heading a{color: #fff;}</style>";
		} else {
			echo "<style>#preview {background: var(--surya) ; color: #000; max-height: 50vh;} #heading {color: #000; max-width: 100vw;}</style>";
		} }?>
		<div id="heading" >
            		<?php echo "<a id='section' href='section.php?section=".$row['section']."'>".$row['section']."</a>"; ?>
            		<h1><?php echo $row['article_title']; ?></h1>
            		<h3><?php echo $row['author_name']; ?><br><?php echo $row['author_class']; ?><br><?php echo $row['date_added']; ?></h3>
		</div>
        </div>
        <!-- content -->
        <div class="content">
            <?php echo $row['content']; ?>
        </div>
        <script>
          var section = document.getElementById("section");
          switch (section.innerHTML.toLowerCase()) {
            case "news":
              section.style.borderLeft = "5px solid #ff0";
              break;
            case "science":
              section.style.borderLeft = "5px solid rgb(255, 72, 0)";
              break;
            case "features":
              section.style.borderLeft = "5px solid rgb(255, 0, 128)";
              break;
            case "sbs life":
              section.style.borderLeft = "5px solid rgb(119, 0, 255)";
              break;
            case "sports":
              section.style.borderLeft = "5px solid #0ff";
              break;
            case "poetry":
              section.style.borderLeft = "5px solid #0f0";
              break;
            case "business":
              section.style.borderLeft = "5px solid rgb(0, 96, 0)";
              break;
          }
        </script>
        <br><br><br><br>
        <footer>
            <a href="index.php">
                <img src="Assets/sbsmaglogo2.jpg">
            </a>
            <p>Step By Step School</p>
            <p id="call">Are you interested in the SBSMAG? <br>Submit your articles to thesbsmag@gmail.com</p>
        </footer>
    </body>
</html>
