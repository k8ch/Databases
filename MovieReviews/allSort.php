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
                      
            <div>
            
            	<h1>Movie McMovieface</h1>
    
    		</div>
    
	  </header>
    
    	<nav>
    		
            <ul>
            
                <li><a href="index.php">HOME</a> </li>
                <li><a href="movies.php" class="transition">MOVIES</a> </li> 
            	<li><a href="recommendation.php" class="transition">RECOMMENDATION</a> </li>
            
            </ul>
            
   	  </nav>
      
   <div id="wrapper">      
    	<section>
        
        	<div id="movieDisplay">
            <h2>Welcome <?=$_SESSION['firstname']?> <?=$_SESSION['lastname']?></h2>
            
            <?php
				$sortMethod = $_GET['sortMethod'];	
				
				$strSQL = "SELECT * FROM movie ORDER BY ?";
				$rs = $pdo->prepare($strSQL);
		
				if($rs->execute(array($sortMethod))){
					while($movieRow = $rs->fetch(PDO::FETCH_ASSOC)){
							echo $movieRow['name'] . "</br>";

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
