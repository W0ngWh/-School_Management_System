<?php
include("conn.php");
session_start();

if (!isset($_SESSION['u_id'])) {
    header('location: loginpage.php');
    exit();
}

$isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
$isLecturer = isset($_SESSION['l_id']);

$result = mysqli_query($con, "SELECT * FROM courses_t");
?>

<!DOCTYPE html>
<html>
<header>
    <title>Course List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="news.css">
</header>

<body>
    <div class="navbar1">
        <?php if ($isAdmin) { ?>
        <p><a href="AdminMainPage.php"><i class="fas fa-arrow-left"></i> Back</a></p>
        <?php } elseif ($isLecturer) { ?>
            <p><a href="mainpg.php"><i class="fas fa-arrow-left"></i> Back</a></p>
        <?php } ?>
    </div>

    <h2>View Course Added</h2>
    <table width=80%">
        <tr bgcolor="#8D7B68">
            <td>Course Name</td>
            <td>Course Code</td>
            <td>Lecturer Name</td>
            <td>Assignments Name</td>
            <td>Exam Name</td>
            <td>Image</td>
            <td>Assignment Date</td>
            <td>Exam Date</td>
            <td>Course Date</td>
            <td>Edit Course</td>
            <td>Delete</td>
        </tr>

        <?php
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr bgcolor='#E2C799'>";

            echo "<td>";
            echo $row['c_name'];
            echo "</td>";

            echo "<td>";
            echo $row['c_code'];
            echo "</td>";

            echo "<td>";
            echo "<a href=\"mailto:" . $row['c_lname'] . "\">" . $row['c_lname'] . "</a>";
            echo "</td>";

            echo "<td>";
            echo $row['c_assignments'];
            echo "</td>";

            echo "<td>";
            echo $row['c_exams'];
            echo "</td>";

            echo "<td>";
            echo $row['c_pic'];
            echo "</td>";

            echo "<td>";
            echo $row['c_adate'];
            echo "</td>";

            echo "<td>";
            echo $row['c_edate'];
            echo "</td>";

            echo "<td>";
            echo $row['c_cdate'];
            echo "</td>";

            echo "<td><a href=\"edit_course.php?id=";
            echo $row['c_id'];
            echo "\" onClick=\"return confirm('Edit course details?');\">Edit</a></td>";

            echo "<td><a href=\"delete_course.php?id=";
            echo $row['c_id'];
            echo "\" onClick=\"return confirm('Delete course details?');\">Delete</a></td>";

        }

        mysqli_close($con);
        ?>
    </table>
</body>

</html>