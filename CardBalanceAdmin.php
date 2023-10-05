<?php
include("conn.php");
session_start();

if (!isset($_SESSION['user_role']) && $_SESSION['user_role'] !== 'admin') {
    header('location: loginpage.php');
    exit();
}

$message = ""; 
$updateBalanceStmt = null; 

$u_id = $_SESSION['u_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cardId = $_POST['card_id'];
    $amount = floatval($_POST['amount']);

    // Check if the card ID exists in the cards table
    $checkCardQuery = "SELECT u_id FROM cards WHERE card_id = ?";
    $checkCardStmt = $con->prepare($checkCardQuery);
    $checkCardStmt->bind_param("i", $cardId);

    if ($checkCardStmt->execute()) {
        $result = $checkCardStmt->get_result();
        
        if ($result->num_rows > 0) {
            // Card ID found, fetch the associated u_id
            $row = $result->fetch_assoc();
            $u_id = $row['u_id'];

            // Update card balance
            $updateBalanceQuery = "UPDATE cards SET balance = balance + ? WHERE card_id = ?";
            $updateBalanceStmt = $con->prepare($updateBalanceQuery);
            $updateBalanceStmt->bind_param("ds", $amount, $cardId); // Use "ds" for double and string
            
            if ($updateBalanceStmt->execute()) {
                if ($updateBalanceStmt->affected_rows > 0) {
                    // Update successful, insert transaction history
                    $transactionAmount = floatval($_POST['amount']);
                    $insertHistoryQuery = "INSERT INTO transaction_history (card_id, u_id, amount) VALUES (?, ?, ?)";
                    $insertHistoryStmt = $con->prepare($insertHistoryQuery);
                    
                    if ($insertHistoryStmt) {
                        $insertHistoryStmt->bind_param("idi", $cardId, $u_id, $transactionAmount);

                        if ($insertHistoryStmt->execute()) {
                            // Successfully inserted transaction history
                            $message = "Balance updated successfully.";
                        } else {
                            $message = "Error adding transaction history: " . $insertHistoryStmt->error;
                        }
                        $insertHistoryStmt->close();
                    } else {
                        $message = "Error preparing transaction history query: " . mysqli_error($con);
                    }
                } else {
                    $message = "Card ID not found.";
                }
            } else {
                $message = "Error updating balance: " . $updateBalanceStmt->error;
            }
        } else {
            $message = "Card ID not found.";
        }
    } else {
        $message = "Error executing query: " . $checkCardStmt->error;
    }

    $checkCardStmt->close();
    if ($updateBalanceStmt) {
        $updateBalanceStmt->close();
    }
    $con->close();
}
?>




<!DOCTYPE html>
<html>

<head>
    <title>Card Balance Admin</title>
    <link rel="stylesheet" href="CardBalanceAdmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
        // Display a JavaScript alert box with the message
        var message = "<?php echo $message; ?>";
        if (message) {
            alert(message);
        }
    </script>
</head>

<body>
    <!--NavBar-->
    <div class="navbar">
        <p><a href="AdminMainPage.php"><i class="fas fa-arrow-left"></i> Back</a></p>
        <div class="header">
            <h2>Card Balance (Admin)</h2>
        </div>
    </div>
    <!--NavBar-->

    <!--UpdateCardBalance-->
    <div class="admin-form">
        <h3>Top-Up Card Balance</h3>
        <form id="update-form" action="CardBalanceAdmin.php" method="post">
            <label for="card_id" id="card_id" style='margin-left: 60px'>Card ID:</label>
            <input type="text" name="card_id" id="card_id" required>
            <br>
            <label for="amount" id="card_id">Amount to Add:</label>
            <input type="number" name="amount" step="0.01" id="card_id" required>
            <br>
            <div id="alert-message"></div>
            <button type="submit" id="submit">Top-Up Balance</button>
        </form>
    </div>
    <!--UpdateCardBalance-->

</body>

</html>

