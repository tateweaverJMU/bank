<!-- This is the admin page where all of the admin code and functionality is done. -->
<?php

include("database_connect.php");

if ($_COOKIE["type"] != 'master') {
    header("location:index.php");
  }

  // This is if the admin wants to change a users balance
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
            throw new PDOException("User not found");
          }
      } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
      }

      // UPDATE RECIPIENT

     // get the balance of the recipient and update
    $stmt = $connect->prepare("SELECT BALANCE FROM account WHERE ACCOUNT_ID = '$recipient'");
    $stmt->execute();
    $recipient_balance = $stmt->fetchColumn();

    // get the updated balance value
    $new_bal_r = $amount;
    

    $updatestmt1 = $connect->prepare("UPDATE account SET BALANCE = :new_column_value WHERE ACCOUNT_ID = '$recipient'");

    // Bind any necessary parameters to the prepared statement (if needed)
    $updatestmt1->bindParam(':new_column_value', $new_bal_r);

    // Set the new column value
    $new_column_value = $new_bal_r;

    // Execute the prepared statement using the execute() method
    $updatestmt1->execute();

  }

          
    

  

?>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<title>Admin Homepage</title>
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
	<header>
		<h1>Welcome, Admin!</h1>
        <a style="color:white" href="logout.php" >Logout</a>
	</header>

	<main>
		<p>Admin Tools</p>
        <h1>Change User Balances</h1>
        <br>

        <form method="POST">
        
        <label for="amount">Change Balance:</label>
        <input type="number" id="amount" name="amount"><br>
        
        <label for="r_id">Target User:</label>
        <input type="text" id="r_id" name="r_id"><br>

        <input type="submit" name="submit" value="Submit">
        </form>

        <h2>User info:</h2>


        <?php

    include("database_connect.php");

    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $acct_stmt = $connect->prepare("SELECT * FROM account WHERE user_type = 'user'");
    $acct_stmt->execute(array());
    $acct_result = $acct_stmt->fetchAll();

    foreach ($acct_result as $t)
    {

        echo "Account ID: " . $t['ACCOUNT_ID'] . " | Name: " . $t['USER_FNAME'] . " " .  $t['USER_LNAME'] . " | Balance: " . $t['BALANCE'] . "<br><br>";

    }
?>

<!-- This is for showing deposit and withdraw history -->
    <div id="history">

    <?php

    // $transactions_stmt = $connect->prepare("SELECT * FROM transaction");
    // $transactions_stmt->execute(array());
    // $transaction_result = $transactions_stmt->fetchAll();
    // foreach ($transaction_result as $t)
    // {

    //   echo "Transaction ID: " . $t['TRANSACTION_ID'] . " | Amount: $" . $t['AMOUNT'] . "<br>";


    // }


    $dep_stmt = $connect->prepare("SELECT TRANSACTION_ID, ACCOUNT_ID, AMOUNT FROM deposit JOIN transaction ON deposit.DEPOSIT_ID = transaction.DEPOSIT_ID");
    $dep_stmt->execute(array());
    $dep_result = $dep_stmt->fetchAll();

    $with_stmt = $connect->prepare("SELECT TRANSACTION_ID, ACCOUNT_ID, AMOUNT FROM withdraw JOIN transaction ON withdraw.WITHDRAW_ID = transaction.WITHDRAW_ID");
    $with_stmt->execute(array());
    $with_result = $with_stmt->fetchAll();

    echo "<div id='dep'>";
    echo "<h2>Deposits</h2>";
    

    foreach ($dep_result as $t)
    {
      
      echo "Transaction: " . $t['TRANSACTION_ID'] . " Amount: $" . $t['AMOUNT'] . " Recieved by " . $t['ACCOUNT_ID'] . "<br>";


    }

    echo "<br>";

    echo "</div>";

    echo "<div id='withdraw'>";
    echo "<h2>Withdraw History</h2>";


    
    foreach ($with_result as $t)
    {

      //echo " sent by " . $t['ACCOUNT_ID'] . "<br>";
      echo "Transaction: " . $t['TRANSACTION_ID'] . " Amount: $" . $t['AMOUNT'] . " sent by " . $t['ACCOUNT_ID'] . "<br>";


    }

    echo "</div>";



    ?>

  </div>

  <!-- Delete a transaction-->
  <?php



  if(isset($_POST['submit1'])) {
    echo "<meta http-equiv='refresh' content='0'>";
    
    $trans_id = $_POST['t_id'];
    
    // get transaction and delete it
     $stmt = $connect->prepare("DELETE FROM transaction WHERE TRANSACTION_ID = '$trans_id'");
     $stmt->execute();

     echo '<script type="text/javascript">
          alert("Successfullly deleted transaction");
        </script>';
     

  }
  //   echo "<meta http-equiv='refresh' content='0'>";

  //   $del_user = $_POST['del_id'];


  //   $depUpdate = "UPDATE deposit SET ACCOUNT_ID = 'deleted_user' WHERE ACCOUNT_ID = $del_user";

  //   // Prepare the statement with the query and bind the parameter values
  //   $upD = $connect->prepare($depUpdate);
  //   // $upD->bindValue(':new_value', 'deleted_user');
  //   // $upD->bindValue(':value', $del_user);

  //   $upD->execute();

  //   $withUpdate = "UPDATE withdraw SET ACCOUNT_ID = 'deleted_user' WHERE ACCOUNT_ID = $del_user";

  //   // Prepare the statement with the query and bind the parameter values
  //   $upW = $connect->prepare($withUpdate);
  //   // $upW->bindValue(':new_value', 'deleted_user');
  //   // $upW->bindValue(':value', $del_user);

  //   $upW->execute();






  ?>



  <h1>Delete Transaction:</h1>
  <br>

  <form method="POST">

  <label for="del_id">Delete Transaction:</label>
  <input type="text" id="t_id" name="t_id"><br>

  <input type="submit" name="submit1" value="Submit">
  </form>



	</main>

    
  

	<footer>
    
	</footer>
</body>
</html>

