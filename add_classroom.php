<?php
   include("conn.php");

    $classroomName = isset($_POST['name']) ? $_POST['name'] : '';
    $startHour = isset($_POST['start_hour']) ? (int)$_POST['start_hour'] : 0;
    $startMinute = isset($_POST['start_minute']) ? (int)$_POST['start_minute'] : 0;
    $endHour = isset($_POST['end_hour']) ? (int)$_POST['end_hour'] : 0;
    $endMinute = isset($_POST['end_minute']) ? (int)$_POST['end_minute'] : 0;

    if ($classroomName && $startHour !== 0 && $startMinute >= 0 && $startMinute <= 59 &&
        $endHour !== 0 && $endMinute >= 0 && $endMinute <= 59) {
        $sql = "INSERT INTO classrooms (name, start_hour, start_minute, end_hour, end_minute)
                VALUES ('$classroomName', $startHour, $startMinute, $endHour, $endMinute)";
        if ($con->query($sql) === TRUE) {
            http_response_code(200);
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_connect_error();
            http_response_code(500);
        }
    } else {
        http_response_code(400);
    }
    
    mysqli_close($con);
?>



