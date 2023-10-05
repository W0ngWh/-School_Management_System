<?php
include("conn.php");
session_start();

if (!isset($_SESSION['user_role']) && $_SESSION['user_role'] !== 'admin') {
    header('location: loginpage.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $file = "uploads/";
    $filename = $file . basename($_FILES["studentImage"]["name"]);

    // Check if the file is an actual image.
    $imageFileType = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $allowedExtensions = array("jpg", "jpeg", "png");

    // Check if the email already exists in the user_t table.
    $emailsql = "SELECT u_id FROM user_t WHERE u_email = '$_POST[studentEmail]'";
    $result = mysqli_query($con, $emailsql);

    if (mysqli_num_rows($result) > 0) {
        echo '<script>alert("Error: Email already exists. Please use a different email address.");</script>';
    } elseif (in_array($imageFileType, $allowedExtensions)) {
        // Check if the uploaded file is a valid image.
        $imageInfo = @getimagesize($_FILES["studentImage"]["tmp_name"]);
        if ($imageInfo === false) {
            echo '<script>alert("Error: The uploaded file is not a valid image. Only JPG, JPEG, and PNG files are allowed. Please upload a valid image file.");</script>';
        } else {
            // Attempt to move the uploaded file to the specified directory.
            if (move_uploaded_file($_FILES["studentImage"]["tmp_name"], $filename)) {
                // The file has been successfully uploaded.
                $usersql = "INSERT INTO user_t(u_email, u_password, u_role, u_card_id) 
                    VALUES('$_POST[studentEmail]', '$_POST[studentPassword]', 'student', '$_POST[userCard]')";

                $sql = "INSERT INTO students_t(s_id, s_email, s_password, s_name, s_image, s_intake, s_programme)
                    VALUES
                    ('$_POST[studentId]','$_POST[studentEmail]','$_POST[studentPassword]','$_POST[studentName]',
                    '$filename','$_POST[studentIntake]','$_POST[studentProgramme]')";

                if (mysqli_query($con, $usersql) && mysqli_query($con, $sql)) {
                    echo '<script>alert("Student record successfully added!");
                        window.location.href = "StudentAccount.php";
                        </script>';
                    exit;
                } else {
                    echo '<script>alert("Error: ' . mysqli_error($con) . '\\nRecord is not added, please check your input and try again.");</script>';
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        echo '<script>alert("Error: File type not allowed. Only JPG, JPEG, and PNG files are allowed. Please upload a valid image file.");</script>';
    }
}
mysqli_close($con);
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="setting.css">
    <title>Student Account</title>

</head>

<body>
    <!--NavBar-->
    <div class="navbar">
        <p><a href="AdminMainPage.php"><i class="fas fa-arrow-left"></i> Back</a></p>
        <div class="header">
            <h2>Add New Student</h2>
        </div>
    </div>
    <!--NavBar-->

    <div class="passwordcontainer">
        <h2>Add New Student</h2>
        <form action="" method="post" enctype="multipart/form-data">

            <label for="studentId">Student Id:</label>
            <input type="text" name="studentId" required><br>

            <label for="studentEmail">Student Email:</label>
            <input type="email" name="studentEmail" required><br>

            <label for="studentPassword">Student Password:</label>
            <input type="password" name="studentPassword" required><br>

            <label for="studentName">Student Name:</label>
            <input type="text" name="studentName" required><br>

            <label for="studentPicture">Student Picture:</label>
            <input type="file" name="studentImage" required><br>

            <label for="studentIntake">Student Intake:</label>
            <input type="text" name="studentIntake" required><br>

            <label for="studentProgramme">Student Programme:</label>
            <input type="text" name="studentProgramme" required><br>

            <label for="studentCard">Student Card ID:</label>
            <input type="text" name="userCard" required><br>

            <button type="submit">Add New Student</button>
        </form>
    </div>

</body>

</html>