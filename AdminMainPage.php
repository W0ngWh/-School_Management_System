<?php
include("conn.php");
session_start();

if (!isset($_SESSION['user_role']) && $_SESSION['user_role'] !== 'admin') {
    header('location: loginpage.php');
    exit();
}

$u_id = $_SESSION['u_id'];
$u_email = $_SESSION['u_email'];

?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
    <script src="https://kit.fontawesome.com/ece3175d47.js" crossorigin="anonymous"></script>
    <!-- <link rel="stylesheet" href="AdminMainPage.css"> -->
    <link rel="stylesheet" href="style.css">
    <title>Admin Main Page</title>

    <script>
        /* Set the width of the side navigation to 250px */
        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
        }

        /* Set the width of the side navigation to 0 */
        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }

        function confirmLogout() {
            var result = confirm("Are you sure you want to log out?");
            if (result) {
                window.location.href = "logout.php";
            } else {
                return;
            }
        }
    </script>

</head>

<body>
    <div id="main">

        <nav class="navbar"> <!--nav bar codes-->
            <div class="navbar_left">
                <span onclick="openNav()" id="nav">=</span>
                <a href="AdminMainPage.php"><img src="image/pallas.png" alt="Logo"></a>
            </div>
            <div class="navbar_right">
                <ul>
                    <li>
                        <a href="timetable.php"><img src="image/time1.png">
                            <span>Timetable</span></a>
                    </li>
                    <li>
                        <a href="LecturerAttendix.php"><img src="image/check.png">
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

        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <div class="dropdown">
                <a class="dropdown-arrow"><i class="fas fa-user-circle" id="chalk"></i> Student</a>
                <div class="dropdown-content">
                    <a href="StudentAccount.php"><i class="fa fa-minus" id="chalk"> <i class="fas fa-book-reader"
                                id="chalk"></i></i> New Account</a>
                    <a href="SearchStudent.php"><i class="fa fa-minus" id="chalk"> <i class="fas fa-align-left"
                                id="chalk"></i></i> Details</a>
                </div>
            </div>

            <div class="dropdown">
                <a class="dropdown-arrow dropdown-arrow-2"><i class="far fa-user-circle" id="chalk"></i>
                    Lecturer</a>
                <div class="dropdown-content dropdown-content-2">
                    <a href="LecturerAccount.php"><i class="fa fa-minus" id="chalk"> <i class="fas fa-book-reader"
                                id="chalk"></i></i> New Account</a>
                    <a href="SearchLecturer.php"><i class="fa fa-minus" id="chalk"> <i class="fas fa-align-left"
                                id="chalk"></i></i> Details</a>
                </div>
            </div>

            <a href="CardBalanceAdmin.php"><i class="fas fa-donate"></i> Top-up Palcard</a>

            <div class="dropdown">
                <a class="dropdown-arrow dropdown-arrow-3"><i class="fas fa-chalkboard-teacher" id="chalk"></i>
                    Class</a>
                <div class="dropdown-content dropdown-content-3">
                    <a href="AddCourse.php"><i class="fa fa-minus" id="chalk"> <i class="fas fa-book-open"
                                id="chalk"></i></i> Add Course</a>
                    <a href="view_course.php"><i class="fa fa-minus" id="chalk"> <i class="far fa-clock"
                                id="chalk"></i></i>
                        View Course</a>
                    <a href="Classroom Admin.php"><i class="fa fa-minus" id="chalk"> <i class="fas fa-chalkboard"
                                id="chalk"></i></i> Add Classroom</a>
                    <a href="create-tt.php"><i class="fa fa-minus" id="chalk"> <i class="fas fa-clock"
                                id="chalk"></i></i>
                        Add Timetable</a>
                    <a href="timetable.php"><i class="fa fa-minus" id="chalk"> <i class="far fa-clock"
                                id="chalk"></i></i>
                        View Timetable</a>
                </div>
            </div>

            <a href="fee-add.html"><i class="fa-solid fa-file-invoice-dollar"></i> Issue Fee</a>

            <a href="bus.php"><i class="fa fa-bus"></i> Bus Schedule</a>

            <a href="feedback-list.php"><i class="fas fa-clipboard"></i> Review Helpdesk</a>
        </div>

        <div class="container">
            <div class="left-sidebar">
                <div class="student_details">
                    <div class="managepost">
                        <?php if ($u_id) { ?>
                            <h1>Welcome to Admin Dashboard!</h1>
                            <p>Admin Email:
                                <?php echo $u_email ?>
                            </p>
                            <p>Admin ID:
                                <?php echo $u_id ?>
                            </p>
                        <?php } ?>
                        <div class="logout-button">
                            <button onclick="confirmLogout()" id="logoutButton">Logout</button>
                        </div>

                    </div>
                </div>
            </div> <!--closing div for left-sidebar  -->

            <div class="middle">
                <div class="campusnews">
                    <div class="managepost">
                        <h1>Manage Campus News and Events</h1>

                        <div class="add">
                            <a href="news-add.html">Add News</a>
                        </div>
                        <div class="add">
                            <a href="news-list.php">Manage News</a>
                        </div>
                    </div>
                </div>

                <div class="campusnews">
                    <div class="managepost">
                        <h1>Manage Student Result</h1>

                        <div class="add">
                            <a href="result_add.php">Add Student Result</a>
                        </div>
                        <div class="add">
                            <a href="result_list.php">Manage Student Result</a>
                        </div>
                    </div>
                </div>
                
            </div>

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
        </div> <!--div close for container-->
    </div><!--div close for main-->
    <script src="AdminMainPage.js"></script>

</body>

</html>