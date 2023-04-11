<?php
//login.php

include("database_connect.php");

if(isset($_COOKIE["type"]))
{
 header("location:index.php");
}

$message = '';

if(isset($_POST["login"]))
{
 if(empty($_POST["ACCOUNT_ID"]) || empty($_POST["USER_PASSWORD"]))
 {
  $message = "<div class='alert alert-danger'>Both Fields are required</div>";
 }
 else
 {
  $query = "
  SELECT * FROM ACCOUNT 
  WHERE ACCOUNT_ID = :ACCOUNT_ID
  ";
  $statement = $connect->prepare($query);
  $statement->execute(
   array(
    'ACCOUNT_ID' => $_POST["ACCOUNT_ID"]
   )
  );
  $count = $statement->rowCount();
  if($count > 0)
  {
   $result = $statement->fetchAll();
   foreach($result as $row)
   {
    if(password_verify($_POST["USER_PASSWORD"], $row["USER_PASSWORD"]))
    {
        setcookie("aid", $row["ACCOUNT_ID"], time()+3600);
        setcookie("fname", $row["USER_FNAME"], time()+3600);
        setcookie("lname", $row["USER_LNAME"], time()+3600);
        setcookie("balance", $row["BALANCE"], time()+3600);
        setcookie("type", $row["user_type"], time()+3600);
        
     
     header("location:index.php");
    }
    else
    {
     $message = '<div class="alert alert-danger">Wrong Password</div>';
    }
   }
  }
  else
  {
   $message = "<div class='alert alert-danger'>Username</div>";
  }
 }
}


?>

<!DOCTYPE html>
<html>
 <head>
  <title>Welcome to Bank</title>
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
 </head>
 <body>
  <br />
  <div class="container">
   <h2 align="center">Welcome to Happy Friends Bank</h2>
   <br />
   <div class="panel panel-default">

    <div class="panel-heading">Login</div>
    <div class="panel-body">
     <span><?php echo $message; ?></span>
     <form method="post">
      <div class="form-group">
       <label>User ID</label>
       <input type="text" name="ACCOUNT_ID" id="ACCOUNT_ID" class="form-control" />
      </div>
      <div class="form-group">
       <label>Password</label>
       <input type="password" name="USER_PASSWORD" id="USER_PASSWORD" class="form-control" />
      </div>
      <div class="form-group">
       <input type="submit" name="login" id="login" class="btn btn-info" value="Login" />
      </div>
     </form>
    </div>
   </div>
   <br />

<div class="createAccount">

<button onclick="window.location.href='signup.php'">New? Sign Up here</button>

</div>
   
  </div>
 </body>
</html>