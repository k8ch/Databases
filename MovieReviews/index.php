<?php
require_once("dbConnect.php");

if(!isset($_SESSION['other'])){
	
	$_SESSION['other'] = uniqid("reviewer",true);

}

if( isset($_POST['btnSubmit'])&&
		($_SERVER['HTTP_HOST'] == "localhost" || $_SERVER['HTTP_HOST']=="schoolServers.ca")&&
		isset($_SESSION['other'])&&
		$_SESSION['other']==$_POST['other']){
			
		//a form that includes btnSubmit was submitted
		//the form came from our domain
		$email = trim($_POST['email']);
		$pw = trim($_POST['pass']);
		//Assume that we are using HTTPS to get these values from the browser to tge server
	
	if(!empty($email)&&!empty($pw)){
		
		$strSQL = "SELECT * FROM project.users WHERE email='{$email}' AND password='{$pw}'";
		//$rs = $dbconn->prepare($strSQL);
		$rs = pg_query($dbconn, $strSQL);
		if($rs){
			
			//query ran ok
			//check that we have ONE match		
			if(pg_num_rows($rs)==1){
				
				$row = pg_fetch_assoc($rs);
				session_regenerate_id();//create a new serrion for the user
				$_SESSION['userid'] = $row['userid'];
				$_SESSION['firstname'] = $row['firstname'];
				$_SESSION['lastname'] = $row['lastname'];
				$_SESSION['username'] = $row['username'];
				$_SESSION['country'] = $row['country'];
				$_SESSION['postcode'] = $row['postcode'];
				$_SESSION['email'] = $row['email'];
				//$_SESSION['user_type'] = $row['user_type'];
				//these variables are only ever created on this page
				//header("Location: loggedIn.php");	
			
			}else{
			
				//no matches	
				$errMsg = "Invalid E-mail or Password";
			
			}
			
			
			
		}else{
			
			//could not run the query
			$errMsg="The database kinda passed out on you";
			
		}
		
	}else{
  		
		//error
		$errMsg = "Both fields are required.";	
		
	}
	
}

if(isset($_SESSION['userid'])){
	
				header("Location: loggedIn.php");	
}
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
            
                <form name="loginform" action="index.php" method="post">
                <input type="hidden" name="other" value="<?=$_SESSION['other']?>" />
                
                <div class="formBox">
                    <label for="email" title="E-mail address">E-mail:</label><br >
                    <input type="text" title="E-mail address" name="email" id="email" value="" autocomplete="off"/>
                </div>
                
                <div class="formBox">
                    <label for="pass">Password:</label><br />
                    <input type="password" autocomplete="off" name="pass" id="pass" value=""/>
                </div>
                
                <div id="submitBox">
                    <input type="submit" name="btnSubmit" value="Log In" id="btnSubmit"/>
                </div>
                
                <div id="errMsg">
            	<?php
					if(isset($errMsg)){
					echo "<p>" . $errMsg . "</p>";	
					}
				?>
            	</div>
                </form>
                  
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
      			<h2>Top 10 Highest Rated Movies</h2>
             	<div id="movieSelect">
				 <?php
                 
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
