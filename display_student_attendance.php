<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['code1']) && isset($_POST['code2']) && isset($_POST['code3'])) {
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'sdp_db';

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $code = $conn->real_escape_string($_POST['code1']) . $conn->real_escape_string($_POST['code2']) . $conn->real_escape_string($_POST['code3']);

    $sql = "SELECT id, class_code, start_time, end_time, date FROM student_attendance WHERE code = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<table style='text-align: center; width: 100%;'>";
        echo "<tr><th>Class Code</th><th>Start Time</th><th>End Time</th><th>Date</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["class_code"] . "</td>";
            echo "<td>" . $row["start_time"] . "</td>";
            echo "<td>" . $row["end_time"] . "</td>";
            echo "<td>" . $row["date"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='text-align: center'>No attendance records found for the code: $code</p>";
    }

    $stmt->close();
    $conn->close();
}
?>




