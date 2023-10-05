<?php
include("conn.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Check user_t table for authentication
        $check = "SELECT * FROM user_t WHERE u_email='$email' AND u_password='$password'";
        $result = mysqli_query($con, $check);
        $row = mysqli_fetch_array($result);

        if ($row) {
            $_SESSION['u_id'] = $row['u_id'];
            if ($row['u_role'] == 'admin') {
                
                $_SESSION['user_role'] = 'admin';
                $_SESSION['u_email'] =  $row['u_email'];
                header('location: AdminMainPage.php');
                exit(); 

            } elseif ($row['u_role'] == 'student') {
                $student_query = "SELECT * FROM students_t WHERE s_email='$email'";
                $student_result = mysqli_query($con, $student_query);

                if (!$student_result) {
                    die("Error: " . mysqli_error($con)); // Display the MySQL error message
                }

                $student_row = mysqli_fetch_array($student_result);

                if ($student_row) {
                    $_SESSION['s_id'] = $student_row['s_id'];
                    $_SESSION['s_name'] = $student_row['s_name'];
                    $_SESSION['s_email'] = $email;
                    $_SESSION['s_image'] = $student_row['s_image'];
                    $_SESSION['s_intake'] = $student_row['s_intake'];
                    $_SESSION['s_programme'] = $student_row['s_programme'];

                    header('location: mainpg.php');
                    exit();

                } else {
                    echo '<script>alert("Student data not found! Please contact admin if this issue persist.");
                            window.location.href = "loginpage.php";
                        </script>';
                    exit();
                }
            } elseif ($row['u_role'] == 'lecturer') {
                $lecturer_query = "SELECT * FROM lecturer_t WHERE l_email='$email'";
                $lecturer_result = mysqli_query($con, $lecturer_query);

                if (!$lecturer_result) {
                    die("Error: " . mysqli_error($con)); // Display the MySQL error message
                }

                $lecturer_row = mysqli_fetch_array($lecturer_result);

                if ($lecturer_row) {
                    $_SESSION['l_id'] = $lecturer_row['l_id'];
                    $_SESSION['l_name'] = $lecturer_row['l_name'];
                    $_SESSION['l_email'] = $email;
                    $_SESSION['l_image'] = $lecturer_row['l_image'];

                    header('location: mainpg.php');
                    exit(); 

                } else {
                    echo '<script>alert("Lecturer data not found! Please contact admin if this issue persist.");
                            window.location.href = "loginpage.php";
                        </script>';
                    exit();
                }
            }
        } else {
            // Handle invalid login credentials
            echo '<script>alert("Invalid email or password, please try to log in again!");
                    window.location.href = "loginpage.php";
                </script>';
            exit(); 
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Pallas Login</title>
    <link rel="stylesheet" href="loginpage.css">
</head>

<body>

    <div class="logincontainer">
        <div class="position">
            <div class="logo">
                <img src="image/pallas.png">
            </div>
            <div class="spacing">
                <div class="aboutus">
                    <a href="about_us.html"><button>About Us</button></a>
                </div>
                <div class="contactus">
                    <a href="contactus.html"><button>Contact Us</button></a>
                </div>
            </div>
        </div>
        <div class="loginborder">
            <div class="loginbody">
                <form action="loginpage.php" method="post" class="login">
                    <div class="logininput">
                        <p>Email: </p>
                        <input name="email" placeholder="Email Address" type="email" class="box" required />
                    </div>
                    <div class="logininput">
                        <p>Password: </p>
                        <input name="password" placeholder="Password" type="password" class="box" required />
                    </div>
                    <div class="button">
                        <button name="submit" class="loginbutton">LOGIN</button>
                    </div>
                </form>
                <div class="footer">
                    <footer>© 2023 Pallas University. All rights reserved.</footer>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
