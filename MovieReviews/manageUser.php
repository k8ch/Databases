<?php
require_once("dbConnect.php");

if( isset($_POST['btnSave'])&&
	($_SERVER['HTTP_HOST'] == "localhost" || $_SERVER['HTTP_HOST']=="schoolServers.ca")&&
	isset($_SESSION['other'])&&
	$_SESSION['other']==$_POST['other']){
			
	$username = $_POST['username'];		
	$email = trim($_POST['email']);
	$firstname = trim($_POST['firstname']);		
	$lastname = trim($_POST['lastname']);
	$country = $_POST['country'];
	$postcode = trim($_POST['postcode']);	
	$userid = $_SESSION['userid'];	
	
	if(!empty($username)&&!empty($email)&&!empty($firstname)&&!empty($lastname)&&!empty($country)&&!empty($postcode)){
		
		$strSQL = "UPDATE project.users 
				   SET username='{$username}', email='{$email}', firstname='{$firstname}', lastname='{$lastname}', country='{$country}', postcode='{$postcode}'
				   WHERE userid='{$userid}'";
				   
		$rs = pg_query($dbconn, $strSQL);
		
		if($rs){
			
			$_SESSION['firstname'] = $firstname;
			$_SESSION['lastname'] = $lastname;
			$_SESSION['username'] = $username;
			$_SESSION['country'] = $country;
			$_SESSION['postcode'] = $postcode;
			$_SESSION['email'] = $email;
			
			$msg="Your info has been successfully updated!";
			
		}else{
			
			//could not run the query
			$msg="The database kinda passed out on you";
			
		}
	
	}else{
		
		$msg="None of the fields can be left blank!";
		
	}
			
	
}

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Movie McMovieface - Settings</title>
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
    	<section id="manageUser">
        
        	<h2>User Settings</h2>
        
        	<form name="userform" action="manageUser.php" method="post">
            <input type="hidden" name="other" value="<?=$_SESSION['other']?>" />
            	<div class="formBox">
              		<label for="username">Username:</label><br />
                  	<input type="text" autocomplete="off" name="username" id="username" value="<?=$_SESSION['username']?> "/>
              	</div>
                <div class="formBox">
              		<label for="email">Email:</label><br />
                  	<input type="text" autocomplete="off" name="email" id="email" value="<?=$_SESSION['email']?> "/>
              	</div>
                <div class="formBox">
              		<label for="firstname">First Name:</label><br />
                  	<input type="text" autocomplete="off" name="firstname" id="firstname" value="<?=$_SESSION['firstname']?> "/>
              	</div>
                <div class="formBox">
              		<label for="lastname">Last Name:</label><br />
                  	<input type="text" autocomplete="off" name="lastname" id="lastname" value="<?=$_SESSION['lastname']?> "/>
              	</div>
                <div class="formBox">
              			<label for="country">Country:</label><br />
                  		<input type="text" autocomplete="off" name="country" id="country" value="<?=$_SESSION['country']?> "/>
                </div>
                <div class="formBox">
              		<label for="postcode">Postal Code:</label><br />
                  	<input type="text" autocomplete="off" name="postcode" id="postcode" value="<?=$_SESSION['postcode']?> "/>
              	</div>
                <div class="formBox">
              		<input type="submit" name="btnSave" value="Save" id="btnSave"/>
              	</div>
            
            </form>
            <p><?php if(isset($msg)){
				echo $msg;
			}else{
			}?></p>
                    
    	</section>

     </div>
    </div>
    	
	<?php include("footerinc.php"); ?>
    
</body>
</html>
