<?php
include("conn.php");
session_start();

if (!isset($_SESSION['user_role']) && $_SESSION['user_role'] !== 'admin') {
    header('location: loginpage.php');
    exit();
}

$results = mysqli_query($con, "SELECT * FROM feedback_t");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Feedback List</title>
    <link rel="stylesheet" type="text/css" href="feedback-list.css">
</head>

<body>
    <div class="back">
        <a href="AdminMainPage.php">Back to Home</a>
    </div>
    <table>
        <tr bgcolor="#8D7B68">
            <td>ID</td>
            <td>Feedback</td>
        </tr>

        <?php
        while ($row = mysqli_fetch_array($results)) {
            echo "<tr bgcolor=\"#E2C799\">";

            echo "<td>";
            echo $row['fb_id'];
            echo "</td>";

            echo "<td>";
            echo $row['fb_description'];
            echo "</td>";

            echo "</tr>";
        }
        ?>
    </table>
</body>

</html>