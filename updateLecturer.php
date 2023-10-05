<?php
include("conn.php");
session_start();

if (!isset($_SESSION['user_role']) && $_SESSION['user_role'] !== 'admin') {
    header('location: loginpage.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lecturerId = $_POST['lecturerId'];
    $lecturerEmail = $_POST['lecturerEmail'];
    $lecturerPassword = $_POST['lecturerPassword'];
    $lecturerName = $_POST['lecturerName'];
    $lecturerCardId = $_POST['userCard']; // Correct variable name

    if ($_FILES['lecturerImage']['error'] === UPLOAD_ERR_OK) {
        $fileTmpName = $_FILES['lecturerImage']['tmp_name'];
        $fileName = $_FILES['lecturerImage']['name'];

        $uploadDir = 'uploads/';

        if (move_uploaded_file($fileTmpName, $uploadDir . $fileName)) {
            $imagePath = $uploadDir . $fileName;

            $sql = "UPDATE lecturer_t SET
                    l_email=?, 
                    l_password=?,
                    l_name=?, 
                    l_image=?
                    WHERE l_id=?";

            $stmt = mysqli_prepare($con, $sql);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "sssss", $lecturerEmail, $lecturerPassword, $lecturerName, $imagePath, $lecturerId);

                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_close($stmt);

                    // Update the u_card_id in the user_t table
                    $updateCardIdSql = "UPDATE user_t SET u_card_id=? WHERE u_email=?";
                    $stmtCardId = mysqli_prepare($con, $updateCardIdSql);

                    if ($stmtCardId) {
                        mysqli_stmt_bind_param($stmtCardId, "ss", $lecturerCardId, $lecturerEmail); // Correct variable name

                        if (mysqli_stmt_execute($stmtCardId)) {
                            mysqli_stmt_close($stmtCardId);
                            mysqli_close($con);
                            echo '<script>alert("Lecturer record successfully edited!");
                                    window.location.href = "SearchLecturer.php";</script>';
                            exit;
                        } else {
                            echo "Error updating u_card_id: " . mysqli_error($con);
                        }
                    } else {
                        echo "Error preparing statement for u_card_id update: " . mysqli_error($con);
                    }
                } else {
                    echo "Error updating record: " . mysqli_error($con);
                }
            } else {
                echo "Error preparing statement: " . mysqli_error($con);
            }
        } else {
            echo "Error moving uploaded file.";
        }
    } else {
        echo "Error with file upload: " . $_FILES['lecturerImage']['error'];
    }
}
?>