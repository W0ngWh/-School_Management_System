<?php
include("conn.php");

$n_id = $_POST['n_id'];
$n_description = mysqli_real_escape_string($con, $_POST['n_description']);
$targetDir = 'newsupload/';

// Get the file name and extension
$fileName = basename($_FILES['n_image']['name']);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

$allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
if (in_array($fileType, $allowedTypes)) {
    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES['n_image']['tmp_name'], $targetFilePath)) {
        $sql = "UPDATE news_t SET
        n_image = '$targetFilePath',
        n_title = '$_POST[n_title]',
        n_description = '$n_description',
        n_date = '$_POST[n_date]',
        n_time = '$_POST[n_time]',
        n_location = '$_POST[n_location]'
        
        WHERE n_id = $n_id";

        if (mysqli_query($con, $sql)) {
            echo '<script>
            alert("News Updated!");
            window.location.href="news.php";
            </script>';
        } else {
            echo "Update Error!" . mysqli_error($con);
        }
    } else {
        echo "Error uploading the file.";
    }
} else {
    echo "Invalid file type. Allowed types: jpg, jpeg, png, gif";
}

mysqli_close($con);
?>
