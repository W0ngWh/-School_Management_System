<?php
include("conn.php");
session_start();

$isLecturer = isset($_SESSION['l_id']);

$query = "SELECT c_name  FROM courses_t";
$result = mysqli_query($con, $query);
$courses = [];

while ($row = mysqli_fetch_assoc($result)) {
    $courses[] = $row['c_name'];
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>AttendiX</title>
    <link rel="stylesheet" href="LecturerAttendix.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <!--NavBar-->
    <div class="navbar">
        <?php if ($isLecturer) { ?>
            <p><a href="mainpg.php"><i class="fas fa-arrow-left"></i> Back</a></p>
        <?php } else { ?>
            <p><a href="AdminMainPage.php"><i class="fas fa-arrow-left"></i> Back</a></p>
        <?php } ?>
        <div class="header">
            <h2>AttendiX</h2>
        </div>
    </div>
    <!--NavBar-->

    <!--AttendiX-->
    <form class="attendix" id="attendance-form" method="post">
        <div class="attend">
            <h2>Mark New Attendance</h2>
            <hr>
        </div>
        <div class="coding">
            <div class="left">
                <div class="box">
                    <h3>Class Code</h3>
                    <select id="class_code" name="class_code" required>
                    <option value="">Select a Course</option>
                        <?php foreach ($courses as $courses): ?>
                            <option value="<?php echo $courses; ?>"><?php echo $courses; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="box">
                    <h3>Time</h3>
                    <label for="start_time">Start Time:</label>
                    <input type="time" id="start_time" name="start_time" required>
                    <label for="end_time">End Time:</label>
                    <input type="time" id="end_time" name="end_time" required>
                </div>
            </div>
            <div class="right">
                <div class="box">
                    <h3>Date</h3>
                    <input type="date" id="date" name="date" required>
                </div>
                <div class="box">
                    <h3>Mark All Student</h3>
                    <label>
                        <input type="radio" name="attendance_status" value="Absent" checked> Absent
                    </label>
                    <label>
                        <input type="radio" name="attendance_status" value="Present"> Present
                    </label>
                </div>
            </div>
        </div>
        <div class="mark">
            <button type="submit" name="submit" id="mark">Mark Attendance</button>
        </div>
    </form>
    <!--AttendiX-->

    <!--PHP-->
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

        $class_code = $_POST['class_code'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $date = $_POST['date'];
        $attendance_status = $_POST['attendance_status'];
        $code = generateRandomCode();

        $stmt_attendance_records = $con->prepare("INSERT INTO attendance_records (class_code, start_time, end_time, date, attendance_status, code) 
                                                        VALUES (?, ?, ?, ?, ?, ?)");
        $stmt_attendance_records->bind_param("sssssi", $class_code, $start_time, $end_time, $date, $attendance_status, $code);

        $stmt_student_attendance = $con->prepare("INSERT INTO student_attendance (class_code, start_time, end_time, date, code) 
                                                        VALUES (?, ?, ?, ?, ?)");
        $stmt_student_attendance->bind_param("ssssi", $class_code, $start_time, $end_time, $date, $code);

        if ($stmt_attendance_records->execute() && $stmt_student_attendance->execute()) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            echo "Error: " . mysqli_error($con);
        }

        $stmt_attendance->close();
        $stmt_student_attendance->close();
        $con->close();
    }

    function generateRandomCode()
    {
        return rand(100, 999);
    }
    ?>
    <!--PHP-->

    <!--History-->
    <div class="history">
        <div class="attend">
            <h2>Attendance History</h2>
            <hr>
        </div>
        <?php include 'display_attendance.php'; ?>
    </div>
    <!--History-->
</body>

</html>