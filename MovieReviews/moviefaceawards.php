<?php
require_once("dbConnect.php");
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Movie McMovieface - Awards</title>
    <link href="styles/gen.css" rel="stylesheet" />
    <link rel="shortcut icon" href="images/favicon.png" />
    <script src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script src='jquery.js'></script>
    <script src="scripts/custom.js"></script>
    <script src='jquery.transit.js'></script>
    <script type="text/javascript">
        $(document).ready(function() {



            $("body").fadeIn(500);

            $("a.transition").click(function(event){
                event.preventDefault();
                linkLocation = this.href;
                $("body").fadeOut(1000, redirectPage);
            });

            function redirectPage() {
                window.location = linkLocation;
            }
        });
    </script>
</head>
<body>

<header>

    <div id="title">
            
            	<h1>Movie McMovieface</h1>
    
    		</div>

</header>

<nav>

    <ul>

        <li><a href="index.php">HOME</a> </li>
        <li><a href="movies.php" class="transition">MOVIES</a> </li>
        <li><a href="genres.php" class="transition">GENRES</a> </li>
        <li><a href="moviefaceawards.php" class="transition">AWARDS</a></li>

    </ul>

</nav>

<div id="wrapper">
    <section>

        <div id="awardSelect">

            <div>
                <a href="awardview.php?queryMethod=toptenmovies">Top Ten Movies</a>

            </div>

            <div>
                <a href="awardview.php?queryMethod=topmovie">Movies That Were 10/10</br> to Someone</a>

            </div>

            <div>
                <a href="awardview.php?queryMethod=totalratingspermovie">Ratings per movie</a>

            </div>

            <div>
                <a href="awardview.php?queryMethod=notratedsince0116">Movie without ratings after January 1st 2016</a>

            </div>

            <div>
                <a href="awardview.php?queryMethod=highestratedgenre">Highest rated crime movie</a>

            </div>

            <div>
                <a href="awardview.php?queryMethod=likespertopic">Shows the topics ordered by how many users like them</a>

            </div>

            <div>
                <a href="awardview.php?queryMethod=highestratinguser">The users who submit the highest rating</a>

            </div>

            <div>
                <a href="awardview.php?queryMethod=lowerthanjohnsmith">Users that have rated lower than John Smith</a>

            </div>

            <div>
                <a href="awardview.php?queryMethod=mostopinionateduser">User whose ratings very the most in the drama genre</a>

            </div>

        </div>

    </section>

</div>
</div>

<?php include("footerinc.php"); ?>

</body>
</html>
