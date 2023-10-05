<?php
include("conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $s_id = $_POST['s_id'];
    $f_total = $_POST['f_total'];
    $f_paid = 0;
    $f_pending = $f_total;

    // Check if student exist in students_t database or not
    $check_sql = "SELECT * FROM students_t WHERE s_id = '$s_id'";
    $check_result = mysqli_query($con, $check_sql);

    // Check if fee record already exist in fees_t database
    $fcheck_sql = "SELECT * FROM fees_t WHERE s_id = '$s_id'";
    $fcheck_result = mysqli_query($con, $fcheck_sql); 

    // IF Student ID exist and DOES NOT have fee record
    if (mysqli_num_rows($check_result) > 0) {
        if (mysqli_num_rows($fcheck_result) == 0) {
            $sql = "INSERT INTO fees_t (s_id, f_total, f_paid, f_pending)
            VALUES ('$s_id', '$f_total', '$f_paid', '$f_pending')";

            if (mysqli_query($con, $sql)) {
                echo '<script>
                alert("Fees Added!");
                window.location.href="fee-list.php";
                </script>';
            } else {
                echo "Error has occured!" . mysqli_error($con);
            }
        }
        // IF Fee Record Exist
        else {
            echo '<script>
            alert("Student ID already has a fee record!")
            window.location.href="fee-add.html";
            </script>';
        }
    } 
    // IF Student ID DOES NOT exist
    else {
        echo '<script>
        alert("Student ID NOT found!")
        window.location.href="fee-add.html";
        </script>';
    }
}

mysqli_close($con);
?>