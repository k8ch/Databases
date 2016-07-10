<?php
require_once("dbConnect.php");
?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" >
<title>Movie McMovieface - Home</title>
<link href="styles/gen.css" rel="stylesheet" />

<link rel="shortcut icon" href="images/favicon.png" />
 <style type="text/css" media="screen">
            .slides_container {
				float:left;
					width:1000px;
	height:374px;
		
	margin-bottom:20px;
		border:4px solid #f96b61;
            }
            .slides_container div {
                width:1000px;
                height:374px;
                display:block;
				
            }
        </style>
    
        <script src="http://code.jquery.com/jquery-latest.min.js"></script>
        <script src="scripts/slides.jquery.js"></script>
        <script src="scripts/custom.js"></script>
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
<script>
            $(function(){
                $("#slides").slides();
            });
        </script>
</head>

<body>
		
		<header>
                      
            <div id="title">
            
            	<h1>Movie McMovieface</h1>
    
    		</div>
            
            <div id="login">
            	<h4>Welcome <?= $_SESSION['firstname']?> <?= $_SESSION['lastname']?></h4>
                
                <form name="loginform" action="logout.php" method="post">
                	<input type="submit" name="btnOut" value="Log Out" id="btnOut"/>
                </form>
                
                <a href="manageUser.php" id="manageAccount">Manage Account</a>
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
      
<div id="slides">
            <div class="slides_container">
                <div>
                    <img src="images/banner.jpg" />
                </div>
            </div>
    
    	<section>
    

        
        	<article id="mainContent">
      			<h2>Top 10 Recommended Movies for You</h2>
             	<div id="movieSelect">
				 <?php
                 
                 	$strSQL = "SELECT DISTINCT M.Name
								FROM project.Movie AS M
								  INNER JOIN project.MovieTopics AS MT USING (MovieID)
								  INNER JOIN project.Likes AS L USING (TopicID)
								WHERE L.UserID =" . $_SESSION['userid'] . " 
									  AND MT.TopicID = L.TopicID
								LIMIT 10;";
					//$rs = $dbconn->prepare($strSQL);
					$rs = pg_query($dbconn, $strSQL);
					if($rs){
						echo '<ol id="popularList">';
						while($row = pg_fetch_assoc($rs)){
							
							echo '<li>' . $row['name'] . '</li>';
                		}
						echo "</ol>";
					}
                 
                 ?>
             	</div>
        	</article>
                    
    	</section>
 


     </div>
    </div>
    <?php include("footerinc.php"); ?>	

</body>
</html>
