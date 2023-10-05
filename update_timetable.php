<?php
include("conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject = $_POST['subject'];
    $sub_code = $_POST['sub_code'];
    $lecturer = $_POST['lecturer'];
    $sub_day = $_POST['sub_day'];
    $sub_stime = $_POST['sub_stime'];
    $sub_etime = $_POST['sub_etime'];
    $location = $_POST['location'];

    // Mapping of days to numeric values
    $daysToValues = [
        'Monday' => 1,
        'Tuesday' => 2,
        'Wednesday' => 3,
        'Thursday' => 4,
        'Friday' => 5,
    ];

    // Default value for unknown day
    $iDay = $daysToValues[$sub_day] ?? 0;

    $sql = "INSERT INTO timetable_t (tt_id, tt_subject, tt_lecturer, tt_location, tt_day, tt_stime, tt_etime, tt_arrange)
        VALUES ('$sub_code', '$subject', '$lecturer', '$location', '$sub_day', '$sub_stime', '$sub_etime', '$iDay')";

    if (!mysqli_query($con, $sql)) {
        die('Error: ' . mysqli_error($con));
    } else {
        echo '<script>
        alert("Data Recorded!");
        window.location.href="timetable.php";
        </script>';
    }
} else {
    echo "Invalid request method.";
}

mysqli_close($con);
?>
