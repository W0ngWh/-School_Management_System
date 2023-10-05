<?php
include("conn.php");
session_start();

if (!isset($_SESSION['user_role']) && $_SESSION['user_role'] !== 'admin') {
    header('location: loginpage.php');
    exit();
}

$f_id = $_GET['id'];
$results = mysqli_query($con, "SELECT * FROM fees_t WHERE f_id = $f_id");
$row = mysqli_fetch_assoc($results);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Pay Fees</title>
    <link rel="stylesheet" type="text/css" href="fee-add.css">
</head>

<body>
    <div class="edit-form">
        <form name="edit-fees" id="edit-fees" action="fee-update.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="f_id" id="f_id" value="<?php echo $row["f_id"] ?>"></input>

            <span>Student ID:</span>
            <input type="text" name="s_id" id="s_id" value="<?php echo $row["s_id"] ?>" readonly></input>
            <br>

            <span>Total Fees:</span>
            <input type="text" name="f_total" id="f_total" value="<?php echo $row["f_total"] ?>" readonly></input>
            <br>

            <span>Paid:</span>
            <input type="text" name="f_paid" id="f_paid" value="<?php echo $row["f_paid"] ?>" readonly></input>
            <br>

            <span>Pending:</span>
            <input type="text" name="f_pending" id="f_pending" value="<?php echo $row["f_pending"] ?>" readonly></input>
            <br>

            <span>Pay:</span>
            <input type="number" name="f_pay" id="f_pay" value="0"></input>
            <br>

            <button type="submit" name="edit-fee" id="edit-fee">Pay</button>
        </form>
        <br>
        <a href="fee-list.php">Back to List</a>
    </div>
</body>

</html>