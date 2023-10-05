<?php
include("conn.php");
session_start();

if (!isset($_SESSION['l_id'])) {
    header('location: loginpage.php');
    exit(); // Make sure to exit to prevent further execution
}

// You can now access the student's information using the session variables
$lecturer_id = $_SESSION['l_id'];
$lecturer_name = $_SESSION['l_name'];
$lecturer_email = $_SESSION['l_email'];
$lecturer_image = $_SESSION['l_image'];

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
                <a href="lecmainpage.php"><img src="image/pallas.png" alt="Logo"></a>
            </div>

            <div class="navbar_right">
                <ul>
                    <li>
                        <a href="timetable.php"><img src="image/time.png">
                            <span>Timetable</span></a>
                    </li>
                    <li>
                        <a href="Attendix.php"><img src="image/check.png">
                            <span>AttendiX</span></a>
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
                        <h1>Welcome to Your Dashboard!</h1>
                        <p>Lecturer Name: <?php echo $lecturer_name ?></p>
                        <p>Lecturer ID: <?php echo $lecturer_id ?></p>
                    </div>
                </div>

                <div class="timetable">
                    <div class="managepost">
                        <div class="cardheader">
                            <h2>Timetable</h2>
                            <h3>Your classes to teach today...<h3>
                        </div>

                        <?php
                            //to get the current date time to display the details in timetable
                            $timestamp = time(); // get the current timestamp
                            $date = date('Y-m-d H:i:s', $timestamp); // format the timestamp as a string in the desired format
                            $day = date('l', $timestamp);

                            $sql = "SELECT
                            courses_t.c_name AS course_name,
                            courses_t.c_lname AS lecturer_name,
                            timetable_t.tt_day AS tt_day,
                            timetable_t.tt_location AS tt_location,
                            timetable_t.tt_stime AS tt_stime,
                            timetable_t.tt_etime AS tt_etime
                        FROM
                            timetable_t
                        JOIN
                            courses_t ON timetable_t.course_id = courses_t.c_id";

                            $result = mysqli_query($con, $sql);
                            if ((mysqli_num_rows($result) > 0) && ($row['tt_day'] = $day)) {
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
                                <!-- php to display list of user post starts -->
                                <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                     <tr>
                                        <td><?php echo $row["course_name"]; ?></td>
                                        <td><?php echo $row['lecturer_name']; ?></td>
                                        <td><?php echo $row['tt_day']; ?></td>
                                        <td><?php echo $row['tt_location']; ?></td>
                                        <td><?php echo $row['tt_stime']; ?></td>
                                        <td><?php echo $row['tt_etime']; ?></td>
                                    </tr>  
                                    <?php } ?>
                                </tbody>
                            </table>
                        <?php } else {
                            echo "There is no class today...";
                            echo '<img src="image/catplay.gif" alt="No Class" style="width: auto; height: 200px;">';
                        } ?>
                    </div>
                </div>
            </div> <!--closing div for left side bar-->

            <div class="right-sidebar">
                <div class="events">
                    here are events
                    <p>more
                    <p>heheh
                    <h3>breaking newsWOW</h3>
                </div>
            </div>
        </div>

        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <!-- add accourding to student data -->
            
            <a href=""><?php echo "<img src='$lecturer_image' alt='Profile Picture'>"; ?></a>
            <a href="CardBalance.php"><i class="fa-solid fa-wallet"></i> Palcard</a>
            <a href="#"><i class="fa-solid fa-envelope-open-text"></i> Survey and Feedback</a>
            <div class="dropdown">
                <a class="dropdown-arrow"><i class="fas fa-chalkboard" id="chalk"></i> Academic Management</a>
                <div class="dropdown-content">
                    <a href="Classroom.php"><i class="fa fa-minus" id="chalk"> <i class="fas fa-chalkboard-teacher" id="chalk"></i></i> Classroom</a>
                    <a href="courses.php"><i class="fa fa-minus" id="chalk"> <i class="fas fa-book-open" id="chalk"></i></i> Course</a>
                    <a href="Fee.html"><i class="fa fa-minus" id="chalk"> <i class="fa-solid fa-money-check-dollar" id="chalk"></i></i> Fee</a>
                    <a href=""><i class="fa fa-minus" id="chalk"> <i class="far fa-file-alt" id="chalks"></i></i> Helpdesk</a>
                </div>
            </div>

            <a href="Result.html"><i class="fa-solid fa-square-poll-vertical"></i> Result</a>

            <div class="dropdown">
                <a class="dropdown-arrow dropdown-arrow-2"><i class="fa fa-university" id="chalk"></i> Campus Management</a>
                <div class="dropdown-content dropdown-content-2">
                    <a href=""><i class="fa fa-minus" id="chalk"> <i class="fa fa-bus" id="chalk"></i></i> Bus Schedule</a>
                    <a href=""><i class="fa fa-minus" id="chalk"> <i class="fas fa-school" id="chalk"></i></i> Campus Life</a>
                    <a href=""><i class="fa fa-minus" id="chalk"> <i class="fa fa-newspaper-o" id="chalks"></i></i> News</a>
                </div>
            </div>

            <a href="setting.php"><i class="fa-solid fa-gear"></i> Setting</a>
        </div>

    </div> <!--div close for main-->

    <script src="mainpg.js"></script>

</body>

</html>