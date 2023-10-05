<?php
    include("conn.php");

    $sql="INSERT INTO bus_t (bus_id, bus_driver, bus_dt, bus_dl, bus_des)

    VALUES

    ('$_POST[bus_id]', '$_POST[driver]', '$_POST[dtime]', '$_POST[dlocation]','$_POST[destination]')";

    if(!mysqli_query($con,$sql)) {
        die('Error:'.mysqli_error($con));
    }
    else {
        echo'<script>
        window.location.href="create-bs.html";
        </script>';
    }
    
    mysqli_close($con);
?>
