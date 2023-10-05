<?php
    include("conn.php");
    if (isset($_GET['n_id'])) {
        $n_id = $_GET['n_id'];
        $query = "SELECT * FROM news_t WHERE n_id = $n_id";
        $results = mysqli_query($con, $query);
    }
    $n_id = $_GET['id'];
    $results = mysqli_query($con, "SELECT * FROM news_t WHERE n_id = $n_id");
    $row = mysqli_fetch_assoc($results);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Edit News</title>
        <link rel="stylesheet" type="text/css" href="news-edit.css">
    </head>
    <body>
    <div class="edit-form">
        <form name="edit-news" id="edit-news" action="news-update.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="n_id" id="n_id" value="<?php echo $row["n_id"]?>"></input>
            <span>News Image:</span>
            <br>
            <input type="file" name="n_image" id="n_image"></input>
            <br><br>

            <span>News Title:</span>
            <input type="text" name="n_title" id="n_title" value="<?php echo $row["n_title"]?>"></input>
            <br>

            <span>Description:</span>
            <textarea name="n_description" id="n_description"><?php echo $row["n_description"]?></textarea>
            <br>

            <span>Date: </span>
            <input type="date" name="n_date" id ="n_date" placeholder="Date" value="<?php echo $row["n_date"]?>"></input>
            <br><br>

            <span>Time: </span>
            <input type="time" name="n_time" id="n_time" placeholder="Time" value="<?php echo $row["n_time"]?>"></input>
            <br><br>

            <span>Location:</span>
            <input type="text" name="n_location" id="n_location" value="<?php echo $row["n_location"]?>"></input>
            <br>

            <button type="submit" name="update_news" id="update_news">Change</button>

        </form>
    </div>
    </body>
</html>