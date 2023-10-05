<?php
include("conn.php");
session_start();

if (!isset($_SESSION['u_id'])) {
    header('location: loginpage.php');
    exit();
}

$u_id = $_SESSION['u_id'];

if (isset($_POST['feedback'])) {
    $feedback = mysqli_real_escape_string($con, $_POST['feedback']);

    if (empty($feedback)) {
        echo '<script>alert("Feedback field cannot be empty.");</script>';
    } else {
        $sql = "INSERT INTO feedback_t(u_id, fb_description)
        VALUES('$u_id', '$feedback')";

        if (mysqli_query($con, $sql)) {
            echo '<script>alert("Feedback Submitted!");
            window.location.href="feedback.php";</script>';
        } else {
            echo '<script>alert("Submission Error! ' . mysqli_error($con) . '");</script>';
        }
    }
}
mysqli_close($con);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Feedback Form</title>
    <link rel="stylesheet" type="text/css" href="feedback.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
        // JavaScript function to validate the feedback form
        function validateFeedbackForm() {
            var feedback = document.getElementById("feedback").value;

            if (feedback.trim() === "") {
                alert("Feedback field cannot be empty.");
                return false; // Prevent form submission
            }
        }
    </script>

</head>

<body>
    <div class="nav-bar">
        <a href="mainpg.php"><i class="fas fa-arrow-left"></i> Back to Home</a>
    </div>
    <div class="form-box">
        <form name="feedback-form" id="feedback-form" action="feedback.php" method="post"
            onsubmit="return validateFeedbackForm();">
            <h2>What would you like to report?</h2>
            <br><br>
            <span>Write your feedback:</span>
            <textarea name="feedback" id="feedback"></textarea>
            <br>
            <button type="submit" name="submit" id="submit">Submit</button>
        </form>
    </div>
</body>

</html>