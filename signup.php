<?php

include("database_connect.php");

function createUser() {
    echo "made it in";
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $username = $_POST['username'];
    $pass = $_POST['pass'];

    $stmt = $connect->prepare("INSERT INTO account (account_id, user_password, user_fname, user_lname, balance, business_id, user_type) VALUES (:username, :pass, :fname, :lname, :balance, :business_id, :user_type)");

    // Bind the values to the placeholders
    $stmt->bindParam(':fname', $fname);
    $stmt->bindParam(':lname', $lname);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':pass', $pass);
    $stmt->bindParam(':balance', 100);
    $stmt->bindParam(':business_id', 0);
    $stmt->bindParam(':user_type', user);

    // Set the values of the variables
    // $name = "John Doe";
    // $email = "johndoe@example.com";
    // $phone = "555-555-5555";

    // Execute the SQL statement
    $stmt->execute();

    header("location:login.php");

}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<body>

<form method="post" action="signup.php">
    
  <label for="fname">First Name:</label>
  <input type="text" id="fname" name="fname"><br>
  
  <label for="lname">Last Name:</label>
  <input type="text" id="lname" name="lname"><br>

  <label for="username">Create Username:</label>
  <input type="text" id="username" name="username"><br>

  <label for="pass">Create Password:</label>
  <input type="password" id="pass" name="pass"><br>

  <label for="cpassword">Confirm Password:</label>
  <input type="cpassword" id="cpassword" name="cpassword"><br>

  <input type="submit" value="Submit">
</form>

    
</body>
</html>