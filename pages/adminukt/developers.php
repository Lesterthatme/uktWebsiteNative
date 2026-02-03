<?php

require '../../connection/dbconnection.php';
session_start();


$page = isset($_GET['page']) ? 'developers/' . $_GET['page'] : 'developers/2025';


// Fetch all site settings start
$settings = [];
$sql = "SELECT * FROM site_settings LIMIT 1";
$result = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_assoc($result)) {
  $settings = $row;

  if (!empty($settings)) {
    $title_admin = htmlspecialchars($settings['websitetitle_admin']);
    $title_cm = htmlspecialchars($settings['websitetitle_cm']);
  }
}
// Fetch all site settings end
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
 <link rel="icon" type="image/png" href="../../assets/uploads/site settings/favicon/<?php echo htmlspecialchars($settings['fav_icon']); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($settings['websitetitle_admin']); ?></title>
  <!-- start css  -->
  <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?=V1.0">
  <!-- end css -->
  <!-- Remix icon -->
  <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">
</head>
<body class="bg-light">
  <!-- include side bar start -->
  <?php include 'include/alert.php';?>
  <?php include 'include/sidebar.php';?>
  <!-- include side bar end -->
  <main class="bg-light">
    <!-- include navbar start -->
    <?php include 'include/navbar.php';?>
    <!-- include navbar end -->
    <!-- start: Content -->
    <div class="p-4">
      <div class="row">
        <div class="card border-0 pb-3">
          <div class="card-body">
            <div class="doc-tabs-container">
              <ul class="doc-tabs d-flex list-unstyled">
                <li class="me-3">
                  <a class="doc-link <?= ($page == 'developers/2025') ? 'active' : '' ?>" href="?page=2025">2025</a>
                </li>
                <li class="me-3">
                  <a class="doc-link <?= ($page == 'developers/2024') ? 'active' : '' ?>" href="?page=2024">2024</a>
                </li>
              </ul>
              <hr class="doc-tabs-divider">
            </div>
            <?php
            $page = isset($_GET['page']) ? 'developers/' . $_GET['page'] : 'developers/2025';
            ?>
            <h5 class="fw-semibold text-muted">Developers</h5>
            <p class="card-text text-muted small">Information Technology Students from Bulacan Agricultural State College.</p>
            <div class="developers">
            <?php include $page . '.php'; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end: Content -->
    <?php include 'include/footer.php'; ?>
    </div>
  </main>
  <!-- start js -->
  <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/bootstrap/js/jquery-3.7.1.js"></script>
  <script src="../../assets/bootstrap/js/script.js"></script>
  <script src="../../assets/bootstrap/js/carousel.js?=v1.3"></script>
  <script src="../../assets/bootstrap/js/drag_and_drop.js?=v1.0"></script>
  <script src="../../assets/bootstrap/js/activeLink.js?=v1.2"></script>
  <script src="../../assets/bootstrap/js/site_settings.js"></script>
  <!-- <script src="../../assets/bootstrap/js/doc-link.js"></script>
  end js -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
  const links = document.querySelectorAll(".doc-link");
  const urlParams = new URLSearchParams(window.location.search);
  const currentPage = urlParams.get("page") || "2025.php";
  links.forEach(link => {
    const linkPage = link.getAttribute("href").split("=")[1];

    if (linkPage === currentPage) {
      link.classList.add("active");
    } else {
      link.classList.remove("active");
    }
  });
});

  </script>
</body>
</html>