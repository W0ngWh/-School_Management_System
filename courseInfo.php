<?php
include("conn.php");
session_start();

if (!isset($_SESSION['u_id'])) {
    header('location: loginpage.php');
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Course Information</title>
    <style>
        /* Define CSS styles for the page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        .section {
            margin-top: 20px;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }

        .section h2 {
            color: #333;
        }

        .section p {
            font-size: 16px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container">

        <?php

        $data = $_GET['data'];
        $sql = "SELECT * FROM `courses_t` WHERE c_id= '$data'";
        $result = mysqli_query($con, $sql);
        if ($result) {
            $row = mysqli_fetch_assoc($result)
                ?>

            <h1>Course Information</h1>

            <!-- Course Overview Section -->
            <div class="section">
                <h2>Course Overview</h2>
                <p><strong>Course Title: </strong>
                    <?php echo $row['c_name']; ?>
                </p>
                <p><strong>Instructor: </strong>
                    <?php echo $row['c_lname']; ?>
                </p>
                <p><strong>Course Date: </strong>
                    <?php echo $row['c_cdate']; ?>
                </p>
                <p><strong>Course Code: </strong>
                    <?php echo $row['c_code']; ?>
                </p>
                <p><strong>Description: </strong>
                    <?php echo $row['c_description']; ?>
                </p>
            </div>

            <!-- Assignments Section -->
            <div class="section">
                <h2>Assignments</h2>
                <p><strong>Assignment 1: </strong>
                    <?php echo $row['c_assignments']; ?>
                </p>
                <p><strong>Assignment Due Date: </strong>
                    <?php echo $row['c_adate']; ?>
                </p>
            </div>

            <!-- Exams Section -->
            <div class="section">
                <h2>Exams</h2>
                <p><strong>Examination: </strong>
                    <?php echo $row['c_exams']; ?>
                </p>
                <p><strong>Examination Date: </strong>
                    <?php echo $row['c_edate']; ?>
                </p>
            </div>

            <!-- Resources Section -->
            <div class="section">
                <h2>Resources</h2>
                <p><strong>Slides: </strong>
                    <?php echo $row['c_name']; ?> Slides
                </p>
                <p><strong>Tutorials: </strong>
                    <?php echo $row['c_name']; ?> Tutorials
                </p>
            </div>
        </div>

        <?php
        }
        ?>

</body>

</html>