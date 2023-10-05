<?php
include("conn.php");
session_start();

if (!isset($_SESSION['user_role']) && $_SESSION['user_role'] !== 'admin') {
    header('location: loginpage.php');
    exit();
}

$results = mysqli_query($con, "SELECT * FROM news_t");
?>

<!DOCTYPE html>
<html>
<head>
    <title>News List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="news.css">
</head>

<body>
    <div class="navbar1">
        <p><a href="AdminMainPage.php"><i class="fas fa-arrow-left"></i> Back</a></p>
        <p>Manage News</p>
        <div class="header">
        <a href="news-add.html">Add News</a>
        </div>
    </div>

    <table>
        <!-- Table Header -->
        <tr bgcolor="#8D7B68">
            <td>ID</td>
            <td>Image</td>
            <td>Title</td>
            <td>Description</td>
            <td>Date</td>
            <td>Time</td>
            <td>Location</td>
            <td>Edit</td>
            <td>Delete</td>
        </tr>

        <!-- Table Body Using PHP -->
        <?php
        while ($row = mysqli_fetch_array($results)) {
            echo "<tr bgcolor=\"#E2C799\">";

            echo "<td>";
            echo $row['n_id'];
            echo "</td>";

            echo "<td>";
            echo $row['n_image'];
            echo "</td>";

            echo "<td>";
            echo $row['n_title'];
            echo "</td>";

            echo "<td>";
            echo $row['n_description'];
            echo "</td>";

            echo "<td>";
            echo $row['n_date'];
            echo "</td>";

            echo "<td>";
            echo $row['n_time'];
            echo "</td>";

            echo "<td>";
            echo $row['n_location'];
            echo "</td>";

            echo "<td><a href=\"news-edit.php?id=";
            echo $row['n_id'];
            echo "\">Edit</a></td>";

            echo "<td><a href=\"news-delete.php?id=";
            echo $row['n_id'];
            echo "\" onClick=\"return  confirm('Delete ";
            echo $row['n_title'];
            echo " details?');\">Delete</a></td>";

            echo "</tr>";
        }

        ?>
    </table>
</body>

</html>