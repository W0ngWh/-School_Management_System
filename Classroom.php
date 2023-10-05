<?php 
session_start();

if (!isset($_SESSION['u_id'])) {
    header('location: loginpage.php');
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Classroom Finder</title>
    <link rel="stylesheet" href="Classroom.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <!-- NavBar -->
    <div class="navbar">
        <p><a href="mainpg.php"><i class="fas fa-arrow-left"></i> Back</a></p>
        <div class="header">
            <h2>Classroom Finder</h2>
        </div>
    </div>
    <!-- NavBar -->

    <form id="availability-form">
        <label for="search-start-hour">Start Hour:</label>
        <input type="number" id="search-start-hour" min="0" max="23">
        <label for="search-start-minute">Start Minute:</label>
        <input type="number" id="search-start-minute" min="0" max="59">

        <label for="search-end-hour">End Hour:</label>
        <input type="number" id="search-end-hour" min="0" max="23">
        <label for="search-end-minute">End Minute:</label>
        <input type="number" id="search-end-minute" min="0" max="59">

        <button type="button" onclick="searchAvailability()">Search Availability</button>
    </form>

    <div class="border">
        <div class="qwe">
            <h3>Classroom</h3>
        </div>
        <div id="availability"></div>
    </div> 

    <script src="Classroom.js"></script>
</body>

</html>

