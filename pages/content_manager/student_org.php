<?php
include 'include/alert.php';
session_start();
include '../../function/partnership_function.php';
include 'confirmation.php';

include("../../connection/dbconnection.php");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$page = isset($_GET['page']) && in_array($_GET['page'], ['about_org', 'list_org', 'event_activities_org', 'rules_org']) ? $_GET['page'] : 'about_org';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" href="../../assets/images/officiallogo (1).png" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>University of Kratie || Admin</title>

  <!-- CSS -->
  <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?v=2.8">
  <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">
</head>

<body class="bg-light">
  <!-- Include Sidebar -->
  <?php include 'include/sidebar.php'; ?>

  <main class="bg-light">
    <!-- Include Navbar -->
    <?php include 'include/navbar.php'; ?>

    <!-- Content -->
    <div class="p-4">
      <div class="row">
        <div class="card border-0 pb-3">
          <div class="card-body">
            <div class="doc-tabs-container mt-3">
              <ul class="doc-tabs d-flex list-unstyled">
                <li class="me-3">
                  <a class="doc-link <?= ($page == 'about_org') ? 'active' : '' ?>" href="?page=about_org">About Student Organizations</a>
                </li>
                <li class="me-3">
                  <a class="doc-link <?= ($page == 'list_org') ? 'active' : '' ?>" href="?page=list_org">List of Organizations</a>
                </li>
                <li class="me-3">
                  <a class="doc-link <?= ($page == 'event_activities_org') ? 'active' : '' ?>" href="?page=event_activities_org">Events and Activities</a>
                </li>
                <li class="me-3">
                  <a class="doc-link <?= ($page == 'rules_org') ? 'active' : '' ?>" href="?page=rules_org">Events and Activities</a>
                </li>

              </ul>
              <hr class="doc-tabs-divider">
            </div>
            <div class="content_org">
              <!-- Include dynamic page content -->
              <?php include $page . '.php'; ?>
            </div>
          </div>
        </div>
      </div>

      <?php include 'include/footer.php'; ?>
    </div>
  </main>

  <!-- JavaScript -->
  <script src="../../assets/bootstrap/js/jquery-3.7.1.js"></script>
  <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/bootstrap/js/script.js"></script>
  <script src="../../assets/bootstrap/js/carousel.js"></script>
  <script src="../../assets/bootstrap/js/drag_and_drop.js?v=2.1"></script>
  <script src="../../assets/bootstrap/js/activeLink.js?v=1.7"></script>
  <script src="../../assets/bootstrap/js/logs.js?v=1.4"></script>
  <script src="../../assets/bootstrap/js/site_settings.js?v=1.0"></script>

  <!-- JavaScript to Load Content Dynamically -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const links = document.querySelectorAll(".doc-link");

      links.forEach(link => {
        link.addEventListener("click", function() {
          // Remove active class from all links
          links.forEach(l => l.classList.remove("active"));

          // Add active class to clicked link
          this.classList.add("active");
        });
      });
    });
  </script>

</body>

</html>
