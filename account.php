<!-- 
    This is the account page. This is used by a user to view their account information
    and transaction history.
-->
<?php
if(!isset($_COOKIE["type"]))
{
 header("location:login.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/bank_logo.JPG">
    <title>Happy Friends Bank</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/acc.css">

</head>
<body>
<div class="topnav">
      <a href="index.php">Home</a>
      <a href="transaction.php">Make a Transaction</a>
      <a href="account.php">Account</a>
      <a href="logout.php">Logout</a>


    </div>

    <div id=helper>
        <p>This is an account page. This page is where you view your account information and view all of your transactions to verify that you're the only person using your account and funds.</p>
</div>

<div id="accountinfo">
    <!-- Get and view the account info -->
<?php
  if(isset($_COOKIE["type"]))
  {

    include("database_connect.php");

    echo "<div id=profile>";
    echo "<h2 class='heading'>Account</h2>";

    // get first name, last name account_id and balance
    if (isset($_COOKIE["aid"])) {
        $account = $_COOKIE["aid"];
    }

    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $stmt = $connect->prepare("SELECT * FROM account WHERE ACCOUNT_ID = '$account'");
    $stmt->execute();
    $row = $stmt->fetch();

    $a_id = "Account ID: " . $row['ACCOUNT_ID'] . "<br>";
    $b = "Balance: " . $row['BALANCE'] . "<br>";
    $name = "Name: " . $row['USER_FNAME'] . " " . $row['USER_LNAME'] . "<br>";
   // $info = $name . " " . $a_id . " " . $b;
    //echo '<div class="info">' . $name . $a_id . $b .  '</div>';
    echo '<div class="info">';
    echo "<p>$name<p>";
    echo "<p>$a_id<p>";
    echo "<p>$b<p>";
    echo '</div>';
    //echo '<div class="info">' . $info . '</div>';
    echo "<img src='images/bank_logo.JPG'>";
    echo "</div>";
    


    // GET ACCOUNT TRANSACTION HISTORY
    // deposit information
    $deposit_stmt = $connect ->prepare("SELECT * FROM deposit WHERE ACCOUNT_ID = '$account'");
    $deposit_stmt->execute(array());
    $deposit_result = $deposit_stmt->fetchAll();
    // foreach ($deposit_result as $row)
    // {
    //     echo $row['DEPOSIT_ID'];
    // }

    // withdraw information
    $withdraw_stmt = $connect ->prepare("SELECT * FROM withdraw WHERE ACCOUNT_ID = '$account'");
    $withdraw_stmt->execute(array());
    $withdraw_result = $withdraw_stmt->fetchAll();
    // foreach ($withdraw_result as $row)
    // {
    //     echo $row['WITHDRAW_ID'];
    // }

    // cycle through transactions to put them in order
    $transactions = array();
    $transactions_stmt = $connect->prepare("SELECT * FROM transaction");
    $transactions_stmt->execute(array());
    $transaction_result = $transactions_stmt->fetchAll();
    foreach ($transaction_result as $t)
    {
        foreach ($withdraw_result as $w)
        {
            if ($w['WITHDRAW_ID'] == $t['WITHDRAW_ID'])
            {
                array_push($transactions, ['Withdraw', '-$' . $t['AMOUNT']]);
            }
        }
        foreach ($deposit_result as $d)
        {
            if ($d['DEPOSIT_ID'] == $t['DEPOSIT_ID'])
            {
                array_push($transactions, ['Deposit', '+$' . $t['AMOUNT']]);
            }
        }
    }

    // foreach ($transactions as $t)
    // {
    //     print_r($t);
    //     echo "<br>";
    // }

    // OUTPUT ALL WITHDRAW/DEPOSIT INFORMATION IN A TABLE
    echo "<div id='ts'>";
    echo "<h2 class='heading'>Transactions</h2>";
    echo "<table id='trans'>";
    foreach ($transactions as $t) 
    {
        echo "<tr id='item'>";
        echo "<td>" . $t[0] . "</td>";
        if ($t[0] == "Withdraw")
        {
            echo "<td id='w_money'>" . $t[1] . "</td>";
        }
        else {
            echo "<td id='d_money'>" . $t[1] . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";

    echo "</div>";
  }
?>

</div>
    
</body>
</html>