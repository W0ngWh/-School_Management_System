<?php
include("conn.php");
session_start();

if (!isset($_SESSION['u_id'])) {
    header('location: loginpage.php');
    exit();
}
$u_id = $_SESSION['u_id'];

$check = "SELECT * FROM user_t WHERE u_id='$u_id'";
$result = mysqli_query($con, $check);
$row = mysqli_fetch_array($result);

$results = mysqli_query($con, "SELECT * FROM news_t ORDER BY n_date ASC");
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="news.css" />
    <title>News</title>
</head>

<body>

    <div class="navbar">
        <?php if ($row['u_role'] == 'admin') { ?>
            <a href="AdminMainPage.php"><i class="fas fa-arrow-left"></i> Back to Home</a>
        <?php } else { ?>
            <a href="mainpg.php"><i class="fas fa-arrow-left"></i> Back to Home</a>
        <?php } ?>
        <div class="header">
            <p>Pallas University's News</p>
        </div>
        <?php if ($row['u_role'] == 'admin') { ?>
            <div class="navbar-edit">
                <a href="news-list.php">Edit News</a>
            </div>
        <?php } ?>

    </div>


    <?php
    while ($row = mysqli_fetch_array($results)) {
        ?>

        <div class="container">
            <div class="n-image" style="background-image: url('<?php echo $row["n_image"]; ?>')">
                <div class="n-text">
                    <br>
                    <div class="n-title">
                        <?php
                        echo $row["n_title"]
                            ?>
                    </div>
                    <br>
                    <?php
                    echo $row["n_description"]
                        ?>
                    <br><br>
                    <p>Date:
                        <?php echo $row["n_date"] ?>
                    </p>
                    <br>
                    <p>Time:
                        <?php echo $row["n_time"] ?>
                    </p>
                    <br>
                    <p>Location:
                        <?php echo $row["n_location"] ?>
                    </p>
                </div>
            </div>
        </div>

        <br>

        <?php
    }
    ?>

    <br><br><br>

</body>

</html>