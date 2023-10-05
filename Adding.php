<?php
session_start();
include("conn.php");

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if a file was uploaded
    if (isset($_FILES['c_pic'])) {
        $fileName = $_FILES['c_pic']['name'];
        $fileTmpName = $_FILES['c_pic']['tmp_name'];
        $fileSize = $_FILES['c_pic']['size'];
        $fileError = $_FILES['c_pic']['error'];

        if ($fileError === 0) {
            $fileDestination = 'uploads/' . $fileName;

            // Move the uploaded file to the destination folder
            if (move_uploaded_file($fileTmpName, $fileDestination)) {
                // Extract course data from the form
                $c_name = $_POST['c_name'];
                $c_code = $_POST['c_code'];
                $c_lname = $_POST['c_lname'];
                $c_assignments = $_POST['c_assignments'];
                $c_exams = $_POST['c_exams'];
                $c_adate = $_POST['c_adate'];
                $c_edate = $_POST['c_edate'];
                $c_cdate = $_POST['c_cdate'];
                $c_intake = $_POST['c_intake'];
                $c_programme = $_POST['c_programme'];
                $c_description = $_POST['c_description'];

                // Insert course data into the database
                $sql = "INSERT INTO courses_t (c_name, c_code, c_lname, c_assignments, c_exams, c_pic, c_adate, c_edate, c_cdate, c_intake, c_programme, c_description)
                        VALUES ('$c_name', '$c_code', '$c_lname', '$c_assignments', '$c_exams', '$fileDestination', '$c_adate', '$c_edate', '$c_cdate', '$c_intake', '$c_programme', '$c_description')";

                if (mysqli_query($con, $sql)) {
                    echo '<script>alert("1 record added successfully!");';
                    echo 'window.location.href = "view_course.php";</script>';
                } else {
                    echo '<script>alert("Error: ' . mysqli_error($con) . '");</script>';
                }
            } else {
                echo '<script>alert("Error uploading the image.");</script>';
            }
        } else {
            echo '<script>alert("Invalid file type or file size is too large.");</script>';
        }
    } else {
        echo '<script>alert("No file was uploaded.");</script>';
    }
} else {
    echo '<script>alert("Form was not submitted.");</script>';
}

mysqli_close($con);
?>
