<?php
session_start();

if (!isset($_SESSION['user_role']) && $_SESSION['user_role'] !== 'admin') {
    header('location: loginpage.php');
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Classroom Finder Admin</title>
    <link rel="stylesheet" href="Classroom Admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <!-- NavBar -->
    <div class="navbar">
        <p><a href="AdminMainPage.php"><i class="fas fa-arrow-left"></i> Back</a></p>
        <div class="header">
            <h2>Classroom Finder (Admin)</h2>
        </div>
    </div>
    <!-- NavBar -->

    <!-- Add Classroom -->
    <div id="add-form">
        <h2>Add Classroom</h2>
        <form id="add-classroom-form">
            <label for="classroom-name">Classroom Name:</label>
            <input type="text" id="classroom-name">
            <br>
            <label for="start-hour">Start Time (Hour):</label>
            <input type="number" id="start-hour" min="0" max="23">
            <label for="start-minute">Start Time (Minute):</label>
            <input type="number" id="start-minute" min="0" max="59">
            <label for="end-hour">End Time (Hour):</label>
            <input type="number" id="end-hour" min="0" max="23">
            <label for="end-minute">End Time (Minute):</label>
            <input type="number" id="end-minute" min="0" max="59">
            <button type="button" onclick="addClassroom()" class="addbutton">Add Classroom</button>
        </form>
    </div>
    <!-- Add Classroom -->

    <div id="classrooms-list"></div>

    <!-- Edit Classroom -->
    <div id="edit-form" class="edit-form" style="display: none;">
        <button type="button" onclick="closeEditForm()" class="close-button">&times;</button>
        <h2>Edit Classroom</h2>
        <form id="edit-classroom-form">
            <input type="hidden" id="edit-classroom-id">
            <label for="edit-classroom-name">Classroom Name:</label>
            <input type="text" id="edit-classroom-name">
            <label for="edit-start-hour">Start Time (Hour):</label>
            <input type="number" id="edit-start-hour" min="0" max="23">
            <label for="edit-start-minute">Start Time (Minute):</label>
            <input type="number" id="edit-start-minute" min="0" max="59">
            <label for="edit-end-hour">End Time (Hour):</label>
            <input type="number" id="edit-end-hour" min="0" max="23">
            <label for="edit-end-minute">End Time (Minute):</label>
            <input type="number" id="edit-end-minute" min="0" max="59">
            <button type="button" onclick="updateClassroom()" class="addbutton">Update Classroom</button>
        </form>
    </div>
    <!-- Edit Classroom -->

    <script src="Classroom Admin.js"></script>
</body>

</html>

