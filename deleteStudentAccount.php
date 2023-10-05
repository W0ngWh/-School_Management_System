<?php
include("conn.php");
session_start();

if (!isset($_SESSION['user_role']) && $_SESSION['user_role'] !== 'admin') {
    header('location: loginpage.php');
    exit();
}

// Check if the 'id' parameter is present in the URL
if (isset($_GET['id'])) {
    // Get the student ID from the URL
    $id = $_GET['id'];

    // Debug: Output the ID to check if it's correct
    //echo "ID to delete: $id<br>";

    // Begin a database transaction
    mysqli_begin_transaction($con);

    $getEmailQuery = "SELECT s_email FROM students_t WHERE s_id = '$id' LIMIT 1";
    $resultEmail = mysqli_query($con, $getEmailQuery);

    if ($resultEmail && $row = mysqli_fetch_assoc($resultEmail)) {
        $studentEmail = $row['s_email'];

        // Attempt to delete from students_t
        $deleteStudentQuery = "DELETE FROM students_t WHERE s_id = '$id'";
        $resultStudent = mysqli_query($con, $deleteStudentQuery);

        if ($resultStudent) {
            // Debugging: Check if student record was deleted
            echo "Student record with ID $id has been deleted successfully.<br>";

            // Check if a student record with this ID existed
            if (mysqli_affected_rows($con) > 0) {
                // Delete the corresponding user record from the user_t table
                $deleteUserQuery = "DELETE FROM user_t WHERE u_email = ?";
                $stmt = mysqli_prepare($con, $deleteUserQuery);

                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, "s", $studentEmail);
                    $resultUser = mysqli_stmt_execute($stmt);

                    if ($resultUser) {
                        // Commit the transaction if both deletions are successful
                        mysqli_commit($con);
                        echo "User record associated with Student ID $id has been deleted successfully.<br>";
                    } else {
                        // Rollback the transaction if the user record deletion fails
                        mysqli_rollback($con);
                        echo "Error deleting user record: " . mysqli_error($con) . "<br>";
                    }
                } else {
                    // Rollback the transaction if the statement preparation fails
                    mysqli_rollback($con);
                    echo "Error preparing user record deletion statement: " . mysqli_error($con) . "<br>";
                }
            } else {
                // Rollback the transaction if no student record was found with the provided ID
                mysqli_rollback($con);
                echo "No student record found with ID $id.<br>";
            }
        } else {
            // Handle the SQL error if the student record deletion fails
            echo "Error deleting student record: " . mysqli_error($con) . "<br>";
        }
    } else {
        // Rollback the transaction if the email retrieval fails
        mysqli_rollback($con);
        echo "Error retrieving student email or no student record found with ID $id.<br>";
    }

    // End the transaction
    mysqli_autocommit($con, true);

    echo "Debugging completed.<br>";
} else {
    // 'id' parameter is missing in the URL
    echo "ID parameter is missing in the URL.<br>";
}
mysqli_close($con); // Close the database connection
echo '<script>alert("Student record successfully deleted!");
window.location.href = "SearchStudent.php";</script>';

?>