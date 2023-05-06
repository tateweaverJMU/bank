

<?php

// This is the signup page. From here users not logged in can create an account they can sign into HFB with.
// Basic page including a form and PHP code to create an account in the database.

if ($_COOKIE["type"] == 'master') {
  header("location:admin.php");
}

if ($_COOKIE["type"] == 'user') {
  header("location:index.php");
}

if(isset($_POST['return'])) {
  header("location:login.php");
}

if(isset($_POST['submit'])) {

    include("database_connect.php");

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $account_id = $_POST['username'];

    $password = $_POST['pass'];
    $hashpass = password_hash($password, PASSWORD_DEFAULT);
    

    try {
        // set the PDO error mode to exception
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // sql statement to insert
        $sql = $connect->prepare("INSERT INTO account (account_id, user_password, user_fname, user_lname, balance, business_id, user_type)  VALUES ('$account_id', '$hashpass', '$fname', '$lname', '100', '0', 'user')");
        
        // use exec() because no results are returned

        $sql->execute();

        //$connect->exec($sql);
        
        echo '<script type="text/javascript">
          alert("New account created successfully. Please return to Login to access your account.");
        </script>';


      } catch(PDOException $e) {

        echo '<script type="text/javascript">
          alert("Account with that username already exists. Sorry!");
        </script>';

      }
    

}




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/bank_logo.JPG">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/signup.css">
</head>
<body>
  
<h1 align="center">Create an Account:</h1>

<form method="POST" action="">
    
  <label for="fname">First Name:</label>
  <input type="text" id="fname" name="fname"><br>
  
  <label for="lname">Last Name:</label>
  <input type="text" id="lname" name="lname"><br>

  <label for="username">Create Username:</label>
  <input type="text" id="username" name="username"><br>

  <label for="pass">Create Password:</label>
  <input type="password" id="pass" name="pass"><br>

  <input type="submit" name="submit" value="Submit">

<input type="submit" name="return" value="Return to Login">

</form>

<!-- <button onclick="window.location.href='login.php'">Return to login</button> -->

    
</body>
</html>