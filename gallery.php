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
        <title>SBSMAG | Gallery</title>
        <link href="gallery.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato:400,900" rel="stylesheet">
        <script defer src="Assets/fontawesome-all.js"></script>
    </head>
    <body>
        <div id="navbar">
            <a href="#" id="close" class="nav-top">
                <i class="far fa-times-circle"></i>
            </a>
            <a href="#" id="news" class="nav-item">News</a>
            <a href="#" id="sci"  class="nav-item">Science</a>
            <a href="#" id="feat" class="nav-item">Features</a>
            <a href="#" id="life" class="nav-item">Lifestyle</a>
            <a href="#" id="spo"  class="nav-item">Sports</a>
            <a href="#" id="soc"  class="nav-item">Society</a>
            <a href="#" id="busi" class="nav-item">Business</a>
            <a href="#" class="nav-item">Gallery</a>
            <script>
                var close_btn = document.getElementById("close");
                close_btn.onclick = function() {
                    document.getElementById("navbar").style.transform = "translateY(-100%)";
                    document.getElementById("navbar").style.display = "none";
                }
            </script>
        </div>
        <div class="header">
            <a href="index.php">
                <img src="Assets/sbsmaglogo2.jpg">
            </a>
        </div>
	<div id="overlay">
        	<button>Close <i class="fa fa-times"></i></button>
		<img src="">
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
                $img_sql = "SELECT * FROM images ORDER BY id DESC LIMIT 30";
                $img_exec = mysqli_query($conn, $img_sql);
                while ($row = mysqli_fetch_array($img_exec, MYSQLI_ASSOC)) { ?>
                    <div  class="item">
                        <img <?php echo "src='uploads/".$row['image_path']."'"; ?>alt="">
                        <!-- <div class="item__overlay"><p>VIEW</p></div> -->
                    </div>
                <?php } ?>
		<script>
			var overlay = document.getElementById("overlay");
      			var overlayImage = overlay.querySelector("img");
      			var overlayClose = overlay.querySelector("button");
      			const images = document.querySelectorAll('.item');
      			function handleClick(e) {
        			const photo = e.currentTarget.querySelector("img").src;
        			overlayImage.src = photo;
				overlay.style.display = "grid"
      			}
      			function close() {
        			overlay.style.display = "none";
      			}
      			images.forEach(image => image.addEventListener('click', handleClick ));
      			overlayClose.addEventListener("click", close);
		</script>
            <script>
                // Generation of Filler
                var colors = ["#A0011D", "#ED5222","#FFB21C", "#FFFD5A"];
                function random_number(lower,upper) {
                    return Math.floor(Math.random() * (upper-lower) + lower);
                }
                var items = document.getElementsByClassName("item");
                for(var i = 0; i < items.length; i++) {
                    items[i].className = "item h"+random_number(2,4)+" w"+random_number(2,4);
                    items[i].addEventListener('click', handleClick);
                }
                var art_container = document.getElementById("main");
                function generate_filler() {
                  if (items.length <= 15) {
                    limit = 15;
                  } else {
                    limit = items.length;
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
        <footer>
            <a href="index.html">
                <img src="Assets/sbsmaglogo2.jpg">
            </a>
            <p>Step By Step School</p>
            <p id="call">Are you interested in the SBSMAG? <br>Submit your articles to thesbsmag@gmail.com</p>
        </footer>
    </body>
</html>
