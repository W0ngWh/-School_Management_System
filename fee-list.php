<?php
include("conn.php");
session_start();

if (!isset($_SESSION['user_role']) && $_SESSION['user_role'] !== 'admin') {
    header('location: loginpage.php');
    exit();
}

$results = mysqli_query($con, "SELECT * FROM fees_t");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Fees List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="fee-list.css">
</head>

<body>
    <div class="navbar1">
        <p><a href="AdminMainPage.php"><i class="fas fa-arrow-left"></i> Back</a></p>
        <p>Student Fees</p>
        <div class="header">
            <a href="fee-add.html">Add Record</a>
        </div>
    </div>

    <table>
        <!-- Table Header -->
        <tr bgcolor="#8D7B68">
            <td>Student ID</td>
            <td>Total</td>
            <td>Paid</td>
            <td>Pending</td>
            <td>Pay</td>
            <td>Edit</td>
            <td>Delete</td>
        </tr>

        <!-- Table Body Using PHP -->
        <?php
            while ($row = mysqli_fetch_array($results)) {
                echo "<tr bgcolor=\"#E2C799\">";

                echo "<td>";
                echo $row['s_id'];
                echo "</td>";

                echo "<td>";
                echo $row['f_total'];
                echo "</td>";

                echo "<td>";
                echo $row['f_paid'];
                echo "</td>";

                echo "<td>";
                echo $row['f_pending'];
                echo "</td>";

                echo "<td><a href=\"fee-pay.php?id=";
                echo $row['f_id'];
                echo "\">Pay</a></td>";

                echo "<td><a href=\"fee-edit.php?id=";
                echo $row['f_id'];
                echo "\">Edit</a></td>";

                echo "<td><a href=\"fee-delete.php?id=";
                echo $row['f_id'];
                echo "\" onClick=\"return  confirm('Delete ";
                echo $row['s_id'];
                echo " details?');\">Delete</a></td>";
            }
        ?>
</body>