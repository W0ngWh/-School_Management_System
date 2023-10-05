<?php
include("conn.php");
session_start();

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('location: loginpage.php');
    exit();
}

// Check if the r_id parameter is set in the URL
if (isset($_GET['id'])) {
    $resultId = $_GET['id'];

    $delete = "DELETE FROM result_t WHERE r_id = ?";

    $stmt = mysqli_prepare($con, $delete);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $resultId);

        if (mysqli_stmt_execute($stmt)) {
            // Successful delete
            header('location: result_list.php');
            exit();
        } else {
            echo "Error: " . mysqli_error($con);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Error in preparing the statement
        echo "Error: " . mysqli_error($con);
    }
} else {
    echo "<script>alert('Invalid request.');</script>";
    header('location: result_list.php');
}
?>
