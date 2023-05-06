<!-- There is not much code on this page. This is the index page to introduce people to the website -->
<?php

//verify user is logged in
if(!isset($_COOKIE["type"]))
{
 header("location:login.php");
}

// admin does not access user pages
if ($_COOKIE["type"] == 'master') {
  header("location:admin.php");
}
?>


<!DOCTYPE html>
<html>
  <head>
  <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="images/bank_logo.JPG">
    <title>Happy Friends Bank</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/index.css">
  </head>
  <body>
    <div class="topnav">
      <a href="index.php">Home</a>
      <a href="transaction.php">Make a Transaction</a>
      <a href="account.php">Account</a>
      <a href="logout.php">Logout</a>


    </div>

    <div class="main">
    <h1>Welcome to Happy Friends Bank</h1>
    <p>HFB is an educational banking system to teach young audiences about how banking works.</p>
    <h2>Banking made easy</h2> 
    <img src="images/bank_logo.JPG">
  </div>
    
  </body>
</html>