<?php
include("conn.php");
session_start();

if (!isset($_SESSION['u_id'])) {
    header('location: loginpage.php');
    exit();
}

$isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="setting.css">
    <title>Student Information</title>
</head>

<body>
    <!--NavBar-->
    <div class="navbar">
        <?php if ($isAdmin) { ?>
            <p><a href="AdminMainPage.php"><i class="fas fa-arrow-left"></i> Back</a></p>
        <?php } else { ?>
            <p><a href="mainpg.php"><i class="fas fa-arrow-left"></i> Back</a></p>
        <?php } ?>
        <div class="header">
            <h2>Search Student</h2>
        </div>
    </div>
    <!--NavBar-->

    <div class="searchcontainer">
        <form method="post">
            <label>Search Student Database</label>
            <h5>Search for student ID, names or email.</h5>
            <input type="text" name="search" style="width: auto">
            <input type="submit" name="submit" style="width: auto">
        </form>
    </div>
    <?php
    if (isset($_POST['submit'])) {
        $search = $_POST['search'];

        $sql = "SELECT * FROM students_t WHERE s_id LIKE ? OR s_name LIKE ? OR s_email LIKE ?";
        $stmt = mysqli_prepare($con, $sql);
        $searchParam = "%" . $search . "%"; //to search for partial matches
        mysqli_stmt_bind_param($stmt, "sss", $searchParam, $searchParam, $searchParam);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) { //to loop through all matching records
                    ?>

                    <div class="container">
                        <div class="student-info">
                            <h1>Student Information</h1>
                            <p><span class="highlighted">ID:</span>
                                <?php echo $row['s_id'] ?>
                            </p>
                            <p><span class="highlighted">Name:</span>
                                <?php echo $row['s_name']; ?>
                            </p>
                            <p><span class="highlighted">Email:</span>
                                <?php echo $row['s_email'] ?>
                            </p>
                            <p><span class="highlighted">Intake:</span>
                                <?php echo $row['s_intake'] ?>
                            </p>
                            <p><span class="highlighted">Programme:</span>
                                <?php echo $row['s_programme'] ?>
                            </p>

                            <?php if ($isAdmin) { ?>
                                <p><span class="highlighted">
                                        <?php
                                        echo "<td><a href=\"EditStudent.php?id="; //edit button to edit data in the database
                                        echo $row['s_id'];
                                        echo "\">Edit Account Details</a></td>";
                                        ?>
                                    </span></p>

                                <p><span class="highlighted">
                                        <?php
                                        echo "<td><a href=\"deleteStudentAccount.php?id=";
                                        echo $row['s_id'];
                                        echo "\" onClick=\"return  confirm('Delete Account Details"; //JavaScript to confirm the deletion  of the record
                                        echo $row['s_name'];
                                        echo " details?');\">Delete Account Details</a></td></tr>";
                                        ?>
                                    </span></p>
                            <?php } ?>

                        </div>
                        <div class="profile-pic">
                            <img src="<?php echo $row['s_image']; ?>" alt="Profile Picture" class="profile-image"
                                style="max-width: 65%">
                        </div>
                    </div>
                    <?php
                }
            } else { ?>
                <div class="searchcontainer">
                    <?php
                    echo "Data not Found.";
                    ?>
                </div>
                <?php
            }
        } else {
            // Handle the SQL error
            echo "Error: " . mysqli_error($con);
        }
    }
    ?>

</body>

</html>