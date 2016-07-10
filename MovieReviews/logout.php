<?php
session_start();
session_unset();//set all session variables to null
session_destroy();//delete the file that holds the session variables

session_start();
session_regenerate_id();
$_SESSION['reason'] = $reason;

header("Location: index.php");//send them back to the login page
exit();//do it right away
?>