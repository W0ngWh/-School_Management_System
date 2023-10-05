<?php
include("conn.php");
session_start();

$isLecturer = isset($_SESSION['l_id']);
$isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';

if (!$isLecturer && !$isAdmin) {
  // Redirect to the login page or display an error message
  header('location: loginpage.php');
  exit();
}

$students = [];
$courses = [];

$query = "SELECT s_id FROM students_t";
$result = mysqli_query($con, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $students[] = $row['s_id'];
}

$query_courses = "SELECT c_name FROM courses_t";
$result_courses = mysqli_query($con, $query_courses);

while ($row = mysqli_fetch_assoc($result_courses)) {
    $courses[] = $row['c_name'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve values from the form
    $studentID = $_POST["s_id"];
    $courseName = $_POST["c_name"];
    $grade = $_POST["r_grade"];
    $gpa = $_POST["r_gpa"];
    $cgpa = isset($_POST["r_cgpa"]) ? $_POST["r_cgpa"] : null;
    $status = $_POST["r_status"];
    $semester = $_POST["r_semester"];
    $resultDate = $_POST["r_date"];

    // Check if a result for the same course and semester already exists
    $checkQuery = "SELECT COUNT(*) FROM result_t WHERE r_s_id = ? AND r_c_name = ? AND r_semester = ?";
    $stmtCheck = mysqli_prepare($con, $checkQuery);
    mysqli_stmt_bind_param($stmtCheck, "ssi", $studentID, $courseName, $semester);
    mysqli_stmt_execute($stmtCheck);
    mysqli_stmt_bind_result($stmtCheck, $count);
    mysqli_stmt_fetch($stmtCheck);
    mysqli_stmt_close($stmtCheck);

    if ($count > 0) {
        // A result for the same course and semester already exists
        echo "<script>alert('The result for $courseName has been added for semester $semester already! Please select another semester or delete the previous record.');</script>";
    } else {
        // Prepare the SQL statement to insert data into the table
        $insertQuery = "INSERT INTO result_t (r_s_id, r_c_name, r_grade, r_gpa, r_cgpa, r_status, r_semester, r_date)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        // Create a prepared statement
        $stmt = mysqli_prepare($con, $insertQuery);

        if ($stmt) {
            // Bind the parameters
            mysqli_stmt_bind_param($stmt, "ssssssis", $studentID, $courseName, $grade, $gpa, $cgpa, $status, $semester, $resultDate);

            if (mysqli_stmt_execute($stmt)) {
                // Data insertion was successful
                echo "<script>alert('Result added successfully!');</script>";
            } else {
                echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
        }
    }

    // Close the database connection
    mysqli_close($con);
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="AddCourse.css">
    <title>Add Student Result</title>
</head>

<body>
    <div class="navbar">
        <?php if ($isAdmin) { ?>
            <p><a href="AdminMainPage.php"><i class="fas fa-arrow-left"></i> Back</a></p>
        <?php } else {?>
            <p><a href="mainpg.php"><i class="fas fa-arrow-left"></i> Back</a></p>
        <?php } ?>
        <div class="header">
            <h2>Add Student Result</h2>
        </div>
    </div>

    <div class="container">
        <div id="feedback-form">
            <h2 class="header">Add Student Result</h2><br>
            <form action="result_add.php" method="post">
                <label for="stuid">Student ID:</label><br>
                <select id="stuid" name="s_id" required="required">
                    <option value="">Select a Student ID</option>
                    <?php foreach ($students as $student): ?>
                        <option value="<?php echo $student; ?>"><?php echo $student; ?></option>
                    <?php endforeach; ?>
                </select><br>

                <label for="coursename">Course Name:</label><br>
                <select id="coursename" name="c_name" required="required">
                    <option value="">Select a Course</option>
                    <?php foreach ($courses as $course): ?>
                        <option value="<?php echo $course; ?>"><?php echo $course; ?></option>
                    <?php endforeach; ?>
                </select><br>

                <label for="grade">Grade:</label>
                <select id="grade" name="r_grade" required="required">
                    <option value="">Select a Grade</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                    <option value="F">F</option>
                </select><br>

                <label for="gpa">GPA:</label>
                <input type="number" id="gpa" name="r_gpa" min="0" max="4.00" step="0.01"
                    required="required"></input><br>
                <label for="cgpa">CGPA:</label>
                <input type="number" id="cgpa" name="r_cgpa" min="0" max="4.00" step="0.01"
                    required="required"></input><br>

                <label for="status">Result Status:</label><br>
                <select id="status" name="r_status" required="required">
                    <option value="Pass">Pass</option>
                    <option value="Fail">Fail</option>
                </select><br>

                <label for="semester">Result for Semester:</label>
                <input type="number" id="semester" name="r_semester" min="1" max="6" step="1" value="1"
                    required="required"></input><br>

                <div class="date">
                    <label for="date">Result Date Released:</label>
                    <input type="date" id="resultdate" name="r_date" required="required"></input><br>
                    <br>
                </div>
                <button id="submit" type="submit">Add Result</button>
            </form>
        </div>
    </div>

</body>

</html>