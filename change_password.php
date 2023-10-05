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
    $s_email = $_SESSION['s_email'];
}

if ($isLecturer) {
    // Lecturer session information
    $l_id = $_SESSION['l_id'];
    $l_email = $_SESSION['l_email'];
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $currentPassword = $_POST["currentPassword"];
    $newPassword = $_POST["newPassword"];
    $confirmNewPassword = $_POST["confirmNewPassword"];

    // Retrieve the current password from the database
    if ($isStudent) {
        $sql = "SELECT s_password FROM students_t WHERE s_id = '$s_id'";
    } elseif ($isLecturer) {
        $sql = "SELECT l_password FROM lecturer_t WHERE l_id = '$l_id'";
    }
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($isStudent) {
        $storedPassword = $row["s_password"];
    } elseif  ($isLecturer) {
        $storedPassword = $row["l_password"];
    }

    // Check if the current password matches the stored password
    if ($currentPassword === $storedPassword) {
        // Check if the new password and confirm new password match
        if ($newPassword === $confirmNewPassword) {
            if ($isStudent) {
                $updatepassword = "UPDATE students_t SET s_password = '$newPassword' WHERE s_id = '$s_id'";
                $updatePasswordUser = "UPDATE user_t SET u_password = '$newPassword' WHERE u_email = '$s_email'";
            } elseif ($isLecturer) {
                $updatepassword = "UPDATE lecturer_t SET l_password = '$newPassword' WHERE l_id = '$l_id'";
                $updatePasswordUser = "UPDATE user_t SET u_password = '$newPassword' WHERE u_email = '$l_email'";
            }

            if (mysqli_query($con, $updatepassword) && mysqli_query($con, $updatePasswordUser)) {
                $successMessage = "Password changed successfully!";
            } else {
                $errorMessage = "Error updating password: " . mysqli_error($con);
                echo "Error updating password: " . mysqli_error($con);
            }
        } else {
            $errorMessage = "New password and confirm new password do not match.";
        }
    } else {
        $errorMessage = "Incorrect current password. Please try again.";
    }
}
?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="setting.css">
    <title>Change Password</title>
</head>

<body>
    <!--NavBar-->
    <div class="navbar">
        <p><a href="setting.php"><i class="fas fa-arrow-left"></i> Back</a></p>
        <div class="header">
            <h2>Change Password</h2>
        </div>
    </div>
    <!--NavBar-->

    <div class="passwordcontainer">
        <h2>Change Password</h2>
        <?php
        if (isset($successMessage)) {
            echo "<p style='color: green;'>$successMessage</p>";
        }
        if (isset($errorMessage)) {
            echo "<p id='errorMessage' style='color: red;'>$errorMessage</p>";
        }

        ?>
        <form action="" method="post" onsubmit="return validateForm();">
            <label for="currentPassword">Current Password:</label>
            <input type="password" name="currentPassword" required><br>
            <label for="newPassword">New Password:</label>
            <input type="password" name="newPassword" id="newPassword" required><br>
            <label for="confirmNewPassword">Confirm New Password:</label>
            <input type="password" name="confirmNewPassword" id="confirmNewPassword" required><br>
            <button type="submit">Change Password</button>
        </form>
    </div>

</body>

<script>
    function validateForm() {
        var newPassword = document.getElementById('newPassword').value;
        var confirmNewPassword = document.getElementById('confirmNewPassword').value;

        if (newPassword !== confirmNewPassword) {
            alert('New password and confirm new password do not match.');
            return false;
        }

        var errorMessage = document.getElementById('errorMessage');
        if (errorMessage) {
            errorMessage.style.display = 'none';
        }

        return true;
    }

    var errorMessage = document.getElementById('errorMessage');
    if (errorMessage) {
        setTimeout(function () {
            errorMessage.style.display = 'none';
        }, 3000); // Hide any error message after 3 seconds
    }

    var successMessage = document.getElementById('successMessage');
    if (successMessage) {
        setTimeout(function () {
            successMessage.style.display = 'none';
        }, 3000); // Hide success message after 3 seconds
    }
</script>

</html>