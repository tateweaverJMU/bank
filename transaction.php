<!-- This is our transaction page that shows all users and you can send a transaction to all of them-->
<!DOCTYPE html>
<html>
  <head>
  <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Happy Friends Bank</title>
    <link rel="icon" href="images/bank_logo.JPG">
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/transaction.css">
  </head>
  <body>
    <div class="topnav">
      <a href="index.php">Home</a>
      <a href="transaction.php">Make a Transaction</a>
      <a href="account.php">Account</a>
      <a href="logout.php">Logout</a>


    </div>

    <h1>Make a Transaction</h1>

    <form method="POST">
    
    <label for="amount">Amount to transfer:</label>
    <input type="number" id="amount" name="amount"><br>

    
    <label for="r_id">Recipient Account ID:</label>
    <input type="text" id="r_id" name="r_id"><br>


    <input type="submit" name="submit" value="Submit">
    </form>


<?php


include("database_connect.php");


if(!isset($_COOKIE["type"]))
{
 header("location:login.php");
}


if ($_COOKIE["type"] == 'master') {
  header("location:admin.php");
}


if (isset($_COOKIE["aid"])) {
  $cur_acc = $_COOKIE["aid"];
}

// The following code is to put the current users balance on the page
$bal_st = $connect->prepare("SELECT BALANCE FROM account WHERE ACCOUNT_ID = '$cur_acc'");

// Execute the prepared statement using the execute() method
$bal_st->execute();

// Fetch the result set using the fetch() method
while ($row = $bal_st->fetch()) {
    // Use PHP to generate HTML code that displays the retrieved column values
    echo "<p>Available Balance: " . $row['BALANCE'] . "</p>";
}

// This if statement is to cover all instances where a user submits a transaction request
if(isset($_POST['submit'])) {
  echo "<meta http-equiv='refresh' content='0'>";



  $amount = $_POST['amount'];
  $recipient = $_POST['r_id'];
  if (isset($_COOKIE["aid"])) {
    $sender_id = $_COOKIE["aid"];
  }

  try {
      // set the PDO error mode to exception
      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



    // verify the recipient exists
    $query = "
      SELECT * FROM account 
      WHERE ACCOUNT_ID = :ACCOUNT_ID
      ";
      $statement = $connect->prepare($query);
      $statement->execute(
      array(
      'ACCOUNT_ID' => $recipient
      ));

      $count = $statement->rowCount();
      if($count <= 0)
      {

        echo '<script type="text/javascript">
          alert("User not found. Please try again.");
        </script>';


        throw new PDOException("User not found");
      }


    // UPDATE SENDER

    // Get the Senders balance
    $stmt = $connect->prepare("SELECT BALANCE FROM account WHERE ACCOUNT_ID = '$sender_id'");
    $stmt->execute();
    $sender_balance = $stmt->fetchColumn();

    if ($sender_balance < $amount) {

      echo '<script type="text/javascript">
          alert("Insufficient funds. You can only send what you have!");
        </script>';


      throw new PDOException("Insufficient funds");
    }
    if ($amount <= 0) {

      echo '<script type="text/javascript">
          alert("No negative transfers!");
        </script>';

      throw new PDOException("Negative Transfer Not Allowed");
    }

    // get the updated balance value
    $new_bal = $sender_balance - $amount;
    

  $updatestmt = $connect->prepare("UPDATE account SET BALANCE = :new_column_value WHERE ACCOUNT_ID = '$sender_id'");

  // Bind any necessary parameters to the prepared statement (if needed)
  $updatestmt->bindParam(':new_column_value', $new_bal);

  // Set the new column value
  $new_column_value = $new_bal;

  // Execute the prepared statement using the execute() method
  $updatestmt->execute();

  

  // UPDATE RECIPIENT

     // get the balance of the recipient and update
    $stmt = $connect->prepare("SELECT BALANCE FROM account WHERE ACCOUNT_ID = '$recipient'");
    $stmt->execute();
    $recipient_balance = $stmt->fetchColumn();

    // get the updated balance value
    $new_bal_r = $recipient_balance + $amount;
    

  $updatestmt1 = $connect->prepare("UPDATE account SET BALANCE = :new_column_value WHERE ACCOUNT_ID = '$recipient'");

  // Bind any necessary parameters to the prepared statement (if needed)
  $updatestmt1->bindParam(':new_column_value', $new_bal_r);

  // Set the new column value
  $new_column_value = $new_bal_r;

  // Execute the prepared statement using the execute() method
  $updatestmt1->execute();


         // CREATE DEPOSIT/WITHDRAW/TRANSACTION
   // sql statements to add deposit and withdraw entities to database
   $sqldeposit = "INSERT INTO deposit (account_id) 
   VALUES ('$recipient')";

   $sqlwithdrawl = "INSERT INTO withdraw (account_id) 
   VALUES ('$sender_id')";
   
   // execute, and get the IDs of the entities inserted
   $connect->exec($sqldeposit);
   $dep_id =  $connect->lastInsertId();

   $connect->exec($sqlwithdrawl);
   $with_id =  $connect->lastInsertId();

 // create transaction object with the withdraw and deposit entities within
   $sqltrans = "INSERT INTO transaction (withdraw_id, deposit_id, amount) 
   VALUES ('$with_id', '$dep_id', '$amount')";
   $connect->exec($sqltrans);


    } catch(PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
  

}

?>
  <div id=helper>
    <p>This is a Transaction page. All banks have a transaction page to send money to other users.</p>
  </div>

  <div id="contacts">
    <h2>User List:</h2>

    
    <?php
    // This portion is to show all users available for transactions
      include("database_connect.php");

      $acc_stmt = $connect->prepare("SELECT * FROM account WHERE USER_TYPE = 'user' ORDER BY USER_FNAME ASC");
      $acc_stmt->execute(array());
      $acc_result = $acc_stmt->fetchAll();

      echo "<table>
            <tr>
              <th>Account ID</th>
              <th>First Name</th>
              <th>Last Name</th>
            </tr>";

      foreach ($acc_result as $a)
    {
      
      //echo $a['ACCOUNT_ID'] . " : " . $a['USER_FNAME'] . " " . $a['USER_LNAME'] . "<br>";

      echo "<tr>
            <td>" . $a['ACCOUNT_ID'] . "</td>
            <td>" . $a['USER_FNAME'] . "</td>
            <td>" .$a['USER_LNAME'] . "</td>
            </tr>";


    }

    echo "</table>"
    ?>

  </div>

  </body>
</html>