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
    $stmt = mysqli_prepare($con, "SELECT * FROM lecturer_t WHERE l_id = ?");
    mysqli_stmt_bind_param($stmt, "s", $id); // Use "s" for string ID
    mysqli_stmt_execute($stmt);

    // Get the result
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // echo "ID from URL: " . $_GET["id"] . "<br>";
        // echo "Lecturer ID from Database: " . $row['l_id'] . "<br>";
        // Lecturer data found, load it into form fields
        $lecturerCardId = "";

        $stmtUser = mysqli_prepare($con, "SELECT u_card_id FROM user_t WHERE u_email = ?");
        mysqli_stmt_bind_param($stmtUser, "s", $row['l_email']);
        mysqli_stmt_execute($stmtUser);

        $resultUser = mysqli_stmt_get_result($stmtUser);

        if ($rowUser = mysqli_fetch_assoc($resultUser)) {
            $lecturerCardId = $rowUser['u_card_id'];
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
            <title>Edit Lecturer Details</title>
        </head>

        <body>
            <!--NavBar-->
            <div class="navbar">
                <p><a href="SearchLecturer.php"><i class="fas fa-arrow-left"></i> Back</a></p>
                <div class="header">
                    <h2>Change Lecturer Details</h2>
                </div>
            </div>
            <!--NavBar-->

            <div class="passwordcontainer">
                <h2>Edit Lecturer Details</h2>
                <form action="updateLecturer.php" method="post" enctype="multipart/form-data">
                    <label for="lecturerId">Lecturer Id</label>
                    <input type="text" name="lecturerId" value="<?php echo $row['l_id'] ?>" readonly><br>

                    <label for="lecturerEmail">Lecturer Email:</label>
                    <input type="email" name="lecturerEmail" value="<?php echo $row['l_email'] ?>" required><br>

                    <label for="lecturerPassword">Lecturer Password:</label>
                    <input type="password" name="lecturerPassword" value="<?php echo $row['l_password'] ?>" readonly><br>

                    <label for="lecturerName">Lecturer Name:</label>
                    <input type="text" name="lecturerName" value="<?php echo $row['l_name'] ?>" required><br>

                    <label for="lecturerPicture">Lecturer Picture:</label>
                    <input type="file" name="lecturerImage" required><br>

                    <label for="lecturerCardId">Lecturer Card ID:</label>
                    <input type="text" name="userCard" value="<?php echo $lecturerCardId ?>" required><br>

                    <button type="submit">Edit Details</button>
                </form>
            </div>

        </body>
        </html>

    <?php
    } else {
        echo "No lecturer found with ID: " . $id;
    }

    mysqli_stmt_close($stmt);
} else {
    echo "No ID parameter provided.";
}

mysqli_close($con);
?>
