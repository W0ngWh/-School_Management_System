<?php
include("conn.php");
session_start();

$isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
if (!$isAdmin) {
    header('location: loginpage.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve values from the form
    $resultID = $_POST["r_id"];
    $grade = $_POST["r_grade"];
    $gpa = $_POST["r_gpa"];
    $cgpa = isset($_POST["r_cgpa"]) ? $_POST["r_cgpa"] : null;
    $status = $_POST["r_status"];
    $semester = $_POST["r_semester"];
    $resultDate = $_POST["r_date"];

    $updateQuery = "UPDATE result_t 
                    SET r_grade = ?, r_gpa = ?, r_cgpa = ?, r_status = ?, r_semester = ?, r_date = ?
                    WHERE r_id = ?";

    $stmt = mysqli_prepare($con, $updateQuery);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssisi", $grade, $gpa, $cgpa, $status, $semester, $resultDate, $resultID);

        if (mysqli_stmt_execute($stmt)) {
            // Result update successful
            echo "<script>alert('Result updated successfully!');
            window.location.href = 'result_list.php';</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
    }
    mysqli_close($con);
}
?>
