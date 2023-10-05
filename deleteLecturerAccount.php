<?php
include("conn.php");
session_start();

if (!isset($_SESSION['user_role']) && $_SESSION['user_role'] !== 'admin') {
    header('location: loginpage.php');
    exit();
}


if (isset($_GET['id'])) {
    // Get the lecturer ID from the URL
    $id = $_GET['id'];

    // Debug: Output the ID to check if it's correct
    //echo "ID to delete: $id<br>";

    $getEmailQuery = "SELECT l_email FROM lecturer_t WHERE l_id = '$id' LIMIT 1";
    $resultEmail = mysqli_query($con, $getEmailQuery);

    if ($resultEmail && $row = mysqli_fetch_assoc($resultEmail)) {
        $lecturerEmail = $row['l_email'];

        // Attempt to delete from lecturer_t
        $deleteLecturerQuery = "DELETE FROM lecturer_t WHERE l_id = '$id'";
        $resultLecturer = mysqli_query($con, $deleteLecturerQuery);

        if ($resultLecturer) {
            // Debugging: Check if lecturer record was deleted
            echo "Lecturer record with ID $id has been deleted successfully.<br>";

            // Check if a lecturer record with this ID existed
            if (mysqli_affected_rows($con) > 0) {
                // Delete the corresponding user record from the user_t table
                $deleteUserQuery = "DELETE FROM user_t WHERE u_email = '$lecturerEmail'";
                $resultUser = mysqli_query($con, $deleteUserQuery);

                if ($resultUser) {
                    // Commit the transaction if both deletions are successful
                    mysqli_commit($con);
                    echo "User record associated with Lecturer ID $id has been deleted successfully.<br>";
                } else {
                    // Rollback the transaction if the user record deletion fails
                    mysqli_rollback($con);
                    echo "Error deleting user record: " . mysqli_error($con) . "<br>";
                }
            } else {
                // Rollback the transaction if no lecturer record was found with the provided ID
                mysqli_rollback($con);
                echo "No lecturer record found with ID $id.<br>";
            }
        } else {
            // Handle the SQL error if the lecturer record deletion fails
            echo "Error deleting lecturer record: " . mysqli_error($con) . "<br>";
        }

        // End the transaction
        mysqli_autocommit($con, true);

        echo "Debugging completed.<br>";
    } else {
        // 'id' parameter is missing in the URL
        echo "ID parameter is missing in the URL.<br>";
    }
    mysqli_close($con); // Close the database connection
    echo '<script>alert("Lecturer record successfully deleted!");
window.location.href = "SearchLecturer.php";</script>';
}
?>