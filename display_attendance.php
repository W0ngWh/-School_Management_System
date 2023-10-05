<?php
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'sdp_db';

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT id, class_code, start_time, end_time, date, attendance_status, code FROM attendance_records";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table style='text-align: center; width: 100%;'>";
        echo "<tr><th>Class Code</th><th>Start Time</th><th>End Time</th><th>Date</th><th>Students Status</th><th>Attendance Code</th><th>Actions</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["class_code"] . "</td>";
            echo "<td>" . $row["start_time"] . "</td>";
            echo "<td>" . $row["end_time"] . "</td>";
            echo "<td>" . $row["date"] . "</td>";
            echo "<td>" . $row["attendance_status"] . "</td>";
            echo "<td>" . $row["code"] . "</td>";
            echo '<td><a href="#" onclick="confirmDelete(' . $row["code"] . ')">Delete</a></td>';
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='text-align: center'>No attendance records found.</p>";
    }

    $conn->close();
?>

<script>
    function confirmDelete(code) {
    if (confirm("Are you sure you want to delete this attendance record?")) {
        window.location.href = 'delete_attendance.php?code=' + code;
    }
}
</script>



