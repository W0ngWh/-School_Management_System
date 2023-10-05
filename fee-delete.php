<?php
    include("conn.php");

    $f_id=$_GET['id'];
    $query="DELETE FROM fees_t WHERE f_id=$f_id";

    if (mysqli_query($con, $query)) {
        echo "Succesfully Deleted Student Fees Record.";
    } else {
        echo "Error: " . mysqli_error($con);
    }
    mysqli_close($con);
    header("Location:fee-list.php")
?>
