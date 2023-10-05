<?php
include("conn.php");
session_start();

$u_id = $_SESSION['u_id'];
$isLecturer = isset($_SESSION['l_id']);
$isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';

$query = "SELECT u_role FROM user_t WHERE u_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $u_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $userRole = $row['u_role'];
} else {
    echo "User's role not found in the database.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="timetable.css">
    </link>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Timetable</title>
</head>

<body>
    <div class="navbar">
        <?php if (!$isAdmin) { ?>
            <p><a href="mainpg.php"><i class="fas fa-arrow-left"></i> Back</a></p>
        <?php } else { ?>
            <p><a href="AdminMainPage.php"><i class="fas fa-arrow-left"></i> Back</a></p>
        <?php } ?>
        <div class="header">
            <h2>View Timetable</h2>
        </div>

    </div>

    <?php
    $query = "SELECT
        courses_t.c_name AS course_name,
        courses_t.c_lname AS lecturer_name,
        timetable_t.tt_day AS tt_day,
        timetable_t.tt_location AS tt_location,
        timetable_t.tt_stime AS tt_stime,
        timetable_t.tt_etime AS tt_etime
    FROM
        timetable_t
    JOIN
        courses_t ON timetable_t.course_id = courses_t.c_id
    ORDER BY FIELD(tt_day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday')";

    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        ?>
        <div class="container">
            <table width="90%" class="timetable">
                <tr>
                    <th>Day</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Subject Name</th>
                    <th>Location</th>
                    <th>Lecturer</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["tt_day"] . "</td>";
                    echo "<td>" . $row["tt_stime"] . "</td>";
                    echo "<td>" . $row["tt_etime"] . "</td>";
                    echo "<td>" . $row["course_name"] . "</td>";
                    echo "<td>" . $row["tt_location"] . "</td>";
                    echo "<td>" . $row["lecturer_name"] . "</td>";
                }
                ?>
            </table>
        </div>
        <?php
    } else {
        echo "<p>There is no record... Please contact admin if this is a problem.</p>";
    }

    mysqli_close($con);
    ?>
    <div class="button-container">
        <?php if ($userRole === 'admin' || ($isLecturer)) { ?>
            <button onclick="location.href = 'create-tt.php';" id="myButton">Add New Timetable Schedule</button>
        <?php } ?>
    </div>
</body>

</html>