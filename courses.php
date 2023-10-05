<?php
include("conn.php");
session_start();


if (!isset($_SESSION['u_id'])) {
  header('location: loginpage.php');
  exit();
}

$isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
$isStudent = isset($_SESSION['s_id']);
$isLecturer = isset($_SESSION['l_id']);

$result = mysqli_query($con, "SELECT * FROM courses_t");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <title>Courses</title>

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" type="text/css" href="courses.css">
  </link>
  <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
  </link>

</head>

<body>
  <div class="navbar">
    <?php if ($isAdmin) { ?>
      <p><a href="AdminMainPage.php"><i class="fas fa-arrow-left"></i> Back</a></p>
    <?php } else { ?>
      <p><a href="mainpg.php"><i class="fas fa-arrow-left"></i> Back</a></p>
    <?php } ?>
    <div class="header">
      <h2>Courses</h2>
    </div>
  </div>

  <main>
    <section class="py-5 text-center container">
      <div class="row py-lg-5">
        <div class="col-lg-6 col-md-8 mx-auto">
          <h1 class="fw-light">Enrolled Courses</h1>
          <?php if ($isStudent) { ?>
            <p class="lead text-muted">Here are all the courses you have enrolled in
              and have done previously or will be done in the future.</p>
            <p>
            <?php } else { ?>
            <p class="lead text-muted">Here are all the courses you are registered.
              Please contact admin if you have issues regarding the course.
            </p>
          <?php } ?>
          <p>
            <?php if ($isAdmin) { ?>
              <a href="AdminMainPage.php" class="btn btn-primary my-2">Back to Home</a>
            <?php } else { ?>
              <a href="mainpg.php" class="btn btn-primary my-2">Back to Home</a>
            <?php } ?>
            <?php if ($isLecturer || $isAdmin) { ?>
              <a href="view_course.php" class="btn btn-secondary my-2">Edit Course Details</a>
            <?php } ?>
          </p>
        </div>
      </div>
    </section>

    <?php
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_array($result)) {
        ?>

        <div class="album py-0 bg-light">
          <div class="container">
            <form method="post" action="courses.php?action=add&id=<?php echo $row["c_id"]; ?>">

              <div class="course-item">
                <div class="pbox">
                  <div class="card shadow-sm">
                    <!-- Modify the image link -->
                    <a href="courseInfo.php?data=<?php echo $row['c_id']; ?>">
                      <?php if (strpos($row["c_pic"], '.svg') !== false): ?>
                        <svg class="bd-placeholder-img card-img-top"
                          style="background-image: url('<?php echo $row["c_pic"]; ?>'); background-position: cover; background-position: center; background-repeat: no-repeat"
                          width="100%" height="250"></svg>
                      <?php else: ?>
                        <img class="bd-placeholder-img card-img-top" src="<?php echo $row["c_pic"]; ?>"
                          alt="<?php echo $row["c_name"]; ?>" style="width: 100%; height: 250px; object-fit: cover;" />
                      <?php endif; ?>
                    </a>


                    <div class="card-body">
                      <p class="card-text">
                        <?php

                        echo '<a href="courseInfo.php?data=' . $row['c_id'] . '">' . $row['c_name'] . '</a></td>';

                        ?>
                      </p>
                      <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                          <p class="card-text">
                            <?php
                            echo $row['c_lname'];
                            ?>
                          </p>
                        </div>
                        <small class="text-muted">
                          <?php
                          echo $row['c_code'];
                          ?>
                        </small>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <?php
      }
    }
    ?>

    <br>
    <br>
  </main>

  <br>
  <br>

  <div class="newbox">

    <footer class="text-muted py-5">
      <div class="container">
        <p class="float-end mb-1">
          <a href="#">Back to top</a>
        </p>
        <p class="mb-1">Pallas Univeristy&copy; </p>
        <p class="mb-0">Your Courses and Modules</p>
      </div>
    </footer>

  </div>

</body>

</html>