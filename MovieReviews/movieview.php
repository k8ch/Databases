<?php
require_once("dbConnect.php");
$movieid = $_GET['movieid'];

if( isset($_POST['btnAdd'])&&
		($_SERVER['HTTP_HOST'] == "localhost" || $_SERVER['HTTP_HOST']=="schoolServers.ca")&&
		isset($_SESSION['other'])&&
		$_SESSION['other']==$_POST['other']){
			
            $strSQL="INSERT INTO project.movietopics (movieid, topicid)
                    VALUES (" . $movieid. ", " . $_POST['topic'] . ");";

            $btnquery = pg_query($dbconn, $strSQL);
			
}


if( isset($_POST['btnDel'])&&
		($_SERVER['HTTP_HOST'] == "localhost" || $_SERVER['HTTP_HOST']=="schoolServers.ca")&&
		isset($_SESSION['other'])&&
		$_SESSION['other']==$_POST['other']){
			
            $strSQL="DELETE FROM project.movietopics
                where project.movietopics.movieid = " . $movieid . "
                and project.movietopics.topicid = " . $_POST['topic'];

            $btnquery = pg_query($dbconn, $strSQL);
}


if( isset($_POST['btnAdd'])&&
		($_SERVER['HTTP_HOST'] == "localhost" || $_SERVER['HTTP_HOST']=="schoolServers.ca")&&
		isset($_SESSION['other'])&&
		$_SESSION['other']==$_POST['other']){
			
            $strSQL="INSERT INTO project.watched (userid, movieid, rating, date)
                    VALUES (" . $_SESSION['userid'] . ", " . $movieid . ", " . $movieRow['rating'] . ", " . date("Y-m-d") . ")";

            $btnquery = pg_query($dbconn, $strSQL);
			
}
		
?>		
		
		
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Movie McMovieface - Movies</title>
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

        <div id="movieDisplay">

            <?php
            $movieid = $_GET['movieid'];

            $strSQL = "SELECT M.MovieID, M.Language, M.countryReleased, M.subtitles,M.Name, D.firstname, D.lastname, M.DateReleased, ROUND(AVG(W.Rating), 1)
						FROM project.Movie AS M
						  INNER JOIN project.Watched AS W USING (MovieID)
						  INNER JOIN project.MovieTopics AS MT USING (MovieID)
						  INNER JOIN project.Topics AS T USING (TopicID)
						  INNER JOIN project.Directs AS DS USING (MovieID)
						  INNER JOIN project.Director AS D USING (DirectorID)
						  WHERE M.movieid =" . $movieid . "
						GROUP BY M.MovieID, M.Language, M.countryReleased, M.subtitles,M.Name, D.firstname, D.lastname, M.DateReleased
						ORDER BY M.Name;";
						
						
			 $strSQL2 = "SELECT T.description
							FROM project.Topics AS T
							INNER JOIN project.MovieTopics AS MT USING (TopicID)
							INNER JOIN project.Movie AS M USING (MovieID)
							WHERE M.MovieID = " . $movieid . ";";

            $rs = pg_query($dbconn, $strSQL);
			$rs2 = pg_query($dbconn, $strSQL2);
			if($rs){
                
				$movieRow = pg_fetch_assoc($rs);
                    echo "<div id=movie" . $movieid . ">";

                    echo "<h2>" . $movieRow['name'] . "</h2>";
					echo '<p>Directed by: ' . $movieRow['firstname'] . ' ' . $movieRow['lastname']. '</p>';
					echo '<p>Rating: ' . $movieRow['round'] . '/10</p>';
					if($rs2) {
						echo '<p>Genres: </p>';
						while($row2 = pg_fetch_assoc($rs2)){
							echo '<p>' . $row2['description']. '</p>';
							 	
						}	
					echo '</div">';
					}


                    echo "<p>" . $movieRow['datereleased'] . "</p>";
                    echo "<p>" . $movieRow['countryreleased'] . "</p>";
                    echo "<p>" . $movieRow['language'] . "</p>";
                    echo "<p>" . $movieRow['subtitles'] . "</p>";
                    echo "<form id='movie" . $movieid . "form' method='post'>";
					echo '<input type="hidden" name="other" value="' . $_SESSION['other'] . '" />';
					echo '<label for="topic">Genre:</label><br />';
                    echo "<select name='Topic'>
                            <option value='Action'>Action</option>
                            <option value='Adventure'>Adventure</option>
                            <option value='Animation'>Animation</option>
                            <option value='Biography'>Biography</option>
                            <option value='Comedy'>Comedy</option>
                            <option value='Crime'>Crime</option>
                            <option value='Drama'>Drama</option>
                            <option value='Family'>Family</option>
                            <option value='Fantasy'>Fantasy</option>
                            <option value='Film-Noir'>Film-Noir</option>
                            <option value='History'>History</option>
                            <option value='Horror'>Horror</option>
                            <option value='Music'>Music</option>
                            <option value='Musical'>Musical</option>
                            <option value='Mystery'>Mystery</option>
                            <option value='Romance'>Romance</option>
                            <option value='Sci-Fi'>Sci-Fi</option>
                            <option value='Sport'>Sport</option>
                            <option value='Thriller'>Thriller</option>
                            <option value='War'>War</option>
                            <option value='Western'>Western</option>
                          </select>";
						  echo "</br>";
                    echo '<input type="submit" name="btnAdd" value="Add Tag" id="btnAdd">';
                    echo '<input type="submit" name="btnDel" value="Delete Tag" id="btnDel">';
					echo "</br>";
					echo '<label for="rating">Rating:</label><br />';
                    echo "<select name='Rating'>
                            <option value='1'>1</option>
                            <option value='2'>2</option>
                            <option value='3'>3</option>
                            <option value='4'>4</option>
                            <option value='5'>5</option>
                            <option value='6'>6</option>
                            <option value='7'>7</option>
                            <option value='8'>8</option>
                            <option value='9'>9</option>
                            <option value='10'>10</option>
                          </select>";
					echo '<input type="submit" name="btnRate" value="Rate This Movie" id="btnRate">';
                    echo "</form>";

                    echo "</div>";
                    if (isset($_POST["Topic"])) {
                        $topic = $_POST["Topic"];

                    }
                    if (isset($_POST["Rating"])) {
                        $rating = $_POST["Rating"];
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
