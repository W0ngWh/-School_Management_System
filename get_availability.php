<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sdp_db";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $startHour = isset($_GET['start_hour']) ? (int)$_GET['start_hour'] : 0;
    $startMinute = isset($_GET['start_minute']) ? (int)$_GET['start_minute'] : 0;
    $endHour = isset($_GET['end_hour']) ? (int)$_GET['end_hour'] : 0;
    $endMinute = isset($_GET['end_minute']) ? (int)$_GET['end_minute'] : 0;    

    $sql = "SELECT * FROM classrooms";
    $result = $conn->query($sql);

    $availabilityData = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $startTimestamp = mktime($row['start_hour'], $row['start_minute'], 0, date('n'), date('j'), date('Y'));
            $endTimestamp = mktime($row['end_hour'], $row['end_minute'], 0, date('n'), date('j'), date('Y'));

            $selectedTimestamp = mktime($startHour, $startMinute, 0, date('n'), date('j'), date('Y'));

            $available = ($selectedTimestamp >= $startTimestamp && $selectedTimestamp <= $endTimestamp);
            $availabilityData[] = array(
                'name' => $row['name'],
                'available' => $available,
                'start_hour' => $row['start_hour'],
                'start_minute' => $row['start_minute'],
                'end_hour' => $row['end_hour'],
                'end_minute' => $row['end_minute']
            );
        }
    }

    $conn->close();

    header('Content-Type: application/json');
    echo json_encode($availabilityData);
?>





