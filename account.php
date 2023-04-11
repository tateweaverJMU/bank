


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
</head>
<body>
<div class="topnav">
      <a href="index.php">Big Bank</a>
      <a href="transaction.php">Make a Transaction</a>
      <a href="account.php">Account</a>
      <a href="logout.php">Logout</a>


    </div>
<?php
  if(isset($_COOKIE["type"]))
  {

    echo '<h2 align="center">Welcome User</h2>';
    if (isset($_COOKIE["aid"])) {
        $account_id = $_COOKIE["aid"];
        echo $account_id;
    }
    if (isset($_COOKIE["fname"])) {
        $fname = $_COOKIE["fname"];
        echo $fname;
    }
    if (isset($_COOKIE["lname"])) {
        $lname = $_COOKIE["lname"];
        echo $lname;
    }
    if (isset($_COOKIE["balance"])) {
        $balance = $_COOKIE["balance"];
        echo $balance;
    }

  }
?>
    
</body>
</html>