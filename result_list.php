<?php
include("conn.php");
session_start();

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('location: loginpage.php');
    exit();
}

$results = mysqli_query($con, "SELECT * FROM result_t");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Student Results</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="news.css">
</head>
<body>
    <div class="navbar1">
        <p><a href="AdminMainPage.php"><i class="fas fa-arrow-left"></i> Back</a></p>
        <p>Manage Student Results</p>
        <div class="header">
            <a href="result_add.php">Add Result</a>
        </div>
    </div>

    <table>
        <tr bgcolor="#8D7B68">
            <td>ID</td>
            <td>Student Name</td>
            <td>Course Name</td>
            <td>Grade</td>
            <td>GPA</td>
            <td>CGPA</td>
            <td>Status</td>
            <td>Semester</td>
            <td>Date</td>
            <td>Edit</td>
            <td>Delete</td>
        </tr>

        <?php
        while ($row = mysqli_fetch_array($results)) {
            echo "<tr bgcolor=\"#E2C799\">";
            echo "<td>{$row['r_id']}</td>";
            echo "<td>{$row['r_s_id']}</td>";
            echo "<td>{$row['r_c_name']}</td>";
            echo "<td>{$row['r_grade']}</td>";
            echo "<td>{$row['r_gpa']}</td>";
            echo "<td>{$row['r_cgpa']}</td>";
            echo "<td>{$row['r_status']}</td>";
            echo "<td>{$row['r_semester']}</td>";
            echo "<td>{$row['r_date']}</td>";
            echo "<td><a href=\"result_edit.php?id={$row['r_id']}\">Edit</a></td>";
            echo "<td><a href=\"result_delete.php?id={$row['r_id']}\" onClick=\"return confirm('Delete this student's result data?');\">Delete</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
