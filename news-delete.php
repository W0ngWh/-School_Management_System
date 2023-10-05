<?php
    include("conn.php");

    $n_id=$_GET['id'];
    $query="DELETE FROM news_t WHERE n_id=$n_id";

    if (mysqli_query($con, $query)) {
        echo "Succesfully Deleted News.";
    } else {
        echo "Error: " . mysqli_error($con);
    }
    mysqli_close($con);
    header("Location:news-list.php")
?>
