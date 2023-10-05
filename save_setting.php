<?php
include("conn.php");
session_start();

if (!isset($_SESSION['s_id']) && !isset($_SESSION['l_id'])) {
    header('location: loginpage.php');
    exit();
}

$isStudent = isset($_SESSION['s_id']);
$isLecturer = isset($_SESSION['l_id']);

if ($isStudent) {
    // Student session information
    $s_id = $_SESSION['s_id'];
    $s_name = $_SESSION['s_name'];
    $s_email = $_SESSION['s_email'];
    $s_image = $_SESSION['s_image'];
    $s_intake = $_SESSION['s_intake'];
    $s_programme = $_SESSION['s_programme'];
}

if ($isLecturer) {
    // Lecturer session information
    $l_id = $_SESSION['l_id'];
    $l_name = $_SESSION['l_name'];
    $l_email = $_SESSION['l_email'];
    $l_image = $_SESSION['l_image'];

}

if (isset($_POST['submit'])) {
    $profilePicture = $_FILES['profilePicture'];

    $fileName = $profilePicture['name'];
    $fileTmpName = $profilePicture['tmp_name'];
    $fileSize = $profilePicture['size'];
    $fileError = $profilePicture['error'];

    if ($fileError === 0) {
        $fileDestination = 'uploads/' . $fileName;

        // Move the uploaded file to the destination folder
        if (move_uploaded_file($fileTmpName, $fileDestination)) {
            if ($isStudent) {
                // Update student session and database
                $student_id = $_SESSION['s_id'];
                $sql = "UPDATE students_t SET s_image = '$fileDestination' WHERE s_id = '$student_id'";
            } elseif ($isLecturer) {
                // Update lecturer session and database
                $lecturer_id = $_SESSION['l_id'];
                $sql = "UPDATE lecturer_t SET l_image = '$fileDestination' WHERE l_id = '$lecturer_id'";
            }

            if ($con->query($sql) === TRUE) {
                $_SESSION['s_image'] = $fileDestination;

                // Redirect back to the setting page with a success message
                header('location: setting.php?profileChanged=1');
                exit();
            } else {
                echo "Error updating profile picture: " . mysqli_error($con);
            }
        } else {
            echo "Error moving uploaded file to destination folder.";
        }
    } else {
        echo "Error uploading profile picture.";
    }
}

?>