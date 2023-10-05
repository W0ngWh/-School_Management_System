<?php
include("conn.php");
session_start();

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('location: loginpage.php');
    exit();
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // Create a prepared statement
    $stmt = mysqli_prepare($con, "SELECT * FROM students_t WHERE s_id = ?");
    mysqli_stmt_bind_param($stmt, "s", $id); // Use "s" for string ID
    mysqli_stmt_execute($stmt);

    // Get the result
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Student data found, load it into form fields
        // echo "ID from URL: " . $_GET["id"] . "<br>";
        // echo "Student ID from Database: " . $row['s_id'] . "<br>";

        $studentCardId = "";

        $stmtUser = mysqli_prepare($con, "SELECT u_card_id FROM user_t WHERE u_email = ?");
        mysqli_stmt_bind_param($stmtUser, "s", $row['s_email']);
        mysqli_stmt_execute($stmtUser);

        $resultUser = mysqli_stmt_get_result($stmtUser);

        if ($rowUser = mysqli_fetch_assoc($resultUser)) {
            $studentCardId = $rowUser['u_card_id'];
        }

        mysqli_stmt_close($stmtUser);
        ?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="setting.css">
            <title>Edit Student Details</title>
        </head>

        <body>
            <!--NavBar-->
            <div class="navbar">
                <p><a href="SearchStudent.php"><i class="fas fa-arrow-left"></i> Back</a></p>
                <div class="header">
                    <h2>Edit Student Details</h2>
                </div>
            </div>
            <!--NavBar-->

            <div class="passwordcontainer">
                <h2>Edit Student Details</h2>
                <form action="updateStudent.php" method="post" enctype="multipart/form-data">
                    <label for="studentId">Student Id</label>
                    <input type="text" name="studentId" value="<?php echo $row['s_id'] ?>" readonly><br>

                    <label for="studentEmail">Student Email:</label>
                    <input type="email" name="studentEmail" value="<?php echo $row['s_email'] ?>" required><br>

                    <label for="studentPassword">Student Password:</label>
                    <input type="password" name="studentPassword" value="<?php echo $row['s_password'] ?>" readonly><br>

                    <label for="studentName">Student Name:</label>
                    <input type="text" name="studentName" value="<?php echo $row['s_name'] ?>" required><br>

                    <label for="studentPicture">Student Picture:</label>
                    <input type="file" name="studentImage" required><br>

                    <label for="studentIntake">Student Intake:</label>
                    <input type="text" name="studentIntake" value="<?php echo $row['s_intake'] ?>" required><br>

                    <label for="studentProgramme">Student Programme:</label>
                    <input type="text" name="studentProgramme" value="<?php echo $row['s_programme'] ?>" required><br>

                    <label for="studentCardId">Student Card ID:</label>
                    <input type="text" name="userCard" value="<?php echo $studentCardId ?>" required><br>

                    <button type="submit">Edit Details</button>
                </form>
            </div>

        </body>
        </html>

    <?php
    } else {
        echo "No student found with ID: " . $id;
    }

    mysqli_stmt_close($stmt);
} else {
    echo "No ID parameter provided.";
}

mysqli_close($con);
?>
