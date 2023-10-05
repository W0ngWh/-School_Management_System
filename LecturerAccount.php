<?php
include("conn.php");
session_start();

if (!isset($_SESSION['user_role']) && $_SESSION['user_role'] !== 'admin') {
    header('location: loginpage.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $file = "uploads/";
    $filename = $file . basename($_FILES["lecturerImage"]["name"]);

    $imageFileType = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $allowedExtensions = array("jpg", "jpeg", "png");

    $emailsql = "SELECT u_id FROM user_t WHERE u_email = '$_POST[lecturerEmail]'";
    $result = mysqli_query($con, $emailsql);

    if (mysqli_num_rows($result) > 0) {
        echo '<script>alert("Error: Email already exists. Please use a different email address.");</script>';
    } elseif (in_array($imageFileType, $allowedExtensions)) {
        // Attempt to move the uploaded file to the specified directory.
        if (move_uploaded_file($_FILES["lecturerImage"]["tmp_name"], $filename)) {
            // The file has been successfully uploaded.
            $usersql = "INSERT INTO user_t(u_email, u_password, u_role, u_card_id) 
            VALUES('$_POST[lecturerEmail]', '$_POST[lecturerPassword]', 'lecturer', '$_POST[userCard]')";

            $sql = "INSERT INTO lecturer_t(l_id, l_email, l_password, l_name, l_image)
            VALUES
            ('$_POST[lecturerId]','$_POST[lecturerEmail]','$_POST[lecturerPassword]',
            '$_POST[lecturerName]','$filename')";

            if (mysqli_query($con, $usersql) && mysqli_query($con, $sql)) {
                echo '<script>alert("Lecturer record successfully added!");
                        window.location.href = "LecturerAccount.php";
                        </script>';
                exit;
            } else {
                echo '<script>alert("Error: ' . mysqli_error($con) . '\\nRecord is not added, please check your input and try again.");</script>';
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
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
    <title>Lecturer Account</title>

</head>

<body>
    <!--NavBar-->
    <div class="navbar">
        <p><a href="AdminMainPage.php"><i class="fas fa-arrow-left"></i> Back</a></p>
        <div class="header">
            <h2>Add New Lecturer</h2>
        </div>
    </div>
    <!--NavBar-->

    <div class="passwordcontainer">
        <h2>Add New Lecturer</h2>
        <form action="" method="post" enctype="multipart/form-data">

            <label for="lecturerEmail">Lecturer Id:</label>
            <input type="text" name="lecturerId" required><br>

            <label for="lecturerEmail">Lecturer Email:</label>
            <input type="email" name="lecturerEmail" required><br>

            <label for="lecturerPassword">Lecturer Password:</label>
            <input type="password" name="lecturerPassword" required><br>

            <label for="lecturerName">Lecturer Name:</label>
            <input type="text" name="lecturerName" required><br>

            <label for="lecturerPicture">Lecturer Picture:</label>
            <input type="file" name="lecturerImage" required><br>

            <label for="lecturerCard">Lecturer Card ID:</label>
            <input type="text" name="userCard" required><br>

            <button type="submit">Add New Lecturer</button>
        </form>
    </div>

</body>

</html>