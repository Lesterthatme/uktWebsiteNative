<?php
include 'include/alert.php';
session_start();
include 'confirmation.php';
include("../../connection/dbconnection.php");


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" href="../../assets/images/officiallogo (1).png" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>University of Kratie || Admin</title>
  <!-- start css  -->
  <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/bootstrap/css/style.css">
  <!-- end css -->
  <!-- Remix icon -->
  <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">

</head>

</head>

<body class="bg-light">

  <!-- include side bar start -->
  <?php include 'include/sidebar.php';

  ?>
  <!-- include side bar end -->

  <main class="bg-light">

    <!-- include navbar start -->
    <?php include 'include/navbar.php';

    ?>
    <!-- include navbar end -->

    <!-- start: Content -->
    <div class="p-4">
      <div class="row">
        <div class="card border-0 pb-3">
          <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
              <h5 class="card-title fs-6 mb-2 mb-md-0">Program Offering by Department</h5>
            </div>
            <p class="card-text text-muted small">Please click the Department and Managed the Program</p>

            <div class="container">
              <div class="row g-3">
                <?php
                $query = "SELECT department_id, dm_name, dm_about, dm_image FROM department";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <div class="col-12 col-sm-6 col-md-4">
                      <div class="card shadow-sm d-flex flex-column h-100"
                        style="transition: transform 0.3s ease, box-shadow 0.3s ease, border-radius 0.3s ease; cursor: pointer;"
                        onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 4px 10px rgba(0, 0, 0, 0.2)'; this.style.borderRadius='15px';"
                        onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none'; this.style.borderRadius='5px';">

                        <!-- Centered Image -->
                        <div class="d-flex justify-content-center align-items-center p-3" style="height: 200px; width: 100%; overflow: hidden;">
                          <img src="../../assets/uploads/department_image/<?php echo $row['dm_image']; ?>"
                            class="img-fluid rounded"
                            alt="Department Image"
                            style="max-width: 150px; max-height: 150px; object-fit: cover;">
                        </div>

                        <!-- Card Content -->
                        <div class="card-body d-flex flex-column text-center">
                          <h5 class="card-title"><?php echo $row['dm_name']; ?></h5>
                          <small class="card-text flex-grow-1">
                            <?php echo substr($row['dm_about'], 0, 120) . (strlen($row['dm_about']) > 120 ? '...' : ''); ?>
                          </small>

                          <!-- Inline Button -->
                          <div class="d-inline-flex justify-content-center mt-3">
                            <a href="manage_program?department_id=<?php echo $row['department_id']; ?>"
                              class="btn btn-dynamic btn-sm" style="max-width: 10rem;">Manage Programs</a>
                          </div>
                        </div>
                      </div>
                    </div>
                <?php
                  }
                } else {
                  echo "<p class='text-muted'>No departments found.</p>";
                }
                ?>
              </div>
            </div>
          </div>
        </div>
        <?php include 'include/footer.php'; ?>
      </div>
  </main>

  <script src="../../assets/bootstrap/js/Logs.js?v=1.1"></script>
  <script src="../../assets/bootstrap/js/site_settings.js"></script>
  <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/bootstrap/js/jquery-3.7.1.js"></script>
  <script src="../../assets/bootstrap/js/script.js"></script>
  <script src="../../assets/bootstrap/js/carousel2itemslide.js?=v1.7"></script>
  <script src="../../assets/bootstrap/js/drag_and_drop.js?=v1.0"></script>
  <script src="../../assets/bootstrap/js/activeLink.js?=v1.1"></script>

</body>

</html>