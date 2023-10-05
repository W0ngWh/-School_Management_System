<?php
include("conn.php");
session_start();

$isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';

if (!$isAdmin) {
  header('location: loginpage.php');
  exit();
}


if (isset($_GET['r_id'])) {
    $r_id = $_GET['r_id'];
    $query = "SELECT * FROM result_t WHERE r_id = $r_id";
    $results = mysqli_query($con, $query);
}

$r_id = $_GET['id'];
$results = mysqli_query($con, "SELECT * FROM result_t WHERE r_id = $r_id");
$row = mysqli_fetch_assoc($results);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Student Result</title>
    <link rel="stylesheet" type="text/css" href="AddCourse.css">
</head>

<body>
    <div class="navbar">
        <p><a href="result_list.php"><i class="fas fa-arrow-left"></i> Back</a></p>
        <div class="header">
            <h2>Edit Result</h2>
        </div>
    </div>

    <div class="container">
    <div id="feedback-form">
      <h2 class="header">Edit Student Result</h2><br>        
      <form action="result_update.php" method="post">
            <input type="hidden" name="r_id" id="stuid" value="<?php echo $row["r_id"] ?>"></input>

            <span>Student Name:</span>
            <input type="text" name="r_s_id" id="stuid" value="<?php echo $row["r_s_id"] ?>" disabled></input>
            <br>

            <span>Course Name:</span>
            <input type="text" name="r_c_name" id="coursename" value="<?php echo $row["r_c_name"] ?>" disabled></input>
            <br>

            <span>Grade:</span>
            <select name="r_grade" id="grade" required="required">
                <option value="">Select a Grade</option>
                <option value="A" <?php if ($row["r_grade"] == "A") echo "selected"; ?>>A</option>
                <option value="B" <?php if ($row["r_grade"] == "B") echo "selected"; ?>>B</option>
                <option value="C" <?php if ($row["r_grade"] == "C") echo "selected"; ?>>C</option>
                <option value="D" <?php if ($row["r_grade"] == "D") echo "selected"; ?>>D</option>
                <option value="F" <?php if ($row["r_grade"] == "F") echo "selected"; ?>>F</option>
            </select>
            <br>

            <span>GPA:</span>
            <input type="number" name="r_gpa" id="gpa" min="0" max="4.00" step="0.01" value="<?php echo $row["r_gpa"] ?>"></input>
            <br>

            <span>CGPA:</span>
            <input type="number" name="r_cgpa" id="cgpa" min="0" max="4.00" step="0.01" value="<?php echo $row["r_cgpa"] ?>"></input>
            <br>

            <span>Result Status:</span>
            <select name="r_status" id="status">
                <option value="Pass" <?php if ($row["r_status"] == "Pass") echo "selected"; ?>>Pass</option>
                <option value="Fail" <?php if ($row["r_status"] == "Fail") echo "selected"; ?>>Fail</option>
            </select>
            <br>

            <span>Result for Semester:</span>
            <input type="number" name="r_semester" id="semester" min="1" max="6" step="1" value="<?php echo $row["r_semester"] ?>"></input>
            <br>

            <span>Result Date Released:</span>
            <input type="date" name="r_date" id="resultdate" value="<?php echo $row["r_date"] ?>"></input>
            <br><br>

            <button id="submit" type="submit">Update Result</button>
        </form>
    </div>
</body>

</html>
