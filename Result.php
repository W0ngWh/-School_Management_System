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
    $s_intake = $_SESSION['s_intake'];
    $s_programme = $_SESSION['s_programme'];


    $query = "SELECT * FROM result_t WHERE r_s_id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "s", $s_id);
    mysqli_stmt_execute($stmt);
    $results = mysqli_stmt_get_result($stmt);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Result</title>
    <link rel="stylesheet" href="Result.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <!--NavBar-->
    <div class="navbar">
        <p><a href="mainpg.php"><i class="fas fa-arrow-left"></i> Back</a></p>
        <div class="header">
            <h2>Result</h2>
        </div>
    </div>
    <!--NavBar-->

    <!--Bar-->
    <div class="bar">
        <h4>Intake - Course</h4>
        <p>
            <?php echo $s_intake . " - " . $s_programme ?>
        </p>
        <hr>
        <div id="chart-container">
            <canvas id="bar-chart"></canvas>
        </div>
        <div class="below">
            <button onclick="toggleSurvey()">Survey<i class="fas fa-newspaper"></i></button>
            <button onclick="openPage()">Interim Transcript<i class="fas fa-file"></i></button>
        </div><br>

        <h3>Degree Classification</h3>
        <hr>
        <table class="table">
            <tr>
                <td>3.70 and above</td>
                <td>Distinction</td>
            </tr>
            <tr>
                <td>3.00 and above</td>
                <td>Merit</td>
            </tr>
            <tr>
                <td>2.00 and above</td>
                <td>Pass</td>
            </tr>
        </table>
    </div>
    <!--Bar-->

    <!--Result-->
    <?php
    // Fetch and display results for each semester
    for ($semester = 1; $semester <= 6; $semester++) {
        $semesterDataQuery = "SELECT * FROM result_t WHERE r_s_id = ? AND r_semester = ?";
        $stmt = mysqli_prepare($con, $semesterDataQuery);
        mysqli_stmt_bind_param($stmt, "ss", $s_id, $semester);
        mysqli_stmt_execute($stmt);
        $semesterResult = mysqli_stmt_get_result($stmt);
        $numRows = mysqli_num_rows($semesterResult);

        // Check if there are results for this semester
        if ($numRows > 0) {
            $semesterData = mysqli_fetch_assoc($semesterResult); // Fetch the first row
    
            ?>
            <div class="result">
                <div class="sem">
                    <h3>
                        <?php echo "Semester " . $semester; ?>
                    </h3>
                    <p>
                        <?php echo "Status: " . $semesterData['r_status']; ?>
                    </p>
                    <p>
                        <?php echo "CGPA: " . $semesterData['r_gpa']; ?>
                    </p>
                </div>
                <div class="dropdown">
                    <div class="dropdown-arrow">&#9660;</div>
                    <div class="dropdown-content">
                        <?php
                        // Loop through the course-specific data
                        do {
                            ?>
                            <hr>
                            <div class="grade">
                                <p>
                                    <?php echo "Grade: " . $semesterData['r_grade']; ?>
                                </p>
                            </div>
                            <h4>
                                <?php echo $semesterData['r_c_name']; ?>
                            </h4>
                            <p>
                                <?php echo "Result: " . $semesterData['r_grade']; ?>
                            </p>
                            <p>
                                <?php echo "Internal Release Date: " . $semesterData['r_date']; ?>
                            </p>
                            <?php
                        } while ($semesterData = mysqli_fetch_assoc($semesterResult)); // Fetch the rest of the rows
                        ?>
                        <hr>
                    </div>
                </div>
            </div>
            <?php
        } else {
            // If no results for this semester, display a message
            ?>
            <div class="result">
                <div class="sem">
                    <h3>
                        <?php echo "Semester " . $semester; ?>
                    </h3>
                    <p>No records available for this semester.</p>
                </div>
            </div>
            <?php
        }
    }
    ?>

    <!--Result-->

    <!--Marks Details-->
    <div class="marks">
        <h3>Marks and Grades</h3>
        <hr>
        <table class="table">
            <tbody>
                <tr>
                    <td>80 - 100</td>
                    <td>A+</td>
                    <td>4.00</td>
                    <td>Distinction</td>
                </tr>
                <tr>
                    <td>75-79</td>
                    <td>A</td>
                    <td>3.70</td>
                    <td>Distinction</td>
                </tr>
                <tr>
                    <td>70-74</td>
                    <td>B+</td>
                    <td>3.30</td>
                    <td>Credit</td>
                </tr>
                <tr>
                    <td>65-69</td>
                    <td>B</td>
                    <td>3.00</td>
                    <td>Credit</td>
                </tr>
                <tr>
                    <td>60-64</td>
                    <td>C+</td>
                    <td>2.70</td>
                    <td>Pass</td>
                </tr>
                <tr>
                    <td>55-59</td>
                    <td>C</td>
                    <td>2.30</td>
                    <td>Pass</td>
                </tr>
                <tr>
                    <td>50-54</td>
                    <td>C-</td>
                    <td>2.00</td>
                    <td>Pass</td>
                </tr>
                <tr>
                    <td>40-49</td>
                    <td>D</td>
                    <td>1.70</td>
                    <td>Fail (Marginal)</td>
                </tr>
                <tr>
                    <td>30-39</td>
                    <td>F+</td>
                    <td>1.30</td>
                    <td>Fail</td>
                </tr>
                <tr>
                    <td>20-29</td>
                    <td>F</td>
                    <td>1.00</td>
                    <td>Fail</td>
                </tr>
                <tr>
                    <td>1-19</td>
                    <td>F-</td>
                    <td>0.00</td>
                    <td>Fail</td>
                </tr>
                <tr>
                    <td></td>
                    <td>CT</td>
                    <td>2.00E</td>
                    <td>Credit Transfer</td>
                </tr>
            </tbody>
        </table>

        <div class="details">
            <p><b>R</b> = Awarding of module credit by passing module referral assessments.</p>
            <p><b>C</b> = Awarding of module credit through compensation at the discretion of the Examination Board,
                based on the student's overall academic performance. No referral assessment is required for module.</p>
            <p><b>K</b> = Module passed at the third attempt.</p>
            <p><b>+</b> = Module has been taken as a replacement for a failed module.</p>
            <p>Matapelajaran Umum (MPU) modules, Co-Curricular and Industrial Experience will not be included in the GPA
                and CGPA calculation</p>
            <p><b>* Result is subject to External Moderation</b></p>
        </div>
    </div>
    <!--Marks Details-->

    <!--Survey-->
    <form class="form" id="survey-form" style="display: none;">
        <button onclick="toggleSurvey()" class="close-btn">X</button>
        <h2>Survey</h2>
        <hr style="margin-bottom: 20px;">
        <div class="survey-border">
            <h1>Currently No Survey Available</h1>
            <div class="selected">
                <h3>No Module Selected!</h3>
                <p>Select a Module to submit the survey</p>
            </div>
        </div>
        <div class="configure">
            <h3>Configuration Section</h3>
            <hr>
            <div class="selection">
                <p>Intake</p>
                <h3>
                    <?php echo $s_intake ?>
                </h3>
                <hr>
                <div class="type">
                    <div class="sike">
                        <p>Survey Type</p>
                        <h4>Select a type of survey</h4>
                        <div class="dropdown">
                            <div class="survey-arrow">&#9660;</div>
                            <div class="survey-content">
                                <p>Programme Evaluation</p>
                                <hr style="width: 97%;">
                                <p>Module Survey</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--Survey-->

    <script>
        var canvas = document.getElementById("bar-chart");
        var data = {
            labels: ["A+", "A", "B+", "B", "C+", "C"],
            datasets: [
                {
                    label: "Result Summary Chart",
                    data: [2, 1, 2, 3, 4, 2],
                    backgroundColor: ["#FA447E", "#449CFA", "#E8E833", "#3FEC9B", "#BE2DFC", "#FC8F2D"],
                },
            ],
        };

        var barChart = new Chart(canvas, {
            type: "bar",
            data: data,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });

        document.addEventListener("click", function (event) {
            var dropdownArrows = document.querySelectorAll('.dropdown-arrow');
            for (var i = 0; i < dropdownArrows.length; i++) {
                var dropdownArrow = dropdownArrows[i];
                var dropdownContent = dropdownArrow.nextElementSibling;
                if (event.target !== dropdownArrow) {
                    dropdownContent.style.display = 'none';
                }
            }
        });

        var dropdownArrows = document.querySelectorAll('.dropdown-arrow');
        dropdownArrows.forEach(function (dropdownArrow) {
            dropdownArrow.addEventListener('click', function () {
                var dropdownContent = this.nextElementSibling;
                dropdownContent.style.display = (dropdownContent.style.display === 'block') ? 'none' : 'block';
            });
        });

        function toggleSurvey() {
            var form = document.getElementById("survey-form");
            form.style.display = (form.style.display === "none") ? "block" : "none";
        }

        document.addEventListener("click", function (event) {
            var dropdownContents = document.getElementsByClassName("survey-content");
            for (var i = 0; i < dropdownContents.length; i++) {
                var dropdownContent = dropdownContents[i];
                if (!event.target.matches('.survey-arrow') && !event.target.matches('.survey-content')) {
                    dropdownContent.style.display = 'none';
                }
            }
        });

        document.querySelector('.survey-arrow').addEventListener('click', function () {
            var dropdownContent = this.nextElementSibling;
            dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' : 'block';
        });

        function openPage() {
            window.open('InterimTranscript.html', '_blank');
        }
    </script>
</body>

</html>