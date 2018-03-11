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
            <a href="index.html" class="nav-top">
                Home
            </a>
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
        <!-- image + info -->
        <div class="preview">
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
            <a id="section" href="section.html">Section</a>
            <h1>This is a title</h1>
            <h3>Author's Name <br>Author's Class <br>Date Added</h3>
        </div>
        <!-- content -->
        <div class="content">
            <p><span id="first">L</span>orem ipsum dolor sit amet, consectetur adipiscing elit. Cras eu lorem faucibus augue ullamcorper facilisis ut ac mauris. Donec ullamcorper tempus lorem id accumsan. Praesent egestas vulputate mi, nec bibendum lacus pellentesque ut. Fusce egestas neque quis felis rhoncus venenatis. Nullam auctor tristique purus, ut pretium dui dictum at. Etiam sagittis mollis risus, congue commodo dui consectetur eu. Vivamus nec metus finibus, cursus ante ac, pharetra ante. Donec vestibulum, risus a vehicula eleifend, nunc libero sollicitudin sem, et congue nulla ipsum eget eros. Suspendisse et nunc tempus, scelerisque sapien non, varius lorem. Curabitur congue lectus libero, non egestas sem mollis ac. Vestibulum finibus purus ac tortor iaculis, et accumsan nisl imperdiet.</p>
            <p>Praesent tortor sapien, posuere non rutrum auctor, sagittis tempus purus. Fusce sollicitudin ut velit ut elementum. Donec tincidunt eget felis ut volutpat. Morbi nulla tellus, aliquet sit amet elementum ac, iaculis at diam. Ut posuere nisi at convallis tristique. Nullam ex lacus, pharetra id elit id, cursus rhoncus libero. Praesent fringilla blandit augue at porta. Quisque quis nisi eget nunc maximus malesuada. Aenean accumsan faucibus est sed congue. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut vestibulum condimentum volutpat. Suspendisse bibendum dignissim iaculis.</p>
            <p>Nullam vitae ligula nulla. In condimentum eget nisi a semper. Nulla commodo mi dui, ut bibendum eros varius vitae. Aenean venenatis libero nec ex luctus, vel fermentum dolor maximus. Nunc orci turpis, tempor at malesuada ut, malesuada sed mi. Phasellus iaculis luctus metus bibendum laoreet. Donec sit amet arcu dui. Sed vestibulum metus nec lectus vestibulum, eget ultricies enim accumsan. Sed rhoncus condimentum sagittis. Vivamus euismod euismod volutpat. Etiam lacinia ipsum ut pulvinar pulvinar. Integer at faucibus nibh. Cras in tellus ut diam ultrices blandit nec in arcu.</p>
            <p>Fusce volutpat placerat metus, in finibus risus faucibus ac. Duis bibendum pellentesque egestas. Aenean consectetur interdum arcu rhoncus malesuada. Fusce pulvinar vehicula massa, nec iaculis leo tristique eget. Proin aliquam viverra lacus accumsan luctus. Aliquam vel sem urna. Mauris posuere odio mi, id pretium lacus blandit a.</p>
            <p>Mauris dignissim condimentum turpis, at ultrices velit ullamcorper congue. Nullam fringilla vehicula sodales. Nam ac pellentesque felis. Nullam id lobortis purus. Nam semper suscipit nisl vel vehicula. Nulla pretium magna nec metus mattis vulputate. Fusce feugiat lacus imperdiet augue posuere tristique. Aliquam dapibus eget ante eu dictum. Vivamus nec venenatis mi. Pellentesque risus erat, ornare non dui sed, dignissim hendrerit nisl. Suspendisse volutpat mattis mi, sit amet convallis massa. Aenean vestibulum velit lacus, a molestie diam efficitur nec. Morbi hendrerit eu sapien non sollicitudin. Proin nisi lacus, sodales vel tristique nec, suscipit sit amet arcu.</p> 
        </div>
        <br><br><br><br>
        <footer>
            <a href="index.html">
                <img src="Assets/sbsmaglogo2.jpg">
            </a>
            <p>Step By Step School</p>
            <p id="call">Are you interested in the SBSMAG? <br>Submit your articles to thesbsmag@gmail.com</p>
        </footer>
    </body>
</html>