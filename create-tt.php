<?php
include("conn.php");
session_start();

$isLecturer = isset($_SESSION['l_id']);
$isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';

$query = "SELECT c_id, c_name, c_code, c_lname FROM courses_t";
$result = mysqli_query($con, $query);
$courses = [];
while ($row = mysqli_fetch_assoc($result)) {
    $courses[] = $row;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission here
    $course_id = $_POST["course_id"]; // Get the selected course's ID
    $sub_day = $_POST["sub_day"];
    $sub_stime = $_POST["sub_stime"];
    $sub_etime = $_POST["sub_etime"];
    $location = $_POST["location"];

    $sql = "INSERT INTO timetable_t (course_id, tt_day, tt_stime, tt_etime, tt_location)
            VALUES ('$course_id', '$sub_day', '$sub_stime', '$sub_etime', '$location')";

    if (!mysqli_query($con, $sql)) {
        echo '<script>
            alert("Error: ' . mysqli_error($con) . '");
            window.location.href="timetable.php";
            </script>';
        exit;
    } else {
        echo '<script>
            alert("Data Recorded!");
            window.location.href="timetable.php";
            </script>';
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>New Timetable</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="create-tt.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="navbar">
        <?php if ($isLecturer) { ?>
        <p><a href="mainpg.php"><i class="fas fa-arrow-left"></i> Back</a></p>
        <?php } else {?>
            <p><a href="AdminMainPage.php"><i class="fas fa-arrow-left"></i> Back</a></p>
        <?php } ?>
        <div class="header">
            <h2>Timetable</h2>
        </div>
    </div>

    <div class="container">
        <form name="myForm" id="myForm" oninput="checkForm()" action="create-tt.php" method="post">
            <h2>Add Timetable</h2>
            <label for="course_id">Select a Course:</label>
            <select name="course_id" id="course_id">
                <option value="">Select a Course</option>
                <?php foreach ($courses as $course): ?>
                    <option value="<?php echo $course['c_id']; ?>">
                        <?php echo $course['c_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <br>
            <select name="sub_day" id="sub_day" onblur="dateArrange()" required>
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
            </select>
            <br>
            <span>Start Time: </span>
            <input type="time" name="sub_stime" id="sub_stime" placeholder="Starting Time" required>
            <br>
            <br>
            <span>End Time: </span>
            <input type="time" name="sub_etime" id="sub_etime" placeholder="Ending Time" required>
            <br>
            <br>
            <input type="text" name="location" id="location" placeholder="Location" required>
            <br>
            <button type="submit" id="submit" class="submit" name="signup_submit">Add Timetable</button>
            <br>
            <div class="tts">
                <a href="timetable.php" class="tt">View Timetable</a>
            </div>

            <div class="view">
                <a href="view_course.php" class="course">View Course</a>
            </div>
        </form>
    </div>

    <script>
        document.getElementById("course_id").addEventListener("change", function () {
            var selectedCourseId = document.getElementById("course_id").value;
            var selectedCourse = <?php echo json_encode($courses); ?>.find(course => course.c_id === selectedCourseId);

            if (selectedCourse) {
                document.getElementById("c_code").value = selectedCourse.c_code;
                document.getElementById("c_lname").value = selectedCourse.c_lname;
            } else {
                document.getElementById("c_code").value = "";
                document.getElementById("c_lname").value = "";
            }
        });
    </script>

</body>

<script>
    function showData() {
        var form = document.getElementById("myForm");

        if (form.checkValidity()) {
            alert("Data Recorded!");
        }
    }
</script>

</html>