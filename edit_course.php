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


if (isset($_GET['id'])) {
    $courseId = $_GET['id'];

    $query = "SELECT * FROM courses_t WHERE c_id = $courseId";
  // Add this line for debugging
  //echo "SQL Query: " . $query; 
    $result = mysqli_query($con, $query);

    if (!$result) {
        // Handle query execution error
        echo "Error: " . mysqli_error($con);
        exit();
      }

    $course = mysqli_fetch_assoc($result);
    
    if (!$course) {
      // Handle the case where the course is not found
      echo "Course not found!";
      exit();
    }
}

$query = "SELECT l_name FROM lecturer_t";
$result = mysqli_query($con, $query);
$lecturers = [];

while ($row = mysqli_fetch_assoc($result)) {
    $lecturers[] = $row['l_name'];
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="AddCourse.css">
    <title>Edit Course</title>
</head>

<body>
    <div class="navbar">
        <?php if ($isLecturer) { ?>
            <p><a href="courses.php"><i class="fas fa-arrow-left"></i> Back</a></p>
        <?php } elseif ($isAdmin) { ?>
            <p><a href="AdminMainPage.php"><i class="fas fa-arrow-left"></i> Back</a></p>
        <?php } ?>
        <div class="header">
            <h2>Edit Course</h2>
        </div>
    </div>

    <div class="container">
    <div id="feedback-form">
    <h2 class="header">Edit Course</h2><br>
    <form action="update_course.php" method="post" enctype="multipart/form-data">
       <input type="hidden" name="c_id" value="<?php echo $course['c_id']; ?>">
       <label for="subject">Course Name:</label><br>
        <input type="text" id="coursename" name="c_name" required="required" value="<?php echo $course['c_name']; ?>"></input><br>
        <label for="subject">Course Code:</label>
        <input type="text" id="coursecode" name="c_code" required="required" value="<?php echo $course['c_code']; ?>"></input><br>
        <label for="lecname">Lecturer Name:</label>
        <select id="lecname" name="c_lname" required="required">
          <option value="">Select a Lecturer</option>
          <?php foreach ($lecturers as $lecturer): ?>
            <option value="<?php echo $lecturer; ?>" <?php if ($course['c_lname'] == $lecturer) echo "selected"; ?>><?php echo $lecturer; ?></option>
          <?php endforeach; ?>
        </select><br>
        <label for="subject">Assignments Name:</label>
        <input type="text" id="assignment" name="c_assignments" required="required" value="<?php echo $course['c_assignments']; ?>"></input><br>
        <label for="subject">Exam Name:</label>
        <input type="text" id="exam" name="c_exams" required="required" value="<?php echo $course['c_exams']; ?>"></input><br>
        <label for="subject">Course Image:</label><br>
        <input type="file" class="courseimage" name="c_pic"></input><br>
        <div class="date">
          <br><label for="subject">Assignment Date:</label><br>
          <input type="date" id="adate" name="c_adate" placeholder="Assignment Date" required="required" value="<?php echo $course['c_adate']; ?>"></input><br>
          <label for="subject">Exam Date:</label><br>
          <input type="date" id="edate" name="c_edate" placeholder="Exam Date" required="required" value="<?php echo $course['c_edate']; ?>"></input><br>
          <label for="subject">Course Date:</label><br>
          <input type="date" id="cdate" name="c_cdate" placeholder="Course Date" required="required" value="<?php echo $course['c_cdate']; ?>"></input>
        </div>
        <button id="submit" type="submit">Update Course</button>
        </form>
    </div>
  </div>

</body>

</html>