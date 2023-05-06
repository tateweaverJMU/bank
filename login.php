<!-- This is the login page to validat that users are valid and allow them access to a specific account in the database-->
<?php
//login.php

// connect database
include("database_connect.php");

// check if user type cookie is set to verify login
if(isset($_COOKIE["type"]))
{
 header("location:index.php");
}

$message = '';

if(isset($_POST["signup"]))
{
   header("location:signup.php");
}


// if someone presses the login button
if(isset($_POST["login"]))
{
   if(empty($_POST["ACCOUNT_ID"]) || empty($_POST["USER_PASSWORD"]))
   {
      $message = "<div class='alert alert-danger'>Both Fields are required</div>";
   }
   else
   {
      $query = "
      SELECT * FROM account 
      WHERE ACCOUNT_ID = :ACCOUNT_ID
      ";
      $statement = $connect->prepare($query);
      $statement->execute(
      array(
      'ACCOUNT_ID' => $_POST["ACCOUNT_ID"]
      ));

      $count = $statement->rowCount();
      if($count > 0)
      {
         $result = $statement->fetchAll();
         foreach($result as $row)
         {
         if(password_verify($_POST["USER_PASSWORD"], $row["USER_PASSWORD"]))
         {
            //set the cookies
            echo "right password";
            setcookie("aid", $row["ACCOUNT_ID"], time()+3600);
            setcookie("fname", $row["USER_FNAME"], time()+3600);
            setcookie("lname", $row["USER_LNAME"], time()+3600);
            setcookie("balance", $row["BALANCE"], time()+3600);
            setcookie("type", $row["user_type"], time()+3600);

            if ($row["user_type"] == 'master') {
               header("location:admin.php");
            } else {
        
            header("location:index.php");
            }
         }
         else
         {
            $message = '<div class="alert alert-danger">Wrong Password</div>';
         }
      }
   }
  else
  {
   $message = "<div class='alert alert-danger'>User ID not found.</div>";
  }
 }
}

?>

<!DOCTYPE html>
<html lang="en">
 <head>
 <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Happy Friends Bank</title>
   <link rel="icon" href="images/bank_logo.JPG">
   <link rel="stylesheet" href="css/form.css">
   <link rel="stylesheet" href="css/login.css">
   <link rel="stylesheet" href="css/helper.css">
 </head>
 <body>
  <br>
  <div class="container">
   <h2>Welcome to Happy Friends Bank</h2>
   <img src="images/bank_logo.JPG" alt="Happy Friends Bank Logo Here">

   <div class="panel panel-default">

    <div class="panel-body">
     <span id="error"><?php echo $message; ?></span>
     <form method="post" id="friendsform">
      <div class="form-group">
       <label>Username</label>
       <input type="text" name="ACCOUNT_ID" id="ACCOUNT_ID" class="form-control">
      </div>
      <div class="form-group">
       <label>Password</label>
       <input type="password" name="USER_PASSWORD" id="USER_PASSWORD" class="form-control">
      </div>
      <div class="form-group">
       <input type="submit" name="login" id="login" class="btn btn-info" value="Login">
      </div>
      <div class="form-group">
       <input type="submit" name="signup" id="signup" class="btn btn-info" value="New? Sign Up Here">
      </div>

      
     </form>
</div>
    
   </div>
   <br>

   <!-- <button id="signup" onclick="window.location.href='signup.php'">New? Sign Up here</button> -->

   
  </div>

  <div id=helper>
   <p>This is a login page. This is to keep your account and funds secure from hackers.</p>
</div>
 </body>
</html>