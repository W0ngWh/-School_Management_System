<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sdp_db";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $classroomId = isset($_POST['id']) ? (int)$_POST['id'] : 0; // Add this line to get classroom ID
    $classroomName = isset($_POST['name']) ? $_POST['name'] : '';
    $startHour = isset($_POST['start_hour']) ? (int)$_POST['start_hour'] : 0;
    $startMinute = isset($_POST['start_minute']) ? (int)$_POST['start_minute'] : 0;
    $endHour = isset($_POST['end_hour']) ? (int)$_POST['end_hour'] : 0;
    $endMinute = isset($_POST['end_minute']) ? (int)$_POST['end_minute'] : 0;

    if ($classroomId && $classroomName && $startHour !== 0 && $startMinute >= 0 && $startMinute <= 59 &&
        $endHour !== 0 && $endMinute >= 0 && $endMinute <= 59) {
        $sql = "UPDATE classrooms SET name='$classroomName', start_hour=$startHour, start_minute=$startMinute, end_hour=$endHour, end_minute=$endMinute WHERE id=$classroomId";
        if ($conn->query($sql) === TRUE) {
            http_response_code(200);
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            http_response_code(500);
        }
    } else {
        http_response_code(400);
    }

    $conn->close();
?>


