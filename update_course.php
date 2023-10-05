<?php
include("conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the course ID from the form
    $courseId = $_POST['c_id'];

    // Sanitize and retrieve other form data
    $courseName = mysqli_real_escape_string($con, $_POST['c_name']);
    $courseCode = mysqli_real_escape_string($con, $_POST['c_code']);
    $lecturerName = mysqli_real_escape_string($con, $_POST['c_lname']);
    $assignments = mysqli_real_escape_string($con, $_POST['c_assignments']);
    $exams = mysqli_real_escape_string($con, $_POST['c_exams']);
    $assignmentDate = $_POST['c_adate'];
    $examDate = $_POST['c_edate'];
    $courseDate = $_POST['c_cdate'];

    $imageFileName = $_FILES['c_pic']['name'];
    $imageTmpName = $_FILES['c_pic']['tmp_name'];

    if (!empty($imageFileName)) {
        // Define the directory where the images will be stored
        $uploadDirectory = "uploads/".$imageFileName; // Adjust this path as needed

        // Move the uploaded image to the target directory
        if (move_uploaded_file($imageTmpName, $uploadDirectory)) {
            // Update the course image path in the database
            $updateImageQuery = "UPDATE courses_t SET c_pic = '$uploadDirectory' WHERE c_id = $courseId";
            mysqli_query($con, $updateImageQuery);
        } else {
            // Handle the case where the image upload fails
            echo "Error uploading the image.";
        }
    }

    // Update the course details in the database
    $updateQuery = "UPDATE courses_t SET 
                    c_name = '$courseName',
                    c_code = '$courseCode',
                    c_lname = '$lecturerName',
                    c_assignments = '$assignments',
                    c_exams = '$exams',
                    c_adate = '$assignmentDate',
                    c_edate = '$examDate',
                    c_cdate = '$courseDate'
                    WHERE c_id = $courseId";

    if (mysqli_query($con, $updateQuery)) {
        // Course details updated successfully
        header("location: courses.php"); // Redirect to the course management page
        exit();
    } else {
        // Handle the case where the update query fails
        echo "Error updating course details: " . mysqli_error($con);
    }
}
?>
 