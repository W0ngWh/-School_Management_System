<?php
include("conn.php");
session_start();

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('location: loginpage.php');
    exit();
}

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
            $updateBalanceStmt->bind_param("di", $amount, $cardId);

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
    $updateBalanceStmt->close();
    $con->close();
}
?>