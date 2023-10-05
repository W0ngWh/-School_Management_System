<?php
include("conn.php");
session_start();

if (!isset($_SESSION['s_id'])) {
    header('location: loginpage.php');
    exit();
}

$isStudent = isset($_SESSION['s_id']);

if ($isStudent) {
    // Student session information
    $s_id = $_SESSION['s_id'];
    $s_name = $_SESSION['s_name'];
    $s_email = $_SESSION['s_email'];
    $s_image = $_SESSION['s_image'];
    $s_intake = $_SESSION['s_intake'];
    $s_programme = $_SESSION['s_programme'];
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Attendance</title>
    <link rel="stylesheet" href="Attendix.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        #attendance-table {
            display: none;
        }
    </style>
</head>

<body>
    <!--NavBar-->
    <div class="navbar">
        <p><a href="mainpg.php"><i class="fas fa-arrow-left"></i> Back</a></p>
        <div class="header">
            <h2>Attendance</h2>
        </div>
    </div>
    <!--NavBar-->
    <!--TakeAtt-->
    <div class="takeatt">
        <div class="intake">
            <p>Intake</p>
            <p>
                <?php echo $s_intake ?>
            </p>
            <hr>
        </div>
        <div class="signclass">
            <h4>Overall Intake Attendance</h4>
            <p>100%</p>
            <button onclick="toggleAttendance()">Sign Class Attendance</button>
        </div>
    </div>
    <!--TakeAtt-->

    <!--Attendance-->
    <div class="attendance">
        <div class="attend">
            <h4>Semester 1</h4>
            <hr>
        </div>
        <div class="module">
            <h3><u>Module Attend</u></h3>
            <div id="attendance-table">

            </div>
        </div>
    </div>
    <!--Attendance-->

    <!--Form-->
    <form class="form" id="attendance-form" style="display: none;">
        <button type="button" id="close-btn">X</button>
        <h2>Attendance Code</h2>
        <hr>
        <div class="code">
            <input type="number" name="code1" oninput="singleDigit(this)" min="0" max="9" required>
            <input type="number" name="code2" oninput="singleDigit(this)" min="0" max="9" required>
            <input type="number" name="code3" oninput="singleDigit(this)" min="0" max="9" required>
        </div>
        <button type="submit" class="codesend">Submit</button>
    </form>
    <!--Form-->

    <script>
        const addedCodes = new Set();

        function toggleAttendance() {
            var form = document.getElementById("attendance-form");
            if (form.style.display === "none") {
                form.style.display = "block";
            } else {
                form.style.display = "none";
                form.reset();
            }
        }

        function singleDigit(input) {
            if (input.value.length > 1) {
                input.value = input.value.slice(0, 1);
            }
        }

        function isCodeAlreadyAdded(code) {
            return addedCodes.has(code);
        }

        document.getElementById('attendance-form').addEventListener('submit', function (event) {
            event.preventDefault();
            const codeInput = document.querySelector(".code input");
            const code = codeInput.value.trim();

            // Check for duplicate code before fetching and appending the table
            if (isCodeAlreadyAdded(code)) {
                alert("Code already added.");
                return;
            }

            fetch('display_student_attendance.php', {
                method: 'POST',
                body: new URLSearchParams(new FormData(event.target))
            })
                .then(response => response.text())
                .then(data => {
                    if (data.includes("No attendance records found")) {
                        alert(`No attendance records found for the code`);
                    } else {
                        const tableDiv = document.createElement('div');
                        tableDiv.innerHTML = data;

                        document.getElementById('attendance-table').appendChild(tableDiv);
                        document.getElementById('attendance-table').style.display = 'block';
                        toggleAttendance();

                        addedCodes.add(code);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });

        document.getElementById('close-btn').addEventListener('click', function (event) {
            event.preventDefault();
            toggleAttendance();
        });
    </script>

</body>

</html>