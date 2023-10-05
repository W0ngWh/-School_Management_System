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
    <title>Edit Fees</title>
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
            <input type="number" name="f_total" id="f_total" value="<?php echo $row["f_total"] ?>"></input>
            <br>

            <span>Paid:</span>
            <input type="number" name="f_paid" id="f_paid" value="<?php echo $row["f_paid"] ?>"
                onblur="calcPending()"></input>
            <br>

            <span>Pending:</span>
            <input type="number" name="f_pending" id="f_pending" readonly></input>
            <br>

            <input type="hidden" name="f_pay" id="f_pay" value="0"></input>

            <button type="submit" name="edit-fee" id="edit-fee">Change</button>
        </form>
        <br>
        <a href="fee-list.php">Back to List</a>
    </div>
</body>

<script>
    function calcPending() {
        var totalFee = document.getElementById("f_total").value;
        var paidAmount = document.getElementById("f_paid").value;
        var pendingAmount = (parseInt(totalFee) - parseInt(paidAmount));
        document.getElementById("f_pending").value = pendingAmount;
    }
</script>

</html>