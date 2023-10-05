<?php 
session_start();
include("conn.php");

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $course_id = $_GET['id'];
    echo$course_id ;

    // Delete the course and its associated data from the database
    $delete_query = "DELETE FROM courses_t WHERE c_id = $course_id";
    echo $delete_query ;
    
    if (mysqli_query($con, $delete_query)) {
        echo "Course data deleted successfully.";
    } else {
        echo "Error deleting course and associated data: " . mysqli_error($con);
    }

    mysqli_close($con); // Close the database connection
    header('Location: view_course.php'); // Redirect the user to view_course.php page
}
?>
