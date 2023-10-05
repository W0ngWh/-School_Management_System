<?php
include("conn.php");
session_start();

if (!isset($_SESSION['u_id'])) {
    header('location: loginpage.php');
    exit();
}

$u_id = $_SESSION['u_id'];

$isStudent = isset($_SESSION['s_id']);
$isLecturer = isset($_SESSION['l_id']);
$isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';

if ($isStudent) {
    // Student session information
    $s_id = $_SESSION['s_id'];
    $s_name = $_SESSION['s_name'];
    $s_email = $_SESSION['s_email'];
    $s_image = $_SESSION['s_image'];
    $s_intake = $_SESSION['s_intake'];
    $s_programme = $_SESSION['s_programme'];
}

if ($isLecturer) {
    // Lecturer session information
    $l_id = $_SESSION['l_id'];
    $l_name = $_SESSION['l_name'];
    $l_email = $_SESSION['l_email'];
    $l_image = $_SESSION['l_image'];
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
    <script src="https://kit.fontawesome.com/ece3175d47.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <title>Pallas University</title>

    <script>
        /* Set the width of the side navigation to 250px */
        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
        }

        /* Set the width of the side navigation to 0 */
        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }

    </script>
</head>

<body>
    <div id="main">
        <nav class="navbar"> <!--nav bar codes-->
            <div class="navbar_left">
                <span onclick="openNav()" id="nav">=</span>
                <a href="mainpg.php"><img src="image/pallas.png" alt="Logo"></a>
            </div>
            <div class="navbar_right">
                <ul>
                    <li>
                        <a href="timetable.php"><img src="image/time1.png">
                            <span>Timetable</span></a>
                    </li>
                    <li>
                        <?php if ($isStudent) { ?>
                            <a href="Attendix.php"><img src="image/check.png">
                            <?php } elseif ($isLecturer || $isAdmin) { ?>
                                <a href="LecturerAttendix.php"><img src="image/check.png">
                                <?php } ?>
                                <span>AttendiX</span>
                            </a>
                    </li>
                    <li>
                        <a href="courses.php"><img src="image/mod.png">
                            <span>Modules</span></a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container">
            <div class="left-sidebar">
                <div class="student_details">
                    <div class="managepost">
                        <!-- Display student or lecturer details based on the session -->
                        <?php if ($isStudent) { ?>
                            <h1>Welcome to Your Dashboard!</h1>
                            <p>Student Name:
                                <?php echo $s_name ?>
                            </p>
                            <p>Student ID:
                                <?php echo $s_id ?>
                            </p>
                            <p>Student Intake Code:
                                <?php echo $s_intake ?>
                            </p>
                            <p>Student Programme:
                                <?php echo $s_programme ?>
                            </p>
                        <?php } elseif ($isLecturer) { ?>
                            <h1>Welcome to Your Dashboard!</h1>
                            <p>Lecturer Name:
                                <?php echo $l_name ?>
                            </p>
                            <p>Lecturer ID:
                                <?php echo $l_id ?>
                            </p>
                        <?php } ?>
                    </div>
                </div>

                <div class="timetable">
                    <div class="managepost">
                        <div class="cardheader">
                            <h2>Timetable</h2>
                        </div>

                        <?php
                        //to get the current date time to display the details in timetable
                        $timestamp = time(); // get the current timestamp
                        $date = date('Y-m-d', $timestamp); // format the timestamp as a date string
                        $day = date('l', $timestamp); // get the current day as a string (e.g., Monday)
                        
                        $sql = "SELECT courses_t.c_name AS course_name,
                courses_t.c_lname AS lecturer_name,
                timetable_t.tt_day AS tt_day,
                timetable_t.tt_location AS tt_location,
                timetable_t.tt_stime AS tt_stime,
                timetable_t.tt_etime AS tt_etime
                FROM timetable_t
                JOIN courses_t ON timetable_t.course_id = courses_t.c_id";

                        $result = mysqli_query($con, $sql);

                        // Initialize a flag to check if there are any classes for the current day
                        $classesFound = false;
                        ?>

                        <table>
                            <thead>
                                <tr>
                                    <td>Subject Name</td>
                                    <td>Lecturer</td>
                                    <td>Day</td>
                                    <td>Location</td>
                                    <td>Start Time</td>
                                    <td>End Time</td>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- PHP to display list of user posts starts -->
                                <?php while ($row = mysqli_fetch_assoc($result)) {
                                    // Check if the class is scheduled for the current day
                                    if ($row['tt_day'] == $day) {
                                        $classesFound = true; // Set the flag to true if there are classes
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $row["course_name"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['lecturer_name']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['tt_day']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['tt_location']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['tt_stime']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['tt_etime']; ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>

                        <?php
                        // Check if there are no classes for the current day
                        if (!$classesFound) {
                            ?>
                            <p>There are no classes today...</p>
                            <img src="image/catplay.gif" alt="No Class" style="width: auto; height: 200px;">
                        <?php } ?>
                    </div>
                </div>
                <!-- closing div for timetable  -->
            </div> <!--closing div for left side bar-->

            <div class="right-sidebar">
                <div class="events">
                    <h4><u>News of The Month</u></h4>
                    <?php
                    $news_sql = mysqli_query($con, "SELECT * FROM news_t");
                    while ($row = mysqli_fetch_array($news_sql)) {
                        echo $row['n_title'];
                        echo '<br><br>';
                    }
                    ?>
                    <a href="news.php">Learn More</a>
                </div>

                <div class="events">
                    <h4><u>PalCard</u></h4>
                    <?php
                    $card_sql = mysqli_query($con, "SELECT * FROM cards WHERE u_id=$u_id ");
                    if (mysqli_num_rows($card_sql) > 0) {
                        while ($row = mysqli_fetch_assoc($card_sql)) {
                            echo "RM" . $row['balance'];
                            echo '<br><br>';
                        }
                    } else {
                        echo "No record found.";
                        echo '<br><br>';
                    }
                    ?>
                    <a href="CardBalance.php">View Card Details</a>
                </div>

            </div>
        </div> <!-- closing div for container-->

        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

            <?php if ($isStudent) { ?>
                <a href="setting.php">
                    <?php echo "<img src='$s_image' alt='Profile Picture'>"; ?>
                </a>
            <?php } elseif ($isLecturer) { ?>
                <a href="setting.php">
                    <?php echo "<img src='$l_image' alt='Profile Picture'>"; ?>
                </a>
            <?php } ?>

            <div class="dropdown">
                <a class="dropdown-arrow"><i class="fa-solid fa-magnifying-glass"></i> Search</a>
                <div class="dropdown-content">
                    <a href="SearchStudent.php"><i class="fa fa-minus" id="chalk"> <i class="fas fa-align-left"
                                id="chalk"></i></i> Student Details</a>
                    <a href="SearchLecturer.php"><i class="fa fa-minus" id="chalk"> <i class="fas fa-align-left"
                                id="chalk"></i></i> Lecturer Details</a>
                </div>
            </div>

            <a href="CardBalance.php"><i class="fa-solid fa-wallet"></i> Palcard</a>

            <?php if ($isStudent) { ?>
                <a href="Result.php"><i class="fa-solid fa-square-poll-vertical"></i> Result</a>
            <?php } elseif ($isLecturer) { ?>
                <a href="result_add.php"><i class="fa-solid fa-square-poll-vertical"></i> Add Result</a>
            <?php } ?>

            <div class="dropdown">
                <a class="dropdown-arrow"><i class="fas fa-chalkboard" id="chalk"></i> Academic Management</a>
                <div class="dropdown-content">
                    <a href="Classroom.php"><i class="fa fa-minus" id="chalk"> <i class="fas fa-chalkboard-teacher"
                                id="chalk"></i></i> Classroom</a>
                    <a href="courses.php"><i class="fa fa-minus" id="chalk"> <i class="fas fa-book-open"
                                id="chalk"></i></i> Course</a>
                    <?php if ($isStudent) { ?>
                        <a href="fee.php"><i class="fa fa-minus" id="chalk"> <i class="fa-solid fa-money-check-dollar"
                                    id="chalk"></i></i> Fee</a>
                    <?php } ?>
                    <a href="feedback.php"><i class="fa fa-minus" id="chalk"> <i class="far fa-file-alt"
                                id="chalks"></i></i> Helpdesk</a>
                </div>
            </div>


            <div class="dropdown">
                <a class="dropdown-arrow dropdown-arrow-2"><i class="fa fa-university" id="chalk"></i> Campus
                    Management</a>
                <div class="dropdown-content dropdown-content-2">
                    <a href="bus.php"><i class="fa fa-minus" id="chalk"> <i class="fa fa-bus" id="chalk"></i></i> Bus
                        Schedule</a>
                    <a href="news.php"><i class="fa fa-minus" id="chalk"> <i class="fa fa-newspaper-o"
                                id="chalks"></i></i> News</a>
                </div>
            </div>

            <a href="setting.php"><i class="fa-solid fa-gear"></i> Setting</a>

        </div> <!--div close for main-->

        <script src="mainpg.js"></script>

</body>

</html>