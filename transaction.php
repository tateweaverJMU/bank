

<!DOCTYPE html>
<html>
  <head>
    <title>Big Bank</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div class="topnav">
      <a href="index.php">Big Bank</a>
      <a href="index.php">Make a Transaction</a>
      <a href="account.php">Account</a>
      <a href="logout.php">Logout</a>


    </div>

    <h1>Make a Transaction</h1>

    <form method="post" action="signup.php">
    
    <label for="amount">Amount to transfer:</label>
    <input type="text" id="amount" name="amount"><br>
    
    <label for="r_id">Recipient User ID:</label>
    <input type="text" id="r_id" name="r_id"><br>


    <input type="submit" value="Submit">
    </form>

    
  </body>
</html>