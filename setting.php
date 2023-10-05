<?php
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

?>

<!DOCTYPE html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="setting.css">
    <title>Setting</title>

    <script>
        function validateForm() {
            var profilePictureInput = document.getElementById('profilePicture');
            if (profilePictureInput.files.length === 0) {
                alert('Please select a profile picture before submitting.');
                return false;
            }
            return true;
        }
    </script>
</head>

<body>
    <!--NavBar-->
    <div class="navbar">
        <p><a href="mainpg.php"><i class="fas fa-arrow-left"></i> Back</a></p>
        <div class="header">
            <h2>Setting</h2>
        </div>
    </div>
    <!--NavBar-->
    <div class="container">

        <div class="profile-details">
            <?php
            //to show picture added successfully
            if (isset($_GET['profileChanged'])) {
                echo "<div id='successMessage'>Profile picture changed successfully!</div>";
            }
            echo "<h2>Profile Settings</h2>";
            echo "<table>";
            if ($isStudent) {
                echo "<tr><th>Student ID:</th><td>$s_id</td></tr>";
                echo "<tr><th>Email:</th><td>$s_email</td></tr>";
                echo "<tr><th>Name:</th><td>$s_name</td></tr>";
                echo "<tr><th>Intake:</th><td>$s_intake</td></tr>";
                echo "<tr><th>Programme:</th><td>$s_programme</td></tr>";
            } elseif ($isLecturer) {
                echo "<tr><th>Lecturer ID:</th><td>$l_id</td></tr>";
                echo "<tr><th>Email:</th><td>$l_email</td></tr>";
                echo "<tr><th>Name:</th><td>$l_name</td></tr>";
            }
            echo "</table>";
            ?>
            <div class="profile-picture-form">
                <form action="save_setting.php" method="post" enctype="multipart/form-data"
                    onsubmit="return validateForm();">
                    <label for="profilePicture">Profile Picture:</label>
                    <input type="file" name="profilePicture" id="profilePicture" accept="image/*">
                    <button type="submit" name="submit">Save Changes</button>
                </form>
            </div>
        </div>

        <div class="profile-pic">
            <?php if ($isStudent) {
                echo "<img src='{$_SESSION['s_image']}?t=" . time() . "' alt='Profile Picture' class='profile-image'>";
            } //to prevent caching and load the picture faster
            elseif ($isLecturer) {
                echo "<img src='{$_SESSION['l_image']}?t=" . time() . "' alt='Profile Picture' class='profile-image'>";
            }
            ?>
        </div>
    </div>

    <div class="container1">
        <h2>Manage Account</h2>
        <div class="profile-details">
            <label>If you want to change your password, click this<a href="change_password.php"
                    class="change-password-link">Change Password</a>
            </label>
            <br>

            <div class="logout-button">
                <label>Log Out?

                    <button id="logoutButton">Logout</button> </label>
            </div>
        </div>
    </div>

    <script>
                var successMessage = document.getElementById('successMessage');
                if (successMessage) {
                    setTimeout(function () {
                        successMessage.style.display = 'none';
                    }, 3000); // Hide the message after 3 seconds
                }

                document.getElementById('logoutButton').addEventListener('click', function () {
                    var confirmLogout = confirm("Are you sure you want to log out?");

                    // If the user confirms, proceed with the logout
                    if (confirmLogout) {
                        window.location.href = 'logout.php'; // Redirect to the logout page
                    }
                });

            </script>
</body>

</html>