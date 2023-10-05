<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['code'])) {
        $host = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'sdp_db';
        $conn = new mysqli($host, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $code = $_GET['code'];

        // First, delete from the attendance_records table
        $stmt1 = $conn->prepare("DELETE FROM attendance_records WHERE code = ?");
        $stmt1->bind_param("s", $code);

        // Then, delete from the student_attendance table
        $stmt2 = $conn->prepare("DELETE FROM student_attendance WHERE code = ?");
        $stmt2->bind_param("s", $code);

        // Perform both deletions inside a transaction to ensure atomicity
        $conn->begin_transaction();
        try {
            $stmt1->execute();
            $stmt2->execute();
            $conn->commit(); // Commit the transaction if both deletions are successful
            header("Location: ".$_SERVER['HTTP_REFERER']);
            exit;
        } catch (Exception $e) {
            $conn->rollback(); // Rollback the transaction if any of the deletions fail
            echo "Error: " . $e->getMessage();
        }

        $stmt1->close();
        $stmt2->close();
        $conn->close();
    }
}
?>
