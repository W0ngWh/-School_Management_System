<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sdp_db";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM classrooms";
    $result = $conn->query($sql);

    $classroomsData = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $classroomsData[] = array(
                "id" => $row["id"],
                "name" => $row["name"],
                "start_hour" => $row["start_hour"],
                "start_minute" => $row["start_minute"],
                "end_hour" => $row["end_hour"],
                "end_minute" => $row["end_minute"]
            );
        }
    }

    header('Content-Type: application/json');
    echo json_encode($classroomsData);

    $conn->close();
?>
