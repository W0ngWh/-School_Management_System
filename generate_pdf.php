<?php
include("conn.php");
session_start();

$u_id = $_SESSION['u_id'];

// Get the card ID from the database based on the user's u_id
$query = "SELECT card_id FROM cards WHERE u_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $u_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $cardId = $row['card_id'];

    // Use the card ID to fetch the transaction history
    $transactionHistoryQuery = "SELECT * FROM transaction_history WHERE card_id = ?";
    $transactionHistoryStmt = $con->prepare($transactionHistoryQuery);
    $transactionHistoryStmt->bind_param("i", $cardId);
    $transactionHistoryStmt->execute();
    $transactionHistoryResult = $transactionHistoryStmt->get_result();

    // Start output buffering to capture HTML content
    ob_start();
    ?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>Transaction History</title>
        <link rel="stylesheet" href="generate_pdf.css">
    </head>

    <body>
        <h2>Pallas Education Group</h2>
        <div class="card-info">
            <span style="margin-left: 10px">Card ID:</span>
            <span style="margin-right: 10px">
                <?php echo $cardId; ?>
            </span>
        </div>
        <table>
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Amount</th>
            </tr>
            <?php
            while ($row = $transactionHistoryResult->fetch_assoc()) {
                $transactionDate = $row['transaction_date'];
                $amount = $row['amount'];
                $transactionDateTime = explode(" ", $transactionDate);
                echo "<tr><td>{$transactionDateTime[0]}</td><td>{$transactionDateTime[1]}</td><td>RM{$amount}</td></tr>";
            }
            ?>
        </table>
    </body>

    </html>

    <?php
    $output = ob_get_clean();
    echo $output;
} else {
    // Handle the case where card_id is not found in the database for the user
    echo "<script>alert('Card ID not found in the database for the user. Please contact admin if this is an issue.');
    window.location.href='CardBalance.php';</script>";
    exit();
}
?>