<?php
include("conn.php");
session_start();

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('location: loginpage.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Define the target directory for news images
    $targetDir = 'newsupload/';

    // Get the file name and extension
    $fileName = basename($_FILES['n_image']['name']);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Check if the file is an image
    $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
    if (in_array($fileType, $allowedTypes)) {
        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['n_image']['tmp_name'], $targetFilePath)) {
            // Insert news data into the database with the file path
            $n_title = $_POST['n_title'];
            $n_description = $_POST['n_description'];
            $n_date = $_POST['n_date'];
            $n_time = $_POST['n_time'];
            $n_location = $_POST['n_location'];

            $sql = "INSERT INTO news_t(n_image, n_title, n_description, n_date, n_time, n_location)
                    VALUES ('$targetFilePath', '$n_title', '$n_description', '$n_date', '$n_time', '$n_location')";

            if (mysqli_query($con, $sql)) {
                echo '<script>
                        alert("News Updated!");
                        window.location.href="news.php";
                      </script>';
            } else {
                echo "Update Error!" . mysqli_error($con);
            }
        } else {
            echo "Error uploading the file.";
        }
    } else {
        echo "Invalid file type. Allowed types: jpg, jpeg, png, gif";
    }
}

mysqli_close($con);
?>