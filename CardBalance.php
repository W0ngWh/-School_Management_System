<?php
session_start();
include("conn.php");

if (!isset($_SESSION['u_id'])) {
    header('location: loginpage.php');
    exit();
}

$u_id = $_SESSION['u_id'];

$isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';


?>

<!DOCTYPE html>
<html>

<head>
    <title>Card Balance</title>
    <link rel="stylesheet" href="CardBalance.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <!--NavBar-->
    <div class="navbar">
    <?php if (!$isAdmin) { ?>
        <p><a href="mainpg.php"><i class="fas fa-arrow-left"></i> Back</a></p>
    <?php } else { ?>
        <p><a href="AdminMainPage.php"><i class="fas fa-arrow-left"></i> Back</a></p>
    <?php } ?>
        <div class="header">
            <h2>Card Balance</h2>
        </div>
    </div>
    <!--NavBar-->

    <!--CardBalance-->
    <div class="balance-container">
        <?php
        $query = "SELECT card_id, balance FROM cards WHERE u_id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $u_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $cardId = $row['card_id'];
            $balance = $row['balance'];
            echo "<div class='card-balance'>";
            echo "<p class='balance-label' style='font-size: 20px;'>Balance</p>";
            echo "<p class='balance-value' style='color: rgb(19, 148, 19); font-size: 30px'>RM $balance</p>";
            echo "</div>";
        } else {
            echo "<p>No card found for this user. Please contact admin if this is an issue.</p>";
        }
        ?>
        <div class="pdf">
            <a href="generate_pdf.php" target="_blank" class="pdfbutton">Generate PDF <i class="fa fa-print"></i></a>
        </div>
    </div>
    <!--CardBalance-->

    <!--History-->
    <div class="transaction-history">
        <h3>Transaction History</h3>
        <?php
        $transactionHistoryQuery = "SELECT transaction_date, amount, DATE_FORMAT(transaction_date, '%Y-%m-%d') AS transaction_date_formatted, DATE_FORMAT(transaction_date, '%h:%i %p') AS transaction_time FROM transaction_history WHERE card_id = ?";
        $transactionHistoryStmt = $con->prepare($transactionHistoryQuery);
        $transactionHistoryStmt->bind_param("i", $cardId);
        $transactionHistoryStmt->execute();
        $transactionHistoryResult = $transactionHistoryStmt->get_result();

        if ($transactionHistoryResult->num_rows > 0) {
            echo "<table style='margin: auto;'>";
            echo "<tr><th>Date</th><th>Time</th><th>Amount</th></tr>";
            while ($row = $transactionHistoryResult->fetch_assoc()) {
                $transactionDateFormatted = $row['transaction_date_formatted'];
                $transactionTime = $row['transaction_time'];
                $amount = $row['amount'];
                echo "<tr><td>$transactionDateFormatted</td><td>$transactionTime</td><td>RM$amount</td></tr>";
            }
            echo "</table>";
        } else {
            echo "No transaction history.";
        }
        ?>
    </div>
    <!--History-->
</body>

</html>