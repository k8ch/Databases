<?php
require_once("dbConnect.php");
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Movie McMovieface - Genres</title>
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

        <div id="genreSelect">


            <?php
			$strSQL="SELECT T.description FROM project.Topics AS T;";

            $rs = pg_query($dbconn, $strSQL);
            
            if($rs){
                while($row = pg_fetch_assoc($rs)){
                    echo "<div><a href='movies.php?getGenre=" . $row['description'] .
                        "'>" . $row['description'] . "</a></div>";
                }
            }
                
            ?>


        </div>

    </section>

</div>
</div>

<?php include("footerinc.php"); ?>

</body>
</html>
