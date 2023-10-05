<?php
include("conn.php");
session_start();

$isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';

$u_id = $_SESSION['u_id'];

$query = "SELECT u_role FROM user_t WHERE u_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $u_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $userRole = $row['u_role'];
} else {
    echo "User's role not found in the database.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="timetable.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Bus Schedule</title>
</head>

<body>
    <div class="navbar">
        <?php if ($isAdmin) { ?>
            <p><a href="AdminMainPage.php"><i class="fas fa-arrow-left"></i> Back</a></p>
        <?php } else { ?>
            <p><a href="mainpg.php"><i class="fas fa-arrow-left"></i> Back</a></p>
        <?php } ?>
        <div class="header">
            <h2>View Bus Schedule</h2>
        </div>

    </div>
    <br>
    <?php
    $query = "SELECT * FROM bus_t ORDER BY bus_id, bus_dt ASC";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        ?>
        <div class="container">
            <table width="90%" class="timetable">
                <tr>
                    <th>Bus ID</th>
                    <th>Bus Driver</th>
                    <th>Departure Time</th>
                    <th>Departure Location</th>
                    <th>Destination</th>
                </tr>

                <?php

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["bus_id"] . "</td>";
                    echo "<td>" . $row["bus_driver"] . "</td>";
                    echo "<td>" . $row["bus_dt"] . "</td>";
                    echo "<td>" . $row["bus_dl"] . "</td>";
                    echo "<td>" . $row["bus_des"] . "</td>";
                } ?>
            </table>
            <?php
    } else {
        echo "<p>There is no record... Please contact admin if this is a problem.</p>";
    }

    mysqli_close($con);
    ?>
    </div>
    <br>

    <?php if ($isAdmin) { ?>
        <div class="button-container">
            <button onclick="location.href = 'create-bs.html';" id="myButton">Add New Bus Schedule</button>
        </div>
    <?php } ?>
    <br><br><br>

</body>

</html>