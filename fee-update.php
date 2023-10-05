<?php
    include("conn.php");

    $f_id = $_POST['f_id'];
    $s_id = $_POST['s_id'];
    $f_total = $_POST['f_total'];
    $f_paid = $_POST['f_paid'];
    $f_pending = $_POST['f_pending'];
    $f_pay = $_POST['f_pay'];

    // Edit Fee Details
    if ($f_pay == 0) {
        $edit_sql = "UPDATE fees_t SET 
        f_total = '$f_total',
        f_paid = '$f_paid',
        f_pending = '$f_pending' 
        
        WHERE f_id='$f_id'";

        if (mysqli_query($con, $edit_sql)) {
            echo '<script>
            alert("Fees Updated!");
            window.location.href="fee-list.php";
            </script>';
        } else {
            echo "Update Error!" . mysqli_error($con);
        }
    } else {
        $update_paid = $f_paid + $f_pay;
        $update_pending = $f_total - $update_paid;

        $update_sql = "UPDATE fees_t SET
        f_total = '$f_total',
        f_paid = '$update_paid',
        f_pending = '$update_pending'
        
        WHERE f_id = '$f_id'";

        if (mysqli_query($con, $update_sql)) {
            echo '<script>
            alert("Successfully Paid!");
            window.location.href="fee-list.php";
            </script>';
        } else {
            echo "Update Error!" . mysqli_error($con);
        }
    }

    mysqli_close($con);
?>