<!-- This is a simple logout that will reset the cookie to log out a user and send the user back to the login page-->
<?php
//logout.php
setcookie("type", "", time()-3600);

header("location:login.php");

?>
