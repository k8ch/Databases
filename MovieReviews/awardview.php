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
        <li><a href="moviefaceawards.php" class="transition">AWARDS</a> </li>

    </ul>

</nav>

<div id="wrapper">
    <section>

        <div id="awardsDisplay">
            <?php
            $queryMethod = $_GET['queryMethod'];

            switch ($queryMethod) {
                case "toptenmovies":
                    $strSQL = "SELECT Ratings.Name
                                FROM (
                                        SELECT W.MovieID, M.Name, CAST(AVG(W.Rating) AS INTEGER)
                                        FROM project.Watched AS W
                                        INNER JOIN project.Movie AS M USING (MovieID)
                                        WHERE W.rating NOTNULL
                                        GROUP BY W.MovieID, M.Name
                                        ORDER BY AVG(W.Rating) DESC
                                        LIMIT 10
                                     ) AS Ratings;";
                    $rs = pg_query($dbconn, $strSQL);

                    if($rs){
						echo '<h2>Top 10 Highest Rated Movies</h2>';
						echo '<ol id="popularList">';
						while($row = pg_fetch_assoc($rs)){
							
							echo '<li>' . $row['name'] . '</li>';
                		}
						echo "</ol>";
					}

                    break;
                case "topmovie":
                    $strSQL = "SELECT DISTINCT M.*, T.description
                                FROM project.Topics AS T
                                INNER JOIN project.MovieTopics AS MT USING(TopicID)
                                INNER JOIN project.Movie AS M USING (MovieID)
                                WHERE M.Name IN (
                                  SELECT  Ratings.Name FROM (
                                    SELECT W.MovieID, M.Name, CAST(AVG(W.Rating) AS INTEGER)
                                    FROM project.Watched AS W
                                    INNER JOIN project.Movie AS M USING (MovieID)
                                    WHERE W.rating NOTNULL
                                          AND W.rating IN (
                                      SELECT MAX(W.rating) FROM project.Watched AS W)
                                    GROUP BY W.MovieID, M.Name
                                    ORDER BY AVG(W.Rating) DESC
                                  ) AS Ratings
                                );";
                    $rs = pg_query($dbconn, $strSQL);

                    if($rs){
                        
						echo '<table style = "width:100%"><tr>
                                <td style = "font-weight: bold">NAME</td>
                                <td style = "font-weight: bold">DATE RELEASED</td>
                                <td style = "font-weight: bold">COUNTRY RELEASED</td>
                                <td style = "font-weight: bold">LANGUAGE</td>
                                <td style = "font-weight: bold">SUBTITLES</td>
                                <td style = "font-weight: bold">DESCRIPTION</td>
                              </tr>';
                        while($row = pg_fetch_assoc($rs)){
                            echo '<tr>';
							
                            echo '<td>';
                            echo $row['name'];
                            echo '</td>';
                            
                            echo '<td>';
                            echo $row['datereleased'];
                            echo '</td>';
                            
                            echo '<td>';
                            echo $row['countryreleased'];
                            echo '</td>';
                            
                            echo '<td>';
                            echo $row['language'];
                            echo '</td>';
                            
                            echo '<td>';
                            echo $row['subtitles'];
                            echo '</td>';
                            
                            echo '<td>';
                            echo $row['description'];
                            echo '</td>';
                            
                            echo '</tr>';
                        }
						
						echo '</table>';
                    
                    }

                    break;
                case "totalratingspermovie":
                    $strSQL = "SELECT M.Name, U.username, W.rating
                                FROM project.Movie AS M
                                INNER JOIN project.Watched AS W USING (MovieID)
                                INNER JOIN project.Users AS U USING (UserID)
                                WHERE W.Rating NOTNULL
                                GROUP BY M.Name, U.username, W.Rating
                                ORDER BY M.Name, W.Rating DESC;";
                    $rs = pg_query($dbconn, $strSQL);

                    if($rs){
						
						echo '<table style = "width:500px"><tr>
                                <td style = "font-weight: bold">NAME</td>
                                <td style = "font-weight: bold">USERNAME</td>
                                <td style = "font-weight: bold">RATING(/10)</td>
                              </tr>';
                        while($row = pg_fetch_assoc($rs)){
							echo '<tr>';
							echo '<td>';
                            echo $row['name'];
                            echo '</td>';
                            echo '<td>';
                            echo $row['username'];
                            echo '</td>';                  
							echo '<td>';
                            echo $row['rating'];
                            echo '</td>';
                            
                        }
						echo '</table>';
                    }

                    break;
                case "notratedsince0116":
                    $strSQL = "SELECT *
                                FROM project.Movie AS M
                                WHERE M.MovieID NOT IN (
                                  SELECT M.MovieID
                                  FROM project.Movie AS M
                                  INNER JOIN project.Watched AS W USING (MovieID)
                                  WHERE W.Date > '2016-01-01'
                                );";
                    $rs = pg_query($dbconn, $strSQL);

                     if($rs){
						 
						 echo '<table style = "width:500px"><tr>
                                <td style = "font-weight: bold">NAME</td>
                                <td style = "font-weight: bold">DATE RELEASED</td>
                                <td style = "font-weight: bold">COUNTRY RELEASED</td>
								<td style = "font-weight: bold">LANGUAGE</td>
								<td style = "font-weight: bold">SUBTITLES(T/F)</td>
                              </tr>';
                        while($row = pg_fetch_assoc($rs)){
							echo '<tr>';
							echo '<td>';
                            echo $row['name'];
                            echo '</td>';
							echo '<td>';
                            echo $row['datereleased'];
                            echo '</td>';
							echo '<td>';
                            echo $row['countryreleased'];
                            echo '</td>';
							echo '<td>';
                            echo $row['language'];
                            echo '</td>';
							echo '<td>';
                            echo $row['subtitles'];
                            echo '</td>';
							echo '</tr>';
                        }
						echo '</table>';
                    }

                    break;
                 case "highestratedgenre":
                    $strSQL = "SELECT M.Name, W.UserID
                                FROM project.Movie AS M
                                INNER JOIN project.Watched AS W USING (MovieID)
                                WHERE W.Rating IN (
                                  SELECT MAX(W.Rating) FROM project.Watched AS W)
                                AND M.Name IN (
                                  SELECT Ratings.Name FROM (
                                    SELECT M.Name, MAX(W.Rating)
                                    FROM project.Movie AS M
                                    INNER JOIN project.Watched AS W USING (MovieID)
                                    INNER JOIN project.MovieTopics AS MT USING (MovieID)
                                    INNER JOIN project.Topics AS T USING (TopicID)
                                    WHERE T.Description = 'Crime'
                                    GROUP BY M.Name
                                  ) AS Ratings
                                ) LIMIT 1;";
                    $rs = pg_query($dbconn, $strSQL);
					
                    if($rs){
                        $row = pg_fetch_assoc($rs);
                        echo 'The highest rated Crime movie was ' . $row['name'] . '</br>';
                        echo 'This honor was bestowed upon by' . $row['userid'];
                        
                    }

                    break;
                case "likespertopic":
                    $strSQL = "SELECT T.Description, COUNT(L.TopicID) AS Total_Likes
                                FROM project.Topics AS T
                                INNER JOIN project.Likes AS L USING (TopicID)
                                WHERE L.TopicID NOTNULL
                                GROUP BY T.Description
                                ORDER BY Total_Likes DESC;";
                    $rs = pg_query($dbconn, $strSQL);

                    if($rs){
                        while($row = pg_fetch_assoc($rs)){
                            echo '<p style="padding:20px">' . $row['description'] . ' was liked by '. $row['total_likes'] . ' people.</p>';
                        }
                    }

                    break;
                case "highestratinguser":
                    $strSQL = "SELECT U.FirstName, U.LastName, P.*, M.Name, W.Date
                                FROM project.Users AS U
                                INNER JOIN project.Profile AS P USING (UserID)
                                INNER JOIN project.Watched AS W USING (UserID)
                                INNER JOIN project.Movie AS M USING (MovieID)
                                WHERE W.Rating IN (
                                  SELECT MAX(W.Rating)
                                  FROM project.Watched AS W
                                );";
                    $rs = pg_query($dbconn, $strSQL);

                    if($rs){
						echo '<table style = "width:500px"><tr>
                                <td style = "font-weight: bold">FIRSTNAME</td>
                                <td style = "font-weight: bold">LASTNAME</td>
                                <td style = "font-weight: bold">YEAR BORN</td>
								<td style = "font-weight: bold">GENDER</td>
								<td style = "font-weight: bold">JOIN DATE</td>	
								<td style = "font-weight: bold">MOVIE NAME</td>
								<td style = "font-weight: bold">DATE RATED</td>

                              </tr>';
                        while($row = pg_fetch_assoc($rs)){
							echo '<tr>';
							echo '<td>';
                            echo $row['firstname'];
                            echo '</td>';
							echo '<td>';
                            echo $row['lastname'];
                            echo '</td>';
							echo '<td>';
                            echo $row['yearborn'];
                            echo '</td>';
							echo '<td>';
                            echo $row['gender'];
                            echo '</td>';
							echo '<td>';
                            echo $row['join_date'];
                            echo '</td>';
							echo '<td>';
                            echo $row['name'];
                            echo '</td>';
							echo '<td>';
                            echo $row['date'];
                            echo '</td>';
							echo '</tr>';
                        }
						echo '</table>';
                    }

                    break;
                case "lowerthanjohnsmith":
                    $strSQL = "SELECT DISTINCT U.FirstName, U.LastName, U.Email
                                FROM project.Users AS U
                                INNER JOIN project.Watched AS W USING (UserID)
                                WHERE W.Rating < ANY (
                                  SELECT W.Rating
                                  FROM project.Watched AS W
                                  INNER JOIN project.Users USING (UserID)
                                  WHERE U.FirstName = 'John' AND U.LastName = 'Smith'
                                );";
                    $rs = pg_query($dbconn, $strSQL);

                    if($rs){
                        while($row = pg_fetch_assoc($rs)){
                            echo $row['firstname'];
                            echo $row['lastname'];
                            echo $row['email'];
                        }
                    }

                    break;
                case "mostopinionateduser":
                    $strSQL = "SELECT U.FirstName, U.LastName, U.Email, M.Name, W.Rating
                                FROM project.Users AS U
                                INNER JOIN project.Watched AS W USING (UserID)
                                INNER JOIN project.Movie AS M USING (MovieID)
                                INNER JOIN project.MovieTopics AS MT USING (MovieID)
                                INNER JOIN project.Topics AS T USING (TopicID)
                                WHERE W.UserID IN (
                                  SELECT W.UserID
                                  FROM project.Watched AS W
                                  INNER JOIN project.MovieTopics AS MT USING (MovieID)
                                  INNER JOIN project.Topics AS T USING (TopicID)
                                  WHERE W.Rating > 7
                                  AND T.Description = 'Drama'
                                )
                                AND W.UserID IN (
                                  SELECT W.UserID
                                  FROM project.Watched AS W
                                  INNER JOIN project.MovieTopics AS MT USING (MovieID)
                                  INNER JOIN project.Topics AS T USING (TopicID)
                                  WHERE W.Rating < 3
                                  AND T.Description = 'Drama'
                                );";
                    $rs = pg_query($dbconn, $strSQL);

                     if($rs){
						 echo '<table style = "width:100%"><tr>
                                <td style = "font-weight: bold">FIRSTNAME</td>
                                <td style = "font-weight: bold">LASTNAME</td>
                                <td style = "font-weight: bold">EMAIL</td>
								 <td style = "font-weight: bold">MOVIE</td>
								  <td style = "font-weight: bold">RATING(/10)</td>
                              </tr>';
                        while($row = pg_fetch_assoc($rs)){
							echo '<tr>';
							echo '<td>';
                            echo $row['firstname'];
                            echo '</td>';
							echo '<td>';
                            echo $row['lastname'];
                            echo '</td>';
							echo '<td>';
                            echo $row['email'];
                            echo '</td>';
							echo '<td>';
                            echo $row['name'];
                            echo '</td>';
							echo '<td>';
                            echo $row['rating'];
                            echo '</td>';
							echo '</tr>';
                        }
						echo '</table>';
                    }

                    break;
            }




            ?>

        </div>

    </section>

</div>
</div>

<?php include("footerinc.php"); ?>

</body>
</html>
