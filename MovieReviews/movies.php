<?php
	require_once("dbConnect.php");
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
				$getGenre = "";


				$strSQL = "SELECT M.MovieID, M.Name, D.firstname, D.lastname, M.DateReleased, ROUND(AVG(W.Rating), 1)
                            FROM project.Movie AS M
                              INNER JOIN project.Watched AS W USING (MovieID)
                              INNER JOIN project.MovieTopics AS MT USING (MovieID)
                              INNER JOIN project.Topics AS T USING (TopicID)
                              INNER JOIN project.Directs AS DS USING (MovieID)
                              INNER JOIN project.Director AS D USING (DirectorID)
                            GROUP BY M.movieid, M.name, D.firstname, D.lastname, M.datereleased
                            ORDER BY M.Name;";

			if(isset($_GET['getGenre'])) {
				$getGenre = $_GET['getGenre'];
				$strSQL = "SELECT M.MovieID, M.Name, D.firstname, D.lastname, M.DateReleased, ROUND(AVG(W.Rating), 1)
                            FROM project.Movie AS M
                              INNER JOIN project.Watched AS W USING (MovieID)
                              INNER JOIN project.MovieTopics AS MT USING (MovieID)
                              INNER JOIN project.Topics AS T USING (TopicID)
                              INNER JOIN project.Directs AS DS USING (MovieID)
                              INNER JOIN project.Director AS D USING (DirectorID)
                              WHERE T.Description=" . $getGenre . "
                            GROUP BY M.movieid, M.name, D.firstname, D.lastname, M.datereleased
                            ORDER BY M.Name;";
			}

			$rs = pg_query($dbconn, $strSQL);


			if($rs){
				while($row = pg_fetch_assoc($rs)){
					echo '<div class="moviePeak">';
					echo '<p><a href="movieview.php?movieid=' . $row['movieid'] . '">' .$row['name'] . '</a> (' . $row['datereleased'] . ')</p>';
					echo '<p>Rating: ' . $row['round'] . '/10</p>';
                    echo '<p>Directed by: ' . $row['firstname'] . ' ' . $row['lastname']. '</p>';
					
					$strSQL2 = "SELECT T.description
							FROM project.Topics AS T
							INNER JOIN project.MovieTopics AS MT USING (TopicID)
							INNER JOIN project.Movie AS M USING (MovieID)
							WHERE M.MovieID = " . $row['movieid'] . ";";
							$rs2 = pg_query($dbconn, $strSQL2);
					if($rs2) {
						echo '<p>Genres: </p>';
						while($row2 = pg_fetch_assoc($rs2)){
							echo '<p>' . $row2['description']. '</p>';
							 	
					}	
					echo '</div>';
				}
					
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
