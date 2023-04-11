<?php

if(!isset($_COOKIE["type"]))
{
 header("location:login.php");
}




?>


<!DOCTYPE html>
<html>
  <head>
    <title>Big Bank</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div class="topnav">
      <a href="index.php">Big Bank</a>
      <a href="transaction.php">Make a Transaction</a>
      <a href="account.php">Account</a>
      <a href="logout.php">Logout</a>


    </div>

    <h1>Welcome to Big Bank</h1>
    <p>Big Bank is an educational banking system to teach young audiences about how banking works.</p>
    <h2>Banking made easy</h2> 
    <p>put a picture here or something</p>
    
  </body>
</html>