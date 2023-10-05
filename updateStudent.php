<?php
include("conn.php");
session_start();

if (!isset($_SESSION['user_role']) && $_SESSION['user_role'] !== 'admin') {
    header('location: loginpage.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = $_POST['studentId'];
    $studentEmail = $_POST['studentEmail'];
    $studentPassword = $_POST['studentPassword'];
    $studentName = $_POST['studentName'];
    $studentIntake = $_POST['studentIntake'];
    $studentProgramme = $_POST['studentProgramme'];
    $studentCardId = $_POST['userCard'];

    if ($_FILES['studentImage']['error'] === UPLOAD_ERR_OK) {
        $fileTmpName = $_FILES['studentImage']['tmp_name'];
        $fileName = $_FILES['studentImage']['name'];

        $uploadDir = 'uploads/';

        if (move_uploaded_file($fileTmpName, $uploadDir . $fileName)) {
            $imagePath = $uploadDir . $fileName;

            // Print the update data for debugging
            // echo "Debug: Update Data<br>";
            // echo "Student ID: " . $studentId . "<br>";
            // echo "Student Email: " . $studentEmail . "<br>";
            // echo "Student Password: " . $studentPassword . "<br>";
            // echo "Student Name: " . $studentName . "<br>";
            // echo "Student Intake: " . $studentIntake . "<br>";
            // echo "Student Programme: " . $studentProgramme . "<br>";
            // echo "Image Path: " . $imagePath . "<br>";

            $sql = "UPDATE students_t SET
                    s_email=?, 
                    s_password=?,
                    s_name=?, 
                    s_image=?, 
                    s_intake=?, 
                    s_programme=? 
                    WHERE s_id=?";

            $stmt = mysqli_prepare($con, $sql);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "sssssss", $studentEmail, $studentPassword, $studentName, $imagePath, $studentIntake, $studentProgramme, $studentId);

                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_close($stmt);

                    // Update the u_card_id in the user_t table
                    $updateCardIdSql = "UPDATE user_t SET u_card_id=? WHERE u_email=?";
                    $stmtCardId = mysqli_prepare($con, $updateCardIdSql);

                    if ($stmtCardId) {
                        mysqli_stmt_bind_param($stmtCardId, "ss", $studentCardId, $studentEmail);

                        if (mysqli_stmt_execute($stmtCardId)) {
                            mysqli_stmt_close($stmtCardId);
                            mysqli_close($con);
                            echo '<script>alert("Student record successfully edited!");
                                    window.location.href = "SearchStudent.php";</script>';
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
        echo "Error with file upload: " . $_FILES['studentImage']['error'];
    }
}
?>