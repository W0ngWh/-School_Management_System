<?php
include("conn.php");
session_start();

$u_id = $_SESSION['u_id'];

$id_query = "SELECT * FROM user_t WHERE u_id = ?";
$id_statement = mysqli_prepare($con, $id_query);

if ($id_statement) {
    mysqli_stmt_bind_param($id_statement, "s", $u_id);
    mysqli_stmt_execute($id_statement);
    $id_results = mysqli_stmt_get_result($id_statement);
    $row = mysqli_fetch_assoc($id_results);

    if ($row) {
        $s_id = $row["u_card_id"];

        $fee_query = "SELECT * FROM fees_t WHERE s_id = ?";
        $fee_statement = mysqli_prepare($con, $fee_query);

        if ($fee_statement) {
            mysqli_stmt_bind_param($fee_statement, "s", $s_id);
            mysqli_stmt_execute($fee_statement);
            $fee_results = mysqli_stmt_get_result($fee_statement);

            if ($fee_results) {
                $row = mysqli_fetch_assoc($fee_results);

                if ($row) {
                    $f_total = $row['f_total'];
                    $f_paid = $row['f_paid'];
                    $f_pending = $row['f_pending'];
                } else {
                    echo "No data found for s_id = $s_id";
                }
            } else {
                echo "Error in query: " . mysqli_error($con);
            }
        } else {
            echo "Error preparing fee query: " . mysqli_error($con);
        }
    } else {
        echo "No data found for u_id = $u_id";
    }

    mysqli_stmt_close($id_statement);
    mysqli_stmt_close($fee_statement);
} else {
    echo "Error preparing id query: " . mysqli_error($con);
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Course Fee</title>
    <link rel="stylesheet" href="Fee.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <!--NavBar-->
    <div class="navbar">
        <p><a href="mainpg.php"><i class="fas fa-arrow-left"></i> Back</a></p>
        <div class="header">
            <h2>Course Fee</h2>
        </div>
    </div>
    <!--NavBar-->

    <!--Details-->
    <div class="details">
        <h3>Details</h3>
        <div class="fees">
            <h4>Semester 1 PAYMENT</h4>
            <hr>
            <div class="total">
                <p><b>Due Date</b></p>
                <h4>Sunday, 1 Jan 2023</h4>
                <hr style="width: 90%;">
                <div class="sage">
                    <div class="sum1">
                        <p>Amount Payable</p>
                        <?php echo "RM " . $f_total ?>
                        <p>Outstanding</p>
                        <?php echo "RM " . $f_pending ?>
                    </div>
                    <div class="vertical-line"></div>
                    <div class="sum2">
                        <p>Total Collected</p>
                        <?php echo "RM " . $f_paid ?>
                        <p>Fine</p>
                        <p>N/A</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Details-->

    <!--Graph-->
    <div class="graph">
        <h3>Total Summary</h3>
        <div id="chart-container">
            <canvas id="bar-chart"></canvas>
        </div>
        <hr style="width: 90%;">
        <div class="total">
            <div class="sage">
                <div class="sum1">
                    <p>Fine</p>
                    <p>N/A</p>
                    <p>Paid</p>
                    <?php echo "RM " . $f_paid ?>
                </div>
                <div class="vertical-line"></div>
                <div class="sum2">
                    <p>Overdue</p>
                    <p>N/A</p>
                    <p>Outstanding</p>
                    <?php echo "RM " . $f_pending ?>
                </div>
            </div>
        </div>
    </div>
    <!--Graph-->

    <script>
        var canvas = document.getElementById("bar-chart");

        var data = {
            labels: ["Accommodation", "Shuttle Card", "Course Fee", "Others"],
            datasets: [
                {
                    label: "Summary",
                    data: [10, 20, 30, 40],
                    backgroundColor: ["darkred", "darkblue", "#8B8000", "purple"], 
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
    </script>
</body>
</html>