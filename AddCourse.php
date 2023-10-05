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
  <title>Add New Course</title>
</head>

<body>
  <div class="navbar">
    <?php if ($isLecturer) { ?>
      <p><a href="courses.php"><i class="fas fa-arrow-left"></i> Back</a></p>
    <?php } elseif ($isAdmin) {?>
      <p><a href="AdminMainPage.php"><i class="fas fa-arrow-left"></i> Back</a></p>
    <?php } ?>
    <div class="header">
      <h2>Add Course</h2>
    </div>
  </div>

  <div class="container">
    <div id="feedback-form">
      <h2 class="header">Add New Course</h2><br>
      <form action="Adding.php" method="post" enctype="multipart/form-data">
        <label for="subject">Course Name:</label><br>
        <input type="text" id="coursename" name="c_name" required="required"></input><br>
        <label for="subject">Course Code:</label>
        <input type="text" id="coursecode" name="c_code" required="required"></input><br>
        <label for="lecname">Lecturer Name:</label>
        <select id="lecname" name="c_lname" required="required">
          <option value="">Select a Lecturer</option>
          <?php foreach ($lecturers as $lecturer): ?>
            <option value="<?php echo $lecturer; ?>"><?php echo $lecturer; ?></option>
          <?php endforeach; ?>
        </select><br>
        <label for="subject">Assignments Name:</label>
        <input type="text" id="assignment" name="c_assignments" required="required"></input><br>
        <label for="subject">Exam Name:</label>
        <input type="text" id="exam" name="c_exams" required="required"></input><br>
        <label for="subject">Course Image:</label><br>
        <input type="file" class="courseimage" name="c_pic" required="required"></input><br>
        <div class="date">
          <br><label for="subject">Assignment Date:</label><br>
          <input type="date" id="adate" name="c_adate" placeholder="Assignment Date" required="required"></input><br>
          <label for="subject">Exam Date:</label><br>
          <input type="date" id="edate" name="c_edate" placeholder="Exam Date" required="required"></input><br>
          <label for="subject">Course Date:</label><br>
          <input type="date" id="cdate" name="c_cdate" placeholder="Course Date" required="required"></input><br>
        </div>
        <label for="subject">Course Intake:</label>
        <input type="text" id="cintake" name="c_intake" required="required"></input><br>
        <label for="subject">Course Programme:</label>
        <input type="text" id="cprogramme" name="c_programme" required="required"></input><br>    
        <label for="subject">Course Description:</label>
        <input type="text" id="cdescription" name="c_description" required="required"></input><br>  
        
        <button id="submit" type="submit">Add Course</button>
      </form>
    </div>
  </div>

</body>

</html>